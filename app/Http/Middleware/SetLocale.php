<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['fr', 'ar', 'en'];
        $locale = $request->segment(1);

        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } elseif (Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale(config('app.locale', 'fr'));
        }

        return $next($request);
    }
}
