# Icon Picker Component - دليل الاستخدام

## نظرة عامة

مكون `IconPicker` هو مكون Livewire قابل لإعادة الاستخدام يوفر واجهة سهلة لاختيار أيقونات Remix في مشروعك. يمكن استخدامه في أي نموذج أو مودال أو صفحة إعدadات.

## المميزات

- ✅ واجهة بحث سريعة للأيقونات
- ✅ تصنيف الأيقونات حسب الفئات
- ✅ تصميم متجاوب ومتوافق مع الموضوع المظلم
- ✅ دعم كامل للغة العربية
- ✅ قابل للتخصيص والتكامل
- ✅ يعمل مع جميع نماذج Laravel
- ✅ أحداث Livewire للتفاعل المتقدم

## التثبيت والإعداد

### 1. التأكد من توفر Remix Icons

تأكد من إضافة Remix Icons إلى مشروعك:

```html
<!-- في head section -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
```

### 2. إضافة الأنماط المطلوبة

تأكد من وجود الكلاسات التالية في CSS الخاص بك:

```css
.bg-primary { background-color: #00d4aa; }
.text-primary { color: #00d4aa; }
.border-primary { border-color: #00d4aa; }
.ring-primary { --tw-ring-color: #00d4aa; }
```

## كيفية الاستخدام

### الاستخدام الأساسي

```blade
@livewire('icon-picker')
```

### مع المعاملات المخصصة

```blade
@livewire('icon-picker', [
    'fieldName' => 'service_icon',
    'label' => 'أيقونة الخدمة',
    'placeholder' => 'اختر أيقونة للخدمة',
    'selectedIcon' => 'ri-store-line'
])
```

### في النماذج

```blade
<form method="POST">
    @csrf
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300 mb-2">اسم الخدمة</label>
        <input type="text" name="name" class="form-input">
    </div>
    
    <div class="mb-4">
        @livewire('icon-picker', [
            'fieldName' => 'icon',
            'label' => 'الأيقونة',
            'selectedIcon' => old('icon')
        ])
    </div>
    
    <button type="submit">حفظ</button>
</form>
```

### في المودال

```blade
<!-- Modal Content -->
<div class="modal-body">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <input type="text" placeholder="العنوان">
        </div>
        <div>
            @livewire('icon-picker', [
                'fieldName' => 'modal_icon',
                'label' => 'الأيقونة'
            ])
        </div>
    </div>
</div>
```

## المعاملات المتاحة

| المعامل | النوع | الافتراضي | الوصف |
|---------|------|----------|-------|
| `selectedIcon` | string | '' | الأيقونة المحددة مسبقاً |
| `fieldName` | string | 'icon' | اسم الحقل في النموذج |
| `placeholder` | string | 'اختر أيقونة' | النص التوضيحي |
| `label` | string | 'الأيقونة' | تسمية الحقل |

## عرض الأيقونات في المشروع

### الطريقة الأساسية

```blade
<i class="{{ $service['icon'] }}"></i>
```

### مع النص

```blade
<div class="flex items-center">
    <i class="{{ $service['icon'] }} text-lg ml-2"></i>
    <span>{{ $service['name'] }}</span>
</div>
```

### في البطاقات

```blade
<div class="card">
    <div class="card-icon">
        <i class="{{ $category['icon'] }} text-2xl text-primary"></i>
    </div>
    <h3>{{ $category['name'] }}</h3>
</div>
```

### في القوائم

```blade
@foreach($services as $service)
    <li class="flex items-center p-3 border-b">
        <i class="{{ $service['icon'] }} text-primary ml-3"></i>
        <span>{{ $service['name'] }}</span>
    </li>
@endforeach
```

## الأحداث المتاحة

### الاستماع لحدث اختيار الأيقونة

```javascript
document.addEventListener('livewire:init', () => {
    Livewire.on('iconSelected', (event) => {
        console.log('تم اختيار الأيقونة:', event.icon);
        console.log('اسم الحقل:', event.fieldName);
        
        // يمكنك إضافة منطق مخصص هنا
        updatePreview(event.icon);
    });
});
```

### في مكون Livewire آخر

```php
class MyComponent extends Component
{
    protected $listeners = ['iconSelected'];
    
    public function iconSelected($data)
    {
        $this->selectedIcon = $data['icon'];
        // منطق إضافي
    }
}
```

## التخصيص

### إضافة أيقونات جديدة

يمكنك تعديل ملف `app/Livewire/IconPicker.php` لإضافة فئات أو أيقونات جديدة:

```php
public $icons = [
    'custom_category' => [
        'ri-new-icon-1',
        'ri-new-icon-2',
        // ... المزيد من الأيقونات
    ],
    // ... الفئات الموجودة
];
```

### تغيير التصميم

يمكنك تخصيص ملف `resources/views/livewire/icon-picker.blade.php` لتغيير:
- الألوان
- الأحجام
- التخطيط
- النصوص

## أمثلة متقدمة

### مع التحقق من الصحة

```blade
<div class="mb-4">
    @livewire('icon-picker', [
        'fieldName' => 'icon',
        'label' => 'الأيقونة *',
        'selectedIcon' => old('icon')
    ])
    
    @error('icon')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
```

### في مصفوفة ديناميكية

```blade
@foreach($services as $index => $service)
    <div class="service-item">
        @livewire('icon-picker', [
            'fieldName' => "services[{$index}][icon]",
            'label' => "أيقونة الخدمة #{$index + 1}",
            'selectedIcon' => $service['icon'] ?? ''
        ])
    </div>
@endforeach
```

### مع معاينة مباشرة

```blade
<div class="grid grid-cols-2 gap-6">
    <div>
        @livewire('icon-picker', [
            'fieldName' => 'category_icon',
            'label' => 'أيقونة الفئة'
        ])
    </div>
    
    <div id="icon-preview" class="flex items-center justify-center h-32 bg-gray-100 rounded-lg">
        <i id="preview-icon" class="text-4xl text-gray-400"></i>
    </div>
</div>

<script>
Livewire.on('iconSelected', (event) => {
    document.getElementById('preview-icon').className = event.icon + ' text-4xl text-primary';
});
</script>
```

## استكشاف الأخطاء

### المشكلة: الأيقونات لا تظهر
**الحل:** تأكد من تضمين Remix Icons CSS

### المشكلة: التصميم لا يبدو صحيحاً
**الحل:** تأكد من وجود كلاسات Tailwind و primary colors

### المشكلة: الأحداث لا تعمل
**الحل:** تأكد من تضمين @livewireScripts

## الدعم والمساهمة

لأي استفسارات أو اقتراحات، يمكنك:
- إنشاء issue جديد
- إرسال pull request
- التواصل مع فريق التطوير

---

**ملاحظة:** هذا المكون مصمم للعمل مع Laravel Livewire v3 وأحدث. 