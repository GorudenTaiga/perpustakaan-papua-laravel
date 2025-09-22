<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BookDetailController extends Controller
{
    /**
     * Display book detail for members.
     */
    public function show($slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();

        // Load the book with its categories
        $buku->load('categories');

        return view('pages.member.detail_product', [
            'buku' => $buku,
            'titleBuku' => $buku->judul,
            'author' => $buku->author,
            'publisher' => $buku->publisher,
            'year' => $buku->year,
            'pricePerDay' => $buku->price_per_day,
            'rating' => $buku->rating ?? 0,
            'deskripsi' => $buku->deskripsi,
            'category' => $buku->categories,
            'images' => $buku->images ?? []
        ]);
    }
}