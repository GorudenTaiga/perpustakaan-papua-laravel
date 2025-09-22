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

                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            @if (isset($categories))
                                @foreach ($categories as $c)
                                    <a href="{{ route('allBuku', ['category[]' => $c->id]) }}"
                                        class="nav-link category-item swiper-slide">
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
@endsection
