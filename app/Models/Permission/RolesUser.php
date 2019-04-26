<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Model;

class RolesUser extends Model
{
    protected $table = "roles_users";

    protected $fillable = ['roles_id', 'user_id'];
}
