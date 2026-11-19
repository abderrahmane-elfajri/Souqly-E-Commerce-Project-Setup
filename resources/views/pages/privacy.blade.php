@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('common.privacy'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#C5A059] font-medium block mb-2">
                {{ app()->getLocale() === 'ar' ? 'حماية المعطيات الشخصية (CNDP)' : (app()->getLocale() === 'en' ? 'Data Privacy & CNDP Compliance' : 'Protection des Données & Conformité CNDP') }}
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-normal text-stone-900 tracking-tight mb-4">
                {{ __('common.privacy') }}
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 max-w-xl mx-auto font-light leading-relaxed">
                {{ app()->getLocale() === 'ar'
                    ? 'التزام تام بحماية بياناتك الشخصية وسريتها وفقاً للقانون المغربي 09-08 الصادر عن اللجنة الوطنية لمراقبة حماية المعطيات ذات الطابع الشخصي.'
                    : 'Notre engagement absolu pour la confidentialité et la sécurisation de vos données personnelles, en stricte conformité avec la Loi marocaine N° 09-08.' }}
            </p>
        </div>

        <div class="bg-white border border-stone-200/80 p-8 sm:p-12 space-y-10 shadow-xs text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
            
            <!-- Section 1 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    1. Conformité à la Loi 09-08 & CNDP
                </h2>
                <p>
                    Les informations recueillies sur le site <strong>SOUQLY</strong> font l'objet d'un traitement destiné exclusivement à la gestion, au traitement et à l'expédition de vos commandes au Maroc. Ce traitement est conforme aux dispositions de la <strong>Loi N° 09-08</strong> relative à la protection des personnes physiques à l'égard du traitement des données à caractère personnel, sous l'égide de la Commission Nationale de Contrôle de la Protection des Données à Caractère Personnel (<strong>CNDP</strong>).
                </p>
            </div>

            <!-- Section 2 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    2. Données Collectées & Finalités
                </h2>
                <p class="mb-3">
                    Dans le cadre de l'utilisation de nos services, nous collectons uniquement les données strictement nécessaires au bon acheminement de votre colis :
                </p>
                <ul class="space-y-1.5 list-disc list-inside">
                    <li>Nom et prénom du destinataire</li>
                    <li>Numéro de téléphone marocain (nécessaire à la prise de contact par le coursier)</li>
                    <li>Adresse complète de livraison et ville de destination</li>
                    <li>Adresse e-mail pour l'envoi de la confirmation et des récapitulatifs de commande</li>
                </ul>
            </div>

            <!-- Section 3 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    3. Non-Divulgation & Sécurité Absolue
                </h2>
                <p>
                    SOUQLY ne commercialise, ne loue, ni ne cède aucune donnée personnelle à des tiers à des fins publicitaires. Vos coordonnées de livraison sont exclusivement partagées avec notre transporteur officiel mandaté (Amana, Cathedis ou Ozone) dans l'unique but de finaliser la remise en main propre de votre commande.
                </p>
            </div>

            <!-- Section 4 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    4. Droit d'Accès, de Rectification et de Suppression
                </h2>
                <p>
                    Conformément à la Loi 09-08, vous disposez d'un droit d'accès, de rectification et d'opposition sur les données vous concernant. Vous pouvez exercer ce droit à tout moment depuis votre espace client (/account) ou en nous contactant directement par e-mail à <strong>contact@souqly.ma</strong> ou via notre conciergerie WhatsApp.
                </p>
            </div>

        </div>

    </div>
</div>
@endsection
