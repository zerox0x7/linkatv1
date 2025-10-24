# تحديث Paylink v2.0 - الطريقة الصحيحة للمصادقة

## التاريخ
2025-10-10

## المشكلة السابقة
كان الكود يحاول استخدام `secret_key` مباشرة في Authorization header، مما أدى إلى:
```
403 Forbidden: "Invalid Token"
```

## الحل الصحيح ✅

Paylink يتطلب **خطوتين للمصادقة** (Two-Step Authentication):

### الخطوة 1: الحصول على id_token
```
POST /api/auth
```

**البيانات المرسلة:**
```json
{
    "apiId": "APP_ID_1631587500860",
    "secretKey": "35e8bf7d-6c74-496a-88ed-c149f2dfbb00",
    "persistToken": false
}
```

**الاستجابة:**
```json
{
    "id_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

### الخطوة 2: استخدام id_token
استخدم `id_token` في جميع طلبات API الأخرى:
```
Authorization: Bearer {id_token}
```

## التغييرات في الكود

### 1. إضافة Method جديد: `getAuthToken()`

```php
protected function getAuthToken(): ?string
{
    try {
        $client = new Client([
            'verify' => true,
            'timeout' => 30,
        ]);
        
        $response = $client->post($this->getBaseUrl() . '/api/auth', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'apiId' => $this->getApiId(),
                'secretKey' => $this->getSecretKey(),
                'persistToken' => false, // Token صالح لمدة 30 دقيقة
            ],
        ]);
        
        $result = json_decode($response->getBody(), true);
        
        Log::info('نجح الحصول على token من Paylink', [
            'has_token' => isset($result['id_token']),
            'api_id' => $this->getApiId(),
        ]);
        
        return $result['id_token'] ?? null;
        
    } catch (\Exception $e) {
        Log::error('فشل الحصول على token من Paylink', [
            'error' => $e->getMessage(),
            'api_id' => $this->getApiId(),
        ]);
        
        throw new \Exception('فشل المصادقة مع Paylink: ' . $e->getMessage());
    }
}
```

### 2. تحديث `processPayment()`

**قبل:**
```php
$response = $client->post($this->getBaseUrl() . '/api/addInvoice', [
    'headers' => [
        'Authorization' => $this->getSecretKey(),  // ❌ خاطئ
    ],
    'json' => $payload,
]);
```

**بعد:**
```php
// الحصول على id_token أولاً
$authToken = $this->getAuthToken();  // ✅

if (!$authToken) {
    return $this->formatResponse([
        'success' => false,
        'message' => 'فشل الحصول على توكن المصادقة من Paylink',
    ]);
}

$response = $client->post($this->getBaseUrl() . '/api/addInvoice', [
    'headers' => [
        'Authorization' => 'Bearer ' . $authToken,  // ✅ صحيح
    ],
    'json' => $payload,
]);
```

### 3. تحديث `verifyPayment()`

**قبل:**
```php
$response = $client->get($this->getBaseUrl() . '/api/getInvoice/' . $transactionNo, [
    'headers' => [
        'Authorization' => $this->getSecretKey(),  // ❌ خاطئ
    ],
]);
```

**بعد:**
```php
// الحصول على id_token أولاً
$authToken = $this->getAuthToken();  // ✅

if (!$authToken) {
    Log::error('فشل الحصول على token للتحقق من الدفع');
    return false;
}

$response = $client->get($this->getBaseUrl() . '/api/getInvoice/' . $transactionNo, [
    'headers' => [
        'Authorization' => 'Bearer ' . $authToken,  // ✅ صحيح
    ],
]);
```

## persistToken Options

- **`false`**: التوكن صالح لمدة **30 دقيقة** (مناسب للاستخدام الفوري)
- **`true`**: التوكن صالح لمدة **30 ساعة** (للاستخدام طويل الأمد)

في التطبيق الحالي نستخدم `false` لأننا نحصل على token جديد مع كل طلب دفع.

## Flow العملية الكاملة

```
1. المستخدم يختار Paylink في صفحة الدفع
   ↓
2. CheckoutController يستدعي PaylinkGateway->processPayment()
   ↓
