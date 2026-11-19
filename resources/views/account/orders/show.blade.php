@extends('layouts.app')

@section('title', __('orders.details_title') . ' #' . $order->order_number . ' — SOUQLY')

@section('content')
<div class="bg-[#FAF8F5] min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Minimalist -->
        <nav class="flex items-center gap-2 text-[11px] uppercase tracking-[0.2em] text-stone-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-stone-900 transition-colors">{{ __('common.home', ['default' => 'Accueil']) }}</a>
            <span>/</span>
            <a href="{{ route('account.dashboard') }}" class="hover:text-stone-900 transition-colors">{{ __('account.title', ['default' => 'Mon Compte']) }}</a>
            <span>/</span>
            <a href="{{ route('account.orders.index') }}" class="hover:text-stone-900 transition-colors">{{ __('orders.title') }}</a>
            <span>/</span>
            <span class="text-stone-900 font-semibold font-mono">#{{ $order->order_number }}</span>
        </nav>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-medium flex items-center gap-3">
                <span class="text-emerald-600 text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-900 text-xs font-medium flex items-center gap-3">
                <span class="text-rose-600 text-base">✕</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Order Header Card (Architectural Framing) -->
        <div class="bg-white border border-stone-200/80 p-8 sm:p-10 mb-10 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-baseline md:justify-between gap-6 pb-6 border-b border-stone-200/80">
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="font-mono text-2xl sm:text-3xl font-semibold text-stone-900 tracking-wide">{{ $order->order_number }}</h1>
                        <span class="inline-flex items-center px-3 py-1 text-[10px] uppercase tracking-widest font-semibold border {{ $order->status->badgeClasses() }}">
                            {{ $order->status->label(app()->getLocale()) }}
                        </span>
                    </div>
                    <p class="text-xs text-stone-400 mt-2 font-light">
                        {{ __('orders.date') }} : <span class="text-stone-700 font-medium">{{ $order->created_at->translatedFormat('d F Y à H:i') }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-4 flex-wrap">
                    <!-- WhatsApp Support Direct Link -->
                    <a href="{{ $order->whatsapp_inquiry_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2.5 border border-emerald-600/40 bg-emerald-950/20 text-emerald-800 text-[11px] uppercase tracking-wider font-semibold hover:bg-emerald-900 hover:text-white transition duration-300">
                        <span>📲 WhatsApp Concierge</span>
                    </a>

                    @if($order->canBeCancelled())
                        <form method="POST" action="{{ route('account.orders.cancel', $order->order_number) }}" onsubmit="return confirm('{{ __('orders.cancel_confirm') }}');">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 border border-rose-200 bg-rose-50 text-rose-800 hover:bg-rose-100 text-[11px] uppercase tracking-wider font-semibold transition">
                                <span>{{ __('orders.cancel_order') }}</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Visual Progress Stepper (Quiet Luxury Linear Stepper) -->
            <div class="pt-8">
                <h3 class="text-[10px] font-semibold text-stone-900 uppercase tracking-[0.24em] mb-8">{{ __('orders.tracking_title') }}</h3>

                @if($order->status === \App\Enums\OrderStatus::CANCELLED)
                    <div class="bg-rose-50 border border-rose-200 p-6 text-rose-900 text-xs">
                        <div class="font-semibold mb-1 uppercase tracking-wider">
                            {{ __('orders.status') }} : {{ $order->status->label(app()->getLocale()) }}
                        </div>
                        <p class="text-rose-700 font-light leading-relaxed">Cette commande a été annulée. Aucun prélèvement ni livraison n'aura lieu. Les pièces ont été réintégrées dans les réserves de l'atelier.</p>
                    </div>
                @else
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

                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-6 relative">
                        @foreach($steps as $idx => $step)
                            @php
                                $isCompleted = $idx < $currentStep;
                                $isCurrent = $idx === $currentStep;
                                $isPending = $idx > $currentStep;
                            @endphp
                            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-3">
                                <div class="w-9 h-9 flex items-center justify-center text-xs font-semibold flex-shrink-0 transition-all border
                                    {{ $isCompleted ? 'bg-stone-900 text-white border-stone-900' : '' }}
                                    {{ $isCurrent ? 'bg-[#C5A059] text-[#0B1320] border-[#C5A059] ring-2 ring-[#C5A059]/30 font-bold' : '' }}
                                    {{ $isPending ? 'bg-[#FAF8F5] text-stone-400 border-stone-200' : '' }}">
                                    @if($isCompleted)
                                        <span>✓</span>
                                    @else
                                        <span>0{{ $idx }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-xs uppercase tracking-wider font-semibold {{ $isCurrent ? 'text-stone-900 font-bold' : ($isCompleted ? 'text-stone-800' : 'text-stone-400') }}">
                                        {{ $step['name'] }}
                                    </h4>
                                    <p class="text-[10.5px] text-stone-500 hidden sm:block font-light mt-0.5">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Shipment Courier Card if available -->
            @if($order->latestShipment)
                <div class="mt-8 p-4 bg-[#FAF8F5] border border-stone-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs tracking-wider">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">🚚</span>
                        <div>
                            <span class="font-semibold text-stone-900 uppercase block tracking-wider">{{ $order->latestShipment->carrier }}</span>
                            <span class="text-stone-500 font-light">{{ __('orders.tracking_code') }} : <strong class="font-mono text-stone-900">{{ $order->latestShipment->tracking_number }}</strong></span>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 text-[10px] uppercase tracking-widest font-semibold border {{ $order->latestShipment->status->badgeClasses() }}">
                        {{ $order->latestShipment->status->label(app()->getLocale()) }}
                    </span>
                </div>
            @endif
        </div>

        <!-- 2-Column Details Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Items Snapshot & Address (2 cols) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Items list -->
                <div class="bg-white border border-stone-200/80 p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900 mb-6 pb-3 border-b border-stone-200/80 flex items-center justify-between">
                        <span>{{ __('orders.items') }} ({{ $order->items_count }})</span>
                        <span class="text-stone-400 font-mono text-[11px]">MAD (درهم مغربي)</span>
                    </h3>

                    <div class="divide-y divide-stone-100">
                        @foreach($order->items as $item)
                            <div class="py-5 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-[#FAF8F5] border border-stone-200/70 flex items-center justify-center p-1 text-2xl flex-shrink-0">
                                        🛍️
                                    </div>
                                    <div>
                                        <h4 class="font-serif text-base text-stone-900 font-normal">{{ $item->product_name }}</h4>
                                        <p class="text-xs text-stone-400 mt-0.5">RÉF : <span class="font-mono">{{ $item->sku }}</span></p>
                                        @if($item->variant_attributes)
                                            <div class="flex items-center gap-2 mt-1">
                                                @foreach($item->variant_attributes as $key => $val)
                                                    <span class="inline-flex items-center px-2 py-0.5 border border-stone-200 bg-[#FAF8F5] text-[10px] text-stone-600 uppercase tracking-wider">
                                                        {{ ucfirst($key) }}: {{ $val }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right rtl:text-left flex-shrink-0">
                                    <span class="text-xs text-stone-400 block font-light">{{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}</span>
                                    <span class="font-medium text-sm text-stone-900">{{ number_format($item->total, 2) }} {{ $order->currency }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Moroccan Shipping Snapshot -->
                <div class="bg-white border border-stone-200/80 p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900 mb-6 pb-3 border-b border-stone-200/80">
                        {{ __('orders.delivery_address') }}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs tracking-wider">
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-widest block font-medium">{{ __('orders.recipient') }}</span>
                            <span class="font-medium text-stone-900 text-sm mt-0.5 block">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-widest block font-medium">{{ __('orders.phone') }}</span>
                            <span class="font-medium text-stone-900 font-mono text-sm mt-0.5 block">{{ $order->customer_phone }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-widest block font-medium">{{ __('orders.city') }}</span>
                            <span class="font-medium text-stone-900 mt-0.5 block">{{ $order->shipping_city }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-widest block font-medium">Email</span>
                            <span class="text-stone-600 mt-0.5 block">{{ $order->customer_email }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] text-stone-400 uppercase tracking-widest block font-medium">{{ __('orders.address') }}</span>
                            <span class="text-stone-800 mt-0.5 block font-light leading-relaxed">{{ $order->shipping_address }}</span>
                        </div>
                        @if($order->shipping_notes)
                            <div class="sm:col-span-2 p-3.5 bg-[#FAF8F5] border border-stone-200/80 text-xs text-stone-700 font-light">
                                <span class="font-medium text-stone-900 uppercase text-[10px] tracking-wider block mb-0.5">{{ __('orders.notes') }} :</span>
                                <span>{{ $order->shipping_notes }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Financials & Concierge (1 col) -->
            <div class="space-y-8">
                <!-- Summary Card -->
                <div class="bg-white border border-stone-200/80 p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-900 mb-6 pb-3 border-b border-stone-200/80">
                        {{ __('orders.order_summary') }}
                    </h3>

                    <div class="space-y-3.5 text-xs tracking-wider">
                        <div class="flex justify-between text-stone-600">
                            <span>{{ __('orders.subtotal') }}</span>
                            <span class="font-medium text-stone-900">{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</span>
                        </div>

                        <div class="flex justify-between text-stone-600">
                            <span>{{ __('orders.shipping') }}</span>
                            @if($order->shipping_cost > 0)
                                <span class="font-medium text-stone-900">{{ number_format($order->shipping_cost, 2) }} {{ $order->currency }}</span>
                            @else
                                <span class="font-semibold text-emerald-700">{{ __('orders.free') }}</span>
                            @endif
                        </div>

                        @if($order->discount > 0)
                            <div class="flex justify-between text-emerald-700 font-medium">
                                <span>Remise</span>
                                <span>-{{ number_format($order->discount, 2) }} {{ $order->currency }}</span>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-stone-200/80 flex justify-between items-baseline">
                            <span class="font-medium text-stone-900 uppercase text-[11px] tracking-wider">{{ __('orders.total_amount') }}</span>
                            <span class="font-serif text-2xl font-normal text-stone-900">{{ number_format($order->total, 2) }} <span class="text-xs text-stone-500 font-sans">{{ $order->currency }}</span></span>
                        </div>
                    </div>

                    <div class="mt-6 p-3.5 bg-[#FAF8F5] border border-stone-200/80 flex items-center gap-3">
                        <span class="text-xl">💵</span>
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-900 block">{{ __('orders.cod_badge') }}</span>
                            <span class="text-[10px] text-stone-500">Règlement : {{ $order->payment_status->label(app()->getLocale()) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Private Concierge Card -->
                <div class="bg-[#0B1320] text-white p-7 border border-stone-800">
                    <span class="text-[9.5px] uppercase tracking-[0.25em] text-[#C5A059] font-medium block mb-2">SERVICE PRIVÉ CASABLANCA</span>
                    <h4 class="font-serif text-xl font-normal text-white mb-2">Conciergerie Souqly</h4>
                    <p class="text-xs text-stone-400 font-light leading-relaxed mb-6">
                        Une instruction particulière pour votre coursier ou une question de suivi ? Notre service client dédié vous assiste directement sur WhatsApp.
                    </p>
                    <a href="{{ $order->whatsapp_inquiry_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary w-full py-3.5 bg-[#C5A059] hover:bg-[#B38F46] text-[#0B1320] text-[10.5px] uppercase tracking-[0.18em] font-bold border-none transition text-center">
                        <span>Ouvrir WhatsApp</span>
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
