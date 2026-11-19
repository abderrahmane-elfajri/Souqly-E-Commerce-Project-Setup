@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('auth.sign_up'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-lg mx-auto px-4 sm:px-6">
        
        <!-- Header Minimalist -->
        <div class="text-center mb-10">
            <span class="text-[10px] uppercase tracking-[0.25em] text-stone-400 font-medium block mb-2">ADHÉSION MEMBRE</span>
            <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal">
                {{ __('auth.sign_up') }}
            </h1>
            <p class="text-xs text-stone-500 mt-2 font-light">
                {{ __('auth.already_have_account') }} 
                <a href="{{ route('login') }}" class="font-semibold text-stone-900 hover:text-[#C5A059] transition-colors underline underline-offset-2">
                    {{ __('auth.sign_in') }}
                </a>
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-900 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Registration Card -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-10 shadow-xs space-y-5">
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                        {{ __('auth.full_name') }} *
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Yassine El Amrani"
                        class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                        {{ __('auth.email_address') }} *
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="yassine@example.com"
                        class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition"
                    >
                </div>

                <!-- Moroccan Phone & City (2 columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                            {{ __('auth.phone_number') }} *
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            placeholder="0661234567"
                            class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 font-mono tracking-wider transition"
                        >
                        <span class="text-[10px] text-stone-400 mt-1 block font-light">06XXXXXXXX ou +2126XXXXXXXX</span>
                    </div>

                    <!-- Moroccan City -->
                    <div>
                        <label for="city" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                            {{ __('auth.city') }} *
                        </label>
                        <select 
                            name="city" 
                            id="city" 
                            required
                            class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition font-medium"
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
                    <label for="address" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                        {{ __('auth.delivery_address') }}
                    </label>
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        value="{{ old('address') }}" 
                        placeholder="Quartier, Boulevard, Rue, N° d'immeuble, Étage"
                        class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition"
                    >
                </div>

                <!-- Password & Confirmation (2 columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                            {{ __('auth.password_label') }} *
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="Min. 8 caractères"
                            class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                            {{ __('auth.password_confirmation') }} *
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            required 
                            placeholder="Confirmer"
                            class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full py-4 text-[11px] uppercase tracking-[0.2em] font-semibold text-center block transition">
                        {{ __('auth.create_account') }}
                    </button>
                </div>
            </form>

            <!-- Moroccan Guarantees -->
            <div class="mt-6 pt-6 border-t border-stone-100 flex items-center justify-around text-center text-xs text-stone-400 tracking-wider">
                <div>
                    <span class="block text-base mb-0.5">💵</span>
                    <span class="font-medium text-stone-700 text-[10.5px]">Paiement COD</span>
                </div>
                <div class="h-6 w-px bg-stone-200"></div>
                <div>
                    <span class="block text-base mb-0.5">🚚</span>
                    <span class="font-medium text-stone-700 text-[10.5px]">Porteur 48h</span>
                </div>
                <div class="h-6 w-px bg-stone-200"></div>
                <div>
                    <span class="block text-base mb-0.5">🛡️</span>
                    <span class="font-medium text-stone-700 text-[10.5px]">Garantie 7J</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
