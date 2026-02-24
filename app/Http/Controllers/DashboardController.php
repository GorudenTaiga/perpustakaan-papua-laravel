<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $books = Buku::limit(15)->get();

        return view('pages.member.index', [
            'categories' => $categories,
            'books' => $books,
        ]);
    }
}