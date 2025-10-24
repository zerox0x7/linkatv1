# إصلاح MyFatoorah - URL الصحيح للسعودية

## التاريخ
2025-10-10

## المشكلة المكتشفة
كان النظام يستخدم URL خاطئ لـ MyFatoorah:
- ❌ **الخطأ**: `https://apitest.myfatoorah.com`
- ✅ **الصحيح**: `https://api-sa.myfatoorah.com`

## الحل المطبق ✅

### تحديث SimpleMyFatoorahGateway.php
```php
// قبل التعديل
$this->baseUrl = $this->isTest ? 'https://apitest.myfatoorah.com' : 'https://api.myfatoorah.com';

// بعد التعديل
$this->baseUrl = 'https://api-sa.myfatoorah.com'; // URL الصحيح للسعودية
```

## URLs الصحيحة حسب الدولة

| الدولة | URL |
|--------|-----|
| **السعودية** | `https://api-sa.myfatoorah.com` ✅ |
| الكويت | `https://api-kw.myfatoorah.com` |
| البحرين | `https://api-bh.myfatoorah.com` |
| الإمارات | `https://api-ae.myfatoorah.com` |
| قطر | `https://api-qa.myfatoorah.com` |
| عمان | `https://api-om.myfatoorah.com` |
| الأردن | `https://api-jo.myfatoorah.com` |
| مصر | `https://api-eg.myfatoorah.com` |

## الخطوة التالية

الآن URL صحيح، لكن لا يزال هناك خطأ **401 Unauthorized**.

هذا يعني أن **API Key غير صحيح أو منتهي الصلاحية**.

### الحل: الحصول على API Key صحيح

1. **اذهب إلى**: https://myfatoorah.com
2. **سجل دخولك** أو أنشئ حساب جديد
3. **في لوحة التحكم**: اذهب إلى "API Keys"
4. **اختر**: "Test Environment" أو "Live Environment"
5. **انسخ**: API Key الجديد
6. **حدث النظام**:
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

## الاختبار

بعد تحديث API Key:

1. **اذهب لصفحة الدفع**
2. **اختر MyFatoorah**
3. **اضغط "إتمام الطلب"**
4. **يجب أن يعمل الآن!** ✅

## البديل السريع

إذا لم تحصل على API Key صحيح فوراً:

**استخدم Paylink** - يعمل بشكل مثالي! ✅

---

**الآن URL صحيح، فقط تحتاج API Key صحيح!** 🚀
