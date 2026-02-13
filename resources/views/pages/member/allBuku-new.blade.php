@extends('main_member')

@push('styles')
<style>
    /* Hero Search Section */
    .hero-search-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 80px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .hero-search-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }

    .hero-search-content {
        position: relative;
        z-index: 1;
    }

    .hero-search-title {
        color: white;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .hero-search-subtitle {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.2rem;
        margin-bottom: 2.5rem;
    }

    /* Advanced Search Box */
    .advanced-search-box {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 900px;
        margin: 0 auto;
    }

    .search-input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .search-input-group input {
        height: 60px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 0 60px 0 24px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .search-input-group input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .search-btn {
        position: absolute;
        right: 8px;
        top: 8px;
        height: 44px;
        width: 44px;
        border-radius: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    /* Filter Tags */
    .filter-tags {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .filter-tag {
        padding: 8px 16px;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .filter-tag:hover {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
    }

    .filter-tag.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
    }

    /* Main Content Area */
    .books-content-area {
        padding: 3rem 0;
        background: #f7fafc;
    }

    /* Sidebar */
    .sidebar-modern {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 20px;
    }

    .sidebar-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .category-item {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .category-item:hover {
        background: #f7fafc;
        transform: translateX(4px);
    }

    .category-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .category-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .category-count {
        margin-left: auto;
        background: #e2e8f0;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .category-item.active .category-count {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    /* Book Cards */
    .book-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .book-cover-container {
        position: relative;
        padding-top: 140%;
        background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%);
        overflow: hidden;
    }

    .book-cover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .book-card:hover .book-cover {
        transform: scale(1.05);
    }

    .book-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }

    .wishlist-btn {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .wishlist-btn:hover {
        transform: scale(1.1);
    }

    .wishlist-btn.active {
        background: #ef4444;
        color: white;
    }

    .wishlist-btn svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .book-info {
        padding: 1.5rem;
    }

    .book-categories {
        display: flex;
        gap: 6px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .book-category-badge {
        background: #e0e7ff;
        color: #5b21b6;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .book-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        color: #718096;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .book-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }

    .book-stock {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #10b981;
        font-weight: 600;
    }

    .book-stock.low {
        color: #f59e0b;
    }

    .book-stock.out {
        color: #ef4444;
    }

    .book-year {
        color: #718096;
    }

    .book-actions {
        display: flex;
        gap: 10px;
    }

    .btn-detail {
        flex: 1;
        padding: 12px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-gdrive {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #10b981;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-gdrive:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    /* Filter Bar */
    .filter-bar {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .results-count {
        font-size: 1rem;
        color: #4a5568;
        font-weight: 500;
    }

    .sort-dropdown {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sort-dropdown:focus {
        border-color: #667eea;
        outline: none;
    }

    /* Pagination */
    .pagination-modern {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 3rem;
    }

    .page-link-modern {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #4a5568;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .page-link-modern:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .page-link-modern.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .page-link-modern.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        font-size: 5rem;
        color: #cbd5e0;
        margin-bottom: 1.5rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #718096;
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-search-title {
            font-size: 2rem;
        }

        .advanced-search-box {
            padding: 1.5rem;
        }

        .sidebar-modern {
            margin-bottom: 2rem;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .sort-dropdown {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Search Section -->
<section class="hero-search-section">
    <div class="container-fluid">
        <div class="hero-search-content text-center">
            <h1 class="hero-search-title">Temukan Buku Favoritmu</h1>
            <p class="hero-search-subtitle">Jelajahi koleksi lengkap perpustakaan kami dengan lebih dari 10,000+ buku</p>

            <!-- Advanced Search Box -->
            <div class="advanced-search-box">
                <form action="{{ route('allBuku') }}" method="GET">
                    <div class="search-input-group">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Cari judul buku, penulis, atau penerbit..."
                            value="{{ request('search') }}"
                        >
                        <button type="submit" class="search-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Quick Filter Tags -->
                    <div class="filter-tags">
                        <label class="filter-tag {{ !request('category') ? 'active' : '' }}">
                            <input type="radio" name="category[]" value="" style="display: none;" onchange="this.form.submit()">
                            <span>📚 Semua Buku</span>
                        </label>
                        @foreach($categories->take(5) as $cat)
                        <label class="filter-tag {{ in_array($cat->id, (array)request('category')) ? 'active' : '' }}">
                            <input type="checkbox" name="category[]" value="{{ $cat->id }}" style="display: none;" onchange="this.form.submit()">
                            <span>{{ $cat->nama }}</span>
                        </label>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Area -->
<section class="books-content-area">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Filters -->
            <aside class="col-lg-3 col-md-4">
                <div class="sidebar-modern">
                    <h5 class="sidebar-title">📂 Kategori Buku</h5>
                    <form action="{{ route('allBuku') }}" method="GET" id="categoryForm">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sortBy" value="{{ request('sortBy') }}">
                        
                        <div class="category-item {{ !request('category') ? 'active' : '' }}" onclick="clearCategories()">
                            <input type="radio" name="category[]" value="" class="category-checkbox" {{ !request('category') ? 'checked' : '' }}>
                            <span>Semua Kategori</span>
                            <span class="category-count">{{ $buku->total() }}</span>
                        </div>

                        @foreach($categories as $cat)
                        <div class="category-item {{ in_array($cat->id, (array)request('category')) ? 'active' : '' }}">
                            <input 
                                type="checkbox" 
                                name="category[]" 
                                value="{{ $cat->id }}" 
                                class="category-checkbox"
                                {{ in_array($cat->id, (array)request('category')) ? 'checked' : '' }}
                                onchange="this.form.submit()"
                            >
                            <span>{{ $cat->nama }}</span>
                            <span class="category-count">
                                {{ \App\Models\Buku::whereJsonContains('category_id', $cat->id)->count() }}
                            </span>
                        </div>
                        @endforeach
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="col-lg-9 col-md-8">
                <!-- Filter Bar -->
                <div class="filter-bar">
                    <div class="results-count">
                        <strong>{{ $buku->total() }}</strong> buku ditemukan
                        @if(request('search'))
                            untuk "<strong>{{ request('search') }}</strong>"
                        @endif
                    </div>
                    <form action="{{ route('allBuku') }}" method="GET">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @foreach((array)request('category') as $cat)
                        <input type="hidden" name="category[]" value="{{ $cat }}">
                        @endforeach
                        
                        <select name="sortBy" class="sort-dropdown" onchange="this.form.submit()">
                            <option value="default" {{ request('sortBy') == 'default' ? 'selected' : '' }}>
                                🔀 Urutkan: Default
                            </option>
                            <option value="judulAZ" {{ request('sortBy') == 'judulAZ' ? 'selected' : '' }}>
                                🔤 Judul (A - Z)
                            </option>
                            <option value="judulZA" {{ request('sortBy') == 'judulZA' ? 'selected' : '' }}>
                                🔤 Judul (Z - A)
                            </option>
                            <option value="newest" {{ request('sortBy') == 'newest' ? 'selected' : '' }}>
                                🆕 Terbaru
                            </option>
                        </select>
                    </form>
                </div>

                <!-- Books Grid -->
                @if($buku->count() > 0)
                <div class="row g-4">
                    @foreach($buku as $book)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="book-card">
                            <!-- Book Cover -->
                            <div class="book-cover-container">
                                <img src="{{ $book->banner_url ?: asset('images/book-placeholder.jpg') }}" 
                                     alt="{{ $book->judul }}" 
                                     class="book-cover">
                                
                                <!-- Stock Badge -->
                                @if($book->stock > 10)
                                    <div class="book-badge">✓ Tersedia</div>
                                @elseif($book->stock > 0)
                                    <div class="book-badge" style="background: #f59e0b;">⚠ Terbatas</div>
                                @else
                                    <div class="book-badge" style="background: #ef4444;">✗ Habis</div>
                                @endif

                                <!-- Wishlist Button -->
                                <button 
                                    class="wishlist-btn add-to-wishlist {{ Auth::check() && \App\Models\Wishlist::where('member_id', Auth::user()->member->membership_number)->where('buku_id', $book->id)->exists() ? 'active' : '' }}"
                                    data-id="{{ $book->id }}"
                                    @guest onclick="alert('Silakan login untuk menambahkan ke wishlist'); return false;" @endguest
                                >
                                    <svg viewBox="0 0 24 24">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </button>
                            </div>

                            <!-- Book Info -->
                            <div class="book-info">
                                <!-- Categories -->
                                <div class="book-categories">
                                    @foreach($book->categories()->take(2) as $cat)
                                    <span class="book-category-badge">{{ $cat->nama }}</span>
                                    @endforeach
                                </div>

                                <!-- Title -->
                                <h3 class="book-title" title="{{ $book->judul }}">
                                    {{ $book->judul }}
                                </h3>

                                <!-- Author -->
                                <p class="book-author">
                                    ✍️ {{ $book->author }}
                                </p>

                                <!-- Meta Info -->
                                <div class="book-meta">
                                    <span class="book-stock {{ $book->stock > 10 ? '' : ($book->stock > 0 ? 'low' : 'out') }}">
                                        📦 {{ $book->stock }} stok
                                    </span>
                                    <span class="book-year">
                                        📅 {{ $book->year }}
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="book-actions">
                                    <a href="{{ route('buku', $book->slug) }}" class="btn-detail">
                                        Lihat Detail
                                    </a>
                                    @if($book->gdrive_link)
                                    <a href="{{ $book->gdrive_link }}" target="_blank" class="btn-gdrive" title="Buku Digital">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                            <path d="M14 2v6h6"/>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($buku->hasPages())
                <div class="pagination-modern">
                    {{-- Previous --}}
                    <a href="{{ $buku->previousPageUrl() ?: '#' }}" 
                       class="page-link-modern {{ $buku->onFirstPage() ? 'disabled' : '' }}">
                        ‹
                    </a>

                    {{-- Page Numbers --}}
                    @foreach($buku->links()->elements as $element)
                        @if(is_array($element))
                            @foreach($element as $page => $url)
                                <a href="{{ $url }}" 
                                   class="page-link-modern {{ $page == $buku->currentPage() ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    <a href="{{ $buku->nextPageUrl() ?: '#' }}" 
                       class="page-link-modern {{ !$buku->hasMorePages() ? 'disabled' : '' }}">
                        ›
                    </a>
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">📚</div>
                    <h3 class="empty-state-title">Tidak Ada Buku Ditemukan</h3>
                    <p class="empty-state-text">
                        Coba ubah kata kunci pencarian atau filter kategori Anda
                    </p>
                    <a href="{{ route('allBuku') }}" class="btn-detail mt-3" style="display: inline-block; width: auto; padding: 12px 32px;">
                        Lihat Semua Buku
                    </a>
                </div>
                @endif
            </main>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Clear all category filters
function clearCategories() {
    document.querySelectorAll('input[name="category[]"]').forEach(cb => cb.checked = false);
    document.getElementById('categoryForm').submit();
}

// Wishlist functionality
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-wishlist').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            @guest
                alert('Silakan login terlebih dahulu');
                return;
            @endguest
            
            const bukuId = this.dataset.id;
            const isActive = this.classList.contains('active');

            try {
                const res = await fetch("{{ route('wishlist.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        buku_id: bukuId,
                        member_id: {{ Auth::check() ? Auth::user()->member->membership_number : 'null' }}
                    })
                });

                const data = await res.json();

                if (data.success) {
                    this.classList.toggle('active');
                    
                    // Update wishlist sidebar if exists
                    const wishlistBody = document.querySelector('#offcanvasWishlist .offcanvas-body');
                    if (wishlistBody) {
                        fetch("{{ route('wishlist.partial') }}")
                            .then(r => r.text())
                            .then(html => wishlistBody.innerHTML = html);
                    }

                    // Show toast notification
                    const message = isActive ? 'Dihapus dari wishlist' : 'Ditambahkan ke wishlist';
                    showToast(message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
});

// Simple toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #10b981;
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endpush
