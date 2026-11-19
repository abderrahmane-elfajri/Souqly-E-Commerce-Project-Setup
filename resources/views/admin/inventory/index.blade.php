@extends('layouts.admin')

@section('title', 'Gestion des Stocks & Mouvements — Admin SOUQLY')
@section('header_title', 'Gestion de l\'Inventaire & Audit des Stocks')

@section('content')
<div class="space-y-8">

    <!-- Stock KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Unités Totales en Stock</span>
            <div class="text-2xl font-black text-slate-900 font-mono">{{ $metrics['total_units'] }}</div>
            <p class="text-xs text-slate-500 mt-1">Sur l'ensemble du catalogue</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Ruptures de Stock</span>
            <div class="text-2xl font-black text-rose-600 font-mono">{{ $metrics['out_of_stock'] }}</div>
            <p class="text-xs text-slate-500 mt-1">Produits à 0 unité</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Stocks Critiques (1-5)</span>
            <div class="text-2xl font-black text-amber-600 font-mono">{{ $metrics['low_stock'] }}</div>
            <p class="text-xs text-slate-500 mt-1">Réapprovisionnement recommandé</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Mouvements Consignés</span>
            <div class="text-2xl font-black text-souqly-navy font-mono">{{ $metrics['total_movements'] }}</div>
            <p class="text-xs text-slate-500 mt-1">Traçabilité complète (ventes, retours)</p>
        </div>
    </div>

    <!-- Quick Operations: Restock & Adjustment -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Restock Box -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Réapprovisionnement de Stock (Entrée)</span>
            </h3>

            <form method="POST" action="{{ route('admin.inventory.restock') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Produit *</label>
                    <select name="product_id" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                        <option value="">Sélectionner un produit...</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->sku }} — {{ $p->name }} (Actuel : {{ $p->stock }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Quantité à ajouter *</label>
                        <input type="number" name="quantity" min="1" required placeholder="Ex: 20" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">N° Bon / Référence *</label>
                        <input type="text" name="reference" required placeholder="Ex: BL-202611-01" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-mono uppercase">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Note fournisseur / observation</label>
                    <input type="text" name="notes" placeholder="Ex: Réception arrivage Casablanca..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                </div>

                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition">
                    + Ajouter au Stock
                </button>
            </form>
        </div>

        <!-- Manual Correction Box -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span>⚖️</span> Ajustement / Correction d'Inventaire
            </h3>

            <form method="POST" action="{{ route('admin.inventory.adjust') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Produit *</label>
                    <select name="product_id" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                        <option value="">Sélectionner un produit...</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->sku }} — {{ $p->name }} (Actuel : {{ $p->stock }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nouveau stock réel compté *</label>
                    <input type="number" name="new_stock" min="0" required placeholder="Ex: 15" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Motif de l'ajustement *</label>
                    <input type="text" name="reason" required placeholder="Ex: Inventaire physique mensuel, casse, etc." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                </div>

                <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl shadow transition">
                    Corriger le Stock
                </button>
            </form>
        </div>

    </div>

    <!-- Table 1: Current Product Stock Levels -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Niveaux de Stock par Produit</span>
            </h3>

            <div class="flex items-center gap-2 text-xs">
                <a href="{{ route('admin.inventory.index') }}" class="px-3 py-1.5 rounded-lg {{ empty($currentFilter) ? 'bg-souqly-navy text-white font-bold' : 'bg-slate-100 text-slate-600' }}">
                    Tous
                </a>
                <a href="{{ route('admin.inventory.index', ['filter' => 'low_stock']) }}" class="px-3 py-1.5 rounded-lg {{ $currentFilter === 'low_stock' ? 'bg-amber-600 text-white font-bold' : 'bg-slate-100 text-slate-600' }}">
                    Critiques (≤5)
                </a>
                <a href="{{ route('admin.inventory.index', ['filter' => 'out_of_stock']) }}" class="px-3 py-1.5 rounded-lg {{ $currentFilter === 'out_of_stock' ? 'bg-rose-600 text-white font-bold' : 'bg-slate-100 text-slate-600' }}">
                    Ruptures (0)
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Produit</th>
                        <th class="py-3 px-4">SKU</th>
                        <th class="py-3 px-4">Catégorie</th>
                        <th class="py-3 px-4 text-center">Niveau de Stock</th>
                        <th class="py-3 px-4">État</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $p)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $p->name }}</td>
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $p->sku }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $p->category?->name ?? '—' }}</td>
                            <td class="py-3 px-4 text-center font-bold text-base font-mono">
                                {{ $p->stock }}
                            </td>
                            <td class="py-3 px-4">
                                @if($p->stock <= 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">
                                        Rupture
                                    </span>
                                @elseif($p->stock <= 5)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                        Critique
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Normal
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-500">Aucun produit trouvé.</td>
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

    <!-- Table 2: Full Audit Trail of Inventory Movements -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Journal Complet d'Audit des Mouvements (Traceabilité)</span>
            </h3>
            <p class="text-xs text-slate-500 mt-1">Historique immuable de chaque variation de stock (achats, annulations, réapprovisionnements).</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Date & Heure</th>
                        <th class="py-3 px-4">Produit</th>
                        <th class="py-3 px-4">Type de mouvement</th>
                        <th class="py-3 px-4">Variation</th>
                        <th class="py-3 px-4">Stock Avant &rarr; Après</th>
                        <th class="py-3 px-4">Référence</th>
                        <th class="py-3 px-4">Opérateur / Motif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($movements as $m)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-slate-500 text-[11px] font-mono">
                                {{ $m->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-900">
                                {{ $m->product?->name ?? 'Produit #' . $m->product_id }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $m->type->badgeClasses() }}">
                                    {{ $m->type->label('fr') }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono font-bold {{ $m->quantity > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $m->quantity > 0 ? '+' : '' }}{{ $m->quantity }}
                            </td>
                            <td class="py-3 px-4 font-mono text-slate-600">
                                {{ $m->stock_before }} &rarr; <strong class="text-slate-900">{{ $m->stock_after }}</strong>
                            </td>
                            <td class="py-3 px-4 font-mono font-bold text-slate-800">
                                {{ $m->reference ?? '—' }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 text-[11px]">
                                {{ $m->notes ?? 'Système' }}
                                @if($m->creator)
                                    <span class="block text-[10px] text-slate-400">Par: {{ $m->creator->name }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-500">Aucun mouvement enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movements->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $movements->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
