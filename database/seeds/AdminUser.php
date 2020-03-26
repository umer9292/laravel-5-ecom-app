<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Profile;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'customer',
            'description' => 'customer role'
        ]);
        $role = Role::create([
            'name' => 'admin',
            'description' => 'admin role'
        ]);

        $user = User::create([
            'email' => 'umer@gamil.com',
            'password' => bcrypt('secret'),
            'role_id' => $role->id,
            'status' => 1
        ]);

    }
}
