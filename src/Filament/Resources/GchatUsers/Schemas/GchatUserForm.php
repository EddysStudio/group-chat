<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatUsers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GchatUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('fio'),
                DateTimePicker::make('last_time'),
                Textarea::make('connect')
                    ->columnSpanFull(),
                Textarea::make('connect_data')
                    ->columnSpanFull(),
            ]);
    }
}
