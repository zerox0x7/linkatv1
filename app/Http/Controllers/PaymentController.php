<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\PaymentGateways\ClickpayGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * عرض صفحة الدفع ببطاقة الائتمان
     *
     * @param  int  $order
     * @return \Illuminate\Contracts\View\View
     */
    public function creditCard($order)
    {
        $order = $this->getUserOrder($order);
        
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'تم دفع هذا الطلب بالفعل');
        }
        
        return view('payment.credit_card', compact('order'));
    }
    
    /**
     * عرض صفحة الدفع بالتحويل البنكي
     *
     * @param  int  $order
     * @return \Illuminate\Contracts\View\View
     */
    public function bankTransfer($order)
    {
        $order = $this->getUserOrder($order);
        
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'تم دفع هذا الطلب بالفعل');
        }
        
        // الحصول على بيانات الحسابات البنكية من إعدادات الموقع
        $bankAccounts = [
            [
                'bank_name' => 'البنك الأهلي',
                'account_name' => 'اسم الحساب',
                'account_number' => 'SA0000000000000000000000',
                'iban' => 'SA0000000000000000000000',
            ],
            [
                'bank_name' => 'بنك الراجحي',
                'account_name' => 'اسم الحساب',
                'account_number' => 'SA0000000000000000000000',
                'iban' => 'SA0000000000000000000000',
            ],
        ];
        
        return view('payment.bank_transfer', compact('order', 'bankAccounts'));
    }
    
    /**
     * إتمام عملية الدفع
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request, $order)
    {
        $order = $this->getUserOrder($order);
        
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'تم دفع هذا الطلب بالفعل');
        }
        
        // التحقق من طريقة الدفع
        if ($order->payment_method === 'credit_card') {
            // التحقق من معلومات البطاقة
            $request->validate([
                'card_number' => 'required|string|size:16',
                'card_holder' => 'required|string|max:255',
                'expiry_month' => 'required|string|size:2',
                'expiry_year' => 'required|string|size:2',
                'cvv' => 'required|string|size:3',
            ]);
            
            // هنا يتم التكامل مع بوابة الدفع الفعلية
            // هذا فقط مثال وليس تنفيذ حقيقي
            
            // إنشاء معرف دفع وهمي
            $paymentId = 'CRD-' . strtoupper(Str::random(10));
            
            // تحديث سجل الدفع
            $payment = $order->payment;
            $payment->update([
                'payment_id' => $paymentId,
                'payer_id' => auth()->id(),
                'payer_email' => auth()->user()->email,
                'payment_status' => 'completed',
                'payment_data' => [
                    'card_last4' => substr($request->card_number, -4),
                    'payment_id' => $paymentId,
                ],
            ]);
            
            // تحديث حالة الطلب
            if ($order->status !== 'completed') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'paid_at' => now(),
                ]);
            } else {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);
            }
            
            // زيادة عدد طلبات المستخدم
            $user = auth()->user();
            $user->increment('orders_count');
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'تم الدفع بنجاح وتأكيد الطلب');
        } elseif ($order->payment_method === 'bank_transfer') {
            // التحقق من معلومات التحويل
            $request->validate([
                'transfer_receipt' => 'required|image|max:2048',
                'transfer_date' => 'required|date',
                'bank_name' => 'required|string|max:255',
                'transfer_amount' => 'required|numeric',
                'transfer_name' => 'required|string|max:255',
            ]);
            
            // تحميل إيصال التحويل
            $receiptPath = $request->file('transfer_receipt')->store('receipts', 'public');
            
            // تحديث سجل الدفع
            $payment = $order->payment;
            $payment->update([
                'payment_id' => 'BNK-' . strtoupper(Str::random(10)),
                'payer_id' => auth()->id(),
                'payer_email' => auth()->user()->email,
                'payment_status' => 'pending',
                'payment_data' => [
                    'transfer_receipt' => $receiptPath,
                    'transfer_date' => $request->transfer_date,
                    'bank_name' => $request->bank_name,
                    'transfer_amount' => $request->transfer_amount,
                    'transfer_name' => $request->transfer_name,
                ],
            ]);
            
            // تحديث حالة الطلب
            $order->update([
                'status' => 'pending_confirmation',
            ]);
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'تم إرسال معلومات التحويل بنجاح، سيتم مراجعة التحويل وتأكيد الطلب قريباً');
        }
        
        return redirect()->route('checkout.index')
            ->with('error', 'حدث خطأ أثناء معالجة الدفع');
    }
    
    /**
     * معالجة الدفع عبر كليك باي
     *
     * @param  int  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clickpay($order)
    {
        // حذف أي مخرجات مؤقتة
        if (ob_get_level()) {
            ob_end_clean();
        }

        $order = $this->getUserOrder($order);
        
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'تم دفع هذا الطلب بالفعل');
        }
        
        try {
            // البحث عن طريقة الدفع
            $paymentMethod = PaymentMethod::where('code', 'clickpay')->first();
            
            if (!$paymentMethod || !$paymentMethod->is_active) {
                Log::error('طريقة الدفع كليك باي غير متاحة أو غير مفعلة', [
                    'payment_method_exists' => (bool)$paymentMethod,
                    'is_active' => $paymentMethod ? $paymentMethod->is_active : false,
                ]);
                
                return redirect()->route('checkout.index')
                    ->with('error', 'طريقة الدفع غير متاحة حالياً');
            }
            
            // تسجيل المعلومات للتشخيص
            Log::info('بدء عملية الدفع مع كليك باي', [
                'order_id' => $order->id,
                'payment_method' => $paymentMethod->toArray(),
                'credentials' => $paymentMethod->getActiveCredentials(),
            ]);
            
            // إنشاء بوابة الدفع
            $gateway = $this->createGateway($paymentMethod);
            
            // معالجة الدفع
            $response = $gateway->processPayment($order);
            
            // تسجيل الاستجابة للتشخيص
            Log::info('استجابة كليك باي', [
                'order_id' => $order->id,
                'response' => $response,
                'has_redirect_url' => isset($response['redirect_url']),
                'redirect_url' => $response['redirect_url'] ?? null,
                'success' => $response['success'] ?? false,
            ]);
            
            // في حالة النجاح وإعادة التوجيه
            if ($response['success'] && isset($response['redirect_url']) && !empty($response['redirect_url'])) {
                // تسجيل محاولة الدفع
                $this->logPaymentAttempt($order, $paymentMethod, $response);
                
                // حفظ معرف الطلب المعلق في الجلسة
                session()->put('pending_order_id', $order->id);
                
                // تسجيل معلومات التوجيه للتشخيص
                Log::debug('تفاصيل التوجيه لبوابة كليك باي', [
                    'redirect_url' => $response['redirect_url'],
                    'order_id' => $order->id,
                    'session_id' => session()->getId(),
                    'has_output' => ob_get_level() > 0
                ]);
                
                // إعادة الاستجابة بطريقة مختلفة: عرض صفحة HTML مع توجيه فوري
                echo '<!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="refresh" content="0;url=' . $response['redirect_url'] . '">
                    <title>جاري التحويل إلى بوابة الدفع</title>
                    <script type="text/javascript">
                        window.location.href = "' . $response['redirect_url'] . '";
                    </script>
                </head>
                <body>
                    <h1>جاري التحويل إلى بوابة الدفع...</h1>
                    <p>إذا لم يتم تحويلك تلقائيًا، <a href="' . $response['redirect_url'] . '">انقر هنا</a></p>
                </body>
                </html>';
                exit;
            }
            
            // في حالة الفشل أو عدم وجود رابط إعادة توجيه
            Log::warning('فشل في إنشاء طلب الدفع', [
                'order_id' => $order->id,
                'response' => $response,
                'message' => $response['message'] ?? 'لا توجد رسالة خطأ',
            ]);
            
            return redirect()->route('checkout.index')
                ->with('error', $response['message'] ?? 'حدث خطأ أثناء معالجة الدفع: لم نتمكن من الاتصال ببوابة الدفع');
            
        } catch (\Exception $e) {
            Log::error('Clickpay payment error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('checkout.index')
                ->with('error', 'حدث خطأ أثناء معالجة الدفع، يرجى المحاولة مرة أخرى: ' . $e->getMessage());
        }
    }
    
    /**
     * معالجة الاستجابة الناجحة من بوابة كليك باي
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clickpaySuccess(Request $request)
    {
        $orderId = $request->get('order_id');
        $token = $request->get('token');
        Log::info('بيانات الاستجابة الكاملة من بوابة الدفع - success', [
            'all_data' => $request->all(),
            'query_params' => $request->query(),
            'order_id' => $orderId,
            'token' => $token,
            'respStatus' => $request->get('respStatus'),
            'tranRef' => $request->get('tranRef'),
            'tran_ref' => $request->get('tran_ref'),
            'transactionNo' => $request->get('transactionNo'),
            'orderNumber' => $request->get('orderNumber'),
            'headers' => $request->headers->all(),
            'server_data' => $_SERVER,
            'request_method' => $request->method(),
            'raw_post' => file_get_contents('php://input'),
        ]);

        if (!$orderId || !$token) {
            return redirect()->route('checkout.index')
                ->with('error', 'رابط غير صالح أو بيانات ناقصة. يرجى التأكد من صحة الرابط أو التواصل مع الدعم.');
        }

        $order = \App\Models\Order::where('id', $orderId)
            ->where('order_token', $token)
            ->first();
        
        // إذا لم يتم العثور على الطلب باستخدام order_token، جرب order_number
        if (!$order) {
            $order = \App\Models\Order::where('id', $orderId)
                ->where('order_number', $token)
                ->first();
        }
        
        if (!$order) {
            return redirect()->route('checkout.index')
                ->with('error', 'رابط غير صالح أو الطلب غير موجود. يرجى التواصل مع الدعم الفني.');
        }

        // استعادة جلسة المستخدم تلقائيًا إذا لم يكن مسجلاً الدخول
        if (!auth()->check() && $order->user_id) {
            \Auth::loginUsingId($order->user_id);
            Log::info('تم تسجيل دخول المستخدم تلقائيًا بعد العودة من بوابة الدفع', [
                'user_id' => $order->user_id,
                'order_id' => $order->id
            ]);
        }

        try {
            // استخدام payment_method من Order بدلاً من hardcode
            $paymentMethod = PaymentMethod::where('code', $order->payment_method)->first();
            if (!$paymentMethod) {
                return redirect()->route('orders.show', $order->id)
                    ->with('error', 'طريقة الدفع غير متاحة');
            }
            $gateway = $this->createGateway($paymentMethod);
            $paymentData = array_merge($request->all(), $request->query());
            if (isset($paymentData['respStatus']) && $paymentData['respStatus'] === 'A') {
                Log::info('وجدت حالة نجاح في استجابة كليك باي', [
                    'respStatus' => $paymentData['respStatus'],
                    'tranRef' => $paymentData['tranRef'] ?? null,
                    'order_id' => $order->id
                ]);
                $this->markOrderAsPaid($order, $paymentData);
                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'تم الدفع بنجاح وتأكيد الطلب');
            }
            if (empty($paymentData) || (count($paymentData) === 1 && isset($paymentData['order_id']))) {
                Log::warning('بيانات الرد من البوابة فارغة، سنحاول الاستعلام باستخدام رقم الطلب فقط', [
                    'order_id' => $order->id
                ]);
                $paymentData = [
                    'order_id' => $order->id,
                    'cart_id' => (string) $order->id,
                    'direct_query' => true,
                ];
            }
            Log::info('البيانات المرسلة للتحقق من الدفع', [
                'payment_data' => $paymentData
            ]);
            $isVerified = $gateway->verifyPayment($paymentData);
            Log::info('نتيجة التحقق من الدفع', [
                'is_verified' => $isVerified,
                'order_id' => $order->id
            ]);
            if ($isVerified) {
                $this->markOrderAsPaid($order, $paymentData);
                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'تم الدفع بنجاح وتأكيد الطلب');
            } else {
                return redirect()->route('checkout.index')
                    ->with('error', 'لم يتم التحقق من عملية الدفع بنجاح. إذا تم خصم المبلغ من بطاقتك ولم يتم تأكيد الطلب، يرجى التواصل مع الدعم الفني فوراً.');
            }
        } catch (\Exception $e) {
            Log::error('Clickpay success callback error', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('checkout.index')
                ->with('error', 'حدث خطأ أثناء معالجة استجابة الدفع: ' . $e->getMessage());
        }
    }
    
    /**
     * معالجة إلغاء الدفع من بوابة كليك باي
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clickpayCancel(Request $request)
    {
        $orderId = $request->get('order_id');
        $token = $request->get('token');
        Log::info('بيانات الإلغاء الكاملة من بوابة الدفع', [
            'all_data' => $request->all(),
            'query_params' => $request->query(),
            'order_id' => $orderId,
            'token' => $token,
            'tranRef' => $request->get('tranRef'),
            'tran_ref' => $request->get('tran_ref'),
            'transactionNo' => $request->get('transactionNo'),
            'orderNumber' => $request->get('orderNumber'),
            'respStatus' => $request->get('respStatus'),
            'headers' => $request->headers->all(),
            'request_method' => $request->method(),
        ]);
        if (!$orderId || !$token) {
            return redirect()->route('checkout.index')
                ->with('error', 'رابط غير صالح أو بيانات ناقصة. يرجى التأكد من صحة الرابط أو التواصل مع الدعم.');
        }
        $order = \App\Models\Order::where('id', $orderId)
            ->where('order_token', $token)
            ->first();
        
        // إذا لم يتم العثور على الطلب باستخدام order_token، جرب order_number
        if (!$order) {
            $order = \App\Models\Order::where('id', $orderId)
                ->where('order_number', $token)
                ->first();
        }
        
        if (!$order) {
            return redirect()->route('checkout.index')
                ->with('error', 'رابط غير صالح أو الطلب غير موجود. يرجى التواصل مع الدعم الفني.');
        }
        // استعادة جلسة المستخدم تلقائيًا إذا لم يكن مسجلاً الدخول
        if (!auth()->check() && $order->user_id) {
            \Auth::loginUsingId($order->user_id);
            Log::info('تم تسجيل دخول المستخدم تلقائيًا بعد العودة من بوابة الدفع (إلغاء)', [
                'user_id' => $order->user_id,
                'order_id' => $order->id
            ]);
        }
        if (session()->has('pending_order_id') && session()->get('pending_order_id') == $order->id) {
            session()->forget('pending_order_id');
            Log::info('تم حذف معرف الطلب المعلق من الجلسة', ['order_id' => $order->id]);
        }
        try {
            $latestPayment = \App\Models\Payment::where('order_id', $order->id)
                ->latest()
                ->first();
            if ($latestPayment && $latestPayment->payment_id) {
                // استخدام payment_method من Order بدلاً من hardcode
                $paymentMethod = PaymentMethod::where('code', $order->payment_method)->first();
                if ($paymentMethod) {
                    $gateway = $this->createGateway($paymentMethod);
                    $paymentData = [
                        'order_id' => $order->id,
                        'tran_ref' => $latestPayment->payment_id,
                        'direct_query' => true,
                    ];
                    Log::info('التحقق من حالة الدفع الفعلية بعد توجيه الإلغاء', [
                        'order_id' => $order->id,
                        'transaction_id' => $latestPayment->payment_id
                    ]);
                    $isVerified = $gateway->verifyPayment($paymentData);
                    if ($isVerified) {
                        Log::info('تم التحقق من نجاح الدفع رغم توجيه الإلغاء', [
                            'order_id' => $order->id,
                            'transaction_id' => $latestPayment->payment_id
                        ]);
                        $this->markOrderAsPaid($order, $paymentData);
                        return redirect()->route('orders.show', $order->id)
                            ->with('success', 'تم الدفع بنجاح وتأكيد الطلب');
                    }
                    Log::info('نتيجة التحقق من الدفع في صفحة الإلغاء', [
                        'is_verified' => $isVerified,
                        'order_id' => $order->id,
                        'transaction_id' => $latestPayment->payment_id
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('خطأ في التحقق من حالة الدفع الفعلية', [
                'error' => $e->getMessage(),
                'order_id' => $orderId
            ]);
        }
        return redirect()->route('checkout.index')
            ->with('error', 'تم إلغاء عملية الدفع أو لم يتم التحقق من الدفع. إذا تم خصم المبلغ من بطاقتك ولم يتم تأكيد الطلب، يرجى التواصل مع الدعم الفني فوراً.');
    }
    
    /**
     * معالجة الإشعارات التلقائية من بوابة كليك باي
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clickpayWebhook(Request $request)
    {
        Log::info('Clickpay webhook received', $request->all());
        
        try {
            // البحث عن طريقة الدفع
            $paymentMethod = PaymentMethod::where('code', 'clickpay')->first();
            
            if (!$paymentMethod) {
                return response()->json(['error' => 'Payment method not found'], 404);
            }
            
            // إنشاء بوابة الدفع
            $gateway = $this->createGateway($paymentMethod);
            
            // معالجة الإشعار
            $response = $gateway->handleWebhook($request->all());
            
            if ($response['success']) {
                return response()->json(['success' => true]);
            }
            
            return response()->json(['error' => $response['message']], 400);
            
        } catch (\Exception $e) {
            Log::error('Clickpay webhook error', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * معالجة الدفع عبر ماي فاتورة
     *
     * @param  int  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function myfatoorah($order)
    {
        if (ob_get_level()) {
            ob_end_clean();
        }
        $order = $this->getUserOrder($order);
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'تم دفع هذا الطلب بالفعل');
        }
        try {
            // استخدام SimpleMyFatoorahGateway الجديد
            $gateway = new \App\PaymentGateways\Myfatoorah\SimpleMyFatoorahGateway();
            $customer = [
                'name'   => $order->user->name ?? 'عميل',
                'email'  => $order->user->email ?? 'test@test.com',
                'mobile' => $order->user->phone ?? '',
            ];
            $amount = $order->total;
            $successUrl = route('payment.myfatoorah.success', ['order_id' => $order->id, 'token' => $order->order_token]);
            $errorUrl   = route('payment.myfatoorah.cancel', ['order_id' => $order->id, 'token' => $order->order_token]);
            $paymentUrl = $gateway->createPayment($customer, $amount, $successUrl, $errorUrl, $order->currency ?? 'SAR');
            session()->put('pending_order_id', $order->id);
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            \Log::error('MyFatoorah payment error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('checkout.index')
                ->with('error', 'حدث خطأ أثناء معالجة الدفع، يرجى المحاولة مرة أخرى: ' . $e->getMessage());
        }
    }

    /**
     * معالجة العودة من ماي فاتورة (نجاح الدفع)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function myfatoorahSuccess(Request $request)
    {
        $orderId = $request->get('order_id');
        $token = $request->get('token');
        Log::info('بيانات الاستجابة الكاملة من ماي فاتورة - success', [
            'all_data' => $request->all(),
            'query_params' => $request->query(),
            'order_id' => $orderId,
            'token' => $token,
        ]);
        if (!$orderId || !$token) {
            return redirect()->route('checkout.index')
                ->with('error', 'رابط غير صالح أو بيانات ناقصة. يرجى التأكد من صحة الرابط أو التواصل مع الدعم.');
        }
        $order = \App\Models\Order::where('id', $orderId)
            ->where('order_token', $token)
            ->first();
        if (!$order) {
            return redirect()->route('checkout.index')
                ->with('error', 'رابط غير صالح أو الطلب غير موجود. يرجى التواصل مع الدعم الفني.');
        }
        if (!auth()->check() && $order->user_id) {
            \Auth::loginUsingId($order->user_id);
            Log::info('تم تسجيل دخول المستخدم تلقائيًا بعد العودة من ماي فاتورة', [
                'user_id' => $order->user_id,
                'order_id' => $order->id
            ]);
        }
        try {
            $paymentMethod = PaymentMethod::where('code', 'myfatoorah')->first();
            if (!$paymentMethod) {
                return redirect()->route('orders.show', $order->id)
                    ->with('error', 'طريقة الدفع غير متاحة');
            }
            $gateway = $this->createGateway($paymentMethod);
            $paymentId = $request->get('paymentId');
            if (!$paymentId) {
                return redirect()->route('orders.show', $order->id)
                    ->with('error', 'لم يتم العثور على رقم الدفع.');
            }
            $verify = $gateway->verifyPayment($paymentId);
            Log::info('نتيجة التحقق من الدفع ماي فاتورة', [
                'verify' => $verify,
                'order_id' => $order->id
            ]);
            if ($verify['success'] && $verify['status'] === 'Paid') {
                $this->markOrderAsPaid($order, $verify['data']);
                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'تم الدفع بنجاح وتأكيد الطلب');
            } else {
                return redirect()->route('checkout.index')
                    ->with('error', 'لم يتم التحقق من عملية الدفع بنجاح. إذا تم خصم المبلغ من بطاقتك ولم يتم تأكيد الطلب، يرجى التواصل مع الدعم الفني فوراً.');
            }
        } catch (\Exception $e) {
            Log::error('MyFatoorah success callback error', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('checkout.index')
                ->with('error', 'حدث خطأ أثناء معالجة استجابة الدفع: ' . $e->getMessage());
        }
    }

    /**
     * استقبال Webhook ماي فاتورة
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function myfatoorahWebhook(Request $request)
    {
        $secretKey = config('myfatoorah.webhook_secret_key');
        $mfSignature = $request->header('MyFatoorah-Signature');
        $body  = $request->getContent();
        $input = json_decode($body, true);
        $eventType = $input['EventType'] ?? null;
        $data = $input['Data'] ?? [];
        $orderId = $data['CustomerReference'] ?? null;
        Log::info('استقبال Webhook ماي فاتورة', [
            'input' => $input,
            'order_id' => $orderId,
            'signature' => $mfSignature,
            'eventType' => $eventType,
        ]);
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Order ID not found'], 400);
        }
        $order = \App\Models\Order::find($orderId);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        $paymentMethod = PaymentMethod::where('code', 'myfatoorah')->first();
        if (!$paymentMethod) {
            return response()->json(['success' => false, 'message' => 'Payment method not found'], 404);
        }
        $gateway = $this->createGateway($paymentMethod);
        $verify = $gateway->handleWebhook([
            'inputData' => $data,
            'secretKey' => $secretKey,
            'signature' => $mfSignature,
            'eventType' => $eventType,
        ]);
        if ($verify['success']) {
            $this->markOrderAsPaid($order, $data);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => $verify['message'] ?? 'Webhook verification failed'], 400);
        }
    }
    
    /**
     * إنشاء بوابة الدفع
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \App\PaymentGateways\BaseGateway
     */
    protected function createGateway(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->code === 'myfatoorah') {
            $gatewayClass = 'App\\PaymentGateways\\Myfatoorah\\MyFatoorahGateway';
        } else {
            $gatewayClass = "App\\PaymentGateways\\" . ucfirst($paymentMethod->code) . "Gateway";
        }

        // تسجيل البيانات للتشخيص
        Log::debug('بيانات بوابة الدفع', [
            'code' => $paymentMethod->code,
            'config_type' => gettype($paymentMethod->config), 
            'config_empty' => empty($paymentMethod->config),
            'mode' => $paymentMethod->mode ?? 'live'
        ]);

        // استخدام بيانات الاعتماد من حقل config
        $configData = is_string($paymentMethod->config) ? json_decode($paymentMethod->config, true) : $paymentMethod->config;

        // التحقق من صحة البيانات
        if (empty($configData) || !is_array($configData)) {
            Log::error('بيانات الاعتماد غير صالحة', [
                'payment_method' => $paymentMethod->code,
                'config_data' => $configData
            ]);
            throw new \Exception('بيانات الاعتماد غير صالحة');
        }

        // إنشاء بوابة الدفع مع البيانات الصحيحة
        return new $gatewayClass(
            $configData, // تمرير البيانات كاملة
            $configData, // تمرير نفس البيانات كبيانات اعتماد
            $paymentMethod->mode ?? 'live' // استخدام وضع التشغيل من قاعدة البيانات
        );
    }
    
    /**
     * تسجيل محاولة الدفع
     *
     * @param  \App\Models\Order  $order
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @param  array  $response
     * @return void
     */
    protected function logPaymentAttempt(Order $order, PaymentMethod $paymentMethod, array $response)
    {
        // تحديث الطلب بطريقة الدفع
        $order->update([
            'payment_method' => $paymentMethod->code,
        ]);
        
        // تحديث سجل الدفع
        $order->payment()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method_id' => $paymentMethod->id,
                'payment_id' => $response['transaction_id'] ?? null,
                'payer_id' => auth()->id(),
                'payer_email' => auth()->user()->email,
                'payment_status' => 'pending',
                'payment_data' => [
                    'transaction_id' => $response['transaction_id'] ?? null,
                    'raw_response' => $response['raw_response'] ?? [],
                    'request_time' => now()->toDateTimeString(),
                ],
            ]
        );
    }
    
    /**
     * الحصول على طلب المستخدم
     *
     * @param  int  $orderId
     * @return \App\Models\Order
     */
    protected function getUserOrder($orderId)
    {
        return Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->with('payment')
            ->firstOrFail();
    }
    
    /**
     * تحديث حالة الطلب إلى "مدفوع"
     * 
     * @param \App\Models\Order $order الطلب
     * @param array $paymentData بيانات الدفع
     * @return void
     */
    private function markOrderAsPaid($order, $paymentData)
    {
        // تحديث حالة الدفع
        $payment = Payment::where('order_id', $order->id)->first();
        
        if ($payment) {
            // استخدام tranRef بدلاً من tran_ref للتوافق مع API كليك باي
            $paymentId = $paymentData['tranRef'] ?? $paymentData['tran_ref'] ?? ($order->payment->payment_id ?? null);
            
            $payment->update([
                'payment_id' => $paymentId,
                'payer_id' => auth()->id(),
                'payer_email' => auth()->user()->email,
                'payment_status' => 'completed',
                'payment_data' => $paymentData,
            ]);
        }
        
        // تحديث حالة الطلب
        if ($order->status !== 'completed') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'paid_at' => now(),
            ]);
        } else {
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
        }
        
        // تسليم الأكواد الرقمية بعد الدفع الناجح
        $order->deliverDigitalCodes();
        
        // التحقق من وجود معرف طلب معلق في الجلسة وتفريغ سلة التسوق
        if (session()->has('pending_order_id') && session()->get('pending_order_id') == $order->id) {
            // تفريغ سلة التسوق باستخدام نموذج Cart مباشرة
            if (auth()->check()) {
                $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                if ($cart) {
                    $cart->items()->delete();
                    Log::info('تم تفريغ سلة التسوق المستخدم بعد نجاح الدفع', ['order_id' => $order->id]);
                }
            } elseif (session()->has('cart_session_id')) {
                $sessionId = session()->get('cart_session_id');
                $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
                if ($cart) {
                    $cart->items()->delete();
                    Log::info('تم تفريغ سلة التسوق الزائر بعد نجاح الدفع', ['order_id' => $order->id]);
                }
            }
            
            // إزالة معرف الطلب المعلق من الجلسة
            session()->forget('pending_order_id');
        }
        
        // زيادة عدد طلبات المستخدم
        auth()->user()->increment('orders_count');
        
        // إرسال إشعار واتساب بنجاح عملية الدفع
        try {
            // تحديد نوع الطلب (رقمي، خدمات، منتجات عادية)
            $orderTypes = [];
            foreach ($order->items as $item) {
                if ($item->orderable_type === 'App\\Models\\Product') {
                    $orderTypes[$item->orderable->type] = true;
                } elseif ($item->orderable_type === 'App\\Models\\DigitalCard') {
                    $orderTypes['digital'] = true;
                }
            }
            
            // تحديد نوع الطلب الرئيسي
            $orderType = 'عام';
            if (count($orderTypes) === 1) {
                if (isset($orderTypes['digital']) || isset($orderTypes['digital_card'])) {
                    $orderType = 'منتجات رقمية';
                } elseif (isset($orderTypes['service'])) {
                    $orderType = 'خدمات';
                } elseif (isset($orderTypes['physical'])) {
                    $orderType = 'منتجات مادية';
                }
            } else {
                // ترتيب أولوية العرض إذا كان هناك أكثر من نوع
                if (isset($orderTypes['digital']) || isset($orderTypes['digital_card'])) {
                    $orderType = 'منتجات رقمية ومنتجات أخرى';
                } elseif (isset($orderTypes['service'])) {
                    $orderType = 'خدمات ومنتجات أخرى';
                }
            }
            
            // جلب رقم هاتف المستخدم
            $phone = auth()->user()->phone;
            
            if ($phone) {
                // إرسال إشعار الدفع
                $whatsappService = app(\App\Services\WhatsApp\WhatsAppService::class);
                $whatsappService->sendMessage($phone, 'payment_complete', [
                    'customer_name' => auth()->user()->name,
                    'order_id' => $order->id,
                    'order_type' => $orderType,
                    'total_amount' => number_format($order->total, 2) . ' ' . config('app.currency', 'ريال'),
                    'payment_date' => now()->format('Y-m-d H:i'),
                    'order_url' => route('orders.show', $order->id)
                ], $order);
                
                Log::info('تم إرسال إشعار نجاح الدفع عبر واتساب', [
                    'order_id' => $order->id,
                    'phone' => $phone,
                    'order_type' => $orderType
                ]);
            } else {
                Log::warning('تعذر إرسال إشعار واتساب لعدم وجود رقم هاتف للمستخدم', [
                    'order_id' => $order->id,
                    'user_id' => auth()->id()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('خطأ أثناء إرسال إشعار واتساب بنجاح الدفع', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $order->id
            ]);
        }
    }

    /**
     * دالة اختبار وتشخيص ربط ماي فاتورة
     */
    public function testMyfatoorahDebug()
    {
        // 1. جميع طرق الدفع
        $allGateways = \App\Models\PaymentMethod::all();
        // 2. اسم قاعدة البيانات
        $dbName = \DB::connection()->getDatabaseName();
        // 3. نتيجة الاستعلام الخام
        $raw = \DB::select("SELECT * FROM payment_methods WHERE code = 'myfatoorah' AND is_active = 1");
        // 4. نتيجة الاستعلام Eloquent
        $eloquent = \App\Models\PaymentMethod::where('code', 'myfatoorah')->where('is_active', 1)->first();
        // 5. محتوى Model
        $modelFile = null;
        $modelPath = app_path('Models/PaymentMethod.php');
        if (file_exists($modelPath)) {
            $modelFile = file_get_contents($modelPath);
        }
        dd([
            'all_gateways' => $allGateways,
            'db_name' => $dbName,
            'raw_sql' => $raw,
            'eloquent' => $eloquent,
            'model_file' => $modelFile,
        ]);
    }

    /**
     * معالجة إلغاء الدفع من ماي فاتورة
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function myfatoorahCancel(Request $request)
    {
        $orderId = $request->get('order_id');
        $token = $request->get('token');
        \Log::info('إلغاء الدفع من ماي فاتورة', [
            'all_data' => $request->all(),
            'query_params' => $request->query(),
            'order_id' => $orderId,
            'token' => $token,
        ]);
        return redirect()->route('checkout.index')
            ->with('error', 'تم إلغاء عملية الدفع من قبل المستخدم أو لم تكتمل العملية. إذا تم خصم المبلغ من بطاقتك ولم يتم تأكيد الطلب، يرجى التواصل مع الدعم الفني.');
    }

    /**
     * معالجة الدفع عبر ادفع بي
     *
     * @param  int  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edfapay($order)
    {
        if (ob_get_level()) {
            ob_end_clean();
        }

        $order = $this->getUserOrder($order);
        
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'تم دفع هذا الطلب بالفعل');
        }
        
        try {
            // البحث عن طريقة الدفع
            $paymentMethod = PaymentMethod::where('code', 'edfapay')->first();
            
            if (!$paymentMethod || !$paymentMethod->is_active) {
                Log::error('طريقة الدفع ادفع بي غير متاحة أو غير مفعلة', [
                    'payment_method_exists' => (bool)$paymentMethod,
                    'is_active' => $paymentMethod ? $paymentMethod->is_active : false,
                ]);
                
                return redirect()->route('checkout.index')
                    ->with('error', 'طريقة الدفع غير متاحة حالياً');
            }
            
            // تسجيل المعلومات للتشخيص
            Log::info('بدء عملية الدفع مع ادفع بي', [
                'order_id' => $order->id,
                'payment_method' => $paymentMethod->toArray(),
            ]);
            
            // إنشاء بوابة الدفع
            $gateway = $this->createGateway($paymentMethod);
            
            // معالجة الدفع
            $response = $gateway->processPayment($order);
            
            // تسجيل الاستجابة للتشخيص
            Log::info('استجابة ادفع بي', [
                'order_id' => $order->id,
                'response' => $response,
                'has_redirect_url' => isset($response['redirect_url']),
                'redirect_url' => $response['redirect_url'] ?? null,
                'success' => $response['success'] ?? false,
            ]);
            
            // في حالة النجاح وإعادة التوجيه
            if ($response['success'] && isset($response['redirect_url']) && !empty($response['redirect_url'])) {
                // تسجيل محاولة الدفع
                $this->logPaymentAttempt($order, $paymentMethod, $response);
                
                // حفظ معرف الطلب المعلق في الجلسة
                session()->put('pending_order_id', $order->id);
                
                // تسجيل معلومات التوجيه للتشخيص
                Log::debug('تفاصيل التوجيه لبوابة ادفع بي', [
                    'redirect_url' => $response['redirect_url'],
                    'order_id' => $order->id,
                    'session_id' => session()->getId(),
                ]);
                
                return redirect($response['redirect_url']);
            }
            
            // في حالة الفشل أو عدم وجود رابط إعادة توجيه
            Log::warning('فشل في إنشاء طلب الدفع', [
                'order_id' => $order->id,
                'response' => $response,
                'message' => $response['message'] ?? 'لا توجد رسالة خطأ',
            ]);
            
            return redirect()->route('checkout.index')
                ->with('error', $response['message'] ?? 'حدث خطأ أثناء معالجة الدفع: لم نتمكن من الاتصال ببوابة الدفع');
            
        } catch (\Exception $e) {
            Log::error('EdfaPay payment error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('checkout.index')
                ->with('error', 'حدث خطأ أثناء معالجة الدفع، يرجى المحاولة مرة أخرى: ' . $e->getMessage());
        }
    }

    /**
     * معالجة الاستجابة الناجحة من بوابة ادفع بي
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edfapaySuccess(Request $request)
    {
        $orderId = $request->get('order_id');
        $token = $request->get('token');
        
        Log::info('بيانات الاستجابة الكاملة من ادفع بي - success', [
            'all_data' => $request->all(),
            'query_params' => $request->query(),
            'order_id' => $orderId,
            'token' => $token,
        ]);

        if (!$orderId || !$token) {
            return redirect()->route('checkout.index')
                ->with('error', 'رابط غير صالح أو بيانات ناقصة');
        }

        $order = Order::where('id', $orderId)
            ->where('order_token', $token)
            ->first();

        if (!$order) {
            return redirect()->route('checkout.index')
                ->with('error', 'الطلب غير موجود');
        }

        try {
            $paymentMethod = PaymentMethod::where('code', 'edfapay')->first();
            if (!$paymentMethod) {
                return redirect()->route('orders.show', $order->id)
                    ->with('error', 'طريقة الدفع غير متاحة');
            }

            $gateway = $this->createGateway($paymentMethod);
            $paymentData = array_merge($request->all(), $request->query());
            
            if ($gateway->verifyPayment($paymentData)) {
                $this->markOrderAsPaid($order, $paymentData);
                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'تم الدفع بنجاح وتأكيد الطلب');
            }

            return redirect()->route('checkout.index')
                ->with('error', 'لم يتم التحقق من عملية الدفع بنجاح');
            
        } catch (\Exception $e) {
            Log::error('EdfaPay success callback error', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('checkout.index')
                ->with('error', 'حدث خطأ أثناء معالجة استجابة الدفع: ' . $e->getMessage());
        }
    }

    /**
     * معالجة إلغاء الدفع من بوابة ادفع بي
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edfapayCancel(Request $request)
    {
        $orderId = $request->get('order_id');
        $token = $request->get('token');
        
        Log::info('بيانات الإلغاء من ادفع بي', [
            'all_data' => $request->all(),
            'query_params' => $request->query(),
            'order_id' => $orderId,
            'token' => $token,
        ]);

        return redirect()->route('checkout.index')
            ->with('error', 'تم إلغاء عملية الدفع');
    }

    /**
     * معالجة الإشعارات التلقائية من بوابة ادفع بي
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edfapayWebhook(Request $request)
    {
        Log::info('EdfaPay webhook received', $request->all());
        
        try {
            $paymentMethod = PaymentMethod::where('code', 'edfapay')->first();
            
            if (!$paymentMethod) {
                return response()->json(['error' => 'Payment method not found'], 404);
            }
            
            $gateway = $this->createGateway($paymentMethod);
            $response = $gateway->handleWebhook($request->all());
            
            if ($response['success']) {
                return response()->json(['success' => true]);
            }
            
            return response()->json(['error' => $response['message']], 400);
            
        } catch (\Exception $e) {
            Log::error('EdfaPay webhook error', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 