<?php

namespace App\Enums;

enum InventoryMovementType: string
{
    case SALE = 'sale';
    case RESTOCK = 'restock';
    case CANCELLATION_RETURN = 'cancellation_return';
    case ADJUSTMENT = 'adjustment';
    case LOSS = 'loss';

    public function label(string $locale = 'fr'): string
    {
        return match($this) {
            self::SALE => match($locale) {
                'ar' => 'بيع / طلب عميل',
                'en' => 'Sale / Order Deduction',
                default => 'Vente / Déduction de commande',
            },
            self::RESTOCK => match($locale) {
                'ar' => 'إعادة تموين المخزون',
                'en' => 'Restock / Purchase Receipt',
                default => 'Réapprovisionnement',
            },
            self::CANCELLATION_RETURN => match($locale) {
                'ar' => 'إرجاع بسبب إلغاء الطلب',
                'en' => 'Order Cancellation Return',
                default => 'Retour suite annulation',
            },
            self::ADJUSTMENT => match($locale) {
                'ar' => 'تسوية يدوية للمخزون',
                'en' => 'Manual Stock Adjustment',
                default => 'Ajustement manuel',
            },
            self::LOSS => match($locale) {
                'ar' => 'تلف أو خسارة',
                'en' => 'Loss / Damaged Goods',
                default => 'Perte / Marchandise endommagée',
            },
        };
    }

    public function badgeClasses(): string
    {
        return match($this) {
            self::SALE => 'bg-rose-100 text-rose-800',
            self::RESTOCK => 'bg-emerald-100 text-emerald-800',
            self::CANCELLATION_RETURN => 'bg-blue-100 text-blue-800',
            self::ADJUSTMENT => 'bg-amber-100 text-amber-800',
            self::LOSS => 'bg-gray-100 text-gray-800',
        };
    }
}
