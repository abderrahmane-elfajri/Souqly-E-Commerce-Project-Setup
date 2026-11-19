@extends('layouts.admin')

@section('title', 'Gestion des Catégories — Admin SOUQLY')
@section('header_title', 'Catégories & Taxonomie')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    <!-- Categories List (8 cols) -->
    <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span>📁</span> Catégories du Marché Marocain ({{ $categories->count() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Français</th>
                        <th class="py-3 px-4 text-right">العربية</th>
                        <th class="py-3 px-4">English</th>
                        <th class="py-3 px-4">Slug URL</th>
                        <th class="py-3 px-4 text-center">Produits</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $cat)
                        @php
                            $fr = $cat->translations->firstWhere('locale', 'fr')?->name;
                            $ar = $cat->translations->firstWhere('locale', 'ar')?->name;
                            $en = $cat->translations->firstWhere('locale', 'en')?->name;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $fr ?? $cat->slug }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900 text-right font-heading" dir="rtl">{{ $ar ?? '—' }}</td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $en ?? '—' }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 text-[11px]">{{ $cat->slug }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $cat->products->count() }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" onsubmit="return confirm('Supprimer cette catégorie ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg transition">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-500">Aucune catégorie créée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Add Form (4 cols) -->
    <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4 self-start">
        <h3 class="font-bold text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center gap-2">
            <span>+</span> Nouvelle Catégorie
        </h3>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nom en Français *
                </label>
                <input type="text" name="name_fr" required placeholder="Ex: Parfums & Cosmétiques" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    الاسم بالعربية *
                </label>
                <input type="text" name="name_ar" required placeholder="عطور ومستحضرات تجميل" dir="rtl" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-heading">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Name in English *
                </label>
                <input type="text" name="name_en" required placeholder="Ex: Fragrances & Beauty" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Slug URL (Optionnel)
                </label>
                <input type="text" name="slug" placeholder="ex: fragrances-beauty" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange font-mono">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Ordre d'affichage
                </label>
                <input type="number" name="sort_order" value="0" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange">
            </div>

            <button type="submit" class="w-full py-2.5 bg-souqly-orange hover:bg-souqly-orange-hover text-white text-xs font-bold rounded-xl shadow transition">
                Créer la Catégorie
            </button>
        </form>
    </div>

</div>
@endsection
