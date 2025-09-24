@if ($wishlist->count() > 0)
    <ul class="list-group">
        @foreach ($wishlist as $item)
            <li class="list-group-item d-flex align-items-center">
                <img src="{{ Storage::disk('public')->url($item->buku()->banner) }}" alt="{{ $item->buku()->judul }}"
                    class="img-thumbnail me-3" style="width: 60px; height: 80px; object-fit: cover;">
                <span>{{ $item->buku()->judul }}</span>
                <a href="{{ route('buku', $item->buku()->slug) }}">Detail</a>
            </li>
        @endforeach
    </ul>
@else
    <p>Belum ada buku di wishlist.</p>
@endif
