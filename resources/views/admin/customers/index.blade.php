@extends('layouts.admin')

@section('title', 'Gestion des Clients — Admin SOUQLY')
@section('header_title', 'Clients & Comptes Utilisateurs')

@section('content')
<div class="space-y-6">

    <!-- Search Toolbar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-900 text-sm">Liste des clients enregistrés</h3>
            <p class="text-xs text-slate-500 mt-0.5">Comptes acheteurs sur la plateforme Souqly.</p>
        </div>

        <form method="GET" action="{{ route('admin.customers.index') }}" class="flex items-center gap-2">
            <div class="relative">
                <input 
                    type="search" 
                    name="q" 
                    value="{{ $searchQuery ?? '' }}" 
                    placeholder="Nom, téléphone, email..." 
                    class="text-xs px-3.5 py-2 pe-8 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange w-56 sm:w-64"
                >
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Client</th>
                        <th class="py-3.5 px-4">Téléphone Maroc</th>
                        <th class="py-3.5 px-4 text-center">Commandes</th>
                        <th class="py-3.5 px-4">Statut</th>
                        <th class="py-3.5 px-4">Date d'inscription</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $c)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $c->name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $c->email }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-800">
                                {{ $c->phone ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">
                                    {{ $c->orders_count }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    Actif
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                {{ $c->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.customers.show', $c->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg text-xs font-bold transition">
                                    <span>Fiche</span>
                                    <span>&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Aucun client trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
