<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatUsers;

use EddysStudio\GroupChat\Filament\Resources\GchatUsers\Pages\CreateGchatUser;
use EddysStudio\GroupChat\Filament\Resources\GchatUsers\Pages\EditGchatUser;
use EddysStudio\GroupChat\Filament\Resources\GchatUsers\Pages\ListGchatUsers;
use EddysStudio\GroupChat\Filament\Resources\GchatUsers\Schemas\GchatUserForm;
use EddysStudio\GroupChat\Filament\Resources\GchatUsers\Tables\GchatUsersTable;
use App\Models\GchatUser;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GchatUserResource extends Resource
{
    protected static ?string $model = \EddysStudio\GroupChat\Models\GchatUser::class;
    protected static string|UnitEnum|null $navigationGroup = 'Our chat';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Chat Users';

    public static function form(Schema $schema): Schema
    {
        return GchatUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GchatUsersTable::configure($table);
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
            'index' => ListGchatUsers::route('/'),
            'create' => CreateGchatUser::route('/create'),
            'edit' => EditGchatUser::route('/{record}/edit'),
        ];
    }
}
