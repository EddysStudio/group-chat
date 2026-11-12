<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatMessages\Pages;

use EddysStudio\GroupChat\Filament\Resources\GchatMessages\GchatMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGchatMessages extends ListRecords
{
    protected static string $resource = GchatMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
