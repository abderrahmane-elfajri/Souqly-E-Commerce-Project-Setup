<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InventoryMovementType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display product catalog list for admins.
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category.translations', 'translations'])->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->filled('stock_status')) {
            if ($request->query('stock_status') === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            } elseif ($request->query('stock_status') === 'low_stock') {
                $query->whereBetween('stock', [1, 5]);
            } elseif ($request->query('stock_status') === 'in_stock') {
                $query->where('stock', '>', 5);
            }
        }

        if ($request->filled('q')) {
            $term = '%' . $request->query('q') . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('sku', 'like', $term)
                    ->orWhere('slug', 'like', $term)
                    ->orWhereHas('translations', function ($t) use ($term) {
                        $t->where('name', 'like', $term);
                    });
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::with('translations')->get();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->query('category_id'),
            'selectedStock' => $request->query('stock_status'),
            'searchQuery' => $request->query('q'),
        ]);
    }

    /**
     * Show creation form.
     */
    public function create(): View
    {
        $categories = Category::with('translations')->get();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store new product and trilingual descriptions.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'name_fr' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'short_description_fr' => 'nullable|string|max:500',
            'description_fr' => 'nullable|string',
            'short_description_ar' => 'nullable|string|max:500',
            'description_ar' => 'nullable|string',
            'short_description_en' => 'nullable|string|max:500',
            'description_en' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::create([
                'category_id' => $validated['category_id'],
                'sku' => strtoupper($validated['sku']),
                'slug' => Str::slug($validated['name_fr']) . '-' . strtolower(Str::random(4)),
                'price' => $validated['price'],
                'compare_at_price' => $validated['compare_at_price'] ?? null,
                'stock' => $validated['stock'],
                'is_featured' => (bool) ($validated['is_featured'] ?? false),
                'status' => 'published',
            ]);

            // Create 3 localized translations
            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'fr',
                'name' => $validated['name_fr'],
                'short_description' => $validated['short_description_fr'] ?? null,
                'description' => $validated['description_fr'] ?? null,
            ]);

            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'ar',
                'name' => $validated['name_ar'],
                'short_description' => $validated['short_description_ar'] ?? null,
                'description' => $validated['description_ar'] ?? null,
            ]);

            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'en',
                'name' => $validated['name_en'],
                'short_description' => $validated['short_description_en'] ?? null,
                'description' => $validated['description_en'] ?? null,
            ]);

            // Initial stock audit movement
            if ($product->stock > 0) {
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'type' => InventoryMovementType::RESTOCK,
                    'quantity' => $product->stock,
                    'stock_before' => 0,
                    'stock_after' => $product->stock,
                    'reference' => 'INITIAL_CREATION',
                    'notes' => 'Stock initial à la création du produit',
                    'created_by' => $request->user()?->id,
                ]);
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès avec ses traductions multilingues.');
    }

    /**
     * Show edit form.
     */
    public function edit(Product $product): View
    {
        $product->load(['category', 'translations']);
        $categories = Category::with('translations')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update product and translations.
     */
    public function update(Product $product, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => "required|string|max:50|unique:products,sku,{$product->id}",
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'is_featured' => 'nullable|boolean',
            'name_fr' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'short_description_fr' => 'nullable|string|max:500',
            'description_fr' => 'nullable|string',
            'short_description_ar' => 'nullable|string|max:500',
            'description_ar' => 'nullable|string',
            'short_description_en' => 'nullable|string|max:500',
            'description_en' => 'nullable|string',
        ]);

        DB::transaction(function () use ($product, $validated) {
            $product->update([
                'category_id' => $validated['category_id'],
                'sku' => strtoupper($validated['sku']),
                'price' => $validated['price'],
                'compare_at_price' => $validated['compare_at_price'] ?? null,
                'is_featured' => (bool) ($validated['is_featured'] ?? false),
            ]);

            foreach (['fr', 'ar', 'en'] as $loc) {
                ProductTranslation::updateOrCreate(
                    ['product_id' => $product->id, 'locale' => $loc],
                    [
                        'name' => $validated["name_{$loc}"],
                        'short_description' => $validated["short_description_{$loc}"] ?? null,
                        'description' => $validated["description_{$loc}"] ?? null,
                    ]
                );
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}
