<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Super Admin
        $adminSupperAdmin = [
            'name' => 'Super Admin',
            'email' => 'admin@rabiloo.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => Carbon::now()
        ];
        User::create($adminSupperAdmin)->assignRole('Super Admin');

        // Admin Manager
        $userManager = [
            'name' => 'Manager',
            'email' => 'manager@rabiloo.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => Carbon::now()
        ];
        User::create($userManager)->assignRole('Manager');
    }
}
