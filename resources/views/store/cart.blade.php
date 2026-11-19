@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('cart.title'))

@section('content')
<div class="py-10 bg-slate-50 min-h-[70vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-8">
            {{ __('cart.title') }}
        </h1>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-semibold">
                {{ session('info') }}
            </div>
        @endif

        @if($cart->items->isEmpty())
            <!-- Empty Cart State -->
            <div class="bg-white rounded-3xl border border-slate-200 p-12 sm:p-16 text-center max-w-xl mx-auto shadow-sm">
                <div class="w-24 h-24 rounded-full bg-orange-100/70 text-souqly-orange flex items-center justify-center text-4xl mx-auto mb-6">
                    🛒
                </div>
                <h2 class="text-xl font-black text-slate-900 mb-2">
                    {{ __('cart.empty_title') }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mb-8 leading-relaxed">
                    {{ __('cart.empty_subtitle') }}
                </p>
                <a href="{{ route('shop') }}" class="btn-primary text-sm px-8 py-3.5 shadow-lg">
                    {{ __('cart.continue_shopping') }} &rarr;
                </a>
            </div>
        @else
            <!-- Active Cart with Items -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Items Table / List -->
                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
                    <div class="divide-y divide-slate-100">
                        @foreach($cart->items as $item)
                            <div class="py-5 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-20 rounded-xl bg-slate-100 flex items-center justify-center text-3xl shrink-0 border border-slate-200">
                                        @if($item->product->category->slug === 'luxury-watches') ⌚ @elseif($item->product->category->slug === 'electronics') 📱 @elseif($item->product->category->slug === 'fashion') 👜 @else 🏺 @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-sm text-slate-900 hover:text-souqly-orange transition">
                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        @if($item->variant)
                                            <div class="text-[11px] text-slate-500 mt-0.5">
                                                @foreach($item->variant->attributes as $k => $v)
                                                    <span class="inline-block bg-slate-100 px-2 py-0.5 rounded text-slate-600 font-medium me-1">{{ $k }}: {{ $v }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="text-xs font-bold text-souqly-orange mt-1">
                                            {{ number_format($item->unit_price, 2) }} MAD
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity & Total -->
                                <div class="flex items-center justify-between w-full sm:w-auto gap-6">
                                    <!-- Quantity form -->
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="w-7 h-7 rounded-lg border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-bold text-xs">
                                            -
                                        </button>
                                        <span class="w-8 text-center text-xs font-bold">{{ $item->quantity }}</span>
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="w-7 h-7 rounded-lg border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-bold text-xs">
                                            +
                                        </button>
                                    </form>

                                    <!-- Subtotal -->
                                    <div class="text-end min-w-[90px]">
                                        <span class="font-black text-sm text-slate-900 block">
                                            {{ number_format($item->subtotal, 2) }} MAD
                                        </span>
                                    </div>

                                    <!-- Delete Item -->
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-rose-600 p-1 transition" title="{{ __('cart.item_removed') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('shop') }}" class="font-bold text-souqly-navy hover:text-souqly-orange flex items-center gap-1">
                            &larr; {{ __('cart.continue_shopping') }}
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-rose-600 hover:underline">
                                {{ __('cart.clear_cart') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
                    <h2 class="text-base font-black text-slate-900 pb-3 border-b border-slate-100">
                        {{ __('checkout.order_summary') }}
                    </h2>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>{{ __('cart.subtotal') }}</span>
                            <span class="font-bold text-slate-900">{{ number_format($cart->subtotal, 2) }} MAD</span>
                        </div>

                        <div class="flex items-center justify-between text-slate-600">
                            <span>{{ __('cart.shipping') }}</span>
                            @if($cart->shipping_cost == 0)
                                <span class="font-bold text-emerald-600">{{ __('cart.shipping_free') }}</span>
                            @else
                                <span class="font-bold text-slate-900">{{ number_format($cart->shipping_cost, 2) }} MAD</span>
                            @endif
                        </div>

                        @if($cart->subtotal < 500)
                            <div class="p-2.5 rounded-lg bg-orange-50 text-souqly-orange text-[11px] font-medium border border-orange-100">
                                💡 Ajoutez encore <strong>{{ number_format(500 - $cart->subtotal, 2) }} MAD</strong> pour bénéficier de la livraison gratuite !
                            </div>
                        @endif

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="font-black text-slate-900">{{ __('cart.order_total') }}</span>
                            <div class="text-end">
                                <span class="font-black text-xl text-souqly-orange">{{ number_format($cart->total, 2) }}</span>
                                <span class="font-bold text-xs text-souqly-navy">MAD</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout CTA Button -->
                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full py-3.5 text-sm font-bold shadow-lg text-center block">
                        {{ __('cart.proceed_checkout') }} &rarr;
                    </a>

                    <!-- Moroccan Trust Pill -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-500 text-center space-y-1">
                        <span class="font-bold text-slate-800 block">💵 Paiement 100% à la livraison (COD)</span>
                        <span>Vérifiez vos articles avant de régler le livreur.</span>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
