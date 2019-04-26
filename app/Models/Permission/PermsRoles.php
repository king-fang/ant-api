<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Model;

class PermsRoles extends Model
{
    protected $table = 'perms_roles';

    protected $fillable = ['roles_id', 'perms_id'];
}
