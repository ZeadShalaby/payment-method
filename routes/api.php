<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\HyperpayController;
use App\Http\Controllers\MyFatoorahController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ! PayPal Payment //
Route::get('/payment/paypal', [PayPalController::class, 'paypal'])->name('payment.paypal');
Route::post('/payment/paypal/cancel', [PayPalController::class, 'cancel'])->name('payment.cancel');
Route::get('/payment/paypal/success', [PayPalController::class, 'success'])->name('payment.success');

// ! Hyperpay Payment //
Route::get('/payment/hyperpay/{price}', [HyperpayController::class, 'hyperpay'])->name('payment.hyperpay');
Route::post('/payment/hyperpay/cancel', [HyperpayController::class, 'cancel'])->name('payment.hyperpay.cancel');
Route::get('/payment/hyperpay/success', [HyperpayController::class, 'success'])->name('payment.hyperpay.success');


// ! Fatoorah Payment //
Route::POST('myfatoorah/pay', [MyFatoorahController::class, 'pay'])->name('myfatoorah.index');
Route::get('myfatoorah/callback', [MyFatoorahController::class, 'callback'])->name('myfatoorah.callback');

// ! Stripe Payment //
Route::get('/payment/hyperpay', [StripeController::class, 'hyperpay'])->name('payment.hyperpay');
Route::post('/payment/hyperpay/cancel', [StripeController::class, 'cancel'])->name('payment.hyperpay.cancel');
Route::get('/payment/hyperpay/success', [StripeController::class, 'success'])->name('payment.hyperpay.success');