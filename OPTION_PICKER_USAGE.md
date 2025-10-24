# Option Picker Component - الدليل الشامل

## نظرة عامة

مكون `OptionPicker` هو مكون Livewire مرن وقابل للتخصيص يمكنه استبدال أي قائمة اختيار في مشروعك. يدعم المكون أنواع مختلفة من العروض والاختيار المتعدد والبحث.

## المميزات الرئيسية

- ✅ **مرونة تامة**: يمكن استخدامه لأي نوع من الخيارات
- ✅ **أنواع عرض متعددة**: نص، أيقونات، ألوان، صور، شارات
- ✅ **اختيار متعدد**: إمكانية اختيار خيارات متعددة مع حد أقصى
- ✅ **بحث ذكي**: البحث في العناوين والأوصاف
- ✅ **واجهة عربية**: دعم كامل للغة العربية مع RTL
- ✅ **تصميم متجاوب**: يعمل على جميع الأجهزة
- ✅ **أحداث Livewire**: للتفاعل المتقدم
- ✅ **سهولة التكامل**: يعمل مع النماذج وقواعد البيانات

## أنواع العروض المدعومة

### 1. النص (text)
```blade
@livewire('option-picker', [
    'options' => ['key1' => 'قيمة 1', 'key2' => 'قيمة 2'],
    'displayType' => 'text'
])
```

### 2. الأيقونات (icon)
```blade
@livewire('option-picker', [
    'options' => [
        ['value' => 'store', 'label' => 'متجر', 'icon' => 'ri-store-line'],
        ['value' => 'phone', 'label' => 'هاتف', 'icon' => 'ri-phone-line']
    ],
    'displayType' => 'icon'
])
```

### 3. الألوان (color)
```blade
@livewire('option-picker', [
    'options' => [
        ['value' => '#3B82F6', 'label' => 'أزرق', 'color' => '#3B82F6'],
        ['value' => '#10B981', 'label' => 'أخضر', 'color' => '#10B981']
    ],
    'displayType' => 'color'
])
```

### 4. الصور (image)
```blade
@livewire('option-picker', [
    'options' => [
        ['value' => '1', 'label' => 'منتج 1', 'image' => '/path/to/image1.jpg'],
        ['value' => '2', 'label' => 'منتج 2', 'image' => '/path/to/image2.jpg']
    ],
    'displayType' => 'image'
])
```

### 5. الشارات (badge)
```blade
@livewire('option-picker', [
    'options' => [
        ['value' => '1', 'label' => 'منتج', 'category' => 'إلكترونيات'],
        ['value' => '2', 'label' => 'خدمة', 'category' => 'استشارات']
    ],
    'displayType' => 'badge'
])
```

## المعاملات المتاحة

| المعامل | النوع | الافتراضي | الوصف |
|---------|------|----------|-------|
| `options` | array | [] | مصفوفة الخيارات |
| `selectedValue` | string/array | '' | القيمة المحددة مسبقاً |
| `fieldName` | string | 'option' | اسم الحقل في النموذج |
| `label` | string | 'الخيار' | تسمية الحقل |
| `placeholder` | string | 'اختر خياراً' | النص التوضيحي |
| `displayType` | string | 'text' | نوع العرض (text, icon, color, image, badge) |
| `searchable` | boolean | true | إمكانية البحث |
| `multiple` | boolean | false | الاختيار المتعدد |
| `maxSelections` | int | null | الحد الأقصى للاختيارات |
| `emptyMessage` | string | 'لا توجد خيارات' | رسالة عدم وجود خيارات |
| `searchPlaceholder` | string | 'ابحث...' | نص البحث التوضيحي |

## تنسيقات البيانات المدعومة

### 1. مصفوفة بسيطة (Key-Value)
```php
$options = [
    'key1' => 'قيمة 1',
    'key2' => 'قيمة 2',
    'key3' => 'قيمة 3'
];
```

### 2. مصفوفة مُنسقة
```php
$options = [
    [
        'value' => 'unique_id',
        'label' => 'العنوان المعروض',
        'description' => 'وصف اختياري',
        'icon' => 'ri-icon-name',
        'color' => '#FF5733',
        'image' => '/path/to/image.jpg',
        'category' => 'فئة'
    ]
];
```

