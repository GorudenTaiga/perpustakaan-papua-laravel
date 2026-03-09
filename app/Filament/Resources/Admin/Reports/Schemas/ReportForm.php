<?php

namespace App\Filament\Resources\Admin\Reports\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Placeholder;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Laporan')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->description('Tentukan periode dan jenis laporan yang ingin dibuat')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Judul Laporan')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Laporan Bulanan Januari 2026')
                                ->suffixIcon('heroicon-o-document-text')
                                ->columnSpanFull(),

                            Select::make('period_type')
                                ->label('Jenis Periode')
                                ->required()
                                ->default('bulanan')
                                ->options([
                                    'bulanan' => '📅 Bulanan',
                                    'triwulan' => '📊 Triwulan',
                                    'semester' => '📈 Semester',
                                    'tahunan' => '📋 Tahunan',
                                    'custom' => '🔧 Custom',
                                ])
                                ->native(false)
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $now = now();
                                    match ($state) {
                                        'bulanan' => (function () use ($set, $now) {
                                            $set('period_start', $now->copy()->startOfMonth()->format('Y-m-d'));
                                            $set('period_end', $now->copy()->endOfMonth()->format('Y-m-d'));
                                        })(),
                                        'triwulan' => (function () use ($set, $now) {
                                            $set('period_start', $now->copy()->startOfQuarter()->format('Y-m-d'));
                                            $set('period_end', $now->copy()->endOfQuarter()->format('Y-m-d'));
                                        })(),
                                        'semester' => (function () use ($set, $now) {
                                            $month = $now->month;
                                            $set('period_start', $month <= 6
                                                ? $now->copy()->startOfYear()->format('Y-m-d')
                                                : $now->copy()->setMonth(7)->startOfMonth()->format('Y-m-d'));
                                            $set('period_end', $month <= 6
                                                ? $now->copy()->setMonth(6)->endOfMonth()->format('Y-m-d')
                                                : $now->copy()->endOfYear()->format('Y-m-d'));
                                        })(),
                                        'tahunan' => (function () use ($set, $now) {
                                            $set('period_start', $now->copy()->startOfYear()->format('Y-m-d'));
                                            $set('period_end', $now->copy()->endOfYear()->format('Y-m-d'));
                                        })(),
                                        default => null,
                                    };
                                }),

                            DatePicker::make('period_start')
                                ->label('Tanggal Mulai')
                                ->required()
                                ->default(now()->startOfMonth())
                                ->suffixIcon('heroicon-o-calendar'),

                            DatePicker::make('period_end')
                                ->label('Tanggal Selesai')
                                ->required()
                                ->default(now()->endOfMonth())
                                ->suffixIcon('heroicon-o-calendar'),
                        ]),
                    ]),

                Section::make('Informasi')
                    ->icon('heroicon-o-information-circle')
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        Placeholder::make('info')
                            ->label('')
                            ->content(new HtmlString(
                                '<div class="text-sm space-y-2 text-gray-600 dark:text-gray-400">'
                                . '<p>📊 <strong>Laporan akan otomatis menghitung:</strong></p>'
                                . '<ul class="list-disc list-inside ml-2 space-y-1">'
                                . '<li>📚 <strong>Koleksi</strong> — Total buku, stok, buku baru, stok rendah/habis, kategori populer</li>'
                                . '<li>👥 <strong>Keanggotaan</strong> — Total anggota, registrasi baru, per jenis & tier, verifikasi</li>'
                                . '<li>📖 <strong>Sirkulasi</strong> — Peminjaman, pengembalian, keterlambatan, durasi rata-rata, top buku & peminjam</li>'
                                . '<li>💰 <strong>Keuangan</strong> — Denda terkumpul, per metode pembayaran, outstanding</li>'
                                . '<li>📅 <strong>Reservasi</strong> — Total reservasi per status</li>'
                                . '<li>⭐ <strong>Ulasan</strong> — Total ulasan, rata-rata rating, distribusi</li>'
                                . '</ul></div>'
                            )),
                    ]),
            ]);
    }
}
