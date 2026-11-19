@extends('layouts.app')

@section('title', __('orders.public_tracking') . ' — SOUQLY')

@section('content')
<div class="bg-[#FAF8F5] min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search Card Minimalist -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-14 mb-12 text-center shadow-xs">
            <div class="w-14 h-14 bg-[#FAF8F5] border border-stone-200 text-[#C5A059] flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
            </div>
            <span class="text-[10px] uppercase tracking-[0.25em] text-stone-400 font-medium block mb-1">SUIVI DE COLIS & PORTEUR</span>
            <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 font-normal mb-3">{{ __('orders.public_tracking') }}</h1>
            <p class="text-stone-500 text-xs sm:text-sm max-w-lg mx-auto mb-10 font-light leading-relaxed">{{ __('orders.public_tracking_desc') }}</p>

            <form method="POST" action="{{ route('track.search') }}" class="max-w-lg mx-auto space-y-5 text-left rtl:text-right">
                @csrf
                <div>
                    <label class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                        {{ __('orders.order_number') }} (ex : SQL-202611-ABCDE)
                    </label>
                    <input type="text" name="order_number" value="{{ old('order_number', $orderNumber ?? '') }}" required placeholder="SQL-..." class="w-full px-4 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 font-mono uppercase text-xs font-semibold tracking-wider">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-stone-700 uppercase tracking-[0.2em] mb-1.5">
                        {{ __('orders.phone') }} (utilisé lors de la commande)
                    </label>
                    <input type="tel" name="phone" value="{{ old('phone', $phone ?? '') }}" required placeholder="06XXXXXXXX ou +2126XXXXXXXX" class="w-full px-4 py-3 bg-[#FAF8F5] border border-stone-300 focus:outline-none focus:border-stone-900 text-xs font-mono">
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full py-4 text-[11px] uppercase tracking-[0.2em] font-semibold text-center block transition">
                        <span>{{ __('orders.search_button') }}</span>
                    </button>
                </div>
            </form>
        </div>

        @if($searched && $notFound)
            <div class="bg-rose-50 border border-rose-200 p-6 text-center text-rose-900 mb-8">
                <h3 class="font-semibold text-sm mb-1 uppercase tracking-wider">{{ __('orders.not_found_message') }}</h3>
                <p class="text-xs text-rose-700 font-light">Assurez-vous d'avoir saisi le numéro exact de commande ainsi que le numéro de téléphone marocain renseigné.</p>
            </div>
        @endif

        @if($order)
            <!-- Order Tracking Result Card -->
            <div class="bg-white border border-stone-200/80 p-8 sm:p-10 space-y-8 shadow-xs">
                
                <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-4 pb-6 border-b border-stone-200/80">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="text-xl sm:text-2xl font-semibold text-stone-900 font-mono tracking-wide">{{ $order->order_number }}</span>
                            <span class="inline-flex items-center px-3 py-0.5 text-[10px] uppercase tracking-widest font-semibold border {{ $order->status->badgeClasses() }}">
                                {{ $order->status->label(app()->getLocale()) }}
                            </span>
                        </div>
                        <p class="text-xs text-stone-400 mt-1 font-light">
                            Destination : <strong class="text-stone-800">{{ $order->shipping_city }}</strong> ({{ $order->customer_name }})
                        </p>
                    </div>

                    <a href="{{ $order->whatsapp_inquiry_url }}" target="_blank" rel="noopener noreferrer" class="text-[11px] uppercase tracking-wider font-semibold text-emerald-800 hover:text-emerald-950 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.592 2.654-.696c1.004.577 1.764.846 2.806.847h.005c3.182 0 5.768-2.587 5.768-5.768z"/></svg>
                        <span>WhatsApp Concierge</span>
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

                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-6">
                        @foreach($steps as $idx => $step)
                            @php
                                $isCompleted = $idx < $currentStep;
                                $isCurrent = $idx === $currentStep;
                                $isPending = $idx > $currentStep;
                            @endphp
                            <div class="flex sm:flex-col items-center sm:text-center gap-3">
                                <div class="w-9 h-9 flex items-center justify-center text-xs font-semibold flex-shrink-0 transition-all border
                                    {{ $isCompleted ? 'bg-stone-900 text-white border-stone-900' : '' }}
                                    {{ $isCurrent ? 'bg-[#C5A059] text-[#0B1320] border-[#C5A059] font-bold' : '' }}
                                    {{ $isPending ? 'bg-[#FAF8F5] text-stone-400 border-stone-200' : '' }}">
                                    @if($isCompleted)
                                        <span>✓</span>
                                    @else
                                        <span>0{{ $idx }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-xs uppercase tracking-wider font-semibold {{ $isCurrent ? 'text-stone-900' : ($isCompleted ? 'text-stone-800' : 'text-stone-400') }}">
                                        {{ $step['name'] }}
                                    </h4>
                                    <p class="text-[10px] text-stone-400 hidden sm:block font-light mt-0.5">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Summary items -->
                <div class="pt-6 border-t border-stone-200/80">
                    <h4 class="text-[10px] font-semibold text-stone-400 uppercase tracking-[0.22em] mb-4">{{ __('orders.items') }} ({{ $order->items_count }})</h4>
                    <div class="divide-y divide-stone-100">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between text-xs py-3 tracking-wider">
                                <div>
                                    <span class="font-serif text-sm text-stone-900">{{ $item->product_name }}</span>
                                    <span class="text-stone-400 font-mono"> × {{ $item->quantity }}</span>
                                </div>
                                <span class="font-medium text-stone-900">{{ number_format($item->total, 2) }} {{ $order->currency }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-stone-200/80 flex justify-between items-baseline text-xs tracking-wider">
                        <span class="font-semibold uppercase text-stone-900 text-[11px]">{{ __('orders.total_amount') }}</span>
                        <span class="font-serif text-xl font-normal text-stone-900">{{ number_format($order->total, 2) }} <span class="text-xs text-stone-500 font-sans">{{ $order->currency }}</span></span>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
