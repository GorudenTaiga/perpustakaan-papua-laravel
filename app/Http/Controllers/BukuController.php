<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Category;
use Arr;
use Illuminate\Http\Request;
use Str;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BukuRequest $request)
    {
        $buku = Buku::query()
            // Sorting
            ->when($request->query('sortBy'), function ($q, $sort) {
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
                    default:
                        $q->orderBy('created_at', 'desc');
                }
            })
            // Category filtering
            ->when($request->query('category', []), function ($q, $categories) {
                $categories = array_filter($categories); // Remove empty values
                if (!empty($categories) && !in_array('all', $categories)) {
                    foreach ($categories as $cat) {
                        $q->whereJsonContains('category_id', intval($cat));
                    }
                }
            })
            // Search
            ->when($request->query('search'), function ($q, $search) {
                $q->where(function($query) use ($search) {
                    $query->where('judul', 'like', '%' . $search . '%')
                          ->orWhere('author', 'like', '%' . $search . '%')
                          ->orWhere('publisher', 'like', '%' . $search . '%')
                          ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->paginate(24);
    
        // Use ultra modern view
        return view('pages.member.allBuku', [
            'buku' => $buku,
            'categories' => Category::all()
        ]);
    }

    public function allCategory() {
        $category = Category::all();

        return view('pages.member.allCategory', [
            'categories' => $category
        ]);
    }

    public function view($slug) {
        $buku = Buku::where('slug', $slug)->first();

        return view('pages.member.detail_product', [
            'buku' => $buku,
        ]);
    }
}