<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymobService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('PAYMOB_API_KEY');
        $this->apiUrl = env('PAYMOB_API_URL');
    }

    // Function to get the authentication token
    public function getAuthToken()
    {
        $response = Http::post("{$this->apiUrl}/auth/tokens", [
            'api_key' => $this->apiKey,
        ]);

        if ($response->successful()) {
            return $response->json()['token'];
        }

        return null;
    }

    // Function to create a payment order
    public function createPaymentOrder($amount)
    {
        $authToken = $this->getAuthToken(); // Get the token
        if (!$authToken) {
            return ['error' => 'Unable to authenticate with PayMob API']; // Return error message if authentication fails
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
        ])->post("{$this->apiUrl}/ecommerce/orders", [
                    'amount_cents' => $amount * 100,  // Amount in cents
                    'currency' => 'EGP',
                    'order_id' => uniqid(),  // Unique order ID
                ]);

        // Check the response status
        if ($response->successful()) {
            return $response->json(); // Return order details
        } else {
            // Return error details if the operation fails
            return [
                'error' => 'Payment order creation failed',
                'response' => $response->json() // Show error details from the response
            ];
        }
    }

    // Function to check payment status using the token
    public function checkPaymentStatus($token)
    {
        $authToken = $this->getAuthToken(); // Get the token
        if (!$authToken) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
        ])->get("{$this->apiUrl}/ecommerce/orders/{$token}");

        if ($response->successful()) {
            return $response->json();  // Return payment status
        }

        return null;
    }
}
