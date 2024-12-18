<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymobService;

class PayMobController extends Controller
{
    protected $paymobService;

    public function __construct(PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function createOrder()
    {
        $amount = 10000; // The amount in cents (100 EGP in this case)
        $currency = "EGP"; // The currency
        $paymentOrder = $this->paymobService->createPaymentOrder($amount, $currency);

        if (isset($paymentOrder['error'])) {
            return response()->json([
                'error' => $paymentOrder['error'],
                'details' => $paymentOrder['response'] ?? 'No response details available'
            ], 500);
        }

        // Check if the URL sent by PayMob is valid
        $isValid = $this->checkUrlValidity($paymentOrder['order_url']);
        if ($isValid) {
            return response()->json($paymentOrder); // Return the new link to the client if it's valid
        } else {
            // Return an error if the URL is invalid
            return response()->json([
                'error' => 'Invalid payment URL, please contact your merchant',
                'url' => $paymentOrder['order_url']
            ], 400);
        }
    }

    // Function to check payment status using the Token
    public function checkPaymentStatus($token)
    {
        // Use a function from PaymobService to check the payment status based on the token
        $paymentStatus = $this->paymobService->checkPaymentStatus($token);

        if ($paymentStatus) {
            return response()->json($paymentStatus);  // Return the payment status
        }

        return response()->json(['error' => 'Payment status check failed'], 500);
    }

    // Function to check the validity of the URL
    public function checkUrlValidity($url)
    {
        // Use cURL to check the URL validity
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);  // Do not load the content
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Do not output the result directly

        // Execute the request
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check the HTTP status
        return $statusCode == 200; // If the status is 200, the URL is valid
    }

    // Function to show the result of the URL validity check
    public function showUrlCheckResult()
    {
        $url = "https://accept.paymob.com/standalone/?ref=i_LRR2blVWcmxrS3RIcWpQd05DRVd2NUxCZz09X0NZd0UyTk55OUdSdVRuOWNsbDR3bGc9PQ";
        $isValid = $this->checkUrlValidity($url);

        return response()->json(['isValid' => $isValid]);
    }
}
