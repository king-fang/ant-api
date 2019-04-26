<?php

namespace App\Models\Permission;
use App\Models\Permission\PermsRoles;
use App\Models\Permission\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Perm extends Model
{
    protected $fillable = ['name', 'path', 'component', 'redirect', 'hidden', 'title', 'roles', 'icon', 'hidden_header_content', 'pid'];


    public function getRolesAttribute($value)
    {
        return $this->attributes['roles'] = explode(',', $value);
    }

    public function setRolesAttribute($value)
    {
        if(is_array($value))
        {
            return $this->attributes['roles'] = implode(',', $value);
        }
        return $this->attributes['roles'] = $value;
    }


    public function setPathAttribute($value)
    {
        $pid = request()->pid;

        if($pid == 0)
        {
            if(Str::contains($value, '/'))
            {
                return  $this->attributes['path'] = $value;
            }
            return  $this->attributes['path'] = '/'.$value;

        }else{

            $pname = self::find($pid);

            if(Str::contains($value, $pname->path))
            {
                 $path = $value;
            }else{
                $path = $pname->path.'/'.$value;
            }
            if(request()->is_defualt == 1)
            {
                $pname->redirect = $path;
                $pname->save();
            }
            return  $this->attributes['path'] = $path;
        }

    }


    public function setNameAttribute($value){

        $pid = request()->pid;
        if($pid == 0)
        {
            $this->attributes['name'] = Str::studly($value);

        }else{
            $pname = self::find($pid);

            if(Str::contains($value, $pname->name))
            {
                $this->attributes['name'] = $pname->name.Str::studly(Str::after($value, $pname->name));;
            }else{
                $this->attributes['name'] = $pname->name.Str::studly($value);
            }

            $oname = self::where('name',$this->attributes['name'])->first();
            if($oname && $oname->id != request()->route('perm')){
                return response()->json(['code'=>422, 'message' => '名称已经存在'],422)->send();
            }
        }
        return  $this->attributes;
    }


    public function hasChirld()
    {
        return $this->hasMany(Perm::class, 'pid', 'id');
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'perms_roles', 'perms_id', 'roles_id');
    }

    public function permsRoles()
    {
        return $this->hasMany(PermsRoles::class, 'perms_id', 'id');
    }
}
