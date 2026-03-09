<?php

namespace App\Filament\Resources\Admin\BookReviews\Pages;

use App\Filament\Resources\Admin\BookReviews\BookReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookReview extends EditRecord
{
    protected static string $resource = BookReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
