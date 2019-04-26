<?php

namespace App\Http\Requests;

class RoleRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'name' => 'required|unique:roles,name',
                    'number' => 'required|unique:roles,number',
                ];
            }
            // UPDATE
            case 'PUT':
            {
                return [
                    'name' => 'required|unique:roles,name,'.request()->route('role'),
                    'number' => 'required|unique:roles,number,'.request()->route('role'),
                ];
            }
        }
    }

    public function messages()
    {
        return [
            'name.required' => '请填写角色名称',
            'name.unique'   => '角色名称重复',
            'number.unique'   => '角色名唯一码重复',
        ];
    }
}
