<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\payment\PayMobController;
use App\Http\Controllers\payment\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ?todo paymob 
Route::get('/checkout/processed', [PayMobController::class, 'checkout_process'])->name('checkout.processed');

Route::get("/checkout", [CheckoutController::class, "checkout"])->name("checkout");
Route::get("checkout/response", function (Request $request) {
    return $request->all();
});