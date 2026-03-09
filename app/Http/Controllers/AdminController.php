<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinjamanCounts = Pinjaman::selectRaw("
            COUNT(CASE WHEN status = 'dipinjam' THEN 1 END) as pinjam_count,
            COUNT(CASE WHEN status = 'dikembalikan' THEN 1 END) as kembalikan_count,
            COUNT(CASE WHEN status = 'jatuh_tempo' THEN 1 END) as jatuh_tempo_count
        ")->first();

        return view('pages.admin.index', [
            'username' => Auth::user()->name,
            'booksCount' => Buku::count(),
            'title' => 'Dashboard | Admin',
            'memberCount' => User::where('role', 'member')->count(),
            'pinjamCount' => $pinjamanCounts->pinjam_count,
            'kembalikanCount' => $pinjamanCounts->kembalikan_count,
            'jatuhTempoCount' => $pinjamanCounts->jatuh_tempo_count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}