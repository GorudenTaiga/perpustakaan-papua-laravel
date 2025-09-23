@extends('main_member')
@section('content')
    <section id="profile-page" class="single-profile mt-0 mt-md-5">
        <div class="container-fluid">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="{{ route('dashboard') }}">Home</a>
                <span class="breadcrumb-item active" aria-current="page">Profile</span>
            </nav>

            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="row flex-column-reverse flex-lg-row">
                        <div class="col-md-12 col-lg-10">
                            <!-- profile picture -->
                            <div class="swiper profile-large-slider swiper-fade swiper-horizontal">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="image-zoom" data-scale="2.5"
                                            data-image="{{ $member->image ?? asset('users/images/profile-placeholder.png') }}">
                                            <img src="{{ $member->image ?? asset('users/images/profile-placeholder.png') }}"
                                                alt="{{ $member->user->name }}" class="img-fluid rounded-circle shadow-lg">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <!-- / profile picture -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="profile-info">
                        <div class="element-header">
                            <h2 itemprop="name" class="display-6">{{ $member->user->name }}</h2>
                            <div class="rating-container d-flex gap-0 align-items-center">
                                <span class="badge bg-primary text-uppercase">{{ $member->user->role }}</span>
                            </div>
                        </div>

                        <div class="meta-profile py-3">
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Email:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <li class="select-item">{{ $member->user->email }}</li>
                                </ul>
                            </div>
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Bergabung:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <li class="select-item">{{ $member->user->created_at->format('d M Y') }}</li>
                                </ul>
                            </div>
                            <div class="meta-item d-flex align-items-baseline">
                                <h6 class="item-title no-margin pe-2">Terakhir Login:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <li class="select-item">{{ $member->user->last_login_at?->diffForHumans() ?? '-' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="action-buttons d-flex flex-wrap gap-3">
                            {{-- <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a> --}}
                            <a href="{{ route('logout') }}" class="btn btn-outline-danger px-4 py-2">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="profile-info-tabs py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="d-flex flex-column flex-md-row align-items-start gap-5">
                    <div class="nav flex-row flex-wrap flex-md-column nav-pills me-3 col-lg-3" id="v-pills-tab"
                        role="tablist" aria-orientation="vertical">
                        {{-- <button class="nav-link text-start active" id="v-pills-bio-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-bio" type="button" role="tab" aria-controls="v-pills-bio"
                            aria-selected="true">Bio</button> --}}

                        <button class="nav-link text-start" id="v-pills-loans-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-loans" type="button" role="tab" aria-controls="v-pills-loans"
                            aria-selected="false">Riwayat Peminjaman</button>
                    </div>

                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Bio Tab -->
                        {{-- <div class="tab-pane fade show active" id="v-pills-bio" role="tabpanel"
                            aria-labelledby="v-pills-bio-tab" tabindex="0">
                            <h5>Tentang Saya</h5>
                            <p>{{ $user->bio ?? 'Belum ada deskripsi.' }}</p>
                        </div> --}}

                        <!-- Riwayat Peminjaman Tab -->
                        <div class="tab-pane fade" id="v-pills-loans" role="tabpanel" aria-labelledby="v-pills-loans-tab"
                            tabindex="0">
                            <h5>Riwayat Peminjaman</h5>
                            <ul class="list-group">
                                @foreach ($pinjaman as $loan)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $loan->buku->judul }}
                                        <span class="badge bg-secondary">{{ $loan->loan_date }}</span>
                                    </li>
                                    @empty($loan)
                                        <li class="list-group-item">Belum ada peminjaman.</li>
                                    @endempty
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
