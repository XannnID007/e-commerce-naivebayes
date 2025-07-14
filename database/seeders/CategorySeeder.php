<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'nama' => 'Floral',
                'deskripsi' => 'Aroma bunga yang lembut dan feminin',
                'icon' => 'fas fa-flower'
            ],
            [
                'nama' => 'Woody',
                'deskripsi' => 'Aroma kayu yang hangat dan maskulin',
                'icon' => 'fas fa-tree'
            ],
            [
                'nama' => 'Oriental',
                'deskripsi' => 'Aroma eksotis dengan rempah-rempah',
                'icon' => 'fas fa-star'
            ],
            [
                'nama' => 'Fresh',
                'deskripsi' => 'Aroma segar dan bersih',
                'icon' => 'fas fa-leaf'
            ],
            [
                'nama' => 'Citrus',
                'deskripsi' => 'Aroma jeruk yang menyegarkan',
                'icon' => 'fas fa-lemon'
            ],
            [
                'nama' => 'Fougère',
                'deskripsi' => 'Aroma herbal dengan lavender',
                'icon' => 'fas fa-seedling'
            ],
            [
                'nama' => 'Chypre',
                'deskripsi' => 'Aroma kompleks dengan oakmoss',
                'icon' => 'fas fa-mountain'
            ],
            [
                'nama' => 'Gourmand',
                'deskripsi' => 'Aroma manis seperti makanan',
                'icon' => 'fas fa-cookie'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
