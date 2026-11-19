@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('account.my_account'))

@section('content')
<div class="py-10 bg-slate-50 min-h-[70vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Account Header -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-souqly-navy text-white text-2xl font-black flex items-center justify-center shrink-0 shadow-md">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-black text-slate-900">{{ $user->name }}</h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-souqly-orange">
                            Client SOUQLY
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $user->email }} • {{ $user->phone ?? 'Pas de numéro enregistré' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('account.orders.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-souqly-orange text-white text-xs font-bold rounded-xl hover:bg-souqly-orange-hover shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>Mes Commandes ({{ $user->orders()->count() }})</span>
                </a>

                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-outline text-xs px-4 py-2 text-rose-600 hover:border-rose-300 hover:bg-rose-50">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Col: Default Address & Profile -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Shipping Address Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>📍</span> {{ __('account.addresses') }}
                        </h3>
                        <span class="badge-currency">{{ __('account.default_badge') }}</span>
                    </div>

                    @if($defaultAddress)
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                            <div class="font-bold text-slate-800 text-sm">{{ $defaultAddress->full_name }}</div>
                            <div class="text-slate-600">{{ $defaultAddress->address }}</div>
                            <div class="text-slate-600 font-semibold">{{ $defaultAddress->city }} {{ $defaultAddress->postal_code ? '('.$defaultAddress->postal_code.')' : '' }}</div>
                            <div class="text-slate-600 flex items-center gap-1.5 pt-1">
                                <span>📞</span> <span>{{ $defaultAddress->phone }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-slate-500">Aucune adresse par défaut renseignée.</p>
                    @endif
                </div>

                <!-- Update Profile Form -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-sm mb-4 flex items-center gap-2">
                        <span>👤</span> {{ __('account.profile') }}
                    </h3>

                    <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                {{ __('auth.full_name') }}
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                required
                                class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                {{ __('auth.phone_number') }}
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                value="{{ old('phone', $user->phone) }}" 
                                required
                                class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                            >
                        </div>

                        <button type="submit" class="btn-primary text-xs w-full py-2.5">
                            {{ __('account.save_changes') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Col: Orders History -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm min-h-[400px] flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                                <span>📦</span> {{ __('account.orders') }}
                            </h3>
                            @if($recentOrders->isNotEmpty())
                                <a href="{{ route('account.orders.index') }}" class="text-xs font-bold text-souqly-orange hover:underline">
                                    Voir tout ({{ $user->orders()->count() }}) &rarr;
                                </a>
                            @else
                                <a href="{{ route('shop') }}" class="text-xs font-bold text-souqly-orange hover:underline">
                                    {{ __('account.explore_products') }} &rarr;
                                </a>
                            @endif
                        </div>

                        @if($recentOrders->isNotEmpty())
                            <div class="space-y-3 mb-6">
                                @foreach($recentOrders as $order)
                                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono font-bold text-slate-900">{{ $order->order_number }}</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $order->status->badgeClasses() }}">
                                                    {{ $order->status->label(app()->getLocale()) }}
                                                </span>
                                            </div>
                                            <p class="text-slate-500 text-[11px] mt-0.5">
                                                {{ $order->created_at->format('d/m/Y H:i') }} • {{ $order->items_count }} article(s) • {{ $order->shipping_city }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-3 self-end sm:self-center">
                                            <span class="font-bold text-slate-900 text-sm">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                                            <a href="{{ route('account.orders.show', $order->order_number) }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-800 font-bold hover:bg-slate-100 transition">
                                                Suivre &rarr;
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Orders Empty state -->
                            <div class="text-center py-16 px-4">
                                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-3xl mb-4 text-slate-400">
                                    🛍️
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm">
                                    {{ __('account.no_orders') }}
                                </h4>
                                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">
                                    Commandez vos articles préférés en paiement à la livraison (Cash on Delivery) partout au Maroc.
                                </p>
                                <a href="{{ route('shop') }}" class="btn-primary text-xs px-6 py-3">
                                    Découvrir le catalogue SOUQLY
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Assistance box -->
                    <div class="p-4 rounded-xl bg-orange-50/60 border border-orange-100 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">💬</span>
                            <div>
                                <span class="font-bold text-slate-900 block">Besoin d'aide pour une commande ?</span>
                                <span class="text-slate-600">Notre équipe WhatsApp est à votre disposition.</span>
                            </div>
                        </div>
                        <a 
                            href="https://wa.me/212600000000?text=Bonjour%20Souqly%2C%20j%27ai%20une%20question%20concernant%20mon%20compte" 
                            target="_blank" 
                            class="font-bold text-emerald-700 bg-emerald-100 hover:bg-emerald-200 px-3 py-1.5 rounded-lg transition"
                        >
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
