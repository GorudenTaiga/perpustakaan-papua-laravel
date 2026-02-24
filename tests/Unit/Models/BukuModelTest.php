<?php

namespace Tests\Unit\Models;

use App\Models\Buku;
use App\Models\Category;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BukuModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_buku_has_correct_fillable_fields(): void
    {
        $buku = new Buku();
        $expected = [
            'uuid', 'judul', 'author', 'publisher', 'year',
            'stock', 'denda_per_hari', 'deskripsi', 'slug',
            'category_id', 'banner', 'gdrive_link'
        ];
        $this->assertEquals($expected, $buku->getFillable());
    }

    public function test_buku_casts_category_id_to_array(): void
    {
        $buku = new Buku();
        $casts = $buku->getCasts();
        $this->assertArrayHasKey('category_id', $casts);
        $this->assertEquals('array', $casts['category_id']);
    }

    public function test_buku_uses_slug_for_route_key(): void
    {
        $buku = new Buku();
        $this->assertEquals('slug', $buku->getRouteKeyName());
    }

    public function test_buku_has_banner_url_appended(): void
    {
        $buku = new Buku();
        $this->assertContains('banner_url', $buku->getAppends());
    }

    public function test_buku_has_category_relationship(): void
    {
        $buku = Buku::first();
        $this->assertNotNull($buku);
        $relation = $buku->category();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_buku_categories_method_returns_collection(): void
    {
        $buku = Buku::first();
        $this->assertNotNull($buku);
        $categories = $buku->categories();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $categories);
    }

    public function test_buku_table_name_is_buku(): void
    {
        $buku = new Buku();
        $this->assertEquals('buku', $buku->getTable());
    }

    public function test_first_buku_exists_in_database(): void
    {
        $buku = Buku::first();
        $this->assertNotNull($buku);
        $this->assertNotEmpty($buku->judul);
        $this->assertNotEmpty($buku->slug);
    }
}
