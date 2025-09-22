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
        return view('pages.admin.index', [
            'username' => Auth::user()->name,
            'booksCount' => Buku::count(),
            'title' => 'Dashboard | Admin',
            'memberCount' => User::where('role', 'member')->count(),
            'pinjamCount' => Pinjaman::where('status', 'dipinjam')->count(),
            'kembalikanCount' => Pinjaman::where('status', 'dikembalikan')->count(),
            'jatuhTempoCount' => Pinjaman::where('status', 'jatuh_tempo')->count()
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