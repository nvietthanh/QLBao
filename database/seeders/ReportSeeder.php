<?php

namespace Database\Seeders;

use App\Models\ReportAccount;
use App\Models\ReportPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i = 0 ; $i < 30 ; $i++) {
            ReportAccount::create([
                'account_report_id' => rand(1, 40),
                'account_id' => rand(1, 40),
                'content' => $faker->paragraph,
                'image' => json_encode([fake()->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for($i = 0 ; $i < 30 ; $i++) {
            ReportPost::create([
                'post_id' => rand(1, 40),
                'account_report_id' => rand(1, 40),
                'content' => $faker->paragraph,
                'image' => json_encode([fake()->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
