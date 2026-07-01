<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'opening_cash', 'closing_cash', 'opened_at', 'closed_at', 'status'])]
#[Casts([
    'opening_cash' => 'decimal:2',
    'closing_cash' => 'decimal:2',
    'opened_at' => 'datetime',
    'closed_at' => 'datetime',
])]
class CashierSession extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
