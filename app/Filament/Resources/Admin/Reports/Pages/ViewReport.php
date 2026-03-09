<?php

namespace App\Filament\Resources\Admin\Reports\Pages;

use App\Filament\Resources\Admin\Reports\ReportResource;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        $record = $this->record;
        $data = $record->data ?? [];

        $koleksi = $data['koleksi'] ?? [];
        $keanggotaan = $data['keanggotaan'] ?? [];
        $sirkulasi = $data['sirkulasi'] ?? [];
        $keuangan = $data['keuangan'] ?? [];
        $reservasi = $data['reservasi'] ?? [];
        $ulasan = $data['ulasan'] ?? [];

        return $schema->components([
            // ── Report Header ────────────────────────────────────────
            View::make('filament.admin.reports.report-header')
                ->viewData([
                    'title' => $record->title ?? 'Laporan',
                    'periodType' => match ($record->period_type ?? '') {
                        'bulanan' => 'Bulanan',
                        'triwulan' => 'Triwulan',
                        'semester' => 'Semester',
                        'tahunan' => 'Tahunan',
                        'custom' => 'Custom',
                        default => ucfirst($record->period_type ?? '-'),
                    },
                    'periodStart' => $record->period_start
                        ? Carbon::parse($record->period_start)->translatedFormat('d F Y')
                        : '-',
                    'periodEnd' => $record->period_end
                        ? Carbon::parse($record->period_end)->translatedFormat('d F Y')
                        : '-',
                    'generatedBy' => $record->generatedBy?->name ?? 'System',
                    'createdAt' => $record->created_at
                        ? Carbon::parse($record->created_at)->translatedFormat('d F Y, H:i')
                        : '-',
                ]),

            // ── Ringkasan Eksekutif ──────────────────────────────────
            View::make('filament.admin.reports.stat-cards')
                ->viewData([
                    'stats' => [
                        [
                            'label' => 'Registrasi Baru',
                            'value' => number_format($record->total_registrations ?? 0),
                            'color' => 'info',
                            'description' => 'Pendaftar periode ini',
                        ],
                        [
                            'label' => 'Total Anggota',
                            'value' => number_format($record->total_members ?? 0),
                            'color' => 'primary',
                        ],
                        [
                            'label' => 'Peminjaman',
                            'value' => number_format($record->total_loans ?? 0),
                            'color' => 'warning',
                            'description' => 'Transaksi pinjam',
                        ],
                        [
                            'label' => 'Pengembalian',
                            'value' => number_format($record->total_returns ?? 0),
                            'color' => 'success',
                            'description' => 'Buku dikembalikan',
                        ],
                    ],
                ]),

            // ── Statistik Koleksi ────────────────────────────────────
            Section::make('Statistik Koleksi')
                ->icon('heroicon-o-book-open')
                ->collapsible()
                ->schema([
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                ['label' => 'Total Judul', 'value' => number_format($koleksi['total_judul'] ?? 0), 'color' => 'primary'],
                                ['label' => 'Total Stok', 'value' => number_format($koleksi['total_stok'] ?? 0), 'color' => 'primary'],
                                ['label' => 'Buku Baru', 'value' => number_format($koleksi['buku_baru_periode'] ?? 0), 'color' => 'success', 'description' => 'Periode ini'],
                            ],
                        ]),
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                ['label' => 'Stok Habis', 'value' => number_format($koleksi['stok_habis'] ?? 0), 'color' => 'danger'],
                                ['label' => 'Stok Rendah', 'value' => number_format($koleksi['stok_rendah'] ?? 0), 'color' => 'warning', 'description' => '≤ 3 eksemplar'],
                            ],
                        ]),
                    View::make('filament.admin.reports.ranked-table')
                        ->viewData([
                            'title' => 'Top 5 Kategori Terpopuler',
                            'items' => $koleksi['top_kategori'] ?? [],
                            'nameKey' => 'nama',
                            'valueKey' => 'total',
                            'valueSuffix' => ' buku',
                        ]),
                ]),

            // ── Statistik Keanggotaan ────────────────────────────────
            Section::make('Statistik Keanggotaan')
                ->icon('heroicon-o-user-group')
                ->collapsible()
                ->schema([
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                ['label' => 'Total Anggota', 'value' => number_format($keanggotaan['total_anggota'] ?? 0), 'color' => 'primary'],
                                ['label' => 'Anggota Baru', 'value' => number_format($keanggotaan['anggota_baru_periode'] ?? 0), 'color' => 'info', 'description' => 'Periode ini'],
                                ['label' => 'Terverifikasi', 'value' => number_format($keanggotaan['terverifikasi'] ?? 0), 'color' => 'success'],
                                ['label' => 'Belum Verifikasi', 'value' => number_format($keanggotaan['belum_verifikasi'] ?? 0), 'color' => 'warning'],
                            ],
                        ]),
                    Grid::make(2)->schema([
                        View::make('filament.admin.reports.key-value-table')
                            ->viewData([
                                'title' => 'Distribusi per Jenis Keanggotaan',
                                'items' => $keanggotaan['per_jenis'] ?? [],
                                'valueSuffix' => ' anggota',
                            ]),
                        View::make('filament.admin.reports.key-value-table')
                            ->viewData([
                                'title' => 'Distribusi per Tier',
                                'items' => $keanggotaan['per_tier'] ?? [],
                                'valueSuffix' => ' anggota',
                            ]),
                    ]),
                ]),

            // ── Statistik Sirkulasi ──────────────────────────────────
            Section::make('Statistik Sirkulasi')
                ->icon('heroicon-o-arrow-path')
                ->collapsible()
                ->schema([
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                ['label' => 'Peminjaman Periode', 'value' => number_format($sirkulasi['total_peminjaman_periode'] ?? 0), 'color' => 'primary'],
                                ['label' => 'Peminjaman Aktif', 'value' => number_format($sirkulasi['peminjaman_aktif'] ?? 0), 'color' => 'warning'],
                                ['label' => 'Dikembalikan', 'value' => number_format($sirkulasi['dikembalikan_periode'] ?? 0), 'color' => 'success', 'description' => 'Periode ini'],
                            ],
                        ]),
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                ['label' => 'Jatuh Tempo', 'value' => number_format($sirkulasi['jatuh_tempo'] ?? 0), 'color' => 'danger'],
                                ['label' => 'Menunggu Verifikasi', 'value' => number_format($sirkulasi['menunggu_verifikasi'] ?? 0), 'color' => 'info'],
                                ['label' => 'Rata-rata Durasi', 'value' => number_format($sirkulasi['rata_rata_durasi_hari'] ?? 0, 1) . ' hari', 'color' => 'gray'],
                            ],
                        ]),
                    Grid::make(2)->schema([
                        View::make('filament.admin.reports.ranked-table')
                            ->viewData([
                                'title' => 'Top 10 Buku Paling Dipinjam',
                                'items' => $sirkulasi['top_buku_dipinjam'] ?? [],
                                'nameKey' => 'judul',
                                'valueKey' => 'total_pinjam',
                                'valueSuffix' => '×',
                            ]),
                        View::make('filament.admin.reports.ranked-table')
                            ->viewData([
                                'title' => 'Top 10 Peminjam Teraktif',
                                'items' => $sirkulasi['top_peminjam'] ?? [],
                                'nameKey' => 'name',
                                'valueKey' => 'total_pinjam',
                                'valueSuffix' => '×',
                            ]),
                    ]),
                ]),

            // ── Statistik Keuangan ───────────────────────────────────
            Section::make('Statistik Keuangan')
                ->icon('heroicon-o-banknotes')
                ->collapsible()
                ->schema([
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                [
                                    'label' => 'Denda Terkumpul',
                                    'value' => 'Rp ' . number_format($keuangan['total_denda_terkumpul'] ?? 0, 0, ',', '.'),
                                    'color' => 'success',
                                ],
                                [
                                    'label' => 'Total Transaksi',
                                    'value' => number_format($keuangan['total_transaksi'] ?? 0),
                                    'color' => 'primary',
                                ],
                                [
                                    'label' => 'Denda Outstanding',
                                    'value' => number_format($keuangan['denda_outstanding'] ?? 0),
                                    'color' => 'danger',
                                    'description' => 'Belum dibayar',
                                ],
                            ],
                        ]),
                    View::make('filament.admin.reports.payment-methods-table')
                        ->viewData([
                            'title' => 'Rincian per Metode Pembayaran',
                            'items' => $keuangan['per_metode_pembayaran'] ?? [],
                        ]),
                ]),

            // ── Statistik Reservasi ──────────────────────────────────
            Section::make('Statistik Reservasi')
                ->icon('heroicon-o-calendar')
                ->collapsible()
                ->schema([
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                [
                                    'label' => 'Total Reservasi',
                                    'value' => number_format($reservasi['total_reservasi_periode'] ?? 0),
                                    'color' => 'primary',
                                    'description' => 'Periode ini',
                                ],
                            ],
                        ]),
                    View::make('filament.admin.reports.status-badges')
                        ->viewData([
                            'title' => 'Distribusi Status Reservasi',
                            'items' => $reservasi['per_status'] ?? [],
                            'labels' => [
                                'waiting' => 'Menunggu',
                                'available' => 'Tersedia',
                                'fulfilled' => 'Terpenuhi',
                                'cancelled' => 'Dibatalkan',
                            ],
                        ]),
                ]),

            // ── Statistik Ulasan ─────────────────────────────────────
            Section::make('Statistik Ulasan')
                ->icon('heroicon-o-star')
                ->collapsible()
                ->schema([
                    View::make('filament.admin.reports.stat-cards')
                        ->viewData([
                            'stats' => [
                                [
                                    'label' => 'Total Ulasan',
                                    'value' => number_format($ulasan['total_ulasan_periode'] ?? 0),
                                    'color' => 'primary',
                                    'description' => 'Periode ini',
                                ],
                                [
                                    'label' => 'Rata-rata Rating',
                                    'value' => number_format($ulasan['rata_rata_rating'] ?? 0, 1) . ' / 5.0',
                                    'color' => 'warning',
                                ],
                            ],
                        ]),
                    View::make('filament.admin.reports.rating-distribution')
                        ->viewData([
                            'title' => 'Distribusi Rating Ulasan',
                            'distribution' => $ulasan['distribusi_rating'] ?? [],
                        ]),
                ]),
        ]);
    }
}
