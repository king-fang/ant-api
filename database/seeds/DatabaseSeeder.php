<?php

use App\Models\Permission\PermsRoles;
use App\Models\Permission\Role;
use App\Models\Permission\RolesUser;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //角色
        factory(Role::class)->create();

        //管理员
        factory(User::class)->create();

        //角色管理员
        factory(RolesUser::class)->create();

        //权限
        DB::table('perms')->insert([
            [
                'path'       => '/permission',
                'name'       => 'Permission',
                'redirect'   => '/permission/users',
                'title'      => '权限管理',
                'component'  => 'RouteView',
                'icon'       => 'setting',
                'hidden'     =>  1,
                'pid'        => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'path'       => '/permission/users',
                'name'       => 'PermissionUsers',
                'redirect'   => '',
                'title'      => '管理员',
                'component'  => 'PermissionUsers',
                'icon'       => '',
                'hidden'     =>  1,
                'pid'        => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'path'       => '/permission/roles',
                'name'       => 'PermissionRoles',
                'redirect'   => '',
                'title'      => '角色列表',
                'component'  => 'PermissionRoles',
                'icon'       => '',
                'hidden'     =>  1,
                'pid'        => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'path'       => '/permission/perms',
                'name'       => 'PermissionPerms',
                'redirect'   => '',
                'title'      => '权限列表',
                'component'  => 'PermissionPerms',
                'icon'       => '',
                'hidden'     =>  1,
                'pid'        => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('perms_roles')->insert([
            [
                'roles_id' => 1,
                'perms_id' => 1,
            ],
            [
                'roles_id' => 1,
                'perms_id' => 2,
            ],
            [
                'roles_id' => 1,
                'perms_id' => 3,
            ],
            [
                'roles_id' => 1,
                'perms_id' => 4,
            ]
        ]);
    }
}
