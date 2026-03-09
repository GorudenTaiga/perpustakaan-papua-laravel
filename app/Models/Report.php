<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';

    protected $fillable = [
        'title',
        'period_type',
        'period_start',
        'period_end',
        'generated_by',
        'total_registrations',
        'total_members',
        'total_loans',
        'total_returns',
        'data',
    ];

    protected $casts = [
        'total_registrations' => 'integer',
        'total_members' => 'integer',
        'total_loans' => 'integer',
        'total_returns' => 'integer',
        'period_start' => 'date',
        'period_end' => 'date',
        'data' => 'array',
    ];

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Generate comprehensive report data for a given period.
     */
    public static function generateReportData(?string $startDate = null, ?string $endDate = null): array
    {
        $start = $startDate ? \Carbon\Carbon::parse($startDate) : now()->startOfMonth();
        $end = $endDate ? \Carbon\Carbon::parse($endDate) : now()->endOfMonth();

        return [
            'koleksi' => self::getCollectionStats($start, $end),
            'keanggotaan' => self::getMembershipStats($start, $end),
            'sirkulasi' => self::getCirculationStats($start, $end),
            'keuangan' => self::getFinancialStats($start, $end),
            'reservasi' => self::getReservationStats($start, $end),
            'ulasan' => self::getReviewStats($start, $end),
        ];
    }

    private static function getCollectionStats($start, $end): array
    {
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stock');
        $bukuBaru = Buku::whereBetween('created_at', [$start, $end])->count();
        $stokHabis = Buku::where('stock', 0)->count();
        $stokRendah = Buku::where('stock', '>', 0)->where('stock', '<=', 3)->count();

        $topKategori = \DB::table('categories')
            ->select('categories.nama', \DB::raw('COUNT(buku.id) as total'))
            ->leftJoin('buku', function ($join) {
                // PostgreSQL: check if category id exists in the JSON array
                $join->whereRaw("buku.category_id::jsonb @> to_jsonb(categories.id)");
            })
            ->groupBy('categories.id', 'categories.nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->toArray();

        return [
            'total_judul' => $totalBuku,
            'total_stok' => $totalStok,
            'buku_baru_periode' => $bukuBaru,
            'stok_habis' => $stokHabis,
            'stok_rendah' => $stokRendah,
            'top_kategori' => $topKategori,
        ];
    }

    private static function getMembershipStats($start, $end): array
    {
        $totalMember = Member::count();
        $memberBaru = Member::whereBetween('created_at', [$start, $end])->count();
        $memberVerified = Member::where('verif', true)->count();
        $memberUnverified = Member::where('verif', false)->count();

        $perJenis = Member::selectRaw('jenis, COUNT(*) as total')
            ->groupBy('jenis')
            ->pluck('total', 'jenis')
            ->toArray();

        $perTier = Member::selectRaw('tier, COUNT(*) as total')
            ->groupBy('tier')
            ->pluck('total', 'tier')
            ->toArray();

        return [
            'total_anggota' => $totalMember,
            'anggota_baru_periode' => $memberBaru,
            'terverifikasi' => $memberVerified,
            'belum_verifikasi' => $memberUnverified,
            'per_jenis' => $perJenis,
            'per_tier' => $perTier,
        ];
    }

    private static function getCirculationStats($start, $end): array
    {
        $totalPinjam = Pinjaman::whereBetween('created_at', [$start, $end])->count();
        $pinjamanAktif = Pinjaman::whereIn('status', ['dipinjam', 'jatuh_tempo'])->count();
        $dikembalikan = Pinjaman::where('status', 'dikembalikan')
            ->whereBetween('return_date', [$start, $end])->count();
        $jatuhTempo = Pinjaman::where('status', 'jatuh_tempo')->count();
        $menungguVerif = Pinjaman::where('status', 'menunggu_verif')->count();

        $avgDurasi = Pinjaman::where('status', 'dikembalikan')
            ->whereNotNull('return_date')
            ->whereBetween('return_date', [$start, $end])
            ->selectRaw("AVG(DATE_PART('day', return_date::timestamp - loan_date::timestamp)) as avg_days")
            ->value('avg_days');

        $topBuku = \DB::table('pinjaman')
            ->join('buku', 'pinjaman.buku_id', '=', 'buku.id')
            ->whereBetween('pinjaman.created_at', [$start, $end])
            ->select('buku.judul', \DB::raw('COUNT(pinjaman.id) as total_pinjam'), \DB::raw('SUM(pinjaman.quantity) as total_qty'))
            ->groupBy('buku.id', 'buku.judul')
            ->orderByDesc('total_pinjam')
            ->limit(10)
            ->get()
            ->toArray();

        $topPeminjam = \DB::table('pinjaman')
            ->join('member', \DB::raw('pinjaman.member_id::text'), '=', 'member.membership_number')
            ->join('users', 'member.users_id', '=', 'users.id')
            ->whereBetween('pinjaman.created_at', [$start, $end])
            ->select('users.name', \DB::raw('COUNT(pinjaman.id) as total_pinjam'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_pinjam')
            ->limit(10)
            ->get()
            ->toArray();

        return [
            'total_peminjaman_periode' => $totalPinjam,
            'peminjaman_aktif' => $pinjamanAktif,
            'dikembalikan_periode' => $dikembalikan,
            'jatuh_tempo' => $jatuhTempo,
            'menunggu_verifikasi' => $menungguVerif,
            'rata_rata_durasi_hari' => round($avgDurasi ?? 0, 1),
            'top_buku_dipinjam' => $topBuku,
            'top_peminjam' => $topPeminjam,
        ];
    }

    private static function getFinancialStats($start, $end): array
    {
        $totalDenda = Payments::whereBetween('payment_date', [$start, $end])->sum('amount');
        $totalTransaksi = Payments::whereBetween('payment_date', [$start, $end])->count();

        $perMetode = Payments::whereBetween('payment_date', [$start, $end])
            ->selectRaw('payment_method, COUNT(*) as total_transaksi, SUM(amount) as total_amount')
            ->groupBy('payment_method')
            ->get()
            ->toArray();

        $dendaOutstanding = Pinjaman::where('status', 'jatuh_tempo')
            ->whereDoesntHave('payments')
            ->count();

        return [
            'total_denda_terkumpul' => $totalDenda,
            'total_transaksi' => $totalTransaksi,
            'per_metode_pembayaran' => $perMetode,
            'denda_outstanding' => $dendaOutstanding,
        ];
    }

    private static function getReservationStats($start, $end): array
    {
        $totalReservasi = BookReservation::whereBetween('created_at', [$start, $end])->count();

        $perStatus = BookReservation::whereBetween('created_at', [$start, $end])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'total_reservasi_periode' => $totalReservasi,
            'per_status' => $perStatus,
        ];
    }

    private static function getReviewStats($start, $end): array
    {
        $totalUlasan = BookReview::whereBetween('created_at', [$start, $end])->count();
        $rataRating = BookReview::whereBetween('created_at', [$start, $end])->avg('rating');

        $distribusiRating = BookReview::whereBetween('created_at', [$start, $end])
            ->selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->toArray();

        return [
            'total_ulasan_periode' => $totalUlasan,
            'rata_rata_rating' => round($rataRating ?? 0, 1),
            'distribusi_rating' => $distribusiRating,
        ];
    }
}