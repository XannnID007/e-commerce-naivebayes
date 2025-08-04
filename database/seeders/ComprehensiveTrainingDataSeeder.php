<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingData;

class ComprehensiveTrainingDataSeeder extends Seeder
{
    public function run()
    {
        $comprehensiveTrainingData = [
            // FLORAL - Target: 30 data
            [
                'deskripsi' => 'Aroma floral yang fresh dengan sentuhan citrus dan green notes',
                'top_notes' => 'Citrus, Green Apple, Bergamot',
                'middle_notes' => 'Rose, Jasmine, Lily of the Valley',
                'base_notes' => 'Musk, Cedarwood, Amber',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma bunga sakura yang ethereal dan dreamy dengan sentuhan freesia yang romantis',
                'top_notes' => 'Sakura, Freesia, Lemon',
                'middle_notes' => 'Peony, Gardenia, Magnolia',
                'base_notes' => 'Cedar, Amber, Soft Musk',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum floral yang soft dengan aroma lavender dan chamomile yang menenangkan',
                'top_notes' => 'Lavender, Chamomile, Bergamot',
                'middle_notes' => 'Rose Petals, Jasmine, Violet',
                'base_notes' => 'Sandalwood, Vanilla, Musk',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet bunga musim semi dengan dominasi tulip dan daffodil yang segar',
                'top_notes' => 'Tulip, Daffodil, Green Leaves',
                'middle_notes' => 'Lily of Valley, White Rose, Iris',
                'base_notes' => 'White Musk, Blonde Woods, Ambergris',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma bunga oriental dengan sentuhan ylang-ylang dan frangipani yang eksotis',
                'top_notes' => 'Ylang-Ylang, Frangipani, Mandarin',
                'middle_notes' => 'Tuberose, Orange Blossom, Gardenia',
                'base_notes' => 'Sandalwood, Benzoin, Musk',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum feminin dengan dominasi bunga putih dan sentuhan dewy morning',
                'top_notes' => 'White Flowers, Dewy Green, Citrus',
                'middle_notes' => 'Jasmine Sambac, White Tea, Lily',
                'base_notes' => 'Crystal Musk, Blonde Woods, Ambergris',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma bunga mawar Damask yang mewah dengan sentuhan powder yang lembut',
                'top_notes' => 'Damask Rose, Pink Pepper, Aldehydes',
                'middle_notes' => 'Bulgarian Rose, Geranium, Iris',
                'base_notes' => 'Musk, Powdery Notes, Cashmere Woods',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet floral dengan aroma honeysuckle dan wisteria yang romantis',
                'top_notes' => 'Honeysuckle, Wisteria, Petitgrain',
                'middle_notes' => 'White Rose, Jasmine, Sweet Pea',
                'base_notes' => 'White Musk, Soft Woods, Vanilla',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan aroma bunga lili yang innocent dan pure dengan sentuhan baby breath',
                'top_notes' => 'White Lily, Baby Breath, Green Mandarin',
                'middle_notes' => 'Iris, White Peony, Muguet',
                'base_notes' => 'Soft Musk, Vanilla, Light Woods',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma floral powdery dengan dominasi violet dan iris yang elegant',
                'top_notes' => 'Violet, Iris, Aldehydes',
                'middle_notes' => 'Rose, Jasmine, Heliotrope',
                'base_notes' => 'Powdery Musk, Orris, Blonde Woods',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet bunga wild flowers dengan aroma meadow dan field flowers yang natural',
                'top_notes' => 'Wild Flowers, Meadow Grass, Morning Dew',
                'middle_notes' => 'Dandelion, Poppy, Clover',
                'base_notes' => 'Green Musk, Hay, Light Woods',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan aroma bunga narcissus dan hyacinth yang spring-like',
                'top_notes' => 'Narcissus, Hyacinth, Green Leaves',
                'middle_notes' => 'Lily, Freesia, Jasmine',
                'base_notes' => 'White Musk, Cedar, Ambroxan',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma floral green dengan sentuhan grass dan fresh petals',
                'top_notes' => 'Fresh Petals, Grass, Green Apple',
                'middle_notes' => 'Rose, Lily of Valley, Green Tea',
                'base_notes' => 'Green Musk, Cedar, Ambergris',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan dominasi bunga carnation dan dianthus yang spicy floral',
                'top_notes' => 'Carnation, Dianthus, Pink Pepper',
                'middle_notes' => 'Rose, Clove, Cinnamon',
                'base_notes' => 'Musk, Vanilla, Sandalwood',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet evening flowers dengan aroma tuberose dan night blooming jasmine',
                'top_notes' => 'Tuberose, Night Jasmine, Citrus',
                'middle_notes' => 'Gardenia, Orange Blossom, Ylang',
                'base_notes' => 'Sandalwood, Musk, Benzoin',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma floral aldehydic dengan sentuhan classic dan timeless',
                'top_notes' => 'Aldehydes, White Flowers, Lemon',
                'middle_notes' => 'Rose, Jasmine, Lily',
                'base_notes' => 'Sandalwood, Musk, Iris',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan aroma bunga apple blossom dan cherry blossom yang delicate',
                'top_notes' => 'Apple Blossom, Cherry Blossom, Petitgrain',
                'middle_notes' => 'Rose, Peony, White Tea',
                'base_notes' => 'Musk, Blonde Woods, Ambroxan',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet tropical flowers dengan aroma hibiscus dan plumeria',
                'top_notes' => 'Hibiscus, Plumeria, Coconut',
                'middle_notes' => 'Frangipani, Gardenia, Ylang',
                'base_notes' => 'Sandalwood, Vanilla, Musk',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma floral aquatic dengan water lily dan lotus yang fresh',
                'top_notes' => 'Water Lily, Lotus, Aquatic Notes',
                'middle_notes' => 'Jasmine, White Rose, Marine',
                'base_notes' => 'Musk, Ambergris, Driftwood',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan dominasi bunga stephanotis dan gardenia yang creamy',
                'top_notes' => 'Stephanotis, Gardenia, Mandarin',
                'middle_notes' => 'Tuberose, Jasmine, Coconut',
                'base_notes' => 'Sandalwood, Vanilla, Musk',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma bunga magnolia dan camellia yang soft dan elegant',
                'top_notes' => 'Magnolia, Camellia, Green Leaves',
                'middle_notes' => 'White Rose, Peony, Lily',
                'base_notes' => 'Soft Musk, Cedar, Ambroxan',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet vintage roses dengan aroma tea rose dan cabbage rose yang classic',
                'top_notes' => 'Tea Rose, Cabbage Rose, Geranium',
                'middle_notes' => 'Bulgarian Rose, Damask Rose, Iris',
                'base_notes' => 'Musk, Sandalwood, Amber',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan aroma bunga morning glory dan sweet pea yang innocent',
                'top_notes' => 'Morning Glory, Sweet Pea, Dew',
                'middle_notes' => 'Lily, Freesia, Green Leaves',
                'base_notes' => 'White Musk, Light Woods, Ambroxan',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma floral musk dengan dominasi white musk dan clean flowers',
                'top_notes' => 'Clean Flowers, White Musk, Citrus',
                'middle_notes' => 'Lily, Jasmine, Cotton',
                'base_notes' => 'Crystal Musk, Blonde Woods, Ambergris',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet dried flowers dengan aroma potpourri dan preserved petals',
                'top_notes' => 'Dried Flowers, Potpourri, Lavender',
                'middle_notes' => 'Rose Petals, Jasmine, Violet',
                'base_notes' => 'Sandalwood, Musk, Benzoin',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan aroma bunga heather dan scotch broom yang wild',
                'top_notes' => 'Heather, Scotch Broom, Green',
                'middle_notes' => 'Wild Rose, Gorse, Meadow',
                'base_notes' => 'Moss, Musk, Light Woods',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma floral ozonic dengan sea flowers dan coastal blooms',
                'top_notes' => 'Sea Flowers, Coastal Blooms, Ozone',
                'middle_notes' => 'Sea Rose, Marine Lily, Salt',
                'base_notes' => 'Driftwood, Musk, Ambergris',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Bouquet English garden dengan aroma cottage garden flowers',
                'top_notes' => 'English Rose, Cottage Flowers, Green',
                'middle_notes' => 'Delphinium, Hollyhock, Lavender',
                'base_notes' => 'Moss, Musk, Cedar',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Parfum dengan dominasi bunga jasmine sambac dan Arabian jasmine',
                'top_notes' => 'Jasmine Sambac, Arabian Jasmine, Green',
                'middle_notes' => 'Tuberose, Gardenia, Rose',
                'base_notes' => 'Sandalwood, Musk, Benzoin',
                'category_id' => 1
            ],
            [
                'deskripsi' => 'Aroma bunga ethereal dengan angel flowers dan celestial blooms',
                'top_notes' => 'Angel Flowers, Celestial Blooms, Light',
                'middle_notes' => 'White Lily, Iris, Cloud',
                'base_notes' => 'Soft Musk, Ambroxan, Blonde Woods',
                'category_id' => 1
            ],

            // WOODY - Target: 30 data
            [
                'deskripsi' => 'Aroma kayu cedar yang kuat berpadu dengan vetiver dan patchouli yang earthy',
                'top_notes' => 'Cedar, Black Pepper, Bergamot',
                'middle_notes' => 'Vetiver, Geranium, Lavender',
                'base_notes' => 'Patchouli, Leather, Amber',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum maskulin dengan aroma kayu oak dan birch yang smoky dan intens',
                'top_notes' => 'Pine, Lemon, Cardamom',
                'middle_notes' => 'Oak, Birch, Cedarwood',
                'base_notes' => 'Smokywood, Amber, Musk',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody oriental dengan dominasi sandalwood dan rosewood yang warm',
                'top_notes' => 'Rosewood, Spices, Citrus',
                'middle_notes' => 'Sandalwood, Cedar, Guaiac Wood',
                'base_notes' => 'Amber, Musk, Tobacco',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma kayu tropis dengan sentuhan coconut wood dan bamboo yang eksotis',
                'top_notes' => 'Bamboo, Coconut Wood, Lime',
                'middle_notes' => 'Teak Wood, Cedar, Pine',
                'base_notes' => 'Driftwood, Sea Salt, Ambergris',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum woody dengan nuansa hutan pinus dan cedarwood yang fresh',
                'top_notes' => 'Pine Needles, Eucalyptus, Mint',
                'middle_notes' => 'Cedarwood, Fir Balsam, Juniper',
                'base_notes' => 'Musk, Amber, Moss',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody gourmand dengan aroma kayu manis dan vanilla yang hangat',
                'top_notes' => 'Cinnamon Wood, Nutmeg, Orange',
                'middle_notes' => 'Sandalwood, Cedar, Cloves',
                'base_notes' => 'Vanilla, Tonka Bean, Amber',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma kayu gelap dengan sentuhan leather dan tobacco yang sophisticated',
                'top_notes' => 'Dark Woods, Bergamot, Spices',
                'middle_notes' => 'Ebony, Cedar, Patchouli',
                'base_notes' => 'Leather, Tobacco, Musk',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody aquatic dengan perpaduan driftwood dan sea breeze yang menyegarkan',
                'top_notes' => 'Sea Breeze, Driftwood, Ozonic Notes',
                'middle_notes' => 'Cedar, Pine, Sage',
                'base_notes' => 'Ambergris, Musk, Salt',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan aroma mahogany dan walnut yang rich dan luxury',
                'top_notes' => 'Mahogany, Walnut, Bergamot',
                'middle_notes' => 'Cedar, Sandalwood, Vetiver',
                'base_notes' => 'Amber, Leather, Musk',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma woody spicy dengan campuran cedar dan exotic spices',
                'top_notes' => 'Cedar, Exotic Spices, Citrus',
                'middle_notes' => 'Sandalwood, Cardamom, Nutmeg',
                'base_notes' => 'Amber, Musk, Patchouli',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody fresh dengan dominasi cypress dan juniper yang crisp',
                'top_notes' => 'Cypress, Juniper, Mint',
                'middle_notes' => 'Cedar, Pine, Lavender',
                'base_notes' => 'Musk, Ambergris, Moss',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan aroma redwood dan sequoia yang majestic',
                'top_notes' => 'Redwood, Sequoia, Green',
                'middle_notes' => 'Cedar, Fir, Pine',
                'base_notes' => 'Moss, Earth, Musk',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma woody amber dengan perpaduan amber dan precious woods',
                'top_notes' => 'Precious Woods, Amber, Spices',
                'middle_notes' => 'Sandalwood, Cedar, Oud',
                'base_notes' => 'Amber, Musk, Benzoin',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody smoky dengan sentuhan birch tar dan charcoal',
                'top_notes' => 'Birch Tar, Charcoal, Citrus',
                'middle_notes' => 'Smoky Woods, Cedar, Vetiver',
                'base_notes' => 'Leather, Tar, Musk',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan aroma agarwood dan oud yang premium',
                'top_notes' => 'Agarwood, Oud, Rose',
                'middle_notes' => 'Sandalwood, Cedar, Spices',
                'base_notes' => 'Amber, Musk, Benzoin',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma woody green dengan moss dan forest floor',
                'top_notes' => 'Forest Floor, Moss, Green',
                'middle_notes' => 'Cedar, Pine, Fern',
                'base_notes' => 'Oakmoss, Earth, Musk',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody marine dengan driftwood dan sea-weathered timber',
                'top_notes' => 'Driftwood, Sea Salt, Ozone',
                'middle_notes' => 'Weathered Wood, Cedar, Sage',
                'base_notes' => 'Ambergris, Musk, Seaweed',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan dominasi ebony dan blackwood yang dark',
                'top_notes' => 'Ebony, Blackwood, Pepper',
                'middle_notes' => 'Dark Cedar, Patchouli, Vetiver',
                'base_notes' => 'Dark Musk, Tar, Leather',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma woody floral dengan rosewood dan violet wood',
                'top_notes' => 'Rosewood, Violet Wood, Citrus',
                'middle_notes' => 'Cedar, Sandalwood, Rose',
                'base_notes' => 'Musk, Amber, Soft Woods',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody aromatic dengan eucalyptus wood dan tea tree',
                'top_notes' => 'Eucalyptus Wood, Tea Tree, Mint',
                'middle_notes' => 'Cedar, Pine, Sage',
                'base_notes' => 'Musk, Amber, Light Woods',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan aroma olive wood dan Mediterranean woods',
                'top_notes' => 'Olive Wood, Mediterranean Woods, Herbs',
                'middle_notes' => 'Cedar, Sandalwood, Lavender',
                'base_notes' => 'Musk, Amber, Benzoin',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma woody citrus dengan cedarwood dan bergamot',
                'top_notes' => 'Cedarwood, Bergamot, Lemon',
                'middle_notes' => 'Cedar, Sandalwood, Neroli',
                'base_notes' => 'Musk, Amber, Light Woods',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody powdery dengan iris wood dan soft woods',
                'top_notes' => 'Iris Wood, Soft Woods, Aldehydes',
                'middle_notes' => 'Cedar, Sandalwood, Iris',
                'base_notes' => 'Powdery Musk, Blonde Woods, Ambroxan',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan dominasi cashmeran dan cashmere wood',
                'top_notes' => 'Cashmeran, Cashmere Wood, Spices',
                'middle_notes' => 'Cedar, Sandalwood, Vetiver',
                'base_notes' => 'Musk, Amber, Soft Woods',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma woody leather dengan leather accord dan suede',
                'top_notes' => 'Leather, Suede, Bergamot',
                'middle_notes' => 'Cedar, Sandalwood, Tobacco',
                'base_notes' => 'Leather, Musk, Amber',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody mineral dengan stone woods dan mineral notes',
                'top_notes' => 'Stone Woods, Mineral, Citrus',
                'middle_notes' => 'Cedar, Flint, Sage',
                'base_notes' => 'Musk, Ambergris, Stone',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan aroma paper birch dan white woods',
                'top_notes' => 'Paper Birch, White Woods, Green',
                'middle_notes' => 'Cedar, Birch, Lily',
                'base_notes' => 'White Musk, Blonde Woods, Ambroxan',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Aroma woody vanilla dengan vanilla wood dan creamy woods',
                'top_notes' => 'Vanilla Wood, Creamy Woods, Citrus',
                'middle_notes' => 'Sandalwood, Cedar, Vanilla',
                'base_notes' => 'Vanilla, Tonka, Soft Woods',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Woody incense dengan frankincense wood dan sacred woods',
                'top_notes' => 'Frankincense Wood, Sacred Woods, Citrus',
                'middle_notes' => 'Cedar, Sandalwood, Incense',
                'base_notes' => 'Frankincense, Musk, Amber',
                'category_id' => 2
            ],
            [
                'deskripsi' => 'Parfum dengan dominasi aged woods dan vintage timber',
                'top_notes' => 'Aged Woods, Vintage Timber, Spices',
                'middle_notes' => 'Old Cedar, Aged Sandalwood, Vetiver',
                'base_notes' => 'Aged Musk, Amber, Benzoin',
                'category_id' => 2
            ],

            // ORIENTAL - Target: 30 data
            [
                'deskripsi' => 'Aroma eksotis dengan rempah-rempah India, saffron dan amber yang misterius dan memikat',
                'top_notes' => 'Saffron, Cardamom, Pink Pepper',
                'middle_notes' => 'Rose, Oud, Jasmine',
                'base_notes' => 'Amber, Patchouli, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum oriental yang charming dengan dominasi vanilla dan tonka bean yang manis',
                'top_notes' => 'Orange, Cinnamon, Nutmeg',
                'middle_notes' => 'Vanilla, Jasmine, Rose',
                'base_notes' => 'Tonka Bean, Benzoin, Amber',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental spicy dengan aroma ginger dan black pepper yang warm dan sensual',
                'top_notes' => 'Ginger, Black Pepper, Mandarin',
                'middle_notes' => 'Cinnamon, Cardamom, Rose',
                'base_notes' => 'Amber, Sandalwood, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Aroma oriental dengan sentuhan incense dan myrrh yang spiritual dan dalam',
                'top_notes' => 'Incense, Myrrh, Bergamot',
                'middle_notes' => 'Frankincense, Rose, Jasmine',
                'base_notes' => 'Amber, Oud, Sandalwood',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental gourmand dengan perpaduan honey dan almonds yang lezat',
                'top_notes' => 'Honey, Almonds, Orange Blossom',
                'middle_notes' => 'Jasmine, Rose, Cinnamon',
                'base_notes' => 'Vanilla, Tonka Bean, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum oriental dengan nuansa Arabian nights, oud dan rose yang mewah',
                'top_notes' => 'Oud, Rose, Saffron',
                'middle_notes' => 'Jasmine, Patchouli, Sandalwood',
                'base_notes' => 'Amber, Musk, Benzoin',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental woody dengan aroma cedar dan spices yang complex dan sophisticated',
                'top_notes' => 'Spices, Cedar, Bergamot',
                'middle_notes' => 'Cinnamon, Cloves, Rose',
                'base_notes' => 'Sandalwood, Amber, Patchouli',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Aroma oriental dengan sentuhan dates dan figs yang exotic dan fruity',
                'top_notes' => 'Dates, Figs, Mandarin',
                'middle_notes' => 'Rose, Jasmine, Spices',
                'base_notes' => 'Amber, Musk, Sandalwood',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental floral dengan dominasi tuberose dan exotic flowers',
                'top_notes' => 'Tuberose, Exotic Flowers, Spices',
                'middle_notes' => 'Ylang-Ylang, Jasmine, Cinnamon',
                'base_notes' => 'Amber, Sandalwood, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum dengan aroma oriental vanilla yang rich dan creamy',
                'top_notes' => 'Oriental Vanilla, Spices, Citrus',
                'middle_notes' => 'Vanilla, Rose, Cinnamon',
                'base_notes' => 'Vanilla, Tonka Bean, Amber',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Aroma oriental amber dengan golden amber dan precious resins',
                'top_notes' => 'Golden Amber, Precious Resins, Citrus',
                'middle_notes' => 'Rose, Jasmine, Spices',
                'base_notes' => 'Amber, Benzoin, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental smoky dengan aroma smoky woods dan incense',
                'top_notes' => 'Smoky Woods, Incense, Bergamot',
                'middle_notes' => 'Rose, Oud, Spices',
                'base_notes' => 'Smoke, Amber, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum oriental dengan dominasi saffron dan golden spices',
                'top_notes' => 'Saffron, Golden Spices, Rose',
                'middle_notes' => 'Jasmine, Oud, Cardamom',
                'base_notes' => 'Amber, Sandalwood, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental leather dengan aroma leather dan exotic spices',
                'top_notes' => 'Leather, Exotic Spices, Bergamot',
                'middle_notes' => 'Rose, Oud, Tobacco',
                'base_notes' => 'Leather, Amber, Patchouli',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Aroma oriental dengan sentuhan chocolate dan cocoa',
                'top_notes' => 'Chocolate, Cocoa, Orange',
                'middle_notes' => 'Rose, Jasmine, Cinnamon',
                'base_notes' => 'Vanilla, Tonka Bean, Amber',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental powdery dengan iris dan powdery notes yang soft',
                'top_notes' => 'Iris, Powdery Notes, Aldehydes',
                'middle_notes' => 'Rose, Jasmine, Orris',
                'base_notes' => 'Powdery Musk, Amber, Sandalwood',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum dengan aroma oriental coffee dan coffee beans',
                'top_notes' => 'Coffee, Coffee Beans, Cardamom',
                'middle_notes' => 'Rose, Jasmine, Cinnamon',
                'base_notes' => 'Vanilla, Amber, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental balsamic dengan balsamic notes dan resinous woods',
                'top_notes' => 'Balsamic Notes, Resinous Woods, Citrus',
                'middle_notes' => 'Rose, Oud, Spices',
                'base_notes' => 'Balsam, Amber, Benzoin',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Aroma oriental dengan sentuhan caramel dan burnt sugar',
                'top_notes' => 'Caramel, Burnt Sugar, Orange',
                'middle_notes' => 'Rose, Jasmine, Cinnamon',
                'base_notes' => 'Vanilla, Tonka Bean, Amber',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental fruity dengan exotic fruits dan tropical spices',
                'top_notes' => 'Exotic Fruits, Tropical Spices, Mandarin',
                'middle_notes' => 'Rose, Jasmine, Cardamom',
                'base_notes' => 'Amber, Sandalwood, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum oriental dengan dominasi labdanum dan cistus',
                'top_notes' => 'Labdanum, Cistus, Bergamot',
                'middle_notes' => 'Rose, Oud, Spices',
                'base_notes' => 'Labdanum, Amber, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental metallic dengan metallic notes dan precious metals',
                'top_notes' => 'Metallic Notes, Precious Metals, Citrus',
                'middle_notes' => 'Rose, Jasmine, Spices',
                'base_notes' => 'Amber, Musk, Benzoin',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Aroma oriental dengan sentuhan animalic dan civet',
                'top_notes' => 'Animalic Notes, Civet, Rose',
                'middle_notes' => 'Jasmine, Oud, Spices',
                'base_notes' => 'Amber, Musk, Sandalwood',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental green dengan green spices dan herbs',
                'top_notes' => 'Green Spices, Herbs, Bergamot',
                'middle_notes' => 'Rose, Jasmine, Green Cardamom',
                'base_notes' => 'Amber, Sandalwood, Green Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum oriental dengan aroma tamarind dan exotic pods',
                'top_notes' => 'Tamarind, Exotic Pods, Citrus',
                'middle_notes' => 'Rose, Jasmine, Spices',
                'base_notes' => 'Amber, Musk, Sandalwood',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental wine dengan wine notes dan grape accord',
                'top_notes' => 'Wine Notes, Grape Accord, Citrus',
                'middle_notes' => 'Rose, Jasmine, Spices',
                'base_notes' => 'Amber, Musk, Benzoin',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Aroma oriental dengan sentuhan curry dan exotic spice blend',
                'top_notes' => 'Curry, Exotic Spice Blend, Citrus',
                'middle_notes' => 'Rose, Jasmine, Turmeric',
                'base_notes' => 'Amber, Sandalwood, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental resinous dengan pine resin dan tree saps',
                'top_notes' => 'Pine Resin, Tree Saps, Bergamot',
                'middle_notes' => 'Rose, Oud, Frankincense',
                'base_notes' => 'Resin, Amber, Benzoin',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Parfum oriental dengan dominasi osmanthus dan apricot flowers',
                'top_notes' => 'Osmanthus, Apricot Flowers, Mandarin',
                'middle_notes' => 'Rose, Jasmine, Spices',
                'base_notes' => 'Amber, Sandalwood, Musk',
                'category_id' => 3
            ],
            [
                'deskripsi' => 'Oriental marine dengan sea amber dan oceanic spices',
                'top_notes' => 'Sea Amber, Oceanic Spices, Salt',
                'middle_notes' => 'Rose, Jasmine, Seaweed',
                'base_notes' => 'Amber, Ambergris, Musk',
                'category_id' => 3
            ],

            // FRESH - Target: 30 data
            [
                'deskripsi' => 'Aroma segar seperti angin laut dengan sentuhan mint dan eucalyptus yang menyegarkan',
                'top_notes' => 'Mint, Eucalyptus, Sea Breeze',
                'middle_notes' => 'Sea Salt, Lavender, Marine Notes',
                'base_notes' => 'Driftwood, Musk, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan aroma aquatic dan ozone yang bersih dan energizing',
                'top_notes' => 'Ozone, Water Lily, Cucumber',
                'middle_notes' => 'Bamboo, Green Tea, Sea Salt',
                'base_notes' => 'White Musk, Ambergris, Cedar',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh green dengan dominasi grass dan green leaves yang natural',
                'top_notes' => 'Grass, Green Leaves, Dewdrops',
                'middle_notes' => 'Lily of Valley, Green Tea, Mint',
                'base_notes' => 'White Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Aroma fresh citrus dengan perpaduan lemon dan lime yang vibrant',
                'top_notes' => 'Lemon, Lime, Grapefruit',
                'middle_notes' => 'Green Apple, Mint, Basil',
                'base_notes' => 'White Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh alpine dengan aroma mountain air dan pine yang crisp',
                'top_notes' => 'Mountain Air, Pine, Mint',
                'middle_notes' => 'Lavender, Rosemary, Sage',
                'base_notes' => 'Musk, Cedar, Moss',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan nuansa rain dan petrichor yang menenangkan',
                'top_notes' => 'Rain, Petrichor, Ozonic Notes',
                'middle_notes' => 'Lily, Green Leaves, Mint',
                'base_notes' => 'Musk, Ambergris, Cedar',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh aquatic dengan sentuhan coconut water dan sea spray',
                'top_notes' => 'Coconut Water, Sea Spray, Lime',
                'middle_notes' => 'Jasmine, Sea Salt, Mint',
                'base_notes' => 'White Musk, Driftwood, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Aroma fresh morning dengan dew dan cucumber yang revitalizing',
                'top_notes' => 'Morning Dew, Cucumber, Green Mandarin',
                'middle_notes' => 'Green Tea, White Flowers, Mint',
                'base_notes' => 'Musk, Ambroxan, Cedar',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh herbal dengan dominasi herbs dan aromatic plants',
                'top_notes' => 'Herbs, Aromatic Plants, Citrus',
                'middle_notes' => 'Basil, Thyme, Mint',
                'base_notes' => 'Green Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan aroma clean laundry dan soap',
                'top_notes' => 'Clean Laundry, Soap, Aldehydes',
                'middle_notes' => 'White Flowers, Cotton, Lily',
                'base_notes' => 'Clean Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh ozonic dengan ozone dan atmospheric notes',
                'top_notes' => 'Ozone, Atmospheric Notes, Mint',
                'middle_notes' => 'Sea Salt, Marine, Lily',
                'base_notes' => 'Musk, Ambergris, Cedar',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Aroma fresh dengan sentuhan ice dan frozen notes',
                'top_notes' => 'Ice, Frozen Notes, Mint',
                'middle_notes' => 'Eucalyptus, Pine, Sage',
                'base_notes' => 'Cool Musk, Ambroxan, Cedar',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh floral dengan clean flowers dan white petals',
                'top_notes' => 'Clean Flowers, White Petals, Citrus',
                'middle_notes' => 'Lily, Jasmine, Green Tea',
                'base_notes' => 'White Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan aroma spring breeze dan new growth',
                'top_notes' => 'Spring Breeze, New Growth, Green',
                'middle_notes' => 'Lily of Valley, Green Leaves, Mint',
                'base_notes' => 'Green Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh tea dengan green tea dan white tea notes',
                'top_notes' => 'Green Tea, White Tea, Citrus',
                'middle_notes' => 'Jasmine Tea, Mint, Cucumber',
                'base_notes' => 'Tea Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Aroma fresh dengan sentuhan bamboo dan zen garden',
                'top_notes' => 'Bamboo, Zen Garden, Green',
                'middle_notes' => 'Green Tea, Lily, Mint',
                'base_notes' => 'Zen Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh mineral dengan mineral water dan spring water',
                'top_notes' => 'Mineral Water, Spring Water, Citrus',
                'middle_notes' => 'Lily, Mint, Marine',
                'base_notes' => 'Mineral Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan aroma apple orchard dan green fruits',
                'top_notes' => 'Apple Orchard, Green Fruits, Mint',
                'middle_notes' => 'Green Apple, Lily, Cucumber',
                'base_notes' => 'Green Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh cotton dengan cotton flowers dan soft fabric',
                'top_notes' => 'Cotton Flowers, Soft Fabric, Aldehydes',
                'middle_notes' => 'White Flowers, Cotton, Lily',
                'base_notes' => 'Cotton Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Aroma fresh dengan sentuhan meadow dan field grass',
                'top_notes' => 'Meadow, Field Grass, Green',
                'middle_notes' => 'Wild Flowers, Mint, Clover',
                'base_notes' => 'Grass Musk, Cedar, Hay',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh powder dengan baby powder dan talc notes',
                'top_notes' => 'Baby Powder, Talc, Aldehydes',
                'middle_notes' => 'White Flowers, Iris, Lily',
                'base_notes' => 'Powdery Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan aroma snow dan winter air',
                'top_notes' => 'Snow, Winter Air, Mint',
                'middle_notes' => 'Pine, Eucalyptus, Sage',
                'base_notes' => 'Cool Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh citrus dengan yuzu dan Japanese citrus',
                'top_notes' => 'Yuzu, Japanese Citrus, Mint',
                'middle_notes' => 'Green Tea, Lily, Cucumber',
                'base_notes' => 'White Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Aroma fresh dengan sentuhan aloe vera dan healing plants',
                'top_notes' => 'Aloe Vera, Healing Plants, Green',
                'middle_notes' => 'Cucumber, Mint, Green Tea',
                'base_notes' => 'Healing Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh marine dengan kelp dan seaweed notes',
                'top_notes' => 'Kelp, Seaweed, Sea Salt',
                'middle_notes' => 'Marine Flowers, Mint, Sage',
                'base_notes' => 'Marine Musk, Driftwood, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan aroma waterfall dan rushing water',
                'top_notes' => 'Waterfall, Rushing Water, Mint',
                'middle_notes' => 'Water Lily, Marine, Sage',
                'base_notes' => 'Water Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh linen dengan clean linen dan fabric softener',
                'top_notes' => 'Clean Linen, Fabric Softener, Aldehydes',
                'middle_notes' => 'White Flowers, Cotton, Lily',
                'base_notes' => 'Linen Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Aroma fresh dengan sentuhan glacier dan arctic air',
                'top_notes' => 'Glacier, Arctic Air, Mint',
                'middle_notes' => 'Pine, Eucalyptus, Ice',
                'base_notes' => 'Arctic Musk, Cedar, Ambergris',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Fresh spa dengan spa water dan wellness notes',
                'top_notes' => 'Spa Water, Wellness Notes, Eucalyptus',
                'middle_notes' => 'Cucumber, Mint, Green Tea',
                'base_notes' => 'Spa Musk, Cedar, Ambroxan',
                'category_id' => 4
            ],
            [
                'deskripsi' => 'Parfum fresh dengan aroma morning mist dan fog',
                'top_notes' => 'Morning Mist, Fog, Ozonic',
                'middle_notes' => 'Lily, Green Leaves, Mint',
                'base_notes' => 'Mist Musk, Cedar, Ambergris',
                'category_id' => 4
            ],

            // FRUITY - Target: 30 data
            [
                'deskripsi' => 'Parfum fruity dengan aroma cherry manis dan strawberry yang juicy dan menyenangkan',
                'top_notes' => 'Cherry, Strawberry, Pink Grapefruit',
                'middle_notes' => 'Peach, Raspberry, Freesia',
                'base_notes' => 'Vanilla, Musk, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma tropical dengan dominasi mango dan pineapple yang exotic',
                'top_notes' => 'Mango, Pineapple, Passionfruit',
                'middle_notes' => 'Coconut, Jasmine, Frangipani',
                'base_notes' => 'Vanilla, Musk, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity gourmand dengan perpaduan apple dan pear yang crisp dan fresh',
                'top_notes' => 'Green Apple, Pear, Lemon',
                'middle_notes' => 'Peach, White Flowers, Mint',
                'base_notes' => 'Musk, Vanilla, Cedar',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum berry dengan aroma blackberry dan blueberry yang intense',
                'top_notes' => 'Blackberry, Blueberry, Cassis',
                'middle_notes' => 'Raspberry, Rose, Violet',
                'base_notes' => 'Vanilla, Musk, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity citrus dengan dominasi orange dan mandarin yang cheerful',
                'top_notes' => 'Orange, Mandarin, Tangerine',
                'middle_notes' => 'Peach, Neroli, Orange Blossom',
                'base_notes' => 'Musk, Vanilla, Light Woods',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma stone fruits dengan peach dan apricot yang lembut dan manis',
                'top_notes' => 'Peach, Apricot, Nectarine',
                'middle_notes' => 'Jasmine, Rose, Lily',
                'base_notes' => 'Musk, Vanilla, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity floral dengan grape dan lychee yang refreshing',
                'top_notes' => 'Grape, Lychee, Pink Grapefruit',
                'middle_notes' => 'Peony, Freesia, Rose',
                'base_notes' => 'Musk, Vanilla, Cedar',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum dengan aroma pomegranate dan fig yang sophisticated',
                'top_notes' => 'Pomegranate, Fig, Bergamot',
                'middle_notes' => 'Rose, Jasmine, Violet',
                'base_notes' => 'Musk, Amber, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity exotic dengan dragon fruit dan kiwi yang unique',
                'top_notes' => 'Dragon Fruit, Kiwi, Lime',
                'middle_notes' => 'Lychee, Jasmine, Green Tea',
                'base_notes' => 'Musk, Vanilla, Light Woods',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma fruity dengan sentuhan banana dan coconut yang tropical',
                'top_notes' => 'Banana, Coconut, Pineapple',
                'middle_notes' => 'Frangipani, Ylang-Ylang, Mango',
                'base_notes' => 'Vanilla, Sandalwood, Musk',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity wine dengan wine grape dan champagne notes',
                'top_notes' => 'Wine Grape, Champagne, Citrus',
                'middle_notes' => 'Peach, Rose, Freesia',
                'base_notes' => 'Musk, Vanilla, Cedar',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum dengan aroma melon dan watermelon yang summer-like',
                'top_notes' => 'Melon, Watermelon, Cucumber',
                'middle_notes' => 'Green Apple, Lily, Mint',
                'base_notes' => 'White Musk, Cedar, Ambroxan',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity candy dengan candy fruits dan sugar notes',
                'top_notes' => 'Candy Fruits, Sugar, Cotton Candy',
                'middle_notes' => 'Strawberry, Peach, Vanilla',
                'base_notes' => 'Sugar Musk, Vanilla, Tonka Bean',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma fruity dengan sentuhan rhubarb dan tart fruits',
                'top_notes' => 'Rhubarb, Tart Fruits, Pink Pepper',
                'middle_notes' => 'Strawberry, Rose, Rhubarb Leaf',
                'base_notes' => 'Musk, Vanilla, Light Woods',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity jam dengan berry jam dan preserve notes',
                'top_notes' => 'Berry Jam, Preserves, Sugar',
                'middle_notes' => 'Raspberry, Strawberry, Rose',
                'base_notes' => 'Vanilla, Musk, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum dengan aroma plum dan damson yang rich',
                'top_notes' => 'Plum, Damson, Bergamot',
                'middle_notes' => 'Rose, Jasmine, Violet',
                'base_notes' => 'Musk, Amber, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity spice dengan cinnamon apple dan spiced fruits',
                'top_notes' => 'Cinnamon Apple, Spiced Fruits, Nutmeg',
                'middle_notes' => 'Apple, Cinnamon, Rose',
                'base_notes' => 'Vanilla, Musk, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma fruity dengan sentuhan papaya dan guava yang exotic',
                'top_notes' => 'Papaya, Guava, Lime',
                'middle_notes' => 'Passion Fruit, Jasmine, Coconut',
                'base_notes' => 'Vanilla, Musk, Light Woods',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity green dengan green fruits dan unripe notes',
                'top_notes' => 'Green Fruits, Unripe Notes, Lime',
                'middle_notes' => 'Green Apple, Mint, Cucumber',
                'base_notes' => 'Green Musk, Cedar, Ambroxan',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum dengan aroma cranberry dan red berries yang tart',
                'top_notes' => 'Cranberry, Red Berries, Pink Pepper',
                'middle_notes' => 'Rose, Raspberry, Freesia',
                'base_notes' => 'Musk, Vanilla, Cedar',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity cocktail dengan fruit cocktail dan mixed berries',
                'top_notes' => 'Fruit Cocktail, Mixed Berries, Citrus',
                'middle_notes' => 'Peach, Strawberry, Rose',
                'base_notes' => 'Musk, Vanilla, Light Woods',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma fruity dengan sentuhan elderberry dan blackcurrant',
                'top_notes' => 'Elderberry, Blackcurrant, Bergamot',
                'middle_notes' => 'Rose, Violet, Freesia',
                'base_notes' => 'Musk, Vanilla, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity honey dengan honey fruits dan bee pollen',
                'top_notes' => 'Honey Fruits, Bee Pollen, Orange',
                'middle_notes' => 'Peach, Honey, Orange Blossom',
                'base_notes' => 'Honey Musk, Vanilla, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum dengan aroma persimmon dan exotic Asian fruits',
                'top_notes' => 'Persimmon, Asian Fruits, Yuzu',
                'middle_notes' => 'Lychee, Jasmine, Green Tea',
                'base_notes' => 'Musk, Vanilla, Light Woods',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity ice dengan frozen fruits dan sorbet notes',
                'top_notes' => 'Frozen Fruits, Sorbet, Mint',
                'middle_notes' => 'Berry Ice, Cucumber, Lily',
                'base_notes' => 'Cool Musk, Cedar, Ambroxan',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma fruity dengan sentuhan quince dan medlar',
                'top_notes' => 'Quince, Medlar, Bergamot',
                'middle_notes' => 'Apple, Rose, Freesia',
                'base_notes' => 'Musk, Vanilla, Cedar',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity herb dengan herbed fruits dan garden fruits',
                'top_notes' => 'Herbed Fruits, Garden Fruits, Basil',
                'middle_notes' => 'Apple, Mint, Green Tea',
                'base_notes' => 'Green Musk, Cedar, Ambroxan',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum dengan aroma starfruit dan carambola yang unique',
                'top_notes' => 'Starfruit, Carambola, Lime',
                'middle_notes' => 'Lychee, Jasmine, Mint',
                'base_notes' => 'Musk, Vanilla, Light Woods',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Parfum dengan aroma bunga mawar yang lembut berpadu dengan melati putih dan lily yang menawan',
                'top_notes' => 'Mawar, Bergamot, Pink Pepper',
                'middle_notes' => 'Melati, Lily, Peony',
                'base_notes' => 'Musk Putih, Vanilla, Cedar',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Fruity dried dengan dried fruits dan raisin notes',
                'top_notes' => 'Dried Fruits, Raisin, Fig',
                'middle_notes' => 'Date, Rose, Honey',
                'base_notes' => 'Vanilla, Musk, Sandalwood',
                'category_id' => 5
            ],
            [
                'deskripsi' => 'Aroma fruity dengan sentuhan cloudberry dan nordic berries',
                'top_notes' => 'Cloudberry, Nordic Berries, Pine',
                'middle_notes' => 'Lingonberry, Rose, Mint',
                'base_notes' => 'Musk, Cedar, Ambergris',
                'category_id' => 5
            ]
        ];

        // Insert all training data with validation status
        foreach ($comprehensiveTrainingData as $data) {
            TrainingData::create(array_merge($data, [
                'is_validated' => true,
                'validated_at' => now()
            ]));
        }
    }
}
