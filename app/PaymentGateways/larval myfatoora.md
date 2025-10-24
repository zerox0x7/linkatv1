Laravel
2.2.4

Suggest Edits
Source Files
Install the MyFatoorah Laravel package via myfatoorah/laravel-package composer.

cmd

composer require myfatoorah/laravel-package
Installation steps
❗️
Important Note

The MyFatoorah Laravel package provides examples of how to use the MyFatoorah Library and the MyFatoorah API endpoints. Any validations or security criteria must be taken from your side to ensure a seamless payment experience.

Publish the MyFatoorah provider using the following CLI command.
cmd

php artisan vendor:publish --provider="MyFatoorah\LaravelPackage\MyFatoorahServiceProvider" --tag="myfatoorah"
To test the payment cycle, type the below URL onto your browser. Replace only the {example.com} with your site domain. You can use the test cards listed on the Test Cards page.

https://{example.com}/myfatoorah
Or
https://{example.com}/myfatoorah/checkout
Customize the app/Http/Controllers/MyFatoorahController.php file as per your site needs.
PHP

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;

class MyFatoorahController extends Controller {

    /**
     * @var array
     */
    public $mfConfig = [];

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Initiate MyFatoorah Configuration
     */
    public function __construct() {
        $this->mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Redirect to MyFatoorah Invoice URL
     * Provide the index method with the order id and (payment method id or session id)
     *
     * @return Response
     */
    public function index() {
        try {
            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;

            $orderId  = request('oid') ?: 147;
            $curlData = $this->getPayLoadData($orderId);

            $mfObj   = new MyFatoorahPayment($this->mfConfig);
            $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $orderId, $sessionId);

            return redirect($payment['invoiceURL']);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => 'false', 'Message' => $exMessage]);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how to map order data to MyFatoorah
     * You can get the data using the order object in your system
     * 
     * @param int|string $orderId
     * 
     * @return array
     */
    private function getPayLoadData($orderId = null) {
        $callbackURL = route('myfatoorah.callback');

        //You can get the data using the order object in your system
        $order = $this->getTestOrderData($orderId);

        return [
            'CustomerName'       => 'FName LName',
            'InvoiceValue'       => $order['total'],
            'DisplayCurrencyIso' => $order['currency'],
            'CustomerEmail'      => 'test@test.com',
            'CallBackUrl'        => $callbackURL,
            'ErrorUrl'           => $callbackURL,
            'MobileCountryCode'  => '+965',
            'CustomerMobile'     => '12345678',
            'Language'           => 'en',
            'CustomerReference'  => $orderId,
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Get MyFatoorah Payment Information
     * Provide the callback method with the paymentId
     * 
     * @return Response
     */
    public function callback() {
        try {
            $paymentId = request('paymentId');

            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            $data  = $mfObj->getPaymentStatus($paymentId, 'PaymentId');

            $message = $this->getTestMessage($data->InvoiceStatus, $data->InvoiceError);

            $response = ['IsSuccess' => true, 'Message' => $message, 'Data' => $data];
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            $response  = ['IsSuccess' => 'false', 'Message' => $exMessage];
        }
        return response()->json($response);
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how to Display the enabled gateways at your MyFatoorah account to be displayed on the checkout page
     * Provide the checkout method with the order id to display its total amount and currency
     * 
     * @return View
     */
    public function checkout() {
        try {
            //You can get the data using the order object in your system
            $orderId = request('oid') ?: 147;
            $order   = $this->getTestOrderData($orderId);

            //You can replace this variable with customer Id in your system
            $customerId = request('customerId');

            //You can use the user defined field if you want to save card
            $userDefinedField = config('myfatoorah.save_card') && $customerId ? "CK-$customerId" : '';

            //Get the enabled gateways at your MyFatoorah acount to be displayed on checkout page
            $mfObj          = new MyFatoorahPaymentEmbedded($this->mfConfig);
            $paymentMethods = $mfObj->getCheckoutGateways($order['total'], $order['currency'], config('myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception('noPaymentGateways');
            }

            //Generate MyFatoorah session for embedded payment
            $mfSession = $mfObj->getEmbeddedSession($userDefinedField);

            //Get Environment url
            $isTest = $this->mfConfig['isTest'];
            $vcCode = $this->mfConfig['countryCode'];

            $countries = MyFatoorah::getMFCountries();
            $jsDomain  = ($isTest) ? $countries[$vcCode]['testPortal'] : $countries[$vcCode]['portal'];

            return view('myfatoorah.checkout', compact('mfSession', 'paymentMethods', 'jsDomain', 'userDefinedField'));
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return view('myfatoorah.error', compact('exMessage'));
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how the webhook is working when MyFatoorah try to notify your system about any transaction status update
     */
    public function webhook(Request $request) {
        try {
            //Validate webhook_secret_key
            $secretKey = config('myfatoorah.webhook_secret_key');
            if (empty($secretKey)) {
                return response(null, 404);
            }

            //Validate MyFatoorah-Signature
            $mfSignature = $request->header('MyFatoorah-Signature');
            if (empty($mfSignature)) {
                return response(null, 404);
            }

            //Validate input
            $body  = $request->getContent();
            $input = json_decode($body, true);
            if (empty($input['Data']) || empty($input['EventType']) || $input['EventType'] != 1) {
                return response(null, 404);
            }

            //Validate Signature
            if (!MyFatoorah::isSignatureValid($input['Data'], $secretKey, $mfSignature, $input['EventType'])) {
                return response(null, 404);
            }

            //Update Transaction status on your system
            $result = $this->changeTransactionStatus($input['Data']);

            return response()->json($result);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => false, 'Message' => $exMessage]);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function changeTransactionStatus($inputData) {
        //1. Check if orderId is valid on your system.
        $orderId = $inputData['CustomerReference'];

        //2. Get MyFatoorah invoice id
        $invoiceId = $inputData['InvoiceId'];

        //3. Check order status at MyFatoorah side
        if ($inputData['TransactionStatus'] == 'SUCCESS') {
            $status = 'Paid';
            $error  = '';
        } else {
            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            $data  = $mfObj->getPaymentStatus($invoiceId, 'InvoiceId');

            $status = $data->InvoiceStatus;
            $error  = $data->InvoiceError;
        }

        $message = $this->getTestMessage($status, $error);

        //4. Update order transaction status on your system
        return ['IsSuccess' => true, 'Message' => $message, 'Data' => $inputData];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function getTestOrderData($orderId) {
        return [
            'total'    => 15,
            'currency' => 'KWD'
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function getTestMessage($status, $error) {
        if ($status == 'Paid') {
            return 'Invoice is paid.';
        } else if ($status == 'Failed') {
            return 'Invoice is not paid due to ' . $error;
        } else if ($status == 'Expired') {
            return $error;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
}
📘
MyFtoorah Library

MyFatoorah Laravel-Package uses the MyFatoorah Library composer package. Check the PHP library to help you Customize your Laravel website.

Merchant Configurations
Edit the config/myfatoorah.php file with your correct vendor data.

Live Configuration: set "test_mode" with "false" and use your live token.
Test Configuration: set "test_mode" with "true" and use the test token. Also, use the list of test cards to explore the payment process.
PHP

<?php

return [
    /**
     * API Token Key (string)
     * Accepted value:
     * Live Token: https://myfatoorah.readme.io/docs/live-token
     * Test Token: https://myfatoorah.readme.io/docs/test-token
     */
    'api_key' => '',
    /**
     * Test Mode (boolean)
     * Accepted value: true for the test mode or false for the live mode
     */
    'test_mode' => true,
    /**
     * Country ISO Code (string)
     * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
     */
    'country_iso' => 'KWT',
    /**
     * Save card (boolean)
     * Accepted value: true if you want to enable save card options.
     * You should contact your account manager to enable this feature in your MyFatoorah account as well.
     */
    'save_card' => true,
    /**
     * Webhook secret key (string)
     * Enable webhook on your MyFatoorah account setting then paste the secret key here.
     * The webhook link is: https://{example.com}/myfatoorah/webhook
     */
    'webhook_secret_key' => '',
    /**
     * Register Apple Pay (boolean)
     * Set it to true to show the Apple Pay on the checkout page.
     * First, verify your domain with Apple Pay before you set it to true.
     * You can either follow the steps here: https://docs.myfatoorah.com/docs/apple-pay#verify-your-domain-with-apple-pay or contact the MyFatoorah support team (tech@myfatoorah.com).
    */
    'register_apple_pay' => false
];


إليك خطة عمل عملية ومختصرة لإضافة بوابة دفع MyFatoorah (أو أي بوابة مشابهة) إلى متجرك Laravel بشكل احترافي ومرن:
خطة العمل لإضافة بوابة MyFatoorah
1. تجهيز البيئة والإعدادات
تثبيت الحزمة الرسمية:
Apply to larval myfat...
Run
نشر إعدادات الحزمة (config):
Apply to larval myfat...
Run
إضافة بيانات الاعتماد (API Key, test mode, country code) في ملف الإعدادات أو قاعدة البيانات.
2. إعداد نموذج طريقة الدفع في لوحة الإدارة
التأكد من وجود خيار MyFatoorah في جدول payment_methods.
إضافة حقول config المناسبة (api_key, mode, ...).
3. إنشاء كلاس بوابة الدفع
إنشاء ملف جديد:
app/PaymentGateways/MyFatoorahGateway.php
يرث من BaseGateway ويحتوي على:
منطق إنشاء الفاتورة.
منطق التحقق من الدفع.
منطق التعامل مع الردود (callback/webhook).
4. تعديل منطق الدفع في الكنترولر
في PaymentController أو CheckoutController:
عند اختيار MyFatoorah، استدعِ كلاس البوابة الجديد.
مرر بيانات الطلب، واستقبل رابط الدفع، وأعد توجيه العميل.
5. إضافة مسارات (Routes) للـ Callback/Webhook
في routes/web.php:
Apply to larval myfat...
6. تحديث حالة الطلب بعد الدفع
في دوال الـ callback/webhook:
تحقق من صحة التوقيع.
حدّث حالة الطلب في قاعدة البيانات.
فعّل تسليم المنتجات أو الأكواد الرقمية إذا كان الدفع ناجحًا.
7. اختبار كامل الدورة
جرب الدفع في وضع الاختبار (Test Mode).
تحقق من استقبال الردود وتحديث الطلبات بشكل صحيح.
راقب السجلات (logs) لأي أخطاء أو مشاكل.
8. تفعيل البوابة للعملاء
بعد التأكد من نجاح الاختبارات، فعّل وضع الإنتاج (Live Mode).
أضف أي تحسينات أو تخصيصات مطلوبة للواجهة أو تجربة المستخدم.
ملاحظات مهمة
راقب دائمًا أمان الـ webhook (تحقق من التوقيع).
احتفظ بسجلات الأخطاء لأي عملية دفع فاشلة.
يمكنك تكرار نفس الخطة لأي بوابة دفع أخرى (EdfaPay، Paymob، إلخ) مع تعديلات بسيطة في الكلاس.
هل ترغب أن أبدأ بتنفيذ أي خطوة من هذه الخطة مباشرة؟
أو تحتاج تفاصيل أكثر عن نقطة معينة؟
