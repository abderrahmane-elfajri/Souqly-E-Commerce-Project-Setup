@extends('layouts.app')

@section('title', 'SOUQLY — ' . (app()->getLocale() === 'ar' ? 'منصة التجارة الذكية في المغرب' : 'Smart Commerce Platform | Tout ce dont vous avez besoin'))

@section('content')
<!-- Hero Section (Luxury Minimalist Editorial Cover • Dark Obsidian #0B1320) -->
<section class="bg-[#0B1320] text-white relative overflow-hidden py-20 sm:py-28 border-b border-stone-800/80">
    <!-- Subtle architectural hairline grid & ambient aura -->
    <div class="absolute inset-0 bg-[radial-gradient(#1E2D4A_1px,transparent_1px)] [background-size:32px_32px] opacity-15 pointer-events-none"></div>
    <div class="absolute top-1/4 end-1/4 w-96 h-96 rounded-full bg-[#C5A059]/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 items-center">
            
            <!-- Hero Typography Column -->
            <div class="lg:col-span-7 space-y-7 text-center lg:text-start">
                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 border border-stone-700/80 bg-stone-900/60 text-[10px] tracking-[0.26em] uppercase text-[#C5A059] font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C5A059]"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'منصة التجارة الراقية بالمغرب • الدار البيضاء' : 'COLLECTION EXCLUSIVE 2026 • CASABLANCA' }}</span>
                </div>

                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-normal tracking-tight leading-[1.15] text-white">
                    @if(app()->getLocale() === 'ar')
                        كل ما تحتاجه.<br>
                        <span class="font-normal text-[#C5A059] italic">في مكان واحد.</span>
                    @elseif(app()->getLocale() === 'en')
                        Everything you need.<br>
                        <span class="italic text-[#C5A059]">In one curated place.</span>
                    @else
                        Tout ce dont vous avez besoin.<br>
                        <span class="italic text-[#C5A059]">En un seul endroit.</span>
                    @endif
                </h1>

                <p class="text-sm sm:text-base text-stone-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-light">
                    @if(app()->getLocale() === 'ar')
                        اكتشف تشكيلة حصرية من الساعات الفاخرة، الإلكترونيات العصرية، والأزياء الراقية مع خدمة توصيل سريعة لجميع المدن المغربية والدفع عند الاستلام.
                    @else
                        L'art du détail et l'exigence de la qualité. Découvrez notre sélection d'horlogerie de prestige, maroquinerie d'atelier, art de vivre et technologie de pointe. Livraison express sécurisée partout au Maroc et paiement à la réception.
                    @endif
                </p>

                <!-- Minimalist Luxury Action CTAs -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('shop') }}" class="btn-primary bg-white text-[#0B1320] hover:bg-stone-200 border-white tracking-[0.2em] text-[11px] uppercase py-4 px-8 font-semibold transition duration-300">
                        <span>{{ app()->getLocale() === 'ar' ? 'ابدأ التسوق الآن' : 'Explorer la collection' }}</span>
                        <span class="rtl:rotate-180">&rarr;</span>
                    </a>
                    
                    <a href="{{ route('shop', ['category' => 'luxury-watches']) }}" class="btn-navy border-stone-700 text-stone-200 hover:text-white hover:border-white tracking-[0.2em] text-[11px] uppercase py-4 px-8 transition duration-300">
                        <span>{{ app()->getLocale() === 'ar' ? 'ساعات فاخرة' : 'Haute Horlogerie' }}</span>
                    </a>
                </div>

                <!-- Minimalist Key Metrics -->
                <div class="grid grid-cols-3 gap-6 pt-10 border-t border-stone-800/80 max-w-lg mx-auto lg:mx-0 text-start">
                    <div>
                        <div class="font-serif text-2xl sm:text-3xl font-light text-white">100%</div>
                        <div class="text-[10px] uppercase tracking-widest text-stone-400 mt-1">{{ app()->getLocale() === 'ar' ? 'دفع عند الاستلام' : 'Paiement à la livraison' }}</div>
                    </div>
                    <div>
                        <div class="font-serif text-2xl sm:text-3xl font-light text-white">24/48h</div>
                        <div class="text-[10px] uppercase tracking-widest text-stone-400 mt-1">{{ app()->getLocale() === 'ar' ? 'توصيل في كل المغرب' : 'Livraison par porteur' }}</div>
                    </div>
                    <div>
                        <div class="font-serif text-2xl sm:text-3xl font-light text-[#C5A059]">MAD</div>
                        <div class="text-[10px] uppercase tracking-widest text-stone-400 mt-1">{{ app()->getLocale() === 'ar' ? 'أسعار بالدرهم المغربي' : 'Prix nets en Dirhams' }}</div>
                    </div>
                </div>
            </div>

            <!-- Hero Horology Showcase Card (Real Photography Interface) -->
            <div class="lg:col-span-5 relative group">
                <!-- Ambient luxury glow -->
                <div class="absolute -inset-2 bg-gradient-to-tr from-[#C5A059]/25 via-[#C5A059]/10 to-transparent blur-2xl opacity-60 group-hover:opacity-100 transition duration-700 pointer-events-none"></div>

                <div class="relative mx-auto max-w-md bg-[#0E1726]/95 backdrop-blur-md border border-stone-700/80 p-6 sm:p-7 shadow-2xl transition duration-500 hover:border-[#C5A059]/70">
                    
                    <!-- Header Info Bar -->
                    <div class="flex items-center justify-between pb-3.5 border-b border-stone-800 text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium">
                        <span class="text-[#C5A059] flex items-center gap-1.5 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#C5A059] animate-ping"></span>
                            <span>PIÈCE PHARE 2026</span>
                        </span>
                        <span class="text-stone-400 tracking-wider">CALIBRE JAPONAIS AUTO</span>
                    </div>

                    <!-- Real Photography Image Showcase -->
                    <div class="relative aspect-[4/3] sm:aspect-square bg-[#070D17] my-5 overflow-hidden border border-stone-800 group/img">
                        <img 
                            src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=85" 
                            alt="Souqly Royal Chronographe Automatique 41mm" 
                            class="w-full h-full object-cover object-center group-hover/img:scale-105 transition-transform duration-700 ease-out"
                            width="600"
                            height="600"
                            loading="eager"
                        >
                        
                        <!-- Floating Glassmorphism Badge: Casablanca 24h Dispatch -->
                        <div class="absolute bottom-3 start-3 end-3 flex items-center justify-between gap-2 p-2.5 bg-[#0B1320]/90 backdrop-blur-md border border-stone-700/80 text-[10px]">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="text-stone-200 font-medium tracking-wider">En Stock à Casablanca</span>
                            </div>
                            <span class="text-[#C5A059] font-mono font-semibold tracking-wider">24h Express</span>
                        </div>

                        <div class="absolute top-3 end-3 px-2.5 py-1 bg-[#C5A059] text-[#0B1320] text-[9.5px] font-bold tracking-widest uppercase shadow-md">
                            -24% PRIVILÈGE
                        </div>
                    </div>

                    <!-- Metadata & Pricing -->
                    <div class="space-y-3.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-[10px] text-stone-400 uppercase tracking-[0.22em] font-medium">Haute Horlogerie • 41mm</span>
                            <div class="flex items-center text-[#C5A059] text-[11px] gap-1">
                                <div class="flex items-center text-[#C5A059]">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <span class="text-stone-400 text-[10px] font-mono">(48 avis vérifiés)</span>
                            </div>
                        </div>

                        <h3 class="font-serif text-lg sm:text-xl text-white font-normal leading-snug">
                            <a href="{{ route('product.show', 'souqly-royal-chrono-41mm') }}" class="hover:text-stone-200 transition-colors">
                                Souqly Royal Chrono Automatique 41mm
                            </a>
                        </h3>

                        <div class="flex items-center justify-between pt-3 border-t border-stone-800">
                            <div>
                                <span class="text-2xl font-serif text-white font-normal tracking-wide">1,890.00 <span class="text-xs font-sans text-[#C5A059] font-medium">MAD</span></span>
                                <span class="text-xs text-stone-500 line-through ms-2">2,490.00</span>
                            </div>
                            <a href="{{ route('product.show', 'souqly-royal-chrono-41mm') }}" class="btn-primary bg-[#C5A059] hover:bg-[#B38F46] text-[#0B1320] text-[10px] tracking-[0.2em] py-3 px-5 font-bold uppercase border-none transition-all shadow-md">
                                {{ app()->getLocale() === 'ar' ? 'طلب الآن' : 'Commander' }} &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Curated Categories Grid (Architectural Gallery Layout) -->
<section class="py-20 bg-[#FAF8F5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-baseline justify-between mb-12 pb-4 border-b border-stone-200/80 gap-4">
            <div>
                <span class="text-[10px] uppercase tracking-[0.26em] font-medium text-stone-500">CATALOGUE SÉLECTIF</span>
                <h2 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal mt-1">
                    {{ app()->getLocale() === 'ar' ? 'تصفح حسب الفئات' : 'Nos Collections Phares' }}
                </h2>
            </div>
            <a href="{{ route('shop') }}" class="text-xs uppercase tracking-[0.18em] font-semibold text-stone-700 hover:text-stone-900 transition flex items-center gap-1.5">
                <span>{{ app()->getLocale() === 'ar' ? 'عرض جميع الفئات' : 'Explorer le catalogue' }}</span>
                <span class="rtl:rotate-180">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group relative bg-white border border-stone-200/80 hover:border-stone-900 transition-all duration-500 flex flex-col justify-between overflow-hidden shadow-xs">
                    <div class="relative aspect-[4/3] bg-stone-900 overflow-hidden">
                        <img 
                            src="{{ $category->image_url }}" 
                            alt="{{ $category->name }}" 
                            class="w-full h-full object-cover object-center opacity-85 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700 ease-out"
                            loading="lazy"
                            width="400"
                            height="300"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0B1320]/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-3 start-3 text-white text-xs font-serif tracking-wider">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[9px] uppercase tracking-widest font-sans bg-[#0B1320]/85 backdrop-blur-sm border border-stone-700/80 text-[#C5A059]">
                                {!! $category->renderSvgIcon('w-3 h-3 text-[#C5A059] shrink-0') !!}
                                <span>{{ app()->getLocale() === 'ar' ? 'تشكيلة مختارة' : 'COLLECTION' }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-6 text-center flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-serif text-base sm:text-lg text-stone-900 font-normal group-hover:text-stone-700 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-stone-500 mt-1 line-clamp-1 font-light">
                                {{ $category->description }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-stone-100 text-[10px] uppercase tracking-[0.18em] text-stone-400 group-hover:text-stone-900 transition-colors font-medium">
                            {{ app()->getLocale() === 'ar' ? 'استكشف المجموعة' : 'Voir les pièces' }} &rarr;
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Showcase (Quiet Luxury Product Cards) -->
<section class="py-20 bg-white border-t border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-baseline justify-between mb-12 pb-4 border-b border-stone-200/80 gap-4">
            <div>
                <span class="text-[10px] uppercase tracking-[0.26em] font-medium text-stone-500">SÉLECTION DE SAISON</span>
                <h2 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal mt-1">
                    {{ app()->getLocale() === 'ar' ? 'منتجات مميزة ومختارة' : 'Pièces d\'Exception' }}
                </h2>
            </div>
            <a href="{{ route('shop') }}" class="btn-outline text-[11px] uppercase tracking-[0.18em] px-5 py-2.5">
                <span>{{ app()->getLocale() === 'ar' ? 'تصفح كل المنتجات' : 'Voir toute la collection' }}</span>
                <span class="rtl:rotate-180">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                <div class="bg-white border border-stone-200/80 hover:border-stone-900 transition-all duration-500 flex flex-col justify-between group">
                    <div>
                        <div class="relative bg-[#FAF8F5] aspect-[4/5] overflow-hidden group">
                            @if($product->discount_percentage)
                                <div class="absolute top-3 start-3 border border-stone-300 bg-white/95 text-stone-800 text-[10px] font-semibold tracking-widest uppercase px-2 py-0.5 z-10">
                                    -{{ $product->discount_percentage }}%
                                </div>
                            @endif

                            <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                                <img 
                                    src="{{ $product->primary_image_url }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                                    loading="lazy"
                                    width="600"
                                    height="750"
                                >
                            </a>
                        </div>

                        <div class="p-6 space-y-2">
                            <span class="text-[9.5px] uppercase font-semibold text-stone-400 tracking-[0.2em] block">
                                {{ $product->category->name }}
                            </span>
                            <h3 class="font-serif text-lg text-stone-900 font-normal leading-snug group-hover:text-amber-800 transition line-clamp-2">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-stone-500 line-clamp-2 pt-1 font-light leading-relaxed">
                                {{ $product->short_description }}
                            </p>
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-3 border-t border-stone-100 flex items-center justify-between">
                        <div>
                            <div class="text-base font-medium text-stone-900 tracking-wide">
                                {{ number_format($product->price, 2) }} <span class="text-xs text-stone-500 font-sans">MAD</span>
                            </div>
                            @if($product->compare_at_price)
                                <div class="text-[11px] text-stone-400 line-through">
                                    {{ number_format($product->compare_at_price, 2) }} MAD
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('product.show', $product->slug) }}" class="text-[11px] uppercase tracking-[0.16em] font-semibold text-stone-900 hover:text-[#C5A059] transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'طلب' : 'Détails' }} &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Moroccan Market Express WhatsApp Concierge Banner -->
<section class="py-16 bg-[#FAF8F5]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="bg-[#0B1320] text-white p-10 sm:p-14 border border-stone-800 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="space-y-3 text-center md:text-start">
                <span class="text-[#C5A059] text-[10px] font-semibold uppercase tracking-[0.26em]">CONCIERGERIE PRIVÉE CASABLANCA</span>
                <h3 class="font-serif text-2xl sm:text-3xl font-normal leading-tight text-white">
                    {{ app()->getLocale() === 'ar' ? 'كتفضل تدوز طلبك مباشرة عبر الواتساب؟' : 'Une commande sur-mesure ou une assistance immédiate ?' }}
                </h3>
                <p class="text-xs sm:text-sm text-stone-300 max-w-xl font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar' ? 'فريق خدمة الزبناء رهن إشارتكم طيلة أيام الأسبوع لمساعدتكم وتأكيد طلبكم في ثوانٍ.' : 'Nos conseillers sont disponibles 7j/7 pour vous orienter, valider vos commandes de haute horlogerie et organiser la livraison sécurisée à votre adresse.' }}
                </p>
            </div>
            <a 
                href="https://wa.me/212600000000?text=Bonjour%20Souqly%2C%20je%20souhaite%20passer%20une%20commande" 
                target="_blank" 
                class="btn-primary bg-[#C5A059] hover:bg-[#B38F46] text-[#0B1320] font-semibold text-xs tracking-[0.18em] px-8 py-4 shrink-0 border-none transition"
            >
                <span>WhatsApp (+212 600-000000)</span>
            </a>
        </div>
    </div>
</section>
@endsection
