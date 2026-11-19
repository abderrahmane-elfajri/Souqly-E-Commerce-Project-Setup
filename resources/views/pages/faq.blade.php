@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('common.faq'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#C5A059] font-medium block mb-2">
                {{ app()->getLocale() === 'ar' ? 'مركز المساعدة والإرشادات' : (app()->getLocale() === 'en' ? 'Help & Guidance' : 'Guide & Assistance Client') }}
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-normal text-stone-900 tracking-tight mb-4">
                {{ __('common.faq') }}
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 max-w-xl mx-auto font-light leading-relaxed">
                {{ app()->getLocale() === 'ar'
                    ? 'كل ما تحتاج معرفته حول الشحن بالمغرب، الدفع عند الاستلام، وفحص المنتجات قبل الاستلام.'
                    : 'Toutes les réponses à vos questions concernant la commande, la livraison express au Maroc, le paiement COD et notre garantie d\'authenticité.' }}
            </p>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-6">
            
            <!-- Item 1: COD -->
            <div class="bg-white border border-stone-200/80 p-8 shadow-xs">
                <h3 class="font-serif text-lg sm:text-xl font-normal text-stone-900 mb-3 flex items-center gap-3">
                    <span class="text-[#C5A059] font-sans font-medium text-sm">01.</span>
                    <span>
                        {{ app()->getLocale() === 'ar'
                            ? 'كيف يعمل الدفع عند الاستلام (Cash on Delivery)؟'
                            : 'Comment fonctionne le Paiement à la Livraison (Cash on Delivery) ?' }}
                    </span>
                </h3>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar'
                        ? 'في سوقلي، لن تدفع أي درهم مسبقاً. عند إتمام طلبك، يقوم فريقنا بتجهيز شحنتك وإرسالها مع مندوب التوصيل المعتمد. تقوم بفحص الطرد والتأكد من مطابقته، ثم تسلم المبلغ نقداً للمندوب.'
                        : 'Chez SOUQLY, aucun paiement préalable par carte bancaire n\'est requis. Vous passez votre commande en ligne, notre conciergerie la prépare et l\'expédie via nos transporteurs partenaires. À l\'arrivée du coursier, vous inspectez le colis et réglez le montant exact en espèces.' }}
                </p>
            </div>

            <!-- Item 2: Delivery & Cities -->
            <div class="bg-white border border-stone-200/80 p-8 shadow-xs">
                <h3 class="font-serif text-lg sm:text-xl font-normal text-stone-900 mb-3 flex items-center gap-3">
                    <span class="text-[#C5A059] font-sans font-medium text-sm">02.</span>
                    <span>
                        {{ app()->getLocale() === 'ar'
                            ? 'ما هي المدن المشمولة بالتوصيل وما هي الآجال؟'
                            : 'Quelles sont les villes desservies et les délais de livraison au Maroc ?' }}
                    </span>
                </h3>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar'
                        ? 'نوصل لجميع المدن المغربية (الدار البيضاء، الرباط، مراكش، طنجة، فاس، أكادير، مكناس، وجدة، القنيطرة، تطوان وغيرها). التوصيل يتم خلال 24 إلى 48 ساعة كحد أقصى.'
                        : 'Nous couvrons l\'ensemble du Royaume du Maroc grâce à notre réseau national de transporteurs express (Amana, Cathedis, Ozone). Les livraisons sur le Grand Casablanca et Rabat s\'effectuent sous 24h, et sous 24h à 48h ouvrées pour les autres régions (Marrakech, Tanger, Fès, Agadir, etc.).' }}
                </p>
            </div>

            <!-- Item 3: Inspection at door -->
            <div class="bg-white border border-stone-200/80 p-8 shadow-xs">
                <h3 class="font-serif text-lg sm:text-xl font-normal text-stone-900 mb-3 flex items-center gap-3">
                    <span class="text-[#C5A059] font-sans font-medium text-sm">03.</span>
                    <span>
                        {{ app()->getLocale() === 'ar'
                            ? 'هل يمكنني فحص ومعاينة المنتج قبل الدفع للمندوب؟'
                            : 'Puis-je ouvrir et inspecter le colis avant de régler le livreur ?' }}
                    </span>
                </h3>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar'
                        ? 'نعم بكل تأكيد. تضمن سوقلي لجميع عملائها حق فتح ومعاينة المنتج بحضور مندوب التوصيل للتأكد من سلامته ومطابقته لطلبكم قبل تسليم المبلغ.'
                        : 'Absolument. Conformément à notre charte de confiance SOUQLY, vous avez le droit d\'ouvrir le colis et de vérifier l\'intégrité de vos articles en présence du livreur avant d\'effectuer le règlement en espèces.' }}
                </p>
            </div>

            <!-- Item 4: Free shipping -->
            <div class="bg-white border border-stone-200/80 p-8 shadow-xs">
                <h3 class="font-serif text-lg sm:text-xl font-normal text-stone-900 mb-3 flex items-center gap-3">
                    <span class="text-[#C5A059] font-sans font-medium text-sm">04.</span>
                    <span>
                        {{ app()->getLocale() === 'ar'
                            ? 'كم تبلغ تكاليف التوصيل؟ ومتى يكون الشحن مجانياً؟'
                            : 'Quel est le montant des frais de livraison ? Comment bénéficier de la livraison gratuite ?' }}
                    </span>
                </h3>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar'
                        ? 'رسوم التوصيل محددة في 30 درهم مغربي لجميع المدن. كما نوفر التوصيل المجاني بالكامل لأي طلب بقيمة 500 درهم أو أكثر.'
                        : 'Les frais de livraison sont forfaitaires et s\'élèvent à 30,00 MAD pour toute commande sur l\'ensemble du territoire marocain. La livraison devient 100% offerte et gratuite pour toute commande d\'un montant égal ou supérieur à 500,00 MAD.' }}
                </p>
            </div>

            <!-- Item 5: Tracking & WhatsApp -->
            <div class="bg-white border border-stone-200/80 p-8 shadow-xs">
                <h3 class="font-serif text-lg sm:text-xl font-normal text-stone-900 mb-3 flex items-center gap-3">
                    <span class="text-[#C5A059] font-sans font-medium text-sm">05.</span>
                    <span>
                        {{ app()->getLocale() === 'ar'
                            ? 'كيف أتتبع شحنتي أو أتواصل مع خدمة العملاء؟'
                            : 'Comment suivre ma commande et contacter le service client ?' }}
                    </span>
                </h3>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    {{ app()->getLocale() === 'ar'
                        ? 'يمكنك تتبع شحنتك مباشرة عبر صفحة "تتبع الطلب" بإدخال رقم الطلب ورقم هاتفك، أو عبر التواصل المباشر مع خدمة العملاء عبر واتساب 7/7.'
                        : 'Vous pouvez suivre l\'acheminement en temps réel via notre page de suivi public (/track) à l\'aide de votre numéro de commande et numéro de téléphone, ou en échangeant directement avec notre conciergerie privée via WhatsApp disponible 7j/7.' }}
                </p>
            </div>

        </div>

        <!-- Help Banner -->
        <div class="mt-14 p-8 bg-[#0B1320] text-white border border-stone-800 text-center">
            <h4 class="font-serif text-xl sm:text-2xl font-normal text-stone-100 mb-2">
                {{ app()->getLocale() === 'ar' ? 'هل لديك سؤال إضافي؟' : 'Une question spécifique ?' }}
            </h4>
            <p class="text-xs text-stone-400 font-light max-w-md mx-auto mb-6">
                {{ app()->getLocale() === 'ar' ? 'فريق خدمة الزبناء رهن إشارتكم طيلة أيام الأسبوع للإجابة على كافة تساؤلاتكم.' : 'Notre conciergerie est à votre écoute pour vous conseiller et vous accompagner dans votre commande.' }}
            </p>
            <a 
                href="https://wa.me/212600000000?text={{ rawurlencode('Bonjour Souqly, j\'ai une question qui ne figure pas dans la FAQ.') }}" 
                target="_blank"
                class="inline-flex items-center gap-2.5 px-6 py-3.5 bg-emerald-800 hover:bg-emerald-900 text-white text-[11px] uppercase tracking-[0.2em] font-semibold transition"
            >
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.592 2.654-.696c1.004.577 1.764.846 2.806.847h.005c3.182 0 5.768-2.587 5.768-5.768z"/></svg>
                <span>{{ __('common.whatsapp_concierge') }}</span>
            </a>
        </div>

    </div>
</div>
@endsection
