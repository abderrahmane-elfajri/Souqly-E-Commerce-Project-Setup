@extends('layouts.admin')

@section('title', 'SOUQLY — Vue d\'ensemble Admin')
@section('header_title', 'Tableau de Bord Administratif')

@section('content')
<div class="space-y-8">

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Revenue in MAD -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Chiffre d'Affaires</span>
                <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-base">
                    MAD
                </span>
            </div>
            <div class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                {{ number_format($metrics['total_revenue_mad'], 2) }} <span class="text-xs text-slate-500 font-normal">د.م.</span>
            </div>
            <p class="text-xs text-emerald-600 font-semibold mt-2 flex items-center gap-1">
                <span>✓</span> Encaissé / Livré en COD
            </p>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Commandes Totales</span>
                <span class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-base">
                    📦
                </span>
            </div>
            <div class="text-2xl font-black text-slate-900 font-mono">
                {{ $metrics['total_orders'] }}
            </div>
            <div class="flex items-center gap-2 mt-2 text-xs">
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold">
                    {{ $metrics['pending_orders'] }} en attente
                </span>
                <span class="px-2 py-0.5 rounded-full bg-sky-100 text-sky-800 font-bold">
                    {{ $metrics['shipped_orders'] }} en cours
                </span>
            </div>
        </div>

        <!-- Catalog Products & Stock Alerts -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Produits Actifs</span>
                <span class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-base">
                    🏷️
                </span>
            </div>
            <div class="text-2xl font-black text-slate-900 font-mono">
                {{ $metrics['total_products'] }}
            </div>
            <div class="mt-2 text-xs">
                @if($metrics['low_stock_products'] > 0)
                    <span class="text-rose-600 font-bold flex items-center gap-1">
                        <span>⚠️</span> {{ $metrics['low_stock_products'] }} produit(s) en stock critique (≤5)
                    </span>
                @else
                    <span class="text-emerald-600 font-semibold">Tous les stocks sont optimaux</span>
                @endif
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Clients Inscrits</span>
                <span class="w-10 h-10 rounded-xl bg-orange-100 text-souqly-orange flex items-center justify-center font-bold text-base">
                    👥
                </span>
            </div>
            <div class="text-2xl font-black text-slate-900 font-mono">
                {{ $metrics['total_customers'] }}
            </div>
            <p class="text-xs text-slate-500 mt-2">
                Clients avec comptes au Maroc
            </p>
        </div>

    </div>

    <!-- Quick Action Bar -->
    <div class="bg-gradient-to-r from-souqly-navy to-slate-900 rounded-2xl p-6 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-md">
        <div>
            <h3 class="text-lg font-bold">Gestion Rapide SOUQLY</h3>
            <p class="text-xs text-slate-300 mt-1">Actions administratives prioritaires pour le marché marocain.</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-souqly-orange hover:bg-souqly-orange-hover text-white text-xs font-bold rounded-xl shadow transition">
                Traiter les Commandes ({{ $metrics['pending_orders'] }})
            </a>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/20 transition">
                + Nouveau Produit
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/20 transition">
                Ajuster le Stock
            </a>
        </div>
    </div>

    <!-- 2-Columns: Recent Orders + Recent Inventory Audit Movements -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Recent Orders (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <span>📦</span> Dernières Commandes Clients
                </h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-souqly-orange hover:underline">
                    Voir toutes les commandes &rarr;
                </a>
            </div>

            @if($recentOrders->isEmpty())
                <p class="text-xs text-slate-500 py-6 text-center">Aucune commande enregistrée pour le moment.</p>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($recentOrders as $order)
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
                            <div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono font-bold text-slate-900 hover:text-souqly-orange transition">
                                        {{ $order->order_number }}
                                    </a>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $order->status->badgeClasses() }}">
                                        {{ $order->status->label('fr') }}
                                    </span>
                                </div>
                                <p class="text-slate-500 text-[11px] mt-0.5">
                                    {{ $order->customer_name }} • {{ $order->shipping_city }} • {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3 self-end sm:self-center">
                                <div class="text-right rtl:text-left">
                                    <span class="font-bold text-slate-900 text-sm block">{{ number_format($order->total, 2) }} MAD</span>
                                    <span class="text-[10px] text-slate-400">COD</span>
                                </div>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="Consulter la commande">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Stock Movements Audit Trail (5 cols) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <span>📋</span> Mouvements de Stock
                </h3>
                <a href="{{ route('admin.inventory.index') }}" class="text-xs font-bold text-souqly-orange hover:underline">
                    Journal complet &rarr;
                </a>
            </div>

            @if($recentMovements->isEmpty())
                <p class="text-xs text-slate-500 py-6 text-center">Aucun mouvement de stock consigné.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentMovements as $mv)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="font-bold text-slate-800 truncate max-w-[180px]">
                                    {{ $mv->product?->name ?? 'Produit #' . $mv->product_id }}
                                </span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold {{ $mv->type->badgeClasses() }}">
                                    {{ $mv->type->label('fr') }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-[11px] text-slate-500">
                                <span>Réf: <strong class="font-mono text-slate-700">{{ $mv->reference ?? 'Manuel' }}</strong></span>
                                <span class="font-bold {{ $mv->quantity > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $mv->quantity > 0 ? '+' : '' }}{{ $mv->quantity }} ({{ $mv->stock_before }} &rarr; {{ $mv->stock_after }})
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
