<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Игрушки', 'image' => 'kidify/imgs/page/homepage1/bg-collection1.png'],
            ['name' => 'Одежда', 'image' => 'kidify/imgs/page/homepage1/bg-kid.png'],
            ['name' => 'Аксессуары', 'image' => 'kidify/imgs/page/homepage1/bg-collection2.png'],
            ['name' => 'Обувь', 'image' => 'kidify/imgs/page/homepage1/apparels.png'],
            ['name' => 'Книги и развитие', 'image' => 'kidify/imgs/page/homepage1/dress.png'],
            ['name' => 'Уход за малышом', 'image' => 'kidify/imgs/page/homepage1/bg-animal.png'],
        ];

        foreach ($categories as $i => $data) {
            Category::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'image' => $data['image'],
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }
    }
}
