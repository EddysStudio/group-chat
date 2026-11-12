<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatMessages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GchatMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
