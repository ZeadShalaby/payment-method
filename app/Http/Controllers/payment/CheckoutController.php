<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $payment_key = PayMobController::pay(100, uniqid());
        return view('paymob.index')->with('token', $payment_key);
    }
}
