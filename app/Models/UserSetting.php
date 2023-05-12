<?php

namespace App\Models;

use Illuminate\Database\Eloquent\;
use Illuminate\Database\Eloquent\{
    Model,
    Factories\HasFactory,
    Relations\BelongsTo
};

class UserSetting extends Model
{
    use HasFactory;

    protected $table = 'users_settings';

    protected $guarded = [];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
