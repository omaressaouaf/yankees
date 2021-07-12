<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MealController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ExtraController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\NotificationController;

Route::group(['middleware' => "setLocale"], function () {

    // categories index route should be public for the user in order to filter
    Route::get('/categories', [CategoryController::class, 'index']);


    Route::group(['middleware' => ['auth:sanctum']], function () {
        // Addresses
        Route::resource('/addresses', AddressController::class)->only(['index', 'store', 'destroy']);
        // Notifications
        Route::delete('notifications', [NotificationController::class, 'deleteNotifications']);
        Route::put('notifications', [NotificationController::class, 'markNotifications']);
        Route::get('notifications', [NotificationController::class, 'getNotifications']);


        Route::group(['middelware' => 'roles:admin,manager,deliveryman'], function () {
            //Some order routes are Accessible for admin and deliveryman
            Route::get('orders', [OrderController::class, 'index']);
            Route::get('orders/{order}', [OrderController::class, 'show']);
            Route::put('orders/{order}', [OrderController::class, 'update']);
        });
        Route::group(['middleware' =>  'roles:admin,manager'], function () {
            // Dashboard
            Route::get('/dashboard/search',  [DashboardController::class, 'globalSearch']);
            Route::get('/dashboard/count',  [DashboardController::class, 'count']);
            Route::get('/dashboard/charts',   [DashboardController::class, 'charts']);

            // users
            Route::get('/users/roles', [UserController::class, 'getRoles']);
            Route::get('/users/deliverymen', [UserController::class, 'getDeliverymen']);
            Route::delete('/users/bulk/{ids}', [UserController::class, 'bulk_destroy']);
            Route::apiResource('users', UserController::class);

            // categories
            Route::delete('/categories/bulk/{ids}', [CategoryController::class, 'bulk_destroy']);
            Route::put('/categories/updateOrders' , [CategoryController::class , 'updateOrders']);
            Route::apiResource('categories', CategoryController::class)->except(['index']);

            // extras
            Route::delete('/extras/bulk/{ids}', [ExtraController::class, 'bulk_destroy']);
            Route::apiResource('extras', ExtraController::class);

            // meals
            Route::delete('/meals/bulk/{ids}', [MealController::class, 'bulk_destroy']);
            Route::apiResource('meals', MealController::class);


            // Orders
            Route::put('/orders/refund/{order}', [OrderController::class, 'refundUser']);
            Route::put('/orders/charge/{order}', [OrderController::class, 'chargeUser']);
            Route::delete('/orders/bulk/{ids}', [OrderController::class, 'bulk_destroy']);
            Route::delete('orders/{order}', [OrderController::class, 'destroy']);


            // Sections (CMS)
            Route::apiResource('sections', SectionController::class)->only(['index', 'update']);


            // Settings
            Route::get('/settings', [SettingController::class, 'index']);
            Route::post('/settings/app', [SettingController::class, 'app']);
            Route::post('/settings/delivery', [SettingController::class, 'delivery']);
            Route::post('/settings/cart', [SettingController::class, 'cart']);
            Route::post('/settings/schedule', [SettingController::class, 'schedule']);
            Route::post('/settings/payment', [SettingController::class, 'payment']);
        });
    });
});
