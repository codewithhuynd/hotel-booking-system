<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordChangeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'token_hash',
        'new_password_hash',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsUsed(): void
    {
        if (is_null($this->used_at)) {
            $this->forceFill(['used_at' => now()])->save();
        }
    }
}
