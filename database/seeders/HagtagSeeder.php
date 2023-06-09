<?php

namespace Database\Seeders;

use App\Models\HagTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HagtagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HagTag::create(
            [
                'name' => 'Mới nhất',
                'slug' => Str::remove('-', Str::slug('Mới nhất')),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        
        HagTag::create([
            'name' => 'Năng lượng tích cực',
            'slug' => Str::remove('-', Str::slug('Năng lượng tích cực')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        HagTag::create([
            'name' => 'Thị trường tiêu dùng',
            'slug' => Str::remove('-', Str::slug('Thị trường tiêu dùng')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        HagTag::create([
            'name' => 'Giảm nghèo bền vững',
            'slug' => Str::remove('-', Str::slug('Giảm nghèo bền vững')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
