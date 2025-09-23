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

        /* Ukuran kartu: 8.6cm x 5.4cm */
        .kartu {
            width: 8.6cm;
            height: 5.4cm;
            border: 1px solid #000;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            /* Pastikan padding dan border dihitung dalam ukuran total */
        }

        /* HEADER */
        /* ... (bagian ini tidak berubah) ... */

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

        /* FOOTER */
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
    </style>
</head>

<body>
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
            <div>{{ $member->membership_number }}</div>
        </div>
        {{-- <div class="ttd">
            <div>Jayapura, {{ \Carbon\Carbon::now() }}</div>
            <img src="{{ asset('signature.png') }}" alt="Tanda Tangan">
            <div>Kepala Perpustakaan</div>
        </div> --}}
    </div>
</body>

</html>
