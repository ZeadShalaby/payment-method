<?php

namespace App\Http\Controllers;

use Stripe;
use Stripe\Charge;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class StripeController extends Controller
{
    use ResponseTrait;


    // ?todo return link for payment page  
    public function getPaymentLink()
    {
        $paymentLink = route('payment.stripe.index');
        return $this->StripLink($paymentLink);
    }

    // ?todo return view payment trip 
    public function index()
    {
        return view('stripe.index');
    }

    // ?todo Paypal Method 
    public function stripe(Request $request)
    {

        $request->validate([
            'stripeToken' => 'required',
        ]);

        try {
            // Initialize Stripe with secret key from .env
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = Charge::create([
                "amount" => 100 * 100,
                "currency" => "INR",
                "source" => $request->stripeToken,
                "description" => "This payment is testing purpose of websolutionstuff.com",
            ]);

            // Handle successful payment intent response
            return $this->returnSuccessMessage($paymentIntent);

        } catch (\Stripe\Exception\CardException $e) {
            // Handle card-related errors
            return $this->ErrorsPayments($e->getMessage());
        } catch (\Exception $e) {
            // Log any other error and return a general error message
            Log::error('Stripe Payment Error: ' . $e->getMessage());
            return $this->ErrorsPayments("Payment failed. Please try again later.");
        }
    }
}