3. PaylinkGateway يستدعي getAuthToken()
   ├─→ POST /api/auth مع apiId و secretKey
   ├─→ يستلم id_token
   └─→ يرجع id_token
   ↓
4. PaylinkGateway يستخدم id_token لإنشاء الفاتورة
   ├─→ POST /api/addInvoice مع Authorization: Bearer {id_token}
   ├─→ يستلم رابط الدفع (url)
   └─→ يوجه المستخدم لرابط الدفع
   ↓
5. المستخدم يدفع في صفحة Paylink
   ↓
6. Paylink توجه المستخدم للعودة مع transactionNo
   ↓
7. PaymentController يستدعي PaylinkGateway->verifyPayment()
   ├─→ يستدعي getAuthToken() مرة أخرى
   ├─→ GET /api/getInvoice/{transactionNo} مع token جديد
   ├─→ يتحقق من orderStatus
   └─→ إذا كانت "Paid" يحدث الطلب
```

## الاختبار

### اختبر Authentication أولاً:
```bash
curl -X POST https://restpilot.paylink.sa/api/auth \
  -H "Content-Type: application/json" \
  -d '{
    "apiId": "APP_ID_1631587500860",
    "secretKey": "35e8bf7d-6c74-496a-88ed-c149f2dfbb00",
    "persistToken": false
  }'
```

**يجب أن تحصل على:**
```json
{
    "id_token": "eyJ..."
}
```

### ثم اختبر إنشاء فاتورة:
```bash
# استبدل {TOKEN} بـ id_token من الخطوة السابقة
curl -X POST https://restpilot.paylink.sa/api/addInvoice \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 100,
    "clientName": "Test",
    "clientEmail": "test@test.com",
    "clientMobile": "0501234567",
    "orderNumber": "TEST-001",
    "callBackUrl": "https://yoursite.com/callback",
    "products": [...]
  }'
```

## ملاحظات مهمة

1. **Token Expiry**: التوكن ينتهي بعد 30 دقيقة (persistToken: false)
   - الحل: نحن نطلب token جديد مع كل عملية

2. **Performance**: كل عملية تحتاج طلبين API (auth + action)
   - يمكن تحسينها لاحقاً بـ caching للتوكنات

3. **Error Handling**: إذا فشل الحصول على token، العملية تفشل كاملة
   - يتم تسجيل الخطأ في logs

4. **Security**: لا تشارك `secret_key` أو `id_token` مع أحد
   - يتم تسجيل length فقط في logs للخصوصية

## الملفات المحدثة

1. ✅ `app/PaymentGateways/PaylinkGateway.php`
   - إضافة `getAuthToken()` method
   - تحديث `processPayment()`
   - تحديث `verifyPayment()`

2. ✅ `PAYLINK_INTEGRATION.md`
   - شرح Authentication Flow

3. ✅ `PAYLINK_TROUBLESHOOTING.md`
   - أمثلة curl محدثة
   - خطوات استكشاف الأخطاء

4. ✅ `PAYLINK_UPDATE_V2.md` (هذا الملف)
   - ملخص التغييرات

## ماذا تتوقع الآن

عند اختيار Paylink في الدفع:

1. ✅ يظهر في logs: "نجح الحصول على token من Paylink"
2. ✅ يظهر في logs: "البيانات المرسلة إلى بوابة Paylink"
3. ✅ يظهر في logs: "تم استلام رابط الدفع من Paylink"
4. ✅ يتم توجيهك لصفحة الدفع في Paylink
5. ✅ بعد الدفع، يتم تحديث حالة الطلب تلقائياً

## إذا ظهر خطأ

راجع `storage/logs/laravel.log` وابحث عن:
- "فشل الحصول على token من Paylink" → مشكلة في apiId/secretKey
- "خطأ من Paylink API" → مشكلة في البيانات المرسلة
- "Invalid Token" → مشكلة في المصادقة (يجب ألا يحدث الآن!)

---

**الإصدار**: 2.0  
**التاريخ**: 2025-10-10  
**الحالة**: جاهز للاختبار ✅

