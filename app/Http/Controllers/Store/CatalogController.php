<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display product catalog with filtering and search.
     */
    public function index(Request $request): View
    {
        $categories = Category::active()
            ->with(['translations'])
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        $selectedCategory = $request->filled('category')
            ? Category::where('slug', $request->query('category'))->with('translations')->first()
            : null;

        $products = Product::active()
            ->with(['translations', 'category.translations', 'images', 'variants'])
            ->filter($request->only(['category', 'min_price', 'max_price', 'q', 'sort']))
            ->paginate(12)
            ->withQueryString();

        return view('store.catalog', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Display single product detail page.
     */
    public function show(string $slug): View
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with(['translations', 'category.translations', 'images', 'variants'])
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['translations', 'category.translations', 'images'])
            ->take(4)
            ->get();

        return view('store.product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
