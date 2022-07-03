<?php

namespace Modules\RolePermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

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
        Permission::findOrCreate('teach');
        Permission::findOrCreate('manage_course');

        // $this->call("OthersTableSeeder");
    }
}
