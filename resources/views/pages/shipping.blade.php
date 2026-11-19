@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('common.shipping_policy'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#C5A059] font-medium block mb-2">
                {{ app()->getLocale() === 'ar' ? 'اللوجستيك والتوصيل بالمغرب' : (app()->getLocale() === 'en' ? 'Logistics & Nationwide Delivery' : 'Logistique & Expédition Nationale') }}
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-normal text-stone-900 tracking-tight mb-4">
                {{ __('common.shipping_policy') }}
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 max-w-xl mx-auto font-light leading-relaxed">
                {{ app()->getLocale() === 'ar'
                    ? 'شحن سريع، آمن وموثوق لكافة أنحاء المملكة المغربية بشراكة مع أفضل شركات التوصيل الوطنية.'
                    : 'Un service de livraison sur-mesure opéré par les meilleurs transporteurs express du Royaume du Maroc, avec contrôle qualité à la réception.' }}
            </p>
        </div>

        <div class="bg-white border border-stone-200/80 p-8 sm:p-12 space-y-10 shadow-xs">
            
            <!-- Section 1: Zones & Carriers -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80 flex items-center justify-between">
                    <span>1. {{ app()->getLocale() === 'ar' ? 'شبكة التوزيع وشركاء التوصيل' : 'Réseau de Distribution & Transporteurs Partenaires' }}</span>
                    <span class="text-xs font-mono font-medium text-[#C5A059]">24h - 48h</span>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed mb-4">
                    {{ app()->getLocale() === 'ar'
                        ? 'تتعاون سوقلي مع نخبة شركات الشحن السريع في المغرب، وعلى رأسها أمانة إكسبريس (بريد المغرب)، كاثيديس (Cathedis)، وأوزون إكسبريس (Ozone Express) لتغطية أكثر من 200 مدينة وقرية مغربية.'
                        : 'SOUQLY s\'appuie sur un réseau logistique national d\'excellence comprenant Amana Express (Poste Maroc), Cathedis Express et Ozone Express. Nous assurons une couverture intégrale de plus de 200 villes et centres urbains au Maroc.' }}
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="p-4 bg-[#FAF8F5] border border-stone-200 text-center">
                        <div class="font-serif text-base text-stone-900 mb-1">Amana Express</div>
                        <span class="text-[10px] uppercase tracking-wider text-stone-500 font-medium">Poste Maroc</span>
                    </div>
                    <div class="p-4 bg-[#FAF8F5] border border-stone-200 text-center">
                        <div class="font-serif text-base text-stone-900 mb-1">Cathedis</div>
                        <span class="text-[10px] uppercase tracking-wider text-stone-500 font-medium">National Network</span>
                    </div>
                    <div class="p-4 bg-[#FAF8F5] border border-stone-200 text-center">
                        <div class="font-serif text-base text-stone-900 mb-1">Ozone Express</div>
                        <span class="text-[10px] uppercase tracking-wider text-stone-500 font-medium">Urgent Same-Day</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Tarifs -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    2. {{ app()->getLocale() === 'ar' ? 'تعرفة التوصيل والشحن المجاني' : 'Tarifs Forfaitaires & Gratuité de Livraison' }}
                </h2>
                <div class="space-y-3 text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    <p>
                        {{ app()->getLocale() === 'ar'
                            ? '• تعرفة موحدة: 30 درهم مغربي لكافة الطلبيات العادية داخل المغرب.'
                            : '• Tarif standard : Forfait unique de 30,00 MAD pour toute expédition sur le territoire national.' }}
                    </p>
                    <p>
                        {{ app()->getLocale() === 'ar'
                            ? '• شحن مجاني 100%: تستفيد من التوصيل المجاني بالكامل عند بلوغ مجموع مشترياتك 500 درهم أو أكثر.'
                            : '• Livraison offerte : Gratuite pour toute commande d\'un montant supérieur ou égal à 500,00 MAD.' }}
                    </p>
                </div>
            </div>

            <!-- Section 3: Inspection at door -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    3. {{ app()->getLocale() === 'ar' ? 'معاينة الطرد عند التسليم' : 'Droit de Contrôle & Inspection à la Réception' }}
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar'
                        ? 'تلتزم سوقلي بمبدأ الثقة والشفافية التامة: يحق للزبون فتح الطرد ومعاينة محتوياته بحضور مندوب التوصيل قبل أداء المبلغ نقداً. في حالة وجود أي عيب أو عدم مطابقة، يمكنك رفض الاستلام دون أي مصاريف.'
                        : 'Dans le cadre de notre engagement d\'excellence et de protection du consommateur marocain (Loi 31-08), vous bénéficiez du droit légitime d\'ouvrir et de contrôler votre colis en présence du livreur avant de régler le montant COD.' }}
                </p>
            </div>

            <!-- Section 4: Live tracking -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    4. {{ app()->getLocale() === 'ar' ? 'تتبع مسار الشحنة' : 'Suivi en Temps Réel' }}
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed mb-4">
                    {{ app()->getLocale() === 'ar'
                        ? 'بمجرد شحن طلبيتك، تتوصل برقم تتبع خاص يتيح لك معرفة مسار طردك عبر بوابتنا الإلكترونية أو التواصل مع مندوب التوصيل مباشرة.'
                        : 'Dès la prise en charge par notre transporteur, un numéro de suivi unique vous est attribué. Vous pouvez géolocaliser l\'avancement de votre commande à tout moment via notre portail de suivi dédié.' }}
                </p>
                <a href="{{ route('track') }}" class="btn-primary text-[10px] uppercase tracking-[0.2em] px-6 py-3 font-semibold inline-block">
                    <span>{{ __('orders.public_tracking') }} &rarr;</span>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
