<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->items->sum(fn ($item) => $item->subtotal);
    }

    public function getShippingCostAttribute(): float
    {
        if ($this->subtotal <= 0) {
            return 0.00;
        }

        // Free shipping across Morocco for orders >= 500 MAD
        return $this->subtotal >= 500 ? 0.00 : 30.00;
    }

    public function getTotalAttribute(): float
    {
        return $this->subtotal + $this->shipping_cost;
    }

    public function getItemsCountAttribute(): int
    {
        return (int) $this->items->sum('quantity');
    }
}
