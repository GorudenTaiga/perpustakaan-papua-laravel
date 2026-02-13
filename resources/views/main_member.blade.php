<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - Perpustakaan Provinsi Papua</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .add-to-wishlist.active svg {
            fill: #ef4444;
            stroke: #ef4444;
        }
    </style>
</head>

<body class="min-h-screen bg-white">
    <!-- Main Background Wrapper -->
    <div class="min-h-screen bg-white">

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <defs>
                <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
                    <path fill="currentColor"
                        d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
                    <path fill="currentColor"
                        d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="menu" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M3 6h18v2H3V6m0 5h18v2H3v-2m0 5h18v2H3v-2Z" />
                </symbol>
            </defs>
        </svg>

        <!-- Loading Animation -->
        <div id="preloader"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600">
            <div class="relative">
                <div class="w-20 h-20 border-4 border-white/30 border-t-white rounded-full animate-spin"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <svg class="w-8 h-8 text-white animate-pulse" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <script>
            // Hide preloader when page is loaded
            window.addEventListener('load', function() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    preloader.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 300);
                }
            });
        </script>

        <!-- Search Sidebar -->
        <div x-data="{ open: false }" @keydown.escape.window="open = false">
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
                @click="open = false" style="display: none;">
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="fixed right-0 top-0 z-50 h-full w-full sm:w-96 glass shadow-2xl" style="display: none;">
                <div class="flex h-full flex-col">
                    <div class="flex items-center justify-between border-b border-gray-200/50 p-6">
                        <h3 class="text-xl font-bold text-gray-800">Search Books</h3>
                        <button @click="open = false" class="rounded-lg p-2 hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-6">
                        <form role="search" action="{{ route('allBuku') }}" method="get" class="space-y-4">
                            <div class="relative">
                                <input
                                    class="w-full rounded-xl border-2 border-gray-200 bg-white px-5 py-4 pr-12 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 transition-all"
                                    type="text" placeholder="Search by title, author, or ISBN..."
                                    aria-label="Search" name="search" autocomplete="off">
                                <button
                                    class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 p-2 text-white hover:from-indigo-700 hover:to-purple-700 transition-all"
                                    type="submit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist Sidebar -->
        <div x-data="{ wishlistOpen: false }" @keydown.escape.window="wishlistOpen = false">
            <div x-show="wishlistOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
                @click="wishlistOpen = false" style="display: none;">
            </div>

            <div x-show="wishlistOpen" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="fixed right-0 top-0 z-50 h-full w-full sm:w-96 glass shadow-2xl" style="display: none;">
                <div class="flex h-full flex-col">
                    <div
                        class="flex items-center justify-between border-b border-gray-200/50 bg-gradient-to-r from-pink-500 to-rose-500 p-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <use xlink:href="#heart"></use>
                            </svg>
                            My Wishlist
                        </h3>
                        <button @click="wishlistOpen = false"
                            class="rounded-lg p-2 hover:bg-white/20 transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-6">
                        @if (Auth::check())
                            @if (isset($wishlist) && count($wishlist) > 0)
                                <div class="space-y-4">
                                    @foreach ($wishlist as $item)
                                        @if (!is_null($item->buku()))
                                            <div
                                                class="group relative overflow-hidden rounded-2xl bg-white p-4 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                                                <div class="flex gap-4">
                                                    <div
                                                        class="relative w-16 h-24 flex-shrink-0 overflow-hidden rounded-lg">
                                                        <img src="{{ Storage::disk('public')->url($item->buku?->banner) }}"
                                                            alt="{{ $item->buku?->judul }}"
                                                            class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h4
                                                            class="font-semibold text-gray-900 text-sm line-clamp-2 mb-2">
                                                            {{ $item->buku?->judul }}</h4>
                                                        <a href="{{ route('buku', $item->buku?->slug) }}"
                                                            class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                                                            View Details
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-center py-12">
                                    <div
                                        class="w-24 h-24 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">No books yet</h4>
                                    <p class="text-sm text-gray-500 mb-4">Start adding books you love to your wishlist!
                                    </p>
                                    <a href="{{ route('allBuku') }}"
                                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-pink-500 to-rose-500 px-4 py-2 text-sm font-medium text-white hover:from-pink-600 hover:to-rose-600 transition-all">
                                        Browse Books
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-center py-12">
                                <div
                                    class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Please login</h4>
                                <p class="text-sm text-gray-500 mb-4">Login to view and manage your wishlist</p>
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-2 text-sm font-medium text-white hover:from-indigo-700 hover:to-purple-700 transition-all">
                                    Login Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Modern Header with Glassmorphism -->
        <header class="sticky top-0 z-40 backdrop-blur-xl bg-white/80 border-b border-gray-200/50 shadow-sm">
            <div class="container mx-auto px-4">
                <!-- Top Bar -->
                <div class="flex items-center justify-between py-4">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="relative">
                            <img src="{{ asset('logo.png') }}" alt="logo"
                                class="h-14 w-14 object-contain transition-transform group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 to-purple-600/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-lg font-bold text-gradient">Perpustakaan</h1>
                            <p class="text-xs text-gray-600 font-medium">Provinsi Papua</p>
                        </div>
                    </a>

                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center gap-1">
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('allBuku') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition-all {{ request()->routeIs('allBuku') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            Books
                        </a>
                        <a href="{{ route('allCategories') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition-all {{ request()->routeIs('allCategories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            Categories
                        </a>
                        @if (Auth::check() && Auth::user()->role == 'member')
                            <a href="{{ route('pinjam') }}"
                                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition-all {{ request()->routeIs('pinjam') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                My Loans
                            </a>
                            <a target="_blank"
                                href="{{ route('cetakKTA', base64_encode(Auth::user()->member->id)) }}"
                                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                Member Card
                            </a>
                        @endif
                    </nav>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <!-- Help Badge (Desktop Only) -->
                        <div
                            class="hidden xl:flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <div class="text-left">
                                <p class="text-xs text-gray-500">Need help?</p>
                                <p class="text-sm font-semibold text-gray-900">+62 877 4316 0171</p>
                            </div>
                        </div>

                        @if (Auth::user())
                            <!-- Wishlist Button -->
                            <button @click="wishlistOpen = true"
                                class="relative p-2.5 rounded-lg hover:bg-gradient-to-br hover:from-pink-50 hover:to-rose-50 text-gray-700 hover:text-pink-600 transition-all group">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <use xlink:href="#heart"></use>
                                </svg>
                                @if (isset($wishlist) && count($wishlist) > 0)
                                    <span
                                        class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-br from-pink-500 to-rose-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                                        {{ count($wishlist) }}
                                    </span>
                                @endif
                            </button>

                            <!-- User Profile -->
                            <a href="{{ Auth::user()->role == 'member' ? route('userProfile') : route('filament.admin.pages.dashboard') }}"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gradient-to-br hover:from-indigo-50 hover:to-purple-50 transition-all group">
                                <div
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span
                                    class="hidden md:block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">
                                    {{ Str::limit(Auth::user()->name, 15) }}
                                </span>
                            </a>
                        @else
                            <!-- Login Button -->
                            <a href="{{ route('login') }}"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <use xlink:href="#user"></use>
                                </svg>
                                <span class="hidden sm:inline">Login</span>
                            </a>
                        @endif

                        <!-- Mobile Menu Button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="lg:hidden p-2.5 rounded-lg hover:bg-gray-100 text-gray-700 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <use xlink:href="#menu"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-data="{ mobileMenuOpen: false }" x-show="mobileMenuOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                @click.away="mobileMenuOpen = false"
                class="lg:hidden border-t border-gray-200/50 bg-white/95 backdrop-blur-xl" style="display: none;">
                <div class="container mx-auto px-4 py-4 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('allBuku') }}"
                        class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('allBuku') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        Books
                    </a>
                    <a href="{{ route('allCategories') }}"
                        class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('allCategories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        Categories
                    </a>
                    @if (Auth::check() && Auth::user()->role == 'member')
                        <a href="{{ route('pinjam') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('pinjam') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            My Loans
                        </a>
                        <a target="_blank" href="{{ route('cetakKTA', base64_encode(Auth::user()->member->id)) }}"
                            class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            Member Card
                        </a>
                    @endif
                    <div class="pt-3 border-t border-gray-200">
                        <div
                            class="flex items-center gap-2 px-4 py-3 rounded-lg bg-gradient-to-r from-indigo-50 to-purple-50">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Need help?</p>
                                <p class="text-sm font-semibold text-gray-900">+62 877 4316 0171</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')

        {{-- <section class="py-5 my-5">
      <div class="container-fluid">

        <div class="bg-warning py-5 rounded-5" style="background-image: url('users/images/bg-pattern-2.png') no-repeat;">
          <div class="container">
            <div class="row">
              <div class="col-md-4">
                <img src="users/images/phone.png" alt="phone" class="image-float img-fluid">
              </div>
              <div class="col-md-8">
                <h2 class="my-5">Shop faster with foodmart App</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis sed ptibus liberolectus nonet psryroin. Amet sed lorem posuere sit iaculis amet, ac urna. Adipiscing fames semper erat ac in suspendisse iaculis. Amet blandit tortor praesent ante vitae. A, enim pretiummi senectus magna. Sagittis sed ptibus liberolectus non et psryroin.</p>
                <div class="d-flex gap-2 flex-wrap">
                  <img src="users/images/app-store.jpg" alt="app-store">
                  <img src="users/images/google-play.jpg" alt="google-play">
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </section> --}}

        @include('components.member_footer')

    </div>
    <!-- End Main Background Wrapper -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/modal-system.js') }}"></script>
</body>
@yield('js')

</html>
