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

    // دالة للحصول على الـ token
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

    // دالة لإنشاء طلب دفع
    public function createPaymentOrder($amount)
    {
        $authToken = $this->getAuthToken(); // الحصول على الـ token
        if (!$authToken) {
            return null;
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
        ])->post("{$this->apiUrl}/ecommerce/orders", [
                    'amount_cents' => $amount * 100,  // المبلغ بالقرش
                    'currency' => 'EGP',
                    'order_id' => uniqid(),  // معرف الطلب
                ]);

        if ($response->successful()) {
            return $response->json(); // إرسال تفاصيل الطلب
        }

        return null;
    }



}
