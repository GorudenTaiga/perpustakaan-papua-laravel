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
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Riwayat Baca</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    Riwayat <span class="text-yellow-300">Bacaan</span>
                </h1>
                <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                    Semua buku yang telah selesai Anda baca dan kembalikan.
                </p>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20">
        <div class="container mx-auto px-4">
            @if($history->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                    @foreach($history as $h)
                    <div class="group">
                        <a href="{{ route('buku', $h->buku->slug) }}" class="block relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">✓ Selesai</span>
                            </div>
                            <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                <img src="{{ $h->buku->banner_url }}" alt="{{ $h->buku->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 text-sm leading-snug">{{ $h->buku->judul }}</h3>
                                <p class="text-xs text-gray-500">{{ $h->buku->author }}</p>
                                <p class="text-xs text-gray-400">Dikembalikan: {{ \Carbon\Carbon::parse($h->return_date)->format('d M Y') }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $history->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 mb-6">
                        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-gray-600 mb-6">Anda belum memiliki buku yang telah dikembalikan.</p>
                    <a href="{{ route('allBuku') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
                        Jelajahi Buku
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
