<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managePermissions = Permission::where('guard_name', 'web')->get();

        $roleSuperAdmin = Role::updateOrCreate(['name' => 'Super Admin']);
        $roleSuperAdmin->givePermissionTo($managePermissions);

        $roleManager = Role::updateOrCreate(['name' => 'Manager']);
        $roleManager->givePermissionTo($managePermissions);

        Role::updateOrCreate(['guard_name' => 'accounts', 'name' => 'Creator']);

        Role::updateOrCreate(['guard_name' => 'accounts', 'name' => 'Reader']);
    }
}
