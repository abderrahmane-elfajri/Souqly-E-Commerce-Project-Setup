@extends('layouts.app')

@section('title', __('orders.public_tracking') . ' — SOUQLY')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search Card -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-sm mb-10 text-center">
            <div class="w-16 h-16 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-primary font-heading mb-2">{{ __('orders.public_tracking') }}</h1>
            <p class="text-gray-600 text-sm max-w-xl mx-auto mb-8">{{ __('orders.public_tracking_desc') }}</p>

            <form method="POST" action="{{ route('track.search') }}" class="max-w-xl mx-auto space-y-4 text-left rtl:text-right">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        {{ __('orders.order_number') }} (ex: SQL-202611-ABCDE)
                    </label>
                    <input type="text" name="order_number" value="{{ old('order_number', $orderNumber ?? '') }}" required placeholder="SQL-..." class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-secondary focus:border-secondary font-mono uppercase text-sm font-bold tracking-wider">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        {{ __('orders.phone') }} (utilisé lors de la commande)
                    </label>
                    <input type="tel" name="phone" value="{{ old('phone', $phone ?? '') }}" required placeholder="06XXXXXXXX ou +2126XXXXXXXX" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-secondary focus:border-secondary text-sm font-mono">
                </div>

                <button type="submit" class="w-full py-3.5 px-6 bg-secondary hover:bg-opacity-95 text-white font-bold rounded-xl shadow-lg shadow-secondary/20 transition-all flex items-center justify-center gap-2 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>{{ __('orders.search_button') }}</span>
                </button>
            </form>
        </div>

        @if($searched && $notFound)
            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-6 text-center text-rose-800 mb-8">
                <svg class="w-8 h-8 text-rose-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h3 class="font-bold text-base mb-1">{{ __('orders.not_found_message') }}</h3>
                <p class="text-xs text-rose-700">Assurez-vous d'avoir saisi le numéro exact de commande ainsi que le numéro de téléphone marocain renseigné.</p>
            </div>
        @endif

        @if($order)
            <!-- Order Tracking Result Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-8">
                
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-100">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="text-xl sm:text-2xl font-black text-primary font-mono tracking-tight">{{ $order->order_number }}</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->status->badgeClasses() }}">
                                {{ $order->status->label(app()->getLocale()) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Destination : <strong class="text-gray-800">{{ $order->shipping_city }}</strong> ({{ $order->customer_name }})
                        </p>
                    </div>

                    <a href="{{ $order->whatsapp_inquiry_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-all self-start">
                        <span>WhatsApp Support</span>
                    </a>
                </div>

                <!-- Visual Stepper -->
                <div>
                    @php
                        $currentStep = $order->status->stepIndex();
                        $steps = [
                            1 => ['name' => __('orders.timeline.step1'), 'desc' => __('orders.timeline.step1_desc')],
                            2 => ['name' => __('orders.timeline.step2'), 'desc' => __('orders.timeline.step2_desc')],
                            3 => ['name' => __('orders.timeline.step3'), 'desc' => __('orders.timeline.step3_desc')],
                            4 => ['name' => __('orders.timeline.step4'), 'desc' => __('orders.timeline.step4_desc')],
                            5 => ['name' => __('orders.timeline.step5'), 'desc' => __('orders.timeline.step5_desc')],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                        @foreach($steps as $idx => $step)
                            @php
                                $isCompleted = $idx < $currentStep;
                                $isCurrent = $idx === $currentStep;
                                $isPending = $idx > $currentStep;
                            @endphp
                            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0 transition-all
                                    {{ $isCompleted ? 'bg-emerald-600 text-white' : '' }}
                                    {{ $isCurrent ? 'bg-secondary text-white ring-4 ring-secondary/20 shadow-lg' : '' }}
                                    {{ $isPending ? 'bg-gray-200 text-gray-500' : '' }}">
                                    @if($isCompleted)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <span>{{ $idx }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold {{ $isCurrent ? 'text-secondary' : ($isCompleted ? 'text-gray-900' : 'text-gray-400') }}">
                                        {{ $step['name'] }}
                                    </h4>
                                    <p class="text-[11px] text-gray-500 hidden sm:block">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Summary items -->
                <div class="pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">{{ __('orders.items') }} ({{ $order->items_count }})</h4>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between text-sm py-1.5 border-b border-gray-50">
                                <div>
                                    <span class="font-bold text-gray-900">{{ $item->product_name }}</span>
                                    <span class="text-xs text-gray-500"> × {{ $item->quantity }}</span>
                                </div>
                                <span class="font-semibold text-primary">{{ number_format($item->total, 2) }} {{ $order->currency }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-3 flex justify-between items-baseline text-sm">
                        <span class="font-bold text-gray-900">{{ __('orders.total_amount') }}</span>
                        <span class="text-lg font-black text-secondary">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
