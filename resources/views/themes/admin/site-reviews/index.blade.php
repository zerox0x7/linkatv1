<!DOCTYPE html>
<html lang="ar" dir="rtl"  style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;"   >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقييمات المتجر</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <script>
        tailwind.config={
            theme:{
                extend:{
                    colors:{
                        primary:'#00e5c9',
                        secondary:'#1e293b'
                    },
                    borderRadius:{
                        'none':'0px',
                        'sm':'4px',
                        DEFAULT:'8px',
                        'md':'12px',
                        'lg':'16px',
                        'xl':'20px',
                        '2xl':'24px',
                        '3xl':'32px',
                        'full':'9999px',
                        'button':'8px'
                    }
                }
            }
        }
    </script>
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            background-color: #1a2233;
            color: #e2e8f0;
            font-family: 'Arial', sans-serif;
        }
        .sidebar-item.active {
            border-right: 3px solid #00e5c9;
            background-color: rgba(0, 229, 201, 0.1);
        }
        .card {
            background-color: #232b3e;
        }
        input[type="search"]:focus {
            outline: none;
            border-color: #00e5c9;
        }
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
        }
        .progress-bar-fill.star-5 {
            background-color: #00e5c9;
            width: 68%;
        }
        .progress-bar-fill.star-4 {
            background-color: #00e5c9;
            width: 21%;
        }
        .progress-bar-fill.star-3 {
            background-color: #ffc107;
            width: 7%;
        }
        .progress-bar-fill.star-2 {
            background-color: #ff9800;
            width: 3%;
        }
        .progress-bar-fill.star-1 {
            background-color: #f44336;
            width: 1%;
        }
    </style>








    <!-- CSS للتحكم في القوائم المنسدلة -->
    <style>
        .s-dropdown-content {
            display: none;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .s-dropdown-content.show {
            display: block;
            opacity: 1;
            max-height: 500px;
        }

        .s-dropdown-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .s-dropdown-toggle:hover {
            color: #10b981;
        }

        .s-transform.rotate-180 {
            transform: rotate(180deg);
        }
    </style>












</head>
<body class="min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
       @include('themes.admin.parts.sidebar')

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
          @include('themes.admin.parts.header')

            <!-- Dashboard Content -->
            <div class="p-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-4 gap-6 mb-8">
                    <!-- Total Reviews -->
                    <div class="card rounded p-6 relative">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-gray-400 text-sm">إجمالي التقييمات</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500/10 text-blue-500">
                                <i class="ri-file-list-line"></i>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <h2 class="text-3xl font-bold">1,358</h2>
                            <div class="mr-3 text-green-500 text-sm flex items-center">
                                <span>+15.2%</span>
                                <i class="ri-arrow-up-line mr-1"></i>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">من الشهر الماضي</p>
                    </div>

                    <!-- Average Rating -->
                    <div class="card rounded p-6 relative">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-gray-400 text-sm">متوسط التقييم</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-yellow-500/10 text-yellow-500">
                                <i class="ri-star-line"></i>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <h2 class="text-3xl font-bold">4.8</h2>
                            <div class="flex mr-3">
                                <div class="flex text-yellow-400 text-sm">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-half-fill"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">من 1,358 تقييم</p>
                    </div>

                    <!-- New Reviews -->
                    <div class="card rounded p-6 relative">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-gray-400 text-sm">تقييمات جديدة</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-500/10 text-green-500">
                                <i class="ri-chat-new-line"></i>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <h2 class="text-3xl font-bold">92</h2>
                            <div class="mr-3 text-green-500 text-sm flex items-center">
                                <span>+8.3%</span>
                                <i class="ri-arrow-up-line mr-1"></i>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">هذا الأسبوع</p>
                    </div>

                    <!-- Response Rate -->
                    <div class="card rounded p-6 relative">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-gray-400 text-sm">معدل الاستجابة</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500/10 text-blue-500">
                                <i class="ri-message-3-line"></i>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <h2 class="text-3xl font-bold">96%</h2>
                            <div class="mr-3 text-red-500 text-sm flex items-center">
                                <span>-1.5%</span>
                                <i class="ri-arrow-down-line mr-1"></i>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">من الشهر الماضي</p>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <!-- Rating Distribution -->
                    <div class="card rounded p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-semibold">توزيع التقييمات</h3>
                            <div class="flex space-x-reverse space-x-2">
                                <button class="text-xs px-3 py-1 rounded-full bg-gray-700 text-white">آخر 30 يوم</button>
                                <button class="text-xs px-3 py-1 rounded-full bg-primary text-gray-900">كل الفترات</button>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <!-- 5 stars -->
                            <div class="flex items-center">
                                <div class="w-16 flex items-center">
                                    <span class="text-sm ml-1">5 نجوم</span>
                                    <i class="ri-star-fill text-yellow-400 text-sm"></i>
                                </div>
                                <div class="flex-1 mx-4">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill star-5"></div>
                                    </div>
                                </div>
                                <div class="w-12 text-left">
                                    <span class="text-sm">68%</span>
                                </div>
                            </div>
                            <!-- 4 stars -->
                            <div class="flex items-center">
                                <div class="w-16 flex items-center">
                                    <span class="text-sm ml-1">4 نجوم</span>
                                    <i class="ri-star-fill text-yellow-400 text-sm"></i>
                                </div>
                                <div class="flex-1 mx-4">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill star-4"></div>
                                    </div>
                                </div>
                                <div class="w-12 text-left">
                                    <span class="text-sm">21%</span>
                                </div>
                            </div>
                            <!-- 3 stars -->
                            <div class="flex items-center">
                                <div class="w-16 flex items-center">
                                    <span class="text-sm ml-1">3 نجوم</span>
                                    <i class="ri-star-fill text-yellow-400 text-sm"></i>
                                </div>
                                <div class="flex-1 mx-4">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill star-3"></div>
                                    </div>
                                </div>
                                <div class="w-12 text-left">
                                    <span class="text-sm">7%</span>
                                </div>
                            </div>
                            <!-- 2 stars -->
                            <div class="flex items-center">
                                <div class="w-16 flex items-center">
                                    <span class="text-sm ml-1">2 نجوم</span>
                                    <i class="ri-star-fill text-yellow-400 text-sm"></i>
                                </div>
                                <div class="flex-1 mx-4">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill star-2"></div>
                                    </div>
                                </div>
                                <div class="w-12 text-left">
                                    <span class="text-sm">3%</span>
                                </div>
                            </div>
                            <!-- 1 star -->
                            <div class="flex items-center">
                                <div class="w-16 flex items-center">
                                    <span class="text-sm ml-1">1 نجمة</span>
                                    <i class="ri-star-fill text-yellow-400 text-sm"></i>
                                </div>
                                <div class="flex-1 mx-4">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill star-1"></div>
                                    </div>
                                </div>
                                <div class="w-12 text-left">
                                    <span class="text-sm">1%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Trend -->
                    <div class="card rounded p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-semibold">اتجاه التقييمات</h3>
                            <div class="flex space-x-reverse space-x-2">
                                <button class="text-xs px-3 py-1 rounded-full bg-primary text-gray-900">شهري</button>
                                <button class="text-xs px-3 py-1 rounded-full bg-gray-700 text-white">أسبوعي</button>
                            </div>
                        </div>
                        <div id="reviewTrendChart" class="w-full h-64"></div>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="card rounded p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <h3 class="font-semibold">تقييمات المتجر</h3>
                            <span class="mr-2 text-xs bg-gray-700 px-2 py-1 rounded-full">1,358 تقييم</span>
                        </div>
                        <div class="flex items-center space-x-reverse space-x-3">
                            <div class="relative">
                                <button class="flex items-center text-sm bg-gray-700 hover:bg-gray-600 rounded-button px-4 py-2 whitespace-nowrap">
                                    <span>جميع الفروع</span>
                                    <i class="ri-arrow-down-s-line mr-2"></i>
                                </button>
                            </div>
                            <div class="relative">
                                <button class="flex items-center text-sm bg-gray-700 hover:bg-gray-600 rounded-button px-4 py-2 whitespace-nowrap">
                                    <span>جميع التقييمات</span>
                                    <i class="ri-arrow-down-s-line mr-2"></i>
                                </button>
                            </div>
                            <div class="relative">
                                <button class="flex items-center text-sm bg-gray-700 hover:bg-gray-600 rounded-button px-4 py-2 whitespace-nowrap">
                                    <span>الأحدث</span>
                                    <i class="ri-arrow-down-s-line mr-2"></i>
                                </button>
                            </div>
                            <div class="relative">
                                <button class="flex items-center text-sm bg-gray-700 hover:bg-gray-600 rounded-button px-4 py-2 whitespace-nowrap">
                                    <span>حالة الرد</span>
                                    <i class="ri-arrow-down-s-line mr-2"></i>
                                </button>
                            </div>
                            <button class="flex items-center text-sm bg-primary hover:bg-primary/90 text-gray-900 rounded-button px-4 py-2 whitespace-nowrap">
                                <i class="ri-filter-3-line ml-2"></i>
                                <span>تصفية</span>
                            </button>
                        </div>
                    </div>

                    <!-- Reviews Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="text-right py-3 px-4 font-medium text-gray-400">العميل</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-400">التقييم</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-400">التعليق</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-400">الفرع</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-400">التاريخ</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-400">الحالة</th>
                                    <th class="text-right py-3 px-4 font-medium text-gray-400">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Review 1 -->
                                <tr class="border-b border-gray-700/50 hover:bg-gray-700/10">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center ml-3">
                                                <span>ع</span>
                                            </div>
                                            <div>
                                                <p class="font-medium">عبدالله محمد</p>
                                                <p class="text-gray-400 text-sm">عميل منذ 2023</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex text-yellow-400">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 max-w-xs">
                                        <p class="truncate">تجربة تسوق ممتازة، المنتجات عالية الجودة والتوصيل سريع جداً. سأعود للتسوق مرة أخرى.</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">الرياض - العليا</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">01 يونيو 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-500/10 text-green-500">تم الرد</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-reverse space-x-2">
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-reply-line"></i>
                                            </button>
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Review 2 -->
                                <tr class="border-b border-gray-700/50 hover:bg-gray-700/10">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-500 flex items-center justify-center ml-3">
                                                <span>س</span>
                                            </div>
                                            <div>
                                                <p class="font-medium">سارة أحمد</p>
                                                <p class="text-gray-400 text-sm">عميل منذ 2024</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex text-yellow-400">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-line"></i>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 max-w-xs">
                                        <p class="truncate">خدمة عملاء ممتازة وتنوع كبير في المنتجات. أتمنى لو كانت أسعار الشحن أقل.</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">جدة - الروضة</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">31 مايو 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-yellow-500/10 text-yellow-500">بانتظار الرد</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-reverse space-x-2">
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-primary hover:bg-primary/90 text-gray-900">
                                                <i class="ri-reply-line"></i>
                                            </button>
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Review 3 -->
                                <tr class="border-b border-gray-700/50 hover:bg-gray-700/10">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-purple-500/20 text-purple-500 flex items-center justify-center ml-3">
                                                <span>م</span>
                                            </div>
                                            <div>
                                                <p class="font-medium">محمد العتيبي</p>
                                                <p class="text-gray-400 text-sm">عميل منذ 2022</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex text-yellow-400">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-half-fill"></i>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 max-w-xs">
                                        <p class="truncate">المتجر من أفضل المتاجر التي تعاملت معها، سرعة في التوصيل ومنتجات أصلية 100%.</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">الدمام - الشاطئ</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">30 مايو 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-500/10 text-green-500">تم الرد</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-reverse space-x-2">
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-reply-line"></i>
                                            </button>
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Review 4 -->
                                <tr class="border-b border-gray-700/50 hover:bg-gray-700/10">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-orange-500/20 text-orange-500 flex items-center justify-center ml-3">
                                                <span>ن</span>
                                            </div>
                                            <div>
                                                <p class="font-medium">نورة الحربي</p>
                                                <p class="text-gray-400 text-sm">عميل منذ 2023</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex text-yellow-400">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-line"></i>
                                            <i class="ri-star-line"></i>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 max-w-xs">
                                        <p class="truncate">المنتجات جيدة ولكن التوصيل استغرق وقتاً أطول من المتوقع. آمل تحسين خدمة التوصيل مستقبلاً.</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">الرياض - النخيل</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">29 مايو 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-red-500/10 text-red-500">لم يتم الرد</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-reverse space-x-2">
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-primary hover:bg-primary/90 text-gray-900">
                                                <i class="ri-reply-line"></i>
                                            </button>
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Review 5 -->
                                <tr class="hover:bg-gray-700/10">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-green-500/20 text-green-500 flex items-center justify-center ml-3">
                                                <span>ف</span>
                                            </div>
                                            <div>
                                                <p class="font-medium">فهد القحطاني</p>
                                                <p class="text-gray-400 text-sm">عميل منذ 2024</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex text-yellow-400">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 max-w-xs">
                                        <p class="truncate">تجربة رائعة من البداية للنهاية. موظفي خدمة العملاء متعاونون جداً وساعدوني في اختيار المنتج المناسب.</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">جدة - الصفا</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm">28 مايو 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-500/10 text-green-500">تم الرد</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-reverse space-x-2">
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-reply-line"></i>
                                            </button>
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 text-white">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-6">
                        <div class="text-sm text-gray-400">
                            عرض 1-5 من 1,358 تقييم
                        </div>
                        <div class="flex space-x-reverse space-x-2">
                            <button class="w-9 h-9 flex items-center justify-center rounded bg-gray-700 hover:bg-gray-600 text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="ri-arrow-right-s-line"></i>
                            </button>
                            <button class="w-9 h-9 flex items-center justify-center rounded bg-primary text-gray-900">1</button>
                            <button class="w-9 h-9 flex items-center justify-center rounded bg-gray-700 hover:bg-gray-600 text-white">2</button>
                            <button class="w-9 h-9 flex items-center justify-center rounded bg-gray-700 hover:bg-gray-600 text-white">3</button>
                            <button class="w-9 h-9 flex items-center justify-center rounded bg-gray-700 hover:bg-gray-600 text-white">...</button>
                            <button class="w-9 h-9 flex items-center justify-center rounded bg-gray-700 hover:bg-gray-600 text-white">136</button>
                            <button class="w-9 h-9 flex items-center justify-center rounded bg-gray-700 hover:bg-gray-600 text-white">
                                <i class="ri-arrow-left-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script id="reviewTrendChartScript">
        document.addEventListener('DOMContentLoaded', function() {
            const chartDom = document.getElementById('reviewTrendChart');
            const myChart = echarts.init(chartDom);
            
            const option = {
                animation: false,
                color: ['rgba(87, 181, 231, 1)', 'rgba(141, 211, 199, 1)'],
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    textStyle: {
                        color: '#1f2937'
                    },
                    borderColor: 'rgba(0, 229, 201, 0.2)',
                    borderWidth: 1
                },
                grid: {
                    left: '0',
                    right: '0',
                    top: '10',
                    bottom: '0',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                    axisLine: {
                        lineStyle: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    axisLabel: {
                        color: 'rgba(255, 255, 255, 0.6)'
                    }
                },
                yAxis: [
                    {
                        type: 'value',
                        name: 'التقييمات',
                        min: 0,
                        max: 250,
                        position: 'left',
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: 'rgba(87, 181, 231, 1)'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            }
                        },
                        axisLabel: {
                            color: 'rgba(255, 255, 255, 0.6)'
                        }
                    },
                    {
                        type: 'value',
                        name: 'متوسط التقييم',
                        min: 0,
                        max: 5,
                        position: 'right',
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: 'rgba(141, 211, 199, 1)'
                            }
                        },
                        axisLabel: {
                            formatter: '{value}',
                            color: 'rgba(255, 255, 255, 0.6)'
                        }
                    }
                ],
                series: [
                    {
                        name: 'التقييمات',
                        type: 'line',
                        smooth: true,
                        lineStyle: {
                            width: 3,
                            color: 'rgba(87, 181, 231, 1)'
                        },
                        showSymbol: false,
                        areaStyle: {
                            opacity: 0.1,
                            color: {
                                type: 'linear',
                                x: 0,
                                y: 0,
                                x2: 0,
                                y2: 1,
                                colorStops: [
                                    {
                                        offset: 0, 
                                        color: 'rgba(87, 181, 231, 0.3)'
                                    },
                                    {
                                        offset: 1, 
                                        color: 'rgba(87, 181, 231, 0.05)'
                                    }
                                ]
                            }
                        },
                        emphasis: {
                            focus: 'series'
                        },
                        data: [110, 132, 101, 134, 190, 230]
                    },
                    {
                        name: 'متوسط التقييم',
                        type: 'line',
                        yAxisIndex: 1,
                        smooth: true,
                        lineStyle: {
                            width: 3,
                            color: 'rgba(141, 211, 199, 1)'
                        },
                        showSymbol: false,
                        emphasis: {
                            focus: 'series'
                        },
                        data: [4.2, 4.3, 4.5, 4.6, 4.7, 4.8]
                    }
                ]
            };
            
            myChart.setOption(option);
            
            window.addEventListener('resize', function() {
                myChart.resize();
            });
        });
    </script>
