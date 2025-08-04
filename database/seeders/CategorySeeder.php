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
                'deskripsi' => 'Aroma bunga yang lembut dan feminin dengan sentuhan romantis',
                'icon' => 'fas fa-spa',
                'aktif' => true
            ],
            [
                'nama' => 'Woody',
                'deskripsi' => 'Aroma kayu yang hangat dan maskulin dengan karakter yang kuat',
                'icon' => 'fas fa-tree',
                'aktif' => true
            ],
            [
                'nama' => 'Oriental',
                'deskripsi' => 'Aroma eksotis dengan rempah-rempah dan nuansa misterius',
                'icon' => 'fas fa-star',
                'aktif' => true
            ],
            [
                'nama' => 'Fresh',
                'deskripsi' => 'Aroma segar dan bersih yang memberikan kesegaran alami',
                'icon' => 'fas fa-leaf',
                'aktif' => true
            ],
            [
                'nama' => 'Fruity',
                'deskripsi' => 'Aroma buah-buahan yang manis dan menyegarkan',
                'icon' => 'fas fa-apple-alt',
                'aktif' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
