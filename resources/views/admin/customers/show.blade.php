@extends('layouts.admin')

@section('title', 'Fiche Client ' . $customer->name . ' — Admin SOUQLY')
@section('header_title', 'Détails du Client #' . $customer->id)

@section('content')
<div class="space-y-8">

    <!-- Top Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-souqly-navy text-white text-xl font-black flex items-center justify-center font-heading shadow">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-black text-slate-900">{{ $customer->name }}</h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Compte Actif</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    {{ $customer->email }} • <span class="font-mono font-bold text-slate-700">{{ $customer->phone ?? 'Sans téléphone' }}</span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($customer->phone)
                @php
                    $cleanPhone = preg_replace('/[^\d]/', '', $customer->phone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '212' . substr($cleanPhone, 1);
                    }
                    $waUrl = "https://wa.me/{$cleanPhone}?text=" . rawurlencode("Bonjour {$customer->name}, c'est l'équipe Souqly.");
                @endphp
                <a href="{{ $waUrl }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition">
                    WhatsApp Client
                </a>
            @endif
            <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                &larr; Retour liste
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Saved Addresses (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4 self-start">
            <h3 class="font-bold text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center gap-2">
                <span>📍</span> Carnet d'adresses au Maroc
            </h3>

            @forelse($customer->addresses as $addr)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1.5 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800">{{ $addr->full_name }}</span>
                        @if($addr->is_default)
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-souqly-orange">Par défaut</span>
                        @endif
                    </div>
                    <div class="text-slate-600">{{ $addr->address }}</div>
                    <div class="text-slate-700 font-semibold">{{ $addr->city }} {{ $addr->postal_code ? "({$addr->postal_code})" : '' }}</div>
                    <div class="text-slate-500 font-mono">{{ $addr->phone }}</div>
                </div>
            @empty
                <p class="text-xs text-slate-500 py-4">Aucune adresse enregistrée sur le profil.</p>
            @endforelse
        </div>

        <!-- Orders History (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center justify-between">
                <span>📦 Historique des commandes ({{ $customer->orders->count() }})</span>
                <span class="text-xs font-mono text-slate-500">MAD (د.م.)</span>
            </h3>

            @if($customer->orders->isEmpty())
                <p class="text-xs text-slate-500 py-6 text-center">Ce client n'a passé aucune commande pour l'instant.</p>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($customer->orders as $o)
                        <div class="py-3 flex items-center justify-between gap-4 text-xs">
                            <div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.orders.show', $o->id) }}" class="font-mono font-bold text-slate-900 hover:text-souqly-orange transition">
                                        {{ $o->order_number }}
                                    </a>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $o->status->badgeClasses() }}">
                                        {{ $o->status->label('fr') }}
                                    </span>
                                </div>
                                <p class="text-slate-500 text-[11px] mt-0.5">
                                    {{ $o->created_at->format('d/m/Y H:i') }} • {{ $o->shipping_city }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="font-bold text-slate-900 font-mono">{{ number_format($o->total, 2) }} MAD</span>
                                <a href="{{ route('admin.orders.show', $o->id) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">
                                    Détails &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
