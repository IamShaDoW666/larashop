<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Stripelinks\Http\Controllers\Main;


Route::group([], function () {
    Route::prefix('stripelinks')->group(function () {
        Route::get('/success/{ordermd}', [Main::class, 'success'])->name('stripelinks.success');
        Route::get('/cancel/{ordermd}', [Main::class, 'cancel'])->name('stripelinks.cancel');
        Route::get('/payment-success/{paymentmd}', 'Main@paymentSuccess')->name('stripelinks.paymentsuccess');
        Route::get('/payment-cancel/{paymentmd}', 'Main@paymentCancel')->name('stripelinks.paymentcancel');
    });
});
