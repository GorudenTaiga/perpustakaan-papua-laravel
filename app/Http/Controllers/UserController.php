<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function peminjaman() {
        $pinjaman = Pinjaman::where('member_id', Auth::user()->member->membership_number)->with(['buku', 'member'])->get();
        return view('pages.member.peminjaman', [
            'pinjaman' => $pinjaman
        ]);
    }

    public function pinjam(Request $request) {
        $stock = Buku::select('stock')->where('id', $request->buku_id)->value('stock');
        $valid = $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date',
            'quantity' => 'required|min:1|max:'.$stock
        ]);

        if ($valid) {
            $create = Pinjaman::create([
                'member_id' => Auth::user()->member->membership_number,
                'buku_id' => $request->buku_id,
                'loan_date' => $request->loan_date,
                'due_date' => $request->due_date,
                'quantity' => $request->quantity,
                'status' => 'dipinjam',
                'total_price' => 0
            ]);
            if ($create) {
                return redirect()->back()->with('success', 'Buku telah berhasil di pinjam');
            }
        }
        return redirect()->back()->with('Error', 'Buku gagal dipinjam');
    }

    public function cetakKTA($id)
    {
        $id = base64_decode($id);
        $member = Member::findOrFail($id);

        $pdf = Pdf::loadView('pages.member.kartuAnggota', compact('member'))
            ->setPaper([0, 0, 250.78, 300], 'landscape'); 
            // 8.6cm x 5.4cm dalam point (1cm = 28.35pt)

        return $pdf->stream("kartu-anggota-{$member->id}.pdf");
    }


    public function login(Request $request) 
    {
        if ($request->all()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::user()->role == 'admin') {
                    return redirect()->route('adminDashboard')->with([
                        'user' => Auth::user()
                    ]);
                }
                return redirect()->route('dashboard')->with([
                    'user' => Auth::user()
                ]);
            } else {
                return redirect()->back()->with('error', 'Wrong Email or Password. Please Try Again');
            }
        }
        return view('login');
        
    }

    public function register(Request $request) 
    {
        if ($request->all()) {
            $validate = $request->validate([
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:6'],
                'name' => ['required'],
                'role' => ['required']
            ]);
            if ($validate) {
                if (User::create($validate)) {
                    return redirect()->back()->with('success', 'Register berhasil');
                }
            }
        }
        return view('register');
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