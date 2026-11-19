<?php

namespace App\Enums;

enum UserRole: string
{
    case CUSTOMER = 'customer';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';

    public function isAdmin(): bool
    {
        return $this === self::ADMIN || $this === self::SUPER_ADMIN;
    }

    public function label(string $locale = 'fr'): string
    {
        return match($this) {
            self::CUSTOMER => match($locale) {
                'ar' => 'زبون',
                'en' => 'Customer',
                default => 'Client',
            },
            self::ADMIN => match($locale) {
                'ar' => 'مشرف',
                'en' => 'Administrator',
                default => 'Administrateur',
            },
            self::SUPER_ADMIN => match($locale) {
                'ar' => 'مشرف عام',
                'en' => 'Super Administrator',
                default => 'Super Administrateur',
            },
        };
    }
}
