<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\BookReview;
use App\Models\Category;
use App\Helpers\DatabaseHelper;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Str;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BukuRequest $request)
    {
        $buku = Buku::query()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            // Sorting
            ->when($request->query('sortBy', 'ratingDesc'), function ($q, $sort) {
                switch ($sort) {
                    case 'judulAZ':
                        $q->orderBy('judul', 'asc');
                        break;
                    case 'judulZA':
                        $q->orderBy('judul', 'desc');
                        break;
                    case 'newest':
                        $q->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $q->orderBy('created_at', 'asc');
                        break;
                    case 'ratingDesc':
                        $q->orderByRaw('reviews_avg_rating DESC NULLS LAST');
                        break;
                    case 'ratingAsc':
                        $q->orderByRaw('reviews_avg_rating ASC NULLS FIRST');
                        break;
                }
            })
            // Category filtering
            ->when($request->query('category', []), function ($q, $categories) {
                $categories = array_filter($categories); // Remove empty values
                if (!empty($categories) && !in_array('all', $categories)) {
                    $q->where(function ($query) use ($categories) {
                        foreach ($categories as $cat) {
                            $query->orWhereJsonContains('category_id', intval($cat));
                        }
                    });
                }
            })
            // Search
            ->when($request->query('search'), function ($q, $search) {
                $like = DatabaseHelper::likeOperator();
                $q->where(function($query) use ($search, $like) {
                    $query->where('judul', $like, '%' . $search . '%')
                          ->orWhere('author', $like, '%' . $search . '%')
                          ->orWhere('publisher', $like, '%' . $search . '%')
                          ->orWhere('deskripsi', $like, '%' . $search . '%');
                });
            })
            ->paginate(24)
            ->withQueryString();
    
        $categories = Cache::remember('all_categories', 300, fn () => Category::all());

        return view('pages.member.allBuku', [
            'buku' => $buku,
            'categories' => $categories
        ]);
    }

    public function allCategory() {
        $category = Cache::remember('all_categories', 300, fn () => Category::all());

        return view('pages.member.allCategory', [
            'categories' => $category
        ]);
    }

    public function view($slug) {
        $buku = Buku::where('slug', $slug)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->first();

        // Get related books based on same categories
        $relatedBooks = collect();
        if ($buku && $buku->category_id) {
            $relatedBooks = Buku::where('id', '!=', $buku->id)
                ->where(function ($query) use ($buku) {
                    foreach ($buku->category_id as $catId) {
                        $query->orWhereJsonContains('category_id', $catId);
                    }
                })
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->limit(6)
                ->get();
        }

        // Get reviews with eager loaded relationships
        $reviews = $buku ? $buku->reviews()->with('member.user')->latest()->get() : collect();

        return view('pages.member.detail_product', [
            'buku' => $buku,
            'relatedBooks' => $relatedBooks,
            'reviews' => $reviews,
        ]);
    }
}