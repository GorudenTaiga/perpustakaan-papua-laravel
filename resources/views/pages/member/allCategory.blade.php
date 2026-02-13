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
                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                        </path>
                    </svg>
                    <span class="text-sm font-semibold">Explore Categories</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    Book <span class="text-yellow-300">Categories</span>
                </h1>
                <p class="text-lg lg:text-xl text-white/90 max-w-2xl leading-relaxed">
                    Browse books by category and discover your next favorite read across all genres.
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 bg-white -mt-20 relative z-20">
        <div class="container mx-auto px-4">
            {{-- Info Bar --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="text-sm text-gray-600">
                        Showing <span class="font-semibold text-gray-900">{{ count($categories) }}</span> categories
                    </div>
                </div>
            </div>

            {{-- Category Grid --}}
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($categories as $c)
                    <a href="{{ route('allBuku', ['category[]' => $c->id]) }}"
                        class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-indigo-200 block">
                        <div class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 aspect-[4/3]">
                            @if ($c->image)
                                <img src="{{ asset($c->image) }}" alt="{{ $c->nama }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                    <svg class="w-20 h-20 text-indigo-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                <div class="flex items-center text-white text-sm font-semibold">
                                    <span>Browse Books</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-900 group-hover:text-indigo-600 transition-colors text-center"
                                title="{{ $c->nama }}">
                                {{ $c->nama }}
                            </h3>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 mb-6">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Categories Found</h3>
                        <p class="text-gray-600 mb-6">There are no categories available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
