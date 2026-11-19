@extends('layouts.admin')

@section('title', 'Gestion des Commandes — Admin SOUQLY')
@section('header_title', 'Commandes & Expéditions')

@section('content')
<div class="space-y-6">

    <!-- Filters & Search Toolbar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        
        <!-- Status Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs font-semibold">
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 rounded-lg transition {{ empty($currentStatus) ? 'bg-souqly-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Toutes ({{ \App\Models\Order::count() }})
            </a>
            @foreach(\App\Enums\OrderStatus::cases() as $st)
                @php
                    $count = \App\Models\Order::where('status', $st)->count();
                @endphp
                <a href="{{ route('admin.orders.index', ['status' => $st->value]) }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap transition {{ $currentStatus === $st->value ? 'bg-souqly-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $st->label('fr') }} ({{ $count }})
                </a>
            @endforeach
        </div>

        <!-- Search input -->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-2">
            @if($currentStatus)
                <input type="hidden" name="status" value="{{ $currentStatus }}">
            @endif
            <div class="relative">
                <input 
                    type="search" 
                    name="q" 
                    value="{{ $searchQuery ?? '' }}" 
                    placeholder="N° commande, client, ville..." 
                    class="text-xs px-3.5 py-2 pe-8 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange w-56 sm:w-64"
                >
                <div class="absolute inset-y-0 end-2 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition">
                Filtrer
            </button>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">N° Commande</th>
                        <th class="py-3.5 px-4">Client</th>
                        <th class="py-3.5 px-4">Destination</th>
                        <th class="py-3.5 px-4">Articles</th>
                        <th class="py-3.5 px-4">Total</th>
                        <th class="py-3.5 px-4">Paiement</th>
                        <th class="py-3.5 px-4">Statut</th>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-souqly-orange transition">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $order->customer_name }}</div>
                                <div class="text-[11px] text-slate-500 font-mono">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-slate-800">{{ $order->shipping_city }}</span>
                                @if($order->latestShipment)
                                    <span class="block text-[10px] text-sky-600 font-semibold">{{ $order->latestShipment->carrier }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-600">
                                {{ $order->items_count }} article(s)
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900 font-mono">
                                {{ number_format($order->total, 2) }} MAD
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $order->payment_status === \App\Enums\PaymentStatus::PAID ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $order->payment_status->label('fr') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold {{ $order->status->badgeClasses() }}">
                                    {{ $order->status->label('fr') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg text-xs font-bold transition">
                                    <span>Gérer</span>
                                    <span>&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-500">
                                Aucune commande trouvée selon ces critères.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
