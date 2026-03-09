<?php

namespace App\Filament\Resources\Admin\BookReviews\Schemas;

use App\Models\Buku;
use DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Ulasan')
                    ->icon('heroicon-o-star')
                    ->description('Ulasan dan rating dari anggota untuk buku')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('member_id')
                                ->label('Anggota')
                                ->options(
                                    DB::table('users as u')
                                        ->leftJoin('member as mem', 'u.id', '=', 'mem.users_id')
                                        ->where('u.role', '=', 'member')
                                        ->pluck('u.name', 'mem.membership_number')
                                )
                                ->searchable()
                                ->preload()
                                ->required()
                                ->suffixIcon('heroicon-o-user'),

                            Select::make('buku_id')
                                ->label('Buku')
                                ->options(Buku::all()->pluck('judul', 'id'))
                                ->searchable()
                                ->preload()
                                ->required()
                                ->suffixIcon('heroicon-o-book-open'),

                            TextInput::make('rating')
                                ->label('Rating')
                                ->numeric()
                                ->required()
                                ->minValue(1)
                                ->maxValue(5)
                                ->step(1)
                                ->default(5)
                                ->suffixIcon('heroicon-o-star')
                                ->helperText('Rating 1-5 bintang'),
                        ]),
                    ]),

                Section::make('Isi Ulasan')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->schema([
                        Textarea::make('review')
                            ->label('Ulasan')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Tulis ulasan tentang buku ini...'),
                    ]),
            ]);
    }
}
