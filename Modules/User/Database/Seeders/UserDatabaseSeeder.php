<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach (User::$defaultUsers as $user){
            User::firstOrCreate(
                ['email' => $user['email']]
                ,[
                "email" => $user['email'],
                "name" => $user['name'],
                "password" => bcrypt($user['password'])
            ])->assignRole($user['role'])->markEmailAsVerified();
        }

        // $this->call("OthersTableSeeder");
    }
}
