<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_city',
        'shipping_address',
        'shipping_notes',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
        'currency',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function latestShipment(): HasOne
    {
        return $this->hasOne(Shipment::class)->latestOfMany();
    }

    public function canBeCancelled(): bool
    {
        return $this->status === OrderStatus::PENDING;
    }

    public function getItemsCountAttribute(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    /**
     * Build WhatsApp inquiry link tailored for Moroccan customer service
     */
    public function getWhatsappInquiryUrlAttribute(): string
    {
        $phone = '212600000000';
        $msg = "Bonjour Souqly, je vous contacte concernant ma commande {$this->order_number} ({$this->customer_name}, {$this->shipping_city}).";
        return "https://wa.me/{$phone}?text=" . rawurlencode($msg);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'SQL-' . date('Ym') . '-';
        do {
            $number = $prefix . strtoupper(Str::random(5));
        } while (static::where('order_number', $number)->exists());

        return $number;
    }
}
