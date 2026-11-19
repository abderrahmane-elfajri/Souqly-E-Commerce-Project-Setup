<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case COD = 'cod';
    case CARD = 'card';

    public function label(string $locale = 'fr'): string
    {
        return match($this) {
            self::COD => match($locale) {
                'ar' => 'الدفع نقداً عند الاستلام (COD)',
                'en' => 'Cash on Delivery (COD)',
                default => 'Paiement en espèces à la livraison (COD)',
            },
            self::CARD => match($locale) {
                'ar' => 'بطاقة بنكية مغربية / دولية',
                'en' => 'Credit / Debit Card',
                default => 'Carte Bancaire CMI / Visa / Mastercard',
            },
        };
    }
}
