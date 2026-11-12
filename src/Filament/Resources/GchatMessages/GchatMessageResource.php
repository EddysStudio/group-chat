<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatMessages;

use EddysStudio\GroupChat\Filament\Resources\GchatMessages\Pages\CreateGchatMessage;
use EddysStudio\GroupChat\Filament\Resources\GchatMessages\Pages\EditGchatMessage;
use EddysStudio\GroupChat\Filament\Resources\GchatMessages\Pages\ListGchatMessages;
use EddysStudio\GroupChat\Filament\Resources\GchatMessages\Schemas\GchatMessageForm;
use EddysStudio\GroupChat\Filament\Resources\GchatMessages\Tables\GchatMessagesTable;
use App\Models\GchatMessage;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GchatMessageResource extends Resource
{
    protected static ?string $model = \EddysStudio\GroupChat\Models\GchatMessage::class;
    protected static UnitEnum|string|null $navigationGroup = 'Our chat';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Chat Messages';

    public static function form(Schema $schema): Schema
    {
        return GchatMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GchatMessagesTable::configure($table);
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
            'index' => ListGchatMessages::route('/'),
            'create' => CreateGchatMessage::route('/create'),
            'edit' => EditGchatMessage::route('/{record}/edit'),
        ];
    }
}
