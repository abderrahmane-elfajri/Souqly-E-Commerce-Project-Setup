<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['fr', 'ar', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.switch');

// Language-prefixed route group example for SEO & canonical URLs
Route::prefix('{locale}')
    ->where(['locale' => 'fr|ar|en'])
    ->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });
    });
