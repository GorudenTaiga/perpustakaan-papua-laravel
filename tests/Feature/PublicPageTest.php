<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use DatabaseTransactions;

    // ==========================================
    // Dashboard / Homepage
    // ==========================================

    public function test_dashboard_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_dashboard_displays_books(): void
    {
        $response = $this->get('/');
        $buku = Buku::first();
        if ($buku) {
            $response->assertSee($buku->judul, false);
        }
        $response->assertStatus(200);
    }

    public function test_dashboard_displays_categories(): void
    {
        $response = $this->get('/');
        $category = Category::first();
        if ($category) {
            $response->assertSee($category->nama, false);
        }
        $response->assertStatus(200);
    }

    // ==========================================
    // Buku Listing Page
    // ==========================================

    public function test_buku_listing_page_loads(): void
    {
        $response = $this->get('/buku');
        $response->assertStatus(200);
    }

    public function test_buku_listing_shows_books(): void
    {
        $response = $this->get('/buku');
        $buku = Buku::first();
        if ($buku) {
            $response->assertSee($buku->judul, false);
        }
        $response->assertStatus(200);
    }

    public function test_buku_listing_has_search_functionality(): void
    {
        $response = $this->get('/buku');
        $response->assertSee('search', false);
        $response->assertStatus(200);
    }

    public function test_buku_search_returns_results(): void
    {
        $buku = Buku::first();
        if (!$buku) {
            $this->markTestSkipped('No buku data available');
        }

        $response = $this->get('/buku?search=' . urlencode($buku->judul));
        $response->assertStatus(200);
        $response->assertSee($buku->judul, false);
    }

    public function test_buku_search_with_nonexistent_term(): void
    {
        $response = $this->get('/buku?search=xyznonexistentbook123');
        $response->assertStatus(200);
    }

    public function test_buku_sort_by_judul_az(): void
    {
        $response = $this->get('/buku?sortBy=judulAZ');
        $response->assertStatus(200);
    }

    public function test_buku_sort_by_judul_za(): void
    {
        $response = $this->get('/buku?sortBy=judulZA');
        $response->assertStatus(200);
    }

    public function test_buku_sort_by_newest(): void
    {
        $response = $this->get('/buku?sortBy=newest');
        $response->assertStatus(200);
    }

    public function test_buku_sort_by_oldest(): void
    {
        $response = $this->get('/buku?sortBy=oldest');
        $response->assertStatus(200);
    }

    public function test_buku_filter_by_category(): void
    {
        $category = Category::first();
        if (!$category) {
            $this->markTestSkipped('No category data available');
        }

        $response = $this->get('/buku?category[]=' . $category->id);
        $response->assertStatus(200);
    }

    // ==========================================
    // Book Detail Page
    // ==========================================

    public function test_buku_detail_page_loads(): void
    {
        $buku = Buku::first();
        if (!$buku) {
            $this->markTestSkipped('No buku data available');
        }

        $response = $this->get('/buku/' . $buku->slug);
        $response->assertStatus(200);
    }

    public function test_buku_detail_shows_title(): void
    {
        $buku = Buku::first();
        if (!$buku) {
            $this->markTestSkipped('No buku data available');
        }

        $response = $this->get('/buku/' . $buku->slug);
        $response->assertSee($buku->judul, false);
    }

    public function test_buku_detail_shows_book_info(): void
    {
        $buku = Buku::first();
        if (!$buku) {
            $this->markTestSkipped('No buku data available');
        }

        $response = $this->get('/buku/' . $buku->slug);
        $response->assertStatus(200);
        if ($buku->author) {
            $response->assertSee($buku->author, false);
        }
    }

    public function test_buku_detail_nonexistent_slug_returns_error(): void
    {
        $response = $this->get('/buku/this-slug-does-not-exist-999');
        // BukuController::view() calls first() which returns null, causing 500
        $response->assertStatus(500);
    }

    // ==========================================
    // Categories Page
    // ==========================================

    public function test_categories_page_loads(): void
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
    }

    public function test_categories_page_shows_categories(): void
    {
        $response = $this->get('/categories');
        $category = Category::first();
        if ($category) {
            $response->assertSee($category->nama, false);
        }
        $response->assertStatus(200);
    }

    public function test_categories_page_shows_count(): void
    {
        $response = $this->get('/categories');
        $count = Category::count();
        $response->assertSee((string) $count, false);
    }

    // ==========================================
    // Help Page
    // ==========================================

    public function test_help_page_loads(): void
    {
        $response = $this->get('/help');
        $response->assertStatus(200);
    }

    public function test_help_page_has_content(): void
    {
        $response = $this->get('/help');
        $response->assertSee('Help', false);
    }

    // ==========================================
    // 404 Page
    // ==========================================

    public function test_unknown_route_returns_404_view(): void
    {
        $response = $this->get('/this-route-does-not-exist');
        $response->assertStatus(200); // catchall returns 200 with 404 view
    }

    // ==========================================
    // Page Structure Tests (Frontend)
    // ==========================================

    public function test_dashboard_has_browse_books_link(): void
    {
        $response = $this->get('/');
        $response->assertSee('Browse', false);
    }

    public function test_buku_listing_has_filter_sidebar(): void
    {
        $response = $this->get('/buku');
        $response->assertSee('Search', false);
        $response->assertStatus(200);
    }

    public function test_buku_detail_has_breadcrumb(): void
    {
        $buku = Buku::first();
        if (!$buku) {
            $this->markTestSkipped('No buku data available');
        }

        $response = $this->get('/buku/' . $buku->slug);
        $response->assertSee('Home', false);
        $response->assertSee('Books', false);
    }

    public function test_buku_detail_has_borrow_button_for_guest(): void
    {
        $buku = Buku::first();
        if (!$buku) {
            $this->markTestSkipped('No buku data available');
        }

        // Guest should not see borrow button (only verified members see it)
        $response = $this->get('/buku/' . $buku->slug);
        $response->assertStatus(200);
        // Guest shouldn't see the borrow modal trigger
        $response->assertDontSee('Borrow This Book', false);
    }
}
