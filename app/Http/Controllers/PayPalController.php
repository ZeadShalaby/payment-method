<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{

    /**
     * todo Paypal Method */
    public function paypal()
    {
        $data = [];
        $data['items'] = [
            [
                'name' => 'subscribe to channel',
                'price' => 1000,
                'desc' => 'Description',
                'qty' => 2
            ],
            [
                'name' => 'make like',
                'price' => 300,
                'desc' => 'Description',
                'qty' => 2
            ]
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = "http://127.0.0.1:8000/api/payment/paypal/success";
        $data['cancel_url'] = "http://127.0.0.1:8000/api/payment/paypal/cancel";
        $data['total'] = 2600;
        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);
    }


    /**
     * todo Cancel Operation */
    public function cancel()
    {
        return response()->json('Payment Cancelled', 402);
    }


    /**
     * todo Success Operation */
    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
        if (in_array($response['ACK'], ['Success', 'SuccessWithWarning'])) {
            /**
             * todo Success Operation */
            return response()->json('Payment Success', 200);
        }

        /** 
         * todo Cancel Operation */
        return response()->json('Payment Cancelled', 402);
    }
}
