<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 当前登录用户只能编辑自己的信息
     * @param $currentUser 当前登录的用户实例
     * @param $user 当前要更新的用户实例
     */
    public function update(User $currentUser,User $user){
        return $currentUser->id === $user->id;
    }
    /**
     * 只有当前用户为管理员时才能删除用户  并且不能删除自己
     * @param $currentUser 当前登录的用户实例
     * @param $user 当前要删除的用户实例
     */
    public function destroy(User $currentUser, User $user){
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
