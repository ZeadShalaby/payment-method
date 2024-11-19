<?php

namespace App\Http\Controllers;
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
        $amount = 10000; // المبلغ بالـ cents (أي 100 جنيه في هذه الحالة)
        $currency = "EGP"; // العملة
        $paymentOrder = $this->paymobService->createPaymentOrder($amount, $currency);

        if ($paymentOrder) {
            return response()->json($paymentOrder); // إرسال الرابط الجديد إلى العميل
        }

        return response()->json(['error' => 'Payment order creation failed'], 500);
    }

    // دالة للتحقق من حالة الدفع باستخدام الـ Token
    public function checkPaymentStatus($token)
    {
        // استخدم دالة من PaymobService تتحقق من حالة الدفع بناءً على الـ token
        $paymentStatus = $this->paymobService->createPaymentOrder($token);

        if ($paymentStatus) {
            return response()->json($paymentStatus);  // رد بحالة الدفع
        }

        return response()->json(['error' => 'Payment status check failed'], 500);
    }

    // دالة للتحقق من صلاحية الرابط
    public function checkUrlValidity($url)
    {
        // استخدم cURL للتحقق من صحة الرابط
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);  // لا تحمّل المحتوى
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // لا تعرض النتيجة مباشرة

        // تنفيذ الطلب
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // تحقق من حالة الـ HTTP
        if ($statusCode == 200) {
            return true; // الرابط صالح
        } else {
            return false; // الرابط غير صالح
        }
    }

    // دالة لعرض نتيجة التحقق من صلاحية الرابط
    public function showUrlCheckResult()
    {
        $url = "https://accept.paymob.com/standalone/?ref=i_LRR2blVWcmxrS3RIcWpQd05DRVd2NUxCZz09X0NZd0UyTk55OUdSdVRuOWNsbDR3bGc9PQ";
        $isValid = $this->checkUrlValidity($url);

        return response()->json(['isValid' => $isValid]);
    }
}
