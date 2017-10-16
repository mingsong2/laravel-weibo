<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\Models\Status;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * 表名字
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token',
    ];

    /**
     * 全球通用头像 Gravatar
     */
    public function gravatar($size = '100'){
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * 在eloquent模型中创建监听事件 来对增删改查进行监听 类似于tp中的before_insert  before_update...
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }

    /**
     * 显示当前用户关注人和自己的微博动态数据
     * @return mixed
     */
    public function feed(){
        $user_ids = Auth::user()->followings()->pluck('user_id')->toArray();
        array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)
                            ->with('user')
                            ->orderBy('created_at','desc');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * 查找自己的粉丝
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * 查找自己关注的人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * 关注某用户
     * @param $user_ids
     */
    public function follow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        //使用sync()方法在followers表上创建一个多对多的记录
        $this->followings()->sync($user_ids,false);
    }

    /**
     * 取消关注某用户
     * @param $user_ids
     */
    public function unfollow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        //使用detac()方法来删除followers上的记录
        $this->followings()->detach($user_ids);
    }

    /**
     * 判断当前登录用户A是否关注了用户B
     * @param $user_ids
     * @return mixed
     */
    public function isFollowing($user_ids)
    {
        return $this->followings->contains($user_ids);
    }

}
