<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show administrative overview with live metrics.
     */
    public function index(): View
    {
        $totalRevenue = Order::where(function ($q) {
            $q->where('payment_status', PaymentStatus::PAID)
              ->orWhere('status', OrderStatus::DELIVERED);
        })->sum('total');

        $metrics = [
            'total_revenue_mad' => $totalRevenue,
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', OrderStatus::PENDING)->count(),
            'shipped_orders' => Order::where('status', OrderStatus::SHIPPED)->count(),
            'delivered_orders' => Order::where('status', OrderStatus::DELIVERED)->count(),
            'total_products' => Product::count(),
            'low_stock_products' => Product::where('stock', '<=', 5)->count(),
            'total_customers' => User::where('role', 'customer')->count(),
        ];

        $recentOrders = Order::with(['items', 'latestShipment'])->latest()->take(6)->get();
        $recentMovements = InventoryMovement::with(['product', 'variant'])->latest()->take(6)->get();

        return view('admin.dashboard', compact('metrics', 'recentOrders', 'recentMovements'));
    }
}
