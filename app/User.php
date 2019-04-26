<?php

namespace App;

use App\Models\Permission\Role;
use App\Models\Permission\RolesUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'realname', 'avatar', 'remember_token', 'last_ip', 'last_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $admin = 'fangxijun0101@meimeik.com';

    public function isAdmin(){

        return $this->email == $this->admin ? true : false;
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        if (app()->runningInConsole()) {
            return $this->attributes['password'] = $value;
        }
        return $this->attributes['password'] = \Hash::make(md5($value));
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users', 'user_id', 'roles_id');
    }


    public function rolesUser()
    {
        return $this->hasMany(RolesUser::class, 'user_id', 'id');
    }

    //添加角色权限
    public function giveToRoles(array $data)
    {
        $arr = [];

        foreach ($data as $value) {

            $arr[] = [
                'roles_id' => $value
            ];
        }
        return $this->rolesUser()->createMany($arr);
    }

    //同步
    public function syncRoles(array $data = [])
    {
        if(empty($data))
        {
            return $this->rolesUser()->delete();
        }else{
            $this->rolesUser()->delete();

            return $this->giveToRoles($data);
        }
    }
}
