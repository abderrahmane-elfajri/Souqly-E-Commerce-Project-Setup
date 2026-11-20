<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SOUQLY — ' . __('common.tagline', ['default' => 'Smart Commerce Platform | Everything you need. One place.']))</title>
    <meta name="description" content="@yield('meta_description', 'Souqly — Première plateforme e-commerce multi-catégories au Maroc. Montres, Électronique, Mode, Maison. Paiement à la livraison dans tout le Maroc.')">

    <!-- OpenGraph & Social Cards -->
    <meta property="og:site_name" content="SOUQLY">
    <meta property="og:title" content="@yield('title', 'SOUQLY — Smart Commerce Platform')">
    <meta property="og:description" content="@yield('meta_description', 'Souqly — Première plateforme e-commerce multi-catégories au Maroc.')">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_MA' : (app()->getLocale() === 'en' ? 'en_US' : 'fr_MA') }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- JSON-LD Moroccan Organization / LocalBusiness Schema (Agence Web4U Standard) -->
    <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'OnlineStore',
      'name' => 'SOUQLY',
      'alternateName' => 'سوقلي',
      'url' => url('/'),
      'description' => 'Plateforme e-commerce multi-catégories au Maroc avec paiement à la livraison.',
      'telephone' => '+212522000000',
      'priceRange' => 'MAD',
      'currenciesAccepted' => 'MAD',
      'paymentAccepted' => 'Cash on Delivery',
      'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => "Boulevard d'Anfa",
        'addressLocality' => 'Casablanca',
        'postalCode' => '20050',
        'addressCountry' => 'MA',
      ],
      'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => '33.589886',
        'longitude' => '-7.603869',
      ],
      'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => url('/shop') . '?q={search_term_string}',
        'query-input' => 'required name=search_term_string',
      ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Fonts: Cormorant Garamond, Playfair Display, Amiri (Serif Luxury) & Plus Jakarta Sans, Cairo (Sans Architecture) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Cairo:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Critical Inline Styles to prevent FOUC -->
    <style>
        svg { display: inline-block; vertical-align: middle; max-width: 100%; height: auto; }
        svg.w-3\.5 { width: 0.875rem !important; height: 0.875rem !important; }
        svg.w-4 { width: 1rem !important; height: 1rem !important; }
        svg.w-5 { width: 1.25rem !important; height: 1.25rem !important; }
        svg.w-6 { width: 1.5rem !important; height: 1.5rem !important; }
        svg.w-8 { width: 2rem !important; height: 2rem !important; }
    </style>

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#FAF8F5] text-stone-900 antialiased min-h-screen flex flex-col font-sans selection:bg-stone-900 selection:text-white">

    <!-- Top Announcement Bar (Luxury Minimalist Horology & Delivery Standard) -->
    <div class="bg-[#0B1320] text-stone-300 text-[11px] uppercase tracking-[0.18em] py-2.5 px-4 border-b border-stone-800/80">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2.5">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#C5A059] animate-pulse"></span>
                <span class="font-medium text-stone-200">
                    @if(app()->getLocale() === 'ar')
                        توصيل خاص وفوري لكافة المدن المغربية (24-48 ساعة) • الدفع عند الاستلام والمعاينة
                    @elseif(app()->getLocale() === 'en')
                        Express White-Glove Delivery Across Morocco (24-48h) • Cash on Delivery & Inspection
                    @else
                        Livraison Express Partout au Maroc (24-48h) • Paiement & Contrôle à la Livraison
                    @endif
                </span>
            </div>
            <div class="flex items-center gap-5 text-stone-400">
                <div class="flex items-center gap-1.5 font-medium text-[#C5A059] tracking-widest">
                    <span>MAD (د.م.)</span>
                </div>
                <div class="h-3 w-px bg-stone-800"></div>
                <!-- Language Switcher -->
                <div class="flex items-center gap-2.5 text-[10px] tracking-widest uppercase">
                    <a href="{{ route('locale.switch', 'fr') }}" class="{{ app()->getLocale() === 'fr' ? 'text-white font-bold border-b border-[#C5A059] pb-0.5' : 'hover:text-stone-200 transition-colors' }}">FR</a>
                    <span class="text-stone-700">•</span>
                    <a href="{{ route('locale.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'text-white font-bold border-b border-[#C5A059] pb-0.5' : 'hover:text-stone-200 transition-colors' }}">العربية</a>
                    <span class="text-stone-700">•</span>
                    <a href="{{ route('locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'text-white font-bold border-b border-[#C5A059] pb-0.5' : 'hover:text-stone-200 transition-colors' }}">EN</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header (Quiet Luxury Digital Flagship) -->
    <header class="bg-[#0B1320]/95 backdrop-blur-md text-white sticky top-0 z-40 border-b border-stone-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 sm:h-22 gap-4">
                
                <!-- Logo: Architectural Wordmark -->
                <div class="flex items-center gap-4">
                    <a href="/" class="flex flex-col group py-1">
                        <span class="font-serif text-2xl sm:text-3xl tracking-[0.26em] text-white font-normal uppercase leading-none group-hover:text-stone-200 transition-colors">
                            SOUQLY<span class="text-[#C5A059]">.</span>
                        </span>
                        <span class="text-[8.5px] tracking-[0.35em] uppercase text-stone-400 font-sans mt-1">
                            MAISON DU COMMERCE • MAROC
                        </span>
                    </a>
                </div>

                <!-- Minimalist Search Input -->
                <div class="hidden md:flex flex-1 max-w-lg mx-6">
                    <form action="{{ route('shop') }}" method="GET" class="w-full relative">
                        <input 
                            type="search" 
                            name="q" 
                            value="{{ request('q', '') }}"
                            placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث عن القطع النادرة، الساعات، الإبداعات...' : (app()->getLocale() === 'en' ? 'Search timepieces, electronics, fine crafts...' : 'Rechercher un garde-temps, produit, collection...') }}" 
                            class="w-full bg-[#121B2B]/80 text-stone-100 placeholder-stone-500 text-xs tracking-wider py-2.5 px-4 ps-10 pe-20 focus:outline-none focus:border-stone-500 border border-stone-800/90 transition-all font-sans"
                        >
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-stone-500">
                            <svg class="w-3.5 h-3.5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button type="submit" class="absolute inset-y-1 end-1 px-3 text-[10px] tracking-widest uppercase font-semibold text-stone-400 hover:text-white transition flex items-center">
                            {{ app()->getLocale() === 'ar' ? 'بحث' : (app()->getLocale() === 'en' ? 'Search' : 'Filtrer') }}
                        </button>
                    </form>
                </div>

                <!-- Right Actions: Concierge WhatsApp + Account + Wishlist + Cart -->
                <div class="flex items-center gap-3 sm:gap-5">
                    <!-- WhatsApp Moroccan Concierge CTA -->
                    <a 
                        href="https://wa.me/212600000000?text=Bonjour%20Souqly%2C%20je%20souhaite%20consulter%20un%20conseiller%20de%20vente" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="hidden lg:inline-flex items-center gap-2 border border-emerald-500/30 hover:border-emerald-400/80 bg-emerald-950/20 text-emerald-300 text-[10.5px] uppercase tracking-[0.16em] font-medium px-3.5 py-2 transition duration-300"
                        title="Conciergerie WhatsApp Privée"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Conciergerie WhatsApp</span>
                    </a>

                    <!-- Auth State: Guest or Logged In User -->
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 border border-amber-600/50 bg-amber-950/20 hover:bg-amber-950/40 text-[#C5A059] text-[10px] tracking-widest uppercase font-semibold transition">
                                <span>Administration</span>
                            </a>
                        @endif

                        <a href="{{ route('account.dashboard') }}" class="flex items-center gap-2 text-stone-300 hover:text-white py-1 transition" title="Espace Personnel">
                            <svg class="w-4 h-4 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden sm:inline text-xs tracking-wider">{{ auth()->user()->name }}</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-stone-500 hover:text-stone-300 p-1 transition" title="Déconnexion">
                                <svg class="w-3.5 h-3.5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    @else
                        <!-- Account link for Guests -->
                        <a href="{{ route('login') }}" class="flex items-center gap-1.5 text-stone-300 hover:text-white py-1 transition text-xs tracking-widest uppercase font-medium">
                            <svg class="w-4 h-4 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden sm:inline text-[11px]">{{ app()->getLocale() === 'ar' ? 'دخول' : (app()->getLocale() === 'en' ? 'Sign In' : 'Connexion') }}</span>
                        </a>
                    @endauth

                    <!-- Cart (Minimalist Architectural Box) -->
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-2.5 border border-stone-800 hover:border-stone-500 bg-stone-900/60 text-stone-100 px-3.5 py-2 text-xs tracking-wider transition">
                        <svg class="w-4 h-4 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="font-medium">{{ number_format($headerCart?->subtotal ?? 0, 0) }} MAD</span>
                        @if(($headerCart?->items_count ?? 0) > 0)
                            <span class="bg-[#C5A059] text-[#0B1320] text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                                {{ $headerCart->items_count }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Curated Categories Navigation Strip -->
        <nav class="bg-[#070D17] border-t border-stone-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between text-[11px] uppercase tracking-[0.2em] py-3 overflow-x-auto whitespace-nowrap scrollbar-none font-medium">
                    <div class="flex items-center gap-7">
                        <a href="{{ route('shop') }}" class="text-white hover:text-[#C5A059] transition-colors flex items-center gap-1.5 font-semibold">
                            <span>{{ app()->getLocale() === 'ar' ? 'كافة المجموعات' : (app()->getLocale() === 'en' ? 'All Collections' : 'Toutes les collections') }}</span>
                        </a>
                        <a href="/shop?category=luxury-watches" class="text-stone-400 hover:text-white transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'ساعات فاخرة' : (app()->getLocale() === 'en' ? 'Haute Horlogerie' : 'Horlogerie d\'Exception') }}
                        </a>
                        <a href="/shop?category=electronics" class="text-stone-400 hover:text-white transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'تكنولوجيا دقيقة' : (app()->getLocale() === 'en' ? 'Fine Technology' : 'Haute Technologie') }}
                        </a>
                        <a href="/shop?category=fashion" class="text-stone-400 hover:text-white transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'جلد وأزياء' : (app()->getLocale() === 'en' ? 'Leather & Apparel' : 'Maroquinerie & Style') }}
                        </a>
                        <a href="/shop?category=home" class="text-stone-400 hover:text-white transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'فن العيش والتصميم' : (app()->getLocale() === 'en' ? 'Living & Design' : 'Art de la Table') }}
                        </a>
                        <a href="{{ route('track') }}" class="text-[#C5A059] hover:text-amber-300 transition-colors flex items-center gap-1.5 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#C5A059]"></span>
                            <span>{{ app()->getLocale() === 'ar' ? 'تتبع شحنتك' : (app()->getLocale() === 'en' ? 'Track Parcel' : 'Suivi de Commande') }}</span>
                        </a>
                    </div>
                    <div class="hidden md:flex items-center gap-3 text-stone-500 text-[10px] tracking-widest uppercase">
                        <span>{{ app()->getLocale() === 'ar' ? 'الدار البيضاء • استشارة خاصة' : 'Atelier Casablanca • Tél : +212 522 00 00 00' }}</span>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content Slot -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Moroccan Trust & Guarantees Strip (Quiet Luxury Standards) -->
    <section class="border-t border-b border-stone-200/80 bg-[#FAF8F5] py-14 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Trust 1 -->
                <div class="flex items-start gap-4 p-5 bg-white border border-stone-200/70 hover:border-stone-400/80 transition-all duration-300">
                    <div class="w-10 h-10 rounded-full bg-[#FAF8F5] border border-stone-200/80 flex items-center justify-center text-[#C5A059] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    </div>
                    <div>
                        <h4 class="font-serif font-medium text-stone-900 text-sm tracking-wide">
                            {{ app()->getLocale() === 'ar' ? 'توصيل خاص وسريع' : (app()->getLocale() === 'en' ? 'Express White-Glove Delivery' : 'Livraison Express par Porteur') }}
                        </h4>
                        <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                            {{ app()->getLocale() === 'ar' ? 'كازا، الرباط، طنجة، مراكش في 24-48 ساعة' : 'Casablanca, Rabat, Tanger, Marrakech en 24/48h' }}
                        </p>
                    </div>
                </div>

                <!-- Trust 2 -->
                <div class="flex items-start gap-4 p-5 bg-white border border-stone-200/70 hover:border-stone-400/80 transition-all duration-300">
                    <div class="w-10 h-10 rounded-full bg-[#FAF8F5] border border-stone-200/80 flex items-center justify-center text-[#C5A059] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-serif font-medium text-stone-900 text-sm tracking-wide">
                            {{ app()->getLocale() === 'ar' ? 'الدفع عند الاستلام (COD)' : (app()->getLocale() === 'en' ? 'Cash on Delivery (COD)' : 'Paiement à la Livraison (COD)') }}
                        </h4>
                        <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                            {{ app()->getLocale() === 'ar' ? 'افحص منتجك قبل الدفع 100% مضمون' : 'Vérifiez votre colis avant de régler le livreur' }}
                        </p>
                    </div>
                </div>

                <!-- Trust 3 -->
                <div class="flex items-start gap-4 p-5 bg-white border border-stone-200/70 hover:border-stone-400/80 transition-all duration-300">
                    <div class="w-10 h-10 rounded-full bg-[#FAF8F5] border border-stone-200/80 flex items-center justify-center text-[#C5A059] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-serif font-medium text-stone-900 text-sm tracking-wide">
                            {{ app()->getLocale() === 'ar' ? 'ضمان الأصالة 100%' : (app()->getLocale() === 'en' ? 'Authenticity & Guarantee' : 'Authenticité & Garantie 7 Jours') }}
                        </h4>
                        <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                            {{ app()->getLocale() === 'ar' ? 'إرجاع أو استبدال بدون تعقيدات' : 'Échange ou remboursement sans tracas' }}
                        </p>
                    </div>
                </div>

                <!-- Trust 4 -->
                <div class="flex items-start gap-4 p-5 bg-white border border-stone-200/70 hover:border-stone-400/80 transition-all duration-300">
                    <div class="w-10 h-10 rounded-full bg-[#FAF8F5] border border-stone-200/80 flex items-center justify-center text-[#C5A059] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-serif font-medium text-stone-900 text-sm tracking-wide">
                            {{ app()->getLocale() === 'ar' ? 'خدمة الزبناء الخاصة 7/7' : (app()->getLocale() === 'en' ? 'Private Concierge 7/7' : 'Conciergerie Privée Dédiée') }}
                        </h4>
                        <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                            {{ app()->getLocale() === 'ar' ? 'عبر واتساب أو الهاتف بالدارجة والفرنسية' : 'Disponible via WhatsApp et téléphone' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (Luxury Minimalist Editorial) -->
    <footer class="bg-[#0B1320] text-stone-400 pt-16 pb-12 border-t border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-14">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <a href="/" class="flex flex-col">
                        <span class="font-serif text-2xl tracking-[0.28em] text-white font-normal uppercase leading-none">
                            SOUQLY<span class="text-[#C5A059]">.</span>
                        </span>
                        <span class="text-[9px] tracking-[0.35em] uppercase text-stone-400 font-sans mt-1.5">
                            ATELIER CASABLANCA
                        </span>
                    </a>
                    <p class="text-xs leading-relaxed text-stone-400 font-light">
                        {{ app()->getLocale() === 'ar' 
                            ? 'سوقلي — منصة التجارة الذكية في المغرب. نوفر لك أفضل المنتجات بأسعار مناسبة مع خدمة توصيل سريعة ودفع آمن عند الاستلام.'
                            : 'Maison de commerce et curation sélective au Maroc. Horlogerie d\'exception, haute technologie, maroquinerie et art de vivre. L\'alliance du raffinement et de la rigueur logistique.' }}
                    </p>
                    <div class="flex items-center gap-3 text-stone-300 text-xs tracking-wider pt-2">
                        <span class="text-stone-500 uppercase text-[10px] tracking-widest">Devise Officielle :</span>
                        <span class="font-medium text-[#C5A059]">MAD (درهم مغربي)</span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="text-stone-200 text-xs font-semibold uppercase tracking-[0.22em] mb-4">
                        {{ app()->getLocale() === 'ar' ? 'المجموعات' : 'Collections' }}
                    </h4>
                    <ul class="space-y-2.5 text-xs text-stone-400 font-light tracking-wide">
                        <li><a href="/shop" class="hover:text-white transition-colors">Toutes les pièces</a></li>
                        <li><a href="/shop?category=luxury-watches" class="hover:text-white transition-colors">Haute Horlogerie</a></li>
                        <li><a href="/shop?category=electronics" class="hover:text-white transition-colors">Haute Technologie</a></li>
                        <li><a href="/shop?category=fashion" class="hover:text-white transition-colors">Maroquinerie d'Atelier</a></li>
                        <li><a href="/shop?category=home" class="hover:text-white transition-colors">Art de la Table Contemporain</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Service & Concierge -->
                <div>
                    <h4 class="text-stone-200 text-xs font-semibold uppercase tracking-[0.22em] mb-4">
                        {{ app()->getLocale() === 'ar' ? 'خدمة الزبناء والطلب' : 'Conciergerie & Suivi' }}
                    </h4>
                    <ul class="space-y-2.5 text-xs text-stone-400 font-light tracking-wide">
                        <li>
                            <a href="{{ route('track') }}" class="text-[#C5A059] hover:text-amber-300 transition-colors flex items-center gap-2 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'تتبع مسار شحنتك' : 'Suivre mon colis en direct' }}</span>
                            </a>
                        </li>
                        <li><a href="https://wa.me/212600000000" target="_blank" class="hover:text-white transition-colors">WhatsApp Concierge Direct</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">{{ __('common.faq') }}</a></li>
                        <li><a href="{{ route('shipping-policy') }}" class="hover:text-white transition-colors">{{ __('common.shipping_policy') }}</a></li>
                        <li><a href="{{ route('return-policy') }}" class="hover:text-white transition-colors">{{ __('common.return_policy') }}</a></li>
                    </ul>
                </div>

                <!-- Col 4: Payment & Security in Morocco -->
                <div class="space-y-4">
                    <h4 class="text-stone-200 text-xs font-semibold uppercase tracking-[0.22em] mb-4">
                        {{ app()->getLocale() === 'ar' ? 'طرق الدفع والأمان' : 'Règlement & Sécurité' }}
                    </h4>
                    <div class="flex flex-col gap-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#141F32] text-stone-200 text-[11px] font-medium border border-stone-800">
                            <svg class="w-3.5 h-3.5 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Paiement à la livraison (COD)</span>
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#141F32] text-stone-400 text-[11px] border border-stone-800">
                            <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span>CMI / Carte Bancaire (Bientôt)</span>
                        </span>
                    </div>
                    <p class="text-[11px] text-stone-500 leading-relaxed pt-2">
                        Atelier Central : Boulevard d'Anfa, Casablanca, Maroc.<br>
                        RC : 542190 • Patente : 4983210 • ICE : 002938475000082
                    </p>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-stone-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-stone-500 gap-4">
                <p>&copy; {{ date('Y') }} SOUQLY Maroc. Maison d'Excellence & Smart Commerce. Tous droits réservés.</p>
                <div class="flex items-center gap-6 text-[11px] uppercase tracking-wider">
                    <a href="{{ route('privacy') }}" class="hover:text-stone-300 transition-colors">{{ __('common.privacy') }}</a>
                    <a href="{{ route('terms') }}" class="hover:text-stone-300 transition-colors">{{ __('common.terms') }}</a>
                    <a href="{{ route('admin.dashboard') }}" class="text-stone-400 hover:text-white transition-colors">Espace Privé Admin</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Luxury WhatsApp Concierge Widget -->
    @php
        $floatingWaMessage = rawurlencode(__('common.whatsapp_floating_msg'));
    @endphp
    <div class="fixed bottom-6 end-6 z-50">
        <a 
            href="https://wa.me/212600000000?text={{ $floatingWaMessage }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="{{ __('common.whatsapp_concierge') }}"
            class="group flex items-center gap-3 bg-[#0B1320] text-white border border-[#C5A059]/40 hover:border-[#C5A059] p-3 sm:px-4 sm:py-3 shadow-2xl transition-all duration-300 hover:scale-105"
        >
            <div class="relative flex items-center justify-center">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 absolute -top-1 -end-1 animate-ping"></span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 absolute -top-0.5 -end-0.5"></span>
                <svg class="w-5 h-5 fill-[#25D366]" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
            </div>
            <div class="hidden sm:flex flex-col text-start">
                <span class="text-[9px] uppercase tracking-[0.2em] text-[#C5A059] font-medium leading-tight">{{ __('common.whatsapp_concierge') }}</span>
                <span class="text-[11px] font-medium tracking-wide text-stone-100">WhatsApp Direct</span>
            </div>
        </a>
    </div>

    @stack('scripts')
</body>
</html>
