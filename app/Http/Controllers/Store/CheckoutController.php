<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService
    ) {}

    /**
     * Show the checkout page.
     */
    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('info', __('checkout.empty_cart_redirect', ['default' => 'Votre panier est vide. Veuillez ajouter des articles avant de commander.']));
        }

        $user = Auth::user();
        $defaultAddress = $user?->defaultAddress;

        $moroccanCities = [
            'Casablanca', 'Rabat', 'Marrakech', 'Tanger', 'Fès', 'Agadir',
            'Meknès', 'Oujda', 'Kénitra', 'Tétouan', 'Safi', 'Mohammédia',
            'El Jadida', 'Nador', 'Béni Mellal', 'Témara', 'Salé'
        ];

        return view('store.checkout', compact('cart', 'user', 'defaultAddress', 'moroccanCities'));
    }

    /**
     * Process order submission.
     */
    public function process(CheckoutRequest $request): RedirectResponse
    {
        $cart = $this->cartService->getCart();

        try {
            $order = $this->checkoutService->placeCodOrder(
                $cart,
                $request->validated(),
                Auth::user()
            );

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', __('checkout.order_placed_success', ['default' => 'Votre commande a été enregistrée avec succès !']));
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Order success page.
     */
    public function success(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();

        return view('store.checkout-success', compact('order'));
    }
}
