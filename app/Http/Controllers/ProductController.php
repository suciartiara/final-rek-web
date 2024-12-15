<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(Request $request)
{
    // Gunakan query builder untuk pagination yang lebih fleksibel
    $products = Product::query()
        ->paginate(10)
        ->withQueryString(); // Mempertahankan query string
    
    return Inertia::render('Products/Index', [
        'products' => $products
    ]);
}
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable',
        'price' => 'required|numeric'
    ]);

    $product = Product::create($validated);

    // Hapus semua cache terkait produk
    Cache::tags('products')->flush();

    return redirect()->route('products.index')
        ->with('success', 'Produk berhasil dibuat');
}

    public function edit(Product $product)
    {
        $product = Product::getCachedProductById($product->id);
        
        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric'
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }
}