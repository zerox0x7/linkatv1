# Icon Select Input Component - دليل الاستخدام

## نظرة عامة

مكون `IconSelectInput` هو بديل للقائمة المنسدلة التقليدية، مصمم خصيصاً لاختيار الأيقونات مع تكامل مباشر مع `wire:model`.

## المميزات

- ✅ **تكامل wire:model**: يعمل مباشرة مع نماذج Livewire
- ✅ **نفس التصميم**: يحافظ على نفس مظهر النماذج الموجودة
- ✅ **أيقونات شاملة**: أكثر من 100 أيقونة منظمة في فئات
- ✅ **بحث تفاعلي**: إمكانية البحث عن الأيقونات
- ✅ **سهولة الاستخدام**: استبدال مباشر للـ select

## الاستخدام الأساسي

### 1. استبدال القائمة المنسدلة العادية

**من:**
```blade
<select wire:model="new_service.icon" class="custom-input p-3 rounded-md w-full">
    <option value="ri-truck-line">توصيل</option>
    <option value="ri-shield-check-line">ضمان</option>
    <!-- ... المزيد من الخيارات -->
</select>
```

**إلى:**
```blade
@livewire('icon-select-input', [
    'value' => $new_service['icon'] ?? '',
    'label' => '',
    'placeholder' => 'اختر أيقونة',
    'wireModel' => 'new_service.icon'
], key('service-icon-'.now()))
```

### 2. في النماذج

```blade
<div class="flex flex-col gap-2">
    <label class="text-sm font-medium text-right">أيقونة الخدمة</label>
    @livewire('icon-select-input', [
        'value' => old('icon', $service->icon ?? ''),
        'placeholder' => 'اختر أيقونة',
        'wireModel' => 'service.icon'
    ])
</div>
```

## المعاملات المتاحة

| المعامل | النوع | الافتراضي | الوصف |
|---------|------|----------|-------|
| `value` | string | '' | القيمة المحددة مسبقاً |
| `label` | string | '' | تسمية الحقل (اختيارية) |
| `placeholder` | string | 'اختر أيقونة' | النص التوضيحي |
| `customClass` | string | 'custom-input p-3 rounded-md w-full' | فئات CSS |
| `wireModel` | string | '' | مسار الخاصية في Livewire |

## الأيقونات المتاحة

المكون يحتوي على أكثر من 100 أيقونة منظمة في فئات:

### 🚚 الخدمات والتوصيل
- `ri-truck-line` - توصيل
- `ri-ship-line` - شحن
- `ri-plane-line` - طيران
- `ri-car-line` - سيارة
- `ri-bike-line` - دراجة
- `ri-subway-line` - مترو

### 🛡️ الدعم والأمان
- `ri-shield-check-line` - ضمان  
- `ri-customer-service-2-line` - دعم فني
- `ri-refund-2-line` - استرجاع
- `ri-security-scan-line` - أمان
- `ri-lock-line` - حماية
- `ri-key-line` - مفتاح

### 🏆 الجودة والجوائز
- `ri-award-line` - جودة
- `ri-medal-line` - ميدالية
- `ri-trophy-line` - كأس
- `ri-vip-crown-line` - تاج
- `ri-star-line` - تقييم
- `ri-star-fill` - تقييم مملوء

### 🛒 التسوق والتجارة
- `ri-price-tag-line` - أسعار
- `ri-shopping-cart-line` - سلة التسوق
- `ri-shopping-bag-line` - حقيبة تسوق
- `ri-store-line` - متجر
- `ri-store-2-line` - متجر 2
- `ri-building-line` - مبنى
- `ri-bank-line` - بنك

### 📞 التواصل
- `ri-phone-line` - هاتف
- `ri-mail-line` - بريد
- `ri-chat-1-line` - محادثة
- `ri-message-line` - رسالة
- `ri-notification-line` - إشعار
- `ri-headphone-line` - سماعة

### 👥 المستخدمون والفرق
- `ri-user-line` - مستخدم
- `ri-user-star-line` - مستخدم نجم
- `ri-team-line` - فريق
- `ri-group-line` - مجموعة
- `ri-admin-line` - مدير
- `ri-parent-line` - والد

### 💻 التكنولوجيا والأدوات
- `ri-settings-line` - إعدادات
- `ri-tools-line` - أدوات
- `ri-computer-line` - كمبيوتر
- `ri-smartphone-line` - هاتف ذكي
- `ri-tablet-line` - لوح
- `ri-tv-line` - تلفزيون
- `ri-gamepad-line` - ألعاب
- `ri-camera-line` - كاميرا
- `ri-video-line` - فيديو

