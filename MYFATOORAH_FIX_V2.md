# إصلاح مشكلة MyFatoorah - الإصدار 2

## التاريخ
2025-10-10

## المشكلة المستمرة
بعد تثبيت مكتبة MyFatoorah، استمر ظهور الخطأ:
```
Kindly review your MyFatoorah admin configuration due to a wrong entry
```

## التحليل
المشكلة كانت في طريقة استخدام مكتبة MyFatoorah:
1. **الطريقة القديمة**: استخدام `MyFatoorahPayment` class
2. **المشكلة**: المكتبة تتطلب إعدادات مختلفة أو API key غير صحيح
3. **الحل**: إنشاء gateway مبسط يستخدم HTTP requests مباشرة

## الحل الجديد ✅

### إنشاء SimpleMyFatoorahGateway

تم إنشاء `SimpleMyFatoorahGateway.php` الذي:
- ✅ يستخدم GuzzleHttp مباشرة بدلاً من مكتبة MyFatoorah المعقدة
- ✅ يرسل HTTP requests مباشرة لـ MyFatoorah API
- ✅ معالجة أفضل للأخطاء
- ✅ تسجيل مفصل للعمليات

### التحديثات المطبقة

#### 1. إنشاء SimpleMyFatoorahGateway
```php
class SimpleMyFatoorahGateway
{
    protected $apiKey;
    protected $isTest;
    protected $countryCode;
    protected $baseUrl;

    public function __construct()
    {
        // جلب الإعدادات من قاعدة البيانات
        $paymentMethod = \App\Models\PaymentMethod::where('code', 'myfatoorah')->first();
        $config = $paymentMethod->config;
        
        $this->apiKey = $config['apiKey'];
        $this->isTest = $paymentMethod->mode === 'test';
        $this->countryCode = $config['vcCode'] ?? 'SAU';
        $this->baseUrl = $this->isTest ? 'https://apitest.myfatoorah.com' : 'https://api.myfatoorah.com';
    }
}
```

#### 2. إنشاء الدفع بـ HTTP مباشر
```php
public function createPayment(array $customer, $amount, $successUrl, $errorUrl, $currency = 'SAR')
{
    $client = new Client();
    
    $payload = [
        'CustomerName' => $customer['name'],
        'CustomerEmail' => $customer['email'],
        'CustomerMobile' => $mobile, // تمت معالجته
        'InvoiceValue' => (float)$amount,
        'DisplayCurrencyIso' => $currency,
        'CallBackUrl' => $successUrl,
        'ErrorUrl' => $errorUrl,
    ];

    $response = $client->post($this->baseUrl . '/v2/SendPayment', [
        'headers' => [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ],
        'json' => $payload,
    ]);
    
    $result = json_decode($response->getBody(), true);
    
    if (isset($result['IsSuccess']) && $result['IsSuccess'] === true) {
        return $result['Data']['InvoiceURL'];
    } else {
        throw new \Exception('خطأ من MyFatoorah: ' . $result['Message']);
    }
}
```

#### 3. تحديث PaymentMethod model
```php
// في PaymentMethod.php
if ($this->code === 'myfatoorah') {
    $gatewayClass = 'App\\PaymentGateways\\Myfatoorah\\SimpleMyFatoorahGateway'; // ✅ الجديد
}
```

#### 4. تحديث PaymentController
```php
// في PaymentController.php
$gateway = new \App\PaymentGateways\Myfatoorah\SimpleMyFatoorahGateway(); // ✅ الجديد
```

## المميزات الجديدة

### 1. تسجيل مفصل
```php
Log::info('MyFatoorah API Response', [
    'payload' => $payload,
    'response' => $result,
]);
```

### 2. معالجة أفضل للأخطاء
```php
if (isset($result['IsSuccess']) && $result['IsSuccess'] === true) {
    // نجح
} else {
    $errorMessage = $result['Message'] ?? 'خطأ غير معروف';
    Log::error('MyFatoorah Payment Error', ['error' => $errorMessage]);
    throw new \Exception('خطأ من MyFatoorah: ' . $errorMessage);
}
```

### 3. معالجة رقم الجوال
```php
// معالجة تلقائية لرقم الجوال
$mobile = preg_replace('/[^0-9]/', '', $mobile);
if (preg_match('/^9665[0-9]{8}$/', $mobile)) {
    $mobile = substr($mobile, 3); // إزالة 966
}
if (preg_match('/^05[0-9]{8}$/', $mobile)) {
    $mobile = substr($mobile, 1); // إزالة 0
}
```

