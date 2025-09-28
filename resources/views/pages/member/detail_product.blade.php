@extends('main_member')
@section('content')
    <section id="selling-product" class="single-product mt-0 mt-md-5">
        <div class="container-fluid">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="{{ route('dashboard') }}">Home</a>
                <a class="breadcrumb-item" href="{{ route('allBuku') }}">List Buku</a>
                <span class="breadcrumb-item active" aria-current="page">{{ $buku->judul }}</span>
            </nav>
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="row flex-column-reverse flex-lg-row">

                        <div class="col-md-12 col-lg-10">
                            <!-- product-large-slider -->
                            <div class="swiper product-large-slider swiper-fade swiper-horizontal swiper-watch-progress">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="image-zoom" data-scale="2.5"
                                            data-image="{{ $buku->banner_url ?? asset('users/images/book-placeholder.jpg') }}">
                                            <img src="{{ $buku->banner_url ?? asset('users/images/book-placeholder.jpg') }}"
                                                alt="{{ $buku->judul }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <!-- / product-large-slider -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="product-info">
                        <div class="element-header">
                            <h2 itemprop="name" class="display-6">{{ $buku->judul }}</h2>
                            <div class="rating-container d-flex gap-0 align-items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="rating" data-rating="{{ $i }}">
                                        <svg width="24" height="24"
                                            class="{{ $i <= $buku->rating ? 'text-primary' : 'text-secondary' }}">
                                            <use xlink:href="#star-solid"></use>
                                        </svg>
                                    </div>
                                @endfor
                                <span class="rating-count">({{ $buku->rating }})</span>
                            </div>
                        </div>

                        <div class="cart-wrap">
                            <div class="product-quantity">
                                <div class="stock-button-wrap">
                                    <div class="qty-button d-flex flex-wrap pt-3">
                                        @if (Auth::check() && Auth::user()->role == 'member' && Auth::user()->member->verif)
                                            <button type="button"
                                                class="btn btn-primary py-3 px-4 text-uppercase me-3 mt-3"
                                                data-bs-toggle="modal" data-bs-target="#pinjamModal">
                                                <i class="fas fa-book me-2"></i>Borrow Book
                                            </button>
                                        @elseif (Auth::check() && Auth::user()->role == 'member' && !Auth::user()->member->verif)
                                            <a href="{{ route('dashboard') }}">
                                                <button type="submit"
                                                    class="btn btn-primary py-3 px-4 text-uppercase me-3 mt-3">
                                                    <i class="fas fa-book me-2"></i>Account not verified
                                                </button>
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}">
                                                <button type="submit"
                                                    class="btn btn-primary py-3 px-4 text-uppercase me-3 mt-3">
                                                    <i class="fas fa-book me-2"></i>Login terlebih dahulu
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="meta-product py-2">
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Author:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <li class="select-item">{{ $buku->author }}</li>
                                </ul>
                            </div>
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Publisher:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <li class="select-item">{{ $buku->publisher }}</li>
                                </ul>
                            </div>
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Tahun Rilis:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <li class="select-item">{{ $buku->year }}</li>
                                </ul>
                            </div>
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Kategory:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    @foreach ($buku->categories() as $c)
                                        <li class="select-item">
                                            <a
                                                href="{{ route('allBuku', ['category[]' => $c->id]) }}">{{ $c->nama }}</a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Stok:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <li class="select-item">Tersedia {{ $buku->stock ?? 0 }} Buku</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (Auth::check() && Auth::user()->role == 'member' && Auth::user()->member->verif)
        <!-- Modal Pinjam Buku -->
        <div class="modal fade" id="pinjamModal" tabindex="-1" aria-labelledby="pinjamModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('pinjam.store') }}" method="POST" class="modal-content">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="pinjamModalLabel">Pinjam Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Buku</label>
                            <input type="number" id="jumlah" name="quantity" class="form-control" min="1"
                                max="{{ $buku->stock ?? 1 }}" value="1" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Pinjam</button>
                    </div>
                </form>
            </div>
        </div>
    @endif



    <section class="product-info-tabs py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="d-flex flex-column flex-md-row align-items-start gap-5">
                    <div class="nav flex-row flex-wrap flex-md-column nav-pills me-3 col-lg-3" id="v-pills-tab"
                        role="tablist" aria-orientation="vertical">
                        <button class="nav-link text-start active" id="v-pills-description-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-description" type="button" role="tab"
                            aria-controls="v-pills-description" aria-selected="true">Informasi Buku</button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-description" role="tabpanel"
                            aria-labelledby="v-pills-description-tab" tabindex="0">
                            <h5>Deskripsi Buku</h5>
                            {!! $buku->deskripsi !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
