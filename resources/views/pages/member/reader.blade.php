@extends('main_member')

@section('content')
<style>
    .reader-container {
        position: relative;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .reader-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 20px;
        padding: 16px 24px;
        background: linear-gradient(135deg, #1e293b, #334155);
        border-radius: 16px;
        color: #fff;
    }

    .reader-header .book-info {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }

    .reader-header .book-info h1 {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .reader-header .book-info p {
        font-size: 0.875rem;
        color: #94a3b8;
        margin: 0;
    }

    .reader-header .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(255,255,255,0.1);
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .reader-header .btn-back:hover {
        background: rgba(255,255,255,0.2);
    }

    .reader-frame-wrapper {
        position: relative;
        width: 100%;
        height: 85vh;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        background: #f1f5f9;
    }

    .reader-frame-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Overlay transparan di atas iframe untuk mencegah klik kanan */
    .reader-frame-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 10;
        pointer-events: none;
    }

    .premium-badge-reader {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .reader-container {
            padding: 12px;
        }

        .reader-header {
            padding: 12px 16px;
        }

        .reader-header .book-info h1 {
            font-size: 1rem;
        }

        .reader-frame-wrapper {
            height: 75vh;
        }
    }
</style>

<div class="reader-container">
    <div class="reader-header">
        <div class="book-info">
            <div>
                <h1>{{ $buku->judul }}</h1>
                <p>{{ $buku->author ?? 'Penulis tidak diketahui' }}</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <span class="premium-badge-reader">⭐ Premium</span>
            <a href="{{ route('buku', $buku->slug) }}" class="btn-back">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="reader-frame-wrapper" oncontextmenu="return false;">
        <iframe 
            src="{{ $embedUrl }}" 
            sandbox="allow-scripts allow-same-origin allow-popups"
            allowfullscreen
            loading="lazy">
        </iframe>
    </div>
</div>

<script>
    // Cegah shortcut download
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S' || e.key === 'p' || e.key === 'P')) {
            e.preventDefault();
            return false;
        }
    });

    // Cegah klik kanan di seluruh halaman reader
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });
</script>
@endsection
