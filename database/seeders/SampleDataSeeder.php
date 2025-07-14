<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\TrainingData;
use App\Models\Category;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Sample Training Data
        $sampleTrainingData = [
            // Floral
            [
                'deskripsi' => 'Aroma bunga mawar yang lembut dengan sentuhan melati dan lily putih',
                'top_notes' => 'Mawar, Bergamot',
                'middle_notes' => 'Melati, Lily',
                'base_notes' => 'Musk, Vanilla',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan dominasi aroma bunga sakura dan freesia yang feminim',
                'top_notes' => 'Sakura, Freesia',
                'middle_notes' => 'Peony, Gardenia',
                'base_notes' => 'Cedar, Amber',
                'category_id' => 1
            ],

            // Woody
            [
                'deskripsi' => 'Aroma kayu cedar yang hangat berpadu dengan sandalwood dan patchouli',
                'top_notes' => 'Cedar, Bergamot',
                'middle_notes' => 'Sandalwood, Vetiver',
                'base_notes' => 'Patchouli, Leather',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum maskulin dengan aroma kayu oak dan birch yang kuat',
                'top_notes' => 'Pine, Lemon',
                'middle_notes' => 'Oak, Birch',
                'base_notes' => 'Musk, Amber',
                'category_id' => 2
            ],

            // Oriental
            [
                'deskripsi' => 'Aroma eksotis dengan rempah-rempah India dan amber yang misterius',
                'top_notes' => 'Cardamom, Saffron',
                'middle_notes' => 'Rose, Oud',
                'base_notes' => 'Amber, Patchouli',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum oriental dengan dominasi vanilla dan tonka bean',
                'top_notes' => 'Orange, Cinnamon',
                'middle_notes' => 'Vanilla, Jasmine',
                'base_notes' => 'Tonka Bean, Benzoin',
                'category_id' => 3
            ],

            // Fresh
            [
                'deskripsi' => 'Aroma segar seperti angin laut dengan sentuhan mint dan eucalyptus',
                'top_notes' => 'Mint, Eucalyptus',
                'middle_notes' => 'Sea Salt, Lavender',
                'base_notes' => 'Driftwood, Musk',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum segar dengan aroma aquatic dan ozone yang bersih',
                'top_notes' => 'Ozone, Water Lily',
                'middle_notes' => 'Bamboo, Green Tea',
                'base_notes' => 'White Musk, Ambergris',
                'category_id' => 4
            ]
        ];

        foreach ($sampleTrainingData as $data) {
            TrainingData::create(array_merge($data, ['is_validated' => true]));
        }

        // Sample Products
        $sampleProducts = [
            [
                'nama' => 'Rose Garden Elegance',
                'deskripsi' => 'Parfum elegan dengan aroma mawar taman yang dipetik saat fajar, berpadu dengan sentuhan melati dan vanilla yang lembut',
                'harga' => 285000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Rose Petals, Pink Pepper',
                'middle_notes' => 'Jasmine, Peony',
                'base_notes' => 'Vanilla, White Musk',
                'stok' => 25,
                'category_id' => 1,
                'aktif' => true
            ],
            [
                'nama' => 'Cedarwood Masculinity',
                'deskripsi' => 'Parfum maskulin dengan karakter kayu cedar yang kuat, diperkaya dengan vetiver dan leather untuk pria yang percaya diri',
                'harga' => 320000,
                'konsentrasi' => 'EDT',
                'top_notes' => 'Bergamot, Black Pepper',
                'middle_notes' => 'Cedarwood, Vetiver',
                'base_notes' => 'Leather, Amber',
                'stok' => 18,
                'category_id' => 2,
                'aktif' => true
            ],
            [
                'nama' => 'Mystical Orient',
                'deskripsi' => 'Aroma oriental yang misterius dengan perpaduan oud, saffron, dan amber untuk pengalaman olfactory yang tak terlupakan',
                'harga' => 450000,
                'konsentrasi' => 'EDP',
                'top_notes' => 'Saffron, Cardamom',
                'middle_notes' => 'Oud, Rose',
                'base_notes' => 'Amber, Sandalwood',
                'stok' => 12,
                'category_id' => 3,
                'aktif' => true
            ],
            [
                'nama' => 'Ocean Breeze Fresh',
                'deskripsi' => 'Kesegaran angin laut yang memberikan energi positif dengan kombinasi mint, sea salt, dan white musk',
                'harga' => 195000,
                'konsentrasi' => 'EDT',
                'top_notes' => 'Mint, Lemon',
                'middle_notes' => 'Sea Salt, Lavender',
                'base_notes' => 'White Musk, Driftwood',
                'stok' => 30,
                'category_id' => 4,
                'aktif' => true
            ],
            [
                'nama' => 'Citrus Sunshine',
                'deskripsi' => 'Parfum citrus yang menyegarkan dengan dominasi orange, lemon, dan grapefruit untuk hari yang cerah',
                'harga' => 165000,
                'konsentrasi' => 'EDC',
                'top_notes' => 'Orange, Lemon, Grapefruit',
                'middle_notes' => 'Neroli, Petitgrain',
                'base_notes' => 'Cedar, Light Musk',
                'stok' => 40,
                'category_id' => 5,
                'aktif' => true
            ],
            [
                'nama' => 'Lavender Fields',
                'deskripsi' => 'Aroma fougère klasik dengan lavender, geranium, dan oakmoss untuk kesan natural dan menenangkan',
                'harga' => 225000,
                'konsentrasi' => 'EDT',
                'top_notes' => 'Lavender, Geranium',
                'middle_notes' => 'Rosemary, Coumarin',
                'base_notes' => 'Oakmoss, Tonka Bean',
                'stok' => 22,
                'category_id' => 6,
                'aktif' => true
            ]
        ];

        foreach ($sampleProducts as $product) {
            Product::create($product);
        }
    }
}
