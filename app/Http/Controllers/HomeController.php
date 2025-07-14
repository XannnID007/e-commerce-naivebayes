<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

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

        // Produk populer (berdasarkan stok terjual - simulasi)
        $popularProducts = Product::aktif()
            ->with('category')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('user.home', compact('latestProducts', 'categories', 'popularProducts'));
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

        // Dalam implementasi nyata, ini akan mengirim email atau menyimpan ke database
        // Untuk demo, kita hanya redirect dengan pesan sukses

        return redirect()->back()->with(
            'success',
            'Terima kasih! Pesan Anda telah dikirim. Tim customer service kami akan segera menghubungi Anda.'
        );
    }

    public function about()
    {
        return view('user.about');
    }
}
