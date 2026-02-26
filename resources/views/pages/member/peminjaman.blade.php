@extends('main_member')
@section('content')
    {{-- Modern Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 py-20 lg:py-28 pb-32">
        <!-- Gradient Fade to White at Bottom -->
        <div class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-b from-transparent to-white pointer-events-none z-10"></div>

        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container relative mx-auto px-4">
            <div class="text-white space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Perpustakaan Saya</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    Peminjaman <span class="text-yellow-300">Saya</span>
                </h1>
                <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                    Lihat dan kelola semua buku yang Anda pinjam di satu tempat.
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20">
        <div class="container mx-auto px-4">
            {{-- Stats Cards --}}
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-6 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Peminjaman</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $pinjaman->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-6 border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Peminjaman Aktif</p>
                            <p class="text-3xl font-bold text-green-600">{{ $pinjaman->whereIn('status', ['dipinjam', 'pending'])->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-6 border border-purple-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Dikembalikan</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $pinjaman->where('status', 'dikembalikan')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Loans List --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Riwayat Peminjaman
                        </h2>
                        @if($pinjaman->count() > 0)
                        <a href="{{ route('pinjam.exportPdf') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-lg font-semibold hover:bg-white/30 transition-all border border-white/30 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor PDF
                        </a>
                        @endif
                    </div>
                </div>

                @if ($pinjaman->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach ($pinjaman as $p)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex flex-col lg:flex-row gap-6">
                                    {{-- Book Image & Info --}}
                                    <div class="flex gap-4 lg:flex-1">
                                        <a href="{{ route('buku', $p->buku->slug) }}" class="flex-shrink-0">
                                            <img src="{{ $p->buku->banner_url }}" 
                                                 alt="{{ $p->buku->judul }}"
                                                 class="w-20 h-28 object-cover rounded-xl shadow-md hover:shadow-lg transition-shadow">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('buku', $p->buku->slug) }}" class="group">
                                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                                    {{ $p->buku->judul }}
                                                </h3>
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1">oleh {{ $p->buku->author ?? 'Tidak Diketahui' }}</p>
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                Jml: {{ $p->quantity }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Loan Details --}}
                                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:flex-1">
                                        {{-- Loan Date --}}
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Tanggal Pinjam</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($p->loan_date)->format('d M Y') }}</p>
                                        </div>

                                        {{-- Due Date --}}
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Batas Pengembalian</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($p->due_date)->format('d M Y') }}</p>
                                        </div>

                                        {{-- Return Date --}}
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Tanggal Kembali</p>
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $p->return_date ? \Carbon\Carbon::parse($p->return_date)->format('d M Y') : '-' }}
                                            </p>
                                        </div>

                                        {{-- Status --}}
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Status</p>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'dipinjam' => 'bg-blue-100 text-blue-700',
                                                    'dikembalikan' => 'bg-green-100 text-green-700',
                                                    'terlambat' => 'bg-red-100 text-red-700',
                                                ];
                                                $statusClass = $statusColors[$p->status] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                                {{ Str::of($p->status)->replace('_', ' ')->title() }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Actions & Fee --}}
                                    <div class="lg:w-48 flex flex-col justify-center gap-3" x-data="{ showWarning: false, loading: false, extended: {{ $p->extended ? 'true' : 'false' }} }">
                                        {{-- Extend Loan Button (Only if active and not yet extended) --}}
                                        @if ($p->status === 'dipinjam' && !$p->extended)
                                            <button x-show="!extended" :disabled="loading" @click="
                                                if (!confirm('Perpanjang peminjaman 7 hari?')) return;
                                                loading = true;
                                                ajaxForm('{{ route('pinjam.extend', $p->id) }}', 'POST', {}, '{{ csrf_token() }}')
                                                    .then(res => {
                                                        $dispatch('show-toast', { message: res.message, type: 'success' });
                                                        extended = true;
                                                    })
                                                    .catch(err => {
                                                        $dispatch('show-toast', { message: err.message || 'Gagal memperpanjang', type: 'error' });
                                                    })
                                                    .finally(() => loading = false);
                                            " class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg font-semibold text-sm hover:from-green-600 hover:to-emerald-600 transition-all shadow-md hover:shadow-lg disabled:opacity-50">
                                                <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span x-text="loading ? 'Memproses...' : 'Perpanjang'"></span>
                                            </button>
                                            <span x-show="extended" class="text-xs text-green-600 italic text-center font-semibold">✓ Sudah diperpanjang</span>
                                        @elseif($p->extended)
                                            <span class="text-xs text-gray-400 italic text-center">Sudah diperpanjang</span>
                                        @endif
                                        {{-- Read Book Button (Only if status is 'dipinjam') --}}
                                        @if (in_array($p->status, ['dipinjam', 'terlambat']))
                                            @if ($p->buku->gdrive_link && Auth::user()->member?->isPremium())
                                                <a href="{{ route('buku.read', $p->buku->slug) }}"
                                                   class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold text-sm hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    Baca Buku
                                                </a>
                                            @elseif ($p->buku->gdrive_link && !Auth::user()->member?->isPremium())
                                                <span class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-lg font-semibold text-sm cursor-not-allowed opacity-80">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                    </svg>
                                                    Khusus Premium
                                                </span>
                                            @else
                                                <button @click="showWarning = true" type="button"
                                                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-400 text-white rounded-lg font-semibold text-sm hover:bg-gray-500 transition-all shadow-md hover:shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    Baca Buku
                                                </button>

                                                {{-- Warning Modal --}}
                                                <div x-show="showWarning" 
                                                     x-cloak
                                                     style="display: none;"
                                                     @keydown.escape.window="showWarning = false"
                                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                                     role="dialog" 
                                                     aria-modal="true">
                                                    {{-- Backdrop --}}
                                                    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                                                         @click="showWarning = false"
                                                         x-show="showWarning"
                                                         x-transition:enter="ease-out duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="ease-in duration-200"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"></div>

                                                    {{-- Modal Panel --}}
                                                    <div class="flex min-h-screen items-center justify-center p-4">
                                                        <div x-show="showWarning"
                                                             x-transition:enter="ease-out duration-300"
                                                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                             x-transition:leave="ease-in duration-200"
                                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                             class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
                                                             @click.stop>
                                                            
                                                            {{-- Modal Header --}}
                                                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                                                                <div class="flex items-center justify-between">
                                                                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                                        </svg>
                                                                        Buku Tidak Tersedia Daring
                                                                    </h3>
                                                                    <button type="button" @click="showWarning = false"
                                                                            class="text-white hover:text-gray-200 transition-colors">
                                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            {{-- Modal Body --}}
                                                            <div class="p-6 space-y-4">
                                                                <div class="flex items-start gap-4">
                                                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="flex-1">
                                                                        <p class="text-sm text-gray-700 leading-relaxed">
                                                                            Buku ini tidak tersedia untuk dibaca secara daring. Silakan kunjungi perpustakaan secara langsung atau hubungi administrator untuk bantuan.
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="bg-gray-50 rounded-xl p-4">
                                                                    <p class="text-xs font-semibold text-gray-700 mb-2">Informasi Kontak:</p>
                                                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                                        </svg>
                                                                        <span class="font-medium">+62 877 4316 0171</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Modal Footer --}}
                                                            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                                                                <button type="button" @click="showWarning = false"
                                                                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold hover:from-yellow-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl">
                                                                    Mengerti
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                        {{-- Fee --}}
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 mb-1">Biaya</p>
                                            @if ($p->final_price == 0)
                                                <p class="text-lg font-bold text-green-600">Gratis</p>
                                                <p class="text-xs text-gray-500">Tidak ada denda</p>
                                            @else
                                                <p class="text-lg font-bold text-red-600">Rp {{ number_format($p->final_price, 0, ',', '.') }}</p>
                                                <p class="text-xs text-red-500">Denda keterlambatan</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-16 px-4">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 mb-6">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Riwayat Peminjaman</h3>
                        <p class="text-gray-600 mb-6">Anda belum meminjam buku apa pun. Mulai jelajahi sekarang!</p>
                        <a href="{{ route('allBuku') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Jelajahi Buku
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
