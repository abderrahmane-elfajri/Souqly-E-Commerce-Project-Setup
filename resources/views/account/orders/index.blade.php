@extends('layouts.app')

@section('title', __('orders.title') . ' — SOUQLY')

@section('content')
<div class="bg-[#FAF8F5] min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Minimalist -->
        <nav class="flex items-center gap-2 text-[11px] uppercase tracking-[0.2em] text-stone-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-stone-900 transition-colors">{{ __('common.home', ['default' => 'Accueil']) }}</a>
            <span>/</span>
            <a href="{{ route('account.dashboard') }}" class="hover:text-stone-900 transition-colors">{{ __('account.title', ['default' => 'Mon Compte']) }}</a>
            <span>/</span>
            <span class="text-stone-900 font-semibold">{{ __('orders.title') }}</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-4 mb-10 pb-6 border-b border-stone-200/80">
            <div>
                <h1 class="font-serif text-3xl sm:text-4xl font-normal text-stone-900">{{ __('orders.title') }}</h1>
                <p class="text-stone-500 text-xs sm:text-sm mt-1.5 font-light">{{ __('orders.subtitle') }}</p>
            </div>
            <a href="{{ route('shop') }}" class="btn-primary text-[10px] uppercase tracking-[0.2em] px-6 py-3 self-start font-semibold">
                <span>{{ __('orders.start_shopping') }}</span>
                <span class="rtl:rotate-180">&rarr;</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-medium flex items-center gap-3">
                <span class="text-emerald-600 text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white p-16 text-center border border-stone-200/80 space-y-4 shadow-xs">
                <div class="w-16 h-16 bg-[#FAF8F5] border border-stone-200 flex items-center justify-center mx-auto text-stone-400">
                    <svg class="w-8 h-8 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-serif text-2xl text-stone-900 font-normal">{{ __('orders.empty') }}</h3>
                <p class="text-stone-500 text-xs max-w-md mx-auto font-light">{{ __('orders.subtitle') }}</p>
                <div class="pt-2">
                    <a href="{{ route('shop') }}" class="btn-primary text-[10px] uppercase tracking-[0.2em] px-8 py-3.5 font-semibold">
                        <span>{{ __('orders.start_shopping') }}</span>
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white border border-stone-200/80 p-6 sm:p-7 hover:border-stone-900 transition-all duration-300">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 border-b border-stone-100">
                            <div>
                                <div class="flex items-center gap-3">
                                    <span class="text-base font-semibold text-stone-900 font-mono tracking-wider">{{ $order->order_number }}</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] uppercase tracking-wider font-semibold border {{ $order->status->badgeClasses() }}">
                                        {{ $order->status->label(app()->getLocale()) }}
                                    </span>
                                </div>
                                <p class="text-xs text-stone-400 mt-1 font-light">
                                    {{ __('orders.date') }}: {{ $order->created_at->translatedFormat('d F Y à H:i') }} • {{ $order->shipping_city }}
                                </p>
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="text-right rtl:text-left">
                                    <span class="text-[10px] uppercase tracking-widest text-stone-400 block font-medium">{{ __('orders.total') }}</span>
                                    <span class="font-serif text-xl font-normal text-stone-900">{{ number_format($order->total, 2) }} <span class="text-xs text-stone-500 font-sans">{{ $order->currency }}</span></span>
                                </div>
                                <a href="{{ route('account.orders.show', $order->order_number) }}" class="text-[11px] uppercase tracking-[0.18em] font-semibold text-stone-900 hover:text-[#C5A059] transition-colors flex items-center gap-1.5">
                                    <span>{{ __('orders.view_details') }}</span>
                                    <span class="rtl:rotate-180">&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <!-- Items Snapshot Preview -->
                        <div class="pt-5 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-2.5 overflow-x-auto py-1">
                                @foreach($order->items->take(4) as $item)
                                    <div class="flex items-center gap-2 bg-[#FAF8F5] border border-stone-200/70 px-3 py-1.5 text-xs text-stone-700">
                                        <span class="font-medium truncate max-w-[150px]">{{ $item->product_name }}</span>
                                        <span class="text-stone-400 font-mono">×{{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                                @if($order->items->count() > 4)
                                    <span class="text-xs text-stone-400 font-light">+{{ $order->items->count() - 4 }} autres pièces</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 text-xs text-stone-500">
                                <span class="inline-flex items-center gap-1.5 text-[11px] uppercase tracking-wider text-stone-600 font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ __('orders.cod_badge') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
