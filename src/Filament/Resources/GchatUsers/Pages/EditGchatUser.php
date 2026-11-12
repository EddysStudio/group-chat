<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatUsers\Pages;

use EddysStudio\GroupChat\Filament\Resources\GchatUsers\GchatUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGchatUser extends EditRecord
{
    protected static string $resource = GchatUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
