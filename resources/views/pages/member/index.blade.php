@extends('main_member')
@section('content')
    {{-- Modern Hero Section with Gradient --}}
    <section
        class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 py-20 lg:py-28 pb-32">
        <!-- Gradient Fade to White at Bottom -->
        <div
            class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-b from-transparent to-white pointer-events-none z-10">
        </div>

        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white/5 rounded-full blur-3xl">
            </div>
        </div>

        <div class="container relative mx-auto px-4">
            <!-- Hero Swiper -->
            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <div class="text-white space-y-6 animate-fade-in">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-semibold">Discover Knowledge</span>
                                </div>
                                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                                    Explore Our<br>
                                    <span class="text-yellow-300">Digital Library</span><br>
                                    Collection
                                </h1>
                                <p class="text-lg lg:text-xl text-white/90 leading-relaxed max-w-xl">
                                    Browse thousands of books across all genres. From classic literature to modern
                                    bestsellers, find your next great read.
                                </p>
                                <div class="flex flex-wrap gap-4 pt-4">
                                    <a href="{{ route('allBuku') }}"
                                        class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold hover:bg-yellow-300 hover:text-indigo-900 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                                        Browse Books
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('allCategories') }}"
                                        class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 text-white rounded-xl font-bold backdrop-blur-sm border-2 border-white/30 hover:bg-white/20 transition-all duration-300">
                                        View Categories
                                    </a>
                                </div>
                            </div>
                            <div class="relative hidden lg:block">
                                <div class="relative z-10 transform hover:scale-105 transition-transform duration-500">
                                    <img src="{{ asset('images/buku_dashboard.png') }}" alt="Books"
                                        class="w-full h-auto drop-shadow-2xl">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <div class="text-white space-y-6">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd"
                                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-semibold">New Arrivals</span>
                                </div>
                                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                                    Latest Additions<br>
                                    to Our<br>
                                    <span class="text-yellow-300">Collection</span>
                                </h1>
                                <p class="text-lg lg:text-xl text-white/90 leading-relaxed max-w-xl">
                                    Discover the newest books added to our library. Stay updated with the latest
                                    publications and trending titles.
                                </p>
                                <div class="flex flex-wrap gap-4 pt-4">
                                    <a href="{{ route('allBuku') }}"
                                        class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold hover:bg-yellow-300 hover:text-indigo-900 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                                        View New Books
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="relative hidden lg:block">
                                <div class="relative z-10 transform hover:scale-105 transition-transform duration-500">
                                    <img src="{{ asset('images/buku_dashboard.png') }}" alt="New Books"
                                        class="w-full h-auto drop-shadow-2xl">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <div class="text-white space-y-6">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-semibold">Digital Access</span>
                                </div>
                                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                                    24/7 Digital<br>
                                    <span class="text-yellow-300">Library Access</span>
                                </h1>
                                <p class="text-lg lg:text-xl text-white/90 leading-relaxed max-w-xl">
                                    Access our complete library collection anytime, anywhere. Borrow books digitally and
                                    read on any device.
                                </p>
                                <div class="flex flex-wrap gap-4 pt-4">
                                    <a href="{{ route('allBuku') }}"
                                        class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold hover:bg-yellow-300 hover:text-indigo-900 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                                        Start Reading
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="relative hidden lg:block">
                                <div class="relative z-10 transform hover:scale-105 transition-transform duration-500">
                                    <img src="{{ asset('images/buku_dashboard.png') }}" alt="Digital Library"
                                        class="w-full h-auto drop-shadow-2xl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-center gap-4 mt-12">
                    <button
                        class="swiper-button-prev-custom w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white hover:bg-white hover:text-indigo-600 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <div class="swiper-pagination-hero"></div>
                    <button
                        class="swiper-button-next-custom w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white hover:bg-white hover:text-indigo-600 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Quick Access Cards --}}
    <section class="py-16 -mt-24 relative z-20 bg-transparent">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Categories Card -->
                <a href="{{ route('allCategories') }}"
                    class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-400 to-cyan-500 p-8 lg:p-12 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-3">Browse Categories</h3>
                        <p class="text-white/90 text-lg mb-6">Explore books by genre and discover new favorites</p>
                        <div
                            class="inline-flex items-center gap-2 text-white font-semibold group-hover:gap-4 transition-all">
                            View All Categories
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- E-Books Card -->
                <a href="{{ route('allBuku') }}"
                    class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-violet-500 to-purple-600 p-8 lg:p-12 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-3">Digital Collection</h3>
                        <p class="text-white/90 text-lg mb-6">Access thousands of e-books and digital resources</p>
                        <div
                            class="inline-flex items-center gap-2 text-white font-semibold group-hover:gap-4 transition-all">
                            Browse E-Books
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Book Categories --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-3">Book Categories</h2>
                    <p class="text-lg text-gray-600">Discover books organized by your favorite genres</p>
                </div>
                <a href="{{ route('allCategories') }}"
                    class="hidden md:inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                    View All
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>
            </div>

            <div class="relative">
                <div class="swiper category-carousel swiper-container">
                    <div class="swiper-wrapper">
                        @if (isset($categories))
                            @foreach ($categories as $c)
                                <div class="swiper-slide">
                                    <a href="{{ route('allBuku', ['category[]' => $c->id]) }}"
                                        class="group block relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                                        <div
                                            class="aspect-[4/5] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                            @if ($c->image)
                                                <img src="{{ asset($c->image) }}" alt="{{ $c->nama }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                                    <svg class="w-20 h-20 text-indigo-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <use xlink:href="#category"></use>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            <h3
                                                class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                                {{ $c->nama }}
                                            </h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button
                    class="category-carousel-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 rounded-full bg-white shadow-xl hover:bg-indigo-600 text-gray-800 hover:text-white transition-all duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button
                    class="category-carousel-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-12 h-12 rounded-full bg-white shadow-xl hover:bg-indigo-600 text-gray-800 hover:text-white transition-all duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- Latest Books --}}
    <section class="py-20 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-3">Latest Books</h2>
                    <p class="text-lg text-gray-600">Explore our newest additions to the collection</p>
                </div>
                <a href="{{ route('allBuku') }}"
                    class="hidden md:inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                    View All Books
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($books as $b)
                    <div class="group">
                        <a href="{{ route('buku', $b->slug) }}"
                            class="block relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                            <!-- Wishlist Button -->
                            <button
                                class="absolute top-3 right-3 z-10 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm shadow-lg flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <use xlink:href="#heart"></use>
                                </svg>
                            </button>

                            <!-- Book Cover -->
                            <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                <img src="{{ $b->banner_url }}" alt="{{ $b->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>

                            <!-- Book Info -->
                            <div class="p-4 space-y-2">
                                <h3
                                    class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 text-sm leading-snug">
                                    {{ $b->judul }}
                                </h3>
                                <div class="flex items-center justify-between text-xs">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-indigo-50 text-indigo-600 font-semibold">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                                            </path>
                                        </svg>
                                        {{ $b->stock }} Available
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-yellow-500 font-semibold">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 15 15">
                                            <use xlink:href="#star-solid"></use>
                                        </svg>
                                        {{ number_format($b->average_rating, 1) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Mobile View All Button -->
            <div class="mt-12 text-center md:hidden">
                <a href="{{ route('allBuku') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                    View All Books
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- 🔥 Popular Books Section --}}
    @if(isset($popularBooks) && $popularBooks->count() > 0)
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-50 border border-red-100 mb-4">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-bold text-red-600">Trending</span>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-3">Buku Populer</h2>
                    <p class="text-lg text-gray-600">Buku yang paling sering dipinjam oleh anggota perpustakaan</p>
                </div>
                <a href="{{ route('allBuku', ['sortBy' => 'newest']) }}"
                    class="hidden md:inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-red-500 to-orange-500 text-white font-semibold hover:from-red-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                    Lihat Semua
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($popularBooks as $index => $b)
                    <div class="group relative">
                        @if($index < 3)
                        <div class="absolute -top-2 -left-2 z-20 w-10 h-10 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            #{{ $index + 1 }}
                        </div>
                        @endif
                        <a href="{{ route('buku', $b->slug) }}"
                            class="block relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                            <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                <img src="{{ $b->banner_url }}" alt="{{ $b->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 text-sm leading-snug">
                                    {{ $b->judul }}
                                </h3>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-500">{{ $b->author }}</span>
                                    @if($b->average_rating > 0)
                                    <span class="inline-flex items-center gap-1 text-yellow-500 font-semibold">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        {{ number_format($b->average_rating, 1) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 🆕 New Arrivals Section --}}
    @if(isset($newArrivals) && $newArrivals->count() > 0)
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 border border-green-100 mb-4">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-bold text-green-600">Baru Ditambahkan</span>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-3">Buku Terbaru</h2>
                    <p class="text-lg text-gray-600">Koleksi terbaru yang baru ditambahkan ke perpustakaan</p>
                </div>
                <a href="{{ route('allBuku', ['sortBy' => 'newest']) }}"
                    class="hidden md:inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold hover:from-green-600 hover:to-emerald-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                    Lihat Semua
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($newArrivals as $b)
                    <div class="group relative">
                        <div class="absolute top-3 left-3 z-10">
                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">BARU</span>
                        </div>
                        <a href="{{ route('buku', $b->slug) }}"
                            class="block relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                            <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                <img src="{{ $b->banner_url }}" alt="{{ $b->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 text-sm leading-snug">
                                    {{ $b->judul }}
                                </h3>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-500">{{ $b->author }}</span>
                                    <span class="text-gray-400">{{ $b->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Feature 1 -->
                <div class="flex gap-4 items-start p-6 rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 8.35a3.07 3.07 0 0 0-3.54.53a3 3 0 0 0 0 4.24L11.29 16a1 1 0 0 0 1.42 0l2.83-2.83a3 3 0 0 0 0-4.24A3.07 3.07 0 0 0 12 8.35Zm2.12 3.36L12 13.83l-2.12-2.12a1 1 0 0 1 0-1.42a1 1 0 0 1 1.41 0a1 1 0 0 0 1.42 0a1 1 0 0 1 1.41 0a1 1 0 0 1 0 1.42ZM12 2A10 10 0 0 0 2 12a9.89 9.89 0 0 0 2.26 6.33l-2 2a1 1 0 0 0-.21 1.09A1 1 0 0 0 3 22h9a10 10 0 0 0 0-20Zm0 18H5.41l.93-.93a1 1 0 0 0 0-1.41A8 8 0 1 1 12 20Z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-gray-900 mb-2">Gratis Peminjaman</h5>
                        <p class="text-gray-600 text-sm">Nikmati meminjam buku dengan puas secara gratis.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex gap-4 items-start p-6 rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M19.63 3.65a1 1 0 0 0-.84-.2a8 8 0 0 1-6.22-1.27a1 1 0 0 0-1.14 0a8 8 0 0 1-6.22 1.27a1 1 0 0 0-.84.2a1 1 0 0 0-.37.78v7.45a9 9 0 0 0 3.77 7.33l3.65 2.6a1 1 0 0 0 1.16 0l3.65-2.6A9 9 0 0 0 20 11.88V4.43a1 1 0 0 0-.37-.78ZM18 11.88a7 7 0 0 1-2.93 5.7L12 19.77l-3.07-2.19A7 7 0 0 1 6 11.88v-6.3a10 10 0 0 0 6-1.39a10 10 0 0 0 6 1.39Zm-4.46-2.29l-2.69 2.7l-.89-.9a1 1 0 0 0-1.42 1.42l1.6 1.6a1 1 0 0 0 1.42 0L15 11a1 1 0 0 0-1.42-1.42Z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-gray-900 mb-2">100% Keaslian Buku</h5>
                        <p class="text-gray-600 text-sm">Buku yang ditampilkan adalah 100% berasal dari pusat perpustakaan.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex gap-4 items-start p-6 rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-gray-900 mb-2">Kualitas Terjamin</h5>
                        <p class="text-gray-600 text-sm">Buku yang tersedia sudah memiliki kualitas yang terjamin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hero Swiper
            const heroSwiper = new Swiper('.hero-swiper', {
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                loop: true,
                pagination: {
                    el: '.swiper-pagination-hero',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
            });

            // Category Swiper
            const categorySwiper = new Swiper('.category-carousel', {
                slidesPerView: 2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.category-carousel-next',
                    prevEl: '.category-carousel-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 24,
                    },
                    1280: {
                        slidesPerView: 6,
                        spaceBetween: 24,
                    },
                },
            });
        });
    </script>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes float-delayed {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float-delayed 3s ease-in-out infinite 1.5s;
        }

        .swiper-pagination-hero .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: white;
            opacity: 0.5;
            transition: all 0.3s;
        }

        .swiper-pagination-hero .swiper-pagination-bullet-active {
            width: 32px;
            border-radius: 6px;
            opacity: 1;
            background: white;
        }
    </style>
@endsection
