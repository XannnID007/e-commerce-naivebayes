<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\TrainingData;
use App\Models\ClassificationLog;

class HomeController extends Controller
{
    public function index()
    {
        // Produk terbaru
        $latestProducts = Product::aktif()
            ->with('category')
            ->latest()
            ->limit(8)
            ->get();

        // Kategori dengan jumlah produk
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('aktif', true);
        }])
            ->where('aktif', true)
            ->limit(8)
            ->get();

        // Produk populer (berdasarkan kategori yang paling banyak produknya)
        $popularProducts = Product::aktif()
            ->with('category')
            ->whereHas('category', function ($query) {
                $query->withCount('products')
                    ->orderByDesc('products_count');
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Stats untuk hero section
        $stats = [
            'total_produk' => Product::where('aktif', true)->count(),
            'total_kategori' => Category::where('aktif', true)->count(),
            'total_training_data' => TrainingData::where('is_validated', true)->count(),
            'akurasi_model' => $this->getModelAccuracy()
        ];

        // Featured categories dengan produk terbanyak
        $featuredCategories = Category::withCount(['products' => function ($query) {
            $query->where('aktif', true);
        }])
            ->where('aktif', true)
            ->orderByDesc('products_count')
            ->limit(6)
            ->get();

        return view('user.home', compact(
            'latestProducts',
            'categories',
            'popularProducts',
            'stats',
            'featuredCategories'
        ));
    }

    public function contact()
    {
        return view('user.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string|max:1000'
        ]);

        // Simpan pesan kontak (opsional - bisa disimpan ke database)
        // ContactMessage::create($request->all());

        // Kirim email notifikasi (opsional)
        // Mail::to('admin@philocalist.com')->send(new ContactMessage($request->all()));

        return redirect()->back()->with(
            'success',
            'Terima kasih! Pesan Anda telah dikirim. Tim customer service kami akan segera menghubungi Anda dalam 1x24 jam.'
        );
    }

    public function about()
    {
        // Data untuk halaman about
        $stats = [
            'total_produk' => Product::where('aktif', true)->count(),
            'total_kategori' => Category::where('aktif', true)->count(),
            'akurasi_model' => $this->getModelAccuracy(),
            'data_training' => TrainingData::where('is_validated', true)->count(),
            'klasifikasi_sukses' => ClassificationLog::where('is_correct', true)->count(),
            'tahun_berdiri' => '2024'
        ];

        // Timeline perusahaan
        $timeline = [
            [
                'year' => '2024',
                'title' => 'Peluncuran Philocalist',
                'description' => 'Memulai bisnis parfum dengan fokus pada kualitas dan inovasi teknologi AI'
            ],
            [
                'year' => '2024',
                'title' => 'Implementasi AI',
                'description' => 'Mengintegrasikan sistem klasifikasi aroma menggunakan algoritma Naive Bayes'
            ],
            [
                'year' => '2024',
                'title' => 'Ekspansi Produk',
                'description' => 'Meluncurkan 50+ varian parfum dalam 8 kategori aroma yang berbeda'
            ],
            [
                'year' => '2025',
                'title' => 'Rencana Masa Depan',
                'description' => 'Pengembangan aplikasi mobile dan ekspansi ke pasar regional'
            ]
        ];

        // Team members (opsional)
        $team = [
            [
                'name' => 'CEO & Founder',
                'role' => 'Visionary Leader',
                'description' => 'Memimpin visi dan strategi perusahaan dalam mengintegrasikan teknologi AI dengan industri parfum',
                'image' => 'team-1.jpg'
            ],
            [
                'name' => 'Head of AI Development',
                'role' => 'AI Specialist',
                'description' => 'Mengembangkan dan mengoptimalkan algoritma Naive Bayes untuk klasifikasi aroma',
                'image' => 'team-2.jpg'
            ],
            [
                'name' => 'Master Perfumer',
                'role' => 'Fragrance Expert',
                'description' => 'Menciptakan formula parfum berkualitas dengan expertise lebih dari 10 tahun',
                'image' => 'team-3.jpg'
            ]
        ];

        return view('user.about', compact('stats', 'timeline', 'team'));
    }

    /**
     * Get model accuracy
     */
    private function getModelAccuracy()
    {
        $totalLogs = ClassificationLog::whereNotNull('is_correct')->count();

        if ($totalLogs == 0) {
            return 95; // Default accuracy jika belum ada data
        }

        $correctLogs = ClassificationLog::where('is_correct', true)->count();
        return round(($correctLogs / $totalLogs) * 100, 1);
    }

    /**
     * API endpoint untuk mendapatkan statistics real-time
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'products' => [
                    'total' => Product::count(),
                    'active' => Product::where('aktif', true)->count(),
                    'by_category' => Category::withCount('products')->get()
                ],
                'categories' => [
                    'total' => Category::count(),
                    'active' => Category::where('aktif', true)->count()
                ],
                'ai_performance' => [
                    'accuracy' => $this->getModelAccuracy(),
                    'total_classifications' => ClassificationLog::count(),
                    'training_data' => TrainingData::where('is_validated', true)->count()
                ],
                'recent_activity' => [
                    'latest_products' => Product::with('category')->latest()->limit(5)->get(),
                    'recent_classifications' => ClassificationLog::with(['product', 'predictedCategory'])
                        ->latest()->limit(5)->get()
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products untuk autocomplete
     */
    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::aktif()
            ->with('category')
            ->where(function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                    ->orWhere('deskripsi', 'like', "%{$query}%")
                    ->orWhereHas('category', function ($cat) use ($query) {
                        $cat->where('nama', 'like', "%{$query}%");
                    });
            })
            ->limit(10)
            ->get(['id', 'nama', 'harga', 'category_id', 'gambar']);

        return response()->json($products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->nama,
                'price' => $product->formatted_harga,
                'category' => $product->category->nama,
                'image' => $product->gambar_url,
                'url' => route('products.show', $product)
            ];
        }));
    }

    /**
     * Get popular products by category
     */
    public function getPopularProducts($categoryId = null)
    {
        $query = Product::aktif()->with('category');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Simulasi popularitas berdasarkan klasifikasi AI yang akurat
        $products = $query->whereNotNull('confidence_score')
            ->orderByDesc('confidence_score')
            ->limit(8)
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->nama,
                    'price' => $product->formatted_harga,
                    'category' => $product->category->nama,
                    'image' => $product->gambar_url,
                    'confidence' => $product->confidence_score,
                    'url' => route('products.show', $product)
                ];
            })
        ]);
    }

    /**
     * Newsletter subscription
     */
    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255'
        ]);

        try {
            // Simpan email subscriber (implementasi sesuai kebutuhan)
            // NewsletterSubscriber::firstOrCreate(['email' => $request->email]);

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Anda berhasil berlangganan newsletter kami.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Get recommendations based on user preferences
     */
    public function getRecommendations(Request $request)
    {
        $preferences = $request->input('preferences', []);

        $query = Product::aktif()->with('category');

        // Filter berdasarkan preferensi kategori
        if (!empty($preferences['categories'])) {
            $query->whereIn('category_id', $preferences['categories']);
        }

        // Filter berdasarkan range harga
        if (!empty($preferences['price_range'])) {
            $priceRange = explode('-', $preferences['price_range']);
            if (count($priceRange) == 2) {
                $query->whereBetween('harga', [(int)$priceRange[0], (int)$priceRange[1]]);
            }
        }

        // Filter berdasarkan konsentrasi
        if (!empty($preferences['concentration'])) {
            $query->whereIn('konsentrasi', $preferences['concentration']);
        }

        $recommendations = $query->orderByDesc('confidence_score')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'recommendations' => $recommendations->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->nama,
                    'price' => $product->formatted_harga,
                    'category' => $product->category->nama,
                    'concentration' => $product->konsentrasi_label,
                    'image' => $product->gambar_url,
                    'confidence' => $product->confidence_score,
                    'url' => route('products.show', $product)
                ];
            })
        ]);
    }
}