### 3. من قاعدة البيانات (Eloquent)
```php
// Controller
$categories = Category::all()->map(function($category) {
    return [
        'value' => $category->id,
        'label' => $category->name,
        'description' => $category->description,
        'icon' => $category->icon,
        'color' => $category->color
    ];
})->toArray();
```

## أمثلة الاستخدام العملية

### 1. اختيار فئة المنتج
```blade
@livewire('option-picker', [
    'options' => $categories->map(fn($cat) => [
        'value' => $cat->id,
        'label' => $cat->name,
        'description' => $cat->description,
        'icon' => $cat->icon
    ]),
    'fieldName' => 'category_id',
    'label' => 'فئة المنتج',
    'displayType' => 'icon',
    'selectedValue' => old('category_id', $product->category_id ?? '')
])
```

### 2. اختيار ألوان المتجر
```blade
@livewire('option-picker', [
    'options' => [
        ['value' => '#3B82F6', 'label' => 'أزرق احترافي', 'color' => '#3B82F6'],
        ['value' => '#10B981', 'label' => 'أخضر طبيعي', 'color' => '#10B981'],
        ['value' => '#F59E0B', 'label' => 'برتقالي دافئ', 'color' => '#F59E0B']
    ],
    'fieldName' => 'primary_color',
    'label' => 'اللون الأساسي',
    'displayType' => 'color',
    'searchable' => false
])
```

### 3. اختيار المستخدمين المسؤولين
```blade
@livewire('option-picker', [
    'options' => $users->map(fn($user) => [
        'value' => $user->id,
        'label' => $user->name,
        'description' => $user->email,
        'icon' => 'ri-user-line'
    ]),
    'fieldName' => 'assigned_users',
    'label' => 'المستخدمون المسؤولون',
    'displayType' => 'icon',
    'multiple' => true,
    'maxSelections' => 5
])
```

### 4. اختيار حالة المنتج
```blade
@livewire('option-picker', [
    'options' => [
        ['value' => 'active', 'label' => 'نشط', 'icon' => 'ri-check-line', 'color' => '#10B981'],
        ['value' => 'inactive', 'label' => 'غير نشط', 'icon' => 'ri-close-line', 'color' => '#EF4444'],
        ['value' => 'pending', 'label' => 'في الانتظار', 'icon' => 'ri-time-line', 'color' => '#F59E0B']
    ],
    'fieldName' => 'status',
    'label' => 'حالة المنتج',
    'displayType' => 'icon',
    'searchable' => false
])
```

### 5. اختيار الخدمات المتاحة
```blade
@livewire('option-picker', [
    'options' => [
        ['value' => 'delivery', 'label' => 'التوصيل', 'icon' => 'ri-truck-line', 'description' => 'خدمة توصيل سريع'],
        ['value' => 'installation', 'label' => 'التركيب', 'icon' => 'ri-tools-line', 'description' => 'خدمة تركيب احترافي'],
        ['value' => 'warranty', 'label' => 'الضمان', 'icon' => 'ri-shield-check-line', 'description' => 'ضمان شامل']
    ],
    'fieldName' => 'services',
    'label' => 'الخدمات المتاحة',
    'displayType' => 'icon',
    'multiple' => true
])
```

## التكامل مع النماذج

### نموذج بسيط
```blade
<form method="POST" action="{{ route('products.store') }}">
    @csrf
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300 mb-2">اسم المنتج</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-input">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>
    
    <div class="mb-4">
        @livewire('option-picker', [
            'options' => $categories,
            'fieldName' => 'category_id',
            'label' => 'الفئة',
            'selectedValue' => old('category_id')
        ])
        @error('category_id') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">حفظ المنتج</button>
</form>
```

### مع التحقق من الصحة
```php
// في Controller
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'services' => 'array',
        'services.*' => 'string'
    ]);
    
    $product = Product::create($request->all());
    
    if ($request->has('services')) {
        $product->services()->sync($request->services);
    }
    
    return redirect()->route('products.index');
}
```

## الأحداث والتفاعل

### الاستماع للأحداث
```javascript
document.addEventListener('livewire:init', () => {
    Livewire.on('optionSelected', (event) => {
        console.log('تم اختيار:', event.value);
        console.log('التسمية:', event.label);
        console.log('اسم الحقل:', event.fieldName);
        
        // تحديث واجهة المستخدم
        updatePreview(event.value);
    });
});
```

