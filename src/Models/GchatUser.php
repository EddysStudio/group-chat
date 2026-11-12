<?php
namespace EddysStudio\GroupChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GchatUser extends Model
{
    protected $table = 'gchat_users';

    protected $fillable = ['name', 'fio', 'hash', 'last_time', 'connect', 'connect_data'];

    protected $casts = [
        'last_time' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(GchatMessage::class, 'user_id');
    }
}
