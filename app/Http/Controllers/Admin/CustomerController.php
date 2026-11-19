<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display listing of customer accounts.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'customer')->withCount('orders')->latest();

        if ($request->filled('q')) {
            $term = '%' . $request->query('q') . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term);
            });
        }

        $customers = $query->paginate(15)->withQueryString();

        return view('admin.customers.index', [
            'customers' => $customers,
            'searchQuery' => $request->query('q'),
        ]);
    }

    /**
     * Show customer profile and purchase history.
     */
    public function show(User $customer): View
    {
        $customer->load(['addresses', 'orders.items']);

        return view('admin.customers.show', [
            'customer' => $customer,
        ]);
    }
}
