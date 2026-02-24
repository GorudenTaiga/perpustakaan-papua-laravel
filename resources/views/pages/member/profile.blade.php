@extends('main_member')
@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 py-20 lg:py-28 pb-32">
        <div class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-b from-transparent to-white pointer-events-none z-10"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container relative mx-auto px-4">
            <div class="text-white space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-semibold">Profil Saya</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    My <span class="text-yellow-300">Profile</span>
                </h1>
                <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                    Kelola profil dan pantau aktivitas perpustakaan Anda.
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20">
        <div class="container mx-auto px-4">

            {{-- Profile Card --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-8" x-data="{ showPhotoModal: false }">
                <div class="flex flex-col lg:flex-row">
                    {{-- Profile Photo --}}
                    <div class="lg:w-80 flex-shrink-0 p-8 flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                        <div class="relative group">
                            <div class="w-48 h-64 lg:w-56 lg:h-72 rounded-2xl overflow-hidden shadow-2xl ring-4 ring-white">
                                <img src="{{ Storage::disk('public')->url($member->image) ?? asset('users/images/profile-placeholder.png') }}"
                                     alt="{{ $member->user->name }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <button @click="showPhotoModal = true"
                                    class="absolute bottom-3 right-3 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-indigo-600 hover:scale-110 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-4 text-xs text-gray-400">Klik ikon kamera untuk ubah foto</p>
                    </div>

                    {{-- Profile Info --}}
                    <div class="flex-1 p-8 lg:p-10">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">{{ $member->user->name }}</h2>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 uppercase">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        {{ $member->user->role }}
                                    </span>
                                    @if($member->verif)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Terverifikasi
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Belum Terverifikasi
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('cetakKTA', base64_encode($member->id)) }}" target="_blank"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold text-sm hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    Kartu Anggota
                                </a>
                                <a href="{{ route('logout') }}"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-red-200 text-red-600 rounded-xl font-semibold text-sm hover:bg-red-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </a>
                            </div>
                        </div>

                        {{-- Info Grid --}}
                        <div class="grid sm:grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Email</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $member->user->email }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">No. Anggota</p>
                                <p class="text-sm font-semibold text-gray-900 font-mono">{{ $member->membership_number }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Bergabung</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $member->user->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Terakhir Login</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $member->user->last_login_at?->diffForHumans() ?? '-' }}</p>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    <ul class="text-sm text-red-700 space-y-1">
                                        @foreach ($errors->all() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Photo Upload Modal (Alpine.js) --}}
                <div x-show="showPhotoModal" x-cloak style="display:none;" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showPhotoModal = false">
                    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showPhotoModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                    <div class="flex min-h-screen items-center justify-center p-4">
                        <div x-show="showPhotoModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                             class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden" @click.stop>
                            <form id="cropForm" action="{{ route('member.updatePhoto') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Upload & Crop Foto
                                        </h3>
                                        <button type="button" @click="showPhotoModal = false" class="text-white hover:text-gray-200 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-6 space-y-4">
                                    <input type="file" id="uploadImage" name="image" accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer">
                                    <div class="rounded-2xl overflow-hidden">
                                        <img id="imagePreview" class="max-w-full hidden">
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                                    <button type="button" @click="showPhotoModal = false" class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
                                        Simpan Foto
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            @php
                $totalBorrowed = \App\Models\Pinjaman::where('member_id', $member->membership_number)->count();
                $activeLoans = \App\Models\Pinjaman::where('member_id', $member->membership_number)->whereIn('status', ['dipinjam', 'menunggu_verif'])->count();
                $returnedBooks = \App\Models\Pinjaman::where('member_id', $member->membership_number)->where('status', 'dikembalikan')->count();
                $reviewCount = \App\Models\BookReview::where('member_id', $member->membership_number)->count();
                $reservationCount = \App\Models\BookReservation::where('member_id', $member->membership_number)->where('status', 'waiting')->count();
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl p-5 text-white text-center shadow-lg">
                    <p class="text-3xl font-bold">{{ $totalBorrowed }}</p>
                    <p class="text-xs font-medium text-white/80 mt-1">Total Pinjaman</p>
                </div>
                <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-3xl p-5 text-white text-center shadow-lg">
                    <p class="text-3xl font-bold">{{ $activeLoans }}</p>
                    <p class="text-xs font-medium text-white/80 mt-1">Pinjaman Aktif</p>
                </div>
                <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-3xl p-5 text-white text-center shadow-lg">
                    <p class="text-3xl font-bold">{{ $returnedBooks }}</p>
                    <p class="text-xs font-medium text-white/80 mt-1">Buku Selesai</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-3xl p-5 text-white text-center shadow-lg">
                    <p class="text-3xl font-bold">{{ $reviewCount }}</p>
                    <p class="text-xs font-medium text-white/80 mt-1">Ulasan</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-5 text-white text-center shadow-lg">
                    <p class="text-3xl font-bold">{{ $reservationCount }}</p>
                    <p class="text-xs font-medium text-white/80 mt-1">Reservasi</p>
                </div>
                <div class="bg-gradient-to-br from-violet-500 to-fuchsia-600 rounded-3xl p-5 text-white text-center shadow-lg">
                    <p class="text-3xl font-bold">{{ $member->wishlist->count() }}</p>
                    <p class="text-xs font-medium text-white/80 mt-1">Wishlist</p>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
                <a href="{{ route('pinjam') }}" class="group bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="font-semibold text-gray-900 text-sm">Peminjaman Saya</span>
                    </div>
                </a>
                <a href="{{ route('readingHistory') }}" class="group bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-green-200 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-semibold text-gray-900 text-sm">Riwayat Baca</span>
                    </div>
                </a>
                <a href="{{ route('wishlist.index') }}" class="group bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-pink-200 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center group-hover:bg-pink-200 transition-colors relative">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            @if($member->wishlist->count() > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-pink-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $member->wishlist->count() }}</span>
                            @endif
                        </div>
                        <span class="font-semibold text-gray-900 text-sm">Wishlist</span>
                    </div>
                </a>
                <a href="{{ route('reservations') }}" class="group bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-amber-200 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <span class="font-semibold text-gray-900 text-sm">Reservasi Buku</span>
                    </div>
                </a>
                <a href="{{ route('notifications') }}" class="group bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-purple-200 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="font-semibold text-gray-900 text-sm">Notifikasi</span>
                    </div>
                </a>
            </div>

            {{-- Recent Loan History --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Riwayat Peminjaman Terakhir
                        </h2>
                        <a href="{{ route('pinjam') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-lg font-semibold hover:bg-white/30 transition-all border border-white/30 text-sm">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                @if($pinjaman->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach ($pinjaman->take(5) as $loan)
                            <div class="p-5 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('buku', $loan->buku->slug) }}" class="flex-shrink-0">
                                        <img src="{{ $loan->buku->banner_url }}" alt="{{ $loan->buku->judul }}"
                                             class="w-12 h-16 object-cover rounded-xl shadow">
                                    </a>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('buku', $loan->buku->slug) }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition-colors text-sm line-clamp-1">{{ $loan->buku->judul }}</a>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</p>
                                    </div>
                                    @php
                                        $sColors = [
                                            'menunggu_verif' => 'bg-yellow-100 text-yellow-700',
                                            'dipinjam' => 'bg-blue-100 text-blue-700',
                                            'dikembalikan' => 'bg-green-100 text-green-700',
                                            'terlambat' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $sColors[$loan->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ Str::of($loan->status)->replace('_', ' ')->title() }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Peminjaman</h3>
                        <p class="text-sm text-gray-500 mb-4">Mulai jelajahi koleksi buku dan pinjam buku pertamamu!</p>
                        <a href="{{ route('allBuku') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
                            Jelajahi Buku
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        let cropper;
        const uploadImage = document.getElementById('uploadImage');
        const imagePreview = document.getElementById('imagePreview');
        const cropForm = document.getElementById('cropForm');

        uploadImage.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    imagePreview.style.display = 'block';

                    if (cropper) cropper.destroy();
                    cropper = new Cropper(imagePreview, {
                        viewMode: 1,
                        width: 478,
                        height: 770
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        cropForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!cropper) {
                cropForm.submit();
                return;
            }

            cropper.getCroppedCanvas({
                width: 478,
                height: 770,
            }).toBlob((blob) => {
                const file = new File([blob], 'cropped.png', { type: 'image/png' });
                const formData = new FormData(cropForm);
                formData.set('image', file);
                formData.set('_method', 'PUT');

                fetch(cropForm.action, { method: 'POST', body: formData })
                    .then(res => {
                        if (res.redirected) {
                            window.location.href = res.url;
                        } else {
                            return res.json();
                        }
                    })
                    .then(data => {
                        if (data?.success) location.reload();
                    })
                    .catch(err => console.error(err));
            });
        });
    </script>
@endsection
