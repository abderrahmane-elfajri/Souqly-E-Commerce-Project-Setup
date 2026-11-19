@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('checkout.order_placed_success'))

@section('content')
<div class="py-12 bg-slate-50 min-h-[75vh]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        
        <!-- Success Card Header -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 sm:p-12 text-center mb-8">
            <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-4xl mx-auto mb-4">
                ✓
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
                {{ __('checkout.order_placed_success') }}
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-500 mt-2 max-w-lg mx-auto leading-relaxed">
                {{ __('checkout.tracking_info') }}
            </p>

            <!-- Order Reference Pill -->
            <div class="mt-6 inline-flex flex-col sm:flex-row items-center gap-2 p-3 px-6 rounded-2xl bg-slate-50 border border-slate-200">
                <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold">{{ __('checkout.order_number') }} :</span>
                <span class="font-mono font-black text-base text-souqly-navy">{{ $order->order_number }}</span>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $order->status->badgeClasses() }}">
                    {{ $order->status->label() }}
                </span>
            </div>
        </div>

        <!-- Order Summary & Shipping Info -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6 mb-8">
            <h2 class="font-black text-slate-900 text-base pb-3 border-b border-slate-100">
                Détails de l'Expédition & Articles
            </h2>

            <!-- Delivery Snapshot -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                    <span class="font-bold text-slate-800 block text-xs">Destinataire & Contact :</span>
                    <div class="text-slate-600">{{ $order->customer_name }}</div>
                    <div class="text-slate-600">📞 {{ $order->customer_phone }}</div>
                    <div class="text-slate-600">{{ $order->customer_email }}</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                    <span class="font-bold text-slate-800 block text-xs">Adresse de Livraison :</span>
                    <div class="text-slate-600">{{ $order->shipping_address }}</div>
                    <div class="font-bold text-slate-800">🇲🇦 {{ $order->shipping_city }}</div>
                    <div class="text-emerald-700 font-semibold pt-1">🚚 Expédition sous 24h à 48h</div>
                </div>
            </div>

            <!-- Items List -->
            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="py-3.5 flex items-center justify-between text-xs">
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $item->product_name }}</h4>
                            <div class="text-[11px] text-slate-500">
                                Réf: {{ $item->sku }} • Qté: {{ $item->quantity }} × {{ number_format($item->unit_price, 2) }} MAD
                            </div>
                        </div>
                        <div class="font-black text-slate-900">
                            {{ number_format($item->total, 2) }} MAD
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Financial Total -->
            <div class="pt-4 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Sous-total :</span>
                    <span>{{ number_format($order->subtotal, 2) }} MAD</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Frais de livraison :</span>
                    <span>{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2) . ' MAD' : 'Gratuite' }}</span>
                </div>
                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-base">
                    <span class="font-black text-slate-900">Total à payer au livreur :</span>
                    <div class="text-end">
                        <span class="font-black text-xl text-souqly-orange">{{ number_format($order->total, 2) }}</span>
                        <span class="font-bold text-xs text-souqly-navy">MAD (Paiement COD)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions: WhatsApp Tracking + Return to Shop -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @php
                $waConfirmMessage = rawurlencode("Bonjour Souqly, je viens de passer la commande N° " . $order->order_number . " (Montant: " . number_format($order->total, 2) . " MAD à destination de " . $order->shipping_city . "). Merci de me confirmer la prise en charge.");
            @endphp
            <a 
                href="https://wa.me/212600000000?text={{ $waConfirmMessage }}"
                target="_blank"
                class="btn-primary w-full sm:w-auto px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-xs font-bold shadow-lg flex items-center justify-center gap-2"
            >
                <span>📲 {{ __('checkout.whatsapp_tracking') }}</span>
            </a>

            <a href="{{ route('shop') }}" class="btn-outline w-full sm:w-auto px-6 py-3.5 text-xs font-bold text-center">
                {{ __('checkout.back_to_shop') }}
            </a>
        </div>

    </div>
</div>
@endsection
