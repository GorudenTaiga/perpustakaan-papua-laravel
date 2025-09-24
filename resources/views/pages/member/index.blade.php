@extends('main_member')
@section('content')
    {{-- Hero --}}
    <section class="py-3"
        style="background-image: url('users/images/library-hero.jpg');background-repeat: no-repeat;background-size: cover;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="banner-blocks">

                        <div class="banner-ad large bg-primary block-1">

                            <div class="swiper main-swiper">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <div class="row banner-content p-5">
                                            <div class="content-wrapper col-md-7">
                                                <div class="categories my-3">Discover Knowledge</div>
                                                <h3 class="display-4">Explore Our Digital Library Collection</h3>
                                                <p>Browse thousands of books across all genres. From classic literature to
                                                    modern bestsellers, find your next great read with our comprehensive
                                                    digital library system.</p>
                                                <a href="{{ route('allBuku') }}"
                                                    class="btn btn-outline-light btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Browse
                                                    Books</a>
                                            </div>
                                            <div class="img-wrapper col-md-5">
                                                <img src="{{ asset('images/buku_dashboard.png') }}" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide">
                                        <div class="row banner-content p-5">
                                            <div class="content-wrapper col-md-7">
                                                <div class="categories mb-3 pb-3">New Arrivals</div>
                                                <h3 class="banner-title">Latest Additions to Our Collection</h3>
                                                <p>Discover the newest books added to our library. Stay updated with the
                                                    latest publications and trending titles across all categories.</p>
                                                <a href="{{ route('allBuku') }}"
                                                    class="btn btn-outline-light btn-lg text-uppercase fs-6 rounded-1">View
                                                    New Books</a>
                                            </div>
                                            <div class="img-wrapper col-md-5">
                                                <img src="users/images/new-books.png" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide">
                                        <div class="row banner-content p-5">
                                            <div class="content-wrapper col-md-7">
                                                <div class="categories mb-3 pb-3">Digital Access</div>
                                                <h3 class="banner-title">24/7 Digital Library Access</h3>
                                                <p>Access our complete library collection anytime, anywhere. Borrow books
                                                    digitally and read on any device with our modern library management
                                                    system.</p>
                                                <a href="{{ route('allBuku') }}"
                                                    class="btn btn-outline-light btn-lg text-uppercase fs-6 rounded-1">Start
                                                    Reading</a>
                                            </div>
                                            <div class="img-wrapper col-md-5">
                                                <img src="users/images/digital-library.png" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-pagination"></div>

                            </div>
                        </div>

                        <div class="banner-ad bg-success-subtle block-2"
                            style="background:url('users/images/library-categories.jpg') no-repeat;background-position: right bottom">
                            <div class="row banner-content p-5">

                                <div class="content-wrapper col-md-7">
                                    <div class="categories sale mb-3 pb-3">Browse Categories</div>
                                    <h3 class="banner-title">Explore by Genre</h3>
                                    <a href="{{ route('allCategories') }}" class="d-flex align-items-center nav-link">View
                                        All Categories <svg width="24" height="24">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg></a>
                                </div>

                            </div>
                        </div>

                        <div class="banner-ad bg-info block-3"
                            style="background:url('users/images/ebooks.jpg') no-repeat;background-position: right bottom">
                            <div class="row banner-content p-5">

                                <div class="content-wrapper col-md-7">
                                    <div class="categories sale mb-3 pb-3">Digital Collection</div>
                                    <h3 class="item-title">E-Books & Digital Resources</h3>
                                    <a href="{{ route('allBuku') }}" class="d-flex align-items-center nav-link">Browse
                                        E-Books <svg width="24" height="24">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg></a>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- / Banner Blocks -->

                </div>
            </div>
        </div>
    </section>

    {{-- Category --}}
    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Book Categories</h2>

                        <div class="d-flex align-items-center">
                            <a href="{{ route('allCategories') }}" class="btn-link text-decoration-none">View All Categories
                                →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            @if (isset($categories))
                                @foreach ($categories as $c)
                                    <a href="{{ route('category', $c->nama) }}" class="nav-link category-item swiper-slide">
                                        @if ($c->image)
                                            <img src="{{ asset($c->image) }}" alt="Category Thumbnail">
                                        @endif
                                        <h3 class="category-title">{{ $c->nama }}</h3>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Trending Products --}}
    <section class="py-5">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="bootstrap-tabs product-tabs">
                        <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                            <h3>Buku Terbaru</h3>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a href="{{ route('allBuku') }}" class="nav-link text-uppercase fs-6">Lebih Banyak</a>
                                </div>
                            </nav>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                aria-labelledby="nav-all-tab">

                                <div
                                    class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

                                    @foreach ($books as $b)
                                        <div class="col">
                                            <div class="product-item">
                                                <a href="#" class="btn-wishlist"><svg width="24"
                                                        height="24">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a>
                                                <figure>
                                                    <a href="{{ route('buku', $b->slug) }}" title="Product Title">
                                                        <img src="{{ $b->banner_url }}" class="tab-image">
                                                    </a>
                                                </figure>
                                                <h3>{{ $b->judul }}</h3>
                                                <span class="qty">{{ $b->stock }} Unit</span><span
                                                    class="rating"><svg width="24" height="24"
                                                        class="text-primary">
                                                        <use xlink:href="#star-solid"></use>
                                                    </svg> {{ $b->rating }}</span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a href="#" class="nav-link">Pinjam</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- / product-grid -->

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
