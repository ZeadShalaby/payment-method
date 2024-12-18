<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PayMobController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\HyperpayController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\PaymobsController;

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
Route::get('/checkout/{payment_method}/{integration_id}/{order_id}/{wallet_or_iframe}', [PaymobsController::class, 'checkingOut']);


// ! Fatoorah Payment //
Route::POST('/myfatoorah/pay', [MyFatoorahController::class, 'pay'])->name('myfatoorah.index');
Route::get('/myfatoorah/callback', [MyFatoorahController::class, 'callback'])->name('myfatoorah.callback');

// ! Stripe Payment //
Route::get('/payment/stripe/link', [StripeController::class, 'getPaymentLink'])->name('payment.stripe.link');
Route::get('/payment/view', [StripeController::class, 'index'])->name('payment.stripe.index');
Route::POST('/payment/stripe', [StripeController::class, 'stripe'])->name('payment.stripe');


// ! Paymob Payment //
Route::post('/paymob/order', [PayMobController::class, 'createOrder']);
Route::post('/paymob/callback', [PayMobController::class, 'paymentCallback']);



//! event listener
Route::POST('/Event/Listeners', [EventController::class, 'index'])->name('Event.ındex');

