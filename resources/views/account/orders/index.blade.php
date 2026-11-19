@extends('layouts.app')

@section('title', __('orders.title') . ' — SOUQLY')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">{{ __('common.home', ['default' => 'Accueil']) }}</a>
            <span>/</span>
            <a href="{{ route('account.dashboard') }}" class="hover:text-primary transition-colors">{{ __('account.title', ['default' => 'Mon Compte']) }}</a>
            <span>/</span>
            <span class="text-primary font-medium">{{ __('orders.title') }}</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary font-heading">{{ __('orders.title') }}</h1>
                <p class="text-gray-600 text-sm mt-1">{{ __('orders.subtitle') }}</p>
            </div>
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-opacity-95 shadow-sm transition-all self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>{{ __('orders.start_shopping') }}</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('orders.empty') }}</h3>
                <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">{{ __('orders.subtitle') }}</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-secondary text-white font-semibold rounded-xl hover:bg-opacity-95 shadow-md shadow-secondary/20 transition-all">
                    <span>{{ __('orders.start_shopping') }}</span>
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-100">
                            <div>
                                <div class="flex items-center gap-3">
                                    <span class="text-lg font-black text-primary font-mono tracking-wide">{{ $order->order_number }}</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeClasses() }}">
                                        {{ $order->status->label(app()->getLocale()) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ __('orders.date') }}: {{ $order->created_at->translatedFormat('d F Y à H:i') }} • {{ $order->shipping_city }}
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="text-right rtl:text-left">
                                    <span class="text-xs text-gray-500 block">{{ __('orders.total') }}</span>
                                    <span class="text-lg font-bold text-primary">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                                </div>
                                <a href="{{ route('account.orders.show', $order->order_number) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-primary text-sm font-semibold rounded-xl hover:bg-primary hover:text-white transition-all">
                                    <span>{{ __('orders.view_details') }}</span>
                                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Items Snapshot Preview -->
                        <div class="pt-4 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-2 overflow-x-auto py-1">
                                @foreach($order->items->take(4) as $item)
                                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200/60 rounded-lg px-2.5 py-1 text-xs text-gray-700">
                                        <span class="font-medium truncate max-w-[140px]">{{ $item->product_name }}</span>
                                        <span class="text-gray-400">×{{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                                @if($order->items->count() > 4)
                                    <span class="text-xs text-gray-400 font-medium">+{{ $order->items->count() - 4 }} autres</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
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
