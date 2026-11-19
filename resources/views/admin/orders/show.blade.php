@extends('layouts.admin')

@section('title', 'Détails Commande ' . $order->order_number . ' — Admin SOUQLY')
@section('header_title', 'Gestion Commande #' . $order->order_number)

@section('content')
<div class="space-y-8">

    <!-- Top Action & Info Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-2xl font-black text-slate-900 font-mono tracking-tight">{{ $order->order_number }}</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->status->badgeClasses() }}">
                    {{ $order->status->label('fr') }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">
                    COD (Paiement à la livraison)
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Enregistrée le {{ $order->created_at->translatedFormat('d F Y à H:i') }} ({{ $order->created_at->diffForHumans() }})
            </p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <!-- Moroccan WhatsApp Direct Link -->
            @php
                $cleanPhone = preg_replace('/[^\d]/', '', $order->customer_phone);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '212' . substr($cleanPhone, 1);
                }
                $waMsg = "Bonjour {$order->customer_name}, c'est le service client Souqly concernant votre commande {$order->order_number} pour livraison à {$order->shipping_city}.";
                $waUrl = "https://wa.me/{$cleanPhone}?text=" . rawurlencode($waMsg);
            @endphp
            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Contacter sur WhatsApp</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                &larr; Retour liste
            </a>
        </div>
    </div>

    <!-- Administrative Operations: Status Transition & Courier Dispatch -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Status Transition Box -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span>⚡</span> Modifier le statut de la commande
            </h3>
            
            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nouveau Statut
                    </label>
                    <select name="status" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                        @foreach(\App\Enums\OrderStatus::cases() as $st)
                            <option value="{{ $st->value }}" {{ $order->status === $st ? 'selected' : '' }} {{ ! $order->status->canTransitionTo($st) && $order->status !== $st ? 'disabled' : '' }}>
                                {{ $st->label('fr') }} {{ ! $order->status->canTransitionTo($st) && $order->status !== $st ? '(Non autorisé)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Note administrative interne (optionnelle)
                    </label>
                    <input type="text" name="note" placeholder="Ex: Confirmation téléphonique avec le client..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                </div>

                <button type="submit" class="px-5 py-2.5 bg-souqly-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow transition">
                    Enregistrer le statut
                </button>
            </form>
        </div>

        <!-- Moroccan Courier Dispatch Form -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span>🚚</span> Expédition & Transporteur Maroc
            </h3>

            @if($order->latestShipment)
                <div class="p-4 rounded-xl bg-sky-50 border border-sky-100 space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sky-950 text-sm">{{ $order->latestShipment->carrier }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $order->latestShipment->status->badgeClasses() }}">
                            {{ $order->latestShipment->status->label('fr') }}
                        </span>
                    </div>
                    <div class="text-sky-800">
                        N° de suivi: <strong class="font-mono text-sky-950">{{ $order->latestShipment->tracking_number }}</strong>
                    </div>
                    <div class="text-[11px] text-sky-600">
                        Expédié le {{ $order->latestShipment->shipped_at?->format('d/m/Y à H:i') }}
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('admin.orders.ship', $order->id) }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Transporteur Marocain
                            </label>
                            <select name="carrier" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                                <option value="Amana Express (Poste Maroc)">Amana Express (Poste Maroc)</option>
                                <option value="Cathedis Express">Cathedis Express</option>
                                <option value="Ozone Express">Ozone Express</option>
                                <option value="Aramex Maroc">Aramex Maroc</option>
                                <option value="Livreur Interne Souqly">Livreur Interne Souqly</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                N° de suivi (Tracking)
                            </label>
                            <input type="text" name="tracking_number" required placeholder="Ex: AMN-1928374-MA" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-mono uppercase">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Instructions livreur
                        </label>
                        <input type="text" name="notes" placeholder="Ex: Colis fragile, vérifier le paiement cash..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                    </div>

                    <button type="submit" class="px-5 py-2.5 bg-souqly-orange hover:bg-souqly-orange-hover text-white text-xs font-bold rounded-xl shadow transition">
                        Assigner l'expédition & Expédier
                    </button>
                </form>
            @endif
        </div>

    </div>

    <!-- 2-Columns: Items Snapshot + Customer Info -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Ordered Items (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm flex items-center justify-between pb-3 border-b border-slate-100">
                <span>Articles commandés ({{ $order->items_count }})</span>
                <span class="text-xs text-slate-500 font-mono">MAD (د.م.)</span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="py-2.5 px-3">Article</th>
                            <th class="py-2.5 px-3">SKU</th>
                            <th class="py-2.5 px-3 text-right">Prix Unitaire</th>
                            <th class="py-2.5 px-3 text-center">Qté</th>
                            <th class="py-2.5 px-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                            <img 
                                                src="{{ $item->product?->primary_image_url ?? 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=80&q=80' }}" 
                                                alt="{{ $item->product_name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $item->product_name }}</div>
                                            @if($item->variant_attributes)
                                                <div class="text-[11px] text-slate-500 mt-0.5">
                                                    @foreach($item->variant_attributes as $k => $v)
                                                        <span>{{ ucfirst($k) }}: {{ $v }} </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3 font-mono text-slate-600">{{ $item->sku }}</td>
                                <td class="py-3 px-3 text-right font-mono">{{ number_format($item->unit_price, 2) }} MAD</td>
                                <td class="py-3 px-3 text-center font-bold">{{ $item->quantity }}</td>
                                <td class="py-3 px-3 text-right font-bold text-slate-900 font-mono">{{ number_format($item->total, 2) }} MAD</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Financials Summary -->
            <div class="pt-4 border-t border-slate-100 max-w-xs ms-auto space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Sous-total:</span>
                    <span class="font-bold font-mono">{{ number_format($order->subtotal, 2) }} MAD</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Frais de livraison:</span>
                    <span class="font-bold font-mono">{{ number_format($order->shipping_cost, 2) }} MAD</span>
                </div>
                @if($order->discount > 0)
                    <div class="flex justify-between text-emerald-600 font-bold">
                        <span>Remise:</span>
                        <span class="font-mono">-{{ number_format($order->discount, 2) }} MAD</span>
                    </div>
                @endif
                <div class="pt-2 border-t border-slate-200 flex justify-between text-sm font-black text-slate-900">
                    <span>Total à encaisser (COD):</span>
                    <span class="text-souqly-orange font-mono">{{ number_format($order->total, 2) }} MAD</span>
                </div>
            </div>
        </div>

        <!-- Customer Snapshot & Shipping Address (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-6">
            <div>
                <h3 class="font-bold text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span>👤</span> Données Client
                </h3>
                <div class="mt-3 space-y-2 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Nom complet</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Téléphone marocain</span>
                        <span class="font-bold text-slate-800 font-mono">{{ $order->customer_phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Email</span>
                        <span class="text-slate-700">{{ $order->customer_email }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span>📍</span> Adresse de livraison au Maroc
                </h3>
                <div class="mt-3 space-y-2 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Ville</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $order->shipping_city }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Adresse exacte</span>
                        <p class="text-slate-700 leading-relaxed">{{ $order->shipping_address }}</p>
                    </div>
                    @if($order->shipping_notes)
                        <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-[11px]">
                            <strong class="block mb-0.5">Instructions :</strong>
                            {{ $order->shipping_notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
