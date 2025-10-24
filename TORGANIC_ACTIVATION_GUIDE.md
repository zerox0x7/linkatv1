# دليل تفعيل ثيم Torganic

## المشكلة
عند محاولة تفعيل ثيم torganic، لا يظهر التصميم الصحيح في الموقع.

## السبب
النظام يستخدم نظام Multi-Store حيث كل متجر لديه ثيم خاص به محفوظ في حقل `active_theme` في جدول `users`، وليس في جدول `settings`.

## الحل

### الطريقة الأولى: عبر Tinker (السريعة)

1. افتح Terminal واذهب إلى مجلد المشروع:
```bash
cd /home/rami/Desktop/linkat-main
```

2. قم بتفعيل ثيم torganic لجميع المتاجر:
```bash
php artisan tinker --execute="\\App\\Models\\User::where('role', 'admin')->update(['active_theme' => 'torganic']); echo 'Theme updated';"
```

3. امسح الكاش:
```bash
php artisan cache:clear && php artisan view:clear && php artisan config:clear
```

### الطريقة الثانية: عبر قاعدة البيانات

1. افتح قاعدة البيانات
2. نفذ هذا الأمر SQL:
```sql
UPDATE users SET active_theme = 'torganic' WHERE role = 'admin';
```

3. امسح الكاش من Terminal:
```bash
php artisan cache:clear && php artisan view:clear
```

### الطريقة الثالثة: عبر لوحة التحكم (إذا كانت متوفرة)

1. اذهب إلى لوحة التحكم
2. اختر "الإعدادات" أو "إعدادات المتجر"
3. ابحث عن خيار "الثيم النشط" أو "Active Theme"
4. اختر "torganic" من القائمة
5. احفظ التغييرات

## التحقق من التفعيل

بعد تطبيق أي من الطرق أعلاه، افتح الموقع في المتصفح وستجد:
- تصميم Torganic الحديث والجذاب
- الألوان الخضراء المميزة للثيم
- تصميم responsive يناسب جميع الأجهزة
- صفحات مكتملة: الرئيسية، المنتجات، السلة، الخروج

## الصفحات المتوفرة في ثيم Torganic

✅ **الصفحة الرئيسية** (`home.blade.php`)
- بنر رئيسي جذاب
- عرض الفئات مع slider
- عرض المنتجات المميزة

✅ **صفحة المنتجات** (`products/index.blade.php`)
- عرض شبكي للمنتجات
- فلترة وبحث متقدم

✅ **صفحة المنتج الفردي** (`products/show.blade.php`)
- تفاصيل المنتج كاملة
- معرض الصور
- إضافة للسلة

✅ **صفحة السلة** (`cart/index.blade.php`)
- عرض محتويات السلة
- تحديث الكميات
- حساب الإجمالي

✅ **صفحة الدفع** (`checkout/index.blade.php`)
- نموذج إتمام الطلب
- خيارات الدفع

✅ **صفحات المصادقة** (`auth/login.blade.php`, `auth/register.blade.php`)
- تسجيل الدخول
- إنشاء حساب جديد

## الأصول (Assets)

جميع ملفات CSS, JS, والصور موجودة في:
```
public/themes/torganic/assets/
├── css/
│   ├── bootstrap.min.css
│   ├── style.css
│   ├── aos.css
│   ├── all.min.css
│   └── swiper-bundle.min.css
├── js/
│   ├── bootstrap.bundle.min.js
│   ├── custom.js
│   ├── swiper-bundle.min.js
│   └── ...
└── images/
    ├── banner/
    ├── product/
    ├── logo/
    └── ...
```

## المشاكل الشائعة

### المشكلة: الثيم لا يزال لا يظهر
**الحل:**
```bash
# امسح جميع أنواع الكاش
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear

# ثم قم بإعادة تحميل الصفحة مع Ctrl+F5 (لمسح كاش المتصفح)
```

### المشكلة: CSS أو JS لا يعمل
**الحل:**
تأكد من أن مجلد `public/themes/torganic/assets/` موجود وبه جميع الملفات.

### المشكلة: تظهر أخطاء في الصفحة
**الحل:**
تحقق من الـ logs في `storage/logs/laravel.log`

## دعم إضافي

إذا واجهت أي مشاكل:
1. تحقق من الـ logs
2. تأكد من أن جميع ملفات الثيم موجودة
3. تأكد من أن قاعدة البيانات محدثة
4. جرب مسح الكاش مرة أخرى

---

تم التحديث: أكتوبر 2025

