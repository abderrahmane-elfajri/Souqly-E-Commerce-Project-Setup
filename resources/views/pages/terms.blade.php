@extends('layouts.app')

@section('title', 'SOUQLY — ' . __('common.terms'))

@section('content')
<div class="py-16 sm:py-20 bg-[#FAF8F5] min-h-[75vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#C5A059] font-medium block mb-2">
                {{ app()->getLocale() === 'ar' ? 'الإطار القانوني والتنظيمي' : (app()->getLocale() === 'en' ? 'Legal Framework' : 'Cadre Juridique & Réglementaire') }}
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-normal text-stone-900 tracking-tight mb-4">
                {{ __('common.terms') }}
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 max-w-xl mx-auto font-light leading-relaxed">
                {{ app()->getLocale() === 'ar'
                    ? 'الشروط والأحكام العامة المنظمة للتعاملات وعمليات البيع والشراء عبر منصة سوقلي بالمملكة المغربية.'
                    : 'Conditions Générales de Vente régissant les transactions commerciales sur la plateforme SOUQLY, en conformité avec la législation marocaine.' }}
            </p>
        </div>

        <div class="bg-white border border-stone-200/80 p-8 sm:p-12 space-y-10 shadow-xs text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
            
            <!-- Article 1 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    Article 1 — Mentions Légales & Identification
                </h2>
                <p>
                    La plateforme <strong>SOUQLY</strong> est éditée et exploitée par la société SOUQLY SARL, immatriculée au Registre du Commerce de Casablanca sous le N° 542190, Patente N° 4983210, Identifiant Commun de l'Entreprise (ICE) : 002938475000082, Siège Social : Boulevard d'Anfa, Casablanca, Maroc.
                </p>
            </div>

            <!-- Article 2 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    Article 2 — Conformité à la Loi 31-08 (Protection du Consommateur)
                </h2>
                <p>
                    Les présentes conditions générales de vente sont régies par le droit marocain, notamment la <strong>Loi N° 31-08</strong> édictant des mesures de protection du consommateur. Toute commande passée sur SOUQLY implique l'adhésion entière et sans réserve du client aux présentes stipulations.
                </p>
            </div>

            <!-- Article 3 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    Article 3 — Prix & Devise Officielle
                </h2>
                <p>
                    Tous les prix figurant sur la plateforme sont libellés en <strong>Dirhams Marocains (MAD / د.م.)</strong>, toutes taxes comprises (TTC). SOUQLY se réserve le droit de modifier ses prix à tout moment, étant toutefois entendu que le prix figurant sur la commande au moment de la validation sera le seul applicable à l'acheteur.
                </p>
            </div>

            <!-- Article 4 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    Article 4 — Modalités de Règlement (Cash on Delivery)
                </h2>
                <p>
                    Le mode de règlement principal proposé est le <strong>Paiement à la Livraison (Cash on Delivery)</strong>. Le client s'engage à régler le montant exact en espèces auprès du transporteur mandaté lors de la remise physique du colis.
                </p>
            </div>

            <!-- Article 5 -->
            <div>
                <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-normal mb-3 pb-3 border-b border-stone-200/80">
                    Article 5 — Litiges & Juridiction Compétente
                </h2>
                <p>
                    En cas de différend relatif à l'interprétation ou à l'exécution des présentes conditions, une solution amiable sera recherchée en priorité via notre conciergerie. À défaut, les tribunaux compétents de <strong>Casablanca</strong> seront seuls habilités à trancher le litige.
                </p>
            </div>

        </div>

    </div>
</div>
@endsection
