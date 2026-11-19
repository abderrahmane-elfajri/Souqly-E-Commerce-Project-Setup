<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Show customer account dashboard.
     */
    public function dashboard(): View
    {
        $user = Auth::user()->load('addresses');
        $defaultAddress = $user->defaultAddress;
        $recentOrders = $user->orders()->with(['items', 'latestShipment'])->latest()->take(5)->get();

        return view('account.dashboard', compact('user', 'defaultAddress', 'recentOrders'));
    }

    /**
     * Update customer profile info.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^(?:(?:\+|00)212|0)[5-7]\d{8}$/'],
        ]);

        $user->update($validated);

        return back()->with('success', __('account.profile_updated', ['default' => 'Vos informations ont été mises à jour avec succès.']));
    }

    /**
     * Update customer password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', __('account.password_updated', ['default' => 'Votre mot de passe a été modifié avec succès.']));
    }
}
