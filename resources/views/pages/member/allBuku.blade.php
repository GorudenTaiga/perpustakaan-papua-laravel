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
            <div class="text-white space-y-6">
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
                    Browse Our <span class="text-yellow-300">Collection</span>
                </h1>
                <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                    Discover thousands of books across all genres. Find your next great read.
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-4 gap-8">
                {{-- Sidebar Filters --}}
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 sticky top-24 space-y-6">
                        {{-- Search Bar --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Search Books</h3>
                            <form action="{{ route('allBuku') }}" method="get">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search by title, author..."
                                        class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all">
                                    <button type="submit"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Categories Filter --}}
                        <div x-data="{ expanded: false }">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Categories</h3>
                            <form action="{{ route('allBuku') }}" method="GET" id="categoryForm">
                                <div class="space-y-1">
                                    <label
                                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" name="category[]" value="all"
                                            onchange="categoryToggle(this, true)"
                                            {{ empty(request('category')) || in_array('all', (array) request('category')) ? 'checked' : '' }}
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm font-medium text-gray-700">All Categories</span>
                                    </label>

                                    @foreach ($categories as $i => $c)
                                        <label x-show="expanded || {{ $i }} < 5"
                                            x-transition
                                            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors {{ in_array($c->id, (array) request('category')) ? 'bg-indigo-50' : '' }}">
                                            <input type="checkbox" name="category[]" value="{{ $c->id }}"
                                                onchange="categoryToggle(this, false)"
                                                {{ in_array($c->id, (array) request('category')) ? 'checked' : '' }}
                                                class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-sm font-medium text-gray-700 truncate">{{ $c->nama }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                @if($categories->count() > 5)
                                <button type="button" @click="expanded = !expanded"
                                    class="mt-2 w-full flex items-center justify-center gap-1.5 py-2 text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <span x-text="expanded ? 'Tampilkan Sedikit' : 'Tampilkan Semua ({{ $categories->count() }})'"></span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                @endif
                            </form>
                            <script>
                                function categoryToggle(el, isAll) {
                                    const form = document.getElementById('categoryForm');
                                    const allCb = form.querySelector('input[value="all"]');
                                    const others = form.querySelectorAll('input[name="category[]"]:not([value="all"])');
                                    if (isAll) {
                                        // "All" clicked: uncheck all others
                                        allCb.checked = true;
                                        others.forEach(cb => cb.checked = false);
                                    } else {
                                        // Specific category clicked: uncheck "All"
                                        allCb.checked = false;
                                        // If nothing is checked, re-check "All"
                                        const anyChecked = Array.from(others).some(cb => cb.checked);
                                        if (!anyChecked) allCb.checked = true;
                                    }
                                    form.submit();
                                }
                            </script>
                        </div>
                    </div>
                </aside>

                {{-- Main Content Area --}}
                <main class="lg:col-span-3">
                    {{-- Filter Bar --}}
                    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 mb-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Showing <span class="font-semibold text-gray-900">{{ $buku->firstItem() ?? 0 }}</span> -
                                <span class="font-semibold text-gray-900">{{ $buku->lastItem() ?? 0 }}</span> of
                                <span class="font-semibold text-gray-900">{{ $buku->total() }}</span> results
                            </div>
                            <form action="{{ route('allBuku') }}" method="GET" class="w-full sm:w-auto">
                                <select name="sortBy" onchange="this.form.submit()"
                                    class="w-full sm:w-auto px-4 py-2 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm font-medium transition-all">
                                    <option value="default" {{ request('sortBy') == 'default' ? 'selected' : '' }}>Default
                                        Sorting</option>
                                    <option value="judulAZ" {{ request('sortBy') == 'judulAZ' ? 'selected' : '' }}>Title (A
                                        - Z)</option>
                                    <option value="judulZA" {{ request('sortBy') == 'judulZA' ? 'selected' : '' }}>Title (Z
                                        - A)</option>
                                    <option value="newest" {{ request('sortBy') == 'newest' ? 'selected' : '' }}>Newest
                                        First</option>
                                    <option value="oldest" {{ request('sortBy') == 'oldest' ? 'selected' : '' }}>Oldest
                                        First</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Book Grid --}}
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($buku as $b)
                            <div
                                class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-indigo-200">
                                <a href="{{ route('buku', $b->slug) }}" class="block">
                                    <div
                                        class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 aspect-[3/4]">
                                        <img src="{{ $b->image ? asset('storage/' . $b->image) : asset('images/placeholder.png') }}"
                                            alt="{{ $b->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        </div>
                                        <div class="absolute top-4 left-4">
                                            <span
                                                class="px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs font-bold rounded-full shadow-lg">
                                                {{ $b->tahun ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="absolute top-4 right-4">
                                            <button
                                                class="add-to-wishlist p-2.5 rounded-full bg-white/90 backdrop-blur-sm hover:bg-white shadow-lg transition-all duration-300 hover:scale-110 {{ Auth::check() && Auth::user()->member && \App\Models\Wishlist::where('member_id', Auth::user()->member->membership_number)->where('buku_id', $b->id)->exists() ? 'active' : '' }}"
                                                data-id="{{ $b->id }}" onclick="event.preventDefault();">
                                                <svg class="w-5 h-5 text-gray-600 hover:text-red-500 transition-colors"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-3">
                                        <h3
                                            class="font-bold text-lg text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors min-h-[3.5rem]">
                                            {{ $b->judul }}
                                        </h3>
                                        <div class="space-y-2">
                                            <p class="text-sm text-gray-600 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                <span class="line-clamp-1">{{ $b->author ?? 'Unknown Author' }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="line-clamp-1">{{ $b->publisher ?? 'Unknown Publisher' }}</span>
                                            </p>
                                        </div>
                                        <div class="pt-3 border-t border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    @if($b->average_rating > 0)
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                        <span class="text-sm font-bold text-gray-700">{{ number_format($b->average_rating, 1) }}</span>
                                                        <span class="text-xs text-gray-400">({{ $b->review_count }})</span>
                                                    </div>
                                                    @else
                                                    <span class="text-xs text-gray-400">Belum ada rating</span>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                    View Details →
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 mb-6">
                                    <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No Books Found</h3>
                                <p class="text-gray-600 mb-6">Try adjusting your search or filter to find what you're
                                    looking for.</p>
                                <a href="{{ route('allBuku') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Reset Filters
                                </a>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($buku->hasPages())
                        <div class="flex justify-center mt-12">
                            <div class="flex items-center gap-2">
                                {{-- Previous --}}
                                @if ($buku->onFirstPage())
                                    <span
                                        class="px-4 py-2.5 rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed font-medium">
                                        ← Previous
                                    </span>
                                @else
                                    <a href="{{ $buku->previousPageUrl() }}"
                                        class="px-4 py-2.5 rounded-xl bg-white border-2 border-gray-200 text-gray-700 hover:border-indigo-500 hover:text-indigo-600 transition-all font-medium shadow-sm hover:shadow-md">
                                        ← Previous
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                <div class="flex items-center gap-2 mx-2">
                                    @foreach ($buku->links()->elements as $element)
                                        @if (is_string($element))
                                            <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                                        @endif
                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $buku->currentPage())
                                                    <span
                                                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white font-bold shadow-lg">
                                                        {{ $page }}
                                                    </span>
                                                @else
                                                    <a href="{{ $url }}"
                                                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-200 text-gray-700 hover:border-indigo-500 hover:text-indigo-600 transition-all font-medium shadow-sm hover:shadow-md">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Next --}}
                                @if ($buku->hasMorePages())
                                    <a href="{{ $buku->nextPageUrl() }}"
                                        class="px-4 py-2.5 rounded-xl bg-white border-2 border-gray-200 text-gray-700 hover:border-indigo-500 hover:text-indigo-600 transition-all font-medium shadow-sm hover:shadow-md">
                                        Next →
                                    </a>
                                @else
                                    <span
                                        class="px-4 py-2.5 rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed font-medium">
                                        Next →
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                </main>

            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.add-to-wishlist').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    const bukuId = btn.dataset.id;

                    // Check if user is authenticated
                    @guest
                    // Show login required modal
                    window.modalSystem.showLoginRequired();
                    return;
                @endguest

                @auth
                // Check if user is member
                @if (Auth::user()->role !== 'member' || !Auth::user()->member)
                    // Show member only modal
                    window.modalSystem.showMemberOnly();
                    return;
                @endif

                try {
                    const res = await fetch("{{ route('wishlist.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            buku_id: bukuId
                        })
                    });

                    // Check if response is JSON
                    const contentType = res.headers.get("content-type");
                    if (!contentType || !contentType.includes("application/json")) {
                        window.modalSystem.showAlert({
                            type: 'danger',
                            title: 'Session Expired',
                            message: 'Your session has expired. Please login again.',
                            buttons: [{
                                    text: 'Login',
                                    href: '{{ route('login') }}',
                                    class: 'primary'
                                },
                                {
                                    text: 'Cancel',
                                    dismiss: true,
                                    class: 'secondary'
                                }
                            ]
                        });
                        return;
                    }

                    const data = await res.json();

                    if (res.ok && data.success) {
                        if (data.added) {
                            btn.classList.add("active");
                            window.modalSystem.showSuccess(
                                'Book added to wishlist!',
                                'You can view your wishlist anytime from the menu.'
                            );
                        } else if (data.removed) {
                            btn.classList.remove("active");
                            window.modalSystem.showSuccess(
                                'Book removed from wishlist',
                                'The book has been removed from your wishlist.'
                            );
                        }
                        window.dispatchEvent(new CustomEvent('wishlist-updated'));
                    } else {
                        // Show error modal
                        window.modalSystem.showError(
                            data.message || 'Failed to update wishlist',
                            'Please try again later.'
                        );
                    }
                } catch (err) {
                    console.error('Wishlist error:', err);
                    window.modalSystem.showError(
                        'An error occurred',
                        err.message || 'Please check your connection and try again.'
                    );
                }
            @endauth
        });
        });
        });
    </script>

    <style>
        .add-to-wishlist.active svg {
            fill: #ef4444;
            stroke: #ef4444;
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
