<?php

namespace App\Filament\Resources\Admin\Payments\Schemas;

use App\Models\Pinjaman;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pinjaman_id')
                    ->label('Pinjaman')
                    ->options(
                        Pinjaman::with(['member.user', 'buku'])
                            ->get()
                            ->mapWithKeys(fn ($p) => [
                                $p->id => ($p->member?->user?->name ?? 'Unknown') . ' - ' . ($p->buku?->judul ?? 'Unknown')
                            ])
                    )
                    ->searchable()
                    ->required(),
                TextInput::make('amount')
                    ->label('Jumlah Denda (Rp)')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                DatePicker::make('payment_date')
                    ->label('Tanggal Pembayaran Denda')
                    ->required(),
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Tunai',
                        'transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                    ])
                    ->required(),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('Keterangan denda (opsional)')
                    ->columnSpanFull(),
            ]);
    }
}
