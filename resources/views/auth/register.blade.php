@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('auth.sign_up'))

@section('content')
<div class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-lg mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-souqly-orange text-white text-2xl font-black flex items-center justify-center mx-auto shadow-md">
                S
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-4">
                {{ __('auth.sign_up') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                {{ __('auth.already_have_account') }} 
                <a href="{{ route('login') }}" class="font-bold text-souqly-navy hover:underline">
                    {{ __('auth.sign_in') }}
                </a>
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Registration Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('auth.full_name') }} *
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Yassine El Amrani"
                        class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('auth.email_address') }} *
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="yassine@example.com"
                        class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                    >
                </div>

                <!-- Moroccan Phone & City (2 columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('auth.phone_number') }} *
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            placeholder="0661234567"
                            class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                        >
                        <span class="text-[11px] text-slate-400 mt-1 block">Ex: 06XXXXXXXX ou +2126XXXXXXXX</span>
                    </div>

                    <!-- Moroccan City -->
                    <div>
                        <label for="city" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('auth.city') }} *
                        </label>
                        <select 
                            name="city" 
                            id="city" 
                            required
                            class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition bg-white"
                        >
                            <option value="">Sélectionnez votre ville</option>
                            @foreach($moroccanCities as $city)
                                <option value="{{ $city }}" {{ old('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('auth.delivery_address') }}
                    </label>
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        value="{{ old('address') }}" 
                        placeholder="Quartier, Rue, N° d'immeuble ou d'appartement"
                        class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                    >
                </div>

                <!-- Password & Confirmation (2 columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('auth.password_label') }} *
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="Min. 8 caractères"
                            class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('auth.password_confirmation') }} *
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            required 
                            placeholder="Confirmer"
                            class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full py-3.5 text-sm font-bold shadow-md">
                        {{ __('auth.create_account') }}
                    </button>
                </div>
            </form>

            <!-- Moroccan Guarantees -->
            <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-around text-center text-xs text-slate-500">
                <div>
                    <span class="block text-base">💵</span>
                    <span class="font-semibold text-slate-700">Paiement COD</span>
                </div>
                <div class="h-6 w-px bg-slate-200"></div>
                <div>
                    <span class="block text-base">🚚</span>
                    <span class="font-semibold text-slate-700">Livraison 48h</span>
                </div>
                <div class="h-6 w-px bg-slate-200"></div>
                <div>
                    <span class="block text-base">🔄</span>
                    <span class="font-semibold text-slate-700">Retour 7 jours</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
