# إعداد API Key صحيح لـ MyFatoorah

## المشكلة الحالية
```
401 Unauthorized - API key غير صحيح أو منتهي الصلاحية
```

## الحل: الحصول على API Key صحيح

### 1. تسجيل الدخول لحساب MyFatoorah
1. اذهب إلى: https://myfatoorah.com
2. سجل دخولك أو أنشئ حساب جديد
3. اذهب إلى لوحة التحكم

### 2. الحصول على API Key
1. في لوحة التحكم، اذهب إلى **"API Keys"** أو **"إعدادات المطور"**
2. اختر **"Test Environment"** للاختبار
3. انسخ **API Key** الجديد

### 3. تحديث API Key في النظام

#### الطريقة 1: عبر لوحة التحكم (إن وجدت)
1. اذهب إلى إعدادات طرق الدفع
2. اختر MyFatoorah
3. ضع API Key الجديد

#### الطريقة 2: عبر قاعدة البيانات
```sql
UPDATE payment_methods 
SET config = JSON_SET(config, '$.apiKey', 'YOUR_NEW_API_KEY_HERE')
WHERE code = 'myfatoorah';
```

#### الطريقة 3: عبر Artisan Tinker
```bash
php artisan tinker
```
```php
$paymentMethod = App\Models\PaymentMethod::where('code', 'myfatoorah')->first();
$config = $paymentMethod->config;
$config['apiKey'] = 'YOUR_NEW_API_KEY_HERE';
$paymentMethod->config = $config;
$paymentMethod->save();
echo 'API Key updated successfully!';
```

## مثال على API Key صحيح

API Key صحيح عادة يكون:
- **طول**: حوالي 100-200 حرف
- **تنسيق**: نص مشفر
- **مثال**: `rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5ThW3O7erRs1xQ3Unylg6m0vgaH9RXQjLJoTDB95HKTknLuKZR1XQbBse1T3PBlk3H3JVWX9cJR7Df4TVLmtQHfIzSYlnqHI4JTn5RqB2VvG9SvodzAr1xQNwvbFaHCkRr3RjBQIDAQAB`

## الإعدادات الصحيحة

```json
{
    "apiKey": "YOUR_REAL_API_KEY_FROM_MYFATOORAH",
    "vcCode": "SAU",
    "mode": "test"
}
```

## اختبار API Key

بعد تحديث API Key، اختبر:

```bash
php artisan tinker
```
```php
$gateway = new App\PaymentGateways\Myfatoorah\SimpleMyFatoorahGateway();
$result = $gateway->createPayment([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'mobile' => '501234567'
], 100, 'https://example.com/success', 'https://example.com/error', 'SAR');
echo 'Success! Payment URL: ' . $result;
```

## إذا لم تحصل على API Key

### البديل 1: استخدام Paylink
Paylink يعمل بشكل صحيح، يمكنك استخدامه مؤقتاً

### البديل 2: استخدام ClickPay
ClickPay أيضاً يعمل بشكل صحيح

### البديل 3: إيقاف MyFatoorah مؤقتاً
```sql
UPDATE payment_methods 
SET is_active = 0 
WHERE code = 'myfatoorah';
```

## الدعم الفني

### MyFatoorah Support
- **البريد**: support@myfatoorah.com
- **الهاتف**: متوفر في موقعهم
- **الدردشة المباشرة**: في موقعهم

### معلومات مفيدة عند التواصل
1. رسالة الخطأ: "401 Unauthorized"
2. API Key المستخدم (بدون كشفه كاملاً)
3. بيئة الاختبار
4. الدولة: السعودية

## ملاحظات مهمة

1. **API Key حساس**: لا تشاركه مع أحد
2. **بيئة الاختبار**: استخدم test API key للاختبار
3. **بيئة الإنتاج**: استخدم live API key للإنتاج فقط
4. **انتهاء الصلاحية**: API keys قد تنتهي صلاحيتها

---

**بعد الحصول على API Key صحيح، MyFatoorah ستعمل بشكل مثالي!** ✅
