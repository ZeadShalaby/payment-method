<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HyperpayController extends Controller
{

    /**
     * todo Paypal Method */
    /**
     * HyperPay Method
     */
    public function hyperpay($price, $brand = 'VISA')
    {
        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" . $price .
            "&currency=EUR" .
            "&paymentType=DB" .
            "&paymentBrand=" . $brand; // Add brand (e.g., VISA, MASTER)

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $res = json_decode($responseData, true);
        return $res; // Return the response from HyperPay API
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
