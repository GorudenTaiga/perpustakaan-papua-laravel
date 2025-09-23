@extends('main_member')
@section('content')
    <section class="py-5 mb-5" style="background: url(images/background-pattern.jpg);">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1 class="page-title pb-2">List Buku</h1>
            </div>
        </div>
    </section>
    <div class="shopify-grid">
        <div class="container-fluid">
            <div class="row g-5">
                <aside class="col-md-2">
                    <div class="sidebar">
                        <div class="widget-menu">
                            <div class="widget-search-bar">
                                <form role="search" action="{{ route('allBuku') }}" method="get"
                                    class="d-flex position-relative">

                                    <input class="form-control form-control-lg rounded-2 bg-light" type="text"
                                        placeholder="Cari Judul" aria-label="Search here" name="search">
                                    <button class="btn bg-transparent position-absolute end-0" type="submit"><svg
                                            width="24" height="24" viewBox="0 0 24 24">
                                            <use xlink:href="#search"></use>
                                        </svg></button>
                                </form>

                            </div>
                        </div>
                        <div class="widget-product-categories pt-5">
                            <h5 class="widget-title">Categories</h5>
                            <form action="{{ route('allBuku') }}" method="GET">
                                <ul class="product-categories sidebar-list list-unstyled">
                                    <li class="cat-item">
                                        <input type="checkbox" name="category[]" value="all" onclick="this.form.submit()"
                                            {{ in_array('all', (array) request('category')) ? 'checked' : '' }}>
                                        All
                                    </li>

                                    @foreach ($categories as $c)
                                        <li class="cat-item">
                                            <input type="checkbox" name="category[]" value="{{ $c->id }}"
                                                onclick="this.form.submit()"
                                                {{ in_array($c->id, (array) request('category')) ? 'checked' : '' }}>
                                            {{ $c->nama }}
                                        </li>
                                    @endforeach
                                </ul>
                            </form>
                        </div>
                    </div>
                </aside>

                <main class="col-md-10">
                    <div class="filter-shop d-flex justify-content-between">
                        <div class="showing-product">
                            {{-- <p>Showing 1–9 of 55 results</p> --}}
                            <p>Memperlihatkan 1 - {{ $buku->perPage() }} dari {{ $buku->total() }}</p>
                        </div>
                        <div class="sort-by">
                            <form action="{{ route('allBuku') }}" method="GET">
                                <select id="input-sort" class="form-control" name="sortBy" onchange="this.form.submit()">
                                    <option value="default" {{ request('sortBy') == 'default' ? 'selected' : '' }}>Default
                                        sorting</option>
                                    <option value="judulAZ" {{ request('sortBy') == 'judulAZ' ? 'selected' : '' }}>Judul (A
                                        - Z)</option>
                                    <option value="judulZA" {{ request('sortBy') == 'judulZA' ? 'selected' : '' }}>Judul (Z
                                        - A)</option>
                                    <option value="rateH" {{ request('sortBy') == 'rateH' ? 'selected' : '' }}>Rating
                                        (Highest)</option>
                                    <option value="rateL" {{ request('sortBy') == 'rateL' ? 'selected' : '' }}>Rating
                                        (Lowest)</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="product-grid row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                        @foreach ($buku->items() as $b)
                            <div class="col d-flex">
                                <div class="product-item card h-100 w-100 d-flex flex-column">
                                    <a href="#" class="btn-wishlist">
                                        <svg width="24" height="24">
                                            <use xlink:href="#heart"></use>
                                        </svg>
                                    </a>

                                    {{-- Figure untuk gambar --}}
                                    <figure class="product-figure">
                                        <a href="{{ route('buku', $b->slug) }}" title="{{ $b->judul }}">
                                            <img src="{{ $b->banner_url }}" alt="Product Thumbnail" class="tab-image">
                                        </a>
                                    </figure>

                                    {{-- Konten teks --}}
                                    <div class="card-body d-flex flex-column">
                                        <h3 class="product-title" title="{{ $b->judul }}">
                                            {{ $b->judul }}
                                        </h3>
                                        <span class="qty">1 Unit</span>
                                        <span class="rating">
                                            <svg width="24" height="24" class="text-primary">
                                                <use xlink:href="#star-solid"></use>
                                            </svg>{{ $b->rating }}
                                        </span>
                                        <div class="mt-auto d-flex align-items-center justify-content-between">
                                            <a href="{{ route('buku', $b->slug) }}" class="nav-link">Detail <svg
                                                    width="18" height="18"></svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- / product-grid -->

                    <nav class="text-center py-4" aria-label="Page navigation">
                        <ul class="pagination d-flex justify-content-center">
                            {{-- Previous --}}
                            <li class="page-item {{ $buku->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-none border-0" href="{{ $buku->previousPageUrl() ?? '#' }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                </a>
                            </li>

                            {{-- Numbered Links --}}
                            @foreach ($buku->links()->elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                    <li class="page-item disabled">
                                        <span class="page-link border-0">{{ $element }}</span>
                                    </li>
                                @endif

                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        <li class="page-item {{ $page == $buku->currentPage() ? 'active' : '' }}">
                                            <a class="page-link border-0" href="{{ $url }}">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next --}}
                            <li class="page-item {{ !$buku->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link border-0" href="{{ $buku->nextPageUrl() ?? '#' }}" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                </a>
                            </li>
                        </ul>
                    </nav>


                </main>

            </div>
        </div>
    </div>
@endsection
