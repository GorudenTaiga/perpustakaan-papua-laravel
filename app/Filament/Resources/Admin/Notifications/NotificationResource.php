<?php

namespace App\Filament\Resources\Admin\Notifications;

use App\Filament\Resources\Admin\Notifications\Pages\CreateNotification;
use App\Filament\Resources\Admin\Notifications\Pages\EditNotification;
use App\Filament\Resources\Admin\Notifications\Pages\ListNotifications;
use App\Filament\Resources\Admin\Notifications\Schemas\NotificationForm;
use App\Filament\Resources\Admin\Notifications\Tables\NotificationsTable;
use App\Models\Notification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBell;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Notifikasi';

    protected static ?string $pluralModelLabel = 'Notifikasi';

    protected static ?string $navigationLabel = 'Notifikasi';

    public static function getNavigationBadge(): ?string
    {
        $unread = static::getModel()::whereNull('read_at')->count();
        return $unread ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'message', 'type'];
    }

    public static function form(Schema $schema): Schema
    {
        return NotificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NotificationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotifications::route('/'),
            'create' => CreateNotification::route('/create'),
            'edit' => EditNotification::route('/{record}/edit'),
        ];
    }
}
