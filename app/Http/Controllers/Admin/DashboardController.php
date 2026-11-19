<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show administrative overview.
     */
    public function index(): View
    {
        $metrics = [
            'total_customers' => User::where('role', 'customer')->count(),
            'total_admins' => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'total_products' => 0, // Ready for Phase 3
            'total_orders' => 0,   // Ready for Phase 5
            'total_revenue_mad' => 0.00,
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('metrics', 'recentUsers'));
    }
}
