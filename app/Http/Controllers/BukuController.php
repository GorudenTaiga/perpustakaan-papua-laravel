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
        $buku = Buku::
            when($request->query('sortBy'), function ($q, $sort) {
                if ($sort == 'judulAZ') {
                    $q->orderBy('judul', 'asc');
                } else if ($sort == 'judulZA') {
                    $q->orderBy('judul', 'desc');
                } else if ($sort == 'rateH') {
                    $q->orderBy('rating', 'desc');
                } else if ($sort == 'rateL') {
                    $q->orderBy('rating', 'asc');
                } else {
                    $q->orderBy('created_at', 'asc');
                }
            })
            ->when($request->query('category', []), function ($q, $categories) {
                // dd(['Categories: ' => $categories]);
                foreach ($categories as $cat) {
                    $q->orWhereJsonContains('category_id', $cat);
                    dd(['Kategori: ' => $cat]);
                    dd(['Data: ' => $q]);
                }
            })
            ->when($request->query('search'), function ($q, $search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%'.$search.'%')
                ->orWhere('publisher', 'like', '%'.$search.'%');
        })
        ->paginate(25);
    
        return view('pages.member.allBuku', [
            'buku' => $buku,
            'categories' => Category::all()
        ]);

        // return dd($request->query());
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