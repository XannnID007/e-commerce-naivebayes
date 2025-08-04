<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\TrainingData;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 10 Sample Products sesuai dengan data di skripsi BAB 3
        $sampleProducts = [
            [
                'nama' => 'Lunaire Essence',
                'deskripsi' => 'Parfum malam dengan aroma bulan yang misterius dan essence floral yang lembut',
                'harga' => 275000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Bergamot, Pink Pepper, Aldehydes',
                'middle_notes' => 'Rose, Jasmine, Lily',
                'base_notes' => 'Musk, Vanilla, Sandalwood',
                'stok' => 25,
                'category_id' => 1, // Floral
                'aktif' => true
            ],
            [
                'nama' => 'Ethereal Bloom',
                'deskripsi' => 'Aroma bunga yang ethereal dan dreamy dengan sentuhan bloom yang romantis',
                'harga' => 290000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Freesia, Peony, Citrus',
                'middle_notes' => 'Magnolia, White Rose, Gardenia',
                'base_notes' => 'White Musk, Cedar, Amber',
                'stok' => 30,
                'category_id' => 1, // Floral
                'aktif' => true
            ],
            [
                'nama' => 'Secret Reviere',
                'deskripsi' => 'Parfum oriental dengan aroma secret garden dan nuansa sungai yang tenang',
                'harga' => 350000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Saffron, Cardamom, Bergamot',
                'middle_notes' => 'Rose, Oud, Jasmine',
                'base_notes' => 'Amber, Patchouli, Musk',
                'stok' => 20,
                'category_id' => 3, // Oriental
                'aktif' => true
            ],
            [
                'nama' => 'In The Garden',
                'deskripsi' => 'Parfum segar dengan aroma taman hijau dan nuansa alam yang natural',
                'harga' => 235000,
                'konsentrasi' => 'EDT',
                'top_notes' => 'Green Leaves, Mint, Cucumber',
                'middle_notes' => 'Lily of Valley, Green Tea, Sea Salt',
                'base_notes' => 'White Musk, Cedar, Ambergris',
                'stok' => 35,
                'category_id' => 4, // Fresh
                'aktif' => true
            ],
            [
                'nama' => 'Charmine',
                'deskripsi' => 'Parfum oriental yang charming dengan aroma vanilla dan amber yang memikat',
                'harga' => 320000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Orange, Cinnamon, Spices',
                'middle_notes' => 'Vanilla, Jasmine, Rose',
                'base_notes' => 'Tonka Bean, Benzoin, Amber',
                'stok' => 22,
                'category_id' => 3, // Oriental
                'aktif' => true
            ],
            [
                'nama' => 'Cherry Glow',
                'deskripsi' => 'Parfum fruity dengan aroma cherry manis dan glow yang berkilau',
                'harga' => 245000,
                'konsentrasi' => 'EDT',
                'top_notes' => 'Cherry, Strawberry, Pink Grapefruit',
                'middle_notes' => 'Peach, Freesia, Rose',
                'base_notes' => 'Vanilla, Musk, Sandalwood',
                'stok' => 28,
                'category_id' => 5, // Fruity
                'aktif' => true
            ],
            [
                'nama' => 'Baby Bloom',
                'deskripsi' => 'Parfum floral yang soft dengan aroma baby powder dan bloom yang innocent',
                'harga' => 265000,
                'konsentrasi' => 'EDT',
                'top_notes' => 'Powder, White Flowers, Citrus',
                'middle_notes' => 'Jasmine, Lily, Sweet Pea',
                'base_notes' => 'Soft Musk, Vanilla, Cashmere',
                'stok' => 32,
                'category_id' => 1, // Floral
                'aktif' => true
            ],
            [
                'nama' => 'Zanith',
                'deskripsi' => 'Parfum fresh dengan aroma puncak kesegaran dan nuansa zenith yang tinggi',
                'harga' => 255000,
                'konsentrasi' => 'EDT',
                'top_notes' => 'Ozone, Mountain Air, Mint',
                'middle_notes' => 'Lavender, Pine, Sea Salt',
                'base_notes' => 'Musk, Cedar, Ambergris',
                'stok' => 26,
                'category_id' => 4, // Fresh
                'aktif' => true
            ],
            [
                'nama' => 'Back To Black',
                'deskripsi' => 'Parfum woody dengan aroma gelap mysterious dan nuansa black yang bold',
                'harga' => 385000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Dark Woods, Black Pepper, Bergamot',
                'middle_notes' => 'Ebony, Cedar, Patchouli',
                'base_notes' => 'Leather, Tobacco, Dark Musk',
                'stok' => 18,
                'category_id' => 2, // Woody
                'aktif' => true
            ],
            [
                'nama' => 'Timeless Alpha',
                'deskripsi' => 'Parfum woody dengan aroma kayu abadi dan karakter alpha yang kuat',
                'harga' => 360000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Cedar, Pine, Cardamom',
                'middle_notes' => 'Sandalwood, Vetiver, Guaiac',
                'base_notes' => 'Amber, Musk, Oakmoss',
                'stok' => 21,
                'category_id' => 2, // Woody
                'aktif' => true
            ]
        ];

        foreach ($sampleProducts as $product) {
            Product::create($product);
        }
    }
}
