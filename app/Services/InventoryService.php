<?php

namespace App\Services;

use App\Enums\InventoryMovementType;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Exception;

class InventoryService
{
    /**
     * Deduct stock for an order sale and record audit movement.
     */
    public function recordDeduction(Product $product, ?ProductVariant $variant, int $quantity, string $reference, ?string $notes = null): InventoryMovement
    {
        $target = $variant ?? $product;
        $stockBefore = (int) $target->stock;

        if ($stockBefore < $quantity) {
            $identifier = $variant ? "variante {$variant->sku}" : $product->name;
            throw new Exception("Stock insuffisant pour {$identifier} (actuel: {$stockBefore}, requis: {$quantity}).");
        }

        $stockAfter = $stockBefore - $quantity;
        $target->decrement('stock', $quantity);

        return InventoryMovement::create([
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'type' => InventoryMovementType::SALE,
            'quantity' => -$quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reference' => $reference,
            'notes' => $notes ?? 'Déduction automatique lors de la commande',
        ]);
    }

    /**
     * Return stock when an order is cancelled and record audit movement.
     */
    public function recordCancellationReturn(Product $product, ?ProductVariant $variant, int $quantity, string $reference, ?string $notes = null): InventoryMovement
    {
        $target = $variant ?? $product;
        $stockBefore = (int) $target->stock;
        $stockAfter = $stockBefore + $quantity;

        $target->increment('stock', $quantity);

        return InventoryMovement::create([
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'type' => InventoryMovementType::CANCELLATION_RETURN,
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reference' => $reference,
            'notes' => $notes ?? 'Réintégration au stock suite annulation de commande',
        ]);
    }

    /**
     * Add restocked units to inventory.
     */
    public function recordRestock(Product $product, ?ProductVariant $variant, int $quantity, string $reference, ?User $user = null, ?string $notes = null): InventoryMovement
    {
        $target = $variant ?? $product;
        $stockBefore = (int) $target->stock;
        $stockAfter = $stockBefore + $quantity;

        $target->increment('stock', $quantity);

        return InventoryMovement::create([
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'type' => InventoryMovementType::RESTOCK,
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reference' => $reference,
            'notes' => $notes,
            'created_by' => $user?->id,
        ]);
    }

    /**
     * Manual stock correction/adjustment.
     */
    public function recordManualAdjustment(Product $product, ?ProductVariant $variant, int $newStock, string $reason, ?User $user = null): InventoryMovement
    {
        $target = $variant ?? $product;
        $stockBefore = (int) $target->stock;
        $diff = $newStock - $stockBefore;

        $target->update(['stock' => $newStock]);

        return InventoryMovement::create([
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'type' => InventoryMovementType::ADJUSTMENT,
            'quantity' => $diff,
            'stock_before' => $stockBefore,
            'stock_after' => $newStock,
            'reference' => 'MANUAL_ADJUSTMENT',
            'notes' => $reason,
            'created_by' => $user?->id,
        ]);
    }
}
