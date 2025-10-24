# دليل نظام إشعارات الواتساب

## الهيكل العام للنظام

```
app/
├── Services/
│   └── WhatsApp/
│       ├── WhatsAppService.php      # الخدمة الرئيسية (الإرسال والإعدادات والقوالب)
│       └── README.md                # توثيق النظام 
├── Models/
│   ├── WhatsAppTemplate.php         # نموذج قوالب الواتساب (موجود)
│   └── WhatsAppLog.php              # نموذج سجلات الإرسال (موجود)
├── Events/
│   └── WhatsAppEvents.php           # جميع أحداث الواتساب في ملف واحد
├── Listeners/
│   └── WhatsAppNotificationListener.php  # مستمع موحد لجميع الأحداث
└── Http/
    └── Controllers/
        └── Admin/
            └── WhatsAppController.php  # لوحة الإدارة (موجود)## طريقة التعامل مع النظام

### 1. إرسال إشعار مباشرة

يمكن استخدام الخدمة مباشرة عند الحاجة لإرسال إشعار فوري:

```php
// استدعاء الخدمة
$whatsAppService = app(\App\Services\WhatsApp\WhatsAppService::class);

// إرسال رسالة
$whatsAppService->sendMessage(
    $phone,         // رقم الهاتف
    'template_type', // نوع القالب
    [               // معاملات القالب
        'param1' => 'value1',
        'param2' => 'value2',
    ],
    $relatedModel   // الكائن المرتبط (اختياري)
);

// وظائف جاهزة للاستخدام
$whatsAppService->sendOrderStatusUpdate($order, 'processing');
$whatsAppService->sendDeliveryNotification($order);
$whatsAppService->sendOTP($phone, $otp, $user);
$whatsAppService->sendLoginCode($phone, $code);
```

### 2. النهج الموصى به: استخدام نظام الأحداث (Events)

لتحقيق فصل أفضل للمسؤوليات والتماسك في التطبيق، يُفضل استخدام نظام الأحداث:

```php
// إطلاق حدث تحديث حالة الطلب
event(new \App\Events\OrderStatusUpdated($order, 'processing'));

// إطلاق حدث استلام الدفع
event(new \App\Events\PaymentReceived($payment));

// إطلاق حدث إنشاء طلب جديد
event(new \App\Events\OrderCreated($order));
```

نظام الاستماع للأحداث سيقوم تلقائياً بمعالجة الإشعارات المناسبة.

## إضافة قوالب جديدة

يجب إضافة قوالب الرسائل الجديدة في قاعدة البيانات من خلال:

1. الذهاب إلى لوحة التحكم > الإعدادات > قوالب الواتساب
2. إنشاء قالب جديد مع تحديد:
   - النوع (type): المعرف الفريد للقالب (مثل: "order_status")
   - المحتوى (content): نص القالب مع معاملات بين أقواس مثل: {customer_name}
   - الحالة (is_active): تفعيل/تعطيل القالب

## تتبع وسجلات الإرسال

يتم تسجيل جميع محاولات الإرسال في جدول `whatsapp_logs` ويمكن تتبعها من:

1. لوحة التحكم > التقارير > سجلات الواتساب
2. عرض تفاصيل كل رسالة (الحالة، رقم الهاتف، المحتوى، وقت الإرسال)
3. إمكانية إعادة إرسال الرسائل الفاشلة

## التوصيات لتطوير النظام

### إضافة أنواع إشعارات جديدة:

1. إنشاء حدث جديد في `app/Events/`
2. إنشاء مستمع للحدث في `app/Listeners/`
3. تسجيل الحدث والمستمع في `app/Providers/EventServiceProvider.php`
4. إضافة وظيفة مناسبة في `WhatsAppService` للتعامل مع نوع الإشعار الجديد
5. إضافة قالب جديد في قاعدة البيانات

### تحسين إدارة الخطأ:

- استخدام آلية إعادة المحاولة للرسائل الفاشلة
- تنفيذ نظام تنبيه للرسائل الحرجة الفاشلة
- تحسين تسجيل الأخطاء والتشخيص

## معلومات API

لمزيد من المعلومات حول الـ API المستخدم، راجع ملف `المطورين api.md` 