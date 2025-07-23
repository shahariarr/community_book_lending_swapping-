<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'create-permission',
            'edit-permission',
            'delete-permission',
            'show-user',
            'destroy-user',

            // Book Category Permissions
            'create-book-category',
            'edit-book-category',
            'delete-book-category',
            'show-book-category',

            // Book Permissions
            'create-book',
            'edit-book',
            'delete-book',
            'show-book',
            'borrow-book',
            'return-book',
         ];

          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
          }
    }
}
