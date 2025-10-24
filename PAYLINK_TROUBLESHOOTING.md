# استكشاف أخطاء Paylink وحلولها

## الخطأ: "Invalid Token" - 403 Forbidden

### السبب
هذا الخطأ يحدث عندما تكون بيانات المصادقة (Authentication) غير صحيحة أو غير مكتملة.

### الحلول المطبقة ✅

تم تحديث طريقة المصادقة في `PaylinkGateway.php` لتستخدم **Authentication Flow الصحيح**:

**الطريقة الصحيحة** (خطوتين):

1. **أولاً**: الحصول على `id_token` من `/api/auth`:
```php
protected function getAuthToken(): ?string
{
    $response = $client->post($this->getBaseUrl() . '/api/auth', [
        'json' => [
            'apiId' => $this->getApiId(),
            'secretKey' => $this->getSecretKey(),
            'persistToken' => false, // Token صالح لمدة 30 دقيقة
        ],
    ]);
    
    $result = json_decode($response->getBody(), true);
    return $result['id_token'] ?? null;
}
```

2. **ثانياً**: استخدام `id_token` في طلبات API:
```php
'headers' => [
    'Authorization' => 'Bearer ' . $authToken,
]
```

### التحقق من البيانات

تأكد من أن `secret_key` في جدول `payment_methods` صحيح:

```sql
SELECT code, config FROM payment_methods WHERE code = 'paylink';
```

يجب أن يكون الناتج:
```json
{
    "api_id": "APP_ID_1631587500860",
    "secret_key": "35e8bf7d-6c74-496a-88ed-c149f2dfbb00",
    "mode": "test"
}
```

### اختبار المصادقة يدوياً

يمكنك اختبار المصادقة باستخدام `curl`:

**الخطوة 1: الحصول على id_token**
```bash
curl -X POST https://restpilot.paylink.sa/api/auth \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "apiId": "APP_ID_1631587500860",
    "secretKey": "35e8bf7d-6c74-496a-88ed-c149f2dfbb00",
    "persistToken": false
  }'
```

سيكون الناتج شيئاً مثل:
```json
{
  "id_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

**الخطوة 2: إنشاء فاتورة باستخدام id_token**
```bash
curl -X POST https://restpilot.paylink.sa/api/addInvoice \
  -H "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..." \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "amount": 100,
    "clientName": "Test User",
    "clientEmail": "test@example.com",
    "clientMobile": "0501234567",
    "orderNumber": "TEST-001",
    "callBackUrl": "https://yoursite.com/callback",
    "cancelUrl": "https://yoursite.com/cancel",
    "products": [
      {
        "title": "Test Product",
        "price": 100,
        "qty": 1,
        "description": "Test",
        "isDigital": true
      }
    ]
  }'
```

### إذا استمر الخطأ

1. **تحقق من صحة secret_key:**
   - قد يكون القديم أو منتهي الصلاحية
   - احصل على secret_key جديد من لوحة تحكم Paylink

2. **تحقق من Environment:**
   - تأكد من استخدام الـ API credentials الصحيحة (test أو live)
   - استخدم credentials مختلفة لبيئة الاختبار والإنتاج

3. **تحقق من IP Whitelisting:**
   - قد تحتاج إلى إضافة IP الخادم إلى القائمة البيضاء في Paylink
   - تواصل مع دعم Paylink لتفعيل IP الخادم

4. **راجع السجلات:**
   ```bash
   tail -f storage/logs/laravel.log | grep -i paylink
   ```

## أخطاء شائعة أخرى

### الخطأ: "Client error: 404 Not Found"

**السبب:** رابط API خاطئ

**الحل:**
```php
// تأكد من استخدام:
https://restpilot.paylink.sa/api/addInvoice
// وليس:
https://api.paylink.sa/addInvoice
```

### الخطأ: "Missing required parameters"

**السبب:** بيانات مفقودة في الطلب

**الحل:** تأكد من وجود جميع الحقول المطلوبة:
- amount
- clientName
- clientEmail
- clientMobile
- orderNumber
- callBackUrl
- products

### الخطأ: "Invalid callback URL"

**السبب:** Paylink لا يمكنها الوصول إلى callback URL

**الحلول:**
1. تأكد من أن الموقع متاح على الإنترنت (ليس localhost)
2. استخدم HTTPS في بيئة الإنتاج
3. تأكد من أن Firewall لا يمنع Paylink من الوصول

### الخطأ: "لم يتم العثور على رابط الدفع في استجابة Paylink"

**السبب:** الاستجابة من Paylink لا تحتوي على `url`

**الحل:**
1. راجع السجلات لمعرفة الاستجابة الكاملة
2. قد تكون هناك رسالة خطأ من Paylink
3. تحقق من صحة جميع البيانات المرسلة

## نصائح للاختبار

### 1. استخدم بيئة التجريب أولاً
```json
{
    "mode": "test"
}
```

### 2. فعّل Logging المفصل
في `config/logging.php`، تأكد من أن المستوى على `debug`:
```php
'level' => 'debug',
```

### 3. راقب السجلات
```bash
# في نافذة terminal منفصلة
tail -f storage/logs/laravel.log
```

### 4. استخدم Postman للاختبار
قبل الاختبار في الموقع، جرب API مباشرة باستخدام Postman:
- Method: POST
- URL: https://restpilot.paylink.sa/api/addInvoice
- Headers:
  - Authorization: YOUR_SECRET_KEY
  - Content-Type: application/json
  - Accept: application/json

## الحصول على المساعدة

### 1. دعم Paylink
- الموقع: https://paylink.sa
- البريد الإلكتروني: support@paylink.sa
- الهاتف: (متوفر في موقعهم)

### 2. معلومات مفيدة عند التواصل
قدم المعلومات التالية:
- APP_ID الخاص بك
- رسالة الخطأ الكاملة
- مثال على الطلب المرسل (بدون sensitive data)
- الاستجابة المستلمة

### 3. السجلات
احفظ السجلات من `storage/logs/laravel.log` التي تحتوي على:
- البيانات المرسلة لـ Paylink
- الاستجابة المستلمة
- أي رسائل خطأ

---

**تم التحديث**: 2025-10-10
**الإصدار**: 1.1

