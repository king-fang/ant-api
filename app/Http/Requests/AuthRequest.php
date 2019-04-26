<?php

namespace App\Http\Requests;

class AuthRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
        ];
    }
}
