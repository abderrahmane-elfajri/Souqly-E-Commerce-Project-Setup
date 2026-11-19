@extends('layouts.app')

@section('title', $product->name . ' — SOUQLY Maroc')

@section('content')
<div class="py-12 bg-[#FAF8F5] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs Minimalist -->
        <nav class="flex text-[11px] uppercase tracking-[0.2em] text-stone-400 gap-2 mb-8 items-center">
            <a href="/" class="hover:text-stone-900 transition-colors">{{ __('common.home') }}</a>
            <span>/</span>
            <a href="{{ route('shop') }}" class="hover:text-stone-900 transition-colors">{{ __('common.shop') }}</a>
            <span>/</span>
            <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-stone-900 transition-colors">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-stone-900 font-medium truncate max-w-xs">{{ $product->name }}</span>
        </nav>

        <!-- Product Main Showcase (Editorial Horology Presentation) -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-12 mb-14 shadow-xs">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left: Product Gallery / Real Studio Photography Visual -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="relative aspect-square bg-[#FAF8F5] border border-stone-200/80 overflow-hidden group">
                        @if($product->discount_percentage)
                            <div class="absolute top-4 start-4 border border-stone-300 bg-white/95 text-stone-800 text-[10px] font-semibold tracking-widest uppercase px-3 py-1 z-10">
                                -{{ $product->discount_percentage }}%
                            </div>
                        @endif

                        <img 
                            id="main-product-image"
                            src="{{ $product->primary_image_url }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                            width="800"
                            height="800"
                            loading="eager"
                        >
                    </div>

                    <!-- Gallery Thumbnails (if multiple images exist) -->
                    @if($product->images->count() > 1)
                        <div class="flex items-center gap-3 overflow-x-auto pb-1">
                            @foreach($product->images as $img)
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('main-product-image').src='{{ $img->image_path }}'"
                                    class="w-20 h-20 shrink-0 border border-stone-200 hover:border-stone-900 transition-colors overflow-hidden focus:outline-none focus:border-[#C5A059]"
                                >
                                    <img src="{{ $img->image_path }}" alt="{{ $img->alt_text ?? $product->name }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Quiet Luxury Guarantees under Gallery -->
                    <div class="grid grid-cols-3 gap-3 text-center text-[10.5px] uppercase tracking-wider text-stone-600 font-medium pt-2">
                        <div class="p-3 bg-[#FAF8F5] border border-stone-200/70 flex flex-col items-center justify-center gap-1.5">
                            <svg class="w-4 h-4 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            <span>Porteur 24/48h Maroc</span>
                        </div>
                        <div class="p-3 bg-[#FAF8F5] border border-stone-200/70 flex flex-col items-center justify-center gap-1.5">
                            <svg class="w-4 h-4 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Contrôle à Réception</span>
                        </div>
                        <div class="p-3 bg-[#FAF8F5] border border-stone-200/70 flex flex-col items-center justify-center gap-1.5">
                            <svg class="w-4 h-4 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Écrin & Garantie 7J</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Product Purchase Details -->
                <div class="lg:col-span-6 space-y-7">
                    
                    <div>
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="text-[10px] uppercase font-semibold text-stone-400 tracking-[0.22em]">
                                {{ $product->category->name }}
                            </span>
                            <span class="text-stone-400 font-mono text-[11px]">RÉF: {{ $product->sku }}</span>
                        </div>

                        <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal leading-tight">
                            {{ $product->name }}
                        </h1>

                        <!-- Reviews Rating preview -->
                        <div class="flex items-center gap-2.5 mt-2.5">
                            <div class="flex text-[#C5A059] text-xs">★★★★★</div>
                            <span class="text-xs text-stone-500 font-light">4.9/5 (58 avis certifiés au Maroc)</span>
                        </div>
                    </div>

                    <!-- Price Block (Strict Moroccan MAD Decimal) -->
                    <div class="py-4 border-y border-stone-200/80 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-widest block font-medium">Prix Net de la Pièce</span>
                            <div class="flex items-baseline gap-2 mt-0.5">
                                <span class="font-serif text-3xl sm:text-4xl font-normal text-stone-900">{{ number_format($product->price, 2) }}</span>
                                <span class="text-xs tracking-widest uppercase font-semibold text-stone-500">MAD (د.م.)</span>
                                @if($product->compare_at_price)
                                    <span class="text-xs text-stone-400 line-through ms-3 font-mono">{{ number_format($product->compare_at_price, 2) }} MAD</span>
                                @endif
                            </div>
                        </div>

                        @if($product->isInStock())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] uppercase tracking-widest font-semibold border border-emerald-300 bg-emerald-50 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                {{ app()->getLocale() === 'ar' ? 'متوفر في المخزون' : 'En Stock à l\'Atelier' }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] uppercase tracking-widest font-semibold border border-rose-300 bg-rose-50 text-rose-800">
                                {{ app()->getLocale() === 'ar' ? 'نفذ من المخزون' : 'Rupture de Stock' }}
                            </span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-light">
                        {{ $product->short_description }}
                    </p>

                    <!-- Add to Cart Form with Variants and Quantity -->
                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-6 pt-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        @if($product->variants->isNotEmpty())
                            <div class="space-y-2.5">
                                <label class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-900">
                                    {{ app()->getLocale() === 'ar' ? 'اختر النوع / المواصفات:' : 'Variantes & Finitions :' }}
                                </label>
                                <div class="flex flex-wrap gap-2.5">
                                    @foreach($product->variants as $index => $variant)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="variant_id" value="{{ $variant->id }}" {{ $index === 0 ? 'checked' : '' }} class="sr-only peer">
                                            <span class="inline-block px-4 py-2 border text-xs tracking-wider border-stone-300 peer-checked:border-stone-900 peer-checked:bg-[#0B1320] peer-checked:text-white transition-all duration-200">
                                                @foreach($variant->attributes as $key => $val)
                                                    {{ $key }}: {{ $val }}
                                                @endforeach
                                                @if($variant->price && $variant->price != $product->price)
                                                    <span class="ms-1 font-mono">({{ number_format($variant->price, 2) }} MAD)</span>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-4 pt-2">
                            <div class="w-24">
                                <select name="quantity" class="w-full text-xs font-semibold px-3 py-4 border border-stone-300 bg-white focus:outline-none focus:border-stone-900 tracking-wider">
                                    <option value="1">Qté : 1</option>
                                    <option value="2">Qté : 2</option>
                                    <option value="3">Qté : 3</option>
                                    <option value="4">Qté : 4</option>
                                    <option value="5">Qté : 5</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-primary flex-1 py-4 text-[11px] uppercase tracking-[0.2em] font-semibold flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>{{ __('common.add_to_cart') }}</span>
                            </button>
                        </div>
                    </form>

                    <!-- Direct WhatsApp Concierge Order Button -->
                    @php
                        $waMessage = rawurlencode("Bonjour Souqly, je souhaite commander la pièce : " . $product->name . " (Prix: " . number_format($product->price, 2) . " MAD, Réf: " . $product->sku . "). Merci d'organiser ma livraison.");
                    @endphp
                    <a 
                        href="https://wa.me/212600000000?text={{ $waMessage }}"
                        target="_blank"
                        class="btn-primary w-full py-3.5 text-[11px] uppercase tracking-[0.18em] bg-emerald-900 hover:bg-emerald-950 text-white border-emerald-800 flex items-center justify-center gap-2 transition"
                    >
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.592 2.654-.696c1.004.577 1.764.846 2.806.847h.005c3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.768-5.768-5.768z"/></svg>
                        <span>Commander par WhatsApp Concierge</span>
                    </a>

                    <!-- Moroccan City Delivery Bullet points -->
                    <div class="pt-4 border-t border-stone-200/80 text-xs text-stone-500 space-y-1.5 font-light">
                        <div class="flex items-start gap-2">
                            <span class="text-[#C5A059] font-serif">✦</span>
                            <span><strong>Villes desservies :</strong> Casablanca, Rabat, Marrakech, Tanger, Fès, Agadir, Oujda, Meknès...</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-[#C5A059] font-serif">✦</span>
                            <span><strong>Modalité de paiement :</strong> Règlement en espèces au livreur après ouverture et contrôle de la pièce.</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Detailed Description Section -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-12 mb-14 shadow-xs">
            <h2 class="font-serif text-2xl text-stone-900 font-normal mb-6 pb-4 border-b border-stone-200/80">
                {{ app()->getLocale() === 'ar' ? 'تفاصيل ومواصفات المنتج' : 'Fiche Technique & Description' }}
            </h2>
            <div class="prose max-w-none text-stone-600 text-sm leading-relaxed space-y-4 font-light">
                <p>{{ $product->description }}</p>
            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->isNotEmpty())
            <div class="space-y-8">
                <div class="flex items-baseline justify-between pb-4 border-b border-stone-200/80">
                    <h2 class="font-serif text-2xl sm:text-3xl text-stone-900 font-normal">
                        {{ app()->getLocale() === 'ar' ? 'منتجات ذات صلة' : 'Pièces Complémentaires' }}
                    </h2>
                    <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-[11px] uppercase tracking-[0.18em] font-semibold text-stone-900 hover:text-[#C5A059] transition-colors">
                        {{ app()->getLocale() === 'ar' ? 'المزيد من هذه الفئة' : 'Voir la collection' }} &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white border border-stone-200/80 hover:border-stone-900 transition-all duration-300 p-5 flex flex-col justify-between group">
                            <div>
                                <a href="{{ route('product.show', $related->slug) }}" class="block aspect-square bg-[#FAF8F5] border border-stone-200/60 overflow-hidden mb-4 group">
                                    <img 
                                        src="{{ $related->primary_image_url }}" 
                                        alt="{{ $related->name }}" 
                                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                                        loading="lazy"
                                        width="300"
                                        height="300"
                                    >
                                </a>
                                <h3 class="font-serif text-sm text-stone-900 line-clamp-2 mb-1 font-normal group-hover:text-amber-800 transition-colors">
                                    <a href="{{ route('product.show', $related->slug) }}">
                                        {{ $related->name }}
                                    </a>
                                </h3>
                            </div>
                            <div class="pt-3 border-t border-stone-100 flex items-center justify-between mt-3">
                                <span class="font-medium text-xs text-stone-900">{{ number_format($related->price, 2) }} MAD</span>
                                <a href="{{ route('product.show', $related->slug) }}" class="text-[10px] uppercase tracking-widest font-semibold text-stone-500 hover:text-stone-900">Détails &rarr;</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
