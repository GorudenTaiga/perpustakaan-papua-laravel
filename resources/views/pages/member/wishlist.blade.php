@extends('main_member')
@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-pink-500 via-rose-500 to-red-500 py-20 lg:py-28 pb-32">
        <div class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-b from-transparent to-white pointer-events-none z-10"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>
        <div class="container relative mx-auto px-4">
            <div class="text-white space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-semibold">Wishlist</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    Wishlist <span class="text-pink-200">Saya</span>
                </h1>
                <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                    Koleksi buku yang ingin Anda baca. Simpan dan kelola daftar bacaan impian Anda.
                </p>
                @if($wishlist->count() > 0)
                <div class="flex items-center gap-4">
                    <div class="px-5 py-2.5 rounded-2xl bg-white/20 backdrop-blur-sm border border-white/30">
                        <span class="text-2xl font-bold">{{ $wishlist->count() }}</span>
                        <span class="text-sm text-white/80 ml-1">Buku</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20" x-data="{ removing: null }">
        <div class="container mx-auto px-4">
            @if($wishlist->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($wishlist as $item)
                        @if($item->buku)
                        <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                             x-show="removing !== {{ $item->buku->id }}"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             id="wishlist-card-{{ $item->buku->id }}">
                            <div class="flex gap-5 p-6">
                                {{-- Book Cover --}}
                                <a href="{{ route('buku', $item->buku->slug) }}" class="flex-shrink-0">
                                    <div class="relative w-24 h-36 overflow-hidden rounded-2xl shadow-md">
                                        <img src="{{ Storage::disk('public')->url($item->buku->banner) }}"
                                             alt="{{ $item->buku->judul }}"
                                             class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                    </div>
                                </a>

                                {{-- Book Details --}}
                                <div class="flex-1 min-w-0 flex flex-col justify-between">
                                    <div>
                                        <a href="{{ route('buku', $item->buku->slug) }}" class="group/title">
                                            <h3 class="font-bold text-gray-900 text-base line-clamp-2 group-hover/title:text-indigo-600 transition-colors">
                                                {{ $item->buku->judul }}
                                            </h3>
                                        </a>
                                        <p class="text-sm text-gray-500 mt-1">{{ $item->buku->author }}</p>

                                        {{-- Categories --}}
                                        @php
                                            $categories = \App\Models\Category::whereIn('id', $item->buku->category_id ?? [])->get();
                                        @endphp
                                        @if($categories->count() > 0)
                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            @foreach($categories->take(2) as $cat)
                                            <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-medium">{{ $cat->nama_category }}</span>
                                            @endforeach
                                            @if($categories->count() > 2)
                                            <span class="px-2 py-0.5 rounded-full bg-gray-50 text-gray-500 text-xs">+{{ $categories->count() - 2 }}</span>
                                            @endif
                                        </div>
                                        @endif

                                        {{-- Rating & Stock --}}
                                        <div class="flex items-center gap-3 mt-2">
                                            @if($item->buku->average_rating > 0)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                <span class="text-sm font-semibold text-gray-700">{{ number_format($item->buku->average_rating, 1) }}</span>
                                            </div>
                                            @endif
                                            <div class="flex items-center gap-1">
                                                <span class="w-2 h-2 rounded-full {{ $item->buku->stok > 0 ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                                <span class="text-xs {{ $item->buku->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $item->buku->stok > 0 ? 'Stok: ' . $item->buku->stok : 'Habis' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex items-center gap-2 mt-3">
                                        <a href="{{ route('buku', $item->buku->slug) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-50 text-indigo-600 text-xs font-semibold hover:bg-indigo-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Detail
                                        </a>
                                        <button onclick="removeFromWishlist({{ $item->buku->id }})"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border-2 border-red-100 text-red-500 text-xs font-semibold hover:bg-red-50 hover:border-red-200 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Added date footer --}}
                            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                                <p class="text-xs text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Ditambahkan {{ $item->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-pink-50 to-rose-50 mb-6">
                        <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Wishlist Masih Kosong</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Anda belum menambahkan buku apapun ke wishlist. Jelajahi koleksi kami dan temukan buku favorit Anda!</p>
                    <a href="{{ route('allBuku') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-2xl font-semibold hover:from-pink-600 hover:to-rose-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Jelajahi Buku
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('js')
<script>
function removeFromWishlist(bukuId) {
    fetch('{{ route("wishlist.destroy") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ buku_id: bukuId })
    }).then(r => r.json()).then(res => {
        if (res.success) {
            const card = document.getElementById('wishlist-card-' + bukuId);
            if (card) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => card.remove(), 300);
            }
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Buku dihapus dari wishlist', type: 'success' } }));
            window.dispatchEvent(new CustomEvent('wishlist-updated'));
            document.querySelectorAll('[data-wishlist-count]').forEach(el => {
                const count = parseInt(el.textContent) - 1;
                el.textContent = count > 0 ? count : '';
                if (count <= 0) el.parentElement.style.display = 'none';
            });
        }
    });
}
</script>
@endsection
