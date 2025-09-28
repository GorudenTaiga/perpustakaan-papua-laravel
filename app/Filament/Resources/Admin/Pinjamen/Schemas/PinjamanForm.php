<?php

namespace App\Filament\Resources\Admin\Pinjamen\Schemas;

use App\Models\Member;
use App\Models\User;
use App\Models\Buku;
use DB;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Carbon\Carbon;

class PinjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('member_id')
                    ->label('Member')
                    ->options(
                        DB::table('users as u')
                            ->leftJoin('member as mem', 'u.id', '=', 'mem.users_id')
                            ->where('u.role', '=', 'member')
                            ->pluck('u.name', 'mem.membership_number')
                    )
                    ->searchable()
                    ->required(),

                Select::make('buku_id')
                    ->label('Buku')
                    ->options(Buku::all()->pluck('judul', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state, callable $get) {
                        self::calculateTotalPrice($set, $get);
                    }),

                TextInput::make('quantity')
                    ->label('Jumlah Buku')
                    ->default(1)
                    ->afterStateUpdated(function (callable $set, $state, callable $get) {
                        if ($state) {
                            $set('total_price', $get('total_price') * $state);
                        }
                        self::calculateTotalPrice($set, $get);
                    })
                    ->live(true)
                    ->required()
                    ->numeric(),

                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->default('dipinjam')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'jatuh_tempo' => 'Jatuh Tempo'
                    ]),

                Section::make('Tanggal')
                    ->schema([
                        DatePicker::make('loan_date')
                            ->label('Tanggal Pinjam')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state, callable $get) {
                                self::calculateTotalPrice($set, $get);
                            }),

                        DatePicker::make('due_date')
                            ->label('Batas Tanggal Kembali')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state, callable $get) {
                                self::calculateTotalPrice($set, $get);
                            }),

                        DatePicker::make('return_date')
                            ->label('Tanggal Dikembalikan')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state, callable $get) {
                                if ($state) {
                                    $set('status', 'dikembalikan');
                                }
                                self::calculateTotalPrice($set, $get);
                            }),
                    ]),

                Section::make('Biaya')
                    ->schema([
                        TextInput::make('total_price')
                            ->label('Total Price')
                            ->live()
                            ->readonly()
                            ->prefix('Rp')
                            ->required(),
        
                        TextInput::make('discount')
                            ->label('Diskon')
                            ->live()
                            ->readonly()
                            ->prefix('Rp')
                            ->default(0),
        
                        TextInput::make('punishment')
                            ->label('Denda')
                            ->live()
                            ->readonly()
                            ->prefix('Rp')
                            ->default(0),
        
                        TextInput::make('final_price')
                            ->live()
                            ->label('Harga Akhir')
                            ->readonly()
                            ->prefix('Rp')
                    ])
            ]);
    }

    private static function calculateTotalPrice(callable $set, callable $get)
    {
        $loanDate = $get('loan_date');
        $dueDate = $get('due_date');
        $returnDate = $get('return_date');
        $bukuId = $get('buku_id');
        $quantity = $get('quantity');
        
        if ($loanDate && $dueDate && $bukuId && $quantity) {
            $loanDateCarbon = Carbon::parse($loanDate);
            $dueDateCarbon = Carbon::parse($dueDate);
            $returnDateCarbon = $returnDate ? Carbon::parse($returnDate) : null;

            $days = $loanDateCarbon->diffInDays($dueDateCarbon);

            $buku = Buku::find($bukuId);
            if ($buku) {
                $totalPrice = ($days * $buku->denda_per_hari) * $quantity;

                // Calculate discount if returned early
                $discount = 0;
                $punishment = 0;
                if ($returnDateCarbon && $returnDateCarbon->lessThan($dueDateCarbon)) {
                    $finalPrice = 0;
                } else {
                    $lateDays = $dueDateCarbon->diffInDays($returnDateCarbon);
                    $punishment = $lateDays * $buku->denda_per_hari;
                    $finalPrice = $totalPrice + $punishment;
                }
                
                $set('total_price', $totalPrice);
                $set('discount', $discount);
                $set('final_price', $finalPrice);
                $set('punishment', $punishment);
            }
        }
    }
}