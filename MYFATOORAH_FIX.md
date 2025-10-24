# إصلاح مشكلة MyFatoorah

## التاريخ
2025-10-10

## المشكلة الأصلية
```
حدث خطأ أثناء معالجة الدفع: require(/home/rami/Desktop/linkat-main/app/PaymentGateways/Myfatoorah/composer/../myfatoorah/library/autoload.php): Failed to open stream: No such file or directory
```

## السبب
1. **مكتبة MyFatoorah مفقودة**: لم تكن مثبتة في `vendor/`
2. **التحميل اليدوي غير صحيح**: الكود كان يحاول تحميل autoload من مجلد محلي غير موجود
3. **Autoload محلي يبحث عن ملفات مفقودة**: `autoload_files.php` كان يحاول تحميل `myfatoorah/library/autoload.php` الذي لم يكن موجوداً

## الحل المطبق ✅

### 1. تثبيت مكتبة MyFatoorah
```bash
composer require myfatoorah/laravel-package
```

**النتيجة:**
- ✅ تم تثبيت `myfatoorah/laravel-package` v2.2.4
- ✅ تم تثبيت `myfatoorah/library` v2.2.8
- ✅ المكتبة الآن موجودة في `vendor/myfatoorah/`

### 2. إزالة التحميل اليدوي من MyFatoorahGateway.php

**قبل:**
```php
public function __construct()
{
    require_once app_path('PaymentGateways/Myfatoorah/autoload.php'); // ❌
    // ...
}
```

**بعد:**
```php
public function __construct()
{
    // لا حاجة لتحميل autoload يدوياً - Laravel autoload يتعامل مع المكتبة تلقائياً ✅
    // ...
}
```

### 3. إزالة التحميل اليدوي من PaymentController.php

**قبل:**
```php
try {
    require_once app_path('PaymentGateways/Myfatoorah/autoload.php'); // ❌
    $gateway = new \App\PaymentGateways\Myfatoorah\MyFatoorahGateway();
    // ...
}
```

**بعد:**
```php
try {
    // لا حاجة لتحميل autoload يدوياً - Laravel autoload يتعامل مع المكتبة تلقائياً ✅
    $gateway = new \App\PaymentGateways\Myfatoorah\MyFatoorahGateway();
    // ...
}
```

### 4. إنشاء autoload placeholder (اختياري)
تم إنشاء ملف `/app/PaymentGateways/Myfatoorah/myfatoorah/library/autoload.php` كـ placeholder لتجنب أي مشاكل محتملة.

## بنية المكتبة الآن

```
vendor/
└── myfatoorah/
    ├── laravel-package/     ← Laravel package
    │   ├── config/
    │   ├── resources/
    │   └── src/
    └── library/             ← Core library
        ├── autoload.php     ← موجود الآن!
        └── src/
            └── API/
                └── Payment/
                    └── MyFatoorahPayment.php
```

## كيفية عمل MyFatoorah الآن

### 1. اختيار MyFatoorah في صفحة الدفع
```php
// في CheckoutController
$gateway = $paymentMethod->createGateway(); // ينشئ MyFatoorahGateway
$result = $gateway->processPayment($order);
```

### 2. إنشاء الدفع
```php
// في MyFatoorahGateway
$paymentUrl = $this->mf->getInvoiceURL($postFields);
// يرجع رابط الدفع من MyFatoorah
```

### 3. التوجيه للدفع
المستخدم يتم توجيهه لصفحة MyFatoorah للدفع

### 4. العودة بعد الدفع
```php
// Route: payment.myfatoorah.success
public function myfatoorahSuccess(Request $request)
{
    // التحقق من الدفع
    $result = $gateway->verifyPayment($paymentId);
    // تحديث حالة الطلب
}
```

## الإعدادات المطلوبة

في جدول `payment_methods`، يجب أن يحتوي سجل MyFatoorah على:

```json
{
    "apiKey": "YOUR_API_KEY_HERE",
    "vcCode": "SAU",
    "mode": "test"
}
```

