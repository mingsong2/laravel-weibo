<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use App\Policies\UserPolicy;
use App\Models\User;
use Mail;
use Auth;
class UsersController extends Controller
{
    /**
     * 在构造方法里面利用"中间件"做身份验证 用来过滤未登录用户的edit update动作
     */
    public function __construct()
    {
        $this->middleware('auth',[
            'only' => ['edit','update','destory','followers','followings']
        ]);
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::paginate(5);
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证表单
        $this->validate($request,[
            'name' => 'required|max:50',
            'email'=> 'required|email|unique:users|max:255',
            'password'=>'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=>bcrypt($request->password),
        ]);
        //Auth::login($user);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);
    }

    /**
     * @param $user 当前用户登录信息
     */
    protected function sendEmailConfirmationTo($user){
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'frank@126.com';
        $name = 'frank';
        $to = $user->email;
        $subject = "感谢注册,请确认您的邮箱";

        Mail::send($view,$data,function($message) use ($from,$to,$name,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $statuses = $user->statuses()
                            ->orderBy('created_at','desc')
                            ->paginate(4);

        return view('users.show',compact('user','statuses'));  //compact('user')将用户数据与视图进行绑定在视图层可以直接用$user来访问用户实例
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);
        //对当前用户进行授权
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //首先进行表单验证
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'confirmed'
        ]);
        //根据id查找出用户信息
        $user = User::findOrFail($id);
        //对当前用户进行授权
        $this->authorize('update',$user);
        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success','个人资料更新成功!');

        return redirect()->route('users.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户!');
        return back();
    }

    public function confirmEmail($token){
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success','恭喜你,激活成功!');
        return redirect()->route('users.show',[$user]);
    }

    /**
     * 找出某用户的所有粉丝
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function followers($id){
        $user = User::findOrFail($id);
        $users = $user->followers()->paginate(20);
        $title="粉丝";
        return view('users.show_follow',compact('users','title'));
    }

    public function followings($id){
        $user = User::findOrFail($id);
        $users = $user->followings()->paginate(20);
        $title = "关注的人";
        return view('users.show_follow',compact('users','title'));
    }
}
