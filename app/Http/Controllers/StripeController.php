<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    //
    /**
     * todo Paypal Method */
    public function stripe()
    {


    }


    /**
     * todo Cancel Operation */
    public function cancel()
    {
        // return response()->json('Payment Cancelled', 402);
    }

    /**
     * todo Success Operation */
    public function success(Request $request)
    {
        // $provider = new ExpressCheckout;
        // $response = $provider->getExpressCheckoutDetails($request->token);
        // if (in_array($response['ACK'], ['Success', 'SuccessWithWarning'])) {
        //     /**
        //      * todo Success Operation */
        //     return response()->json('Payment Success', 200);
        // }

        // /** 
        //  * todo Cancel Operation */
        // return response()->json('Payment Cancelled', 402);
    }

}
