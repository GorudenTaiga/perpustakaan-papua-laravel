<?php

namespace App\Filament\Resources\Admin\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pinjaman_id')
                    ->label('ID Pinjaman')
                    ->required()
                    ->numeric(),
                TextInput::make('amount')
                    ->label('Jumlah Denda (Rp)')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                DatePicker::make('payment_date')
                    ->label('Tanggal Pembayaran')
                    ->required(),
                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->required(),
            ]);
    }
}
