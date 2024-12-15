<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    // Metode untuk mendapatkan produk dengan caching Redis
    public static function getCachedProducts($perPage = 10)
{
    // Gunakan parameter page dari request
    $page = request()->get('page', 1);
    
    // Buat cache key unik berdasarkan halaman
    $cacheKey = "products_list_page_{$page}";

    return Cache::remember($cacheKey, 3600, function () use ($perPage) {
        return self::paginate($perPage);
    });
}

    // Metode untuk mendapatkan produk tunggal dengan caching Redis
    public static function getCachedProductById($id)
    {
        return Cache::remember("product_{$id}", 3600, function () use ($id) {
            return self::findOrFail($id);
        });
    }

    // Metode untuk menghapus cache saat data berubah
    public function clearCache()
    {
        Cache::forget('products_list');
        Cache::forget("product_{$this->id}");
    }

    // Override metode save untuk menghapus cache
    public function save(array $options = [])
    {
        $saved = parent::save($options);
        $this->clearCache();
        return $saved;
    }

    // Override metode delete untuk menghapus cache
    public function delete()
    {
        $this->clearCache();
        return parent::delete();
    }

}