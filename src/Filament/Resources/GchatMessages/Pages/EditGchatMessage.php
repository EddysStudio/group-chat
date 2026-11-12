<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatMessages\Pages;

use EddysStudio\GroupChat\Filament\Resources\GchatMessages\GchatMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGchatMessage extends EditRecord
{
    protected static string $resource = GchatMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
