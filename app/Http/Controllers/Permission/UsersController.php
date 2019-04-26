<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;

class UsersController extends ApiController
{

    public function index()
    {
        $users = User::with('roles')->where(function($query){
            if(request()->keyword)
            {
                $query->where('realname','like','%'.request()->keyword.'%')->orWhere('phone','like','%'.request()->keyword.'%')->orWhere('name', request()->keyword);
            }
        })->orderBy('created_at',request()->sortOrder == 'ascend' ? 'asc' : 'desc')->paginate(request()->pageSize,['*'],'page',request()->pageNo);
        return  $this->success($users);
    }

    public function show($id)
    {
        $user = User::findorfail($id);

        return  $this->success($user);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->only(['name', 'email', 'password', 'phone', 'realname', 'avatar']) + ['remember_token' => str_random()]);

        if($request->roles)
        {
            $user->giveToRoles($request->roles);
        }
        return $this->success('添加成功');
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findorfail($id);

        $user->update($request->only(['name', 'email', 'phone', 'realname', 'avatar']) + ['remember_token' => str_random()]);

        if($request->roles)
        {
            $user->syncRoles($request->roles);
        }
        return $this->success('更新成功');
    }

    public function destroy($id)
    {
        $user = User::findorfail($id);

        if($user->isAdmin())
        {
            return $this->error('超级管理员不能删除');
        }

        $user->delete();

        return $this->success('删除成功');
    }
}
