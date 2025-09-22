<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pinjaman;
use App\Models\Pinjaman_item;
use App\Models\Buku;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        // Get top 5 books with highest ratings
        $topRatedBooks = Buku::orderBy('rating', 'desc')
            ->take(5)
            ->get();

        $books = Buku::limit(15)->get();

        // return dd($books);
        return view('pages.member.index', [
            'categories' => $categories,
            'topRatedBooks' => $topRatedBooks,
            'books' => $books
        ]);
    }
}