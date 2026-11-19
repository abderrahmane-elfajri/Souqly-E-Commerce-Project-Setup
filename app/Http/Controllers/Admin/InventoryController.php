<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Services\InventoryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    /**
     * Display inventory overview, stock levels, and audit trail.
     */
    public function index(Request $request): View
    {
        $productsQuery = Product::with(['category.translations', 'translations'])->latest();

        if ($request->filled('filter')) {
            if ($request->query('filter') === 'out_of_stock') {
                $productsQuery->where('stock', '<=', 0);
            } elseif ($request->query('filter') === 'low_stock') {
                $productsQuery->whereBetween('stock', [1, 5]);
            }
        }

        if ($request->filled('q')) {
            $term = '%' . $request->query('q') . '%';
            $productsQuery->where(function ($sub) use ($term) {
                $sub->where('sku', 'like', $term)
                    ->orWhereHas('translations', function ($t) use ($term) {
                        $t->where('name', 'like', $term);
                    });
            });
        }

        $products = $productsQuery->paginate(10, ['*'], 'products_page');
        $movements = InventoryMovement::with(['product.translations', 'creator'])->latest()->paginate(15, ['*'], 'movements_page');

        $metrics = [
            'total_units' => Product::sum('stock'),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'low_stock' => Product::whereBetween('stock', [1, 5])->count(),
            'total_movements' => InventoryMovement::count(),
        ];

        return view('admin.inventory.index', [
            'products' => $products,
            'movements' => $movements,
            'metrics' => $metrics,
            'currentFilter' => $request->query('filter'),
            'searchQuery' => $request->query('q'),
        ]);
    }

    /**
     * Perform manual stock adjustment.
     */
    public function adjust(Request $request, InventoryService $inventoryService): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'new_stock' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
        ]);

        try {
            $product = Product::findOrFail($validated['product_id']);
            $inventoryService->recordManualAdjustment(
                $product,
                null,
                $validated['new_stock'],
                $validated['reason'],
                $request->user()
            );

            return back()->with('success', "Le stock pour {$product->name} a été ajusté à {$validated['new_stock']} unités.");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Add restocked units to a product.
     */
    public function restock(Request $request, InventoryService $inventoryService): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'required|string|max:100',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $product = Product::findOrFail($validated['product_id']);
            $inventoryService->recordRestock(
                $product,
                null,
                $validated['quantity'],
                $validated['reference'],
                $request->user(),
                $validated['notes'] ?? null
            );

            return back()->with('success', "+{$validated['quantity']} unités ajoutées au stock de {$product->name}.");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
