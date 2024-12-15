<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Tambahkan ini untuk menggunakan Redis
use Inertia\Inertia;

class ProductController extends Controller
{
    // Menggunakan Redis untuk caching produk di index
    public function index(Request $request)
    {
        // Cek apakah data produk sudah ada di cache
        $products = Cache::remember('products_page_' . $request->page, 60, function () use ($request) {
            return Product::query()
                ->paginate(10)
                ->withQueryString(); // Mempertahankan query string
        });
        
        return Inertia::render('Products/Index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    // Menambahkan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric'
        ]);

        $product = Product::create($validated);

        // Hapus cache produk setelah menambah data
        Cache::tags('products')->flush(); // Menghapus cache produk

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dibuat');
    }

    // Menampilkan halaman edit produk
    public function edit(Product $product)
    {
        // Cek jika produk sudah ada di cache
        $product = Cache::remember("product_{$product->id}", 60, function () use ($product) {
            return Product::findOrFail($product->id); // Ambil produk dari database jika tidak ada di cache
        });
        
        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    // Memperbarui produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric'
        ]);

        $product->update($validated);

        // Menghapus cache setelah update produk
        Cache::tags('products')->flush();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        $product->delete();

        // Menghapus cache produk setelah dihapus
        Cache::tags('products')->flush();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    // Menampilkan detail produk
    public function show(Product $product)
    {
        // Menambahkan caching untuk halaman show produk
        $product = Cache::remember("product_show_{$product->id}", 60, function () use ($product) {
            return $product; // Menyimpan produk di Redis untuk halaman show
        });

        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }
}
