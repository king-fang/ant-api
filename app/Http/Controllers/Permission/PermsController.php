<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermRequest;
use Illuminate\Http\Request;
use App\Models\Permission\Perm;

class PermsController extends ApiController
{

    public function index()
    {
        $perms = Perm::where(function($query){
            if(request()->keyword)
            {
                $query->where('title','like','%'.request()->keyword.'%')->orWhere('name','like','%'.request()->keyword.'%');
            }
            if(request()->hidden && request()->hidden <> '0')
            {
                $query->where('hidden',request()->hidden);
            }
        })->orderBy('created_at',request()->sortOrder == 'ascend' ? 'asc' : 'desc')->paginate(request()->pageSize,['*'],'page',request()->pageNo);
        $data['current_page'] = $perms->currentPage();
        $data['total'] = $perms->total();
        $data['data'] = getMenuTree($perms);
        return  $this->success($data);
    }

    public function show($id)
    {
        if($id == 0)
        {
            $perm = getSelectMenuTree(Perm::get());
        }else{
            $perm = Perm::findorfail($id);
        }
        return  $this->success($perm);
    }

    public function store(PermRequest $request)
    {
        $perm = Perm::create($request->all());

        return $this->success('添加成功');
    }

    public function update(PermRequest $request, $id)
    {
        $perm = Perm::findorfail($id);

        $perm->update($request->all());

        return $this->success('更新成功');
    }

    public function destroy($id)
    {
        $perm = Perm::findorfail($id);
        if($perm->hasChirld->count() > 0)
        {
            return $this->error('请先删除子级');
        }
        $perm->delete();

        return $this->success('删除成功');
    }
}
