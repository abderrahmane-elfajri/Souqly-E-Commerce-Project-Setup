<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    /**
     * Show tracking search page.
     */
    public function show(): View
    {
        return view('store.track', [
            'order' => null,
            'searched' => false,
        ]);
    }

    /**
     * Process tracking inquiry by order number and phone.
     */
    public function track(Request $request): View
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'phone' => 'required|string',
        ]);

        $orderNumber = strtoupper(trim($validated['order_number']));
        $inputPhone = preg_replace('/[^\d]/', '', $validated['phone']);
        // Take last 9 digits of phone to match Moroccan numbers robustly (+2126... or 06...)
        $phoneSuffix = substr($inputPhone, -9);

        $order = Order::with(['items', 'shipments', 'latestShipment'])
            ->where('order_number', $orderNumber)
            ->first();

        $matched = false;
        if ($order) {
            $dbPhone = preg_replace('/[^\d]/', '', $order->customer_phone);
            $dbPhoneSuffix = substr($dbPhone, -9);

            if ($phoneSuffix !== '' && $phoneSuffix === $dbPhoneSuffix) {
                $matched = true;
            }
        }

        return view('store.track', [
            'order' => $matched ? $order : null,
            'searched' => true,
            'orderNumber' => $orderNumber,
            'phone' => $validated['phone'],
            'notFound' => ! $matched,
        ]);
    }
}
