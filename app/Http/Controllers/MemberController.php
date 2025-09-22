<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MemberController extends Controller
{
    /**
     * Display the member dashboard with books.
     */
    public function index()
    {
        $books = Buku::with('category')->paginate(12); // Paginate for grid display
        return Inertia::render('Dashboard', [
            'title' => 'Dashboard',
            'books' => $books,
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }
}