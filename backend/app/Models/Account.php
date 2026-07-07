<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $fillable = [
        'unique_code',
        'game_id',
        'price',
        'description',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    public static function generateUniqueCode(): string
    {
        $last = static::max('unique_code');
        if (!$last) {
            return '#000001';
        }
        $num = (int) substr($last, 1);
        return '#' . str_pad($num + 1, 6, '0', STR_PAD_LEFT);
    }
}
