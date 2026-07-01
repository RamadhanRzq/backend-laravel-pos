<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'saldo_awal', 'saldo_akhir', 'waktu_saldo_awal', 'waktu_saldo_akhir', 'status'])]
#[Casts([
    'saldo_awal' => 'decimal:2',
    'saldo_akhir' => 'decimal:2',
    'waktu_saldo_awal' => 'datetime',
    'waktu_saldo_akhir' => 'datetime',
])]
class SesiKasir extends Model
{
    protected $table = 'sesi_kasir';
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
