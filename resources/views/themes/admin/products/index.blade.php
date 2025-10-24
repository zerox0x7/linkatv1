<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Dashboard</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00C8B3',
                        secondary: '#24589E'
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            background-color: #0f172a;
            color: #f9fafb;
            direction: rtl;
        }

        .dropdown-content {
            right: 0;
            left: auto;
        }

        [dir="rtl"] .slider:before {
            right: 2px;
            left: auto;
        }

        [dir="rtl"] input:checked+.slider:before {
            transform: translateX(-20px);
        }

        [dir="rtl"] .search-input {
            padding-right: 2.5rem;
            padding-left: 1rem;
        }

        [dir="rtl"] .search-icon {
            right: 0.75rem;
            left: auto;
        }

        [dir="rtl"] .select-icon {
            left: 0.5rem;
            right: auto;
        }

        .card {
            background-color: #162033;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .status-badge {
            transition: background-color 0.3s;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
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
            background-color: #374151;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #00C8B3;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        .search-input {
            background-color: #111827;
            color: #f9fafb;
        }

        .search-input::placeholder {
            color: #6b7280;
        }

        .hidden {
            display: none;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #111827;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 8px;
        }

        .dropdown-content a {
            color: #f9fafb;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #2a3349;
        }

        .show {
            display: block;
        }


        /* For WebKit browsers (Chrome, Safari, Edge) */
        ::-webkit-scrollbar {
            display: none;
        }

        /* For Firefox */
        html {
            scrollbar-width: none;
        }

        /* For older IE */
        body {
            -ms-overflow-style: none;
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
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            @include('themes.admin.parts.header')
            <!-- Page Content -->
            @livewire('products')
        </div>
    </div>




    <!-- Confirmation Modal -->
    <div id="confirmation-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-full max-w-md transform transition-all scale-95">
            <h2 class="text-xl font-semibold mb-4 text-center">تأكيد الحذف</h2>
            <p class="text-gray-300 mb-6 text-center">هل أنت متأكد من حذف هذا المنتج؟ <br> هذا الإجراء لا يمكن التراجع
                عنه.</p>
            <div class="flex justify-around space-x-4">
                <!-- Cancel Button -->
                <button onclick="hideConfirmationModal()"
                    class="px-6 py-2  rounded-lg bg-gray-600 hover:bg-gray-700 text-gray-200 transition">
                    إلغاء
                </button>
                <!-- Confirm Button -->
                <button onclick="confirmDeletion()"
                    class="px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition">
                    حذف
                </button>
            </div>
        </div>





        <script id="dropdownScript">
            document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = [{
                    trigger: 'languageDropdown',
                    content: 'languageDropdownContent'
                },
                {
                    trigger: 'categoryDropdown',
                    content: 'categoryDropdownContent'
                },
                {
                    trigger: 'statusDropdown',
                    content: 'statusDropdownContent'
                },
                {
                    trigger: 'sortDropdown',
                    content: 'sortDropdownContent'
                }
            ];
            dropdowns.forEach(dropdown => {
                const triggerElement = document.getElementById(dropdown.trigger);
                const contentElement = document.getElementById(dropdown.content);
                if (triggerElement && contentElement) {
                    triggerElement.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdowns.forEach(d => {
                            const content = document.getElementById(d.content);
                            if (content && d.content !== dropdown.content) {
                                content.classList.add('hidden');
                            }
                        });
                        contentElement.classList.toggle('hidden');
                    });
                    contentElement.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
            });
            window.addEventListener('click', function() {
                dropdowns.forEach(dropdown => {
                    const content = document.getElementById(dropdown.content);
                    if (content) {
                        content.classList.add('hidden');
                    }
                });
            });
        });
        </script>


        <script id="toggleScript">
            document.addEventListener('DOMContentLoaded', function() {
            const body = document.querySelector('body');
            const toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 9999;';
            body.appendChild(toastContainer);

            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className =
                    `flex items-center p-4 mb-3 rounded-lg shadow-lg transition-all transform translate-x-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                toast.style.minWidth = '300px';
                const icon = document.createElement('div');
                icon.className = 'w-6 h-6 flex items-center justify-center ml-3 text-white';
                icon.innerHTML = type === 'success' ? '<i class="ri-checkbox-circle-line"></i>' :
                    '<i class="ri-error-warning-line"></i>';
                const text = document.createElement('div');
                text.className = 'text-white';
                text.textContent = message;
                toast.appendChild(icon);
                toast.appendChild(text);
                toastContainer.appendChild(toast);
                requestAnimationFrame(() => {
                    toast.style.transform = 'translateX(0)';
                });
                setTimeout(() => {
                    toast.style.transform = 'translateX(full)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
            // const toggleSwitches = document.querySelectorAll('.switch input[type="checkbox"]');
            // toggleSwitches.forEach(toggle => {
            //     toggle.addEventListener('change', function() {
            //         const card = this.closest('.card');
            //         const statusBadge = card.querySelector('.absolute.top-3.right-3 span');
            //         const productName = card.querySelector('h3').textContent;
            //         const updateStatus = () => {
            //             if (this.checked) {
            //                 statusBadge.className =
            //                     'bg-green-500 text-white text-xs px-2 py-1 rounded-full';
            //                 statusBadge.textContent = 'Active';
            //                 showToast(`تم تنشيط المنتج "${productName}" بنجاح`);
            //             } else {
            //                 statusBadge.className =
            //                     'bg-gray-500 text-white text-xs px-2 py-1 rounded-full';
            //                 statusBadge.textContent = 'Inactive';
            //                 showToast(`تم إلغاء تنشيط المنتج "${productName}" بنجاح`);
            //             }
            //         };
            //         const simulateAPICall = () => {
            //             return new Promise((resolve) => setTimeout(resolve, 300));
            //         };
            //         this.disabled = true;
            //         simulateAPICall()
            //             .then(() => {
            //                 updateStatus();
            //                 this.disabled = false;
            //             })
            //             .catch(() => {
            //                 this.checked = !this.checked;
            //                 showToast(
            //                     'حدث خطأ أثناء تحديث حالة المنتج. يرجى المحاولة مرة أخرى.',
            //                     'error');
            //                 this.disabled = false;
            //             });
            //     });
            // });




        });


        </script>



        {{-- <script>
            function toggleDropdown(section) {
            const content = document.getElementById(section + '-content');
            const arrow = document.getElementById(section + '-arrow');

            content.classList.toggle('show');
            arrow.classList.toggle('rotate-180');
        }

        // فتح القسم المناسب بناءً على الصفحة الحالية أو فتح قسم إدارة المتجر افتراضياً
        document.addEventListener('DOMContentLoaded', function() {
            @if (request()->routeIs('categories.*', 'products.*', 'orders.*'))
                toggleDropdown('store');
            @elseif (request()->routeIs('dashboard.*', 'reports.*'))
                toggleDropdown('dashboard');
            @elseif (request()->routeIs('marketing.*'))
                toggleDropdown('marketing');
            @elseif (request()->routeIs('settings.*'))
                toggleDropdown('settings');
            @else
                toggleDropdown('store');
            @endif
        });
        </script> --}}
</body>

</html>







{{--

@extends('themes.admin.layouts.app')

@section('title', 'إدارة المنتجات')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة المنتجات</h1>
        <div class="flex items-center gap-2">
            <button id="cardViewBtn"
                class="bg-blue-100 text-blue-700 px-3 py-1 rounded shadow-sm text-sm font-medium focus:outline-none">عرض
                كبطاقات</button>
            <button id="tableViewBtn"
                class="bg-gray-100 text-gray-700 px-3 py-1 rounded shadow-sm text-sm font-medium focus:outline-none">عرض
                كجدول</button>
            <a href="{{ route('admin.products.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
                إضافة منتج جديد
            </a>
        </div>
    </div>

    <!-- Filter and search -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">بحث</label>
                    <input type="text" name="search" id="search" placeholder="اسم المنتج أو الوصف..."
                        value="{{ request('search') }}"
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">الفئة</label>
                    <select name="category" id="category"
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        <option value="">كل الفئات</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category')==$category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                    <select name="status" id="status"
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        <option value="">كل الحالات</option>
                        <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>غير نشط</option>
                        <option value="out-of-stock" {{ request('status')=='out-of-stock' ? 'selected' : '' }}>نفذ
                            المخزون</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow mr-2">
                        تصفية
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">
                        إعادة تعيين
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- عرض البطاقات -->
    <div id="cardView" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        @foreach ($products as $product)
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-800 flex flex-col justify-between"
            style="min-height: 440px;">
            <div
                class="h-48 w-full rounded overflow-hidden bg-gray-100 dark:bg-gray-800 mb-0 flex items-center justify-center relative">
                @if ($product->type == 'digital_card')
                <span
                    class="absolute top-3 left-3 bg-purple-600 text-white text-sm font-bold px-3 py-1.5 rounded-xl shadow z-10 flex items-center gap-2">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    بطاقة رقمية
                </span>
                @elseif($product->type == 'account')
                <span
                    class="absolute top-3 left-3 bg-blue-600 text-white text-sm font-bold px-3 py-1.5 rounded-xl shadow z-10 flex items-center gap-2">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    حساب
                </span>
                @elseif($product->type == 'custom')
                <span
                    class="absolute top-3 left-3 bg-yellow-600 text-white text-sm font-bold px-3 py-1.5 rounded-xl shadow z-10 flex items-center gap-2">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8" />
                    </svg>
                    منتج مخصص
                </span>
                @endif
                <img src="{{ asset('storage/' . $product->main_image) }}"
                    class="h-full w-full object-cover rounded-lg transition duration-200" alt="{{ $product->name }}"
                    onerror="this.src='{{ asset('images/product-placeholder.svg') }}';">
            </div>
            <div class="flex-1 flex flex-col justify-between bg-[#1f2937] rounded-b-xl p-4 mt-0" style="margin-top:0;">
                <div class="text-lg font-bold text-gray-100 mb-2 break-words">{{ $product->name }}</div>
                <div class="text-base text-gray-400 mb-3">SKU: {{ $product->sku }}</div>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 rounded text-sm font-medium bg-gray-800 text-gray-200">{{
                        $product->category->name ?? 'بدون فئة' }}</span>
                    <span
                        class="px-3 py-1 rounded text-sm font-medium {{ $product->stock > 0 ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">{{
                        $product->stock > 0 ? 'متوفر' : 'غير متوفر' }}</span>
                    <span
                        class="px-3 py-1 rounded text-sm font-medium {{ $product->status == 'active' ? 'bg-green-800 text-green-100' : ($product->status == 'inactive' ? 'bg-red-800 text-red-100' : 'bg-orange-800 text-orange-100') }}">{{
                        $product->status == 'active' ? 'نشط' : ($product->status == 'inactive' ? 'غير نشط' : 'نفذ
                        المخزون') }}</span>
                </div>
                <div class="mb-3 flex items-center gap-3">
                    @if ($product->old_price)
                    <div class="text-lg font-medium text-red-400">{{ number_format($product->price, 2) }} ر.س</div>
                    <div class="text-base text-gray-400 line-through">{{ number_format($product->old_price, 2) }} ر.س
                    </div>
                    @else
                    <div class="text-lg font-bold text-gray-100">{{ number_format($product->price, 2) }} ر.س</div>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-2">
                @if ($product->type == 'digital_card')
                <a href="{{ route('admin.products.manage-codes', $product) }}"
                    class="text-purple-600 dark:text-purple-300 hover:text-purple-900 dark:hover:text-purple-100"
                    title="إدارة الأكواد الرقمية">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>
                @elseif($product->type == 'account')
                <a href="{{ route('admin.products.manage-accounts', $product) }}"
                    class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100"
                    title="إدارة الحسابات">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </a>
                @endif
                <select
                    class="product-status-select block w-32 px-2 py-1 text-sm border border-gray-300 dark:border-gray-700 rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                    data-product-id="{{ $product->id }}" data-product-type="{{ $product->type }}">
                    <option value="">-- الحالة --</option>
                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    <option value="out-of-stock" {{ $product->status == 'out-of-stock' ? 'selected' : '' }}>نفذ المخزون
                    </option>
                </select>
                <a href="{{ route('admin.products.edit', $product) }}"
                    class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-100"
                    title="تعديل">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block"
                    onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200" title="حذف">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- عرض الجدول (يبقى كما هو) -->
    <div id="tableView">
        <div class="overflow-x-auto">
            <!-- عرض البطاقات في الجوال -->
            <div class="block md:hidden space-y-4">
                @forelse ($products as $product)
                <div
                    class="bg-white dark:bg-gray-900 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center mb-3">
                        <div class="h-14 w-14 rounded overflow-hidden bg-gray-100 dark:bg-gray-800 flex-shrink-0">
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="h-14 w-14 object-cover"
                                alt="{{ $product->name }}"
                                onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                        </div>
                        <div class="mr-4 flex-1">
                            <div class="text-base font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
                        </div>
                        <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-2xl {{ $product->featured ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                title="مميز">★</button>
                        </form>
                    </div>
                    <div class="mb-2 flex flex-wrap gap-2">
                        <span
                            class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">{{
                            $product->category->name ?? 'بدون فئة' }}</span>
                        @if ($product->type == 'digital_card')
                        <span
                            class="px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">بطاقة
                            رقمية</span>
                        @elseif($product->type == 'account')
                        <span
                            class="px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">حساب</span>
                        @endif
                        <span
                            class="px-2 py-0.5 rounded text-xs font-medium {{ $product->stock > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">{{
                            $product->stock > 0 ? 'متوفر' : 'غير متوفر' }}</span>
                        <span
                            class="px-2 py-0.5 rounded text-xs font-medium
                            {{ $product->status == 'active' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                               ($product->status == 'inactive' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200') }}">
                            {{ $product->status == 'active' ? 'نشط' : ($product->status == 'inactive' ? 'غير نشط' : 'نفذ
                            المخزون') }}
                        </span>
                    </div>
                    <div class="mb-2 flex items-center gap-2">
                        @if ($product->old_price)
                        <div class="text-sm font-medium text-red-600 dark:text-red-400">{{
                            number_format($product->price, 2) }} ر.س</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 line-through">{{
                            number_format($product->old_price, 2) }} ر.س</div>
                        @else
                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{
                            number_format($product->price, 2) }} ر.س</div>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @if ($product->type == 'digital_card')
                        <a href="{{ route('admin.products.manage-codes', $product) }}"
                            class="text-purple-600 dark:text-purple-300 hover:text-purple-900 dark:hover:text-purple-100"
                            title="إدارة الأكواد الرقمية">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </a>
                        @elseif($product->type == 'account')
                        <a href="{{ route('admin.products.manage-accounts', $product) }}"
                            class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100"
                            title="إدارة الحسابات">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </a>
                        @endif
                        <div class="inline-block">
                            <select
                                class="product-status-select block w-32 px-2 py-1 text-sm border border-gray-300 dark:border-gray-700 rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                data-product-id="{{ $product->id }}" data-product-type="{{ $product->type }}">
                                <option value="">-- الحالة --</option>
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>غير نشط
                                </option>
                                <option value="out-of-stock" {{ $product->status == 'out-of-stock' ? 'selected' : ''
                                    }}>نفذ المخزون</option>
                            </select>
                        </div>
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-100"
                            title="تعديل">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                            class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200"
                                title="حذف">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-400 dark:text-gray-500 py-8">لا توجد منتجات حالياً</div>
                @endforelse
            </div>
            <!-- الجدول في الشاشات المتوسطة والكبيرة -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الصورة
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                المنتج
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الفئة
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                النوع
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                السعر
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                المخزون
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                مميز
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                إجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="h-10 w-10 rounded overflow-hidden bg-gray-100 dark:bg-gray-800">
                                    <img src="{{ asset('storage/' . $product->main_image) }}"
                                        class="h-10 w-10 object-cover" alt="{{ $product->name }}"
                                        onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $product->category->name ?? 'بدون فئة' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if ($product->type == 'digital_card')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                    بطاقة رقمية
                                </span>
                                @elseif($product->type == 'account')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    حساب
                                </span>
                                @elseif($product->type == 'custom')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                    منتج مخصص
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($product->old_price)
                                <div class="text-sm font-medium text-red-600 dark:text-red-400">{{
                                    number_format($product->price, 2) }} ر.س</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 line-through">{{
                                    number_format($product->old_price, 2) }} ر.س</div>
                                @else
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{
                                    number_format($product->price, 2) }} ر.س</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="text-sm {{ $product->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    @if ($product->type === 'digital_card')
                                    {{ \App\Models\DigitalCardCode::where('product_id', $product->id)->where('status',
                                    'available')->count() }}
                                    @else
                                    {{ $product->stock }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $product->status == 'active' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                               ($product->status == 'inactive' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200') }}">
                                    {{ $product->status == 'active' ? 'نشط' :
                                    ($product->status == 'inactive' ? 'غير نشط' : 'نفذ المخزون') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-2xl {{ $product->featured ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">
                                        ★
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                    @if ($product->type == 'digital_card')
                                    <a href="{{ route('admin.products.manage-codes', $product) }}"
                                        class="text-purple-600 dark:text-purple-300 hover:text-purple-900 dark:hover:text-purple-100"
                                        title="إدارة الأكواد الرقمية">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </a>
                                    @elseif($product->type == 'account')
                                    <a href="{{ route('admin.products.manage-accounts', $product) }}"
                                        class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100"
                                        title="إدارة الحسابات">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </a>
                                    @endif

                                    <div class="inline-block">
                                        <select
                                            class="product-status-select block w-32 px-2 py-1 text-sm border border-gray-300 dark:border-gray-700 rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                            data-product-id="{{ $product->id }}"
                                            data-product-type="{{ $product->type }}">
                                            <option value="">-- الحالة --</option>
                                            <option value="active" {{ $product->status == 'active' ? 'selected' : ''
                                                }}>نشط</option>
                                            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : ''
                                                }}>غير نشط</option>
                                            <option value="out-of-stock" {{ $product->status == 'out-of-stock' ?
                                                'selected' : '' }}>نفذ المخزون</option>
                                        </select>
                                    </div>

                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-gray-400 dark:text-gray-500 py-8">لا توجد منتجات
                                حالياً</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // تبديل بين عرض البطاقات والجدول
    document.addEventListener('DOMContentLoaded', function() {
        const cardView = document.getElementById('cardView');
        const tableView = document.getElementById('tableView');
        const cardBtn = document.getElementById('cardViewBtn');
        const tableBtn = document.getElementById('tableViewBtn');
        cardBtn.addEventListener('click', function() {
            cardView.style.display = '';
            tableView.style.display = 'none';
        });
        tableBtn.addEventListener('click', function() {
            cardView.style.display = 'none';
            tableView.style.display = '';
        });
        // افتراضيًا: عرض البطاقات
        cardView.style.display = '';
        tableView.style.display = 'none';
    });

    // معالجة أخطاء تحميل الصور
    document.addEventListener('DOMContentLoaded', function() {
        // تعيين القيمة الصحيحة للقائمة المنسدلة بناءً على حالة المنتج
        document.querySelectorAll('.product-status-select').forEach(function(select) {
            // جلب العنصر الذي يحتوي على الحالة
            let statusText = '';
            const productRow = select.closest('tr');
            if (productRow) {
                // في الجدول
                const statusCell = productRow.querySelector('td:nth-child(7) span');
                if (statusCell) {
                    statusText = statusCell.textContent.trim();
                }
            } else {
                // في عرض البطاقات
                // ابحث عن العنصر الذي يحمل كلاس أو نص الحالة بجوار السلكت
                const statusSpan = select.parentElement.parentElement.querySelector('span.bg-green-100,span.bg-red-100,span.bg-orange-100,span.bg-green-900,span.bg-red-900,span.bg-orange-900');
                if (statusSpan) {
                    statusText = statusSpan.textContent.trim();
                }
            }

            if (statusText === 'نشط') {
                select.value = 'active';
            } else if (statusText === 'غير نشط') {
                select.value = 'inactive';
            } else if (statusText === 'نفذ المخزون') {
                select.value = 'out-of-stock';
            }
        });
        
        document.querySelectorAll('img').forEach(function(img) {
            img.onerror = function() {
                // استبدال الصورة بصورة افتراضية عند حدوث خطأ في التحميل
                if (!this.src.includes('default-avatar.png') && !this.src.includes('product-placeholder.svg')) {
                    this.src = "{{ asset('images/product-placeholder.svg') }}";
                    console.log('تعذر تحميل الصورة:', this.src);
                }
            };
        });

        // عرض مسار الصور في وحدة التحكم للتصحيح
        console.log('مسار العرض:', "{{ asset('storage/products/') }}");
        console.log('المسار الكامل:', "E:\\dl1s\\htdocs\\store\\public\\storage\\products");
        
        // معالجة تغييرات القائمة المنسدلة لحالة المنتج
        document.querySelectorAll('.product-status-select').forEach(function(select) {
            // حفظ القيمة الأصلية
            const originalValue = select.value;
            
            select.addEventListener('change', function() {
                const productId = this.getAttribute('data-product-id');
                const productType = this.getAttribute('data-product-type');
                const selectedValue = this.value;
                
                console.log('تم تحديد: ', selectedValue, 'للمنتج:', productId, 'نوع المنتج:', productType);
                
                // إذا لم يتم اختيار قيمة، فلا تفعل شيئًا
                if (!selectedValue) {
                    return;
                }
                
                // إذا تم اختيار نفذ المخزون، تأكد من أن النوع هو بطاقة رقمية وعرض تأكيد
                if (selectedValue === 'out-of-stock') {
                    if (!confirm('هل أنت متأكد من تعيين هذا المنتج كـ نفذ المخزون؟ سيظل المخزون والأكواد المتاحة كما هي، لكن المنتج لن يكون متاحًا للشراء.')) {
                        this.value = originalValue;
                        return;
                    }
                }
                
                // إنشاء نموذج وإرساله مباشرة
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ url('admin/products') }}/" + productId + "/toggle-status";
                
                // إضافة CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                // إضافة حقل الحالة
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = selectedValue;
                form.appendChild(statusInput);
                
                // إضافة النموذج للصفحة وإرساله
            document.body.appendChild(form);
            form.submit();
        });
    });
});
</script>


@endpush --}}