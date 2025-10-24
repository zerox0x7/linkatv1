# تكامل بوابة الدفع Paylink

## نظرة عامة
تم إضافة دعم كامل لبوابة الدفع Paylink السعودية إلى النظام.

## الملفات المضافة/المعدلة

### 1. الملفات المضافة
- `app/PaymentGateways/PaylinkGateway.php` - فئة بوابة الدفع Paylink

### 2. الملفات المعدلة
- `app/Http/Controllers/PaymentController.php` - تم تعديل callbacks لتكون عامة وتدعم جميع بوابات الدفع

## الإعدادات المطلوبة

يجب أن تحتوي طريقة الدفع Paylink في جدول `payment_methods` على البيانات التالية في عمود `config`:

```json
{
    "api_id": "APP_ID_1631587500860",
    "secret_key": "35e8bf7d-6c74-496a-88ed-c149f2dfbb00",
    "mode": "test"
}
```

### الحقول:
- **api_id**: معرف التطبيق من Paylink
- **secret_key**: المفتاح السري من Paylink
- **mode**: وضع التشغيل (test للتجريبي، live للحي)

## كيفية العمل

### 1. عملية الدفع (processPayment)
عندما يختار المستخدم Paylink كوسيلة دفع:
1. يتم إنشاء فاتورة في Paylink عبر API endpoint: `/api/addInvoice`
2. يتم إرسال تفاصيل الطلب والمنتجات
3. تستجيب Paylink برابط الدفع (payment URL)
4. يتم توجيه المستخدم إلى صفحة الدفع في Paylink
5. بعد الدفع، يتم توجيه المستخدم إلى callback URL

### 2. التحقق من الدفع (verifyPayment)
عند العودة من بوابة الدفع:
1. يتم استلام `transactionNo` و `orderNumber` من Paylink
2. يتم الاستعلام عن حالة الفاتورة عبر API endpoint: `/api/getInvoice/{transactionNo}`
3. يتم التحقق من `orderStatus` - إذا كانت "Paid" فالدفع ناجح
4. يتم تحديث حالة الطلب في النظام

### 3. Webhook (handleWebhook)
يمكن لـ Paylink إرسال إشعارات تلقائية عند تغير حالة الدفع:
1. يستلم النظام البيانات من Paylink
2. يتم التحقق من `orderStatus`
3. يتم تحديث الطلب والدفع في قاعدة البيانات

## Routes المستخدمة

يستخدم Paylink نفس routes الموجودة للبوابات الأخرى:

```php
// النجاح
route('payment.callback.success', ['order_id' => $order->id, 'token' => $order->order_token])

// الإلغاء
route('payment.callback.cancel', ['order_id' => $order->id, 'token' => $order->order_token])
```

## التحديثات على PaymentController

تم تحديث `clickpaySuccess` و `clickpayCancel` methods لتكون عامة وتدعم جميع بوابات الدفع:

**التحديثات الرئيسية:**
1. استخدام `$order->payment_method` بدلاً من hardcode
2. إضافة دعم للبحث بـ `order_number` كبديل لـ `order_token`
3. إضافة تسجيل لـ `transactionNo` و `orderNumber` من Paylink

## API Endpoints المستخدمة

### Base URL
```
https://restpilot.paylink.sa
```

### Endpoints
1. **المصادقة**: `POST /api/auth`
2. **إنشاء فاتورة**: `POST /api/addInvoice`
3. **الاستعلام عن فاتورة**: `GET /api/getInvoice/{transactionNo}`

### المصادقة (Authentication Flow)

يتطلب Paylink **خطوتين للمصادقة**:

#### الخطوة 1: الحصول على id_token
إرسال طلب POST إلى `/api/auth`:

```json
{
    "apiId": "APP_ID_1631587500860",
    "secretKey": "35e8bf7d-6c74-496a-88ed-c149f2dfbb00",
    "persistToken": false
}
```

**persistToken**:
- `false`: التوكن صالح لمدة **30 دقيقة**
- `true`: التوكن صالح لمدة **30 ساعة**

**الاستجابة**:
```json
{
    "id_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

#### الخطوة 2: استخدام id_token في باقي الطلبات
استخدم `id_token` المُستلم في Authorization header:

```
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

## البيانات المرسلة لـ Paylink

```json
{
    "amount": 100.00,
    "callBackUrl": "https://yoursite.com/payment/callback/success?order_id=1&token=xxx",
    "cancelUrl": "https://yoursite.com/payment/callback/cancel?order_id=1&token=xxx",
    "clientEmail": "customer@example.com",
    "clientMobile": "0501234567",
    "clientName": "اسم العميل",
    "note": "طلب رقم: ORD-XXXXXXXXXX",
    "orderNumber": "ORD-XXXXXXXXXX",
    "products": [
        {
            "title": "اسم المنتج",
            "price": 50.00,
            "qty": 2,
            "description": "وصف المنتج",
            "isDigital": true
        }
    ],
    "supportedCardBrands": ["mada", "visaMastercard", "amex"],
    "displayPending": true
}
```

## حالات الطلب (orderStatus)

- **Paid**: تم الدفع بنجاح ✅
- **Pending**: في انتظار الدفع ⏳
- **Canceled**: تم الإلغاء ❌

## Logging

جميع العمليات يتم تسجيلها في `storage/logs/laravel.log`:
- البيانات المرسلة لـ Paylink
- الاستجابة من Paylink
- حالة التحقق من الدفع
- أي أخطاء تحدث

## الاختبار

للاختبار:
1. تأكد من أن `mode` في config مضبوط على `test`
2. استخدم بيانات الاختبار من Paylink
3. اختر Paylink كطريقة دفع في صفحة الدفع
4. أكمل عملية الدفع في صفحة Paylink
5. تحقق من السجلات (logs) لمتابعة سير العملية

## ملاحظات مهمة

1. **الأمان**: يجب التأكد من أن `order_token` فريد ومعقد بما يكفي
2. **HTTPS**: يجب استخدام HTTPS في بيئة الإنتاج
3. **Timeout**: تم ضبط timeout على 30 ثانية للطلبات
4. **Currency**: العملة الافتراضية هي SAR (ريال سعودي)
5. **Products**: يتم وضع `isDigital: true` لجميع المنتجات

## استكشاف الأخطاء

### المشكلة: لا يتم التوجيه لصفحة الدفع
**الحل**: تحقق من:
- صحة `api_id` و `secret_key`
- اتصال الخادم بالإنترنت
- السجلات (logs) لمعرفة الخطأ

### المشكلة: لا يتم تحديث حالة الطلب بعد الدفع
**الحل**: تحقق من:
- صحة callback URLs
- أن الخادم يمكن الوصول إليه من الإنترنت
- السجلات لمعرفة ما يتم استلامه

### المشكلة: رسالة خطأ "طريقة الدفع غير متاحة"
**الحل**: تأكد من:
- وجود Paylink في جدول `payment_methods`
- أن `code` في الجدول هو `paylink` بالضبط
- أن `is_active = 1`

## الدعم الفني

في حالة وجود مشاكل:
1. راجع السجلات في `storage/logs/laravel.log`
2. تحقق من وثائق Paylink API
3. تواصل مع الدعم الفني لـ Paylink

---

**تاريخ الإنشاء**: 2025-10-10
**الإصدار**: 1.0

