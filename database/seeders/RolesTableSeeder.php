<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Role $administrator */
        $administrator = Role::query()->firstOrCreate(['name' => 'Administrator']);
        $administrator->syncPermissions(
            'access horizon',
            'view all roles',
            'view role',
            'create role',
            'update role',
            'delete role',
            'delete user'
        );
        /** @var Role $staff */
        $staff = Role::query()->firstOrCreate(['name' => 'Staff']);
        $staff->syncPermissions(
            'view all users',
            'view user',
            'create user',
            'update user'
        );
    }
}
