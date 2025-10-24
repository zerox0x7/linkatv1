<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icon Select Input Demo</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .bg-primary { background-color: #00d4aa; }
        .text-primary { color: #00d4aa; }
        .border-primary { border-color: #00d4aa; }
        .ring-primary { --tw-ring-color: #00d4aa; }
        .custom-input {
            background-color: #162033;
            border: 1px solid #4B5563;
            color: white;
        }
        .custom-input:focus {
            outline: none;
            ring: 2px;
            --tw-ring-color: #00d4aa;
            border-color: transparent;
        }
    </style>
</head>
<body class="bg-[#0f1419] text-white">
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-8 text-center">اختبار مكون اختيار الأيقونات</h1>

        <div class="bg-[#162033] rounded-lg p-6 max-w-md mx-auto">
            <h2 class="text-2xl font-semibold mb-4">نموذج الخدمة</h2>
            
            <div class="space-y-4">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">عنوان الخدمة</label>
                    <input type="text" placeholder="مثال: خدمة التوصيل" class="custom-input p-3 rounded-md w-full">
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">أيقونة الخدمة</label>
                    @livewire('icon-select-input', [
                        'value' => 'ri-truck-line',
                        'label' => '',
                        'placeholder' => 'اختر أيقونة'
                    ])
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button class="bg-gray-700 text-white py-2 px-4 rounded-lg text-sm">إلغاء</button>
                    <button class="bg-primary text-[#0f172a] py-2 px-4 rounded-lg text-sm">حفظ</button>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <p class="text-gray-400">تم استبدال القائمة المنسدلة التقليدية بمكون اختيار الأيقونات التفاعلي</p>
            <p class="text-green-400 mt-2">✅ يعمل مع wire:model</p>
            <p class="text-green-400">✅ نفس التصميم</p>
            <p class="text-green-400">✅ أيقونات أكثر</p>
            <p class="text-green-400">✅ إمكانية البحث</p>
        </div>
    </div>

    @livewireScripts
</body>
</html> 