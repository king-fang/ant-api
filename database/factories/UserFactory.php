<?php

use App\Models\Permission\PermsRoles;
use App\Models\Permission\Role;
use App\Models\Permission\RolesUser;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'              => 'admin',
        'email'             => 'fangxijun0101@meimeik.com',
        'phone'             => '18507193432',
        'realname'          => '方细俊',
        'avatar'            => 'http://hulujia.oss-cn-hangzhou.aliyuncs.com/admin/b679c10d880b4d8cb162786f07736073.jpeg',
        'email_verified_at' => now(),
        'password'          => Hash::make('5f4dcc3b5aa765d61d8327deb882cf99'), // password
        'remember_token'    => Str::random(10),
    ];
});


$factory->define(Role::class, function (Faker $faker) {
    return [
        'name'   => '超级管理员',
        'number' => 'admin',
        'desc'   => '所有权限',
    ];
});


$factory->define(RolesUser::class, function (Faker $faker) {
    return [
        'user_id'  => 1,
        'roles_id' => 1,
    ];
});


