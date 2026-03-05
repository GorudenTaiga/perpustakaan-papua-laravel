<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $books = Buku::limit(15)->get();

        // Popular books - most borrowed
        $popularBooks = Buku::select(
                'buku.id', 'buku.uuid', 'buku.judul', 'buku.author', 'buku.publisher',
                'buku.year', 'buku.stock', 'buku.denda_per_hari', 'buku.deskripsi',
                'buku.slug', 'buku.category_id', 'buku.banner', 'buku.gdrive_link',
                'buku.created_at', 'buku.updated_at'
            )
            ->selectRaw('COUNT(pinjaman.id) as borrow_count')
            ->leftJoin('pinjaman', 'buku.id', '=', 'pinjaman.buku_id')
            ->groupBy(
                'buku.id', 'buku.uuid', 'buku.judul', 'buku.author', 'buku.publisher',
                'buku.year', 'buku.stock', 'buku.denda_per_hari', 'buku.deskripsi',
                'buku.slug', 'buku.category_id', 'buku.banner', 'buku.gdrive_link',
                'buku.created_at', 'buku.updated_at'
            )
            ->orderByDesc('borrow_count')
            ->limit(10)
            ->get();

        // New arrivals - last 30 days
        $newArrivals = Buku::where('created_at', '>=', now()->subDays(30))
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