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
            box-sizing: border-box;
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
            gap: 15px;
            align-items: flex-start;
        }

        .left-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo img {
            width: 80px;
            height: 100px;
            border: 1px solid #ccc;
            object-fit: cover;
            margin-bottom: 5px;
        }

        .barcode {
            text-align: center;
        }

        .barcode div {
            margin-top: 2px;
            font-size: 9px;
        }

        .details {
            flex-grow: 1;
        }

        .details table {
            width: 100%;
            font-size: 11px;
        }

        .details td {
            padding: 1px 3px;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <div class="kartu">
        {{-- HEADER --}}
        <div class="header">
            <img style="max-width: 64px; max-height: 64px;"
                src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(asset('icon.png'))) }}" alt="Logo">
            <div><b>KARTU ANGGOTA PERPUSTAKAAN</b></div>
            <div><b>PERPUSTAKAAN PROVINSI PAPUA</b></div>
            <div class="sub-header">
                JL. Raya Kota Raja No.84, Mandala, Kec. Jayapura Utara, Kota Jayapura, Papua
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content">
            <div class="card-body">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- Bagian kiri (foto + barcode) -->
                        <td width="38%" align="left" valign="top" style="padding-left: 5px; text-align: center;">
                            <div class="photo">
                                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(Storage::disk('public')->path($member->image))) }}"
                                    alt="Foto Member">
                            </div>
                            <div class="barcode">
                                {!! $barcode->getBarcodeHTML($member->membership_number, 'C39', 1, 20) !!}
                                <div>{{ $member->membership_number }}</div>
                            </div>
                        </td>

                        <!-- Bagian kanan (details) -->
                        <td width="62%" align="middle" style="padding-left: 4px;">
                            <div class="details">
                                <table style="width: 100%; font-size: 11px; table-layout: fixed;">
                                    <tr>
                                        <td style="width: auto; white-space: nowrap;">Nomor Anggota</td>
                                        <td style="width: auto;">: {{ $member->membership_number }}</td>
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;">Nama</td>
                                        <td>: {{ $member->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;">Jenis</td>
                                        <td>: {{ $member->jenis }}</td>
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;">Berlaku hingga</td>
                                        <td>: {{ $member->valid_date }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
