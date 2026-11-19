@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('cart.title'))

@section('content')
<div class="py-12 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 pb-6 border-b border-stone-200/80 flex items-baseline justify-between">
            <div>
                <span class="text-[10px] uppercase tracking-[0.24em] font-medium text-stone-400 block mb-1">RÉCAPITULATIF PRIVÉ</span>
                <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal">
                    {{ __('cart.title') }}
                </h1>
            </div>
            <a href="{{ route('shop') }}" class="text-[11px] uppercase tracking-[0.18em] font-semibold text-stone-600 hover:text-stone-900 transition-colors">
                &larr; {{ __('cart.continue_shopping') }}
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-medium flex items-center gap-3">
                <span class="text-emerald-600 text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-8 p-4 bg-stone-100 border border-stone-300 text-stone-900 text-xs font-medium">
                {{ session('info') }}
            </div>
        @endif

        @if($cart->items->isEmpty())
            <!-- Empty Cart State Minimalist -->
            <div class="bg-white border border-stone-200/80 p-16 text-center max-w-xl mx-auto space-y-4 shadow-xs">
                <div class="w-16 h-16 bg-[#FAF8F5] border border-stone-200 flex items-center justify-center text-3xl mx-auto mb-2 text-stone-400">
                    🛍️
                </div>
                <h2 class="font-serif text-2xl text-stone-900 font-normal">
                    {{ __('cart.empty_title') }}
                </h2>
                <p class="text-xs text-stone-500 max-w-sm mx-auto leading-relaxed font-light">
                    {{ __('cart.empty_subtitle') }}
                </p>
                <div class="pt-4">
                    <a href="{{ route('shop') }}" class="btn-primary text-[10px] uppercase tracking-[0.2em] px-8 py-3.5 font-semibold">
                        {{ __('cart.continue_shopping') }} &rarr;
                    </a>
                </div>
            </div>
        @else
            <!-- Active Cart with Items -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Items Table / List -->
                <div class="lg:col-span-8 bg-white border border-stone-200/80 p-6 sm:p-8 space-y-6 shadow-xs">
                    <div class="divide-y divide-stone-100">
                        @foreach($cart->items as $item)
                            <div class="py-6 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-20 h-20 bg-[#FAF8F5] border border-stone-200/70 flex items-center justify-center text-3xl shrink-0">
                                        @if($item->product->category->slug === 'luxury-watches') ⌚ @elseif($item->product->category->slug === 'electronics') 📱 @elseif($item->product->category->slug === 'fashion') 👜 @else 🏺 @endif
                                    </div>
                                    <div>
                                        <h3 class="font-serif text-base text-stone-900 font-normal hover:text-amber-800 transition">
                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        @if($item->variant)
                                            <div class="text-[11px] text-stone-500 mt-1">
                                                @foreach($item->variant->attributes as $k => $v)
                                                    <span class="inline-block bg-[#FAF8F5] border border-stone-200 px-2 py-0.5 text-stone-600 text-[10px] uppercase tracking-wider me-1">{{ $k }}: {{ $v }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="text-xs font-medium text-stone-900 mt-1 tracking-wide">
                                            {{ number_format($item->unit_price, 2) }} <span class="text-stone-400 font-sans text-[11px]">MAD</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity & Total -->
                                <div class="flex items-center justify-between w-full sm:w-auto gap-8">
                                    <!-- Minimal Quantity Selector -->
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center border border-stone-300">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="w-8 h-8 flex items-center justify-center text-stone-600 hover:bg-stone-100 font-medium text-xs transition">
                                            -
                                        </button>
                                        <span class="w-8 text-center text-xs font-mono font-medium">{{ $item->quantity }}</span>
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="w-8 h-8 flex items-center justify-center text-stone-600 hover:bg-stone-100 font-medium text-xs transition">
                                            +
                                        </button>
                                    </form>

                                    <!-- Subtotal -->
                                    <div class="text-end min-w-[100px]">
                                        <span class="font-medium text-sm text-stone-900 block tracking-wide">
                                            {{ number_format($item->subtotal, 2) }} <span class="text-[11px] text-stone-400 font-sans">MAD</span>
                                        </span>
                                    </div>

                                    <!-- Delete Item -->
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-stone-300 hover:text-stone-700 p-1 transition" title="{{ __('cart.item_removed') }}">
                                            <svg class="w-4 h-4 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-6 border-t border-stone-100 flex items-center justify-between text-xs tracking-wider">
                        <a href="{{ route('shop') }}" class="font-semibold text-stone-900 hover:text-[#C5A059] transition flex items-center gap-1.5 uppercase text-[10.5px]">
                            &larr; {{ __('cart.continue_shopping') }}
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-stone-400 hover:text-stone-900 text-[10.5px] uppercase tracking-widest transition">
                                {{ __('cart.clear_cart') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary Card (Minimalist Luxury Box) -->
                <div class="lg:col-span-4 bg-white border border-stone-200/80 p-7 space-y-6 shadow-xs">
                    <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900 pb-4 border-b border-stone-200/80">
                        {{ __('checkout.order_summary') }}
                    </h2>

                    <div class="space-y-4 text-xs tracking-wider">
                        <div class="flex items-center justify-between text-stone-600">
                            <span>{{ __('cart.subtotal') }}</span>
                            <span class="font-medium text-stone-900">{{ number_format($cart->subtotal, 2) }} MAD</span>
                        </div>

                        <div class="flex items-center justify-between text-stone-600">
                            <span>{{ __('cart.shipping') }}</span>
                            @if($cart->shipping_cost == 0)
                                <span class="font-semibold text-emerald-800">{{ __('cart.shipping_free') }}</span>
                            @else
                                <span class="font-medium text-stone-900">{{ number_format($cart->shipping_cost, 2) }} MAD</span>
                            @endif
                        </div>

                        @if($cart->subtotal < 500)
                            <div class="p-3 bg-[#FAF8F5] border border-stone-200 text-stone-600 text-[11px] font-light leading-relaxed">
                                💡 Ajoutez encore <strong>{{ number_format(500 - $cart->subtotal, 2) }} MAD</strong> pour bénéficier de la livraison offerte par porteur !
                            </div>
                        @endif

                        <div class="pt-4 border-t border-stone-200/80 flex items-baseline justify-between">
                            <span class="font-semibold uppercase tracking-wider text-stone-900 text-[11px]">{{ __('cart.order_total') }}</span>
                            <div class="text-end">
                                <span class="font-serif text-2xl font-normal text-stone-900">{{ number_format($cart->total, 2) }}</span>
                                <span class="font-sans text-xs text-stone-500 ms-1">MAD</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout CTA Button -->
                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full py-4 text-[11px] uppercase tracking-[0.2em] font-semibold text-center block transition">
                        {{ __('cart.proceed_checkout') }} &rarr;
                    </a>

                    <!-- Moroccan Trust Pill -->
                    <div class="p-4 bg-[#FAF8F5] border border-stone-200/70 text-[11px] text-stone-500 text-center space-y-1 font-light">
                        <span class="font-medium text-stone-900 uppercase tracking-wider text-[10px] block">💵 Paiement 100% à la livraison (COD)</span>
                        <span>Vérifiez vos pièces avec le livreur avant de régler en espèces.</span>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
