<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman - {{ $member->user->name ?? 'Member' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #4f46e5;
            font-size: 22px;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
            font-size: 12px;
        }
        .member-info {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .member-info span {
            margin-right: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #4f46e5;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background: #f9fafb;
        }
        .status {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-dipinjam { background: #dbeafe; color: #1e40af; }
        .status-dikembalikan { background: #d1fae5; color: #065f46; }
        .status-terlambat { background: #fee2e2; color: #991b1b; }
        .status-menunggu_verif { background: #fef3c7; color: #92400e; }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .summary {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .summary-box {
            display: inline-block;
            background: #f0f0ff;
            padding: 8px 15px;
            border-radius: 5px;
            margin-right: 10px;
        }
        .summary-box strong {
            color: #4f46e5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Riwayat Peminjaman Buku</h1>
        <p>Perpustakaan Daerah - Dicetak {{ now()->format('d M Y H:i') }}</p>
    </div>

    <div class="member-info">
        <span><strong>Nama:</strong> {{ $member->user->name ?? '-' }}</span>
        <span><strong>No. Anggota:</strong> {{ $member->membership_number }}</span>
        <span><strong>Email:</strong> {{ $member->user->email ?? '-' }}</span>
    </div>

    <div>
        <div class="summary-box"><strong>Total Peminjaman:</strong> {{ $pinjaman->count() }}</div>
        <div class="summary-box"><strong>Aktif:</strong> {{ $pinjaman->whereIn('status', ['dipinjam', 'menunggu_verif'])->count() }}</div>
        <div class="summary-box"><strong>Dikembalikan:</strong> {{ $pinjaman->where('status', 'dikembalikan')->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Qty</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pinjaman as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ Str::limit($p->buku->judul ?? '-', 30) }}</td>
                <td>{{ $p->buku->author ?? '-' }}</td>
                <td>{{ $p->quantity }}</td>
                <td>{{ \Carbon\Carbon::parse($p->loan_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->due_date)->format('d/m/Y') }}</td>
                <td>{{ $p->return_date ? \Carbon\Carbon::parse($p->return_date)->format('d/m/Y') : '-' }}</td>
                <td>
                    <span class="status status-{{ $p->status }}">
                        {{ Str::of($p->status)->replace('_', ' ')->title() }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh sistem Perpustakaan Daerah. &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>
