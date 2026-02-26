<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\BookReview;
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
                        $q->orWhereJsonContains('category_id', intval($cat));
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
            ->paginate(24)
            ->withQueryString();
    
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

        // Get related books based on same categories
        $relatedBooks = collect();
        if ($buku && $buku->category_id) {
            $relatedBooks = Buku::where('id', '!=', $buku->id)
                ->where(function ($query) use ($buku) {
                    foreach ($buku->category_id as $catId) {
                        $query->orWhereJsonContains('category_id', $catId);
                    }
                })
                ->limit(6)
                ->get();
        }

        // Get reviews for this book
        $reviews = $buku ? $buku->reviews()->with('member.user')->latest()->get() : collect();

        return view('pages.member.detail_product', [
            'buku' => $buku,
            'relatedBooks' => $relatedBooks,
            'reviews' => $reviews,
        ]);
    }

    /**
     * Baca buku digital via Google Drive embed (khusus premium).
     */
    public function read($slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();

        if (!$buku->gdrive_link) {
            abort(404, 'Buku ini tidak tersedia dalam format digital.');
        }

        $member = auth()->user()->member ?? null;

        if (!$member || !$member->isPremium()) {
            return redirect()->route('buku', $slug)
                ->with('error', 'Fitur baca digital hanya tersedia untuk member Premium.');
        }

        $embedUrl = $this->getGdriveEmbedUrl($buku->gdrive_link);

        if (!$embedUrl) {
            return redirect()->route('buku', $slug)
                ->with('error', 'Link Google Drive tidak valid.');
        }

        return view('pages.member.reader', [
            'buku' => $buku,
            'embedUrl' => $embedUrl,
        ]);
    }

    /**
     * Konversi link Google Drive ke URL embed/preview.
     */
    private function getGdriveEmbedUrl(string $url): ?string
    {
        // Format: https://drive.google.com/file/d/{FILE_ID}/view
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
        }

        // Format: https://drive.google.com/open?id={FILE_ID}
        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
        }

        // Format: https://docs.google.com/document/d/{FILE_ID}/...
        if (preg_match('/\/document\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://docs.google.com/document/d/' . $matches[1] . '/preview';
        }

        // Format: https://docs.google.com/spreadsheets/d/{FILE_ID}/...
        if (preg_match('/\/spreadsheets\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://docs.google.com/spreadsheets/d/' . $matches[1] . '/preview';
        }

        // Format: https://docs.google.com/presentation/d/{FILE_ID}/...
        if (preg_match('/\/presentation\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://docs.google.com/presentation/d/' . $matches[1] . '/embed?start=false&loop=false';
        }

        return null;
    }
}