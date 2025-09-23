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
            margin-top: 5px;
            display: block;
        }

        .content table {
            width: 100%;
            font-size: 11px;
        }

        .content td {
            padding: 1px 3px;
            vertical-align: top;
        }

        /* FOOTER pakai flex agar tidak error */
        .footer {
            /* position: absolute; */
            bottom: 5px;
            left: 20px;
            margin-left: 20px;
            right: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 9px;
        }

        .barcode {
            text-align: center;
            width: 55%;
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
            <img src="{{ asset('logo.png') }}" alt="Logo">
            <div><b>KARTU ANGGOTA PERPUSTAKAAN</b></div>
            <div><b>PERPUSTAKAAN PROVINSI PAPUA</b></div>
            <div class="sub-header">
                JL. Raya Kota Raja No.84, Mandala, Kec. Jayapura Utara, Kota Jayapura, Papua
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content">
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

        {{-- FOOTER --}}
        <div class="footer">
            <div class="barcode">
                {!! $barcode->getBarcodeHTML($member->membership_number, 'C39', 1, 20) !!}
                <div>{{ $member->membership_number }}</div>
            </div>
            <div class="ttd">
                <div>Jayapura, {{ now()->format('d F Y') }}</div>
                <div>Kepala Perpustakaan</div>
                <img src="{{ public_path('ttd.png') }}" alt="Tanda Tangan">
                <div><b>ACHMAD DJALALI, SH</b></div>
            </div>
        </div>
    </div>
</body>

</html>

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KTA - {{ $member->user->name }}</title>
    <style>
        .card {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .header {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .body {
            display: flex;
            padding: 10px;
        }

        .photo {
            width: 100px;
            height: 120px;
            margin-right: 10px;
        }

        .details p {
            margin: 5px 0;
        }

        .details span {
            font-weight: bold;
        }

        .footer {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <img src="path/to/logo.png" alt="Logo" class="logo">
            <h1>PEMERINTAH PROVINSI PAPUA</h1>
            <h2>DINAS ARSIP DAN PERPUSTAKAAN DAERAH</h2>
            <p>JL. Raya Abepura - Kotaraja No. 84 Jayapura - Papua</p>
        </div>
        <div class="body">
            <img src="path/to/photo.png" alt="Photo" class="photo">
            <div class="details">
                <p><span>Nomor:</span> {{ $member->membership_number }}</p>
                <p><span>Nama:</span> {{ $member->user->name }}</p>
                <p><span>Jenis:</span> Mahasiswa</p>
                <p><span>Berlaku Hingga:</span> 25-03-2027</p>
            </div>
        </div>
        <div class="footer">
            {!! $barcode->getBarcodeHTML($member->membership_number, 'C39', 1, 20) !!}
        </div>
    </div>
</body>

</html> --}}
