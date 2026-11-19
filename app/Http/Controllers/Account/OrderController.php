<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display listing of customer's orders.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->orders()->with(['items', 'latestShipment'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('account.orders.index', [
            'orders' => $orders,
            'currentStatus' => $request->query('status'),
        ]);
    }

    /**
     * Display single order detail and tracking timeline.
     */
    public function show(string $orderNumber, Request $request): View
    {
        $order = Order::with(['items', 'shipments', 'latestShipment'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Ensure user can only view their own order
        if ($order->user_id !== $request->user()->id) {
            abort(403, __('orders.unauthorized_access', ['default' => 'Accès non autorisé à cette commande.']));
        }

        return view('account.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Cancel an order if still pending.
     */
    public function cancel(string $orderNumber, Request $request, OrderService $orderService): RedirectResponse
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        try {
            $reason = $request->input('reason', 'Annulation demandée par le client');
            $orderService->cancelByCustomer($order, $reason);

            return back()->with('success', __('orders.cancel_success', ['default' => 'Votre commande a été annulée avec succès et le stock a été rétabli.']));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
