<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cart = $this->cartService->getCart();

        return view('store.cart', compact('cart'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:50'],
            'variant_id' => ['nullable', 'exists:product_variants,id'],
        ]);

        $this->cartService->addItem(
            (int) $validated['product_id'],
            (int) ($validated['quantity'] ?? 1),
            isset($validated['variant_id']) ? (int) $validated['variant_id'] : null
        );

        return redirect()->route('cart.index')
            ->with('success', __('cart.item_added', ['default' => 'Article ajouté avec succès à votre panier !']));
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        $this->cartService->updateQuantity($id, (int) $validated['quantity']);

        return back()->with('success', __('cart.cart_updated', ['default' => 'Panier mis à jour.']));
    }

    /**
     * Remove item from cart.
     */
    public function remove(int $id): RedirectResponse
    {
        $this->cartService->removeItem($id);

        return back()->with('success', __('cart.item_removed', ['default' => 'Article retiré du panier.']));
    }

    /**
     * Clear all cart items.
     */
    public function clear(): RedirectResponse
    {
        $this->cartService->clear();

        return back()->with('info', __('cart.cart_cleared', ['default' => 'Votre panier a été vidé.']));
    }
}
