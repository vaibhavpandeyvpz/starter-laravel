<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->firstOrCreate(['name' => 'view all roles']);
        Permission::query()->firstOrCreate(['name' => 'view role']);
        Permission::query()->firstOrCreate(['name' => 'create role']);
        Permission::query()->firstOrCreate(['name' => 'update role']);
        Permission::query()->firstOrCreate(['name' => 'delete role']);

        Permission::query()->firstOrCreate(['name' => 'view all users']);
        Permission::query()->firstOrCreate(['name' => 'view user']);
        Permission::query()->firstOrCreate(['name' => 'create user']);
        Permission::query()->firstOrCreate(['name' => 'update user']);
        Permission::query()->firstOrCreate(['name' => 'delete user']);

        Permission::query()->firstOrCreate(['name' => 'access horizon']);
    }
}
