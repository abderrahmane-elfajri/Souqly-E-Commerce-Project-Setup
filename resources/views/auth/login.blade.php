@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('auth.sign_in'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        
        <!-- Header Minimalist -->
        <div class="text-center mb-10">
            <span class="text-[10px] uppercase tracking-[0.25em] text-stone-400 font-medium block mb-2">ESPACE PRIVÉ MEMBRE</span>
            <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal">
                {{ __('auth.sign_in') }}
            </h1>
            <p class="text-xs text-stone-500 mt-2 font-light">
                {{ __('auth.no_account_yet') }} 
                <a href="{{ route('register') }}" class="font-semibold text-stone-900 hover:text-[#C5A059] transition-colors underline underline-offset-2">
                    {{ __('auth.create_account') }}
                </a>
            </p>
        </div>

        <!-- Alert messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-900 text-xs font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-900 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Login Card -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-10 shadow-xs space-y-6">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                        {{ __('auth.email_address') }}
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="client@souqly.ma"
                        class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition"
                    >
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em]">
                            {{ __('auth.password_label') }}
                        </label>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full text-xs px-3.5 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 tracking-wider transition"
                    >
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs tracking-wider">
                    <label class="flex items-center gap-2 cursor-pointer text-stone-600">
                        <input type="checkbox" name="remember" class="w-3.5 h-3.5 text-stone-900 focus:ring-0 border-stone-300">
                        <span class="text-[11px]">{{ __('auth.remember_me') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full py-4 text-[11px] uppercase tracking-[0.2em] font-semibold text-center block transition">
                    {{ __('auth.log_in') }}
                </button>
            </form>

            <!-- Recruiter / Demo One-Click Fill -->
            <div class="mt-8 pt-6 border-t border-stone-200/80">
                <span class="block text-center text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-3">
                    {{ __('auth.demo_accounts') }}
                </span>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button 
                        type="button" 
                        onclick="fillLogin('admin@souqly.ma', 'password123')"
                        class="p-2.5 rounded-lg border border-slate-200 hover:border-souqly-orange hover:bg-orange-50/50 text-slate-700 font-semibold transition text-center"
                    >
                        👑 Super Admin
                    </button>
                    <button 
                        type="button" 
                        onclick="fillLogin('client@souqly.ma', 'password123')"
                        class="p-2.5 rounded-lg border border-slate-200 hover:border-souqly-orange hover:bg-orange-50/50 text-slate-700 font-semibold transition text-center"
                    >
                        🛍️ Client Test
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function fillLogin(email, pass) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pass;
    }
</script>
@endsection
