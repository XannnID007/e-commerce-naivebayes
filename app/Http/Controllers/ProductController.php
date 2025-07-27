<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\NaiveBayesService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $naiveBayesService;

    public function __construct(NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    // Admin Methods
    public function index()
    {
        $products = Product::with('category')
            ->when(request('search'), function ($query) {
                $query->search(request('search'));
            })
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
            })
            ->paginate(10);

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('aktif', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'konsentrasi' => 'required|in:EDC,EDT,EDP',
            'top_notes' => 'nullable|string',
            'middle_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Upload gambar jika ada - Perbaikan path storage
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan ke storage/app/public/products
            $path = $file->storeAs('products', $filename, 'public');
            $data['gambar'] = $path;
        }

        // Klasifikasi otomatis menggunakan Naive Bayes
        $classification = $this->naiveBayesService->classify($data);
        $data['category_id'] = $classification['category_id'];
        $data['confidence_score'] = $classification['confidence_score'];

        $product = Product::create($data);

        // Log klasifikasi
        $this->naiveBayesService->logClassification($product, $classification);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan dengan klasifikasi otomatis!');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('aktif', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'konsentrasi' => 'required|in:EDC,EDT,EDP',
            'top_notes' => 'nullable|string',
            'middle_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Hapus gambar jika ada
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function reclassify(Product $product)
    {
        $productData = [
            'deskripsi' => $product->deskripsi,
            'top_notes' => $product->top_notes,
            'middle_notes' => $product->middle_notes,
            'base_notes' => $product->base_notes
        ];

        $classification = $this->naiveBayesService->classify($productData);

        $product->update([
            'category_id' => $classification['category_id'],
            'confidence_score' => $classification['confidence_score']
        ]);

        // Log klasifikasi ulang
        $this->naiveBayesService->logClassification($product, $classification);

        return redirect()->back()
            ->with('success', 'Produk berhasil diklasifikasi ulang!');
    }

    // User Methods
    public function userIndex()
    {
        $products = Product::aktif()
            ->with('category')
            ->when(request('search'), function ($query) {
                $query->search(request('search'));
            })
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
            })
            ->when(request('sort'), function ($query) {
                switch (request('sort')) {
                    case 'harga_asc':
                        $query->orderBy('harga', 'asc');
                        break;
                    case 'harga_desc':
                        $query->orderBy('harga', 'desc');
                        break;
                    case 'nama':
                        $query->orderBy('nama', 'asc');
                        break;
                    default:
                        $query->latest();
                }
            })
            ->paginate(12);

        $categories = Category::withCount(['products' => function ($query) {
            $query->where('aktif', true);
        }])->where('aktif', true)->get();

        return view('user.products.index', compact('products', 'categories'));
    }

    public function userShow(Product $product)
    {
        if (!$product->aktif) {
            abort(404);
        }

        $product->load('category');

        // Produk terkait dari kategori yang sama
        $relatedProducts = Product::aktif()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}
