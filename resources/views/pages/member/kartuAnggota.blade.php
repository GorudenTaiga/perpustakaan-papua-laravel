@php
    $barcode = new \Milon\Barcode\DNS1D();
    $barcodeHtml = $barcode->getBarcodeHTML($member->membership_number, 'C39', 1.2, 25);
    // Strip XML declaration yang bikin dompdf error UTF-8
$barcodeHtml = preg_replace('/<\?xml[^>]*\@endphp/', '', $barcodeHtml);
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>KTA {{ $member->membership_number }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 5px;
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        .kartu {
            height: 5.4cm;
            border: 1px solid #000;
            border-radius: 8px;
            overflow: hidden;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            background: #00923f;
            color: white;
            text-align: center;
            padding: 4px;
            font-size: 12px;
            line-height: 1.3;
            position: relative;
            height: 22%;
        }

        .header svg {
            position: absolute;
            top: 6px;
            left: 8px;
            width: 30px;
            height: 40px;
        }

        .sub-header {
            font-size: 9px;
        }

        .content {
            padding: 5px 10px;
            height: 78%;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            display: flex;
            gap: 5px;
            flex: 1;
        }

        .left-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 38%;
        }

        .photo svg {
            width: 70px;
            height: 90px;
            margin-bottom: 5px;
        }

        .barcode {
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .barcode svg {
            width: 100% !important;
            height: 20px !important;
        }

        .barcode div {
            margin-top: 2px;
            font-size: 9px;
            font-weight: bold;
        }

        .details {
            flex: 62%;
            padding-left: 4px;
        }

        .details table {
            width: 100%;
            font-size: 7px;
            table-layout: fixed;
        }

        .details td {
            vertical-align: top;
            white-space: nowrap;
            padding: 0;
        }

        .details td:last-child {
            white-space: normal;
        }
    </style>
</head>

<body>
    <div class="kartu">
        <!-- HEADER -->
        <div class="header">
            <svg viewBox="0 0 64 64" width="30" height="40">
                <rect width="64" height="64" fill="#00923f" rx="8" />
                <text x="32" y="38" text-anchor="middle" fill="white" font-size="16" font-weight="bold">LOGO</text>
            </svg>
            <div><b>KARTU ANGGOTA PERPUSTAKAAN</b></div>
            <div><b>PERPUSTAKAAN PROVINSI PAPUA</b></div>
            <div class="sub-header">
                JL. Raya Kota Raja No.84, Mandala, Kec. Jayapura Utara, Kota Jayapura, Papua
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <div class="card-body">
                <div class="left-section">
                    <div class="photo">
                        <!-- SVG foto placeholder -->
                        <svg viewBox="0 0 70 90" fill="#ddd" stroke="#999" stroke-width="1">
                            <rect width="70" height="90" rx="5" fill="#eee" />
                            <circle cx="35" cy="25" r="12" fill="#ccc" />
                            <path d="M25 45 Q35 55 45 45 Q35 50 25 45 Z" fill="#ddd" />
                            <text x="35" y="70" text-anchor="middle" font-size="7" fill="#999">FOTO</text>
                        </svg>
                    </div>
                    <div class="barcode">
                        {!! $barcodeHtml !!}
                        <div>{{ $member->membership_number }}</div>
                    </div>
                </div>

                <div class="details">
                    <table>
                        <tr>
                            <td style="width:45%">Nomor Anggota</td>
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
                            <td>: {{ $member->valid_date ?: '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
