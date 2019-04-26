<?php

namespace App\Models\Permission;

use App\Models\Permission\PermsRoles;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'desc' ,'number'];


    public function permsRoles()
    {
        return $this->hasMany(PermsRoles::class, 'roles_id', 'id');
    }

    //添加角色权限
    public function giveToPerms(array $data)
    {
        $arr = [];

        foreach (array_unique($data) as $value) {
            $arr[] = [
                'perms_id' => $value
            ];
        }
        return $this->permsRoles()->createMany($arr);
    }

    //同步
    public function syncPerms(array $data = [])
    {
        if(empty($data))
        {
            return $this->permsRoles()->delete();
        }else{
            $this->permsRoles()->delete();

            return $this->giveToPerms($data);
        }
    }
}
