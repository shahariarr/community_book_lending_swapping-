<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions([
            'create-user',
            'edit-user',
            'delete-user',
            'show-user',
            'destroy-user',
            'create-book-category',
            'edit-book-category',
            'delete-book-category',
            'show-book-category',
            'create-book',
            'edit-book',
            'delete-book',
            'show-book',
            'borrow-book',
            'return-book',
            'manage-books',
            'approve-book',
            'reject-book',
            'view-book-requests',
            'view-pending-books',
            'view-all-books',
        ]);

        $user = Role::firstOrCreate(['name' => 'User']);
        $user->syncPermissions([
            'show-book-category',
            'show-book',
            'borrow-book',
            'return-book',
        ]);
    }
}
