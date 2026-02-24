@extends('main_member')
@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 py-20 lg:py-28 pb-32">
        <div class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-b from-transparent to-white pointer-events-none z-10"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>
        <div class="container relative mx-auto px-4">
            <div class="text-white space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Reservasi</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    Reservasi <span class="text-yellow-300">Buku</span>
                </h1>
                <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                    Daftar buku yang Anda reservasi saat stok habis.
                </p>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20">
        <div class="container mx-auto px-4">
            @if($reservations->count() > 0)
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Daftar Reservasi
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($reservations as $r)
                        <div class="p-6 flex flex-col lg:flex-row gap-6 items-center hover:bg-gray-50 transition-colors">
                            <a href="{{ route('buku', $r->buku->slug) }}" class="flex-shrink-0">
                                <img src="{{ $r->buku->banner_url }}" alt="{{ $r->buku->judul }}" class="w-16 h-24 object-cover rounded-xl shadow-md">
                            </a>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('buku', $r->buku->slug) }}" class="group">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $r->buku->judul }}</h3>
                                </a>
                                <p class="text-sm text-gray-500">{{ $r->buku->author }}</p>
                                <p class="text-xs text-gray-400 mt-1">Direservasi: {{ $r->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                @php
                                    $statusColors = [
                                        'waiting' => 'bg-yellow-100 text-yellow-700',
                                        'available' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-gray-100 text-gray-700',
                                        'fulfilled' => 'bg-blue-100 text-blue-700',
                                    ];
                                    $statusLabels = [
                                        'waiting' => 'Menunggu',
                                        'available' => 'Tersedia',
                                        'cancelled' => 'Dibatalkan',
                                        'fulfilled' => 'Terpenuhi',
                                    ];
                                @endphp
                                <span class="px-4 py-2 rounded-full text-sm font-bold {{ $statusColors[$r->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $statusLabels[$r->status] ?? $r->status }}
                                </span>
                                @if($r->status === 'waiting')
                                <form action="{{ route('reservation.cancel') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="reservation_id" value="{{ $r->id }}">
                                    <button type="submit" class="px-4 py-2 rounded-xl border-2 border-red-200 text-red-600 font-semibold hover:bg-red-50 transition-colors text-sm">
                                        Batalkan
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-amber-50 to-orange-50 mb-6">
                        <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Reservasi</h3>
                    <p class="text-gray-600 mb-6">Anda belum mereservasi buku apapun.</p>
                    <a href="{{ route('allBuku') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg">
                        Jelajahi Buku
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
