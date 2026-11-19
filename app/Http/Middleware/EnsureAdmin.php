<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login')->with('error', __('auth.admin_login_required', ['default' => 'Veuillez vous connecter pour accéder à l\'administration.']));
        }

        if (! $request->user()->isAdmin()) {
            abort(403, __('auth.unauthorized_admin', ['default' => 'Accès refusé : espace réservé aux administrateurs.']));
        }

        return $next($request);
    }
}
