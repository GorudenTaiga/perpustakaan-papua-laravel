@extends('main_member')
@section('content')
    {{-- Breadcrumb Section --}}
    <section class="bg-gradient-to-br from-indigo-50 to-purple-50 py-8">
        <div class="container mx-auto px-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Beranda
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('allBuku') }}"
                    class="text-gray-600 hover:text-indigo-600 transition-colors font-medium">Buku</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-semibold">{{ Str::limit($buku->judul, 50) }}</span>
            </nav>
        </div>
    </section>

    {{-- Book Detail Section --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12">
                {{-- Book Image --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <div
                            class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl overflow-hidden shadow-2xl border border-gray-200 group">
                            <div class="aspect-[3/4] relative overflow-hidden">
                                <img src="{{ $buku->image ? asset('storage/' . $buku->image) : asset('images/placeholder.png') }}"
                                    alt="{{ $buku->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-bold rounded-full shadow-xl">
                                        {{ $buku->tahun ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Book Info --}}
                <div class="lg:col-span-1">
                    <div class="space-y-6">
                        {{-- Title and Rating --}}
                        <div class="space-y-4">
                            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                                {{ $buku->judul }}
                            </h1>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-4" x-data="{ showModal: false, loading: false, quantity: 1 }">
                            @if (Auth::check() && Auth::user()->role == 'member' && Auth::user()->member->verif)
                                <button type="button" @click="showModal = true"
                                    class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Pinjam Buku Ini
                                </button>

                                {{-- Tailwind Modal --}}
                                <div x-show="showModal" 
                                     x-cloak
                                     style="display: none;"
                                     @keydown.escape.window="showModal = false"
                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                     aria-labelledby="modal-title" 
                                     role="dialog" 
                                     aria-modal="true">
                                    {{-- Backdrop --}}
                                    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                                         @click="showModal = false"
                                         x-show="showModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"></div>

                                    {{-- Modal Panel --}}
                                    <div class="flex min-h-screen items-center justify-center p-4">
                                        <div x-show="showModal"
                                             x-transition:enter="ease-out duration-300"
                                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave="ease-in duration-200"
                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
                                             @click.stop>
                                            
                                            <form @submit.prevent="
                                                loading = true;
                                                ajaxForm('{{ route('pinjam.store') }}', 'POST', { buku_id: {{ $buku->id }}, quantity: quantity }, '{{ csrf_token() }}')
                                                    .then(res => {
                                                        $dispatch('show-toast', { message: res.message, type: 'success' });
                                                        showModal = false;
                                                        setTimeout(() => location.reload(), 1500);
                                                    })
                                                    .catch(err => {
                                                        $dispatch('show-toast', { message: err.message || 'Gagal meminjam buku', type: 'error' });
                                                    })
                                                    .finally(() => loading = false);
                                            ">
                                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                                                {{-- Modal Header --}}
                                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                                </path>
                                                            </svg>
                                                            Pinjam Buku
                                                        </h3>
                                                        <button type="button" @click="showModal = false"
                                                            class="text-white hover:text-gray-200 transition-colors">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Modal Body --}}
                                                <div class="p-6 space-y-4">
                                                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-4">
                                                        <p class="text-sm text-gray-700 font-semibold">{{ $buku->judul }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">oleh {{ $buku->author }}</p>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <label for="jumlah" class="block text-sm font-bold text-gray-900">Jumlah Buku</label>
                                                        <input type="number" id="jumlah" name="quantity" x-model.number="quantity"
                                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                                            min="1" max="{{ $buku->stock ?? 1 }}" value="1" required>
                                                        @error('quantity')
                                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                                        @enderror
                                                        <p class="text-xs text-gray-500 mt-1">Stok tersedia: {{ $buku->stock ?? 0 }} buku</p>
                                                    </div>
                                                </div>

                                                {{-- Modal Footer --}}
                                                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                                                    <button type="button" @click="showModal = false"
                                                        class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-colors">
                                                        Batal
                                                    </button>
                                                    <button type="submit" :disabled="loading"
                                                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl disabled:opacity-50 flex items-center gap-2">
                                                        <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                        <span x-text="loading ? 'Memproses...' : 'Konfirmasi Peminjaman'"></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @elseif (Auth::check() && Auth::user()->role == 'member' && !Auth::user()->member->verif)
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center gap-3 px-8 py-4 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    Akun Belum Diverifikasi
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Masuk untuk Meminjam
                                </a>
                            @endif
                        </div>

                        {{-- Book Meta Information --}}
                        <div
                            class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 space-y-4 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Buku</h3>

                            <div class="grid gap-4">
                                {{-- Author --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Penulis</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $buku->author ?? 'Tidak diketahui' }}</p>
                                    </div>
                                </div>

                                {{-- Publisher --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Penerbit</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $buku->publisher ?? 'Tidak diketahui' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Year --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Tahun Terbit</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $buku->tahun ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                {{-- Categories --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Kategori</p>
                                        <div class="flex flex-wrap gap-2 mt-1">
                                            @foreach ($buku->categories() as $c)
                                                <a href="{{ route('allBuku', ['category[]' => $c->id]) }}"
                                                    class="inline-block px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-700 hover:border-indigo-500 hover:text-indigo-600 transition-colors">
                                                    {{ $c->nama }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Stock --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Stok Tersedia</p>
                                        <p
                                            class="text-sm font-semibold {{ ($buku->stock ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $buku->stock ?? 0 }} Buku
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Book Description Section --}}
    <section class="py-12 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Deskripsi Buku
                    </h2>
                </div>
                <div class="p-8">
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! $buku->deskripsi ?: '<p class="text-gray-500 italic">Deskripsi tidak tersedia untuk buku ini.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ⭐ Reviews Section --}}
    <section class="py-12 bg-white" x-data="reviewSection()">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Ulasan & Penilaian
                        </h2>
                        <div class="flex items-center gap-2 text-white" x-show="avgRating > 0">
                            <span class="text-3xl font-bold" x-text="avgRating.toFixed(1)"></span>
                            <div>
                                <div class="flex gap-1">
                                    <template x-for="i in 5" :key="i">
                                        <svg class="w-5 h-5" :class="i <= Math.round(avgRating) ? 'text-yellow-200' : 'text-white/30'" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </template>
                                </div>
                                <p class="text-sm text-white/80"><span x-text="reviewCount"></span> ulasan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    {{-- Review Form --}}
                    @if(Auth::check() && Auth::user()->role == 'member' && Auth::user()->member->verif)
                        @php
                            $existingReview = $reviews->where('member_id', Auth::user()->member->membership_number)->first();
                        @endphp
                        <div class="mb-8 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                            <button @click="showForm = !showForm" class="flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                <span x-text="hasMyReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan'"></span>
                            </button>

                            <div x-show="showForm" x-transition class="mt-4">
                                <form @submit.prevent="submitReview()">
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Penilaian</label>
                                        <div class="flex gap-1">
                                            <template x-for="i in 5" :key="i">
                                                <button type="button" @click="formRating = i" class="focus:outline-none">
                                                    <svg class="w-8 h-8 transition-colors" :class="formRating >= i ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan (Opsional)</label>
                                        <textarea x-model="formText" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all" placeholder="Bagikan pendapat Anda tentang buku ini..."></textarea>
                                    </div>

                                    <button type="submit" :disabled="loading" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg disabled:opacity-50 flex items-center gap-2">
                                        <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                        <span x-text="loading ? 'Menyimpan...' : (hasMyReview ? 'Update Ulasan' : 'Kirim Ulasan')"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- Reviews List --}}
                    <template x-if="reviews.length > 0">
                        <div class="space-y-6">
                            <template x-for="(rev, idx) in reviews" :key="idx">
                                <div class="flex gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg" x-text="rev.user_initial"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <span class="font-bold text-gray-900" x-text="rev.user_name"></span>
                                            <div class="flex gap-0.5">
                                                <template x-for="i in 5" :key="'star-'+idx+'-'+i">
                                                    <svg class="w-4 h-4" :class="i <= rev.rating ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                </template>
                                            </div>
                                            <span class="text-xs text-gray-400" x-text="rev.created_at"></span>
                                        </div>
                                        <p x-show="rev.review" class="text-gray-600 text-sm leading-relaxed" x-text="rev.review"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="reviews.length === 0">
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-gray-500">Belum ada ulasan untuk buku ini.</p>
                            @if(Auth::check())
                            <p class="text-gray-400 text-sm mt-1">Jadilah yang pertama memberikan ulasan!</p>
                            @endif
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- 📚 Related Books Section --}}
    @if(isset($relatedBooks) && $relatedBooks->count() > 0)
    <section class="py-12 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Buku Serupa
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($relatedBooks as $rb)
                <a href="{{ route('buku', $rb->slug) }}" class="group block relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                    <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                        <img src="{{ $rb->banner_url }}" alt="{{ $rb->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-3 space-y-1">
                        <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 text-xs leading-snug">{{ $rb->judul }}</h3>
                        <p class="text-xs text-gray-500">{{ $rb->author }}</p>
                        @if($rb->average_rating > 0)
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <span class="text-xs text-gray-500">{{ number_format($rb->average_rating, 1) }}</span>
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 📖 Reservation Section (for out-of-stock books) --}}
    @if(($buku->stock ?? 0) == 0 && Auth::check() && Auth::user()->role == 'member' && Auth::user()->member->verif)
    <section class="py-8 bg-white">
        <div class="container mx-auto px-4">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-3xl p-8 border border-amber-200">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Buku Sedang Tidak Tersedia</h3>
                        <p class="text-gray-600">Reservasi buku ini dan kami akan memberitahu Anda saat buku tersedia kembali.</p>
                    </div>
                    <div x-data="{ loading: false, reserved: false }">
                        <button x-show="!reserved" :disabled="loading" @click="
                            loading = true;
                            ajaxForm('{{ route('reservation.store') }}', 'POST', { buku_id: {{ $buku->id }} }, '{{ csrf_token() }}')
                                .then(res => {
                                    $dispatch('show-toast', { message: res.message, type: 'success' });
                                    reserved = true;
                                })
                                .catch(err => {
                                    $dispatch('show-toast', { message: err.message || 'Gagal mereservasi', type: 'error' });
                                })
                                .finally(() => loading = false);
                        " class="px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-bold hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl whitespace-nowrap disabled:opacity-50 flex items-center gap-2">
                            <svg x-show="loading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            <span x-text="loading ? 'Memproses...' : 'Reservasi Buku'"></span>
                        </button>
                        <div x-show="reserved" class="px-8 py-3 bg-green-100 text-green-700 rounded-xl font-bold whitespace-nowrap flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Reservasi Berhasil!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@section('js')
    @php
        $reviewsJson = $reviews->map(function($r) {
            return [
                'id' => $r->id,
                'rating' => $r->rating,
                'review' => $r->review,
                'user_name' => $r->member->user->name ?? 'Anggota',
                'user_initial' => strtoupper(substr($r->member->user->name ?? 'U', 0, 1)),
                'created_at' => $r->created_at->diffForHumans(),
                'member_id' => $r->member_id,
            ];
        });
        $existingReviewForJs = null;
        if (Auth::check() && Auth::user()->member) {
            $existingReviewForJs = $reviews->where('member_id', Auth::user()->member->membership_number)->first();
        }
    @endphp
    <script>
        function reviewSection() {
            return {
                reviews: @json($reviewsJson),
                avgRating: {{ $buku->average_rating ?? 0 }},
                reviewCount: {{ $buku->review_count ?? 0 }},
                showForm: false,
                loading: false,
                formRating: {{ $existingReviewForJs->rating ?? 5 }},
                formText: '{{ addslashes($existingReviewForJs->review ?? "") }}',
                hasMyReview: {{ $existingReviewForJs ? 'true' : 'false' }},
                myMemberId: '{{ Auth::check() && Auth::user()->member ? Auth::user()->member->membership_number : '' }}',

                submitReview() {
                    this.loading = true;
                    ajaxForm('{{ route("review.store") }}', 'POST', {
                        buku_id: {{ $buku->id }},
                        rating: this.formRating,
                        review: this.formText
                    }, '{{ csrf_token() }}')
                    .then(res => {
                        this.$dispatch('show-toast', { message: res.message, type: 'success' });
                        this.showForm = false;

                        // Update average rating and count
                        this.avgRating = parseFloat(res.average_rating);
                        this.reviewCount = res.review_count;

                        // Update or add the review in the list
                        const newReview = {
                            id: res.review.id,
                            rating: res.review.rating,
                            review: res.review.review,
                            user_name: res.review.user_name,
                            user_initial: res.review.user_initial,
                            created_at: res.review.created_at,
                            member_id: this.myMemberId,
                        };

                        if (res.review.is_update) {
                            const idx = this.reviews.findIndex(r => r.member_id === this.myMemberId);
                            if (idx !== -1) {
                                this.reviews[idx] = newReview;
                            }
                        } else {
                            this.reviews.unshift(newReview);
                        }

                        this.hasMyReview = true;
                    })
                    .catch(err => {
                        this.$dispatch('show-toast', { message: err.message || 'Gagal menyimpan review', type: 'error' });
                    })
                    .finally(() => this.loading = false);
                }
            };
        }
    </script>
    <style>
        .prose {
            color: #374151;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        .prose h1,
        .prose h2,
        .prose h3,
        .prose h4,
        .prose h5,
        .prose h6 {
            color: #111827;
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .prose ul,
        .prose ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        .prose a {
            color: #4f46e5;
            text-decoration: none;
        }

        .prose a:hover {
            color: #6366f1;
            text-decoration: underline;
        }

        .prose strong {
            color: #111827;
            font-weight: 600;
        }

        .prose code {
            background-color: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        /* Alpine.js cloak */
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
