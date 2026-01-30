<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinningCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'is_used',
        'used_by',
        'used_at',
        'product_id',
        'order_id',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if the winning code is valid and available
     */
    public function isAvailable(): bool
    {
        return !$this->is_used;
    }

    /**
     * Mark the winning code as used
     */
    public function markAsUsed($userId, $orderId = null, $productId = null): void
    {
        $this->update([
            'is_used' => true,
            'used_by' => $userId,
            'used_at' => now(),
            'order_id' => $orderId,
            'product_id' => $productId,
        ]);
    }
}

