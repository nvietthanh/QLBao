<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        \DB::table('permissions')->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $adminPermissions = [
            'category' => [
                'category.view',
                'category.edit'
            ],
            'post' => [
                'post.view',
                'post.edit'
            ],
            'comment' => [
                'comment.view',
                'comment.edit'
            ],
            'user' => [
                'user.view',
                'user.edit',
            ],
        ];

        $userPermissions = [
            'readers' => [
                'readers.comment',
            ],
            'creators' => [
                'creators.comment',
                'creators.view-post',
                'creators.edit-post',                
            ]
        ];

        foreach ($adminPermissions as $arrPermission) {
            foreach ($arrPermission as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
            }
        }

        foreach ($userPermissions as $arrPermission) {
            foreach ($arrPermission as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => 'accounts'
                ]);
            }
        }
    }
}
