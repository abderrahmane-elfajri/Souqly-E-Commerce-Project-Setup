<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SOUQLY — Administration')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans min-h-screen flex flex-col md:flex-row">

    <!-- Admin Sidebar (Dark Navy #101D32) -->
    <aside class="w-full md:w-64 bg-souqly-navy text-white flex-shrink-0 flex flex-col justify-between p-6 shadow-xl">
        <div>
            <!-- Admin Logo -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-8 group">
                <div class="w-9 h-9 rounded-xl bg-souqly-orange flex items-center justify-center font-black text-white text-xl shadow-md group-hover:scale-105 transition-transform">
                    S
                </div>
                <div>
                    <span class="text-xl font-black tracking-wider text-white">SOUQLY<span class="text-souqly-orange">.</span></span>
                    <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-semibold">Admin Suite</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="space-y-1.5 text-xs font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-souqly-navy-light text-white border-s-4 border-souqly-orange font-bold' : 'text-slate-300 hover:text-white hover:bg-souqly-navy-light/50' }}">
                    <svg class="w-4 h-4 text-souqly-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Vue d'ensemble</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-souqly-navy-light text-white border-s-4 border-souqly-orange font-bold' : 'text-slate-300 hover:text-white hover:bg-souqly-navy-light/50' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Commandes</span>
                    </div>
                    @php
                        $pendingOrdersCount = \App\Models\Order::where('status', \App\Enums\OrderStatus::PENDING)->count();
                    @endphp
                    @if($pendingOrdersCount > 0)
                        <span class="px-2 py-0.5 rounded-full bg-souqly-orange text-white text-[10px] font-bold">
                            {{ $pendingOrdersCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.products.*') ? 'bg-souqly-navy-light text-white border-s-4 border-souqly-orange font-bold' : 'text-slate-300 hover:text-white hover:bg-souqly-navy-light/50' }}">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Produits</span>
                </a>

                <a href="{{ route('admin.inventory.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.inventory.*') ? 'bg-souqly-navy-light text-white border-s-4 border-souqly-orange font-bold' : 'text-slate-300 hover:text-white hover:bg-souqly-navy-light/50' }}">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Stock & Mouvements</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-souqly-navy-light text-white border-s-4 border-souqly-orange font-bold' : 'text-slate-300 hover:text-white hover:bg-souqly-navy-light/50' }}">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Catégories</span>
                </a>

                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.customers.*') ? 'bg-souqly-navy-light text-white border-s-4 border-souqly-orange font-bold' : 'text-slate-300 hover:text-white hover:bg-souqly-navy-light/50' }}">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Clients</span>
                </a>
            </nav>
        </div>

        <!-- Admin Profile bottom bar -->
        <div class="pt-6 border-t border-slate-800 space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-souqly-orange flex items-center justify-center font-bold text-white text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-slate-400 font-semibold uppercase">{{ auth()->user()->role->label() }}</div>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs pt-2">
                <a href="/" class="text-slate-400 hover:text-white transition flex items-center gap-1">
                    <span>&larr;</span> <span>Voir la boutique</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-rose-400 hover:text-rose-300 font-semibold">
                        Quitter
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Top Navigation Bar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-black text-slate-900 font-heading">
                    @yield('header_title', 'Panneau d\'administration')
                </h2>
            </div>

            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Marché Maroc (MAD د.م.)</span>
                </span>
                <a href="/" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition">
                    Ouvrir Storefront &rarr;
                </a>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Flash feedback -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-white border-t border-slate-200 px-6 py-4 text-center text-xs text-slate-500">
            SOUQLY E-Commerce Platform &copy; {{ date('Y') }} • Conçu pour le marché marocain • Tous droits réservés.
        </footer>
    </div>

</body>
</html>
