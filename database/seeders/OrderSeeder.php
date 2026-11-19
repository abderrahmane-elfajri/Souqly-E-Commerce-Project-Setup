<?php

namespace Database\Seeders;

use App\Enums\InventoryMovementType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ShipmentStatus;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'client@souqly.ma')->first();
        $products = Product::with('variants')->get();

        if ($products->isEmpty() || ! $customer) {
            return;
        }

        // Order 1: Delivered luxury watch in Casablanca
        $p1 = $products->firstWhere('slug', 'montre-chronographe-royale') ?? $products->first();
        $order1 = Order::updateOrCreate(
            ['order_number' => 'SQL-202611-CAS01'],
            [
                'user_id' => $customer->id,
                'status' => OrderStatus::DELIVERED,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone ?? '0661234567',
                'shipping_city' => 'Casablanca',
                'shipping_address' => 'Angle Bd Zerktouni & Bd d\'Anfa, Résidence Al Manar, Apt 14',
                'shipping_notes' => 'Appeler 15 min avant la livraison svp',
                'subtotal' => 2450.00,
                'shipping_cost' => 0.00,
                'discount' => 0.00,
                'total' => 2450.00,
                'currency' => 'MAD',
                'payment_method' => PaymentMethod::COD,
                'payment_status' => PaymentStatus::PAID,
                'created_at' => now()->subDays(5),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $order1->id, 'product_id' => $p1->id],
            [
                'product_name' => $p1->name,
                'sku' => $p1->sku,
                'unit_price' => 2450.00,
                'quantity' => 1,
                'total' => 2450.00,
            ]
        );

        Shipment::firstOrCreate(
            ['order_id' => $order1->id, 'tracking_number' => 'AMN-882910-MA'],
            [
                'carrier' => 'Amana Express',
                'status' => ShipmentStatus::DELIVERED,
                'shipped_at' => now()->subDays(4),
                'delivered_at' => now()->subDays(3),
                'notes' => 'Livré en main propre au client à Casablanca Anfa',
            ]
        );

        InventoryMovement::firstOrCreate(
            ['reference' => $order1->order_number, 'product_id' => $p1->id],
            [
                'type' => InventoryMovementType::SALE,
                'quantity' => -1,
                'stock_before' => 15,
                'stock_after' => 14,
                'notes' => 'Commande #SQL-202611-CAS01 livrée',
            ]
        );

        // Order 2: In-Transit (Shipped) Electronics to Rabat
        $p2 = $products->firstWhere('slug', 'ecouteurs-sans-fil-pro-anc') ?? $products->skip(1)->first() ?? $p1;
        $order2 = Order::updateOrCreate(
            ['order_number' => 'SQL-202611-RAB02'],
            [
                'user_id' => $customer->id,
                'status' => OrderStatus::SHIPPED,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone ?? '0661234567',
                'shipping_city' => 'Rabat',
                'shipping_address' => 'Avenue Allal Ben Abdellah, Immeuble 8, Hassan',
                'shipping_notes' => 'Livraison entre 10h et 17h au bureau',
                'subtotal' => 599.00,
                'shipping_cost' => 0.00,
                'discount' => 0.00,
                'total' => 599.00,
                'currency' => 'MAD',
                'payment_method' => PaymentMethod::COD,
                'payment_status' => PaymentStatus::PENDING,
                'created_at' => now()->subDay(),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $order2->id, 'product_id' => $p2->id],
            [
                'product_name' => $p2->name,
                'sku' => $p2->sku,
                'unit_price' => 599.00,
                'quantity' => 1,
                'total' => 599.00,
            ]
        );

        Shipment::firstOrCreate(
            ['order_id' => $order2->id, 'tracking_number' => 'CAT-449102-MA'],
            [
                'carrier' => 'Cathedis Express',
                'status' => ShipmentStatus::OUT_FOR_DELIVERY,
                'shipped_at' => now()->subHours(18),
                'notes' => 'En cours de distribution avec le livreur à Rabat Hassan',
            ]
        );

        InventoryMovement::firstOrCreate(
            ['reference' => $order2->order_number, 'product_id' => $p2->id],
            [
                'type' => InventoryMovementType::SALE,
                'quantity' => -1,
                'stock_before' => 30,
                'stock_after' => 29,
                'notes' => 'Commande #SQL-202611-RAB02 expédiée',
            ]
        );

        // Order 3: Pending New Order in Marrakech
        $p3 = $products->firstWhere('slug', 'caftan-moderne-soie-marocaine') ?? $p1;
        $order3 = Order::updateOrCreate(
            ['order_number' => 'SQL-202611-RAK03'],
            [
                'user_id' => $customer->id,
                'status' => OrderStatus::PENDING,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone ?? '0661234567',
                'shipping_city' => 'Marrakech',
                'shipping_address' => 'Boulevard Mohammed VI, Résidence Atlas, Guéliz',
                'shipping_notes' => null,
                'subtotal' => 1200.00,
                'shipping_cost' => 0.00,
                'discount' => 0.00,
                'total' => 1200.00,
                'currency' => 'MAD',
                'payment_method' => PaymentMethod::COD,
                'payment_status' => PaymentStatus::PENDING,
                'created_at' => now()->subHours(2),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $order3->id, 'product_id' => $p3->id],
            [
                'product_name' => $p3->name,
                'sku' => $p3->sku,
                'unit_price' => 1200.00,
                'quantity' => 1,
                'total' => 1200.00,
            ]
        );

        InventoryMovement::firstOrCreate(
            ['reference' => $order3->order_number, 'product_id' => $p3->id],
            [
                'type' => InventoryMovementType::SALE,
                'quantity' => -1,
                'stock_before' => 12,
                'stock_after' => 11,
                'notes' => 'Commande #SQL-202611-RAK03 en attente de confirmation',
            ]
        );
    }
}
