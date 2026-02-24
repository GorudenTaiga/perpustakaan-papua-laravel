<?php

namespace App\Http\Controllers;

use App\Models\BookReservation;
use App\Models\Buku;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        $member = Auth::user()->member;
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stock > 0) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Buku masih tersedia, silakan pinjam langsung.'], 422);
            }
            return redirect()->back()->with('error', 'Buku masih tersedia, silakan pinjam langsung.');
        }

        $existing = BookReservation::where('member_id', $member->membership_number)
            ->where('buku_id', $request->buku_id)
            ->where('status', 'waiting')
            ->first();

        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda sudah mereservasi buku ini.'], 422);
            }
            return redirect()->back()->with('error', 'Anda sudah mereservasi buku ini.');
        }

        BookReservation::create([
            'member_id' => $member->membership_number,
            'buku_id' => $request->buku_id,
            'status' => 'waiting',
        ]);

        Notification::create([
            'member_id' => $member->membership_number,
            'type' => 'reservation',
            'title' => 'Reservasi Buku',
            'message' => "Reservasi untuk buku \"{$buku->judul}\" berhasil. Kami akan memberitahu Anda saat buku tersedia.",
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Reservasi berhasil! Anda akan diberitahu saat buku tersedia.']);
        }
        return redirect()->back()->with('success', 'Reservasi berhasil! Anda akan diberitahu saat buku tersedia.');
    }

    public function cancel(Request $request)
    {
        $member = Auth::user()->member;

        $reservation = BookReservation::where('member_id', $member->membership_number)
            ->where('id', $request->reservation_id)
            ->where('status', 'waiting')
            ->firstOrFail();

        $reservation->update(['status' => 'cancelled']);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Reservasi berhasil dibatalkan.']);
        }
        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function index()
    {
        $member = Auth::user()->member;
        $reservations = BookReservation::where('member_id', $member->membership_number)
            ->with('buku')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.member.reservations', compact('reservations'));
    }
}
