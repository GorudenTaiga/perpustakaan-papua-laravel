<?php

namespace App\Filament\Resources\Admin\BookReviews\Pages;

use App\Filament\Resources\Admin\BookReviews\BookReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookReview extends CreateRecord
{
    protected static string $resource = BookReviewResource::class;
}
