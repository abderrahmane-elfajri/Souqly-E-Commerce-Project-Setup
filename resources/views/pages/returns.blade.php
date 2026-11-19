@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('common.return_policy'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#C5A059] font-medium block mb-2">
                {{ app()->getLocale() === 'ar' ? 'الضمان ورضا العملاء' : (app()->getLocale() === 'en' ? 'Guarantee & Customer Satisfaction' : 'Garantie & Satisfaction Client') }}
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-normal text-stone-900 tracking-tight mb-4">
                {{ __('common.return_policy') }}
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 max-w-xl mx-auto font-light leading-relaxed">
                {{ app()->getLocale() === 'ar'
                    ? 'سياسة استبدال واسترجاع مرنة وسريعة تضمن حقوقك بالكامل وفقاً للقانون المغربي لحماية المستهلك.'
                    : 'Une procédure de retour et d\'échange claire, équitable et sans friction, conçue pour vous offrir une sérénité totale lors de chaque acquisition.' }}
            </p>
        </div>

        <div class="bg-white border border-stone-200/80 p-8 sm:p-12 space-y-10 shadow-xs">
            
            <!-- Section 1: Window -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80 flex items-center justify-between">
                    <span>1. {{ app()->getLocale() === 'ar' ? 'أجل الإرجاع والاستبدال (7 أيام)' : 'Délai de Rétractation (7 Jours)' }}</span>
                    <span class="text-xs font-mono font-medium text-[#C5A059]">7 Jours Ouvrés</span>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar'
                        ? 'يحق لك طلب استبدال أو إرجاع أي منتج تم شراؤه عبر سوقلي خلال مدة 7 أيام من تاريخ استلام الطرد، شريطة أن يكون المنتج في حالته الأصلية، غير مستعمل وفي علبته الأصلية مع كافة الملحقات.'
                        : 'Conformément aux dispositions de la Loi marocaine N° 31-08 édictant des mesures de protection du consommateur, vous disposez d\'un délai légal de 7 (sept) jours ouvrés à compter de la réception de votre commande pour exercer votre droit de rétractation ou demander un échange.' }}
                </p>
            </div>

            <!-- Section 2: Conditions -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    2. {{ app()->getLocale() === 'ar' ? 'شروط قبول الإرجاع' : 'Conditions d\'Éligibilité au Retour' }}
                </h2>
                <ul class="space-y-2 text-xs sm:text-sm text-stone-600 font-light leading-relaxed list-disc list-inside">
                    <li>{{ app()->getLocale() === 'ar' ? 'أن يكون المنتج غير مستخدم ومحتفظاً ببطاقات المصنع والملصقات الأصلية.' : 'L\'article doit être rigoureusement neuf, non porté, non utilisé et exempt de toute altération.' }}</li>
                    <li>{{ app()->getLocale() === 'ar' ? 'أن يتم إرجاعه في علبته وتغليفه الأصلي مع كافة الإكسسوارات وشهادات الضمان.' : 'L\'emballage d\'origine, l\'écrin, les livrets de garantie et tous les accessoires doivent être restitués intacts.' }}</li>
                    <li>{{ app()->getLocale() === 'ar' ? 'إرفاق وصل الاستلام أو رقم الطلب المسجل لدى سوقلي.' : 'La référence de commande (ex: SQL-202611-CAS01) doit accompagner le colis de retour.' }}</li>
                </ul>
            </div>

            <!-- Section 3: Process via WhatsApp -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    3. {{ app()->getLocale() === 'ar' ? 'كيفية تقديم طلب الإرجاع أو الاستبدال' : 'Procédure Simplifiée via Conciergerie WhatsApp' }}
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed mb-4">
                    {{ app()->getLocale() === 'ar'
                        ? 'لتسهيل الإجراءات، يكفي التواصل مع خدمة العملاء عبر واتساب مع ذكر رقم الطلب وسبب الإرجاع مع صورة للمنتج. سيقوم فريقنا ببرمجة مرور مندوب التوصيل لاستلام الطرد من عنوانك.'
                        : 'Pour une prise en charge immédiate, contactez simplement notre service client via WhatsApp avec votre numéro de commande et le motif du retour. Nous mandatons un coursier pour récupérer le colis à votre domicile sans démarche complexe.' }}
                </p>
                <a 
                    href="https://wa.me/212600000000?text={{ rawurlencode('Bonjour Souqly, je souhaite effectuer un échange ou retour pour ma commande.') }}" 
                    target="_blank"
                    class="btn-primary text-[10px] uppercase tracking-[0.2em] px-6 py-3 font-semibold inline-block"
                >
                    <span>💬 {{ __('common.whatsapp_concierge') }} &rarr;</span>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
