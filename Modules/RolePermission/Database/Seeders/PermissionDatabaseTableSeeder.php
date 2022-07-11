<?php

namespace Modules\RolePermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;


class PermissionDatabaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach (Permission::$permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        foreach (Role::$roles as $name => $permission) {
            Role::findOrCreate($name)->givePermissionTo($permission);
        }

        // $this->call("OthersTableSeeder");
    }
}
