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
//测试react路由
Route::get('/react','ReactController@react')->name('react');

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

//定义用户重置密码路由
Route::group(['prefix'=>'password'],function(){
    Route::get('email','Auth\PasswordController@getEmail')->name('password.reset');
    Route::post('email','Auth\PasswordController@postEmail')->name('password.reset');
    Route::get('reset/{token}','Auth\PasswordController@getReset')->name('password.edit');
    Route::post('reset','Auth\PasswordController@postReset')->name('password.update');
});


//定义微博控制器为资源型控制地路由
Route::resource('statuses','StatusesController',['only'=>['store','destroy']]);

//定义查看粉丝 和 关注的人路由

Route::get('/users/{id}/followings','UsersController@followings')->name('users.followings');
Route::get('/users/{id}/followers','UsersController@followers')->name('users.followers');

//定义关注用户和取消用户路由
Route::post('/users/followers/{id}','FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{id}','FollowersController@destroy')->name('followers.destroy');

//测试验证码
Route::get('/captcha','TestsController@captchaTest');

Route::resource('test','TestController');

//测试二维码QRcode
Route::get('/qrcode','QrcodeController@qrcode');