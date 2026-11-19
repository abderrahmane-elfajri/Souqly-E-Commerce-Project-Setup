@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('checkout.order_placed_success'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        
        <!-- Luxury Confirmation Header Card -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-14 text-center mb-8 shadow-xs">
            <div class="w-16 h-16 bg-[#FAF8F5] border border-stone-300 text-[#C5A059] flex items-center justify-center font-serif text-2xl mx-auto mb-6">
                ✓
            </div>
            
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#C5A059] font-medium block mb-2">
                {{ app()->getLocale() === 'ar' ? 'تم تأكيد طلبك' : (app()->getLocale() === 'en' ? 'Order Confirmed' : 'Confirmation de Commande') }}
            </span>

            <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal tracking-tight mb-3">
                {{ __('checkout.order_placed_success') }}
            </h1>
            
            <p class="text-xs sm:text-sm text-stone-500 max-w-lg mx-auto font-light leading-relaxed">
                {{ __('checkout.tracking_info') }}
            </p>

            <!-- Order Reference & Status Pill -->
            <div class="mt-8 inline-flex flex-col sm:flex-row items-center gap-3 p-4 px-6 bg-[#FAF8F5] border border-stone-200">
                <span class="text-[10px] text-stone-400 uppercase tracking-[0.2em] font-semibold">{{ __('checkout.order_number') }} :</span>
                <span class="font-mono font-bold text-base text-stone-900 tracking-wider">{{ $order->order_number }}</span>
                <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] uppercase tracking-widest font-semibold border {{ $order->status->badgeClasses() }}">
                    {{ $order->status->label(app()->getLocale()) }}
                </span>
            </div>
        </div>

        <!-- Order Summary & Shipping Details -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-10 space-y-8 mb-8 shadow-xs">
            <div class="flex items-baseline justify-between pb-4 border-b border-stone-200/80">
                <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900">
                    {{ __('checkout.shipping_details') }}
                </h2>
                <span class="text-[10px] uppercase tracking-widest text-[#C5A059] font-medium">
                    Maroc • {{ $order->shipping_city }}
                </span>
            </div>

            <!-- Delivery Snapshot -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div class="p-5 bg-[#FAF8F5] border border-stone-200/70 space-y-1.5">
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-stone-400 block">
                        {{ __('checkout.recipient_contact') }}
                    </span>
                    <div class="font-serif text-base text-stone-900">{{ $order->customer_name }}</div>
                    <div class="text-stone-600 font-mono text-[11px] flex items-center gap-1.5">
                        <svg class="w-3 h-3 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ $order->customer_phone }}</span>
                    </div>
                    <div class="text-stone-500 text-[11px] font-light">{{ $order->customer_email }}</div>
                </div>

                <div class="p-5 bg-[#FAF8F5] border border-stone-200/70 space-y-1.5">
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-stone-400 block">
                        {{ __('checkout.shipping_address_title') }}
                    </span>
                    <div class="text-stone-700 font-light">{{ $order->shipping_address }}</div>
                    <div class="font-medium text-stone-900">{{ $order->shipping_city }}, Maroc</div>
                    <div class="text-emerald-800 text-[11px] font-medium pt-1 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        <span>{{ __('checkout.delivery_notice') }}</span>
                    </div>
                </div>
            </div>

            <!-- Ordered Items List -->
            <div class="divide-y divide-stone-100">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center justify-between text-xs tracking-wider">
                        <div class="flex items-center gap-4">
                            @if($item->product)
                                <div class="w-12 h-12 bg-[#FAF8F5] border border-stone-200/70 shrink-0 overflow-hidden">
                                    <img 
                                        src="{{ $item->product->primary_image_url }}" 
                                        alt="{{ $item->product_name }}" 
                                        class="w-full h-full object-cover object-center"
                                        width="48"
                                        height="48"
                                        loading="lazy"
                                    >
                                </div>
                            @endif
                            <div>
                                <h4 class="font-serif text-sm sm:text-base text-stone-900">{{ $item->product_name }}</h4>
                                <div class="text-[11px] text-stone-400 font-mono mt-0.5">
                                    SKU: {{ $item->sku }} • {{ __('checkout.quantity') }}: {{ $item->quantity }} × {{ number_format($item->unit_price, 2) }} {{ $order->currency }}
                                </div>
                            </div>
                        </div>
                        <div class="font-medium text-stone-900 text-sm">
                            {{ number_format($item->total, 2) }} <span class="text-[11px] text-stone-500 font-sans">{{ $order->currency }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Financial Totals -->
            <div class="pt-6 border-t border-stone-200/80 space-y-3 text-xs tracking-wider">
                <div class="flex items-center justify-between text-stone-600 font-light">
                    <span>{{ __('checkout.subtotal') }} :</span>
                    <span>{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</span>
                </div>
                <div class="flex items-center justify-between text-stone-600 font-light">
                    <span>{{ __('checkout.shipping_fee') }} :</span>
                    <span>{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2) . ' ' . $order->currency : __('checkout.free') }}</span>
                </div>
                
                <div class="pt-4 border-t border-stone-200/80 flex items-baseline justify-between text-base">
                    <div>
                        <span class="text-xs uppercase tracking-[0.2em] font-semibold text-stone-900 block">
                            {{ __('checkout.pay_on_delivery') }}
                        </span>
                        <span class="text-[10px] text-stone-400 font-light">
                            {{ __('checkout.cod_desc') }}
                        </span>
                    </div>
                    <div class="text-end">
                        <span class="font-serif text-2xl font-normal text-stone-900">{{ number_format($order->total, 2) }}</span>
                        <span class="text-xs font-sans text-[#C5A059] font-medium ms-1">{{ $order->currency }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action CTAs -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @php
                $cleanPhone = '212600000000';
                $waConfirmMessage = rawurlencode(
                    app()->getLocale() === 'ar'
                        ? "السلام عليكم سوقلي، قمت بتأكيد الطلب رقم {$order->order_number} بمبلغ " . number_format($order->total, 2) . " درهم إلى مدينة {$order->shipping_city}. يرجى تأكيد الشحن."
                        : "Bonjour Souqly, je viens de passer la commande N° {$order->order_number} (Montant: " . number_format($order->total, 2) . " MAD à destination de {$order->shipping_city}). Merci de me confirmer la prise en charge."
                );
            @endphp
            
            <a 
                href="https://wa.me/{{ $cleanPhone }}?text={{ $waConfirmMessage }}"
                target="_blank"
                rel="noopener noreferrer"
                class="w-full sm:w-auto px-8 py-4 bg-emerald-800 hover:bg-emerald-900 text-white text-[11px] uppercase tracking-[0.2em] font-semibold flex items-center justify-center gap-2.5 transition shadow-xs"
            >
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>{{ __('checkout.whatsapp_tracking') }}</span>
            </a>

            <a 
                href="{{ route('track') }}?order_number={{ $order->order_number }}&phone={{ $order->customer_phone }}" 
                class="w-full sm:w-auto px-6 py-4 bg-white border border-stone-300 hover:border-stone-900 text-stone-900 text-[11px] uppercase tracking-[0.2em] font-semibold text-center transition"
            >
                {{ __('checkout.track_parcel') }}
            </a>

            <a 
                href="{{ route('shop') }}" 
                class="w-full sm:w-auto px-6 py-4 text-stone-500 hover:text-stone-900 text-[11px] uppercase tracking-[0.2em] font-medium text-center transition"
            >
                {{ __('checkout.back_to_shop') }} &rarr;
            </a>
        </div>

    </div>
</div>
@endsection
