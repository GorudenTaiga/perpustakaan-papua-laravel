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
        $wishlist = auth()->user()->member->wishlist()->with('buku')->latest()->get();
        return view('pages.member.wishlist', compact('wishlist'));
    }

    public function partial()
    {
        if (!auth()->check()) {
            return response('<p>Silakan login untuk melihat wishlist.</p>');
        }

        $wishlist = auth()->user()->member->wishlist()->with('buku')->get();

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