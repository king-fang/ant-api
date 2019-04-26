<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 葫芦加+
|--------------------------------------------------------------------------
|
| 利用空余时间想做一些有意义的事情，证明自己存在过！
| 虽然本人是一名菜鸟，但还是想留下些什么！！！

| 于是诞生了葫芦家+
| so 一个专注包包，服装，饰品的2c 商城诞生了
|
| just do it!
*/
//跨域允许
header('Access-Control-Allow-Origin:*');  //生产环境设置允许的域名即可
header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE');
header('Access-Control-Allow-Headers:Content-Type, Authorization, Accept, x-requested-with');
header('Access-Control-Allow-Credentials:true');

//登陆
Route::post('login', 'AuthsController@token');

//用户信息
Route::post('userinfo', 'AuthsController@userinfo')->middleware("auth:api");

//菜单
Route::post('menus', 'AuthsController@menus')->middleware("auth:api");

//退出登陆
Route::post('logout', 'AuthsController@logout')->middleware("auth:api");

//管理员
Route::resource('users', 'Permission\UsersController')->middleware("auth:api");

//角色
Route::resource('roles', 'Permission\RolesController')->middleware("auth:api");

//权限
Route::resource('perms', 'Permission\PermsController')->middleware("auth:api");
