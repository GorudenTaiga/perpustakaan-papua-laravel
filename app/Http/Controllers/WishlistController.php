<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Toggle wishlist (add/remove)
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $member = auth()->user()->member;
        if (!$member) {
            return response()->json(['error' => 'Member not found'], 403);
        }

        $existing = $member->wishlist()->where('buku_id', $request->buku_id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['success' => true, 'removed' => true, 'message' => 'Removed from wishlist']);
        }

        $member->wishlist()->create([
            'buku_id' => $request->buku_id,
        ]);

        return response()->json(['success' => true, 'added' => true, 'message' => 'Added to wishlist']);
    }

    public function index()
    {
        $member = auth()->user()->member;
        
        // Get wishlist with eager loaded buku and reviews aggregate
        $wishlist = $member->wishlist()
            ->with(['buku' => function($query) {
                $query->withAvg('reviews', 'rating')
                      ->withCount('reviews');
            }])
            ->latest()
            ->get();
        
        // Pre-load all categories in one query to avoid N+1
        $categoryIds = $wishlist->pluck('buku.category_id')
            ->flatten()
            ->filter()
            ->unique()
            ->values()
            ->all();
        
        if (!empty($categoryIds)) {
            $categories = \App\Models\Category::whereIn('id', $categoryIds)->get()->keyBy('id');
            
            // Attach categories to each book
            foreach ($wishlist as $item) {
                if ($item->buku) {
                    $bookCategories = collect($item->buku->category_id ?? [])
                        ->map(fn($id) => $categories->get($id))
                        ->filter();
                    $item->buku->setRelation('loadedCategories', $bookCategories);
                }
            }
        }
        
        return view('pages.member.wishlist', compact('wishlist'));
    }

    public function partial()
    {
        if (!auth()->check()) {
            return response('<p>Silakan login untuk melihat wishlist.</p>');
        }

        // Eager load buku with reviews aggregate to avoid N+1
        $wishlist = auth()->user()->member->wishlist()
            ->with(['buku' => function($query) {
                $query->withAvg('reviews', 'rating')
                      ->withCount('reviews');
            }])
            ->latest()
            ->get();

        return view('partials.wishlist', compact('wishlist'));
    }

    /**
     * Remove from wishlist
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $member = auth()->user()->member;
        $member->wishlist()->where('buku_id', $request->buku_id)->delete();

        return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
    }
}