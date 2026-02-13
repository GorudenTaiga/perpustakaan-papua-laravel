@extends('main_member')
@section('content')
    {{-- Breadcrumb Section --}}
    <section class="bg-gradient-to-br from-indigo-50 to-purple-50 py-8">
        <div class="container mx-auto px-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Home
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('allBuku') }}"
                    class="text-gray-600 hover:text-indigo-600 transition-colors font-medium">Books</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-semibold">{{ Str::limit($buku->judul, 50) }}</span>
            </nav>
        </div>
    </section>

    {{-- Book Detail Section --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12">
                {{-- Book Image --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <div
                            class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl overflow-hidden shadow-2xl border border-gray-200 group">
                            <div class="aspect-[3/4] relative overflow-hidden">
                                <img src="{{ $buku->image ? asset('storage/' . $buku->image) : asset('images/placeholder.png') }}"
                                    alt="{{ $buku->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-bold rounded-full shadow-xl">
                                        {{ $buku->tahun ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Book Info --}}
                <div class="lg:col-span-1">
                    <div class="space-y-6">
                        {{-- Title and Rating --}}
                        <div class="space-y-4">
                            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                                {{ $buku->judul }}
                            </h1>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-4" x-data="{ showModal: false }">
                            @if (Auth::check() && Auth::user()->role == 'member' && Auth::user()->member->verif)
                                <button type="button" @click="showModal = true"
                                    class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Borrow This Book
                                </button>

                                {{-- Tailwind Modal --}}
                                <div x-show="showModal" 
                                     x-cloak
                                     @keydown.escape.window="showModal = false"
                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                     aria-labelledby="modal-title" 
                                     role="dialog" 
                                     aria-modal="true">
                                    {{-- Backdrop --}}
                                    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                                         @click="showModal = false"
                                         x-show="showModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"></div>

                                    {{-- Modal Panel --}}
                                    <div class="flex min-h-screen items-center justify-center p-4">
                                        <div x-show="showModal"
                                             x-transition:enter="ease-out duration-300"
                                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave="ease-in duration-200"
                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
                                             @click.stop>
                                            
                                            <form action="{{ route('pinjam.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                                                {{-- Modal Header --}}
                                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                                </path>
                                                            </svg>
                                                            Borrow Book
                                                        </h3>
                                                        <button type="button" @click="showModal = false"
                                                            class="text-white hover:text-gray-200 transition-colors">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Modal Body --}}
                                                <div class="p-6 space-y-4">
                                                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-4">
                                                        <p class="text-sm text-gray-700 font-semibold">{{ $buku->judul }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">by {{ $buku->author }}</p>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <label for="jumlah" class="block text-sm font-bold text-gray-900">Number of Books</label>
                                                        <input type="number" id="jumlah" name="quantity"
                                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all @error('quantity') border-red-500 @enderror"
                                                            min="1" max="{{ $buku->stock ?? 1 }}" value="{{ old('quantity', 1) }}" required>
                                                        @error('quantity')
                                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                                        @enderror
                                                        <p class="text-xs text-gray-500 mt-1">Available stock: {{ $buku->stock ?? 0 }} book(s)</p>
                                                    </div>
                                                </div>

                                                {{-- Modal Footer --}}
                                                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                                                    <button type="button" @click="showModal = false"
                                                        class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-colors">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                                                        Confirm Borrow
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @elseif (Auth::check() && Auth::user()->role == 'member' && !Auth::user()->member->verif)
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center gap-3 px-8 py-4 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    Account Not Verified
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Login to Borrow
                                </a>
                            @endif
                        </div>

                        {{-- Book Meta Information --}}
                        <div
                            class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 space-y-4 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Book Information</h3>

                            <div class="grid gap-4">
                                {{-- Author --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Author</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $buku->author ?? 'Unknown' }}</p>
                                    </div>
                                </div>

                                {{-- Publisher --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Publisher</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $buku->publisher ?? 'Unknown' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Year --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Publication Year</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $buku->tahun ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                {{-- Categories --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Categories</p>
                                        <div class="flex flex-wrap gap-2 mt-1">
                                            @foreach ($buku->categories() as $c)
                                                <a href="{{ route('allBuku', ['category[]' => $c->id]) }}"
                                                    class="inline-block px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-700 hover:border-indigo-500 hover:text-indigo-600 transition-colors">
                                                    {{ $c->nama }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Stock --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Available Stock</p>
                                        <p
                                            class="text-sm font-semibold {{ ($buku->stock ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $buku->stock ?? 0 }} {{ ($buku->stock ?? 0) > 1 ? 'Books' : 'Book' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Book Description Section --}}
    <section class="py-12 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Book Description
                    </h2>
                </div>
                <div class="p-8">
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! $buku->deskripsi ?: '<p class="text-gray-500 italic">No description available for this book.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <style>
        .prose {
            color: #374151;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        .prose h1,
        .prose h2,
        .prose h3,
        .prose h4,
        .prose h5,
        .prose h6 {
            color: #111827;
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .prose ul,
        .prose ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        .prose a {
            color: #4f46e5;
            text-decoration: none;
        }

        .prose a:hover {
            color: #6366f1;
            text-decoration: underline;
        }

        .prose strong {
            color: #111827;
            font-weight: 600;
        }

        .prose code {
            background-color: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        /* Alpine.js cloak */
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
