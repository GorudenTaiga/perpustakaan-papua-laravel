<?php

namespace App\Filament\Resources\Admin\Payments\Schemas;

use App\Models\Pinjaman;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Peminjaman')
                    ->icon('heroicon-o-document-text')
                    ->description('Pilih data peminjaman terkait denda')
                    ->schema([
                        Select::make('pinjaman_id')
                            ->label('Pinjaman')
                            ->options(
                                Pinjaman::with(['member.user', 'buku'])
                                    ->get()
                                    ->mapWithKeys(fn ($p) => [
                                        $p->id => ($p->member?->user?->name ?? 'Unknown') . ' — ' . ($p->buku?->judul ?? 'Unknown')
                                    ])
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Cari berdasarkan nama peminjam atau judul buku'),
                    ]),

                Section::make('Detail Pembayaran')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('amount')
                                ->label('Jumlah Denda')
                                ->required()
                                ->numeric()
                                ->prefix('Rp')
                                ->minValue(0)
                                ->placeholder('0'),
                            DatePicker::make('payment_date')
                                ->label('Tanggal Bayar')
                                ->required()
                                ->default(now())
                                ->suffixIcon('heroicon-o-calendar'),
                            Select::make('payment_method')
                                ->label('Metode Pembayaran')
                                ->options([
                                    'cash' => '💵 Tunai',
                                    'transfer' => '🏦 Transfer Bank',
                                    'qris' => '📱 QRIS',
                                ])
                                ->required()
                                ->native(false),
                        ]),
                    ]),

                Section::make('Catatan Tambahan')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Tambahkan catatan tentang denda ini (opsional)...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
