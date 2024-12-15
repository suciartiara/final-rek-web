<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::getCachedProducts();
        
        return Inertia::render('Products/Index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        
        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dibuat');
    }

    public function show(Product $product)
    {
        $product = Product::getCachedProductById($product->id);
        
        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        $product = Product::getCachedProductById($product->id);
        
        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $validated = $request->validated();

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
}