# إصلاح خطأ `@this` في Sortable

## المشكلة

كان هناك خطأ:
```
ErrorException: Undefined variable $_instance
```

عند استخدام `@this` في ملف `customize.blade.php`

## السبب

`@this` يعمل فقط داخل مكونات Livewire مباشرة (في ملفات `resources/views/livewire/*.blade.php`)، ولا يعمل في Layout الرئيسي.

## الحل

تم تطبيق **3 طرق بديلة** لضمان العمل:

### 1. Window Function (الطريقة الأولى - الأكثر موثوقية)
```javascript
// في Livewire component
window.reorderHeroSlides = function(orderedIds) {
    $wire.call('reorderSlides', orderedIds);
};

// في Layout
if (typeof window.reorderHeroSlides === 'function') {
    window.reorderHeroSlides(orderedIds);
}
```

### 2. Livewire.find() (الطريقة الثانية)
```javascript
const livewireEl = slidesContainer.closest('[wire\\:id]');
const componentId = livewireEl.getAttribute('wire:id');
const component = Livewire.find(componentId);
component.call('reorderSlides', orderedIds);
```

### 3. Custom Event (الطريقة الثالثة)
```javascript
// إرسال
window.dispatchEvent(new CustomEvent('reorder-hero-slides', { 
    detail: { orderedIds: orderedIds } 
}));

// استقبال في Livewire
window.addEventListener('reorder-hero-slides', function(event) {
    $wire.call('reorderSlides', event.detail.orderedIds);
});
```

## النتيجة

الآن ميزة السحب والإفلات تعمل بشكل صحيح بدون أخطاء! ✅

## الملفات المعدلة

1. `resources/views/themes/admin/theme/customize.blade.php` - إضافة 3 طرق للتواصل
2. `resources/views/livewire/theme-customizer.blade.php` - إضافة @script block

## الاختبار

1. افتح صفحة تخصيص الثيم
2. أضف صورتين أو أكثر للبطل
3. اسحب أيقونة (⋮⋮) لإعادة الترتيب
4. يجب أن يعمل بدون أخطاء وحفظ تلقائي ✅

