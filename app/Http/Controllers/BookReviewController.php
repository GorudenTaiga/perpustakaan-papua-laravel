<?php

namespace App\Http\Controllers;

use App\Models\BookReview;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $member = Auth::user()->member;

        $hasBorrowed = Pinjaman::where('member_id', $member->membership_number)
            ->where('buku_id', $request->buku_id)
            ->exists();

        if (!$hasBorrowed) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda hanya bisa mereview buku yang pernah dipinjam.'], 403);
            }
            return redirect()->back()->with('error', 'Anda hanya bisa mereview buku yang pernah dipinjam.');
        }

        $review = BookReview::updateOrCreate(
            [
                'member_id' => $member->membership_number,
                'buku_id' => $request->buku_id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        if ($request->expectsJson()) {
            $buku = \App\Models\Buku::find($request->buku_id);
            $avgRating = BookReview::where('buku_id', $request->buku_id)->avg('rating');
            $reviewCount = BookReview::where('buku_id', $request->buku_id)->count();

            return response()->json([
                'success' => true,
                'message' => 'Review berhasil disimpan!',
                'review' => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'review' => $review->review,
                    'user_name' => Auth::user()->name,
                    'user_initial' => strtoupper(substr(Auth::user()->name, 0, 1)),
                    'created_at' => $review->created_at->diffForHumans(),
                    'is_update' => !$review->wasRecentlyCreated,
                ],
                'average_rating' => round($avgRating, 1),
                'review_count' => $reviewCount,
            ]);
        }
        return redirect()->back()->with('success', 'Review berhasil disimpan!');
    }

    public function destroy(Request $request)
    {
        $member = Auth::user()->member;

        BookReview::where('member_id', $member->membership_number)
            ->where('buku_id', $request->buku_id)
            ->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }
}
