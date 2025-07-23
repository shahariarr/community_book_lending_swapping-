<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=Role::create(['name' => 'User', 'guard_name' => 'web']);

        $user->givePermissionTo([
            'dashboard',
            'users.profile',
            

        ]);
    }
}

