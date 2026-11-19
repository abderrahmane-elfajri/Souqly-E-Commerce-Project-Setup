<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ShipmentStatus;
use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shipment;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(protected InventoryService $inventoryService)
    {
    }

    /**
     * Transition order to a new status with validation and inventory side-effects.
     */
    public function updateStatus(Order $order, OrderStatus $newStatus, ?string $note = null, ?User $actor = null): Order
    {
        if (! $order->status->canTransitionTo($newStatus)) {
            throw new Exception("Transition de statut non autorisée de '{$order->status->value}' vers '{$newStatus->value}'.");
        }

        $previousStatus = $order->status;

        return DB::transaction(function () use ($order, $previousStatus, $newStatus, $note) {
            // If cancelling: return stock to inventory
            if ($newStatus === OrderStatus::CANCELLED) {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    $variant = $item->product_variant_id ? ProductVariant::find($item->product_variant_id) : null;

                    if ($product) {
                        $this->inventoryService->recordCancellationReturn(
                            $product,
                            $variant,
                            $item->quantity,
                            $order->order_number,
                            $note ?? 'Retour de stock suite à l\'annulation de la commande'
                        );
                    }
                }
            }

            // If delivered with COD: mark payment as collected/paid
            if ($newStatus === OrderStatus::DELIVERED && $order->payment_method === PaymentMethod::COD) {
                $order->payment_status = PaymentStatus::PAID;
            }

            $order->status = $newStatus;
            $order->save();

            event(new OrderStatusUpdated($order, $previousStatus, $newStatus, $note));

            return $order;
        });
    }

    /**
     * Customer self-cancellation for pending orders.
     */
    public function cancelByCustomer(Order $order, ?string $reason = null): Order
    {
        if (! $order->canBeCancelled()) {
            throw new Exception("Cette commande ne peut plus être annulée car elle est déjà en cours de traitement.");
        }

        return $this->updateStatus(
            $order,
            OrderStatus::CANCELLED,
            $reason ?? 'Annulée par le client depuis son espace compte'
        );
    }

    /**
     * Create shipment and assign courier tracking.
     */
    public function createShipment(Order $order, string $carrier, string $trackingNumber, ?string $notes = null): Shipment
    {
        return DB::transaction(function () use ($order, $carrier, $trackingNumber, $notes) {
            $shipment = Shipment::create([
                'order_id' => $order->id,
                'carrier' => $carrier,
                'tracking_number' => $trackingNumber,
                'status' => ShipmentStatus::PICKED_UP,
                'shipped_at' => now(),
                'notes' => $notes,
            ]);

            // If order was in confirmed or processing state, transition to shipped
            if (in_array($order->status, [OrderStatus::CONFIRMED, OrderStatus::PROCESSING])) {
                $order->status = OrderStatus::SHIPPED;
                $order->save();
            }

            return $shipment;
        });
    }
}
