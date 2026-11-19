<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Administrator
        User::updateOrCreate(
            ['email' => 'admin@souqly.ma'],
            [
                'name' => 'Directeur Souqly',
                'phone' => '+212661000001',
                'password' => Hash::make('password123'),
                'role' => UserRole::SUPER_ADMIN,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 2. Staff Administrator
        User::updateOrCreate(
            ['email' => 'staff@souqly.ma'],
            [
                'name' => 'Responsable Commandes',
                'phone' => '+212661000002',
                'password' => Hash::make('password123'),
                'role' => UserRole::ADMIN,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 3. Demo Customer with Moroccan delivery address
        $customer = User::updateOrCreate(
            ['email' => 'client@souqly.ma'],
            [
                'name' => 'Yassine El Amrani',
                'phone' => '0661234567',
                'password' => Hash::make('password123'),
                'role' => UserRole::CUSTOMER,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        Address::firstOrCreate(
            [
                'user_id' => $customer->id,
                'phone' => '0661234567',
            ],
            [
                'full_name' => 'Yassine El Amrani',
                'city' => 'Casablanca',
                'address' => 'Angle Bd Zerktouni & Bd d\'Anfa, Résidence Al Manar, Apt 14',
                'postal_code' => '20050',
                'is_default' => true,
            ]
        );
    }
}
