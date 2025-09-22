@php
    $barcode = new Milon\Barcode\DNS1D(); // untuk barcode 1D (C39)
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
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
            width: 8.6cm;
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
            {{-- <img src="{{ public_path('logo.png') }}" alt="Logo"> --}}
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
                    <td>Nama</td>
                    <td>: {{ $member->user->name }}</td>
                </tr>
                <tr>
                    <td>No Anggota</td>
                    <td>: {{ $member->membership_number }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $member->alamat }}</td>
                </tr>
                <tr>
                    <td>Telp</td>
                    <td>: {{ $member->no_telp }}</td>
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
