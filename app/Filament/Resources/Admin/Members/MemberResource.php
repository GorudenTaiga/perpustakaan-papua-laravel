<?php

namespace App\Filament\Resources\Admin\Members;

use App\Filament\Resources\Admin\Members\Pages\CreateMember;
use App\Filament\Resources\Admin\Members\Pages\EditMember;
use App\Filament\Resources\Admin\Members\Pages\ListMembers;
use App\Filament\Resources\Admin\Members\Schemas\MemberForm;
use App\Filament\Resources\Admin\Members\Tables\MembersTable;
use App\Models\Member;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'membership_number';

    protected static ?string $modelLabel = 'Anggota';
    protected static ?string $pluralModelLabel = 'Anggota';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['membership_number', 'user.name', 'jenis'];
    }

    public static function form(Schema $schema): Schema
    {
        return MemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMembers::route('/'),
            'create' => CreateMember::route('/create'),
            'edit' => EditMember::route('/{record}/edit'),
        ];
    }
}
