@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('account.my_account'))

@section('content')
<div class="py-12 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Account Header (Architectural Luxury Presentation) -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-10 mb-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-xs">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-[#0B1320] text-[#C5A059] font-serif text-2xl flex items-center justify-center shrink-0 border border-stone-800">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="font-serif text-2xl sm:text-3xl font-normal text-stone-900">{{ $user->name }}</h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 text-[9.5px] uppercase tracking-widest font-semibold border border-[#C5A059]/40 bg-[#FAF8F5] text-[#C5A059]">
                            MEMBRE SOUQLY
                        </span>
                    </div>
                    <p class="text-xs text-stone-400 mt-1 font-light tracking-wide">
                        {{ $user->email }} • {{ $user->phone ?? 'Pas de numéro enregistré' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('account.orders.index') }}" class="btn-primary text-[10px] uppercase tracking-[0.2em] px-5 py-3 font-semibold">
                    <span>Commandes ({{ $user->orders()->count() }})</span>
                </a>

                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-outline text-[10px] uppercase tracking-[0.18em] px-4 py-2.5 text-stone-400 hover:text-stone-900 hover:border-stone-900">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-medium flex items-center gap-3">
                <span class="text-emerald-600 text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Col: Default Address & Profile -->
            <div class="lg:col-span-5 space-y-8">
                <!-- Shipping Address Card -->
                <div class="bg-white border border-stone-200/80 p-7 shadow-xs">
                    <div class="flex items-baseline justify-between mb-5 pb-3 border-b border-stone-200/80">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900">
                            📍 {{ __('account.addresses') }}
                        </h3>
                        <span class="text-[9.5px] uppercase tracking-widest text-[#C5A059] font-medium">{{ __('account.default_badge') }}</span>
                    </div>

                    @if($defaultAddress)
                        <div class="p-4 bg-[#FAF8F5] border border-stone-200/70 space-y-2 text-xs tracking-wider">
                            <div class="font-serif text-base text-stone-900">{{ $defaultAddress->full_name }}</div>
                            <div class="text-stone-600 font-light">{{ $defaultAddress->address }}</div>
                            <div class="text-stone-800 font-medium">{{ $defaultAddress->city }} {{ $defaultAddress->postal_code ? '('.$defaultAddress->postal_code.')' : '' }}</div>
                            <div class="text-stone-500 font-mono text-[11px] pt-1">
                                📞 {{ $defaultAddress->phone }}
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-stone-400 font-light">Aucune adresse par défaut enregistrée.</p>
                    @endif
                </div>

                <!-- Update Profile Form -->
                <div class="bg-white border border-stone-200/80 p-7 shadow-xs">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900 mb-5 pb-3 border-b border-stone-200/80">
                        👤 {{ __('account.profile') }}
                    </h3>

                    <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                {{ __('auth.full_name') }}
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                required
                                class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider"
                            >
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-700 mb-1.5">
                                {{ __('auth.phone_number') }}
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                value="{{ old('phone', $user->phone) }}" 
                                required
                                class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider font-mono"
                            >
                        </div>

                        <button type="submit" class="btn-primary w-full py-3.5 text-[10px] uppercase tracking-[0.2em] font-semibold">
                            {{ __('account.save_changes') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Col: Orders History -->
            <div class="lg:col-span-7">
                <div class="bg-white border border-stone-200/80 p-7 shadow-xs min-h-[420px] flex flex-col justify-between">
                    <div>
                        <div class="flex items-baseline justify-between mb-6 pb-3 border-b border-stone-200/80">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900">
                                📦 {{ __('account.orders') }}
                            </h3>
                            @if($recentOrders->isNotEmpty())
                                <a href="{{ route('account.orders.index') }}" class="text-[10.5px] uppercase tracking-wider font-semibold text-stone-900 hover:text-[#C5A059] transition-colors">
                                    Voir tout ({{ $user->orders()->count() }}) &rarr;
                                </a>
                            @else
                                <a href="{{ route('shop') }}" class="text-[10.5px] uppercase tracking-wider font-semibold text-stone-900 hover:text-[#C5A059] transition-colors">
                                    {{ __('account.explore_products') }} &rarr;
                                </a>
                            @endif
                        </div>

                        @if($recentOrders->isNotEmpty())
                            <div class="space-y-3 mb-6">
                                @foreach($recentOrders as $order)
                                    <div class="p-4 bg-[#FAF8F5] border border-stone-200/70 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs tracking-wider">
                                        <div>
                                            <div class="flex items-center gap-2.5">
                                                <span class="font-mono font-semibold text-stone-900">{{ $order->order_number }}</span>
                                                <span class="inline-flex items-center px-2 py-0.5 text-[9.5px] uppercase tracking-widest font-semibold border {{ $order->status->badgeClasses() }}">
                                                    {{ $order->status->label(app()->getLocale()) }}
                                                </span>
                                            </div>
                                            <p class="text-stone-400 text-[11px] mt-1 font-light">
                                                {{ $order->created_at->format('d/m/Y H:i') }} • {{ $order->items_count }} pièce(s) • {{ $order->shipping_city }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-4 self-end sm:self-center">
                                            <span class="font-medium text-stone-900 text-sm">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                                            <a href="{{ route('account.orders.show', $order->order_number) }}" class="text-[10.5px] uppercase tracking-wider font-semibold text-stone-900 hover:text-[#C5A059]">
                                                Suivre &rarr;
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Orders Empty state -->
                            <div class="text-center py-16 px-4 space-y-3">
                                <div class="w-16 h-16 bg-[#FAF8F5] border border-stone-200 flex items-center justify-center mx-auto text-2xl text-stone-400">
                                    🛍️
                                </div>
                                <h4 class="font-serif text-xl text-stone-900 font-normal">
                                    {{ __('account.no_orders') }}
                                </h4>
                                <p class="text-xs text-stone-500 max-w-sm mx-auto font-light leading-relaxed">
                                    Commandez vos pièces d'exception en paiement à la livraison (Cash on Delivery) partout au Maroc.
                                </p>
                                <div class="pt-2">
                                    <a href="{{ route('shop') }}" class="btn-primary text-[10px] uppercase tracking-[0.2em] px-6 py-3 font-semibold">
                                        Explorer la collection
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Concierge Assistance box -->
                    <div class="p-4 bg-[#FAF8F5] border border-stone-200/80 flex items-center justify-between text-xs tracking-wider">
                        <div>
                            <span class="font-serif text-sm text-stone-900 font-normal block">Besoin d'un conseil personnalisé ?</span>
                            <span class="text-stone-500 font-light text-[11px]">Notre conciergerie WhatsApp vous assiste 7j/7.</span>
                        </div>
                        <a 
                            href="https://wa.me/212600000000?text=Bonjour%20Souqly%2C%20j%27ai%20une%20question%20concernant%20mon%20compte" 
                            target="_blank" 
                            class="text-[10.5px] uppercase tracking-widest font-semibold text-emerald-800 hover:text-emerald-950 transition-colors"
                        >
                            WhatsApp &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
