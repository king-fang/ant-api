<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Permission\Perm;
use App\Models\Permission\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RolesController extends ApiController
{

    public function index()
    {
        $roles = Role::with('permsRoles')->where(function($query){
            if(request()->keyword)
            {
                $query->where('name','like','%'.request()->keyword.'%')->orWhere('desc', request()->keyword);
            }
        })->orderBy('created_at',request()->sortOrder == 'ascend' ? 'asc' : 'desc')->paginate(request()->pageSize,['*'],'page',request()->pageNo);
         return  $this->success($roles);
    }

    public function show($id)
    {
        if($id == 0)
        {
            $role = Role::where('number', '<>', 'admin')->get();
        }else{

            $role = Role::findorfail($id);
        }

        return  $this->success($role);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->all());
        if(request()->perms)
        {
            $role->giveToPerms($request->perm);
        }
        return $this->success('添加成功');
    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::findorfail($id);

        $role->update($request->all());
        if(request()->perms)
        {
            //刷新角色权限
            $role->syncPerms($request->perms);
        }
        return $this->success('更新成功');
    }

    public function destroy($id)
    {
        $role = Role::findorfail($id);

        $role->delete();

        return $this->success('删除成功');
    }
}
