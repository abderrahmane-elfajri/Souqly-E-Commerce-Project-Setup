@extends('layouts.app')

@section('title', 'SOUQLY — ' . ($selectedCategory ? $selectedCategory->name : __('common.shop', ['default' => 'Boutique complète'])))

@section('content')
<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs & Title Banner -->
        <div class="mb-8">
            <nav class="flex text-xs text-slate-500 gap-2 mb-3 items-center">
                <a href="/" class="hover:text-souqly-orange">{{ __('common.home') }}</a>
                <span>/</span>
                <a href="{{ route('shop') }}" class="{{ empty($filters['category']) ? 'text-slate-900 font-bold' : 'hover:text-souqly-orange' }}">{{ __('common.shop') }}</a>
                @if($selectedCategory)
                    <span>/</span>
                    <span class="text-slate-900 font-bold">{{ $selectedCategory->name }}</span>
                @endif
            </nav>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
                        {{ $selectedCategory ? $selectedCategory->name : (app()->getLocale() === 'ar' ? 'جميع المنتجات المتوفرة' : 'Catalogue & Nouveautés') }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $selectedCategory?->description ?? (app()->getLocale() === 'ar' ? 'اكتشف أفضل المنتجات المختارة بعناية مع توصيل سريع لجميع المدن المغربية.' : 'Articles authentiques garantis, livraison rapide partout au Maroc et paiement à la livraison (COD).') }}
                    </p>
                </div>

                <!-- Active filters tags or count -->
                <div class="text-xs text-slate-500 font-medium">
                    <span class="font-bold text-slate-800">{{ $products->total() }}</span> {{ app()->getLocale() === 'ar' ? 'منتج متوفر' : 'articles trouvés' }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Sidebar Filters (Desktop) -->
            <aside class="lg:col-span-3 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-6">
                <!-- Search input in filter -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                        {{ app()->getLocale() === 'ar' ? 'البحث بالاسم' : 'Recherche' }}
                    </h3>
                    <form action="{{ route('shop') }}" method="GET" class="relative">
                        @if(!empty($filters['category']))
                            <input type="hidden" name="category" value="{{ $filters['category'] }}">
                        @endif
                        <input 
                            type="search" 
                            name="q" 
                            value="{{ $filters['q'] ?? '' }}"
                            placeholder="{{ app()->getLocale() === 'ar' ? 'بحث سريع...' : 'Filtrer par mot...' }}"
                            class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange"
                        >
                    </form>
                </div>

                <!-- Categories filter -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                        {{ app()->getLocale() === 'ar' ? 'الفئات' : 'Catégories' }}
                    </h3>
                    <ul class="space-y-1.5 text-xs">
                        <li>
                            <a 
                                href="{{ route('shop', array_merge($filters, ['category' => null])) }}"
                                class="flex items-center justify-between p-2 rounded-lg font-medium transition {{ empty($filters['category']) ? 'bg-souqly-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}"
                            >
                                <span>{{ app()->getLocale() === 'ar' ? 'جميع الفئات' : 'Toutes les catégories' }}</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a 
                                    href="{{ route('shop', array_merge($filters, ['category' => $category->slug])) }}"
                                    class="flex items-center justify-between p-2 rounded-lg font-medium transition {{ ($filters['category'] ?? '') === $category->slug ? 'bg-souqly-navy text-white' : 'text-slate-600 hover:bg-slate-100' }}"
                                >
                                    <span class="flex items-center gap-2">
                                        <span>{{ $category->icon }}</span>
                                        <span>{{ $category->name }}</span>
                                    </span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ ($filters['category'] ?? '') === $category->slug ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $category->products_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter Form -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                        {{ app()->getLocale() === 'ar' ? 'نطاق السعر (درهم)' : 'Prix (MAD)' }}
                    </h3>
                    <form action="{{ route('shop') }}" method="GET" class="space-y-3">
                        @if(!empty($filters['category']))
                            <input type="hidden" name="category" value="{{ $filters['category'] }}">
                        @endif
                        @if(!empty($filters['q']))
                            <input type="hidden" name="q" value="{{ $filters['q'] }}">
                        @endif

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <input 
                                type="number" 
                                name="min_price" 
                                value="{{ $filters['min_price'] ?? '' }}" 
                                placeholder="Min" 
                                class="w-full px-2.5 py-2 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-souqly-orange"
                            >
                            <input 
                                type="number" 
                                name="max_price" 
                                value="{{ $filters['max_price'] ?? '' }}" 
                                placeholder="Max" 
                                class="w-full px-2.5 py-2 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-souqly-orange"
                            >
                        </div>
                        <button type="submit" class="btn-navy w-full py-2 text-xs">
                            {{ app()->getLocale() === 'ar' ? 'تطبيق السعر' : 'Filtrer' }}
                        </button>
                    </form>
                </div>

                <!-- Clear filters button -->
                @if(!empty($filters['category']) || !empty($filters['min_price']) || !empty($filters['max_price']) || !empty($filters['q']))
                    <div class="pt-2 border-t border-slate-100">
                        <a href="{{ route('shop') }}" class="text-xs text-rose-600 hover:underline block text-center font-medium">
                            {{ app()->getLocale() === 'ar' ? 'إعادة تعيين الفلاتر' : 'Réinitialiser les filtres' }}
                        </a>
                    </div>
                @endif
            </aside>

            <!-- Main Catalog Grid Area -->
            <main class="lg:col-span-9 space-y-6">
                
                <!-- Sort Bar -->
                <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm flex items-center justify-between text-xs">
                    <span class="text-slate-500">
                        {{ app()->getLocale() === 'ar' ? 'عرض النتائج' : 'Affichage des articles' }}
                    </span>

                    <form action="{{ route('shop') }}" method="GET" class="flex items-center gap-2">
                        @foreach($filters as $k => $v)
                            @if($k !== 'sort' && !empty($v))
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endif
                        @endforeach

                        <label for="sort" class="text-slate-600 font-semibold">{{ app()->getLocale() === 'ar' ? 'ترتيب حسب:' : 'Trier par :' }}</label>
                        <select 
                            name="sort" 
                            id="sort" 
                            onchange="this.form.submit()"
                            class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-souqly-orange font-medium"
                        >
                            <option value="latest" {{ ($filters['sort'] ?? '') === 'latest' ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? 'الأحدث' : 'Plus récents' }}
                            </option>
                            <option value="price_asc" {{ ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? 'السعر: من الأقل إلى الأعلى' : 'Prix croissant' }}
                            </option>
                            <option value="price_desc" {{ ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? 'السعر: من الأعلى إلى الأقل' : 'Prix décroissant' }}
                            </option>
                        </select>
                    </form>
                </div>

                <!-- Products Grid -->
                @if($products->isEmpty())
                    <div class="bg-white rounded-2xl p-12 text-center border border-slate-200">
                        <div class="text-4xl mb-3">🔍</div>
                        <h3 class="font-bold text-slate-800 text-base">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات مطابقة للبحث' : 'Aucun produit ne correspond à vos critères' }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">
                            {{ app()->getLocale() === 'ar' ? 'جرب البحث بكلمات أخرى أو أزل الفلاتر.' : 'Essayez d\'élargir vos filtres ou de chercher un autre mot-clé.' }}
                        </p>
                        <a href="{{ route('shop') }}" class="btn-primary text-xs px-6 py-2.5">
                            {{ app()->getLocale() === 'ar' ? 'عرض كل المنتجات' : 'Voir tous les produits' }}
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-souqly-orange transition-all duration-200 flex flex-col justify-between group">
                                <div>
                                    <!-- Visual Header / Image area -->
                                    <div class="relative bg-slate-100 aspect-square flex items-center justify-center p-6 overflow-hidden">
                                        @if($product->discount_percentage)
                                            <div class="absolute top-3 start-3 bg-rose-600 text-white text-[11px] font-black px-2 py-0.5 rounded-full shadow-sm z-10">
                                                -{{ $product->discount_percentage }}%
                                            </div>
                                        @endif

                                        @if($product->is_featured)
                                            <div class="absolute top-3 end-3 bg-souqly-orange text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm z-10">
                                                BESTSELLER
                                            </div>
                                        @endif

                                        <!-- Product Graphic Representation -->
                                        <div class="w-32 h-32 rounded-2xl bg-white shadow-inner flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                                            @if($product->category->slug === 'luxury-watches')
                                                ⌚
                                            @elseif($product->category->slug === 'electronics')
                                                📱
                                            @elseif($product->category->slug === 'fashion')
                                                👜
                                            @else
                                                🏺
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-5 space-y-2">
                                        <div class="flex items-center justify-between text-[11px]">
                                            <span class="text-slate-400 font-semibold uppercase tracking-wider">
                                                {{ $product->category->name }}
                                            </span>
                                            <div class="text-amber-400">
                                                ★★★★★
                                            </div>
                                        </div>

                                        <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-souqly-orange transition line-clamp-2">
                                            <a href="{{ route('product.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        <p class="text-xs text-slate-500 line-clamp-2">
                                            {{ $product->short_description }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Footer / Price & Actions -->
                                <div class="px-5 pb-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <div>
                                        <div class="text-base font-black text-souqly-navy">
                                            {{ number_format($product->price, 2) }} <span class="text-xs font-bold text-souqly-orange">MAD</span>
                                        </div>
                                        @if($product->compare_at_price)
                                            <div class="text-[11px] text-slate-400 line-through">
                                                {{ number_format($product->compare_at_price, 2) }} MAD
                                            </div>
                                        @endif
                                    </div>

                                    <a 
                                        href="{{ route('product.show', $product->slug) }}" 
                                        class="btn-primary text-xs px-3.5 py-2 rounded-xl"
                                    >
                                        {{ app()->getLocale() === 'ar' ? 'التفاصيل' : 'Détails' }} &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6">
                        {{ $products->links() }}
                    </div>
                @endif

            </main>

        </div>

    </div>
</div>
@endsection
