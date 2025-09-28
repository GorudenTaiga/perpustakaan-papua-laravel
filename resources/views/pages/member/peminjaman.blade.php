@extends('main_member')
@section('content')
    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">

                    <div class="table-responsive cart">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="card-title text-uppercase text-muted">Buku</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Jumlah Pinjam</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Tanggal Pinjam</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Tanggal Kadaluwarsa</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Tanggal Pengembalian
                                    </th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Status</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pinjaman->count() > 0)
                                    @foreach ($pinjaman as $p)
                                        <tr>
                                            {{-- Buku --}}
                                            <td scope="row" class="py-4">
                                                <div class="cart-info d-flex flex-wrap align-items-center mb-4">
                                                    <div class="col-lg-3">
                                                        <div class="card-image">
                                                            <img src="{{ $p->buku->banner_url }}" alt="cloth"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="card-detail ps-3">
                                                            <h5 class="card-title">
                                                                <a href="{{ route('buku', $p->buku->slug) }}"
                                                                    class="text-decoration-none">{{ $p->buku->judul }}</a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Jumlah Pinjaman --}}
                                            <td class="py-4">
                                                <div class="input-group product-qty w-50">
                                                    <input type="text" readonly id="quantity"
                                                        value="{{ $p->quantity }}"
                                                        class="form-control input-number text-center">
                                                </div>
                                            </td>

                                            {{-- Tanggal Pinjam --}}
                                            <td class="py-4">
                                                <div class="total-price">
                                                    <span class="money text-dark">{{ $p->loan_date }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="total-price">
                                                    <span class="money text-dark">{{ $p->due_date }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="total-price">
                                                    <span
                                                        class="money text-dark">{{ $p->return_date ?? 'Belum dikembalikan' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="total-price">
                                                    <span
                                                        class="money text-dark">{{ Str::of($p->status)->replace('_', ' ')->title() }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="total-price">
                                                    <span
                                                        class="money text-dark">{{ $p->final_price == 0 ? 'Gratis (Tidak ada Denda)' : $p->final_price }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="py-4 text-center" colspan="7">
                                            <div>
                                                <span>
                                                    Data Pinjaman Tidak Tersedia
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>
        </div>
    </section>
@endsection
