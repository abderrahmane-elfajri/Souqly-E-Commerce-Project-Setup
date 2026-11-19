<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display login page.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle user authentication.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => __('auth.failed'),
                ]);
        }

        $user = Auth::user();

        if (! $user->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => __('auth.account_suspended', ['default' => 'Votre compte est temporairement suspendu. Contactez le support.']),
            ]);
        }

        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', __('auth.welcome_back_admin', ['name' => $user->name, 'default' => "Bienvenue sur l'espace d'administration, {$user->name}."]));
        }

        return redirect()->intended(route('account.dashboard'))
            ->with('success', __('auth.welcome_back', ['name' => $user->name, 'default' => "Bienvenue {$user->name}."]));
    }

    /**
     * Display registration page.
     */
    public function showRegister(): View
    {
        $moroccanCities = [
            'Casablanca', 'Rabat', 'Marrakech', 'Tanger', 'Fès', 'Agadir',
            'Meknès', 'Oujda', 'Kénitra', 'Tétouan', 'Safi', 'Mohammédia',
            'El Jadida', 'Nador', 'Béni Mellal', 'Témara', 'Salé'
        ];

        return view('auth.register', compact('moroccanCities'));
    }

    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => UserRole::CUSTOMER,
            'status' => 'active',
        ]);

        // Create initial default shipping address
        Address::create([
            'user_id' => $user->id,
            'full_name' => $validated['name'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'address' => $validated['address'] ?? $validated['city'],
            'is_default' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('account.dashboard')
            ->with('success', __('auth.registration_success', ['default' => 'Votre compte SOUQLY a été créé avec succès !']));
    }

    /**
     * Destroy user session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', __('auth.logged_out', ['default' => 'Vous avez été déconnecté avec succès.']));
    }
}
