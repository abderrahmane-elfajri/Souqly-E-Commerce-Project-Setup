<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(string $locale = 'fr'): string
    {
        return match($this) {
            self::PENDING => match($locale) {
                'ar' => 'في انتظار التأكيد',
                'en' => 'Pending Confirmation',
                default => 'En attente de confirmation',
            },
            self::CONFIRMED => match($locale) {
                'ar' => 'تم التأكيد',
                'en' => 'Confirmed',
                default => 'Confirmée',
            },
            self::PROCESSING => match($locale) {
                'ar' => 'قيد التحضير والتجهيز',
                'en' => 'Processing',
                default => 'En cours de préparation',
            },
            self::SHIPPED => match($locale) {
                'ar' => 'تم الشحن مع مندوب التوصيل',
                'en' => 'Shipped / Out for Delivery',
                default => 'Expédiée avec livreur',
            },
            self::DELIVERED => match($locale) {
                'ar' => 'تم التسليم بنجاح',
                'en' => 'Delivered',
                default => 'Livrée avec succès',
            },
            self::CANCELLED => match($locale) {
                'ar' => 'ملغاة',
                'en' => 'Cancelled',
                default => 'Annulée',
            },
        };
    }

    public function badgeClasses(): string
    {
        return match($this) {
            self::PENDING => 'bg-amber-100 text-amber-800',
            self::CONFIRMED => 'bg-blue-100 text-blue-800',
            self::PROCESSING => 'bg-purple-100 text-purple-800',
            self::SHIPPED => 'bg-sky-100 text-sky-800',
            self::DELIVERED => 'bg-emerald-100 text-emerald-800',
            self::CANCELLED => 'bg-rose-100 text-rose-800',
        };
    }

    /**
     * Determine if order can transition to given target status.
     */
    public function canTransitionTo(OrderStatus $target): bool
    {
        if ($this === $target) {
            return false;
        }

        // Terminal states cannot transition anywhere
        if ($this === self::DELIVERED || $this === self::CANCELLED) {
            return false;
        }

        return match($this) {
            self::PENDING => in_array($target, [self::CONFIRMED, self::CANCELLED]),
            self::CONFIRMED => in_array($target, [self::PROCESSING, self::CANCELLED]),
            self::PROCESSING => in_array($target, [self::SHIPPED, self::CANCELLED]),
            self::SHIPPED => in_array($target, [self::DELIVERED, self::CANCELLED]),
            default => false,
        };
    }

    /**
     * Stepper step index (1-indexed) for order tracking progression.
     */
    public function stepIndex(): int
    {
        return match($this) {
            self::PENDING => 1,
            self::CONFIRMED => 2,
            self::PROCESSING => 3,
            self::SHIPPED => 4,
            self::DELIVERED => 5,
            self::CANCELLED => 0,
        };
    }

    /**
     * Percentage progress for tracking bar.
     */
    public function progressPercent(): int
    {
        return match($this) {
            self::PENDING => 20,
            self::CONFIRMED => 40,
            self::PROCESSING => 65,
            self::SHIPPED => 85,
            self::DELIVERED => 100,
            self::CANCELLED => 0,
        };
    }
}
