# Torganic Theme Documentation

## نظرة عامة
تم إنشاء ثيم **Torganic** بنجاح بناءً على قالب HTML الخاص بـ Torganic وباستخدام بنية ثيم greenGame الحالي كمرجع.

## هيكل الثيم

### المجلدات والملفات

```
resources/views/themes/torganic/
├── layouts/
│   └── app.blade.php          # القالب الرئيسي للثيم
├── pages/
│   ├── home.blade.php         # الصفحة الرئيسية
│   ├── products/
│   │   ├── index.blade.php    # صفحة قائمة المنتجات
│   │   ├── show.blade.php     # صفحة تفاصيل المنتج
│   │   └── search.blade.php   # صفحة نتائج البحث
│   ├── cart/
│   │   └── index.blade.php    # صفحة سلة التسوق
│   ├── checkout/
│   │   └── index.blade.php    # صفحة إتمام الطلب
│   ├── auth/
│   │   ├── login.blade.php    # صفحة تسجيل الدخول
│   │   └── register.blade.php # صفحة التسجيل
│   ├── profile/
│   │   └── show.blade.php     # صفحة الملف الشخصي
│   └── orders/
│       └── index.blade.php    # صفحة الطلبات
└── partials/
    ├── header.blade.php       # الهيدر
    ├── footer.blade.php       # الفوتر
    └── alerts.blade.php       # رسائل النظام

public/themes/torganic/
└── assets/
    ├── css/                   # ملفات CSS
    ├── js/                    # ملفات JavaScript
    ├── images/                # الصور والأيقونات
    └── webfonts/              # الخطوط
```

## الميزات

### 1. Layout الرئيسي (app.blade.php)
- يدعم SEO بشكل كامل (Open Graph, Twitter Cards)
- يتضمن Meta Tags الديناميكية
- يدعم الأكواد المخصصة (CSS/JS)
- متوافق مع إعدادات المتجر

### 2. الصفحات الرئيسية

#### الصفحة الرئيسية (home.blade.php)
- عرض بانر ترحيبي
- عرض الفئات المميزة (Swiper Slider)
- عرض المنتجات الحديثة

#### صفحة المنتجات (products/index.blade.php)
- عرض شبكي للمنتجات (Grid Layout)
- دعم Pagination
- عرض شارات الخصومات
- أزرار إضافة للسلة

#### صفحة تفاصيل المنتج (products/show.blade.php)
- صورة المنتج
- الوصف والسعر
- معلومات المخزون
- نموذج إضافة للسلة بكمية

#### سلة التسوق (cart/index.blade.php)
- جدول المنتجات
- تحديث الكميات
- حذف المنتجات
- ملخص الطلب

#### صفحة الدفع (checkout/index.blade.php)
- نموذج معلومات العميل
- اختيار طريقة الدفع
- ملخص الطلب

### 3. صفحات المستخدم

#### تسجيل الدخول (auth/login.blade.php)
- نموذج تسجيل دخول
- خيار "تذكرني"
- رابط استعادة كلمة المرور

#### التسجيل (auth/register.blade.php)
- نموذج إنشاء حساب جديد
- التحقق من البيانات

#### الملف الشخصي (profile/show.blade.php)
- عرض معلومات المستخدم
- تحديث البيانات الشخصية
- تغيير كلمة المرور

#### الطلبات (orders/index.blade.php)
- عرض جميع الطلبات
- حالة الطلبات
- تفاصيل كل طلب

## الأصول (Assets)

### CSS Files
- `bootstrap.min.css` - إطار Bootstrap
- `aos.css` - مكتبة الأنيميشن
- `all.min.css` - Font Awesome Icons
- `swiper-bundle.min.css` - مكتبة Swiper للـ Slider
- `style.css` - الأنماط الرئيسية للثيم

### JavaScript Files
- `bootstrap.bundle.min.js` - Bootstrap JS
- `aos.js` - مكتبة الأنيميشن
- `swiper-bundle.min.js` - Swiper Slider
- `custom.js` - السكريبتات المخصصة
- `trk-menu.js` - قائمة التنقل

## التفعيل والاستخدام

### 1. التأكد من نسخ الأصول
تم نسخ جميع ملفات Assets من `template _torganic` إلى `public/themes/torganic/assets`

### 2. الوصول إلى الثيم
- يمكن الوصول للثيم عبر تغيير الثيم في إعدادات المتجر
- أو عبر تعديل ملف Controller المسؤول عن عرض الصفحات

### 3. التخصيص
- جميع الصفحات تستخدم إعدادات المتجر الديناميكية
- يمكن تخصيص الألوان والصور من لوحة التحكم
- الثيم يدعم اللغة العربية بشكل كامل (RTL)

## الملاحظات الهامة

### 1. الاعتمادات
- الثيم مبني على قالب Torganic HTML الأصلي
- تم تحويل HTML إلى Blade templates
- تم دمج البيانات الديناميكية من قاعدة البيانات

### 2. التوافق
- متوافق مع Laravel
- متوافق مع Livewire
- يدعم Bootstrap 5
- يدعم Font Awesome 6

### 3. المتطلبات
- Laravel 8+
- PHP 7.4+
- MySQL/MariaDB
- Composer
- Node.js & NPM (للتطوير)

## الصيانة والتحديثات

### إضافة صفحات جديدة
1. إنشاء ملف Blade جديد في `resources/views/themes/torganic/pages/`
2. استخدام `@extends('theme::layouts.app')` للامتداد من Layout الرئيسي
3. إضافة المحتوى في `@section('content')`

### تعديل الأنماط
1. تعديل ملف `public/themes/torganic/assets/css/style.css`
2. أو إضافة CSS مخصص في إعدادات المتجر

### تعديل السكريبتات
1. تعديل ملف `public/themes/torganic/assets/js/custom.js`
2. أو إضافة JS مخصص في إعدادات المتجر

## الدعم الفني

لأي استفسارات أو مشاكل:
- راجع ملف التوثيق هذا
- تحقق من ملفات greenGame كمرجع
- تأكد من تفعيل جميع الإعدادات المطلوبة

## الإصدار
- **الإصدار:** 1.0.0
- **تاريخ الإنشاء:** أكتوبر 2025
- **آخر تحديث:** أكتوبر 2025

---

تم إنشاء هذا الثيم بنجاح وجاهز للاستخدام! 🎉

