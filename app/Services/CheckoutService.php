<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Events\OrderPlaced;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(protected InventoryService $inventoryService)
    {
    }

    /**
     * Place a Cash on Delivery (COD) order transactionally.
     */
    public function placeCodOrder(Cart $cart, array $data, ?User $user = null): Order
    {
        if ($cart->items->isEmpty()) {
            throw new Exception(__('checkout.empty_cart_error', ['default' => 'Votre panier est vide.']));
        }

        return DB::transaction(function () use ($cart, $data, $user) {
            // 1. Compute verified totals on server (Never trust client prices)
            $subtotal = $cart->subtotal;
            $shippingCost = $cart->shipping_cost;
            $total = $subtotal + $shippingCost;

            // 2. Create Order
            $order = Order::create([
                'user_id' => $user?->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => OrderStatus::PENDING,
                'customer_name' => $data['name'],
                'customer_email' => $data['email'],
                'customer_phone' => $data['phone'],
                'shipping_city' => $data['city'],
                'shipping_address' => $data['address'],
                'shipping_notes' => $data['notes'] ?? null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => 0.00,
                'total' => $total,
                'currency' => 'MAD',
                'payment_method' => PaymentMethod::COD,
                'payment_status' => PaymentStatus::PENDING,
            ]);

            // 3. Deduct stock transactionally and create Immutable Order Item snapshots
            foreach ($cart->items as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->firstOrFail();
                $variant = $item->product_variant_id 
                    ? ProductVariant::where('id', $item->product_variant_id)->lockForUpdate()->firstOrFail() 
                    : null;

                // Deduct stock and log audit movement
                $this->inventoryService->recordDeduction(
                    $product,
                    $variant,
                    $item->quantity,
                    $order->order_number,
                    "Achat commande #{$order->order_number}"
                );

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->product->name,
                    'sku' => $variant?->sku ?? $product->sku,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'total' => $item->subtotal,
                    'variant_attributes' => $variant?->attributes,
                ]);
            }

            // 4. Clear Cart
            $cart->items()->delete();

            // 5. Fire Order Placed Event
            event(new OrderPlaced($order));

            return $order;
        });
    }
}
