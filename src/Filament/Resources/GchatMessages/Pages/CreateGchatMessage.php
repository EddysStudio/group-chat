<?php

namespace EddysStudio\GroupChat\Filament\Resources\GchatMessages\Pages;

use EddysStudio\GroupChat\Filament\Resources\GchatMessages\GchatMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGchatMessage extends CreateRecord
{
    protected static string $resource = GchatMessageResource::class;
}
