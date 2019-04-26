<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'name'     => 'required|unique:users|string|max:50',
                    'realname' => 'required',
                    'phone' => 'required',
                    'email'    => 'required|unique:users',
                    'password' => 'required|between:6,20|confirmed'
                ];
            }
            // UPDATE
            case 'PUT':
            {
                return [
                    'name' => 'required|string|max:50|unique:users,name,'.request()->route('user'),
                    'email' => 'required|unique:users,email,'.request()->route('user'),
                    'realname' => 'required',
                    'phone' => 'required',
                ];
            }
        }
    }

    public function messages()
    {
        return [
            'name.required'      => '用户名不能为空',
            'name.unique'        => '用户名已经存在',
            'name.max'           => '用户名最大50个字符',
            'password.required'  => '密码不能为空',
            'password.between'   => '密码在6到20位之间',
            'password.confirmed' => '确认密码错误',
        ];
    }
}
