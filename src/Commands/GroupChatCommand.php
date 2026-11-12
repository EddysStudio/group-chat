<?php

namespace EddysStudio\GroupChat\Commands;

use Illuminate\Console\Command;

class GroupChatCommand extends Command
{
    public $signature = 'group-chat';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
