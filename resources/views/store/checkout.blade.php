@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('checkout.checkout'))

@section('content')
<div class="py-12 bg-[#FAF8F5] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 pb-6 border-b border-stone-200/80">
            <span class="text-[10px] uppercase tracking-[0.24em] font-medium text-stone-400 block mb-1">FINALISATION SÉCURISÉE</span>
            <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal">
                {{ __('checkout.checkout') }}
            </h1>
        </div>

        @if(session('error'))
            <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-900 text-xs font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-900 text-xs space-y-1">
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Left: Customer Details & Moroccan Address -->
                <div class="lg:col-span-7 space-y-8">
                    
                    <!-- Contact and Address Block -->
                    <div class="bg-white border border-stone-200/80 p-8 sm:p-10 space-y-6 shadow-xs">
                        <div class="flex items-baseline justify-between pb-4 border-b border-stone-200/80">
                            <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900">
                                📍 {{ __('checkout.contact_shipping') }}
                            </h2>
                            @guest
                                <a href="{{ route('login') }}" class="text-[10.5px] uppercase tracking-wider font-semibold text-stone-500 hover:text-stone-900 transition-colors">
                                    Déjà client ? Se connecter
                                </a>
                            @endguest
                        </div>

                        <!-- Name & Email (2 columns) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                    {{ __('checkout.full_name') }} *
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    value="{{ old('name', $defaultAddress?->full_name ?? $user?->name) }}" 
                                    required 
                                    placeholder="Yassine El Amrani"
                                    class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider"
                                >
                            </div>

                            <div>
                                <label for="email" class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                    {{ __('checkout.email') }} *
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    value="{{ old('email', $user?->email) }}" 
                                    required 
                                    placeholder="yassine@example.com"
                                    class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider"
                                >
                            </div>
                        </div>

                        <!-- Phone & City (2 columns) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="phone" class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                    {{ __('checkout.phone') }} *
                                </label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    id="phone" 
                                    value="{{ old('phone', $defaultAddress?->phone ?? $user?->phone) }}" 
                                    required 
                                    placeholder="0661234567"
                                    class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider"
                                >
                                <span class="text-[10px] text-stone-400 mt-1 block font-light">Le porteur vous contactera avant la remise.</span>
                            </div>

                            <div>
                                <label for="city" class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                    {{ __('checkout.city') }} *
                                </label>
                                <select 
                                    name="city" 
                                    id="city" 
                                    required
                                    class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider font-medium"
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
                            <label for="address" class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                {{ __('checkout.address') }} *
                            </label>
                            <input 
                                type="text" 
                                name="address" 
                                id="address" 
                                value="{{ old('address', $defaultAddress?->address) }}" 
                                required 
                                placeholder="Boulevard, Rue, N° d'immeuble, Résidence, Étage"
                                class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider"
                            >
                        </div>

                        <!-- Special Notes -->
                        <div>
                            <label for="notes" class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                {{ __('checkout.notes') }}
                            </label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="2" 
                                placeholder="Instructions particulières pour la livraison..."
                                class="w-full text-xs px-3.5 py-2.5 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider"
                            >{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Payment Method Block -->
                    <div class="bg-white border border-stone-200/80 p-8 sm:p-10 space-y-5 shadow-xs">
                        <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900 pb-4 border-b border-stone-200/80">
                            💳 {{ __('checkout.payment_method') }}
                        </h2>

                        <!-- Cash on Delivery Selection Box -->
                        <div class="p-5 border border-stone-900 bg-[#FAF8F5] flex items-start gap-4">
                            <span class="text-xl">💵</span>
                            <div>
                                <h4 class="font-serif text-base text-stone-900 font-normal">
                                    {{ __('checkout.cod_title') }}
                                </h4>
                                <p class="text-xs text-stone-600 mt-1 font-light leading-relaxed">
                                    {{ __('checkout.cod_desc') }}
                                </p>
                            </div>
                        </div>

                        <!-- Coming soon online payment info -->
                        <div class="p-3.5 bg-[#FAF8F5] border border-stone-200/80 text-[11px] text-stone-400 flex items-center justify-between font-light">
                            <span>💳 Carte Bancaire CMI / Visa / Mastercard</span>
                            <span class="font-medium text-stone-500 uppercase tracking-widest text-[9.5px]">Bientôt disponible</span>
                        </div>
                    </div>

                </div>

                <!-- Right: Order Summary & Place Order Button -->
                <div class="lg:col-span-5 bg-white border border-stone-200/80 p-8 sm:p-10 space-y-6 shadow-xs">
                    <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900 pb-4 border-b border-stone-200/80">
                        {{ __('checkout.order_summary') }} ({{ $cart->items_count }} pièces)
                    </h2>

                    <!-- Items Preview -->
                    <div class="divide-y divide-stone-100 max-h-80 overflow-y-auto space-y-3">
                        @foreach($cart->items as $item)
                            <div class="pt-3 first:pt-0 flex items-center justify-between gap-3 text-xs tracking-wider">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-[#FAF8F5] border border-stone-200/70 shrink-0 overflow-hidden">
                                        <img 
                                            src="{{ $item->product->primary_image_url }}" 
                                            alt="{{ $item->product->name }}" 
                                            class="w-full h-full object-cover object-center"
                                            width="48"
                                            height="48"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div>
                                        <h4 class="font-serif text-sm text-stone-900 line-clamp-1 font-normal">{{ $item->product->name }}</h4>
                                        <div class="text-[10.5px] text-stone-400">Qté: {{ $item->quantity }} × {{ number_format($item->unit_price, 2) }} MAD</div>
                                    </div>
                                </div>
                                <span class="font-medium text-stone-900 shrink-0">
                                    {{ number_format($item->subtotal, 2) }} MAD
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pricing breakdown -->
                    <div class="pt-4 border-t border-stone-200/80 space-y-3 text-xs tracking-wider">
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

                        <div class="pt-4 border-t border-stone-200/80 flex items-baseline justify-between">
                            <span class="font-semibold uppercase tracking-wider text-stone-900 text-[11px]">{{ __('cart.order_total') }}</span>
                            <div class="text-end">
                                <span class="font-serif text-2xl font-normal text-stone-900">{{ number_format($cart->total, 2) }}</span>
                                <span class="font-sans text-xs text-stone-500 ms-1">MAD</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full py-4 text-[11px] uppercase tracking-[0.2em] font-semibold text-center block transition">
                        {{ __('checkout.place_order') }} &rarr;
                    </button>

                    <!-- Trust indicators -->
                    <div class="p-4 bg-[#FAF8F5] border border-stone-200/70 text-[11px] text-stone-500 space-y-1.5 font-light">
                        <div>🔒 <strong>Achat 100% sécurisé :</strong> Aucune carte bancaire requise en ligne.</div>
                        <div>📦 <strong>Ouverture du colis :</strong> Vérifiez vos pièces avant règlement en espèces.</div>
                    </div>
                </div>

            </div>

        </form>

    </div>
</div>
@endsection