</body>
</html>




































{{-- @extends('themes.admin.layouts.app')

@section('title', 'تقييمات الموقع الرئيسية')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">آراء العملاء - تقييمات الموقع</h1>
        <div>
            <a href="{{ route('admin.site-reviews.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                إضافة تقييم جديد
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="mr-2 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors">
                تقييمات المنتجات
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الاسم</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">المسمى الوظيفي</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">التقييم</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الحالة</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">تاريخ الإضافة</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @if($siteReviews->count() > 0)
                    @foreach($siteReviews as $review)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-4 text-sm text-gray-900">{{ $review->name }}</td>
                        <td class="py-4 px-4 text-sm text-gray-500">{{ $review->position ?? '-' }}</td>
                        <td class="py-4 px-4">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $review->is_approved ? 'معتمد' : 'قيد المراجعة' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-500">{{ $review->created_at->format('Y-m-d') }}</td>
                        <td class="py-4 px-4 text-sm font-medium space-x-reverse space-x-2">
                            <a href="{{ route('admin.site-reviews.edit', $review->id) }}" class="inline-block text-blue-600 hover:text-blue-900">تعديل</a>
                            
                            <form action="{{ route('admin.site-reviews.toggle-approval', $review->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-{{ $review->is_approved ? 'yellow' : 'green' }}-600 hover:text-{{ $review->is_approved ? 'yellow' : 'green' }}-900">
                                    {{ $review->is_approved ? 'تعليق' : 'اعتماد' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.site-reviews.destroy', $review->id) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">لا توجد تقييمات حتى الآن</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $siteReviews->links() }}
    </div>
</div>
@endsection  --}}