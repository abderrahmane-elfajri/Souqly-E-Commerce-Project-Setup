<?php

namespace App\Enums;

enum ShipmentStatus: string
{
    case PENDING = 'pending';
    case PICKED_UP = 'picked_up';
    case IN_TRANSIT = 'in_transit';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case DELIVERED = 'delivered';
    case FAILED = 'failed';
    case RETURNED = 'returned';

    public function label(string $locale = 'fr'): string
    {
        return match($this) {
            self::PENDING => match($locale) {
                'ar' => 'في انتظار الاستلام',
                'en' => 'Pending Pickup',
                default => 'En attente d\'enlèvement',
            },
            self::PICKED_UP => match($locale) {
                'ar' => 'تم استلام الطرد من شركة الشحن',
                'en' => 'Picked Up by Courier',
                default => 'Colis pris en charge',
            },
            self::IN_TRANSIT => match($locale) {
                'ar' => 'في الطريق بين المدن',
                'en' => 'In Transit',
                default => 'En transit inter-villes',
            },
            self::OUT_FOR_DELIVERY => match($locale) {
                'ar' => 'مع مندوب التوصيل للتسليم',
                'en' => 'Out for Delivery',
                default => 'En cours de distribution',
            },
            self::DELIVERED => match($locale) {
                'ar' => 'تم التسليم بنجاح',
                'en' => 'Delivered',
                default => 'Livré avec succès',
            },
            self::FAILED => match($locale) {
                'ar' => 'فشل التسليم / تعذر الوصول',
                'en' => 'Delivery Attempt Failed',
                default => 'Tentative de livraison échouée',
            },
            self::RETURNED => match($locale) {
                'ar' => 'تم إرجاع الطرد',
                'en' => 'Returned to Sender',
                default => 'Retourné à l\'expéditeur',
            },
        };
    }

    public function badgeClasses(): string
    {
        return match($this) {
            self::PENDING => 'bg-amber-100 text-amber-800',
            self::PICKED_UP => 'bg-indigo-100 text-indigo-800',
            self::IN_TRANSIT => 'bg-blue-100 text-blue-800',
            self::OUT_FOR_DELIVERY => 'bg-sky-100 text-sky-800',
            self::DELIVERED => 'bg-emerald-100 text-emerald-800',
            self::FAILED => 'bg-rose-100 text-rose-800',
            self::RETURNED => 'bg-gray-100 text-gray-800',
        };
    }
}
