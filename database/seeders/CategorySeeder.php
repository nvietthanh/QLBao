<?php

namespace Database\Seeders;

use App\Models\Account;
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
            'name' => 'Bất động sản',
            'slug' => Str::slug('Bất động sản')
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }

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
                'updaterable' => Account::class,
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
                'updaterable' => Account::class,
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }

        $category = Category::create([
            'name' => 'Giải trí',
            'slug' => Str::slug('Giải trí')
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }
        
        $category = Category::create([
            'name' => 'Giáo dục',
            'slug' => Str::slug('Giáo dục')
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
                'updaterable' => Account::class,
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }
        
        $category = Category::create([
            'name' => 'Pháp luật',
            'slug' => Str::slug('Pháp luật')
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }

        $category = Category::create([
            'name' => 'Sức khỏe',
            'slug' => Str::slug('Sức khỏe')
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }

        $category = Category::create([
            'name' => 'Thế giới',
            'slug' => Str::slug('Thế giới')
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }

        $category = Category::create([
            'name' => 'Thể thao',
            'slug' => Str::slug('Thể thao')
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
                'updaterable' => Account::class,
                'updater_id' => $id,
            ]);
        }
    }
}