### 4. URLs صحيحة
```php
$baseUrl = $this->isTest ? 'https://apitest.myfatoorah.com' : 'https://api.myfatoorah.com';
```

## الإعدادات المطلوبة

في جدول `payment_methods`:

```json
{
    "apiKey": "YOUR_API_KEY_HERE",
    "vcCode": "SAU",
    "mode": "test"
}
```

**ملاحظة مهمة**: تأكد من أن API key صحيح ومناسب للبيئة (test أو live).

## API Endpoints المستخدمة

### Test Environment
```
POST https://apitest.myfatoorah.com/v2/SendPayment
```

### Production Environment
```
POST https://api.myfatoorah.com/v2/SendPayment
```

### Headers المطلوبة
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

## البيانات المرسلة

```json
{
    "CustomerName": "اسم العميل",
    "CustomerEmail": "customer@example.com",
    "CustomerMobile": "501234567",
    "InvoiceValue": 100.00,
    "DisplayCurrencyIso": "SAR",
    "CallBackUrl": "https://yoursite.com/payment/myfatoorah/success",
    "ErrorUrl": "https://yoursite.com/payment/myfatoorah/cancel"
}
```

## الاستجابة المتوقعة

### نجاح
```json
{
    "IsSuccess": true,
    "Message": "تم إنشاء الفاتورة بنجاح",
    "Data": {
        "InvoiceURL": "https://apitest.myfatoorah.com/invoice/123456"
    }
}
```

### فشل
```json
{
    "IsSuccess": false,
    "Message": "Kindly review your MyFatoorah admin configuration due to a wrong entry"
}
```

## استكشاف الأخطاء

### 1. تحقق من API Key
```bash
# في terminal
php artisan tinker
>>> $pm = App\Models\PaymentMethod::where('code', 'myfatoorah')->first();
>>> echo strlen($pm->config['apiKey']); // يجب أن يكون أكثر من 100
```

### 2. تحقق من Mode
```bash
>>> echo $pm->mode; // يجب أن يكون test أو live
```

### 3. تحقق من Country Code
```bash
>>> echo $pm->config['vcCode']; // يجب أن يكون SAU للريال السعودي
```

### 4. راقب السجلات
```bash
tail -f storage/logs/laravel.log | grep -i myfatoorah
```

## إذا استمر الخطأ

### 1. تحقق من API Key
- تأكد من أن API key صحيح
- تأكد من أن API key مناسب للبيئة (test/live)
- احصل على API key جديد من لوحة تحكم MyFatoorah

### 2. تحقق من الإعدادات
```sql
SELECT code, mode, config FROM payment_methods WHERE code = 'myfatoorah';
```

### 3. تواصل مع دعم MyFatoorah
- البريد: support@myfatoorah.com
- الموقع: https://myfatoorah.com
- اذكر لهم رسالة الخطأ الكاملة

## الملفات المحدثة

1. ✅ `app/PaymentGateways/Myfatoorah/SimpleMyFatoorahGateway.php` - جديد
2. ✅ `app/Models/PaymentMethod.php` - تحديث gateway class
3. ✅ `app/Http/Controllers/PaymentController.php` - تحديث gateway class
4. ✅ `MYFATOORAH_FIX_V2.md` - هذا الملف

## الاختبار

### 1. جرب الدفع
1. اذهب لصفحة الدفع
2. اختر **MyFatoorah**
3. اضغط "إتمام الطلب"
4. يجب أن يتم توجيهك لصفحة MyFatoorah

### 2. راقب السجلات
```bash
tail -f storage/logs/laravel.log | grep -i "MyFatoorah API Response"
```

ستشاهد:
```
[INFO] MyFatoorah API Response: {"payload": {...}, "response": {...}}
```

## مقارنة بين الطريقتين

| الطريقة القديمة | الطريقة الجديدة |
|-----------------|------------------|
| MyFatoorahPayment class | HTTP requests مباشرة |
| مكتبة معقدة | GuzzleHttp بسيط |
| أخطاء غامضة | رسائل خطأ واضحة |
| تسجيل محدود | تسجيل مفصل |
| صعبة التشخيص | سهلة التشخيص |

---

**الإصدار**: 2.0  
**التاريخ**: 2025-10-10  
**الحالة**: جاهز للاختبار ✅

**الآن جرب الدفع بـ MyFatoorah مرة أخرى!**
