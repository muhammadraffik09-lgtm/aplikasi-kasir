<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar produk
   public function index()
{
    $products = Product::latest()->get();
   return view('products.index', compact('products'));
}
    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price'  => 'required|numeric',
            'stock'          => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}