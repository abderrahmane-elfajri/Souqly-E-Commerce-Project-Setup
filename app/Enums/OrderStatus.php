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
}
