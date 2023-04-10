<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $category = Category::create([
            'name' => 'Chính trị xã hội',
            'slug' => Str::slug('Chính trị xã hội')
        ]);

        for ($i = 0; $i < 30 ; $i++){
            $title = fake()->name();
            $id = rand(1, 10);
            $category->posts()->create([
                'title' => $title,
                'content' => $faker->paragraph,
                'slug' => Str::slug($title),
                'image' => fake()->imageUrl(),
                'is_popular' => rand(0, 1),
                'is_approved' => 1,
                'creator_id' => $id,
                'updater_id' => $id,
            ]);
        }   

        $category = Category::create([
            'name' => 'Văn hóa',
            'slug' => Str::slug('Văn hóa')
        ]);

        for ($i = 0; $i < 30 ; $i++){
            $title = fake()->name();
            $id = rand(1, 10);
            $category->posts()->create([
                'title' => $title,
                'content' => $faker->paragraph,
                'slug' => Str::slug($title),
                'image' => fake()->imageUrl(),
                'is_popular' => rand(0, 1),
                'is_approved' => 1,
                'creator_id' => $id,
                'updater_id' => $id,
            ]);
        }

        $category = Category::create([
            'name' => 'Xã hội',
            'slug' => Str::slug('Xã hội')
        ]);

        for ($i = 0; $i < 30 ; $i++){
            $title = fake()->name();
            $id = rand(1, 10);
            $category->posts()->create([
                'title' => $title,
                'content' => $faker->paragraph,
                'slug' => Str::slug($title),
                'image' => fake()->imageUrl(),
                'is_popular' => rand(0, 1),
                'is_approved' => 1,
                'creator_id' => $id,
                'updater_id' => $id,
            ]);
        }

        $category = Category::create([
            'name' => 'Kinh doanh',
            'slug' => Str::slug('Kinh doanh')
        ]);

        for ($i = 0; $i < 30 ; $i++){
            $title = fake()->name();
            $id = rand(1, 10);
            $category->posts()->create([
                'title' => $title,
                'content' => $faker->paragraph,
                'slug' => Str::slug($title),
                'image' => fake()->imageUrl(),
                'is_popular' => rand(0, 1),
                'is_approved' => 1,
                'creator_id' => $id,
                'updater_id' => $id,
            ]);
        }
        
        $category = Category::create([
            'name' => 'Du lịch',
            'slug' => Str::slug('Du lịch')
        ]);

        for ($i = 0; $i < 30 ; $i++){
            $title = fake()->name();
            $id = rand(1, 10);
            $category->posts()->create([
                'title' => $title,
                'content' => $faker->paragraph,
                'slug' => Str::slug($title),
                'image' => fake()->imageUrl(),
                'is_popular' => rand(0, 1),
                'is_approved' => 1,
                'creator_id' => $id,
                'updater_id' => $id,
            ]);
        }

        $category = Category::create([
            'name' => 'Đời sống',
            'slug' => Str::slug('Đời sống')
        ]);

        for ($i = 0; $i < 30 ; $i++){
            $title = fake()->name();
            $id = rand(1, 10);
            $category->posts()->create([
                'title' => $title,
                'content' => $faker->paragraph,
                'slug' => Str::slug($title),
                'image' => fake()->imageUrl(),
                'is_popular' => rand(0, 1),
                'is_approved' => 1,
                'creator_id' => $id,
                'updater_id' => $id,
            ]);
        }
    }
}
