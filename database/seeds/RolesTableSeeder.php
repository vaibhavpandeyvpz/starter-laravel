<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Role $administrator */
        $administrator = Role::create(['name' => 'Administrator']);
        $administrator->givePermissionTo(
            'view all roles',
            'view role',
            'create role',
            'update role',
            'delete role',
            'delete user'
        );
        /** @var Role $staff */
        $staff = Role::create(['name' => 'Staff']);
        $staff->givePermissionTo(
            'view all users',
            'view user',
            'create user',
            'update user'
        );
    }
}
