<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
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
     * Display all orders with filters.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['items', 'latestShipment'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('q')) {
            $term = '%' . $request->query('q') . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('order_number', 'like', $term)
                    ->orWhere('customer_name', 'like', $term)
                    ->orWhere('customer_phone', 'like', $term)
                    ->orWhere('shipping_city', 'like', $term);
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'currentStatus' => $request->query('status'),
            'searchQuery' => $request->query('q'),
        ]);
    }

    /**
     * Display single order administrative view.
     */
    public function show(Order $order): View
    {
        $order->load(['items', 'shipments', 'user']);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Update order status with lifecycle checks.
     */
    public function updateStatus(Order $order, Request $request, OrderService $orderService): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string|max:500',
        ]);

        try {
            $targetStatus = OrderStatus::from($validated['status']);
            $orderService->updateStatus($order, $targetStatus, $validated['note'] ?? null, $request->user());

            return back()->with('success', "Le statut de la commande {$order->order_number} a été mis à jour avec succès.");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Assign courier shipment and tracking number.
     */
    public function ship(Order $order, Request $request, OrderService $orderService): RedirectResponse
    {
        $validated = $request->validate([
            'carrier' => 'required|string|max:60',
            'tracking_number' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $orderService->createShipment(
                $order,
                $validated['carrier'],
                $validated['tracking_number'],
                $validated['notes'] ?? null
            );

            return back()->with('success', "L'expédition a été enregistrée et la commande {$order->order_number} marquée comme expédiée.");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
