<?php

namespace App\Http\Controllers;

use App\Services\MyFatoorahService;
use Illuminate\Http\Request;

class MyFatoorahController extends Controller
{
    protected $myFatoorahService;

    public function __construct()
    {
        $this->myFatoorahService = resolve(MyFatoorahService::class);

    }


    public function index()
    {
        $payload = $this->getPayLoadData();
        $data = $this->myFatoorahService->createInvoice($payload);

        return response()->json(['IsSuccess' => true, 'Message' => 'Invoice created successfully.', 'Data' => $data]);
    }

    private function getPayLoadData($orderId = null)
    {
        $callbackURL = route('myfatoorah.callback');

        return [
            'CustomerName' => 'FName LName',
            'InvoiceValue' => 10,
            'DisplayCurrencyIso' => 'KWD',
            'CustomerEmail' => 'test@test.com',
            'CallBackUrl' => $callbackURL,
            'ErrorUrl' => $callbackURL,
            'MobileCountryCode' => '+965',
            'CustomerMobile' => '12345678',
            'Language' => 'en',
            'CustomerReference' => $orderId,
            'SourceInfo' => 'Laravel ' . app()::VERSION
        ];
    }

    public function callback(Request $request)
    {
        $data = $this->myFatoorahService->getPaymentStatus($request->input('paymentId'));
        $msg = '';

        if ($data['InvoiceStatus'] === 'Paid') {
            $msg = 'Invoice is paid.';
        } elseif ($data['InvoiceStatus'] === 'Failed') {
            $msg = 'Invoice is not paid due to ' . $data['InvoiceError'];
        } elseif ($data['InvoiceStatus'] === 'Expired') {
            $msg = 'Invoice is expired.';
        }

        return response()->json(['IsSuccess' => true, 'Message' => $msg, 'Data' => $data]);
    }
}
