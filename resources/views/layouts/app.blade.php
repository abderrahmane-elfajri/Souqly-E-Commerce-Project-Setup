<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SOUQLY — ' . __('common.tagline', ['default' => 'Smart Commerce Platform | Everything you need. One place.']))</title>
    <meta name="description" content="@yield('meta_description', 'Souqly — Première plateforme e-commerce multi-catégories au Maroc. Montres, Électronique, Mode, Maison. Paiement à la livraison dans tout le Maroc.')">

    <!-- Fonts: Plus Jakarta Sans for Latin, Cairo for Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col font-sans">

    <!-- Top Announcement Bar (Morocco Market Focus) -->
    <div class="bg-souqly-navy-dark text-white text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-souqly-orange animate-pulse"></span>
                <span class="font-medium">
                    @if(app()->getLocale() === 'ar')
                        🚚 توصيل سريع لجميع المدن المغربية • الدفع عند الاستلام (COD)
                    @elseif(app()->getLocale() === 'en')
                        🚚 Fast delivery across Morocco (24-48h) • Cash on Delivery available
                    @else
                        🚚 Livraison rapide partout au Maroc (24-48h) • Paiement à la livraison
                    @endif
                </span>
            </div>
            <div class="flex items-center gap-4 text-slate-300">
                <div class="flex items-center gap-1.5 font-semibold text-souqly-orange">
                    <span>MAD (د.م.)</span>
                </div>
                <div class="h-3 w-px bg-slate-700"></div>
                <!-- Language Switcher -->
                <div class="flex items-center gap-2 text-xs">
                    <a href="{{ route('locale.switch', 'fr') }}" class="{{ app()->getLocale() === 'fr' ? 'text-white font-bold underline' : 'hover:text-white' }}">FR</a>
                    <span>|</span>
                    <a href="{{ route('locale.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'text-white font-bold underline' : 'hover:text-white' }}">العربية</a>
                    <span>|</span>
                    <a href="{{ route('locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'text-white font-bold underline' : 'hover:text-white' }}">EN</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-souqly-navy text-white sticky top-0 z-40 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-souqly-orange flex items-center justify-center font-black text-white text-2xl shadow-md group-hover:scale-105 transition-transform">
                            S
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-black tracking-wider text-white">SOUQLY<span class="text-souqly-orange">.</span></span>
                            <span class="text-[10px] tracking-widest uppercase text-slate-400 -mt-1 font-semibold">Morocco</span>
                        </div>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-xl mx-4">
                    <form action="#" method="GET" class="w-full relative">
                        <input 
                            type="search" 
                            name="q"
                            placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث عن منتجات، علامات تجارية، فئات...' : (app()->getLocale() === 'en' ? 'Search products, brands, categories...' : 'Rechercher des produits, marques, catégories...') }}" 
                            class="w-full bg-souqly-navy-light text-white placeholder-slate-400 text-sm rounded-xl py-3 px-4 ps-11 pe-24 focus:outline-none focus:ring-2 focus:ring-souqly-orange border border-slate-700 transition"
                        >
                        <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button type="submit" class="absolute inset-y-1 end-1 px-4 bg-souqly-orange hover:bg-souqly-orange-hover text-white text-xs font-semibold rounded-lg transition flex items-center">
                            {{ app()->getLocale() === 'ar' ? 'بحث' : (app()->getLocale() === 'en' ? 'Search' : 'Chercher') }}
                        </button>
                    </form>
                </div>

                <!-- Right Actions: WhatsApp CTA + Account + Wishlist + Cart -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- WhatsApp Moroccan Direct CTA Button -->
                    <a 
                        href="https://wa.me/212600000000?text=Bonjour%20Souqly%2C%20je%20souhaite%20avoir%20plus%20d%27informations" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="hidden lg:inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow transition"
                        title="Commander par WhatsApp"
                    >
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/>
                        </svg>
                        <span>WhatsApp</span>
                    </a>

                    <!-- Auth State: Guest or Logged In User -->
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-900/60 hover:bg-purple-800 text-purple-200 border border-purple-700 text-xs font-bold transition">
                                <span>👑 Admin</span>
                            </a>
                        @endif

                        <a href="{{ route('account.dashboard') }}" class="flex items-center gap-1.5 text-slate-200 hover:text-white p-2 rounded-lg hover:bg-souqly-navy-light transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden sm:inline text-xs font-medium">{{ auth()->user()->name }}</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-slate-400 hover:text-rose-400 px-2 py-1 rounded transition" title="Déconnexion">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    @else
                        <!-- Account link for Guests -->
                        <a href="{{ route('login') }}" class="flex items-center gap-1.5 text-slate-200 hover:text-white p-2 rounded-lg hover:bg-souqly-navy-light transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden sm:inline text-xs font-medium">{{ app()->getLocale() === 'ar' ? 'دخول' : (app()->getLocale() === 'en' ? 'Sign In' : 'Connexion') }}</span>
                        </a>
                    @endauth

                    <!-- Wishlist -->
                    <a href="/wishlist" class="text-slate-200 hover:text-white p-2 rounded-lg hover:bg-souqly-navy-light transition relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-2 bg-souqly-orange hover:bg-souqly-orange-hover text-white px-3.5 py-2 rounded-xl font-bold text-xs shadow-md transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>{{ number_format($headerCart?->subtotal ?? 0, 0) }} MAD</span>
                        @if(($headerCart?->items_count ?? 0) > 0)
                            <span class="bg-white text-souqly-navy text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-black">
                                {{ $headerCart->items_count }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation Bar / Categories Strip -->
        <nav class="bg-souqly-navy-dark border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between text-xs font-semibold py-2.5 overflow-x-auto whitespace-nowrap scrollbar-none">
                    <div class="flex items-center gap-6">
                        <a href="/" class="text-souqly-orange flex items-center gap-1.5 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'جميع الفئات' : (app()->getLocale() === 'en' ? 'All Categories' : 'Toutes les catégories') }}</span>
                        </a>
                        <a href="/shop?category=luxury-watches" class="text-slate-300 hover:text-white transition">
                            {{ app()->getLocale() === 'ar' ? 'ساعات فاخرة' : (app()->getLocale() === 'en' ? 'Luxury Watches' : 'Montres de Luxe') }}
                        </a>
                        <a href="/shop?category=electronics" class="text-slate-300 hover:text-white transition">
                            {{ app()->getLocale() === 'ar' ? 'إلكترونيات وهواتف' : (app()->getLocale() === 'en' ? 'Electronics & Phones' : 'Électronique & High-Tech') }}
                        </a>
                        <a href="/shop?category=fashion" class="text-slate-300 hover:text-white transition">
                            {{ app()->getLocale() === 'ar' ? 'أزياء وموضة' : (app()->getLocale() === 'en' ? 'Fashion & Apparel' : 'Mode & Style') }}
                        </a>
                        <a href="/shop?category=home" class="text-slate-300 hover:text-white transition">
                            {{ app()->getLocale() === 'ar' ? 'منزل ومطبخ' : (app()->getLocale() === 'en' ? 'Home & Kitchen' : 'Maison & Déco') }}
                        </a>
                        <a href="/shop?promotions=1" class="text-amber-400 font-bold hover:text-amber-300 flex items-center gap-1 transition">
                            <span>🔥 {{ app()->getLocale() === 'ar' ? 'عروض خاصة' : (app()->getLocale() === 'en' ? 'Special Deals' : 'Promotions') }}</span>
                        </a>
                    </div>
                    <div class="hidden md:flex items-center gap-4 text-slate-400">
                        <span>{{ app()->getLocale() === 'ar' ? 'خدمة الزبناء: 0522-000000' : 'Service Client: +212 522 00 00 00' }}</span>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content Slot -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Moroccan Trust & Guarantees Strip -->
    <section class="bg-white border-t border-slate-200 py-10 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Trust 1 -->
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 text-souqly-orange flex items-center justify-center shrink-0 font-bold">
                        🚚
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">
                            {{ app()->getLocale() === 'ar' ? 'توصيل لجميع المدن' : (app()->getLocale() === 'en' ? 'Delivery Across Morocco' : 'Livraison partout au Maroc') }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'كازا، الرباط، طنجة، مراكش في 24-48 ساعة' : 'Casablanca, Rabat, Tanger, Marrakech en 24/48h' }}
                        </p>
                    </div>
                </div>

                <!-- Trust 2 -->
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-souqly-navy flex items-center justify-center shrink-0 font-bold">
                        💵
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">
                            {{ app()->getLocale() === 'ar' ? 'الدفع عند الاستلام (COD)' : (app()->getLocale() === 'en' ? 'Cash on Delivery (COD)' : 'Paiement à la livraison') }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'افحص منتجك قبل الدفع 100% مضمون' : 'Vérifiez votre colis avant de régler le livreur' }}
                        </p>
                    </div>
                </div>

                <!-- Trust 3 -->
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 font-bold">
                        🔄
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">
                            {{ app()->getLocale() === 'ar' ? 'إرجاع سهل خلال 7 أيام' : (app()->getLocale() === 'en' ? '7-Day Easy Return' : 'Garantie retour 7 jours') }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'إرجاع أو استبدال بدون تعقيدات' : 'Échange ou remboursement sans tracas' }}
                        </p>
                    </div>
                </div>

                <!-- Trust 4 -->
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0 font-bold">
                        💬
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">
                            {{ app()->getLocale() === 'ar' ? 'دعم زبناء محلي 7/7' : (app()->getLocale() === 'en' ? 'Local Support 7/7' : 'Support client dédié 7j/7') }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'عبر واتساب أو الهاتف بالدارجة والفرنسية' : 'Disponible via WhatsApp et téléphone' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-souqly-navy text-slate-300 pt-12 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-souqly-orange flex items-center justify-center font-black text-white text-xl">
                            S
                        </div>
                        <span class="text-xl font-black text-white tracking-wider">SOUQLY<span class="text-souqly-orange">.</span></span>
                    </div>
                    <p class="text-xs leading-relaxed text-slate-400">
                        {{ app()->getLocale() === 'ar' 
                            ? 'سوقلي — منصة التجارة الذكية في المغرب. نوفر لك أفضل المنتجات بأسعار مناسبة مع خدمة توصيل سريعة ودفع آمن عند الاستلام.'
                            : 'Souqly — Smart Commerce Platform. La référence e-commerce au Maroc pour les montres, la mode, l\'électronique et la maison. Tout ce dont vous avez besoin, en un seul endroit.' }}
                    </p>
                    <div class="flex items-center gap-3 text-white text-sm">
                        <span class="font-bold text-souqly-orange">Devise:</span> <span>MAD (د.م.)</span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-4 uppercase tracking-wider">
                        {{ app()->getLocale() === 'ar' ? 'روابط سريعة' : 'Navigation' }}
                    </h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="/shop" class="hover:text-souqly-orange transition">Boutique complète</a></li>
                        <li><a href="/shop?category=luxury-watches" class="hover:text-souqly-orange transition">Montres de Luxe</a></li>
                        <li><a href="/shop?category=electronics" class="hover:text-souqly-orange transition">Électronique & Gadgets</a></li>
                        <li><a href="/promotions" class="hover:text-souqly-orange transition">Offres du moment</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Service -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-4 uppercase tracking-wider">
                        {{ app()->getLocale() === 'ar' ? 'خدمة الزبناء' : 'Service Client' }}
                    </h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="/faq" class="hover:text-souqly-orange transition">Questions fréquentes (FAQ)</a></li>
                        <li><a href="/shipping-policy" class="hover:text-souqly-orange transition">Livraison & Délais</a></li>
                        <li><a href="/return-policy" class="hover:text-souqly-orange transition">Politique de retour</a></li>
                        <li><a href="/contact" class="hover:text-souqly-orange transition">Contactez-nous</a></li>
                    </ul>
                </div>

                <!-- Col 4: Payment & Security in Morocco -->
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-sm mb-4 uppercase tracking-wider">
                        {{ app()->getLocale() === 'ar' ? 'طرق الدفع' : 'Moyens de Paiement' }}
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded bg-slate-800 text-white text-[11px] font-semibold border border-slate-700">
                            💵 Paiement à la livraison (COD)
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded bg-slate-800 text-slate-400 text-[11px] font-semibold border border-slate-700">
                            💳 CMI / Carte Bancaire (Bientôt)
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-2">
                        Siège: Boulevard d'Anfa, Casablanca, Maroc.<br>
                        RC: 542190 • IF: 4983210
                    </p>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} SOUQLY Maroc. Tous droits réservés. Développé avec Laravel & Blade.</p>
                <div class="flex gap-4">
                    <a href="/privacy" class="hover:text-slate-400">Confidentialité</a>
                    <a href="/terms" class="hover:text-slate-400">Conditions Générales</a>
                    <a href="/admin" class="text-slate-400 hover:text-souqly-orange">Administration</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