### ❤️ المفضلة والاجتماعي
- `ri-heart-line` - مفضلة
- `ri-heart-fill` - مفضلة مملوء
- `ri-thumb-up-line` - إعجاب
- `ri-share-line` - مشاركة
- `ri-bookmark-line` - مرجعية

### 📍 الموقع والوقت
- `ri-home-line` - منزل
- `ri-map-pin-line` - موقع
- `ri-compass-line` - بوصلة
- `ri-road-map-line` - خريطة طريق
- `ri-time-line` - وقت
- `ri-calendar-line` - تاريخ
- `ri-timer-line` - مؤقت
- `ri-history-line` - تاريخ

### 💰 الأعمال والمالية
- `ri-money-dollar-circle-line` - دولار
- `ri-coin-line` - عملة
- `ri-bank-card-line` - بطاقة بنكية
- `ri-wallet-line` - محفظة
- `ri-exchange-line` - صرف
- `ri-funds-line` - أموال
- `ri-profit-line` - ربح

### 📚 التعليم والتعلم
- `ri-book-line` - كتاب
- `ri-graduation-cap-line` - تخرج
- `ri-pencil-line` - قلم
- `ri-presentation-line` - عرض
- `ri-lightbulb-line` - فكرة
- `ri-brain-line` - عقل

### 🏥 الصحة والعافية
- `ri-heart-pulse-line` - نبض
- `ri-medicine-bottle-line` - دواء
- `ri-first-aid-kit-line` - إسعافات
- `ri-mental-health-line` - صحة نفسية
- `ri-run-line` - جري
- `ri-bike-line` - رياضة

### 🍽️ الطعام والمطاعم
- `ri-restaurant-line` - مطعم
- `ri-cake-line` - كيك
- `ri-cup-line` - كوب
- `ri-beer-line` - مشروب
- `ri-knife-line` - سكين

### 🎉 الترفيه والمتعة
- `ri-gift-line` - هدية
- `ri-fire-line` - شائع
- `ri-flashlight-line` - مصباح
- `ri-magic-line` - سحر
- `ri-palette-line` - لوحة ألوان
- `ri-music-line` - موسيقى
- `ri-movie-line` - فيلم

### 🌤️ الطقس والطبيعة
- `ri-sun-line` - شمس
- `ri-moon-line` - قمر
- `ri-cloud-line` - سحابة
- `ri-plant-line` - نبات
- `ri-tree-line` - شجرة
- `ri-leaf-line` - ورقة

### ✈️ السفر والنقل
- `ri-suitcase-line` - حقيبة سفر
- `ri-passport-line` - جواز سفر
- `ri-hotel-line` - فندق
- `ri-flight-takeoff-line` - إقلاع
- `ri-earth-line` - أرض
- `ri-global-line` - عالمي

### 📄 المستندات والملفات
- `ri-file-line` - ملف
- `ri-folder-line` - مجلد
- `ri-article-line` - مقال
- `ri-clipboard-line` - حافظة
- `ri-contract-line` - عقد
- `ri-download-line` - تنزيل
- `ri-upload-line` - رفع

## إعداد المكون الأساسي

### في Livewire Component

```php
class YourComponent extends Component
{
    protected $listeners = ['updateWireModel'];
    
    public $service = ['icon' => 'ri-truck-line'];
    
    public function updateWireModel($property, $value)
    {
        $keys = explode('.', $property);
        $target = &$this;
        
        for ($i = 0; $i < count($keys) - 1; $i++) {
            $target = &$target->{$keys[$i]};
        }
        
        $target[end($keys)] = $value;
    }
}
```

## أمثلة الاستخدام

### 1. خدمة بسيطة
```blade
@livewire('icon-select-input', [
    'value' => 'ri-truck-line',
    'wireModel' => 'service_icon'
])
```

### 2. مع تسمية
```blade
@livewire('icon-select-input', [
    'value' => $product->icon,
    'label' => 'أيقونة المنتج',
    'wireModel' => 'product.icon'
])
```

### 3. مع فئات مخصصة
```blade
@livewire('icon-select-input', [
    'value' => '',
    'customClass' => 'form-control bg-white text-dark',
    'wireModel' => 'category.icon'
])
```

## العرض في الواجهة

بعد اختيار الأيقونة، يمكنك عرضها في أي مكان:

```blade
<i class="{{ $service['icon'] }} text-white text-2xl"></i>
```

---

**ملاحظة:** هذا المكون مُحسّن للاستخدام مع نماذج Livewire ويحافظ على نفس تصميم مشروعك الحالي. 