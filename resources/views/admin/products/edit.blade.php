@extends('layouts.admin')

@section('title', 'Modifier ' . $product->name . ' — Admin SOUQLY')
@section('header_title', 'Modifier le Produit #' . $product->sku)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-900">Modification Produit & Traductions</h2>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
            &larr; Retour au catalogue
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- General Settings Box -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                <span>⚙️</span> Paramètres & Tarification
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Catégorie *
                    </label>
                    <select name="category_id" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Code SKU *
                    </label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-mono uppercase">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Stock Actuel
                    </label>
                    <div class="text-xs px-3.5 py-2.5 rounded-xl bg-slate-100 border border-slate-200 font-bold text-slate-800 flex items-center justify-between">
                        <span>{{ $product->stock }} unités</span>
                        <a href="{{ route('admin.inventory.index', ['q' => $product->sku]) }}" class="text-souqly-orange hover:underline text-[11px]">
                            Ajuster &rarr;
                        </a>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Prix de Vente (MAD د.م.) *
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-mono font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Prix Barré / Comparé (MAD)
                    </label>
                    <input type="number" step="0.01" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-mono">
                </div>

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-4 h-4 text-souqly-orange rounded border-slate-300 focus:ring-souqly-orange">
                        <span>Mettre en vedette sur l'accueil</span>
                    </label>
                </div>
            </div>
        </div>

        @php
            $frTrans = $product->translations->firstWhere('locale', 'fr');
            $arTrans = $product->translations->firstWhere('locale', 'ar');
            $enTrans = $product->translations->firstWhere('locale', 'en');
        @endphp

        <!-- Trilingual Content Section -->
        <div class="space-y-4">
            
            <!-- French Description Tab -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 font-mono">FR</span>
                    <h3 class="font-bold text-slate-900 text-sm">Contenu en Français</h3>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nom du Produit (FR) *
                    </label>
                    <input type="text" name="name_fr" value="{{ old('name_fr', $frTrans?->name) }}" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Description Courte (FR)
                    </label>
                    <input type="text" name="short_description_fr" value="{{ old('short_description_fr', $frTrans?->short_description) }}" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Description Détaillée (FR)
                    </label>
                    <textarea name="description_fr" rows="3" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">{{ old('description_fr', $frTrans?->description) }}</textarea>
                </div>
            </div>

            <!-- Arabic Description Tab with RTL -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4" dir="rtl">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 font-mono">AR</span>
                    <h3 class="font-bold text-slate-900 text-sm font-heading">المحتوى باللغة العربية</h3>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        اسم المنتج بالعربية *
                    </label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $arTrans?->name) }}" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        وصف قصير بالعربية
                    </label>
                    <input type="text" name="short_description_ar" value="{{ old('short_description_ar', $arTrans?->short_description) }}" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        الوصف الكامل بالعربية
                    </label>
                    <textarea name="description_ar" rows="3" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">{{ old('description_ar', $arTrans?->description) }}</textarea>
                </div>
            </div>

            <!-- English Description Tab -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 font-mono">EN</span>
                    <h3 class="font-bold text-slate-900 text-sm">English Content</h3>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Product Name (EN) *
                    </label>
                    <input type="text" name="name_en" value="{{ old('name_en', $enTrans?->name) }}" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Short Description (EN)
                    </label>
                    <input type="text" name="short_description_en" value="{{ old('short_description_en', $enTrans?->short_description) }}" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Detailed Description (EN)
                    </label>
                    <textarea name="description_en" rows="3" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">{{ old('description_en', $enTrans?->description) }}</textarea>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                Annuler
            </a>
            <button type="submit" class="px-7 py-2.5 bg-souqly-orange hover:bg-souqly-orange-hover text-white text-xs font-bold rounded-xl shadow-lg shadow-souqly-orange/20 transition">
                Enregistrer les Modifications
            </button>
        </div>
    </form>

</div>
@endsection
