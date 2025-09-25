@extends('main_member')
@section('content')
    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Book Categories</h2>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="product-grid row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                        @if (isset($categories))
                            @foreach ($categories as $c)
                                <div class="col d-flex">
                                    <div class="product-item card h-100 w-100 d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            {{-- Figure untuk gambar --}}
                                            <figure class="product-figure align-center justify-content-center">
                                                <a href="{{ route('allBuku', ['category[]' => $c->id]) }}"
                                                    class="nav-link category-item swiper-slide">
                                                    @if ($c->image)
                                                        <img src="{{ asset($c->image) }}" alt="Category Thumbnail">
                                                    @endif
                                                </a>
                                            </figure>

                                            {{-- Konten teks --}}
                                            <h3 class="product-title text-center" title="{{ $c->nama }}">
                                                {{ $c->nama }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
