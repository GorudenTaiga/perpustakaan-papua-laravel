<?php

namespace App\Models;

use App\Http\Controllers\AssetController;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Log;
use Storage;

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
        'gdrive_link'
    ];

    protected $casts = [
        'category_id' => 'array'
    ];

    protected $appends = [
        'banner_url',
        'average_rating',
        'review_count',
    ];
    

    public function bannerUrl(): Attribute
    {
        // return Attribute::get(fn () => $this->banner ? Storage::url($this->banner) : '');
        return Attribute::get(fn () => $this->banner ? Storage::disk('public')->url($this->banner)  : '');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
        // return Category::whereIn('id', $this->category_id ?? [])->get();
        // return $this->belongsToMany(Category::class, Buku::class);
    }

    public function categories()
    {
        return Category::whereIn('id', $this->category_id ?? [])->get();
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

    public function averageRating(): Attribute
    {
        return Attribute::get(fn () => $this->reviews()->avg('rating') ?? 0);
    }

    public function reviewCount(): Attribute
    {
        return Attribute::get(fn () => $this->reviews()->count());
    }

    public function borrowCount(): Attribute
    {
        return Attribute::get(fn () => DB::table('pinjaman')->where('buku_id', $this->id)->count());
    }
}