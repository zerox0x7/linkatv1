<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة عملاء المتجر</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00E1C0',
                        secondary: '#6366f1'
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
    {{-- <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .spin-animation {
            animation: spin 1s linear infinite;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        .fade-out {
            animation: fadeOut 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px) translateX(-50%);
            }

            to {
                opacity: 1;
                transform: translateY(0) translateX(-50%);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0) translateX(-50%);
            }

            to {
                opacity: 0;
                transform: translateY(-20px) translateX(-50%);
            }
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #e2e8f0;
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
        }

        /* Modern Card Styles */
        .modern-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(0, 225, 192, 0.3);
        }

        /* Enhanced Status Badges */
        .status-badge {
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .active-badge {
            background: linear-gradient(135deg, rgba(0, 225, 192, 0.2), rgba(0, 225, 192, 0.3));
            color: #00E1C0;
            box-shadow: 0 0 20px rgba(0, 225, 192, 0.2);
        }

        .inactive-badge {
            background: linear-gradient(135deg, rgba(156, 163, 175, 0.2), rgba(156, 163, 175, 0.3));
            color: #9ca3af;
        }

        /* Modern Role Badges */
        .role-badge {
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-badge {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(99, 102, 241, 0.3));
            color: #6366f1;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
        }

        .manager-badge {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.3));
            color: #f59e0b;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);
        }

        .editor-badge {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.3));
            color: #10b981;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }

        .support-badge {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.3));
            color: #ef4444;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.2);
        }

        /* Enhanced Search Input */
        .search-input {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #00E1C0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 225, 192, 0.1);
            background: rgba(30, 41, 59, 0.8);
        }

        /* Modern Dropdown */
        .dropdown-content {
            background: rgba(30, 41, 59, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .dropdown-item:hover {
            background: rgba(0, 225, 192, 0.1);
            border-radius: 8px;
        }

        /* Enhanced Buttons */
        .modern-btn {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .modern-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(0, 225, 192, 0.3);
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #00E1C0, #00b8a3);
            color: #0f172a;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 225, 192, 0.3);
        }

        .modern-btn-primary:hover {
            box-shadow: 0 8px 25px rgba(0, 225, 192, 0.4);
            transform: translateY(-2px);
        }

        /* Enhanced Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
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
            background: rgba(55, 65, 81, 0.8);
            transition: .4s;
            border-radius: 34px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 2px;
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked+.slider {
            background: linear-gradient(135deg, #00E1C0, #00b8a3);
            box-shadow: 0 0 20px rgba(0, 225, 192, 0.3);
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        /* Enhanced Checkboxes */
        input[type="checkbox"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid rgba(75, 85, 99, 0.8);
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(10px);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        input[type="checkbox"]:checked {
            background: linear-gradient(135deg, #00E1C0, #00b8a3);
            border-color: #00E1C0;
            box-shadow: 0 0 15px rgba(0, 225, 192, 0.3);
        }

        input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            top: 2px;
            left: 6px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Enhanced Table */
        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table-row:hover {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(10px);
            transform: scale(1.01);
        }

        .table-row.selected {
            background: rgba(0, 225, 192, 0.1);
            border-color: rgba(0, 225, 192, 0.3);
        }

        .table-container {
            background: rgba(30, 41, 59, 0.3);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            scrollbar-width: thin;
            scrollbar-color: #4b5563 #1e293b;
        }

        .table-container::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: rgba(30, 41, 59, 0.5);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #4b5563, #6b7280);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
        }

        /* Enhanced Action Buttons */
        .action-btn {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(0, 225, 192, 0.5);
            background: rgba(0, 225, 192, 0.1);
        }

        /* Enhanced Pagination */
        .pagination-btn {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover:not(.active) {
            background: rgba(30, 41, 59, 0.9);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .pagination-btn.active {
            background: linear-gradient(135deg, #00E1C0, #00b8a3);
            color: #0f172a;
            box-shadow: 0 4px 15px rgba(0, 225, 192, 0.3);
        }

        /* Enhanced Customer Tags */
        .customer-tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            margin-right: 4px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(99, 102, 241, 0.3));
            color: #6366f1;
            border: 1px solid rgba(99, 102, 241, 0.3);
            backdrop-filter: blur(10px);
        }

        .customer-tag.vip {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.3));
            color: #f59e0b;
            border-color: rgba(245, 158, 11, 0.3);
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);
        }

        .customer-tag.new {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.3));
            color: #10b981;
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
        }

        /* Enhanced Avatar */
        .avatar-gradient {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #00E1C0);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Enhanced Modal */
        .modal-content {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        /* Enhanced Header */
        .header-glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Enhanced Stats Cards */
        .stats-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            border-color: rgba(0, 225, 192, 0.3);
        }

        /* Enhanced Filter Badges */
        .filter-badge {
            background: linear-gradient(135deg, #00E1C0, #00b8a3);
            box-shadow: 0 0 10px rgba(0, 225, 192, 0.5);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Glassmorphism Effect for Main Container */
        .main-container {
            background: rgba(20, 28, 47, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Enhanced Scrollbar for main content */
        .main-content {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 225, 192, 0.3) transparent;
        }

        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .main-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(0, 225, 192, 0.3), rgba(0, 225, 192, 0.6));
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(0, 225, 192, 0.6), rgba(0, 225, 192, 0.8));
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
    <div id="toastNotification"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 hidden">
        تم تحديث بيانات العملاء بنجاح
    </div>
   
    <div class="flex">
         @include('themes.admin.parts.sidebar')
        <!-- Sidebar -->
        <div  class="w-64 bg-[#0f172a] flex flex-col   right-0 border-l border-gray-800" style="display:none" >

            <div class="p-4 flex justify-center items-center border-b border-gray-800">
                <span class="text-primary font-['Pacifico'] text-2xl">logo</span>
            </div>

            <div class="flex flex-col flex-grow p-4 overflow-y-auto"
                style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
                <!-- لوحة التحكم -->
                <div class="mb-6">
                    <div class="s-dropdown-item">
                        <button class="s-dropdown-toggle flex items-center text-gray-400 text-sm mb-2 w-full"
                            onclick="toggleDropdown('dashboard')">
                            <span>لوحة التحكم</span>
                            <i class="ri-arrow-down-s-line mr-auto transform transition-transform"
                                id="dashboard-arrow"></i>
                        </button>
                        <div class="s-dropdown-content ml-4" id="dashboard-content">
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-primary' : 'text-white hover:bg-gray-800' }} py-2 px-4 rounded mb-1">
                                <div class="w-6 h-6 flex items-center justify-center ml-2">
                                    <i class="ri-dashboard-line"></i>
                                </div>
                                <span>لوحة التحكم الرئيسية</span>
                            </a>
                            {{-- <a href="{{ route('reports.index') }}"
                        class="flex items-center {{ request()->routeIs('reports.*') ? 'bg-gray-800 text-primary' : 'text-white hover:bg-gray-800' }} py-2 px-4 rounded mb-1">
                        <div class="w-6 h-6 flex items-center justify-center ml-2">
                            <i class="ri-bar-chart-line"></i>
                        </div>
                        <span>التقارير</span>
                    </a> --}}
                        </div>
                    </div>
            </div>

                    <!-- إدارة المتجر -->
            <div class="mb-6">
                        <div class="s-dropdown-item">
                            <button class="s-dropdown-toggle flex items-center text-gray-400 text-sm mb-2 w-full"
                                onclick="toggleDropdown('store')">
                                <span>إدارة المتجر</span>
                                <i class="ri-arrow-down-s-line mr-auto transform transition-transform" id="store-arrow"></i>
                            </button>
                            <div class="s-dropdown-content ml-4" id="store-content">

                                <a href="{{ route('admin.products.index') }}"
                                    class="flex items-center {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-primary' : 'text-white hover:bg-gray-800' }} py-2 px-4 rounded mb-1">
                                    <div class="w-6 h-6 flex items-center justify-center ml-2">
                                        <i class="ri-shopping-bag-line"></i>
                                    </div>
                                    <span>المنتجات</span>
                                </a>
                                <a href="#"
                                    class="flex items-center {{ request()->routeIs('orders.*') ? 'bg-gray-800 text-primary' : 'text-white hover:bg-gray-800' }} py-2 px-4 rounded mb-1">
                                    <div class="w-6 h-6 flex items-center justify-center ml-2">
                                        <i class="ri-shopping-cart-line"></i>
                                    </div>
                                    <span>الطلبات</span>
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="flex items-center {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-primary' : 'text-white hover:bg-gray-800' }} py-2 px-4 rounded mb-1">
                                    <div class="w-6 h-6 flex items-center justify-center ml-2">
                                        <i class="ri-categories-line"></i>
                                    </div>
                                    <span>التصنيفات</span>
                                </a>

                              
                            </div>
                        </div>
            </div>

                <!--     -->
                <div class="mb-6">
                    <div class="s-dropdown-item">
                        <button class="s-dropdown-toggle flex items-center text-gray-400 text-sm mb-2 w-full"
                            onclick="toggleDropdown('settings')">
                            <span>الاعدادات </span>
                            <i class="ri-arrow-down-s-line mr-auto transform transition-transform"
                                id="settings-arrow"></i>
                        </button>
                        <div class="s-dropdown-content ml-4" id="settings-content">
                            <a href="{{ route('admin.categories.index') }}"
                                class="flex items-center {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-primary' : 'text-white hover:bg-gray-800' }} py-2 px-4 rounded mb-1">
                                <div class="w-6 h-6 flex items-center justify-center ml-2">
                                    <i class="ri-categories-line"></i>
                                </div>
                                <span>لوحة التحكم الرئيسية</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- معلومات المستخدم -->
                <div class="mt-auto">
                    <div class="flex items-center p-4 bg-gray-800 rounded-lg">
                        <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center ml-3">
                            <div class="w-6 h-6 flex items-center justify-center text-white">
                                <i class="ri-user-line"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ Auth::user()->name ?? 'محمد أحمد' }}</p>
                            <p class="text-xs text-gray-400">مدير المتجر</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="mr-auto">
                            @csrf
                            <button type="submit"
                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white cursor-pointer">
                                <i class="ri-logout-box-line"></i>
                            </button>
                        </form>
                    </div>
                </div>

    </div>
    
    </div>
        <!-- Main Content -->
        <div class=" flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
           @include('themes.admin.parts.header')
           @livewire('clients')
        </div>
    </div>
    <!-- Customer Profile Modal -->
    <div id="customerProfileModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-3xl bg-[#1e293b] rounded-lg overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b border-gray-800">
                <h3 class="text-lg font-bold">معلومات العميل</h3>
                <button id="closeProfileModal"
                    class="w-8 h-8 rounded-full bg-[#141c2f] flex items-center justify-center">
                    <i class="ri-close-line text-gray-400"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 flex flex-col items-center mb-6 md:mb-0">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold mb-4">
                            أح
                        </div>
                        <h3 class="text-xl font-bold">أحمد محمود الخطيب</h3>
                        <div class="text-sm text-gray-400 mb-2">ahmed.khatib@example.com</div>
                        <div class="flex items-center text-sm text-gray-400 mb-4">
                            <div class="w-4 h-4 flex items-center justify-center ml-1">
                                <i class="ri-phone-line"></i>
                            </div>
                            <span>+966 55 123 4567</span>
                        </div>
                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <span class="customer-tag vip">VIP</span>
                            <span class="status-badge active-badge">نشط</span>
                        </div>
                    </div>
                    <div class="md:w-2/3 md:pr-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-[#141c2f] p-3 rounded-lg">
                                <div class="text-sm text-gray-400 mb-1">إجمالي المشتريات</div>
                                <div class="text-xl font-bold">12,850 ر.س</div>
                            </div>
                            <div class="bg-[#141c2f] p-3 rounded-lg">
                                <div class="text-sm text-gray-400 mb-1">عدد الطلبات</div>
                                <div class="text-xl font-bold">32 طلب</div>
                            </div>
                            <div class="bg-[#141c2f] p-3 rounded-lg">
                                <div class="text-sm text-gray-400 mb-1">تاريخ التسجيل</div>
                                <div class="text-xl font-bold">15 مارس 2024</div>
                            </div>
                            <div class="bg-[#141c2f] p-3 rounded-lg">
                                <div class="text-sm text-gray-400 mb-1">آخر نشاط</div>
                                <div class="text-xl font-bold">اليوم 10:30 ص</div>
                            </div>
                        </div>
                        <div class="bg-[#141c2f] p-4 rounded-lg mb-4">
                            <div class="text-sm text-gray-400 mb-2">العنوان</div>
                            <div class="text-sm">
                                حي النزهة، شارع الأمير سلطان، فيلا 45<br>
                                الرياض، المملكة العربية السعودية
                            </div>
                        </div>
                        <div class="bg-[#141c2f] p-4 rounded-lg">
                            <div class="text-sm text-gray-400 mb-2">ملاحظات</div>
                            <div class="text-sm">
                                عميل مميز يفضل المنتجات التقنية الحديثة. يطلب دائماً خدمة التوصيل السريع ويهتم بالعروض
                                الخاصة.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-800">
                    <h4 class="text-lg font-bold mb-4">آخر الطلبات</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px]">
                            <thead>
                                <tr class="bg-[#141c2f] text-gray-300 text-sm">
                                    <th class="py-2 px-3 text-right">#</th>
                                    <th class="py-2 px-3 text-right">التاريخ</th>
                                    <th class="py-2 px-3 text-right">المبلغ</th>
                                    <th class="py-2 px-3 text-right">الحالة</th>
                                    <th class="py-2 px-3 text-center">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-800">
                                    <td class="py-2 px-3">#ORD-9874</td>
                                    <td class="py-2 px-3">01 يونيو 2025</td>
                                    <td class="py-2 px-3">1,250 ر.س</td>
                                    <td class="py-2 px-3"><span class="status-badge active-badge">مكتمل</span></td>
                                    <td class="py-2 px-3 text-center">
                                        <button class="text-primary text-sm">عرض</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-800">
                                    <td class="py-2 px-3">#ORD-9652</td>
                                    <td class="py-2 px-3">25 مايو 2025</td>
                                    <td class="py-2 px-3">850 ر.س</td>
                                    <td class="py-2 px-3"><span class="status-badge active-badge">مكتمل</span></td>
                                    <td class="py-2 px-3 text-center">
                                        <button class="text-primary text-sm">عرض</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3">#ORD-9541</td>
                                    <td class="py-2 px-3">18 مايو 2025</td>
                                    <td class="py-2 px-3">2,100 ر.س</td>
                                    <td class="py-2 px-3"><span class="status-badge active-badge">مكتمل</span></td>
                                    <td class="py-2 px-3 text-center">
                                        <button class="text-primary text-sm">عرض</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button
                        class="bg-[#141c2f] border border-gray-700 rounded-button px-4 py-2 text-sm ml-3 whitespace-nowrap">
                        تعديل البيانات
                    </button>
                    <button class="bg-primary text-gray-900 rounded-button px-4 py-2 text-sm whitespace-nowrap">
                        إرسال رسالة
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script id="dropdownToggle">
        document.addEventListener('DOMContentLoaded', function() {
            let activeFilters = {
                status: {
                    active: false,
                    inactive: false
                }
            };
            // Segment Filter Dropdown
            const segmentFilterBtn = document.getElementById('segmentFilterBtn');
            const segmentDropdown = document.getElementById('segmentDropdown');
            segmentFilterBtn.addEventListener('click', function() {
                segmentDropdown.classList.toggle('hidden');
                statusDropdown.classList.add('hidden');
                sortDropdown.classList.add('hidden');
            });
            // Status Filter Dropdown
            const statusFilterBtn = document.getElementById('statusFilterBtn');
            const statusDropdown = document.getElementById('statusDropdown');
            const inactiveCheckbox = document.getElementById('inactive');
            const activeCheckbox = document.getElementById('active');
            statusFilterBtn.addEventListener('click', function() {
                statusDropdown.classList.toggle('hidden');
                segmentDropdown.classList.add('hidden');
                sortDropdown.classList.add('hidden');
            });
            // Sort Dropdown
            const sortBtn = document.getElementById('sortBtn');
            const sortDropdown = document.getElementById('sortDropdown');
            sortBtn.addEventListener('click', function() {
                sortDropdown.classList.toggle('hidden');
                segmentDropdown.classList.add('hidden');
                statusDropdown.classList.add('hidden');
            });
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!segmentFilterBtn.contains(event.target) && !segmentDropdown.contains(event.target)) {
                    segmentDropdown.classList.add('hidden');
                }
                if (!statusFilterBtn.contains(event.target) && !statusDropdown.contains(event.target)) {
                    statusDropdown.classList.add('hidden');
                }
                if (!sortBtn.contains(event.target) && !sortDropdown.contains(event.target)) {
                    sortDropdown.classList.add('hidden');
                }
            });
            // Dropdown item selection
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                if (!item.querySelector('input[type="checkbox"]')) {
                    item.addEventListener('click', function() {
                        if (item.closest('#sortDropdown')) {
                            sortBtn.querySelector('span').textContent = 'ترتيب حسب: ' + item
                                .textContent;
                            sortDropdown.classList.add('hidden');
                        }
                    });
                }
            });
            // Status filter functionality
            function updateStatusBadge() {
                const hasActiveFilters = activeFilters.status.active || activeFilters.status.inactive;
                const badge = statusFilterBtn.querySelector('.filter-badge');
                if (hasActiveFilters) {
                    if (!badge) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'filter-badge w-2 h-2 bg-primary rounded-full absolute -top-1 -left-1';
                        statusFilterBtn.style.position = 'relative';
                        statusFilterBtn.appendChild(newBadge);
                    }
                } else if (badge) {
                    badge.remove();
                }
            }

            function applyStatusFilter() {
                const tableRows = document.querySelectorAll('tbody tr');
                const cardItems = document.querySelectorAll('.grid > div');
                const items = [...tableRows, ...cardItems];
                items.forEach(item => {
                    const statusBadge = item.querySelector('.status-badge');
                    const isInactive = statusBadge?.classList.contains('inactive-badge');
                    const isActive = statusBadge?.classList.contains('active-badge');
                    const showInactive = activeFilters.status.inactive && isInactive;
                    const showActive = activeFilters.status.active && isActive;
                    const showAll = !activeFilters.status.inactive && !activeFilters.status.active;
                    if (showAll || showInactive || showActive) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
                updateStatusBadge();
                statusDropdown.classList.add('hidden');
            }
            // Add event listeners for status checkboxes
            inactiveCheckbox.addEventListener('change', function() {
                activeFilters.status.inactive = this.checked;
                if (this.checked) {
                    activeCheckbox.checked = false;
                    activeFilters.status.active = false;
                }
            });
            activeCheckbox.addEventListener('change', function() {
                activeFilters.status.active = this.checked;
                if (this.checked) {
                    inactiveCheckbox.checked = false;
                    activeFilters.status.inactive = false;
                }
            });
            // Add event listener for apply button
            const applyButton = statusDropdown.querySelector('button');
            applyButton.addEventListener('click', applyStatusFilter);
        });
    </script>
    <script id="customerSelection">
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const customerCheckboxes = document.querySelectorAll('.customer-select');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
            selectAllCheckbox.addEventListener('change', function() {
                customerCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    updateRowSelection(checkbox);
                });
                updateDeleteButtonState();
            });
            customerCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateRowSelection(this);
                    const allChecked = Array.from(customerCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(customerCheckboxes).some(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                    updateDeleteButtonState();
                });
            });

            function updateRowSelection(checkbox) {
                const row = checkbox.closest('tr');
                if (row) {
                    if (checkbox.checked) {
                        row.classList.add('selected');
                    } else {
                        row.classList.remove('selected');
                    }
                }
            }

            function updateDeleteButtonState() {
                const someChecked = Array.from(customerCheckboxes).some(cb => cb.checked);
                if (someChecked) {
                    deleteSelectedBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    deleteSelectedBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        });
    </script>
    <script id="customerProfileModal">
        document.addEventListener('DOMContentLoaded', function() {
            const profileViewButtons = document.querySelectorAll('.ri-eye-line');
            const customerProfileModal = document.getElementById('customerProfileModal');
            const closeProfileModal = document.getElementById('closeProfileModal');
            profileViewButtons.forEach(button => {
                button.closest('button').addEventListener('click', function() {
                    customerProfileModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });
            closeProfileModal.addEventListener('click', function() {
                customerProfileModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });
            customerProfileModal.addEventListener('click', function(event) {
                if (event.target === customerProfileModal) {
                    customerProfileModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
    <script id="searchFunctionality">
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            let debounceTimer;

            function debounce(func, wait) {
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(debounceTimer);
                        func(...args);
                    };
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(later, wait);
                };
            }

            function performSearch(searchTerm) {
                const tableRows = document.querySelectorAll('tbody tr');
                const cardItems = document.querySelectorAll('.grid > div');
                const items = [...tableRows, ...cardItems];
                const normalizedSearchTerm = searchTerm.toLowerCase().trim();

                items.forEach(item => {
                    const name = item.querySelector('.font-medium')?.textContent.toLowerCase() || '';
                    const email = item.querySelector('.text-gray-400')?.textContent.toLowerCase() || '';
                    const matches = name.includes(normalizedSearchTerm) || email.includes(
                        normalizedSearchTerm);

                    if (searchTerm === '') {
                        item.style.display = '';
                    } else {
                        item.style.display = matches ? '' : 'none';
                    }
                });
            }

            searchInput.addEventListener('input', debounce((e) => {
                performSearch(e.target.value);
            }, 300));
        });
    </script>

    <script id="viewToggle">
        document.addEventListener('DOMContentLoaded', function() {
            const tableViewBtn = document.getElementById('tableViewBtn');
            const cardViewBtn = document.getElementById('cardViewBtn');
            const tableContainer = document.querySelector('.table-container').parentElement;
            // Create card view container
            const cardContainer = document.createElement('div');
            cardContainer.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden';
            // Convert table data to cards
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const card = document.createElement('div');
                card.className = 'bg-[#1e293b] rounded-lg p-4 relative group';
                const checkbox = row.querySelector('.customer-select');
                const avatar = row.querySelector('.rounded-full').cloneNode(true);
                const name = row.querySelector('.font-medium').textContent;
                const email = row.querySelector('.text-gray-400').textContent;
                const purchases = row.querySelectorAll('.font-medium')[1].textContent;
                const orders = row.querySelectorAll('.text-gray-400')[1].textContent;
                const segment = row.querySelector('.customer-tag').cloneNode(true);
                const status = row.querySelector('.status-badge').cloneNode(true);
                const lastActivity = row.querySelector('.text-gray-400:last-child').textContent;
                card.innerHTML = `
<div class="absolute top-3 right-3">
<input type="checkbox" class="customer-select" ${checkbox.checked ? 'checked' : ''}>
</div>
<div class="flex items-start">
<div class="flex-shrink-0 ml-4">${avatar.outerHTML}</div>
<div class="flex-grow">
<h3 class="font-medium mb-1">${name}</h3>
<div class="text-sm text-gray-400 mb-2">${email}</div>
<div class="flex items-center mb-3">
${segment.outerHTML}
<span class="mx-2">•</span>
${status.outerHTML}
</div>
<div class="bg-[#141c2f] rounded-lg p-3 mb-3">
<div class="flex justify-between items-center mb-2">
<span class="text-sm text-gray-400">المشتريات</span>
<span class="font-medium">${purchases}</span>
</div>
<div class="flex justify-between items-center">
<span class="text-sm text-gray-400">الطلبات</span>
<span class="text-sm text-gray-400">${orders}</span>
</div>
</div>
<div class="flex items-center text-sm text-gray-400 mb-3">
<i class="ri-time-line ml-1"></i>
<span>آخر نشاط: ${lastActivity}</span>
</div>
</div>
</div>
<div class="flex justify-end pt-3 border-t border-gray-800 mt-3">
<button class="w-8 h-8 rounded-full bg-[#141c2f] flex items-center justify-center ml-1 action-btn" title="عرض الملف الشخصي">
<i class="ri-eye-line text-gray-400"></i>
</button>
<button class="w-8 h-8 rounded-full bg-[#141c2f] flex items-center justify-center ml-1 action-btn" title="تعديل">
<i class="ri-edit-line text-gray-400"></i>
</button>
<button class="w-8 h-8 rounded-full bg-[#141c2f] flex items-center justify-center action-btn" title="حذف">
<i class="ri-delete-bin-line text-gray-400"></i>
</button>
</div>
`;
                cardContainer.appendChild(card);
            });
            tableContainer.parentNode.insertBefore(cardContainer, tableContainer.nextSibling);
            // Toggle view buttons
            tableViewBtn.addEventListener('click', function() {
                tableViewBtn.classList.add('bg-primary', 'text-gray-900');
                tableViewBtn.classList.remove('text-gray-300');
                cardViewBtn.classList.remove('bg-primary', 'text-gray-900');
                cardViewBtn.classList.add('text-gray-300');
                tableContainer.classList.remove('hidden');
                cardContainer.classList.add('hidden');
            });
            cardViewBtn.addEventListener('click', function() {
                cardViewBtn.classList.add('bg-primary', 'text-gray-900');
                cardViewBtn.classList.remove('text-gray-300');
                tableViewBtn.classList.remove('bg-primary', 'text-gray-900');
                tableViewBtn.classList.add('text-gray-300');
                cardContainer.classList.remove('hidden');
                tableContainer.classList.add('hidden');
            });
        });
    </script>
    <script id="refreshData">
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshBtn');
            const refreshIcon = document.getElementById('refreshIcon');
            const toastNotification = document.getElementById('toastNotification');
            refreshBtn.addEventListener('click', async function() {
                // Disable button and show loading spinner
                refreshBtn.disabled = true;
                const originalIcon = refreshIcon.innerHTML;
                refreshIcon.innerHTML = '<i class="ri-loader-4-line spin-animation"></i>';
                try {
                    // Simulate API call with delay
                    await new Promise(resolve => setTimeout(resolve, 1500));
                    // Show success toast
                    toastNotification.classList.remove('hidden');
                    toastNotification.classList.add('fade-in');
                    // Hide toast after 2 seconds
                    setTimeout(() => {
                        toastNotification.classList.remove('fade-in');
                        toastNotification.classList.add('fade-out');
                        setTimeout(() => {
                            toastNotification.classList.add('hidden');
                            toastNotification.classList.remove('fade-out');
                        }, 300);
                    }, 2000);
                } catch (error) {
                    console.error('Error refreshing data:', error);
                } finally {
                    // Reset button state
                    refreshBtn.disabled = false;
                    refreshIcon.innerHTML = originalIcon;
                }
            });
        });
    </script>







    {{-- <script>
        function toggleDropdown(section) {
            const content = document.getElementById(section + '-content');
            const arrow = document.getElementById(section + '-arrow');

            content.classList.toggle('show');
            arrow.classList.toggle('rotate-180');
        }

        // التحقق من الصفحة الحالية وفتح القسم المناسب عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            // الخطوة 1: التحقق من روابط إدارة المتجر
            // نتحقق إذا كان المستخدم في صفحة المنتجات أو الطلبات
            @if (request()->routeIs('admin.products.*') || request()->routeIs('admin.orders.*'))
                // الخطوة 2: فتح قسم إدارة المتجر إذا كان في إحدى صفحاته
                toggleDropdown('store')

                // الخطوة 3: إضافة أقسام أخرى حسب الحاجة
            @elseif (request()->routeIs('admin.dashboard') || request()->routeIs('admin.reports.*'))
                // فتح قسم لوحة التحكم إذا كان موجوداً
                toggleDropdown('dashboard');
            @elseif (request()->routeIs('admin.categories.*') || request()->routeIs('admin.reports.*'))
                // فتح قسم لوحة التحكم إذا كان موجوداً
                toggleDropdown('categories');
            @else
                // الخطوة 4: فتح قسم إدارة المتجر كقيمة افتراضية
                // إذا لم يكن في أي من الأقسام المحددة، افتح إدارة المتجر
                // toggleDropdown('store');
            @endif
        });
    </script> --}}

</body>

</html>
