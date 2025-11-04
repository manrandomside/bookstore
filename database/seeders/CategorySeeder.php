<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Novel Fantasi',
            'description' => 'Koleksi novel dengan dunia fantasi yang memukau dan penuh petualangan.',
        ]);

        Category::create([
            'name' => 'Novel Romantis',
            'description' => 'Novel dengan cerita cinta yang mengharukan dan penuh emosi.',
        ]);

        Category::create([
            'name' => 'Novel Inspiratif',
            'description' => 'Novel yang memberikan motivasi dan inspirasi dalam hidup.',
        ]);

        Category::create([
            'name' => 'Novel Petualangan',
            'description' => 'Novel dengan aksi dan petualangan seru yang menegangkan.',
        ]);

        Category::create([
            'name' => 'Novel Misteri',
            'description' => 'Novel penuh misteri dan kejutan yang menggebrak pikiran.',
        ]);

        Category::create([
            'name' => 'Novel Filosofi',
            'description' => 'Novel yang penuh dengan makna dan pembelajaran hidup yang mendalam.',
        ]);
    }
}