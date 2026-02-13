@extends('main_member')

@push('styles')
    <style>
        /* Custom Properties */
        :root {
            --primary-purple: #8b5cf6;
            --primary-pink: #ec4899;
            --primary-blue: #3b82f6;
            --dark-bg: #0f172a;
            --card-bg: #1e293b;
            --text-light: #f1f5f9;
            --text-gray: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        /* Hero Section - Ultra Modern */
        .hero-search-ultra {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        .hero-search-ultra::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveGrid 20s linear infinite;
            opacity: 0.3;
        }

        @keyframes moveGrid {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Floating Shapes */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
            opacity: 0.1;
        }

        .shape-1 {
            width: 150px;
            height: 150px;
            background: white;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 100px;
            height: 100px;
            background: #fbbf24;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 80px;
            height: 80px;
            background: #ec4899;
            top: 40%;
            left: 70%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-30px) rotate(180deg);
            }
        }

        /* Hero Content */
        .hero-content-modern {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 20px;
            border-radius: 50px;
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            animation: slideDown 0.6s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title-modern {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.8s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-subtitle-modern {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 3rem;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Ultra Modern Search Box */
        .search-box-ultra {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.5);
            max-width: 1000px;
            margin: 0 auto;
            animation: scaleIn 0.8s ease;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .search-container {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-input-ultra {
            width: 100%;
            height: 70px;
            border-radius: 16px;
            border: 3px solid transparent;
            background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, #667eea, #764ba2) border-box;
            padding: 0 70px 0 28px;
            font-size: 1.15rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .search-input-ultra:focus {
            outline: none;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
        }

        .search-button-ultra {
            position: absolute;
            right: 10px;
            top: 10px;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .search-button-ultra:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        /* Quick Filters - Glassmorphism */
        .quick-filters {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-chip {
            position: relative;
            padding: 12px 24px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid transparent;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            color: #4b5563;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .filter-chip::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .filter-chip:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .filter-chip.active {
            color: white;
            border-color: transparent;
        }

        .filter-chip.active::before {
            opacity: 1;
        }

        /* Stats Bar */
        .stats-bar {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 2rem;
            margin: 2rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .stat-content h4 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .stat-content p {
            font-size: 0.9rem;
            color: #6b7280;
            margin: 0;
        }

        /* Modern Sidebar */
        .sidebar-ultra {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 20px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 3px solid #f3f4f6;
        }

        .sidebar-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .sidebar-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        /* Category Items - Ultra Modern */
        .category-list-ultra {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .category-ultra {
            position: relative;
            padding: 16px 20px;
            border-radius: 14px;
            background: #f9fafb;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .category-ultra:hover {
            background: #f3f4f6;
            transform: translateX(6px);
        }

        .category-ultra.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .category-checkbox-ultra {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .category-name {
            flex: 1;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .category-badge {
            padding: 4px 12px;
            border-radius: 8px;
            background: white;
            color: #667eea;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .category-ultra.active .category-badge {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        /* Book Cards - Premium Design */
        .book-card-ultra {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .book-card-ultra::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .book-card-ultra:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .book-card-ultra:hover::before {
            opacity: 1;
        }

        /* Book Cover with Gradient Overlay */
        .book-cover-ultra {
            position: relative;
            padding-top: 145%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            overflow: hidden;
        }

        .book-cover-ultra::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .book-card-ultra:hover .book-cover-ultra::after {
            opacity: 1;
        }

        .book-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .book-card-ultra:hover .book-image {
            transform: scale(1.1);
        }

        /* Premium Badges */
        .badge-container {
            position: absolute;
            top: 16px;
            right: 16px;
            z-index: 3;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .premium-badge {
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 6px;
            animation: bounceIn 0.6s ease;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .badge-available {
            background: rgba(16, 185, 129, 0.95);
            color: white;
        }

        .badge-limited {
            background: rgba(245, 158, 11, 0.95);
            color: white;
        }

        .badge-out {
            background: rgba(239, 68, 68, 0.95);
            color: white;
        }

        .badge-digital {
            background: rgba(59, 130, 246, 0.95);
            color: white;
        }

        /* Wishlist Heart - Animated */
        .wishlist-heart {
            position: absolute;
            top: 16px;
            left: 16px;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 3;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .wishlist-heart:hover {
            transform: scale(1.15);
            background: white;
        }

        .wishlist-heart.active {
            background: #ef4444;
            animation: heartBeat 0.6s ease;
        }

        @keyframes heartBeat {

            0%,
            100% {
                transform: scale(1);
            }

            10%,
            30% {
                transform: scale(0.9);
            }

            20%,
            40% {
                transform: scale(1.1);
            }
        }

        .wishlist-heart svg {
            width: 22px;
            height: 22px;
            transition: all 0.3s ease;
        }

        .wishlist-heart.active svg {
            fill: white;
            stroke: white;
        }

        /* Book Info Section */
        .book-info-ultra {
            padding: 1.75rem;
        }

        .book-categories-ultra {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .category-pill {
            padding: 6px 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #e0e7ff, #ddd6fe);
            color: #5b21b6;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .book-title-ultra {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.8em;
        }

        .book-author-ultra {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .author-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
        }

        .book-meta-ultra {
            display: flex;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
            padding: 12px 0;
            border-top: 2px solid #f3f4f6;
            border-bottom: 2px solid #f3f4f6;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .meta-icon {
            font-size: 1rem;
        }

        /* Action Buttons - Modern */
        .book-actions-ultra {
            display: flex;
            gap: 12px;
        }

        .btn-primary-ultra {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            text-align: center;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-ultra::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary-ultra:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary-ultra:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-icon-ultra {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-icon-ultra:hover {
            transform: translateY(-2px) rotate(5deg);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        /* Pagination - Ultra Modern */
        .pagination-ultra {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 4rem;
        }

        .page-item-ultra {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: #4b5563;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
        }

        .page-item-ultra:hover {
            background: #f3f4f6;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .page-item-ultra.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        }

        .page-item-ultra.disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Empty State - Premium */
        .empty-state-ultra {
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        .empty-icon-ultra {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            animation: float 3s ease-in-out infinite;
        }

        .empty-title-ultra {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .empty-text-ultra {
            font-size: 1.1rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        /* Loading Animation */
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title-modern {
                font-size: 2.25rem;
            }

            .search-box-ultra {
                padding: 1.75rem;
            }

            .stats-bar {
                flex-direction: column;
                text-align: center;
            }

            .book-card-ultra {
                margin-bottom: 1.5rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }
    </style>
@endpush

@section('content')
    <!-- Ultra Modern Hero Section -->
    <section class="hero-search-ultra">
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <div class="container-fluid">
            <div class="hero-content-modern text-center">
                <!-- Title -->
                <h1 class="hero-title-modern">
                    Temukan <span
                        style="background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Buku
                        Impian</span><br>
                    Anda Di Sini
                </h1>

                <!-- Subtitle -->
                <p class="hero-subtitle-modern">
                    📚 Jelajahi koleksi lengkap | 🔍 Pencarian canggih | 📖 Buku digital tersedia
                </p>

                <!-- Search Box -->
                <div class="search-box-ultra">
                    <form action="{{ route('allBuku') }}" method="GET">
                        <div class="search-container">
                            <input type="text" name="search" class="search-input-ultra"
                                placeholder="🔎 Cari judul, penulis, penerbit, atau kata kunci..."
                                value="{{ request('search') }}">
                            <button type="submit" class="search-button-ultra">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="3"
                                    viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Quick Filters -->
                        <div class="quick-filters">
                            <label class="filter-chip {{ !request('category') ? 'active' : '' }}">
                                <input type="radio" name="category[]" value="" style="display: none;"
                                    onchange="this.form.submit()">
                                <span>📚 Semua Kategori</span>
                            </label>
                            @foreach ($categories->take(6) as $cat)
                                <label
                                    class="filter-chip {{ in_array($cat->id, (array) request('category')) ? 'active' : '' }}">
                                    <input type="checkbox" name="category[]" value="{{ $cat->id }}"
                                        style="display: none;" onchange="this.form.submit()">
                                    <span>{{ $cat->nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section style="background: #f9fafb; padding: 3rem 0;">
        <div class="container-fluid">
            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stat-item">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <h4>{{ $buku->total() }}</h4>
                        <p>Buku Ditemukan</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">📁</div>
                    <div class="stat-content">
                        <h4>{{ $categories->count() }}</h4>
                        <p>Kategori</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">✨</div>
                    <div class="stat-content">
                        <h4>{{ \App\Models\Buku::where('stock', '>', 0)->count() }}</h4>
                        <p>Buku Tersedia</p>
                    </div>
                </div>

                <!-- Sort Dropdown -->
                <form action="{{ route('allBuku') }}" method="GET" style="flex: 1; max-width: 300px;">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    @foreach ((array) request('category') as $cat)
                        <input type="hidden" name="category[]" value="{{ $cat }}">
                    @endforeach

                    <select name="sortBy" class="form-select"
                        style="height: 50px; border-radius: 12px; border: 2px solid #e5e7eb; font-weight: 600;"
                        onchange="this.form.submit()">
                        <option value="default">🔀 Urutkan</option>
                        <option value="judulAZ" {{ request('sortBy') == 'judulAZ' ? 'selected' : '' }}>🔤 Judul A-Z
                        </option>
                        <option value="judulZA" {{ request('sortBy') == 'judulZA' ? 'selected' : '' }}>🔤 Judul Z-A
                        </option>
                        <option value="newest" {{ request('sortBy') == 'newest' ? 'selected' : '' }}>🆕 Terbaru</option>
                    </select>
                </form>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <aside class="col-lg-3 col-md-4">
                    <div class="sidebar-ultra">
                        <div class="sidebar-header">
                            <div class="sidebar-icon">📂</div>
                            <h5 class="sidebar-title">Kategori</h5>
                        </div>

                        <form action="{{ route('allBuku') }}" method="GET" id="categoryForm">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="sortBy" value="{{ request('sortBy') }}">

                            <div class="category-list-ultra">
                                <div class="category-ultra {{ !request('category') ? 'active' : '' }}"
                                    onclick="clearCategories()">
                                    <input type="radio" name="category[]" value="" class="category-checkbox-ultra"
                                        {{ !request('category') ? 'checked' : '' }}>
                                    <span class="category-name">🌟 Semua Kategori</span>
                                    <span class="category-badge">{{ $buku->total() }}</span>
                                </div>

                                @foreach ($categories as $cat)
                                    <div
                                        class="category-ultra {{ in_array($cat->id, (array) request('category')) ? 'active' : '' }}">
                                        <input type="checkbox" name="category[]" value="{{ $cat->id }}"
                                            class="category-checkbox-ultra"
                                            {{ in_array($cat->id, (array) request('category')) ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <span class="category-name">{{ $cat->nama }}</span>
                                        <span class="category-badge">
                                            {{ \App\Models\Buku::whereJsonContains('category_id', $cat->id)->count() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="col-lg-9 col-md-8">
                    @if ($buku->count() > 0)
                        <div class="row g-4">
                            @foreach ($buku as $book)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                    <div class="book-card-ultra">
                                        <!-- Book Cover -->
                                        <div class="book-cover-ultra">
                                            @if ($book->banner_url && file_exists(public_path('storage/' . $book->banner)))
                                                <img src="{{ $book->banner_url }}" alt="{{ $book->judul }}"
                                                    class="book-image">
                                            @else
                                                <!-- SVG Placeholder -->
                                                <svg class="book-image" viewBox="0 0 300 450"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <defs>
                                                        <linearGradient id="bookGrad{{ $book->id }}" x1="0%"
                                                            y1="0%" x2="100%" y2="100%">
                                                            <stop offset="0%"
                                                                style="stop-color:{{ ['#667eea', '#f093fb', '#4facfe', '#fa709a', '#feca57'][$book->id % 5] }};stop-opacity:1" />
                                                            <stop offset="100%"
                                                                style="stop-color:{{ ['#764ba2', '#f77062', '#00f2fe', '#fee140', '#ff9ff3'][$book->id % 5] }};stop-opacity:1" />
                                                        </linearGradient>
                                                    </defs>
                                                    <rect width="300" height="450"
                                                        fill="url(#bookGrad{{ $book->id }})" />
                                                    <g opacity="0.1">
                                                        <rect x="40" y="80" width="220" height="4" fill="white"
                                                            rx="2" />
                                                        <rect x="40" y="100" width="180" height="4" fill="white"
                                                            rx="2" />
                                                        <rect x="40" y="120" width="200" height="4" fill="white"
                                                            rx="2" />
                                                    </g>
                                                    <circle cx="150" cy="200" r="60" fill="white"
                                                        opacity="0.2" />
                                                    <text x="150" y="220" font-family="Arial, sans-serif" font-size="60"
                                                        fill="white" text-anchor="middle" font-weight="bold">📚</text>
                                                    <text x="150" y="320" font-family="Arial, sans-serif" font-size="18"
                                                        fill="white" text-anchor="middle"
                                                        opacity="0.9">{{ Str::limit($book->judul, 20) }}</text>
                                                </svg>
                                            @endif

                                            <!-- Badges -->
                                            <div class="badge-container">
                                                @if ($book->stock > 10)
                                                    <div class="premium-badge badge-available">
                                                        <span>✓</span> Tersedia
                                                    </div>
                                                @elseif($book->stock > 0)
                                                    <div class="premium-badge badge-limited">
                                                        <span>⚠</span> Terbatas
                                                    </div>
                                                @else
                                                    <div class="premium-badge badge-out">
                                                        <span>✗</span> Habis
                                                    </div>
                                                @endif

                                                @if ($book->gdrive_link)
                                                    <div class="premium-badge badge-digital">
                                                        <span>📱</span> Digital
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Wishlist -->
                                            <button
                                                class="wishlist-heart add-to-wishlist {{ Auth::check() &&\App\Models\Wishlist::where('member_id', Auth::user()->member->membership_number)->where('buku_id', $book->id)->exists()? 'active': '' }}"
                                                data-id="{{ $book->id }}"
                                                @guest onclick="alert('Silakan login untuk menambahkan ke wishlist'); return false;" @endguest>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path
                                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Book Info -->
                                        <div class="book-info-ultra">
                                            <!-- Categories -->
                                            <div class="book-categories-ultra">
                                                @foreach ($book->categories()->take(2) as $cat)
                                                    <span class="category-pill">{{ $cat->nama }}</span>
                                                @endforeach
                                            </div>

                                            <!-- Title -->
                                            <h3 class="book-title-ultra" title="{{ $book->judul }}">
                                                {{ $book->judul }}
                                            </h3>

                                            <!-- Author -->
                                            <div class="book-author-ultra">
                                                <span class="author-icon">✍</span>
                                                <span>{{ $book->author }}</span>
                                            </div>

                                            <!-- Meta -->
                                            <div class="book-meta-ultra">
                                                <div class="meta-item"
                                                    style="color: {{ $book->stock > 10 ? '#10b981' : ($book->stock > 0 ? '#f59e0b' : '#ef4444') }}">
                                                    <span class="meta-icon">📦</span>
                                                    <span>{{ $book->stock }}</span>
                                                </div>
                                                <div class="meta-item" style="color: #6b7280;">
                                                    <span class="meta-icon">📅</span>
                                                    <span>{{ $book->year }}</span>
                                                </div>
                                                <div class="meta-item" style="color: #8b5cf6;">
                                                    <span class="meta-icon">👁</span>
                                                    <span>{{ rand(100, 500) }}</span>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="book-actions-ultra">
                                                <a href="{{ route('buku', $book->slug) }}" class="btn-primary-ultra">
                                                    <span style="position: relative; z-index: 1;">Lihat Detail</span>
                                                </a>
                                                @if ($book->gdrive_link)
                                                    <a href="{{ $book->gdrive_link }}" target="_blank"
                                                        class="btn-icon-ultra" title="Buku Digital">
                                                        <svg width="22" height="22" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                                            <path d="M14 2v6h6" />
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
                        @if ($buku->hasPages())
                            <div class="pagination-ultra">
                                <a href="{{ $buku->previousPageUrl() ?: '#' }}"
                                    class="page-item-ultra {{ $buku->onFirstPage() ? 'disabled' : '' }}">
                                    ‹
                                </a>

                                @foreach ($buku->links()->elements as $element)
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            <a href="{{ $url }}"
                                                class="page-item-ultra {{ $page == $buku->currentPage() ? 'active' : '' }}">
                                                {{ $page }}
                                            </a>
                                        @endforeach
                                    @endif
                                @endforeach

                                <a href="{{ $buku->nextPageUrl() ?: '#' }}"
                                    class="page-item-ultra {{ !$buku->hasMorePages() ? 'disabled' : '' }}">
                                    ›
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="empty-state-ultra">
                            <div class="empty-icon-ultra">🔍</div>
                            <h3 class="empty-title-ultra">Tidak Ada Hasil Ditemukan</h3>
                            <p class="empty-text-ultra">
                                Maaf, kami tidak dapat menemukan buku yang Anda cari.<br>
                                Coba gunakan kata kunci atau filter yang berbeda.
                            </p>
                            <a href="{{ route('allBuku') }}" class="btn-primary-ultra"
                                style="display: inline-block; width: auto; padding: 14px 32px;">
                                <span style="position: relative; z-index: 1;">🏠 Kembali ke Beranda</span>
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
        // Clear categories
        function clearCategories() {
            document.querySelectorAll('input[name="category[]"]').forEach(cb => cb.checked = false);
            document.getElementById('categoryForm').submit();
        }

        // Wishlist functionality with animation
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.add-to-wishlist').forEach(btn => {
                    btn.addEventListener('click', async function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            @guest
                            showToast('❌ Silakan login terlebih dahulu', '#ef4444');
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

                                // Update sidebar
                                const wishlistBody = document.querySelector(
                                    '#offcanvasWishlist .offcanvas-body');
                                if (wishlistBody) {
                                    fetch("{{ route('wishlist.partial') }}")
                                        .then(r => r.text())
                                        .then(html => wishlistBody.innerHTML = html);
                                }

                                // Show notification
                                const message = isActive ? '💔 Dihapus dari wishlist' :
                                    '❤️ Ditambahkan ke wishlist';
                                const color = isActive ? '#f59e0b' : '#10b981';
                                showToast(message, color);
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            showToast('❌ Terjadi kesalahan. Coba lagi.', '#ef4444');
                        }
                    });
            });
        });

        // Ultra modern toast notification
        function showToast(message, bg = '#10b981') {
            const toast = document.createElement('div');
            toast.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: ${bg};
        color: white;
        padding: 18px 28px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        z-index: 99999;
        font-weight: 600;
        font-size: 1rem;
        backdrop-filter: blur(10px);
        animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    `;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }

        // Animations
        const styleTag = document.createElement('style');
        styleTag.textContent = `
    @keyframes slideInRight {
        from { 
            opacity: 0; 
            transform: translateX(100px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }
    @keyframes slideOutRight {
        from { 
            opacity: 1; 
            transform: translateX(0); 
        }
        to { 
            opacity: 0; 
            transform: translateX(100px); 
        }
    }
`;
        document.head.appendChild(styleTag);

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endpush
