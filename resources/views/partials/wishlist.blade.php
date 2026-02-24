@if ($wishlist->count() > 0)
    <div class="space-y-4">
        @foreach ($wishlist as $item)
            @if ($item->buku)
            <div class="group relative overflow-hidden rounded-2xl bg-white p-4 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="flex gap-4">
                    <div class="relative w-16 h-24 flex-shrink-0 overflow-hidden rounded-lg">
                        <img src="{{ Storage::disk('public')->url($item->buku->banner) }}"
                            alt="{{ $item->buku->judul }}"
                            class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 text-sm line-clamp-2 mb-2">{{ $item->buku->judul }}</h4>
                        <p class="text-xs text-gray-500 mb-2">{{ $item->buku->author }}</p>
                        <a href="{{ route('buku', $item->buku->slug) }}"
                            class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                            View Details
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <button onclick="removeWishlist({{ $item->buku->id }}, this)" class="flex-shrink-0 p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Remove">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif
        @endforeach
    </div>
    <script>
        function removeWishlist(bukuId, btn) {
            fetch('{{ route("wishlist.destroy") }}', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ buku_id: bukuId })
            }).then(r => r.json()).then(res => {
                btn.closest('.group').remove();
                window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Dihapus dari wishlist', type: 'success' } }));
                window.dispatchEvent(new CustomEvent('wishlist-updated'));
                // Update badge counts
                document.querySelectorAll('[data-wishlist-count]').forEach(el => {
                    const count = parseInt(el.textContent) - 1;
                    el.textContent = count > 0 ? count : '';
                    if (count <= 0) el.parentElement.style.display = 'none';
                });
            });
        }
    </script>
@else
    <div class="flex flex-col items-center justify-center h-full text-center py-12">
        <div class="w-24 h-24 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Belum ada buku</h4>
        <p class="text-sm text-gray-500 mb-4">Tambahkan buku favoritmu ke wishlist!</p>
        <a href="{{ route('allBuku') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-pink-500 to-rose-500 px-4 py-2 text-sm font-medium text-white hover:from-pink-600 hover:to-rose-600 transition-all">
            Jelajahi Buku
        </a>
    </div>
@endif
