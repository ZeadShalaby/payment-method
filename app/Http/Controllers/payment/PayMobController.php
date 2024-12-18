<?php

namespace App\Http\Controllers\payment;

use Stripe\Climate\Order;
use PayMob\Facades\PayMob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PayMobController extends Controller
{
    public static function pay(float $total_amount, string $order_id)
    {
        try {

            $auth = PayMob::AuthenticationRequest();
            // Ensure the token is valid before proceeding
            if (!$auth || !isset($auth->token)) {
                throw new \Exception('Authentication failed');
            }

            $order = PayMob::OrderRegistrationAPI([
                'auth_token' => $auth->token,
                'amount_cents' => $total_amount * 100,
                'currency' => 'EGP',
                'delivery_needed' => false,
                'merchant_order_id' => $order_id,
                'items' => []
            ]);
            if (!$order) {
                throw new \Exception('Order registration failed');
            }

            $PaymentKey = PayMob::PaymentKeyRequest([
                'auth_token' => $auth->token,
                'amount_cents' => $total_amount * 100,
                'currency' => 'EGP',
                'order_id' => $order->id,
                'billing_data' => [
                    "apartment" => "803",
                    "email" => "claudette09@exa.com",
                    "floor" => "42",
                    "first_name" => "Clifford",
                    "street" => "Ethan Land",
                    "building" => "8028",
                    "phone_number" => "+86(8)9135210487",
                    "shipping_method" => "PKG",
                    "postal_code" => "01898",
                    "city" => "Jaskolskiburgh",
                    "country" => "CR",
                    "last_name" => "Nicolas",
                    "state" => "Utah"
                ]
            ]);
            if (!$PaymentKey || !isset($PaymentKey->token)) {
                throw new \Exception('Payment key request failed');
            }

            return $PaymentKey->token;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function checkout_process(Request $request)
    {
        try {
            $request_hmac = $request->hmac;
            $calc_hmac = PayMob::calcHMAC($request);

            if ($request_hmac !== $calc_hmac) {
                throw new \Exception('Invalid HMAC');
            }

            $order_id = $request->obj['order']['merchant_order_id'];
            $amount_cents = $request->obj['amount_cents'];
            $transaction_id = $request->obj['id'];

            if ($request->obj['success'] && (100 * 100) == $amount_cents) {
                return response()->json([
                    'payment_status' => 'finished',
                    'transaction_id' => $transaction_id
                ]);
            } else {
                return response()->json([
                    'payment_status' => 'failed',
                    'transaction_id' => $transaction_id
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
