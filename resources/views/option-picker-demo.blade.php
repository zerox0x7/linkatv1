<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Option Picker Demo - All Use Cases</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .bg-primary { background-color: #00d4aa; }
        .text-primary { color: #00d4aa; }
        .border-primary { border-color: #00d4aa; }
        .ring-primary { --tw-ring-color: #00d4aa; }
        .bg-secondary { background-color: #10b981; }
        .text-secondary { color: #10b981; }
    </style>
</head>
<body class="bg-[#0f1419] text-white">
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-8 text-center">مكون الخيارات المرن - جميع الاستخدامات</h1>

        <!-- 1. Icon Selection -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">1. اختيار الأيقونات</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => 'ri-store-line', 'label' => 'متجر', 'icon' => 'ri-store-line'],
                            ['value' => 'ri-phone-line', 'label' => 'هاتف', 'icon' => 'ri-phone-line'],
                            ['value' => 'ri-mail-line', 'label' => 'بريد', 'icon' => 'ri-mail-line'],
                            ['value' => 'ri-user-line', 'label' => 'مستخدم', 'icon' => 'ri-user-line'],
                            ['value' => 'ri-settings-line', 'label' => 'إعدادات', 'icon' => 'ri-settings-line'],
                        ],
                        'fieldName' => 'service_icon',
                        'label' => 'أيقونة الخدمة',
                        'placeholder' => 'اختر أيقونة',
                        'displayType' => 'icon'
                    ])
                </div>
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => 'ri-shopping-cart-line', 'label' => 'سلة التسوق', 'icon' => 'ri-shopping-cart-line'],
                            ['value' => 'ri-heart-line', 'label' => 'المفضلة', 'icon' => 'ri-heart-line'],
                            ['value' => 'ri-star-line', 'label' => 'التقييمات', 'icon' => 'ri-star-line'],
                        ],
                        'fieldName' => 'multiple_icons',
                        'label' => 'اختيار متعدد للأيقونات',
                        'placeholder' => 'اختر عدة أيقونات',
                        'displayType' => 'icon',
                        'multiple' => true,
                        'maxSelections' => 3
                    ])
                </div>
            </div>
        </div>

        <!-- 2. Color Selection -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">2. اختيار الألوان</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => '#3B82F6', 'label' => 'أزرق', 'color' => '#3B82F6'],
                            ['value' => '#10B981', 'label' => 'أخضر', 'color' => '#10B981'],
                            ['value' => '#F59E0B', 'label' => 'أصفر', 'color' => '#F59E0B'],
                            ['value' => '#EF4444', 'label' => 'أحمر', 'color' => '#EF4444'],
                            ['value' => '#8B5CF6', 'label' => 'بنفسجي', 'color' => '#8B5CF6'],
                        ],
                        'fieldName' => 'brand_color',
                        'label' => 'لون العلامة التجارية',
                        'placeholder' => 'اختر لون',
                        'displayType' => 'color',
                        'searchable' => false
                    ])
                </div>
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => '#FF6B6B', 'label' => 'أحمر فاتح', 'color' => '#FF6B6B'],
                            ['value' => '#4ECDC4', 'label' => 'تركوازي', 'color' => '#4ECDC4'],
                            ['value' => '#45B7D1', 'label' => 'أزرق سماوي', 'color' => '#45B7D1'],
                            ['value' => '#96CEB4', 'label' => 'أخضر نعناعي', 'color' => '#96CEB4'],
                            ['value' => '#FFEAA7', 'label' => 'أصفر شاحب', 'color' => '#FFEAA7'],
                        ],
                        'fieldName' => 'theme_colors',
                        'label' => 'ألوان السمة (متعدد)',
                        'placeholder' => 'اختر ألوان',
                        'displayType' => 'color',
                        'multiple' => true
                    ])
                </div>
            </div>
        </div>

        <!-- 3. Category Selection -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">3. اختيار الفئات</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => '1', 'label' => 'الإلكترونيات', 'description' => 'أجهزة ومعدات إلكترونية', 'category' => 'تقنية'],
                            ['value' => '2', 'label' => 'الأزياء', 'description' => 'ملابس وإكسسوارات', 'category' => 'موضة'],
                            ['value' => '3', 'label' => 'المنزل والحديقة', 'description' => 'أثاث وديكورات منزلية', 'category' => 'منزل'],
                            ['value' => '4', 'label' => 'الكتب', 'description' => 'كتب ومجلات', 'category' => 'تعليم'],
                        ],
                        'fieldName' => 'product_category',
                        'label' => 'فئة المنتج',
                        'placeholder' => 'اختر فئة',
                        'displayType' => 'badge'
                    ])
                </div>
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => 'tech', 'label' => 'التكنولوجيا', 'icon' => 'ri-computer-line', 'description' => 'جميع المنتجات التقنية'],
                            ['value' => 'fashion', 'label' => 'الأزياء', 'icon' => 'ri-shirt-line', 'description' => 'الملابس والإكسسوارات'],
                            ['value' => 'food', 'label' => 'الطعام', 'icon' => 'ri-restaurant-line', 'description' => 'المأكولات والمشروبات'],
                        ],
                        'fieldName' => 'service_categories',
                        'label' => 'فئات الخدمات (متعدد)',
                        'placeholder' => 'اختر فئات',
                        'displayType' => 'icon',
                        'multiple' => true
                    ])
                </div>
            </div>
        </div>

        <!-- 4. Status Selection -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">4. اختيار الحالة</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => 'active', 'label' => 'نشط', 'icon' => 'ri-check-line', 'color' => '#10B981'],
                            ['value' => 'inactive', 'label' => 'غير نشط', 'icon' => 'ri-close-line', 'color' => '#EF4444'],
                            ['value' => 'pending', 'label' => 'في الانتظار', 'icon' => 'ri-time-line', 'color' => '#F59E0B'],
                            ['value' => 'draft', 'label' => 'مسودة', 'icon' => 'ri-draft-line', 'color' => '#6B7280'],
                        ],
                        'fieldName' => 'status',
                        'label' => 'حالة المنتج',
                        'placeholder' => 'اختر حالة',
                        'displayType' => 'icon',
                        'searchable' => false
                    ])
                </div>
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            'all' => 'جميع الحالات',
                            'published' => 'منشور',
                            'draft' => 'مسودة',
                            'archived' => 'مؤرشف'
                        ],
                        'fieldName' => 'filter_status',
                        'label' => 'تصفية حسب الحالة',
                        'placeholder' => 'اختر حالة للتصفية',
                        'displayType' => 'text'
                    ])
                </div>
            </div>
        </div>

        <!-- 5. User/Team Selection -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">5. اختيار المستخدمين/الفرق</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => '1', 'label' => 'أحمد محمد', 'description' => 'مطور واجهات أمامية', 'icon' => 'ri-user-line'],
                            ['value' => '2', 'label' => 'فاطمة علي', 'description' => 'مصممة UI/UX', 'icon' => 'ri-user-line'],
                            ['value' => '3', 'label' => 'محمد حسن', 'description' => 'مطور خلفي', 'icon' => 'ri-user-line'],
                            ['value' => '4', 'label' => 'نور أحمد', 'description' => 'مديرة مشروع', 'icon' => 'ri-user-star-line'],
                        ],
                        'fieldName' => 'assigned_user',
                        'label' => 'تعيين للمستخدم',
                        'placeholder' => 'اختر مستخدم',
                        'displayType' => 'icon'
                    ])
                </div>
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => 'dev', 'label' => 'فريق التطوير', 'icon' => 'ri-code-line', 'description' => '5 مطورين'],
                            ['value' => 'design', 'label' => 'فريق التصميم', 'icon' => 'ri-palette-line', 'description' => '3 مصممين'],
                            ['value' => 'marketing', 'label' => 'فريق التسويق', 'icon' => 'ri-megaphone-line', 'description' => '4 مسوقين'],
                        ],
                        'fieldName' => 'teams',
                        'label' => 'الفرق المختارة',
                        'placeholder' => 'اختر الفرق',
                        'displayType' => 'icon',
                        'multiple' => true
                    ])
                </div>
            </div>
        </div>

        <!-- 6. Location/Region Selection -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibent mb-4">6. اختيار المواقع/المناطق</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            ['value' => 'riyadh', 'label' => 'الرياض', 'icon' => 'ri-map-pin-line', 'description' => 'العاصمة'],
                            ['value' => 'jeddah', 'label' => 'جدة', 'icon' => 'ri-map-pin-line', 'description' => 'المنطقة الغربية'],
                            ['value' => 'dammam', 'label' => 'الدمام', 'icon' => 'ri-map-pin-line', 'description' => 'المنطقة الشرقية'],
                            ['value' => 'mecca', 'label' => 'مكة المكرمة', 'icon' => 'ri-map-pin-line', 'description' => 'المنطقة المقدسة'],
                        ],
                        'fieldName' => 'delivery_city',
                        'label' => 'مدينة التوصيل',
                        'placeholder' => 'اختر مدينة',
                        'displayType' => 'icon'
                    ])
                </div>
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            'north' => 'المنطقة الشمالية',
                            'south' => 'المنطقة الجنوبية', 
                            'east' => 'المنطقة الشرقية',
                            'west' => 'المنطقة الغربية',
                            'central' => 'المنطقة الوسطى'
                        ],
                        'fieldName' => 'service_regions',
                        'label' => 'مناطق الخدمة',
                        'placeholder' => 'اختر المناطق',
                        'displayType' => 'text',
                        'multiple' => true
                    ])
                </div>
            </div>
        </div>

        <!-- 7. Custom Complex Options -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">7. خيارات معقدة مخصصة</h2>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    @livewire('option-picker', [
                        'options' => [
                            [
                                'value' => 'basic',
                                'label' => 'الباقة الأساسية',
                                'description' => 'مناسبة للشركات الصغيرة - 50 منتج، دعم email',
                                'icon' => 'ri-box-line',
                                'color' => '#6B7280',
                                'category' => '99 ر.س/شهر'
                            ],
                            [
                                'value' => 'pro', 
                                'label' => 'الباقة الاحترافية',
                                'description' => 'مناسبة للشركات المتوسطة - 500 منتج، دعم فوري',
                                'icon' => 'ri-vip-crown-line',
                                'color' => '#3B82F6',
                                'category' => '299 ر.س/شهر'
                            ],
                            [
                                'value' => 'enterprise',
                                'label' => 'باقة الشركات',
                                'description' => 'للشركات الكبيرة - منتجات غير محدودة، دعم مخصص',
                                'icon' => 'ri-building-line',
                                'color' => '#10B981',
                                'category' => '999 ر.س/شهر'
                            ]
                        ],
                        'fieldName' => 'subscription_plan',
                        'label' => 'خطة الاشتراك',
                        'placeholder' => 'اختر خطة اشتراك',
                        'displayType' => 'icon'
                    ])
                </div>
            </div>
        </div>

        <!-- 8. Usage Examples Display -->
        <div class="bg-[#162033] rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">أمثلة الاستخدام في الكود</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-[#0f1419] rounded-lg p-4">
                    <h3 class="text-lg font-medium mb-3 text-green-400">مثال 1: اختيار بسيط</h3>
                    <pre class="text-green-400 text-sm overflow-x-auto"><code>@livewire('option-picker', [
    'options' => $categories,
    'fieldName' => 'category_id',
    'label' => 'الفئة',
    'displayType' => 'text'
])</code></pre>
                </div>
                
                <div class="bg-[#0f1419] rounded-lg p-4">
                    <h3 class="text-lg font-medium mb-3 text-green-400">مثال 2: اختيار متعدد مع أيقونات</h3>
                    <pre class="text-green-400 text-sm overflow-x-auto"><code>@livewire('option-picker', [
    'options' => $services,
    'fieldName' => 'services',
    'label' => 'الخدمات',
    'displayType' => 'icon',
    'multiple' => true,
    'maxSelections' => 5
])</code></pre>
                </div>
                
                <div class="bg-[#0f1419] rounded-lg p-4">
                    <h3 class="text-lg font-medium mb-3 text-green-400">مثال 3: في النماذج</h3>
                    <pre class="text-green-400 text-sm overflow-x-auto"><code>&lt;form method="POST"&gt;
    @csrf
    @livewire('option-picker', [
        'options' => $options,
        'selectedValue' => old('field_name'),
        'fieldName' => 'field_name'
    ])
    &lt;button type="submit"&gt;حفظ&lt;/button&gt;
&lt;/form&gt;</code></pre>
                </div>
                
                <div class="bg-[#0f1419] rounded-lg p-4">
                    <h3 class="text-lg font-medium mb-3 text-green-400">مثال 4: مع قاعدة البيانات</h3>
                    <pre class="text-green-400 text-sm overflow-x-auto"><code>// في Controller
$users = User::all()->map(function($user) {
    return [
        'value' => $user->id,
        'label' => $user->name,
        'description' => $user->email,
        'icon' => 'ri-user-line'
    ];
});</code></pre>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    
    <script>
        // Listen for option selection events
        document.addEventListener('livewire:init', () => {
            Livewire.on('optionSelected', (event) => {
                console.log('Option selected:', event);
                // Add your custom logic here
            });
        });
    </script>
</body>
</html> 