### الحقول:
- **apiKey**: مفتاح API من MyFatoorah
- **vcCode**: كود الدولة (SAU, KWT, BHR, ARE, QAT, OMN, JOR, EGY)
- **mode**: test أو live

### العملات المدعومة وأكواد الدول:
- SAR → SAU (السعودية)
- KWD → KWT (الكويت)
- BHD → BHR (البحرين)
- AED → ARE (الإمارات)
- QAR → QAT (قطر)
- OMR → OMN (عمان)
- JOD → JOR (الأردن)
- EGP → EGY (مصر)

## Routes المستخدمة

```php
// عرض صفحة الدفع
Route::get('/payment/myfatoorah/{order}', 'PaymentController@myfatoorah')
    ->name('payment.myfatoorah');

// Callback بعد الدفع الناجح
Route::match(['GET', 'POST'], '/payment/myfatoorah/success', 'PaymentController@myfatoorahSuccess')
    ->name('payment.myfatoorah.success');

// Callback عند الإلغاء
Route::match(['GET', 'POST'], '/payment/myfatoorah/cancel', 'PaymentController@myfatoorahCancel')
    ->name('payment.myfatoorah.cancel');

// Webhook من MyFatoorah
Route::post('/payment/myfatoorah/webhook', 'PaymentController@myfatoorahWebhook')
    ->name('payment.myfatoorah.webhook');
```

## الاختبار

### 1. تأكد من التثبيت:
```bash
composer show myfatoorah/laravel-package
```

يجب أن يظهر:
```
name     : myfatoorah/laravel-package
version  : 2.2.4
```

### 2. اختبر الدفع:
1. اذهب لصفحة الدفع
2. اختر **MyFatoorah**
3. اضغط "إتمام الطلب"
4. يجب أن يتم توجيهك لصفحة MyFatoorah

### 3. راقب السجلات:
```bash
tail -f storage/logs/laravel.log | grep -i myfatoorah
```

## معالجة رقم الجوال

MyFatoorah تتطلب رقم الجوال بصيغة معينة. الكود يعالج الرقم تلقائياً:

```php
// مثال: 966501234567 → 501234567
// مثال: 0501234567 → 501234567
// مثال: 5012345678 → 501234567 (أول 9 أرقام)
```

## استكشاف الأخطاء

### خطأ: "بوابة ماي فاتورة غير مفعلة أو غير موجودة"
**الحل:**
```sql
UPDATE payment_methods 
SET is_active = 1 
WHERE code = 'myfatoorah';
```

### خطأ: "Invalid API Key"
**الحل:** تحقق من صحة `apiKey` في config

### خطأ: "Invalid vcCode"
**الحل:** تأكد من أن `vcCode` يطابق العملة (SAU للريال السعودي)

### خطأ: "Invalid Mobile Number"
**الحل:** الكود يعالج الرقم تلقائياً، لكن تأكد أن المستخدم لديه رقم جوال

## الملفات المحدثة

1. ✅ `composer.json` - إضافة myfatoorah/laravel-package
2. ✅ `composer.lock` - تحديث dependencies
3. ✅ `app/PaymentGateways/Myfatoorah/MyFatoorahGateway.php` - إزالة require_once
4. ✅ `app/Http/Controllers/PaymentController.php` - إزالة require_once
5. ✅ `app/PaymentGateways/Myfatoorah/myfatoorah/library/autoload.php` - placeholder

## ملاحظات مهمة

1. **لا تحذف `vendor/myfatoorah/`** - المكتبة مطلوبة للعمل
2. **استخدم HTTPS** في بيئة الإنتاج
3. **احفظ API Keys بشكل آمن** - لا تشاركها أو تنشرها
4. **اختبر في Test Mode أولاً** قبل الإنتاج

## الدعم

- **وثائق MyFatoorah**: https://myfatoorah.readme.io
- **GitHub**: https://github.com/my-fatoorah/laravel
- **الدعم الفني**: support@myfatoorah.com

---

**الإصدار**: 1.0  
**التاريخ**: 2025-10-10  
**الحالة**: تم الإصلاح ✅

