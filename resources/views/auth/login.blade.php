@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('auth.sign_in'))

@section('content')
<div class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-souqly-navy text-white text-2xl font-black flex items-center justify-center mx-auto shadow-md">
                S
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-4">
                {{ __('auth.sign_in') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                {{ __('auth.no_account_yet') }} 
                <a href="{{ route('register') }}" class="font-bold text-souqly-orange hover:underline">
                    {{ __('auth.create_account') }}
                </a>
            </p>
        </div>

        <!-- Alert messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
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
                        class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                    >
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            {{ __('auth.password_label') }}
                        </label>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full text-sm px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-souqly-orange focus:border-transparent transition"
                    >
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-souqly-orange focus:ring-souqly-orange border-slate-300">
                        <span>{{ __('auth.remember_me') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full py-3.5 text-sm font-bold shadow-md">
                    {{ __('auth.log_in') }}
                </button>
            </form>

            <!-- Recruiter / Demo One-Click Fill -->
            <div class="mt-8 pt-6 border-t border-slate-100">
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
