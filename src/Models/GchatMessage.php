<?php

namespace EddysStudio\GroupChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GchatMessage extends Model
{
    protected $fillable = ['user_id', 'message'];
    const UPDATED_AT = null;

    public function user(): BelongsTo
    {
        return $this->belongsTo(GchatUser::class, 'user_id');
    }
}