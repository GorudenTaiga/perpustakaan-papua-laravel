<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = Member::where('membership_number', Auth::user()->member->membership_number)->with('user')->first();
        if ($member) {
            return view('pages.member.profile', [
                'member' => $member,
                'pinjaman' => Pinjaman::where('member_id', Auth::user()->member->membership_number)->with('buku')->get()
            ]);
        }
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
            'quantity' => 'required|min:1|max:'.$stock
        ]);

        if ($valid && Auth::check() && Auth::user()->role == 'member' && Auth::user()->member->verif) {
            $create = Pinjaman::create([
                'member_id' => Auth::user()->member->membership_number,
                'buku_id' => $request->buku_id,
                'loan_date' => Carbon::now()->toDateString(),
                'due_date' => Carbon::now()->addDays(7)->toDateString(),
                'quantity' => $request->quantity,
                'status' => 'menunggu_verif',
                'verif' => false,
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
            ->setPaper([0, 0, 157.68, 300], 'landscape'); 
            // 8.6cm x 5.4cm dalam point (1cm = 28.35pt)

        return $pdf->stream("kartu-anggota-{$member->id}.pdf");
    }


    public function login(Request $request) 
    {
        if ($request->all()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::user()->role == 'admin') {
                    return redirect()->route('adminDashboard');
                }
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('error', 'Wrong Email or Password. Please Try Again');
            }
        }
        return view('login');
        
    }

    public function updatePhoto(Request $request)
    {
        $valid = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'image.required' => 'Harap upload gambar terlebih dahulu',
            'image.mimes' => 'Harap upload hanya berformat jpg, jpeg, dan png',
            'image.max' => 'Ukuran gambar maksimal 2MB / 2048KB'
        ]);

        if ($valid) {
            $member = auth()->user()->member;

            // simpan file ke storage/app/public/images/member/foto/
            $path = $request->file('image')->store('images/member/foto', 'public');

            // hapus foto lama kalau ada
            if ($member->image && Storage::disk('public')->exists($member->image)) {
                Storage::disk('public')->delete($member->image);
            }

            // update kolom image
            if ($member->update(['image' => $path])) {
                return back()->with('success', 'Foto profil berhasil diperbarui!');
            }
        }
        return back();
    }

    public function register(Request $request) 
    {
        if ($request->isMethod('post')) {
            $validate = $request->validate([
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:6'],
                'name' => ['required'],
                'document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            ]);
            $validate['role'] = 'member';
            
            if ($validate) {
                if ($user = User::create($validate)) {
                    $documentPath = null;
                    
                    // Upload document if provided
                    if ($request->hasFile('document')) {
                        $documentPath = $request->file('document')->store('documents/members', 'public');
                    }
                    
                    if(Member::create([
                        'jenis' => $request->jenis,
                        'users_id' => $user->id,
                        'membership_number' => strtotime($user->created_at),
                        'document_path' => $documentPath
                    ])) {
                        return redirect()->back()->with('success', 'Register berhasil');
                    }
                }
            }
        }
        
        return view('auth.register');
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