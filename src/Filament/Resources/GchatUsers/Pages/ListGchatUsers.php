<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatUsers\Pages;

use EddysStudio\GroupChat\Filament\Resources\GchatUsers\GchatUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGchatUsers extends ListRecords
{
    protected static string $resource = GchatUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
