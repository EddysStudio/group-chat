<?php

namespace EddysStudio\GroupChat;

use Filament\Contracts\Plugin;  
use Filament\Panel;
use EddysStudio\GroupChat\Filament\Resources\GchatMessages\GchatMessageResource;
use EddysStudio\GroupChat\Filament\Resources\GchatUsers\GchatUserResource;

class GroupChat implements Plugin {
    public function getId(): string
    {
        return 'group-chat';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            GchatMessageResource::class,
            GchatUserResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
