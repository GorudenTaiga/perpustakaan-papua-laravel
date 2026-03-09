<?php

namespace App\Filament\Resources\Admin\BookReviews\Pages;

use App\Filament\Resources\Admin\BookReviews\BookReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookReviews extends ListRecords
{
    protected static string $resource = BookReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
