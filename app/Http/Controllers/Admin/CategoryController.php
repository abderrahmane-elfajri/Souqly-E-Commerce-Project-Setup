<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display categories list with trilingual translations.
     */
    public function index(): View
    {
        $categories = Category::with(['translations', 'products'])->orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store new category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => 'nullable|string|max:100|unique:categories,slug',
            'name_fr' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name_fr']);

        DB::transaction(function () use ($validated, $slug) {
            $category = Category::create([
                'slug' => $slug,
                'is_active' => true,
                'sort_order' => $validated['sort_order'] ?? 0,
            ]);

            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => 'fr',
                'name' => $validated['name_fr'],
            ]);

            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => 'ar',
                'name' => $validated['name_ar'],
            ]);

            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => 'en',
                'name' => $validated['name_en'],
            ]);
        });

        return back()->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Delete category if no products are assigned.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', "Impossible de supprimer cette catégorie car {$category->products()->count()} produit(s) y sont rattachés.");
        }

        $category->delete();

        return back()->with('success', 'Catégorie supprimée avec succès.');
    }
}
