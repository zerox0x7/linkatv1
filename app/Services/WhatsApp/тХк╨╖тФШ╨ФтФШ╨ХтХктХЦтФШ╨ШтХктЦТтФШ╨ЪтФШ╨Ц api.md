Resource URL:
https://dl1s.co/api/send
Structure of the POST request body:
Content-Type: application/json
{
"number": "{int}",
"type": "text",
"message": "{string}",
"instance_id": "609ACF283XXXX",
"access_token": "65772560a21de"
}
Send a text message to a phone number through the app
المعلمات
number	84933313xxx
type	text
message	test message
instance_id	609ACF283XXXX
access_token	65772560a21de


الهيكل المتقرح
app/
├── Services/
│   ├── WhatsApp/
│   │   ├── WhatsAppService.php      # الخدمة الرئيسية لإرسال الرسائل
│   │   ├── WhatsAppConfig.php       # إعدادات API الخاص بك
│   │   └── WhatsAppTemplates.php    # قوالب الرسائل
│   └── OTP/
│       └── OTPService.php           # خدمة إدارة أكواد التحقق
├── Notifications/
│   ├── OrderStatusChanged.php       # إشعارات تغيير حالة الطلب  
│   ├── OrderDelivered.php           # إشعارات تسليم المنتجات
│   └── OTPNotification.php          # إشعارات أكواد التحقق
├── Models/
│   └── OTPCode.php                  # نموذج كود التحقق
└── Http/
    └── Controllers/
        ├── Auth/
        │   └── WhatsAppAuthController.php  # تسجيل الدخول بالواتساب
        └── Api/
            └── WhatsAppWebhookController.php  # التعامل مع الردود