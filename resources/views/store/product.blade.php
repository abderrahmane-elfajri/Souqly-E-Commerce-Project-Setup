@extends('layouts.app')

@section('title', $product->name . ' — SOUQLY Maroc')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-xs text-slate-500 gap-2 mb-6 items-center">
            <a href="/" class="hover:text-souqly-orange">{{ __('common.home') }}</a>
            <span>/</span>
            <a href="{{ route('shop') }}" class="hover:text-souqly-orange">{{ __('common.shop') }}</a>
            <span>/</span>
            <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-souqly-orange">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-slate-900 font-bold truncate max-w-xs">{{ $product->name }}</span>
        </nav>

        <!-- Product Main Showcase -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Left: Product Gallery / Visual Representation -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="aspect-square bg-gradient-to-b from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center p-8 relative overflow-hidden border border-slate-200 shadow-inner group">
                        @if($product->discount_percentage)
                            <div class="absolute top-4 start-4 bg-rose-600 text-white text-xs font-black px-3 py-1 rounded-full shadow-md z-10">
                                -{{ $product->discount_percentage }}%
                            </div>
                        @endif

                        <div class="text-8xl transform group-hover:scale-110 transition-transform duration-300">
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

                    <!-- Trust Bar under Gallery -->
                    <div class="grid grid-cols-3 gap-2 text-center text-[11px] text-slate-600 font-semibold pt-2">
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            🚚 24/48h au Maroc
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            💵 Paiement COD
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            🔄 Retour 7 jours
                        </div>
                    </div>
                </div>

                <!-- Right: Product Purchase Details -->
                <div class="lg:col-span-6 space-y-6">
                    
                    <div>
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="font-bold uppercase tracking-wider text-souqly-orange">
                                {{ $product->category->name }}
                            </span>
                            <span class="text-slate-400 font-mono">SKU: {{ $product->sku }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                            {{ $product->name }}
                        </h1>

                        <!-- Reviews Rating preview -->
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex text-amber-400 text-sm">★★★★★</div>
                            <span class="text-xs text-slate-500 font-medium">4.9/5 (58 avis vérifiés au Maroc)</span>
                        </div>
                    </div>

                    <!-- Price Block (Strict Moroccan MAD Decimal) -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Prix Total</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black text-souqly-navy">{{ number_format($product->price, 2) }}</span>
                                <span class="text-sm font-bold text-souqly-orange">MAD (د.م.)</span>
                                @if($product->compare_at_price)
                                    <span class="text-xs text-slate-400 line-through ms-2">{{ number_format($product->compare_at_price, 2) }} MAD</span>
                                @endif
                            </div>
                        </div>

                        @if($product->isInStock())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                {{ app()->getLocale() === 'ar' ? 'متوفر في المخزون' : 'En Stock (Livraison 48h)' }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                {{ app()->getLocale() === 'ar' ? 'نفذ من المخزون' : 'Rupture de stock' }}
                            </span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        {{ $product->short_description }}
                    </p>

                    <!-- Add to Cart Form with Variants and Quantity -->
                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 pt-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        @if($product->variants->isNotEmpty())
                            <div class="space-y-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    {{ app()->getLocale() === 'ar' ? 'اختر النوع / المواصفات:' : 'Variantes disponibles :' }}
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->variants as $index => $variant)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="variant_id" value="{{ $variant->id }}" {{ $index === 0 ? 'checked' : '' }} class="sr-only peer">
                                            <span class="inline-block px-3.5 py-2 rounded-xl border text-xs font-semibold border-slate-300 peer-checked:border-souqly-orange peer-checked:bg-orange-50/70 peer-checked:text-souqly-orange transition">
                                                @foreach($variant->attributes as $key => $val)
                                                    {{ $key }}: {{ $val }}
                                                @endforeach
                                                @if($variant->price && $variant->price != $product->price)
                                                    <span class="ms-1 font-bold">({{ number_format($variant->price, 2) }} MAD)</span>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-3 pt-2">
                            <div class="w-24">
                                <select name="quantity" class="w-full text-xs font-bold px-3 py-3.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                                    <option value="1">Qté: 1</option>
                                    <option value="2">Qté: 2</option>
                                    <option value="3">Qté: 3</option>
                                    <option value="4">Qté: 4</option>
                                    <option value="5">Qté: 5</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-primary flex-1 py-3.5 text-sm font-bold shadow-lg">
                                <span>🛒 {{ __('common.add_to_cart') }}</span>
                            </button>
                        </div>
                    </form>

                    <!-- Direct WhatsApp Order Button (Moroccan Dominant Conversion) -->
                    @php
                        $waMessage = rawurlencode("Bonjour Souqly, je souhaite commander l'article : " . $product->name . " (Prix: " . number_format($product->price, 2) . " MAD, Réf: " . $product->sku . "). Merci de me confirmer la livraison.");
                    @endphp
                    <a 
                        href="https://wa.me/212600000000?text={{ $waMessage }}"
                        target="_blank"
                        class="btn-primary w-full py-3 text-xs bg-emerald-600 hover:bg-emerald-700 shadow-md flex items-center justify-center gap-2"
                    >
                        <span>📲 Commander directement par WhatsApp</span>
                    </a>

                    <!-- Moroccan City Delivery Bullet points -->
                    <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 space-y-1">
                        <div>🇲🇦 <strong>Villes couvertes :</strong> Casablanca, Rabat, Marrakech, Tanger, Fès, Agadir, Oujda, Meknès...</div>
                        <div>💵 <strong>Mode de règlement :</strong> Payez en espèces au livreur après ouverture et vérification du colis.</div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Detailed Description Section -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 mb-12 shadow-sm">
            <h2 class="text-lg font-black text-slate-900 mb-4 pb-2 border-b border-slate-100">
                {{ app()->getLocale() === 'ar' ? 'تفاصيل ومواصفات المنتج' : 'Description Détaillée du Produit' }}
            </h2>
            <div class="prose max-w-none text-slate-600 text-sm leading-relaxed space-y-4">
                <p>{{ $product->description }}</p>
            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->isNotEmpty())
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-black text-slate-900">
                        {{ app()->getLocale() === 'ar' ? 'منتجات ذات صلة' : 'Vous aimerez aussi' }}
                    </h2>
                    <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-xs font-bold text-souqly-orange hover:underline">
                        {{ app()->getLocale() === 'ar' ? 'المزيد من هذه الفئة' : 'Voir plus' }} &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                            <div>
                                <div class="aspect-square bg-slate-100 rounded-xl flex items-center justify-center text-3xl mb-3">
                                    @if($related->category->slug === 'luxury-watches') ⌚ @elseif($related->category->slug === 'electronics') 📱 @elseif($related->category->slug === 'fashion') 👔 @else 🏺 @endif
                                </div>
                                <h3 class="font-bold text-xs text-slate-900 line-clamp-2 mb-1">
                                    <a href="{{ route('product.show', $related->slug) }}" class="hover:text-souqly-orange">
                                        {{ $related->name }}
                                    </a>
                                </h3>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-2">
                                <span class="font-black text-xs text-souqly-navy">{{ number_format($related->price, 2) }} MAD</span>
                                <a href="{{ route('product.show', $related->slug) }}" class="text-xs font-bold text-souqly-orange hover:underline">Voir &rarr;</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
