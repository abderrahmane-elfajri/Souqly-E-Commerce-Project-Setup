<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Retrieve or create current active cart.
     */
    public function getCart(): Cart
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        if ($userId) {
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            
            // If there was an anonymous session cart, merge its items
            $sessionCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();
            if ($sessionCart) {
                foreach ($sessionCart->items as $sessionItem) {
                    $existing = $cart->items()
                        ->where('product_id', $sessionItem->product_id)
                        ->where('product_variant_id', $sessionItem->product_variant_id)
                        ->first();

                    if ($existing) {
                        $existing->increment('quantity', $sessionItem->quantity);
                    } else {
                        $sessionItem->update(['cart_id' => $cart->id]);
                    }
                }
                $sessionCart->delete();
            }
        } else {
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart->load(['items.product.translations', 'items.variant']);
    }

    /**
     * Add a product/variant to the cart.
     */
    public function addItem(int $productId, int $quantity = 1, ?int $variantId = null): CartItem
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        // Check if item already exists in cart
        $cartItem = $cart->items()
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            return $cartItem->fresh();
        }

        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => max(1, $quantity),
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(int $cartItemId, int $quantity): ?CartItem
    {
        $cart = $this->getCart();
        $item = $cart->items()->findOrFail($cartItemId);

        if ($quantity <= 0) {
            $item->delete();
            return null;
        }

        $item->update(['quantity' => $quantity]);
        return $item->fresh();
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(int $cartItemId): bool
    {
        $cart = $this->getCart();
        return (bool) $cart->items()->where('id', $cartItemId)->delete();
    }

    /**
     * Clear all items in cart.
     */
    public function clear(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }
}
