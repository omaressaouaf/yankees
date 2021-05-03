<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WebhookController;

// use Akaunting\Setting\Facade as Setting;



Route::group(['middleware' => "setLocale"], function () {

    //  locale
    Route::get('/setLocale/{locale}', function (Request $request, $locale) {
        if (in_array($locale, config('app.available_locales'))) {
            session()->put('locale', $locale);
        }
        return back();
    });
    // Public
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');

    // Meals
    Route::resource('meals', MealController::class)->only(['index']);

    // Cart
    Route::get('/cart/destroyAll', [CartController::class, 'destroyAll']);
    Route::resource('cart', CartController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::group(['middleware' => "auth"], function () {
        //  Account
        Route::get('/account/dashboard', [AccountController::class,  'dashboard'])->name('account.dashboard');
        Route::get('/account/profile', [AccountController::class,  'profile'])->name('account.profile');
        Route::get('/account/orders', [AccountController::class,  'orders'])->name('account.orders');
        Route::get('/account/addresses', [AccountController::class,  'addresses'])->name('account.addresses');

        // checkout
        Route::resource('checkout', CheckoutController::class)->only(['index', 'store']);
    });

    // Webhook
    Route::post(
        '/stripe/webhook',
        [WebhookController::class, 'handleWebhook']
    );
    // Auth
    Auth::routes();
    // Admin
    Route::get(
        '/admin/{path}',
        function () {
            return view('layouts.admin');
        }
    )->name('admin')->middleware(['auth', 'roles:deliveryman,admin'])->where('path', '([A-z\d\-\/_.]+)?');
    // Route::redirect('/admin', '/admin/dashboard');


});
