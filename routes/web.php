<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('','StaticPagesController@home')->name('home');
Route::get('help','StaticPagesController@help')->name('help');
Route::get('about','StaticPagesController@about')->name('about');

//用户注册页面
Route::get('signup','UsersController@create')->name('signup');

//资源型控制器 符合RESTful架构
Route::resource('users','UsersController');

//用户登录页面
Route::get('login','SessionController@create')->name('login');
//创建新会话(登录)
Route::post('login','SessionController@store')->name('login');
//销毁会话(退出)
Route::delete('logout','SessionController@destroy')->name('logout');

//resource 方法来为用户添加好完整的 RESTful 动作，因此我们不需要再为用户添加编辑页面的路由。但你需要知道，一个符合 RESTful 架构的用户编辑路由应该是像下面这样：
//Route::get('/users/{id}/edit', 'UsersController@edit')->name('users.edit');
//定义激活功能路由
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');