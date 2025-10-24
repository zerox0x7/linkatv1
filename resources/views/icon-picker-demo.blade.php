<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icon Picker Demo</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .bg-primary { background-color: #00d4aa; }
        .text-primary { color: #00d4aa; }
        .border-primary { border-color: #00d4aa; }
        .ring-primary { --tw-ring-color: #00d4aa; }
    </style>
</head>
<body class="bg-[#0f1419] text-white">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8 text-center">مثال على مكون اختيار الأيقونات</h1>
        
        <!-- Example 1: Simple Service Form -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">مثال 1: نموذج إضافة خدمة</h2>
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">اسم الخدمة</label>
                        <input type="text" placeholder="أدخل اسم الخدمة" 
                               class="w-full bg-[#0f1419] border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400">
                    </div>
                    
                    <div>
                        @livewire('icon-picker', [
                            'fieldName' => 'service_icon', 
                            'label' => 'أيقونة الخدمة',
                            'placeholder' => 'اختر أيقونة للخدمة'
                        ])
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">وصف الخدمة</label>
                    <textarea placeholder="أدخل وصف الخدمة" rows="3"
                              class="w-full bg-[#0f1419] border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400"></textarea>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="bg-primary text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90">
                        حفظ الخدمة
                    </button>
                </div>
            </form>
        </div>

        <!-- Example 2: Category Form -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">مثال 2: نموذج إضافة فئة</h2>
            <form>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">اسم الفئة</label>
                        <input type="text" placeholder="أدخل اسم الفئة" 
                               class="w-full bg-[#0f1419] border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400">
                    </div>
                    
                    <div>
                        @livewire('icon-picker', [
                            'fieldName' => 'category_icon', 
                            'label' => 'أيقونة الفئة',
                            'placeholder' => 'اختر أيقونة للفئة'
                        ])
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">لون الخلفية</label>
                        <input type="color" value="#00d4aa"
                               class="w-full h-12 bg-[#0f1419] border border-gray-600 rounded-lg">
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="bg-primary text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90">
                        حفظ الفئة
                    </button>
                </div>
            </form>
        </div>

        <!-- Example 3: Multiple Icon Pickers -->
        <div class="bg-[#162033] rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">مثال 3: متعدد الأيقونات</h2>
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        @livewire('icon-picker', [
                            'fieldName' => 'primary_icon', 
                            'label' => 'الأيقونة الأساسية',
                            'placeholder' => 'اختر الأيقونة الأساسية'
                        ])
                    </div>
                    
                    <div>
                        @livewire('icon-picker', [
                            'fieldName' => 'secondary_icon', 
                            'label' => 'الأيقونة الثانوية',
                            'placeholder' => 'اختر الأيقونة الثانوية'
                        ])
                    </div>
                </div>
            </form>
        </div>

        <!-- Usage Example Display -->
        <div class="bg-[#162033] rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">كيفية عرض الأيقونات في المشروع</h2>
            <div class="bg-[#0f1419] rounded-lg p-4">
                <h3 class="text-lg font-medium mb-3">مثال على الكود:</h3>
                <pre class="text-green-400 text-sm overflow-x-auto"><code>&lt;!-- في blade template --&gt;
&lt;i class="{{ '{{$service[\'icon\']}}' }}"&gt;&lt;/i&gt;

&lt;!-- أو مع نص --&gt;
&lt;div class="flex items-center"&gt;
    &lt;i class="{{ '{{$service[\'icon\']}}' }} text-lg ml-2"&gt;&lt;/i&gt;
    &lt;span&gt;{{ '{{$service[\'name\']}}' }}&lt;/span&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>

    @livewireScripts
    
    <script>
        // Listen for icon selection events
        document.addEventListener('livewire:init', () => {
            Livewire.on('iconSelected', (event) => {
                console.log('Icon selected:', event);
                // You can add custom logic here when an icon is selected
            });
        });
    </script>
</body>
</html> 