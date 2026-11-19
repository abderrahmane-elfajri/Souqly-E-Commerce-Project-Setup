@extends('layouts.app')

@section('title', 'SOUQLY — ' . ($selectedCategory ? $selectedCategory->name : __('common.shop', ['default' => 'Boutique complète'])))

@section('content')
<div class="py-12 bg-[#FAF8F5] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs & Editorial Header -->
        <div class="mb-12 pb-6 border-b border-stone-200/80">
            <nav class="flex text-[11px] uppercase tracking-[0.2em] text-stone-400 gap-2 mb-4 items-center">
                <a href="/" class="hover:text-stone-900 transition-colors">{{ __('common.home') }}</a>
                <span>/</span>
                <a href="{{ route('shop') }}" class="{{ empty($filters['category']) ? 'text-stone-900 font-semibold' : 'hover:text-stone-900 transition-colors' }}">{{ __('common.shop') }}</a>
                @if($selectedCategory)
                    <span>/</span>
                    <span class="text-stone-900 font-semibold">{{ $selectedCategory->name }}</span>
                @endif
            </nav>

            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-4">
                <div>
                    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-normal text-stone-900">
                        {{ $selectedCategory ? $selectedCategory->name : (app()->getLocale() === 'ar' ? 'جميع المنتجات المتوفرة' : 'Catalogue & Nouveautés') }}
                    </h1>
                    <p class="text-xs sm:text-sm text-stone-500 mt-2 font-light max-w-2xl leading-relaxed">
                        {{ $selectedCategory?->description ?? (app()->getLocale() === 'ar' ? 'اكتشف أفضل المنتجات المختارة بعناية مع توصيل سريع لجميع المدن المغربية.' : 'Sélection curatée de pièces authentiques au Maroc. Horlogerie, maroquinerie d\'atelier, haute technologie et mobilier d\'art. Contrôle et paiement à la livraison.') }}
                    </p>
                </div>

                <!-- Active count -->
                <div class="text-[11px] uppercase tracking-[0.2em] text-stone-500 font-medium">
                    <span class="font-bold text-stone-900">{{ $products->total() }}</span> {{ app()->getLocale() === 'ar' ? 'منتج متوفر' : 'pièces répertoriées' }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Sidebar Filters (Desktop Minimalist) -->
            <aside class="lg:col-span-3 bg-white border border-stone-200/80 p-6 space-y-7 shadow-xs">
                <!-- Search input in filter -->
                <div>
                    <h3 class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-900 mb-3 border-b border-stone-100 pb-2">
                        {{ app()->getLocale() === 'ar' ? 'البحث بالاسم' : 'Recherche de Pièce' }}
                    </h3>
                    <form action="{{ route('shop') }}" method="GET" class="relative">
                        @if(!empty($filters['category']))
                            <input type="hidden" name="category" value="{{ $filters['category'] }}">
                        @endif
                        <input 
                            type="search" 
                            name="q" 
                            value="{{ $filters['q'] ?? '' }}"
                            placeholder="{{ app()->getLocale() === 'ar' ? 'بحث سريع...' : 'Mots-clés, référence...' }}"
                            class="w-full text-xs px-3 py-2.5 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-800 transition tracking-wider"
                        >
                    </form>
                </div>

                <!-- Categories filter -->
                <div>
                    <h3 class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-900 mb-3 border-b border-stone-100 pb-2">
                        {{ app()->getLocale() === 'ar' ? 'الفئات' : 'Collections' }}
                    </h3>
                    <ul class="space-y-1 text-xs tracking-wider">
                        <li>
                            <a 
                                href="{{ route('shop', array_merge($filters, ['category' => null])) }}"
                                class="flex items-center justify-between py-2 px-2 transition {{ empty($filters['category']) ? 'font-semibold text-stone-900 border-s-2 border-stone-900 ps-3 bg-[#FAF8F5]' : 'text-stone-500 hover:text-stone-900' }}"
                            >
                                <span class="flex items-center gap-2.5">
                                    <svg class="w-3.5 h-3.5 text-[#C5A059] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    <span>{{ app()->getLocale() === 'ar' ? 'جميع الفئات' : 'Toutes les collections' }}</span>
                                </span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a 
                                    href="{{ route('shop', array_merge($filters, ['category' => $category->slug])) }}"
                                    class="flex items-center justify-between py-2 px-2 transition {{ ($filters['category'] ?? '') === $category->slug ? 'font-semibold text-stone-900 border-s-2 border-stone-900 ps-3 bg-[#FAF8F5]' : 'text-stone-500 hover:text-stone-900' }}"
                                >
                                    <span class="flex items-center gap-2.5">
                                        {!! $category->renderSvgIcon('w-3.5 h-3.5 text-[#C5A059] shrink-0') !!}
                                        <span>{{ $category->name }}</span>
                                    </span>
                                    <span class="text-[10px] font-mono text-stone-400">
                                        {{ $category->products_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter Form -->
                <div>
                    <h3 class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-900 mb-3 border-b border-stone-100 pb-2">
                        {{ app()->getLocale() === 'ar' ? 'نطاق السعر (درهم)' : 'Gamme de Prix (MAD)' }}
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
                                placeholder="Min MAD" 
                                class="w-full px-2.5 py-2 bg-[#FAF8F5] border border-stone-300 text-xs focus:outline-none focus:border-stone-800"
                            >
                            <input 
                                type="number" 
                                name="max_price" 
                                value="{{ $filters['max_price'] ?? '' }}" 
                                placeholder="Max MAD" 
                                class="w-full px-2.5 py-2 bg-[#FAF8F5] border border-stone-300 text-xs focus:outline-none focus:border-stone-800"
                            >
                        </div>
                        <button type="submit" class="btn-primary w-full py-2.5 text-[10px] tracking-[0.2em] uppercase font-semibold">
                            {{ app()->getLocale() === 'ar' ? 'تطبيق السعر' : 'Appliquer' }}
                        </button>
                    </form>
                </div>

                <!-- Clear filters button -->
                @if(!empty($filters['category']) || !empty($filters['min_price']) || !empty($filters['max_price']) || !empty($filters['q']))
                    <div class="pt-2 border-t border-stone-100">
                        <a href="{{ route('shop') }}" class="text-[11px] uppercase tracking-widest text-stone-400 hover:text-stone-900 block text-center font-medium transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'إعادة تعيين الفلاتر' : 'Réinitialiser les filtres' }}
                        </a>
                    </div>
                @endif
            </aside>

            <!-- Main Catalog Grid Area -->
            <main class="lg:col-span-9 space-y-8">
                
                <!-- Sort Bar -->
                <div class="bg-white p-4 border border-stone-200/80 flex items-center justify-between text-xs tracking-wider">
                    <span class="text-stone-400 uppercase text-[10.5px] tracking-widest">
                        {{ app()->getLocale() === 'ar' ? 'عرض النتائج' : 'Résultats du catalogue' }}
                    </span>

                    <form action="{{ route('shop') }}" method="GET" class="flex items-center gap-3">
                        @foreach($filters as $k => $v)
                            @if($k !== 'sort' && !empty($v))
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endif
                        @endforeach

                        <label for="sort" class="text-stone-500 uppercase text-[10px] tracking-widest font-semibold">{{ app()->getLocale() === 'ar' ? 'ترتيب حسب:' : 'Trier par :' }}</label>
                        <select 
                            name="sort" 
                            id="sort" 
                            onchange="this.form.submit()"
                            class="border border-stone-300 px-3 py-1.5 text-xs bg-white focus:outline-none focus:border-stone-800 font-medium tracking-wide"
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
                    <div class="bg-white p-14 text-center border border-stone-200/80 space-y-4">
                        <div class="w-12 h-12 rounded-full bg-[#FAF8F5] border border-stone-200 flex items-center justify-center mx-auto text-stone-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="font-serif text-xl text-stone-800">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات مطابقة للبحث' : 'Aucune pièce ne correspond à vos critères' }}
                        </h3>
                        <p class="text-xs text-stone-500 max-w-md mx-auto font-light">
                            {{ app()->getLocale() === 'ar' ? 'جرب البحث بكلمات أخرى أو أزل الفلاتر.' : 'Essayez d\'élargir vos filtres de prix ou d\'explorer nos autres collections.' }}
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('shop') }}" class="btn-primary text-[10px] uppercase tracking-[0.2em] px-6 py-3">
                                {{ app()->getLocale() === 'ar' ? 'عرض كل المنتجات' : 'Voir toutes les collections' }}
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($products as $product)
                            <div class="bg-white border border-stone-200/80 hover:border-stone-900 transition-all duration-500 flex flex-col justify-between group">
                                <div>
                                    <!-- Visual Header / Real Product Photography -->
                                    <div class="relative bg-[#FAF8F5] aspect-[4/5] overflow-hidden group">
                                        @if($product->discount_percentage)
                                            <div class="absolute top-3 start-3 border border-stone-300 bg-white/95 text-stone-800 text-[9.5px] font-semibold tracking-widest uppercase px-2 py-0.5 z-10">
                                                -{{ $product->discount_percentage }}%
                                            </div>
                                        @endif

                                        @if($product->is_featured)
                                            <div class="absolute top-3 end-3 border border-[#C5A059]/40 bg-white/95 text-[#C5A059] text-[9px] font-bold tracking-widest uppercase px-2 py-0.5 z-10">
                                                VEDETTE
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

                                    <!-- Content -->
                                    <div class="p-6 space-y-2">
                                        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.2em] text-stone-400">
                                            <span>{{ $product->category->name }}</span>
                                            <span class="text-[#C5A059]">★★★★★</span>
                                        </div>

                                        <h3 class="font-serif text-lg text-stone-900 font-normal leading-snug group-hover:text-amber-800 transition line-clamp-2">
                                            <a href="{{ route('product.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        <p class="text-xs text-stone-500 line-clamp-2 font-light leading-relaxed">
                                            {{ $product->short_description }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Footer / Price & Actions -->
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

                                    <a 
                                        href="{{ route('product.show', $product->slug) }}" 
                                        class="text-[11px] uppercase tracking-[0.16em] font-semibold text-stone-900 hover:text-[#C5A059] transition-colors"
                                    >
                                        {{ app()->getLocale() === 'ar' ? 'التفاصيل' : 'Détails' }} &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pt-8">
                        {{ $products->links() }}
                    </div>
                @endif

            </main>

        </div>

    </div>
</div>
@endsection
