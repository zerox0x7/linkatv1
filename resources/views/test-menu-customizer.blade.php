<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>اختبار مخصص القوائم</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00e5bb',
                        secondary: '#9C27B0'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }
        
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #4a5568;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #00e5bb;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .custom-input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .custom-input:focus {
            border-color: #00e5bb;
            outline: none;
        }

        .custom-input::placeholder {
            color: #9ca3af;
        }

        .dragging {
            opacity: 0.8;
            background: #1e293b;
            box-shadow: 0 4px 20px rgba(0, 229, 187, 0.2);
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        .drag-over {
            border: 2px dashed #00e5bb !important;
            position: relative;
        }

        .drag-handle {
            cursor: grab;
        }

        .drag-handle:active {
            cursor: grabbing;
        }
        
        /* Loading animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 to-slate-800">
    <div class="container mx-auto py-8">
        <div class="bg-slate-800 rounded-lg shadow-xl p-6 mb-6">
            <h1 class="text-3xl font-bold text-center text-white mb-2">اختبار مخصص القوائم المطور</h1>
            <p class="text-center text-gray-400 mb-6">النسخة المحسنة مع معالجة أفضل للأخطاء وحفظ محسن للبيانات</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg p-4 text-white">
                    <div class="flex items-center">
                        <i class="ri-database-line text-2xl mr-3"></i>
                        <div>
                            <div class="text-sm opacity-90">معاملات قاعدة البيانات</div>
                            <div class="font-bold">محسنة ✓</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-4 text-white">
                    <div class="flex items-center">
                        <i class="ri-refresh-line text-2xl mr-3"></i>
                        <div>
                            <div class="text-sm opacity-90">حفظ تلقائي</div>
                            <div class="font-bold">مفعل ✓</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg p-4 text-white">
                    <div class="flex items-center">
                        <i class="ri-error-warning-line text-2xl mr-3"></i>
                        <div>
                            <div class="text-sm opacity-90">معالجة الأخطاء</div>
                            <div class="font-bold">محسنة ✓</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Menu Customizer Component -->
        @livewire('menu-customizer')
        
        <!-- Test Information -->
        <div class="bg-slate-800 rounded-lg shadow-xl p-6 mt-6">
            <h2 class="text-xl font-bold text-white mb-4">معلومات الاختبار</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300">
                <div>
                    <h3 class="font-semibold text-white mb-2">التحسينات المطبقة:</h3>
                    <ul class="space-y-1 text-sm">
                        <li>✓ معاملات قاعدة البيانات (Database Transactions)</li>
                        <li>✓ حفظ تلقائي للتغييرات المهمة</li>
                        <li>✓ تتبع التغييرات المعلقة</li>
                        <li>✓ معالجة محسنة للأخطاء</li>
                        <li>✓ تسجيل مفصل للأخطاء</li>
                        <li>✓ واجهة مستخدم محسنة</li>
                        <li>✓ دعم اختصارات لوحة المفاتيح</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-2">اختصارات لوحة المفاتيح:</h3>
                    <ul class="space-y-1 text-sm">
                        <li><kbd class="bg-gray-700 px-2 py-1 rounded">Ctrl+S</kbd> حفظ جميع التغييرات</li>
                        <li><kbd class="bg-gray-700 px-2 py-1 rounded">Ctrl+R</kbd> تحديث القائمة</li>
                    </ul>
                    
                    <h3 class="font-semibold text-white mb-2 mt-4">المشاكل المحلولة:</h3>
                    <ul class="space-y-1 text-sm">
                        <li>✓ فقدان البيانات أثناء الحفظ</li>
                        <li>✓ تضارب التحديثات المتزامنة</li>
                        <li>✓ عدم حفظ أيقونات العناصر</li>
                        <li>✓ أخطاء معالجة الصور</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html> 