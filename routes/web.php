<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\OrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Store\CatalogController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\TrackingController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes — SOUQLY
|--------------------------------------------------------------------------
*/

// Public Storefront & Homepage
Route::get('/', function () {
    $featuredProducts = Product::active()
        ->featured()
        ->with(['translations', 'category.translations'])
        ->take(4)
        ->get();

    $categories = Category::active()
        ->with('translations')
        ->orderBy('sort_order')
        ->get();

    return view('welcome', compact('featuredProducts', 'categories'));
})->name('home');

// Catalog & Product Details
Route::get('/shop', [CatalogController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('product.show');

// Public Parcel & Order Tracking
Route::get('/track', [TrackingController::class, 'show'])->name('track');
Route::post('/track', [TrackingController::class, 'track'])->name('track.search');

// Shopping Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
});

// Language Switcher
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['fr', 'ar', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.switch');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Customer Space
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('password.update');
        
        // Orders & Tracking
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    });

    // Admin Protected Suite (Requires 'admin' or 'super_admin' role)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});
