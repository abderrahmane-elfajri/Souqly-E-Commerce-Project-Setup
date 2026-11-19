@extends('layouts.app')

@section('title', 'SOUQLY — ' . (app()->getLocale() === 'ar' ? 'منصة التجارة الذكية في المغرب' : 'Smart Commerce Platform | Tout ce dont vous avez besoin'))

@section('content')
<!-- Hero Section (Dark Navy #101D32 with Orange Accent) -->
<section class="bg-souqly-navy text-white relative overflow-hidden py-16 sm:py-24">
    <!-- Ambient decorative glow -->
    <div class="absolute top-0 end-0 -mt-12 -me-12 w-96 h-96 rounded-full bg-souqly-orange/10 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 start-0 -mb-12 -ms-12 w-96 h-96 rounded-full bg-blue-500/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Text -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-start">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-souqly-navy-light border border-slate-700 text-xs font-semibold text-souqly-orange">
                    <span class="w-2 h-2 rounded-full bg-souqly-orange animate-ping"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'منصة التجارة الأولى بالمغرب' : 'SMART COMMERCE PLATFORM • MOROCCO' }}</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                    @if(app()->getLocale() === 'ar')
                        كل ما تحتاجه.<br>
                        <span class="text-souqly-orange">في مكان واحد.</span>
                    @elseif(app()->getLocale() === 'en')
                        Everything you need.<br>
                        <span class="text-souqly-orange">In one place.</span>
                    @else
                        Tout ce dont vous avez besoin.<br>
                        <span class="text-souqly-orange">En un seul endroit.</span>
                    @endif
                </h1>

                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    @if(app()->getLocale() === 'ar')
                        اكتشف تشكيلة حصرية من الساعات الفاخرة، الإلكترونيات العصرية، والأزياء الراقية مع خدمة توصيل سريعة لجميع المدن المغربية والدفع عند الاستلام.
                    @else
                        Découvrez notre sélection exclusive de montres de luxe, produits high-tech et prêt-à-porter au Maroc. Profitez de la livraison express en 24/48h et du paiement à la livraison 100% sécurisé.
                    @endif
                </p>

                <!-- Action CTAs -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="/shop" class="btn-primary text-sm px-7 py-3.5 shadow-lg">
                        <span>{{ app()->getLocale() === 'ar' ? 'ابدأ التسوق الآن' : 'Explorer le catalogue' }}</span>
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    
                    <a href="/shop?category=luxury-watches" class="btn-navy text-sm px-7 py-3.5 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700">
                        <span>{{ app()->getLocale() === 'ar' ? 'ساعات فاخرة' : 'Montres de Luxe' }}</span>
                    </a>
                </div>

                <!-- Stats summary -->
                <div class="grid grid-cols-3 gap-4 pt-8 border-t border-slate-800/80 max-w-lg mx-auto lg:mx-0 text-start">
                    <div>
                        <div class="text-2xl font-black text-white">100%</div>
                        <div class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'دفع عند الاستلام' : 'Paiement à la livraison' }}</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-white">48h</div>
                        <div class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'توصيل في كل المغرب' : 'Livraison partout au Maroc' }}</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-souqly-orange">MAD</div>
                        <div class="text-xs text-slate-400">{{ app()->getLocale() === 'ar' ? 'أسعار بالدرهم المغربي' : 'Prix nets en Dirhams' }}</div>
                    </div>
                </div>
            </div>

            <!-- Hero Showcase Card (Watch / Luxury Theme) -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-sm rounded-3xl bg-gradient-to-b from-slate-800 to-souqly-navy-dark p-6 shadow-2xl border border-slate-700">
                    <div class="absolute -top-3 -end-3 bg-souqly-orange text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                        BESTSELLER
                    </div>

                    <!-- Product Mock visual -->
                    <div class="aspect-square bg-slate-900 rounded-2xl flex items-center justify-center p-8 relative overflow-hidden group">
                        <div class="w-48 h-48 rounded-full border-4 border-amber-500/30 flex items-center justify-center relative">
                            <!-- Watch bezel representation -->
                            <div class="w-36 h-36 rounded-full bg-slate-950 border-2 border-slate-700 flex flex-col items-center justify-center shadow-inner">
                                <span class="text-[10px] tracking-widest text-amber-400 font-bold uppercase">CHRONOGRAPH</span>
                                <span class="text-xl font-bold text-white my-1">SOUQLY</span>
                                <span class="text-[9px] text-slate-400">AUTOMATIC</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Montres de Luxe</span>
                            <div class="flex items-center text-amber-400 text-xs gap-1">
                                <span>★★★★★</span>
                                <span class="text-slate-400 text-[11px]">(48 avis)</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white">Souqly Royal Chrono Automatique 41mm</h3>
                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <span class="text-2xl font-black text-souqly-orange">1,890 MAD</span>
                                <span class="text-xs text-slate-400 line-through ms-2">2,490 MAD</span>
                            </div>
                            <a href="/shop" class="btn-primary text-xs px-4 py-2">
                                {{ app()->getLocale() === 'ar' ? 'طلب الآن' : 'Commander' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
            <div>
                <span class="text-xs uppercase tracking-widest font-bold text-souqly-orange">EXPLORER</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">
                    {{ app()->getLocale() === 'ar' ? 'تصفح حسب الفئات' : 'Nos Catégories Phares' }}
                </h2>
            </div>
            <a href="/shop" class="text-xs font-bold text-souqly-navy hover:text-souqly-orange flex items-center gap-1 transition">
                <span>{{ app()->getLocale() === 'ar' ? 'عرض جميع الفئات' : 'Voir tout le catalogue' }}</span>
                <span class="rtl:rotate-180">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Cat 1 -->
            <a href="/shop?category=luxury-watches" class="group relative rounded-2xl p-6 bg-slate-50 border border-slate-200 hover:border-souqly-orange hover:shadow-xl transition-all text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-orange-100 text-3xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    ⌚
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-souqly-orange transition">
                    {{ app()->getLocale() === 'ar' ? 'ساعات فاخرة' : 'Montres de Luxe' }}
                </h3>
                <p class="text-xs text-slate-500 mt-1">Classique, Sport, Automatique</p>
            </a>

            <!-- Cat 2 -->
            <a href="/shop?category=electronics" class="group relative rounded-2xl p-6 bg-slate-50 border border-slate-200 hover:border-souqly-orange hover:shadow-xl transition-all text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-100 text-3xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    📱
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-souqly-orange transition">
                    {{ app()->getLocale() === 'ar' ? 'إلكترونيات وهواتف' : 'High-Tech & Gadgets' }}
                </h3>
                <p class="text-xs text-slate-500 mt-1">Accessoires, Écouteurs, Smart</p>
            </a>

            <!-- Cat 3 -->
            <a href="/shop?category=fashion" class="group relative rounded-2xl p-6 bg-slate-50 border border-slate-200 hover:border-souqly-orange hover:shadow-xl transition-all text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-purple-100 text-3xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    👔
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-souqly-orange transition">
                    {{ app()->getLocale() === 'ar' ? 'أزياء وأناقة' : 'Mode & Style' }}
                </h3>
                <p class="text-xs text-slate-500 mt-1">Vêtements, Maroquinerie, Chaussures</p>
            </a>

            <!-- Cat 4 -->
            <a href="/shop?category=home" class="group relative rounded-2xl p-6 bg-slate-50 border border-slate-200 hover:border-souqly-orange hover:shadow-xl transition-all text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-100 text-3xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    🏡
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-souqly-orange transition">
                    {{ app()->getLocale() === 'ar' ? 'منزل وديكور' : 'Maison & Déco' }}
                </h3>
                <p class="text-xs text-slate-500 mt-1">Art de table, Électroménager</p>
            </a>
        </div>
    </div>
</section>

<!-- Moroccan Market Direct Order Callout -->
<section class="py-12 bg-slate-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="rounded-3xl bg-souqly-navy text-white p-8 sm:p-12 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-3 text-center md:text-start">
                <span class="text-souqly-orange text-xs font-bold uppercase tracking-wider">COMMANDE EXPRESS PAR TÉLÉPHONE OU WHATSAPP</span>
                <h3 class="text-2xl sm:text-3xl font-black">
                    {{ app()->getLocale() === 'ar' ? 'كتفضل تدوز طلبك مباشرة عبر الواتساب؟' : 'Vous préférez commander directement sur WhatsApp ?' }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl">
                    {{ app()->getLocale() === 'ar' ? 'فريق خدمة الزبناء رهن إشارتكم طيلة أيام الأسبوع لمساعدتكم وتأكيد طلبكم في ثوانٍ.' : 'Notre équipe est à votre écoute 7j/7 pour vous conseiller, enregistrer vos commandes et organiser la livraison chez vous.' }}
                </p>
            </div>
            <a 
                href="https://wa.me/212600000000?text=Bonjour%20Souqly%2C%20je%20souhaite%20passer%20une%20commande" 
                target="_blank" 
                class="btn-primary bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-4 shrink-0 rounded-2xl shadow-xl flex items-center gap-3"
            >
                <span>WhatsApp (+212 600-000000)</span>
            </a>
        </div>
    </div>
</section>
@endsection
