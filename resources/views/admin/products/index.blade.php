@extends('layouts.admin')

@section('title', 'Gestion du Catalogue — Admin SOUQLY')
@section('header_title', 'Catalogue Produits')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Filter Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        
        <!-- Filters -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap items-center gap-3">
            <select name="category_id" onchange="this.form.submit()" class="text-xs px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="stock_status" onchange="this.form.submit()" class="text-xs px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                <option value="">Tous les états de stock</option>
                <option value="in_stock" {{ $selectedStock === 'in_stock' ? 'selected' : '' }}>En stock (&gt;5)</option>
                <option value="low_stock" {{ $selectedStock === 'low_stock' ? 'selected' : '' }}>Stock faible (1-5)</option>
                <option value="out_of_stock" {{ $selectedStock === 'out_of_stock' ? 'selected' : '' }}>Rupture de stock (0)</option>
            </select>

            <div class="relative">
                <input 
                    type="search" 
                    name="q" 
                    value="{{ $searchQuery ?? '' }}" 
                    placeholder="SKU, nom du produit..." 
                    class="text-xs px-3.5 py-2 pe-8 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange w-48 sm:w-56"
                >
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition">
                Filtrer
            </button>
        </form>

        <!-- New Product Button -->
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-souqly-orange hover:bg-souqly-orange-hover text-white text-xs font-bold rounded-xl shadow transition self-start md:self-auto">
            <span>+</span> <span>Ajouter un Produit</span>
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Produit</th>
                        <th class="py-3.5 px-4">SKU</th>
                        <th class="py-3.5 px-4">Catégorie</th>
                        <th class="py-3.5 px-4">Prix Public</th>
                        <th class="py-3.5 px-4">Stock</th>
                        <th class="py-3.5 px-4">Mis en avant</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $product->name }}</div>
                                <span class="text-[11px] text-slate-400 font-mono">/product/{{ $product->slug }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-700">
                                {{ $product->sku }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-600">
                                {{ $product->category?->name ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                {{ number_format($product->price, 2) }} MAD
                                @if($product->compare_at_price)
                                    <span class="block text-[10px] text-slate-400 line-through">
                                        {{ number_format($product->compare_at_price, 2) }} MAD
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($product->stock <= 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">
                                        Rupture (0)
                                    </span>
                                @elseif($product->stock <= 5)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                        Faible ({{ $product->stock }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        {{ $product->stock }} en stock
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($product->is_featured)
                                    <span class="text-amber-500 font-bold">★ Vedette</span>
                                @else
                                    <span class="text-slate-400">Normal</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Supprimer définitivement ce produit ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-bold transition">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">
                                Aucun produit ne correspond à ces critères.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
