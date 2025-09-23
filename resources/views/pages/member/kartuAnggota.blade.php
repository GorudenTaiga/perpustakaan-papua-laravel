@php
    $barcode = new Milon\Barcode\DNS1D(); // untuk barcode 1D (C39)
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>KTA - {{ $member->user->name }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        /* Ukuran kartu: 8.6cm x 5.4cm */
        .kartu {
            height: 5.4cm;
            border: 1px solid #000;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            /* Pastikan padding dan border dihitung dalam ukuran total */
        }

        /* HEADER */
        .header {
            background: #00923f;
            color: white;
            text-align: center;
            padding: 4px;
            font-size: 12px;
            line-height: 1.3;
            position: relative;
        }

        .header img {
            position: absolute;
            top: 6px;
            left: 8px;
            width: 40px;
        }

        .sub-header {
            font-size: 9px;
        }

        /* CONTENT */
        .content {
            padding: 5px 10px;
        }

        .card-body {
            display: flex;
            /* Aktifkan Flexbox untuk menata foto dan detail */
            align-items: center;
            /* Posisikan elemen di tengah secara vertikal */
            gap: 10px;
            /* Jarak antara foto dan detail */
        }

        .photo img {
            width: 70px;
            /* Ukuran foto yang lebih jelas */
            height: 90px;
            border: 1px solid #ccc;
            object-fit: cover;
            /* Pastikan foto tidak terdistorsi */
        }

        .details table {
            width: 100%;
            font-size: 11px;
        }

        .details td {
            padding: 1px 3px;
            vertical-align: top;
        }

        /* FOOTER pakai flex agar tidak error */
        .footer {
            position: absolute;
            /* Posisikan secara absolut di dalam .kartu */
            bottom: 5px;
            left: 10px;
            right: 10px;
            display: flex;
            /* Aktifkan Flexbox untuk menata barcode */
            justify-content: flex-start;
            /* Posisikan elemen di awal (kiri) */
            align-items: flex-end;
            font-size: 9px;
        }

        .barcode {
            text-align: center;
        }

        .barcode div {
            margin-top: 2px;
            font-size: 9px;
        }

        .ttd {
            text-align: right;
            width: 40%;
            font-size: 9px;
        }

        .ttd img {
            width: 50px;
            display: block;
            margin-left: auto;
            margin-bottom: 2px;
        }
    </style>
</head>

<body>
    <div class="kartu">
        {{-- HEADER --}}
        <div class="header">
            <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(asset('icon.png'))) }}"
                alt="Logo">
            <div><b>KARTU ANGGOTA PERPUSTAKAAN</b></div>
            <div><b>PERPUSTAKAAN PROVINSI PAPUA</b></div>
            <div class="sub-header">
                JL. Raya Kota Raja No.84, Mandala, Kec. Jayapura Utara, Kota Jayapura, Papua
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content">
            {{-- Ini adalah wadah utama untuk foto dan detail --}}
            <div class="card-body">
                <div class="photo">
                    <img src="{{ $member->image }}" alt="Foto Member">
                </div>
                <div class="details">
                    <table>
                        <tr>
                            <td>Nomor Anggota</td>
                            <td>: {{ $member->membership_number }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $member->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Jenis</td>
                            <td>: {{ $member->jenis }}</td>
                        </tr>
                        <tr>
                            <td>Berlaku hingga</td>
                            <td>: {{ $member->valid_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <div class="barcode">
                {!! $barcode->getBarcodeHTML($member->membership_number, 'C39', 1, 20) !!}
                {{ $member->membership_number }}
            </div>
            {{-- <div class="ttd">
                <div>Jayapura, {{ $today->isoFormat('D MMMM Y') }}</div>
                <img src="{{ asset('signature.png') }}" alt="Tanda Tangan">
                <div>Kepala Perpustakaan</div>
            </div> --}}
        </div>
    </div>
</body>

</html>
