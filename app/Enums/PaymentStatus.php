<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case REFUNDED = 'refunded';

    public function label(string $locale = 'fr'): string
    {
        return match($this) {
            self::PENDING => match($locale) {
                'ar' => 'في انتظار الدفع عند الاستلام',
                'en' => 'Pending COD Payment',
                default => 'En attente paiement à la livraison',
            },
            self::PAID => match($locale) {
                'ar' => 'تم الدفع',
                'en' => 'Paid',
                default => 'Réglé',
            },
            self::REFUNDED => match($locale) {
                'ar' => 'تم استرداد المبلغ',
                'en' => 'Refunded',
                default => 'Remboursé',
            },
        };
    }
}
