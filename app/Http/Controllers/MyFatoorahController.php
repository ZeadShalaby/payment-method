<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Offers;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Traits\Payments\PaymentsTrait;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;


class MyFatoorahController extends Controller
{
    use ResponseTrait, PaymentsTrait;
    public $myFatoorah = [];

    /**
     * Initialize MyFatoorah Configuration
     */
    public function __construct()
    {
        $this->myFatoorah = [
            'apiKey' => env('MYFATOORAH_API_KEY'),
            'isTest' => env('MYFATOORAH_TEST_MODE'),
            'countryCode' => env('MYFATOORAH_COUNTRY_ISO'),
        ];
    }

    /**
     * Handle the creation of a checkout session
     * todo return pay link to frontend 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        try {
            $user = User::find(1);//Auth::user();
            $offerId = Offers::first()->id; //$request->offer_id;
            $offer = Offers::findOrFail($offerId);

            //? call method in paymentsTrait
            $curlData = $this->getPayLoadData($user, $offer);

            $mfObj = new MyFatoorahPayment($this->myFatoorah);
            $payment = $mfObj->getInvoiceURL($curlData);
            return $this->SuccessPayments($payment);

        } catch (Exception $ex) {
            return $this->ErrorsPayments($ex->getMessage());
        }
    }


    public function callback()
    {
        try {
            $paymentId = request('paymentId');
            $mfObj = new MyFatoorahPaymentStatus($this->myFatoorah);
            $data = $mfObj->getPaymentStatus($paymentId, 'PaymentId');
            $user = User::where('email', $data->CustomerEmail)->first();
            $offer = Offers::where('title', $data->CustomerReference)->first();
            attributes:
            // ! saved process payments & orders
            $paymentsId = $this->CreatePayments($data);
            $orders = $this->CreateOrders($user, $offer, $paymentsId);

            //? call method in paymentsTrait
            $message = $this->getTestMessage($data->InvoiceStatus, $data->InvoiceError);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return $this->responseErrors($exMessage);
        }
        return $this->responseSuccess($data, $message);
    }

}
