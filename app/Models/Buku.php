<?php

namespace App\Models;

use App\Http\Controllers\AssetController;
use App\Observers\BukuObserver;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Log;
use Storage;

#[ObservedBy(BukuObserver::class)]
class Buku extends Model
{
    /** @use HasFactory<\Database\Factories\BukuFactory> */
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'uuid',
        'judul',
        'author',
        'publisher',
        'year',
        'stock',
        'denda_per_hari',
        'deskripsi',
        'slug',
        'category_id',
        'banner',
    ];

    protected $casts = [
        'category_id' => 'array'
    ];

    protected $appends = [
        'banner_url',
    ];
    

    public function bannerUrl(): Attribute
    {
        return Attribute::get(fn () => $this->banner ? Storage::disk('public')->url($this->banner)  : '');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get categories for this book. Uses pre-loaded data if available to avoid N+1.
     */
    public function categories()
    {
        if ($this->relationLoaded('loadedCategories')) {
            return $this->loadedCategories;
        }
        return Category::whereIn('id', $this->category_id ?? [])->get();
    }

    /**
     * Pseudo-relationship to allow eager loading categories via controller.
     */
    public function loadedCategories()
    {
        return $this->belongsTo(Category::class, 'id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class, 'buku_id', 'id');
    }

    public function reservations()
    {
        return $this->hasMany(BookReservation::class, 'buku_id', 'id');
    }

    /**
     * Get average rating. Prefer pre-loaded reviews_avg_rating from withAvg().
     */
    public function averageRating(): Attribute
    {
        return Attribute::get(function () {
            if (array_key_exists('reviews_avg_rating', $this->attributes)) {
                return round((float) ($this->attributes['reviews_avg_rating'] ?? 0), 1);
            }
            if (array_key_exists('reviews_sum_rating', $this->attributes) && array_key_exists('reviews_count', $this->attributes)) {
                $count = (int) $this->attributes['reviews_count'];
                return $count > 0 ? round((float) $this->attributes['reviews_sum_rating'] / $count, 1) : 0;
            }
            return $this->reviews()->avg('rating') ?? 0;
        });
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'buku_id', 'id');
    }

    /**
     * Get review count. Prefer pre-loaded reviews_count from withCount().
     */
    public function reviewCount(): Attribute
    {
        return Attribute::get(function () {
            if (array_key_exists('reviews_count', $this->attributes)) {
                return (int) $this->attributes['reviews_count'];
            }
            return $this->reviews()->count();
        });
    }

    public function borrowCount(): Attribute
    {
        return Attribute::get(fn () => DB::table('pinjaman')->where('buku_id', $this->id)->count());
    }
}