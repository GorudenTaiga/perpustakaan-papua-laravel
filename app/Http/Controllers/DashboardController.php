<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('all_categories', 300, fn () => Category::all());

        $books = Buku::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->limit(15)
            ->get();

        // Popular books - most borrowed (using subquery instead of verbose GROUP BY)
        $popularBooks = Buku::withCount(['pinjaman as borrow_count'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('borrow_count')
            ->limit(10)
            ->get();

        // New arrivals - last 30 days
        $newArrivals = Buku::where('created_at', '>=', now()->subDays(30))
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('pages.member.index', [
            'categories' => $categories,
            'books' => $books,
            'popularBooks' => $popularBooks,
            'newArrivals' => $newArrivals,
        ]);
    }
}