@extends('layouts.app')

@section('title', __('orders.details_title') . ' #' . $order->order_number . ' — SOUQLY')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">{{ __('common.home', ['default' => 'Accueil']) }}</a>
            <span>/</span>
            <a href="{{ route('account.dashboard') }}" class="hover:text-primary transition-colors">{{ __('account.title', ['default' => 'Mon Compte']) }}</a>
            <span>/</span>
            <a href="{{ route('account.orders.index') }}" class="hover:text-primary transition-colors">{{ __('orders.title') }}</a>
            <span>/</span>
            <span class="text-primary font-medium">#{{ $order->order_number }}</span>
        </nav>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Order Header Card -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-6 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-2xl sm:text-3xl font-black text-primary font-mono tracking-tight">{{ $order->order_number }}</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->status->badgeClasses() }}">
                            {{ $order->status->label(app()->getLocale()) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ __('orders.date') }}: <span class="font-medium text-gray-800">{{ $order->created_at->translatedFormat('d F Y à H:i') }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <!-- WhatsApp Support Direct Link -->
                    <a href="{{ $order->whatsapp_inquiry_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition-all">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>WhatsApp</span>
                    </a>

                    @if($order->canBeCancelled())
                        <form method="POST" action="{{ route('account.orders.cancel', $order->order_number) }}" onsubmit="return confirm('{{ __('orders.cancel_confirm') }}');">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold rounded-xl border border-rose-200 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ __('orders.cancel_order') }}</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Visual Progress Stepper -->
            <div class="pt-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">{{ __('orders.tracking_title') }}</h3>

                @if($order->status === \App\Enums\OrderStatus::CANCELLED)
                    <div class="bg-rose-50 border border-rose-200 rounded-xl p-5 text-rose-800 text-sm">
                        <div class="flex items-center gap-2 font-bold mb-1">
                            <svg class="w-5 h-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('orders.status') }} : {{ $order->status->label(app()->getLocale()) }}</span>
                        </div>
                        <p class="text-rose-700 text-xs">Cette commande a été annulée. Aucun prélèvement ni livraison n'aura lieu. Les articles ont été réintégrés dans l'inventaire.</p>
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

                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 relative">
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
                @endif
            </div>

            <!-- Shipment Courier Card if available -->
            @if($order->latestShipment)
                <div class="mt-8 p-4 rounded-xl bg-sky-50 border border-sky-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sky-900 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-sky-500 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-sky-950 block">{{ $order->latestShipment->carrier }}</span>
                            <span class="text-xs text-sky-700">{{ __('orders.tracking_code') }}: <strong class="font-mono text-sky-900">{{ $order->latestShipment->tracking_number }}</strong></span>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $order->latestShipment->status->badgeClasses() }}">
                        {{ $order->latestShipment->status->label(app()->getLocale()) }}
                    </span>
                </div>
            @endif
        </div>

        <!-- 2-Column Details Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Items Snapshot & Address (2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Items list -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-base font-bold text-primary mb-4 pb-3 border-b border-gray-100 flex items-center justify-between">
                        <span>{{ __('orders.items') }} ({{ $order->items_count }})</span>
                        <span class="text-xs text-gray-500 font-normal">MAD (د.م.)</span>
                    </h3>

                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="py-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-gray-50 border border-gray-200/80 rounded-xl flex items-center justify-center p-1 text-gray-400 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900">{{ $item->product_name }}</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">SKU: <span class="font-mono">{{ $item->sku }}</span></p>
                                        @if($item->variant_attributes)
                                            <div class="flex items-center gap-2 mt-1">
                                                @foreach($item->variant_attributes as $key => $val)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-gray-100 text-[10px] text-gray-600 font-medium">
                                                        {{ ucfirst($key) }}: {{ $val }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right rtl:text-left flex-shrink-0">
                                    <span class="text-xs text-gray-500 block">{{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}</span>
                                    <span class="text-sm font-bold text-primary">{{ number_format($item->total, 2) }} {{ $order->currency }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Moroccan Shipping Snapshot -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-base font-bold text-primary mb-4 pb-3 border-b border-gray-100">
                        {{ __('orders.delivery_address') }}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-xs text-gray-500 block">{{ __('orders.recipient') }}</span>
                            <span class="font-bold text-gray-900">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">{{ __('orders.phone') }}</span>
                            <span class="font-bold text-gray-900 font-mono">{{ $order->customer_phone }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">{{ __('orders.city') }}</span>
                            <span class="font-bold text-gray-900">{{ $order->shipping_city }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">Email</span>
                            <span class="font-medium text-gray-700">{{ $order->customer_email }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-xs text-gray-500 block">{{ __('orders.address') }}</span>
                            <span class="text-gray-800">{{ $order->shipping_address }}</span>
                        </div>
                        @if($order->shipping_notes)
                            <div class="sm:col-span-2 p-3 bg-amber-50 rounded-xl border border-amber-200/60 text-xs text-amber-900">
                                <span class="font-bold block mb-0.5">{{ __('orders.notes') }}:</span>
                                <span>{{ $order->shipping_notes }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Financials & Help (1 col) -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-base font-bold text-primary mb-4 pb-3 border-b border-gray-100">
                        {{ __('orders.order_summary') }}
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>{{ __('orders.subtotal') }}</span>
                            <span class="font-semibold text-gray-900">{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</span>
                        </div>

                        <div class="flex justify-between text-gray-600">
                            <span>{{ __('orders.shipping') }}</span>
                            @if($order->shipping_cost > 0)
                                <span class="font-semibold text-gray-900">{{ number_format($order->shipping_cost, 2) }} {{ $order->currency }}</span>
                            @else
                                <span class="font-bold text-emerald-600">{{ __('orders.free') }}</span>
                            @endif
                        </div>

                        @if($order->discount > 0)
                            <div class="flex justify-between text-emerald-600 font-semibold">
                                <span>Remise</span>
                                <span>-{{ number_format($order->discount, 2) }} {{ $order->currency }}</span>
                            </div>
                        @endif

                        <div class="pt-3 border-t border-gray-100 flex justify-between items-baseline">
                            <span class="font-bold text-gray-900">{{ __('orders.total_amount') }}</span>
                            <span class="text-xl font-black text-secondary">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                        </div>
                    </div>

                    <div class="mt-6 p-3 bg-gray-50 rounded-xl border border-gray-200/60 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-900 block">{{ __('orders.cod_badge') }}</span>
                            <span class="text-[11px] text-gray-500">Statut : {{ $order->payment_status->label(app()->getLocale()) }}</span>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Help Card -->
                <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-md">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </div>
                        <h4 class="font-bold text-base">Service Client Souqly</h4>
                    </div>
                    <p class="text-xs text-emerald-100 leading-relaxed mb-4">
                        Une question sur la livraison ? Notre équipe à Casablanca vous répond directement sur WhatsApp du lundi au samedi.
                    </p>
                    <a href="{{ $order->whatsapp_inquiry_url }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-emerald-800 font-bold text-xs rounded-xl hover:bg-emerald-50 transition-all shadow">
                        <span>Ouvrir WhatsApp</span>
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
