<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SOUQLY — Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans min-h-screen flex flex-col md:flex-row">

    <!-- Admin Sidebar (Dark Navy #101D32) -->
    <aside class="w-full md:w-64 bg-souqly-navy text-white flex-shrink-0 flex flex-col justify-between p-6">
        <div>
            <!-- Admin Logo -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-9 h-9 rounded-xl bg-souqly-orange flex items-center justify-center font-black text-white text-xl shadow-md">
                    S
                </div>
                <div>
                    <span class="text-xl font-black tracking-wider text-white">SOUQLY<span class="text-souqly-orange">.</span></span>
                    <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-semibold">Admin Suite</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1.5 text-xs font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item active">
                    <svg class="w-4 h-4 text-souqly-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Vue d'ensemble</span>
                </a>

                <a href="#" class="admin-nav-item opacity-70 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Catalogue & Produits</span>
                </a>

                <a href="#" class="admin-nav-item opacity-70 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Catégories</span>
                </a>

                <a href="#" class="admin-nav-item opacity-70 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Commandes & Expéditions</span>
                </a>

                <a href="#" class="admin-nav-item opacity-70 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Clients & Comptes</span>
                </a>

                <a href="#" class="admin-nav-item opacity-70 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Coupons & Remises</span>
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
                <a href="/" class="text-slate-400 hover:text-white transition">
                    &larr; Boutique
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-rose-400 hover:text-rose-300">
                        Quitter
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Admin Content Area -->
    <div class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top bar -->
        <header class="bg-white border-b border-slate-200 h-16 px-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <h2 class="text-base font-bold text-slate-900">Tableau de Bord Administratif</h2>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                    En ligne
                </span>
            </div>

            <div class="flex items-center gap-4 text-xs">
                <span class="text-slate-500">Marché : <strong class="text-slate-800">Maroc (MAD)</strong></span>
                <div class="h-4 w-px bg-slate-200"></div>
                <a href="{{ route('locale.switch', app()->getLocale() === 'fr' ? 'ar' : 'fr') }}" class="font-bold text-souqly-navy hover:text-souqly-orange">
                    {{ app()->getLocale() === 'fr' ? 'العربية (RTL)' : 'Français (LTR)' }}
                </a>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-6 md:p-8 space-y-8 flex-1">
            
            <!-- Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Customers -->
                <div class="admin-metric-card">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Clients Inscrits</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-souqly-navy flex items-center justify-center font-bold">
                            👥
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-900">{{ $metrics['total_customers'] }}</div>
                    <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-block">Comptes actifs</span>
                </div>

                <!-- Card 2: Revenue -->
                <div class="admin-metric-card">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Chiffre d'Affaires</span>
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-souqly-orange flex items-center justify-center font-bold">
                            💰
                        </div>
                    </div>
                    <div class="text-2xl font-black text-souqly-orange">{{ number_format($metrics['total_revenue_mad'], 2) }} MAD</div>
                    <span class="text-[11px] text-slate-400 mt-1 inline-block">Paiements COD & Directs</span>
                </div>

                <!-- Card 3: Orders -->
                <div class="admin-metric-card">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Commandes</span>
                        <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center font-bold">
                            📦
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-900">{{ $metrics['total_orders'] }}</div>
                    <span class="text-[11px] text-slate-400 mt-1 inline-block">Module Phase 5</span>
                </div>

                <!-- Card 4: Products -->
                <div class="admin-metric-card">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Articles en Vente</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                            ⌚
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-900">{{ $metrics['total_products'] }}</div>
                    <span class="text-[11px] text-slate-400 mt-1 inline-block">Prêt pour Phase 3</span>
                </div>
            </div>

            <!-- Recent Users / Accounts Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-bold text-slate-900 text-sm">Derniers Utilisateurs & Rôles</h3>
                    <span class="text-xs text-slate-500">{{ $recentUsers->count() }} comptes enregistrés</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                                <tr>
                                    <td class="font-bold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '—' }}</td>
                                    <td>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold 
                                            {{ $user->role->value === 'super_admin' ? 'bg-purple-100 text-purple-800' : ($user->role->value === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800') }}">
                                            {{ $user->role->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="text-slate-500 text-xs">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
