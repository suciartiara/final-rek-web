<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    // Waktu cache yang konsisten
    const CACHE_DURATION = 3600; // 1 jam

    // Metode untuk generate cache key yang konsisten
    protected static function getCacheKey($type, $identifier = null)
    {
        $page = request()->get('page', 1);
        return match($type) {
            'list' => "products_list_page_{$page}",
            'single' => "product_{$identifier}",
            default => throw new \InvalidArgumentException("Invalid cache type")
        };
    }

    // Metode untuk mendapatkan produk dengan caching Redis
    public static function getCachedProducts($perPage = 10)
    {
        $cacheKey = self::getCacheKey('list');

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($perPage) {
            return self::query()
                ->paginate($perPage)
                ->withQueryString(); // Mempertahankan query string
        });
    }

    // Metode untuk mendapatkan produk tunggal dengan caching Redis
    public static function getCachedProductById($id)
    {
        $cacheKey = self::getCacheKey('single', $id);

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($id) {
            return self::findOrFail($id);
        });
    }

    // Metode untuk menghapus cache secara menyeluruh
    public function clearAllProductCache()
    {
        // Hapus cache list produk untuk semua halaman
        for ($page = 1; $page <= 10; $page++) {
            Cache::forget("products_list_page_{$page}");
        }

        // Hapus cache produk spesifik
        Cache::forget("product_{$this->id}");
    }

    // Override metode save untuk menghapus cache
    public function save(array $options = [])
    {
        $saved = parent::save($options);
        $this->clearAllProductCache();
        return $saved;
    }

    // Override metode delete untuk menghapus cache
    public function delete()
    {
        $this->clearAllProductCache();
        return parent::delete();
    }
}