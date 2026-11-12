<?php

namespace EddysStudio\GroupChat\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EddysStudio\GroupChat\GroupChat
 */
class GroupChat extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \EddysStudio\GroupChat\GroupChat::class;
    }
}
