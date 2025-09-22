<?php

namespace App\Models;

use App\Http\Controllers\AssetController;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'price_per_day',
        'max_days',
        'deskripsi',
        'slug',
        'category_id',
        'rating',
        'banner'
    ];

    protected $casts = [
        'category_id' => 'array'
    ];

    protected $appends = [
        'banner_url'
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
}