### التفاعل مع مكونات Livewire أخرى
```php
class ProductForm extends Component
{
    public $selectedCategory = '';
    public $availableOptions = [];
    
    protected $listeners = ['optionSelected'];
    
    public function optionSelected($data)
    {
        if ($data['fieldName'] === 'category_id') {
            $this->selectedCategory = $data['value'];
            $this->loadCategoryOptions();
        }
    }
    
    public function loadCategoryOptions()
    {
        $this->availableOptions = Option::where('category_id', $this->selectedCategory)->get();
        $this->dispatch('setOptions', $this->availableOptions);
    }
}
```

## التخصيص المتقدم

### إضافة نوع عرض مخصص
```blade
<!-- في option-picker.blade.php -->
@elseif($displayType === 'custom')
    <div class="custom-display">
        <!-- التخصيص الخاص بك هنا -->
        @if($option['custom_field'])
            <span class="custom-indicator">{{ $option['custom_field'] }}</span>
        @endif
    </div>
```

### تخصيص التصفية
```php
// في OptionPicker.php
public function getFilteredOptions()
{
    if (empty($this->searchTerm)) {
        return $this->options;
    }

    return array_filter($this->options, function($option) {
        return stripos($option['label'], $this->searchTerm) !== false ||
               stripos($option['description'] ?? '', $this->searchTerm) !== false ||
               stripos($option['category'] ?? '', $this->searchTerm) !== false;
    });
}
```

## أمثلة متقدمة

### مع إعدادات المتجر
```blade
@livewire('option-picker', [
    'options' => [
        [
            'value' => 'theme_1',
            'label' => 'السمة الكلاسيكية',
            'description' => 'تصميم أنيق ومناسب للمتاجر التقليدية',
            'image' => '/themes/classic-preview.jpg',
            'category' => 'كلاسيكي'
        ],
        [
            'value' => 'theme_2',
            'label' => 'السمة العصرية',
            'description' => 'تصميم حديث مع ألوان جريئة',
            'image' => '/themes/modern-preview.jpg',
            'category' => 'عصري'
        ]
    ],
    'fieldName' => 'store_theme',
    'label' => 'سمة المتجر',
    'displayType' => 'image'
])
```

### مع خطط الاشتراك
```blade
@livewire('option-picker', [
    'options' => [
        [
            'value' => 'basic',
            'label' => 'الباقة الأساسية',
            'description' => '50 منتج • دعم email • تقارير أساسية',
            'icon' => 'ri-box-line',
            'category' => '99 ر.س/شهر'
        ],
        [
            'value' => 'pro',
            'label' => 'الباقة المتقدمة',
            'description' => '500 منتج • دعم فوري • تقارير متقدمة',
            'icon' => 'ri-vip-crown-line',
            'category' => '299 ر.س/شهر'
        ]
    ],
    'fieldName' => 'subscription_plan',
    'label' => 'خطة الاشتراك',
    'displayType' => 'icon'
])
```

## استكشاف الأخطاء

### المشكلة: الخيارات لا تظهر
**الحل:** تأكد من تنسيق البيانات الصحيح
```php
// خطأ
$options = Category::all();

// صحيح  
$options = Category::all()->map(fn($cat) => [
    'value' => $cat->id,
    'label' => $cat->name
]);
```

### المشكلة: الاختيار المتعدد لا يعمل
**الحل:** تأكد من إضافة `[]` لاسم الحقل
```blade
<!-- في النموذج -->
<input name="services[]" type="hidden" />
```

### المشكلة: القيم المحددة مسبقاً لا تظهر
**الحل:** تأكد من تمرير `selectedValue` بالشكل الصحيح
```blade
@livewire('option-picker', [
    'selectedValue' => old('field_name', $model->field_name ?? '')
])
```

## الأداء والتحسين

### للخيارات الكبيرة
```php
// استخدم التصفية من قاعدة البيانات
public function getOptions()
{
    return Category::select('id as value', 'name as label', 'icon')
                  ->where('is_active', true)
                  ->limit(100)
                  ->get()
                  ->toArray();
}
```

### التحميل التدريجي
```php
// في المكون
public function loadMoreOptions()
{
    $this->offset += 50;
    $newOptions = $this->getMoreOptions();
    $this->options = array_merge($this->options, $newOptions);
}
```

---

**ملاحظة:** هذا المكون مصمم ليكون بديلاً شاملاً لجميع قوائم الاختيار في مشروعك. يمكنك استخدامه مع أي نوع من البيانات والتخصيص حسب احتياجاتك. 