<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Mail;


class PasswordController extends Controller
{
    /**
     * @var string 用于设置默认的重定向的路径
     */
    protected $redirectPath = '/';


    public function __construct()
    {
        $this->middleware('guest'); //默认只能让未登录用户访问
    }

    /**
     * 显示发送邮箱页面
     */
    public function getEmail(){
        return view('auth.password');
    }

    /**
     * 接收邮箱 生成一个token 并向该邮箱发送一条连接
     */
    public function postEmail(){
        $input = Input::all();
        $user = User::where('email','=',$input['email'])->first();
        //将token存入password_resets表
        $token = str_random(30);
        DB::table('password_resets')->insert(['email'=>$input['email'],'token'=>$token,'created_at'=>111]);

        Mail::send('emails.password',compact('token'),function($message){

        });
        session()->flash('success','已发送一条邮件至该邮箱');
        return view('auth.password');

    }

    /**
     * 显示更新密码页面
     */
    public function getReset($token){
        return view('auth.reset',compact('token'));
    }

    /**
     * 接收新的密码 并写入数据库
     */
    public function postReset(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|confirmed',

        ]);
        $input = Input::all();
        $user = User::where('email','=',$input['email'])->first();
        $user->password = bcrypt($input['password']);
        $user->save();
        session()->flash('success','密码更新成功');
        return redirect()->route('login');
    }

}
