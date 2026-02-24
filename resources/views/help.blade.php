<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - Perpustakaan Daerah</title>
    <meta name="description" content="Pusat bantuan Perpustakaan Daerah Provinsi Papua - Panduan pendaftaran, peminjaman buku, denda, dan FAQ.">
    <meta property="og:title" content="Help Center - Perpustakaan Daerah Provinsi Papua">
    <meta property="og:description" content="Panduan lengkap pendaftaran anggota, peminjaman buku, dan informasi layanan perpustakaan.">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .help-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .help-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .help-header h1 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .help-section {
            margin-bottom: 2.5rem;
        }
        .help-section h2 {
            color: #764ba2;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #667eea;
        }
        .help-section h3 {
            color: #333;
            font-size: 1.2rem;
            margin-top: 1.5rem;
            margin-bottom: 0.8rem;
        }
        .help-section ul {
            padding-left: 1.5rem;
        }
        .help-section li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        .contact-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 1.5rem;
            border-radius: 5px;
            margin-top: 2rem;
        }
        .btn-back {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.75rem 2rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s;
        }
        .btn-back:hover {
            background: #764ba2;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .alert-info {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 1rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="help-container">
        <div class="help-header">
            <h1>🆘 Help Center</h1>
            <p class="text-muted">Perpustakaan Daerah - Panduan & Bantuan</p>
        </div>

        <div class="alert alert-info">
            <strong>📢 Informasi:</strong> Untuk pertanyaan lebih lanjut, silakan hubungi kami melalui kontak di bawah.
        </div>

        <div class="help-section">
            <h2>📝 Cara Mendaftar Menjadi Anggota</h2>
            <ol>
                <li>Klik tombol "Register" atau "Daftar" di halaman utama</li>
                <li>Isi formulir pendaftaran dengan data yang valid</li>
                <li>Upload dokumen pendukung (Surat Aktif Kuliah/Sekolah, KTP, dll)</li>
                <li>Tunggu verifikasi dari admin (1-2 hari kerja)</li>
                <li>Setelah disetujui, Anda dapat login dan meminjam buku</li>
            </ol>

            <h3>Dokumen yang Diperlukan:</h3>
            <ul>
                <li><strong>Mahasiswa/Pelajar:</strong> Surat Aktif Kuliah/Sekolah + KTP</li>
                <li><strong>Dosen/Guru:</strong> Surat Keterangan Kerja + KTP</li>
                <li><strong>Umum:</strong> KTP atau Kartu Identitas lainnya</li>
            </ul>
        </div>

        <div class="help-section">
            <h2>📚 Cara Meminjam Buku</h2>
            <ol>
                <li>Login ke akun Anda</li>
                <li>Browse katalog buku atau gunakan pencarian</li>
                <li>Klik buku yang ingin dipinjam</li>
                <li>Klik tombol "Pinjam Buku" dan tentukan jumlahnya</li>
                <li>Tunggu verifikasi admin</li>
                <li>Setelah disetujui, ambil buku di perpustakaan</li>
            </ol>

            <p><strong>Catatan:</strong></p>
            <ul>
                <li>Maksimal meminjam <strong>3 buku</strong> dalam satu waktu</li>
                <li>Durasi peminjaman: <strong>14 hari</strong> (dapat berbeda per buku)</li>
                <li>Peminjaman <strong>GRATIS</strong>, tidak ada biaya</li>
            </ul>
        </div>

        <div class="help-section">
            <h2>💻 Buku Digital</h2>
            <p>Beberapa buku tersedia dalam format digital melalui Google Drive:</p>
            <ul>
                <li>Buku dengan icon 🔗 memiliki versi digital</li>
                <li>Akses langsung tanpa perlu verifikasi admin</li>
                <li>Hanya untuk keperluan pribadi dan pendidikan</li>
                <li><strong>DILARANG</strong> menyebarkan link/file ke pihak lain</li>
            </ul>
        </div>

        <div class="help-section">
            <h2>⚠️ Denda & Sanksi</h2>
            <h3>Keterlambatan Pengembalian:</h3>
            <ul>
                <li>Denda: <strong>Rp 1.000 per hari</strong> untuk setiap buku</li>
                <li>Perhitungan dimulai 1 hari setelah jatuh tempo</li>
            </ul>

            <h3>Buku Hilang:</h3>
            <ul>
                <li>Wajib mengganti dengan buku yang sama, ATAU</li>
                <li>Bayar denda <strong>2x harga buku</strong></li>
                <li>Keanggotaan dibekukan hingga penyelesaian</li>
            </ul>

            <h3>Buku Rusak:</h3>
            <ul>
                <li>Kerusakan ringan: Teguran tertulis</li>
                <li>Kerusakan sedang: Denda 50% harga buku</li>
                <li>Kerusakan berat: Wajib mengganti atau denda penuh</li>
            </ul>

            <p class="text-danger mt-3"><strong>⚠️ Pelanggaran Berulang:</strong></p>
            <ul>
                <li>Terlambat 3x: Teguran tertulis</li>
                <li>Terlambat 5x: Suspend 1 bulan</li>
                <li>Terlambat 7x: Pencabutan keanggotaan</li>
            </ul>
        </div>

        <div class="help-section">
            <h2>🎫 Kartu Anggota (KTA)</h2>
            <ul>
                <li>KTA dapat diunduh dari halaman Profile setelah pendaftaran disetujui</li>
                <li>Format: PDF dengan barcode</li>
                <li>Masa berlaku: <strong>2 tahun</strong></li>
                <li>Bawa KTA saat mengambil/mengembalikan buku</li>
            </ul>
        </div>

        <div class="help-section">
            <h2>❓ FAQ (Frequently Asked Questions)</h2>
            
            <h3>Q: Apakah ada biaya untuk menjadi anggota?</h3>
            <p>A: <strong>TIDAK.</strong> Pendaftaran dan peminjaman buku 100% GRATIS.</p>

            <h3>Q: Berapa lama proses verifikasi pendaftaran?</h3>
            <p>A: Biasanya 1-2 hari kerja setelah dokumen lengkap diupload.</p>

            <h3>Q: Apakah bisa memperpanjang masa peminjaman?</h3>
            <p>A: Hubungi admin perpustakaan untuk perpanjangan (jika tidak ada antrian peminjam lain).</p>

            <h3>Q: Bagaimana cara mengembalikan buku?</h3>
            <p>A: Datang langsung ke perpustakaan atau gunakan drop box untuk pengembalian di luar jam operasional.</p>

            <h3>Q: Lupa password, bagaimana?</h3>
            <p>A: Hubungi admin melalui email atau datang langsung ke perpustakaan dengan membawa KTP.</p>
        </div>

        <div class="contact-box">
            <h3 style="color: #667eea; margin-top: 0;">📞 Kontak Kami</h3>
            <ul style="list-style: none; padding-left: 0;">
                <li><strong>📧 Email:</strong> perpustakaan@example.com</li>
                <li><strong>📍 Alamat:</strong> Perpustakaan Daerah Provinsi Papua</li>
                <li><strong>🕐 Jam Operasional:</strong> Senin - Jumat, 08:00 - 16:00 WIT</li>
                <li><strong>📱 WhatsApp:</strong> (Akan ditambahkan)</li>
            </ul>
        </div>

        <div class="text-center">
            <a href="/" class="btn-back">← Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
