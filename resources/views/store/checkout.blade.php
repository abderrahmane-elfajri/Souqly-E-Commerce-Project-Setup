@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('checkout.checkout'))

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-8">
            {{ __('checkout.checkout') }}
        </h1>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            {{-- Honeypot anti-spam field --}}
            <div class="hidden" aria-hidden="true" style="display:none;">
                <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Customer Details & Moroccan Address -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Contact and Address Block -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-5">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h2 class="font-black text-slate-900 text-base flex items-center gap-2">
                                <span>📍</span> {{ __('checkout.contact_shipping') }}
                            </h2>
                            @guest
                                <a href="{{ route('login') }}" class="text-xs font-bold text-souqly-orange hover:underline">
                                    Déjà client ? Se connecter
                                </a>
                            @endguest
                        </div>

                        <!-- Name & Email (2 columns) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('checkout.full_name') }} *
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    value="{{ old('name', $defaultAddress?->full_name ?? $user?->name) }}" 
                                    required 
                                    placeholder="Yassine El Amrani"
                                    class="w-full text-xs px-3.5 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                                >
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('checkout.email') }} *
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    value="{{ old('email', $user?->email) }}" 
                                    required 
                                    placeholder="yassine@example.com"
                                    class="w-full text-xs px-3.5 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                                >
                            </div>
                        </div>

                        <!-- Phone & City (2 columns) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('checkout.phone') }} *
                                </label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    id="phone" 
                                    value="{{ old('phone', $defaultAddress?->phone ?? $user?->phone) }}" 
                                    required 
                                    placeholder="0661234567"
                                    class="w-full text-xs px-3.5 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                                >
                                <span class="text-[10px] text-slate-400 mt-1 block">Le livreur vous appellera avant de livrer.</span>
                            </div>

                            <div>
                                <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('checkout.city') }} *
                                </label>
                                <select 
                                    name="city" 
                                    id="city" 
                                    required
                                    class="w-full text-xs px-3.5 py-3 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                                >
                                    <option value="">Sélectionnez votre ville au Maroc</option>
                                    @foreach($moroccanCities as $city)
                                        <option value="{{ $city }}" {{ old('city', $defaultAddress?->city) === $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Full Delivery Address -->
                        <div>
                            <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                {{ __('checkout.address') }} *
                            </label>
                            <input 
                                type="text" 
                                name="address" 
                                id="address" 
                                value="{{ old('address', $defaultAddress?->address) }}" 
                                required 
                                placeholder="Quartier, Boulevard, Rue, N° d'immeuble, Étage"
                                class="w-full text-xs px-3.5 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                            >
                        </div>

                        <!-- Special Notes -->
                        <div>
                            <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                {{ __('checkout.notes') }}
                            </label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="2" 
                                placeholder="Ex: Appelez-moi de préférence entre 14h et 18h..."
                                class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                            >{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Payment Method Block -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                        <h2 class="font-black text-slate-900 text-base flex items-center gap-2 pb-3 border-b border-slate-100">
                            <span>💳</span> {{ __('checkout.payment_method') }}
                        </h2>

                        <!-- Cash on Delivery Radio -->
                        <div class="p-4 rounded-xl border-2 border-souqly-orange bg-orange-50/40 flex items-start gap-4">
                            <input type="radio" checked class="w-4 h-4 text-souqly-orange focus:ring-souqly-orange border-slate-300 mt-1">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                    <span>💵</span> {{ __('checkout.cod_title') }}
                                </h4>
                                <p class="text-xs text-slate-600 mt-1">
                                    {{ __('checkout.cod_desc') }}
                                </p>
                            </div>
                        </div>

                        <!-- Coming soon online payment info -->
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-400 flex items-center justify-between">
                            <span>💳 Carte Bancaire CMI / Visa / Mastercard</span>
                            <span class="font-semibold text-slate-500 uppercase tracking-wider">Bientôt disponible</span>
                        </div>
                    </div>

                </div>

                <!-- Right: Order Summary & Place Order Button -->
                <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
                    <h2 class="font-black text-slate-900 text-base pb-3 border-b border-slate-100">
                        {{ __('checkout.order_summary') }} ({{ $cart->items_count }} articles)
                    </h2>

                    <!-- Items Preview -->
                    <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto space-y-3">
                        @foreach($cart->items as $item)
                            <div class="pt-3 first:pt-0 flex items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-xl shrink-0">
                                        @if($item->product->category->slug === 'luxury-watches') ⌚ @elseif($item->product->category->slug === 'electronics') 📱 @elseif($item->product->category->slug === 'fashion') 👜 @else 🏺 @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 line-clamp-1">{{ $item->product->name }}</h4>
                                        <div class="text-[11px] text-slate-500">Qté: {{ $item->quantity }} × {{ number_format($item->unit_price, 2) }} MAD</div>
                                    </div>
                                </div>
                                <span class="font-black text-slate-800 shrink-0">
                                    {{ number_format($item->subtotal, 2) }} MAD
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pricing breakdown -->
                    <div class="pt-4 border-t border-slate-100 space-y-2 text-xs">
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

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-base">
                            <span class="font-black text-slate-900">{{ __('cart.order_total') }}</span>
                            <div class="text-end">
                                <span class="font-black text-2xl text-souqly-orange">{{ number_format($cart->total, 2) }}</span>
                                <span class="font-bold text-xs text-souqly-navy">MAD</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full py-4 text-sm font-bold shadow-xl">
                        {{ __('checkout.place_order') }} &rarr;
                    </button>

                    <!-- Trust indicators -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-500 space-y-1">
                        <div>🔒 <strong>Achat 100% sécurisé :</strong> Aucune carte bancaire requise.</div>
                        <div>📦 <strong>Ouverture du colis :</strong> Vous pouvez vérifier le produit avant de payer.</div>
                    </div>
                </div>

            </div>

        </form>

    </div>
</div>
@endsection
