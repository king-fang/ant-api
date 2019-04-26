<?php

namespace App\Http\Requests;

class PermRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                $component = ['component' => 'required'];
                if(request()->pid)
                {
                    $component = ['component' => 'required|unique:perms,component'];
                }
                return [
                    'name'  => 'required|unique:perms,name',
                    'path'  => 'required',
                    'title' => 'required',
                ] +  $component;
            }

            // UPDATE
            case 'PUT':
            {
                $component = ['component' => 'required'];

                if(request()->pid)
                {
                    $component = ['component' => 'required|unique:perms,component,'.request()->route('perm')];
                }

                return [
                    'name'  => 'required|unique:perms,name,'.request()->route('perm'),
                    'path'  => 'required',
                    'title' => 'required',
                ] + $component;
            }
        }
    }

    public function messages()
    {
        return [
            'component.unique' => '组件别名已经存在'
        ];
    }
}
