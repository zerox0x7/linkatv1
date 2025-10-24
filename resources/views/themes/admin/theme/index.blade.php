<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الثيمات - {{ \App\Models\Setting::get('store_name', config('app.name')) }}</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#15B8A6',
                        secondary: '#10b981'
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
    @livewireStyles
</head>

<body class="bg-[#0a0f1a] text-gray-100" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#0f1623] to-[#162033] border-b border-[#2a3548] sticky top-0 z-40 shadow-lg">
                <div class="flex items-center justify-between p-6">
                    <div>
                        <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                                <i class="ri-paint-brush-line text-purple-400"></i>
                            </div>
                            إدارة الثيمات
                        </h1>
                        <p class="text-gray-400 mt-1">اختر الثيم النشط وخصصه حسب احتياجات متجرك</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-3 bg-gradient-to-r from-[#1a2234] to-[#0f1623] border border-[#2a3548] text-white rounded-xl hover:border-primary/50 transition-all duration-300 flex items-center gap-2 shadow-lg">
                        <i class="ri-arrow-right-line"></i>
                        <span>رجوع للوحة التحكم</span>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 p-8" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/50 rounded-xl text-green-400 animate-fade-in">
                        <div class="flex items-center gap-3">
                            <i class="ri-checkbox-circle-line text-2xl"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-gradient-to-r from-red-500/20 to-rose-500/20 border border-red-500/50 rounded-xl text-red-400 animate-fade-in">
                        <div class="flex items-center gap-3">
                            <i class="ri-error-warning-line text-2xl"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Current Active Theme -->
                <div class="mb-8 bg-gradient-to-br from-[#121827] to-[#1a2234] rounded-2xl border border-primary/30 shadow-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-primary to-secondary flex items-center justify-center shadow-lg">
                            <i class="ri-paint-brush-line text-3xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-1">الثيم النشط حالياً</h3>
                            <p class="text-primary text-2xl font-bold">{{ ucfirst($activeTheme) }}</p>
                        </div>
                        <a href="{{ route('admin.themes.customize') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:opacity-90 transition-all duration-300 flex items-center gap-2 shadow-lg">
                            <i class="ri-brush-3-line"></i>
                            <span>تخصيص الثيم</span>
                        </a>
                    </div>
                </div>

                <!-- Available Themes -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                            <i class="ri-layout-grid-line text-purple-400"></i>
                        </div>
                        الثيمات المتاحة
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($availableThemes as $theme)
                        <div class="bg-gradient-to-br from-[#121827] to-[#1a2234] rounded-2xl border border-[#2a3548] shadow-xl overflow-hidden hover:border-primary/50 transition-all duration-300 group">
                            <!-- Theme Screenshot -->
                            <div class="h-48 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center relative overflow-hidden">
                                @if($theme['screenshot'])
                                    <img src="{{ $theme['screenshot'] }}" alt="{{ $theme['title'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center">
                                        <i class="ri-layout-line text-6xl text-gray-600 mb-2"></i>
                                        <p class="text-gray-500 text-sm">لا توجد صورة معاينة</p>
                                    </div>
                                @endif
                                
                                @if($activeTheme === $theme['name'])
                                    <div class="absolute top-3 right-3 px-3 py-1 bg-gradient-to-r from-primary to-secondary text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="ri-checkbox-circle-line ml-1"></i>
                                        نشط
                                    </div>
                                @endif
                            </div>

                            <!-- Theme Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $theme['title'] }}</h3>
                                <p class="text-gray-400 text-sm mb-4">{{ $theme['description'] }}</p>
                                
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                    <span>الإصدار: {{ $theme['version'] }}</span>
                                    @if($theme['author'])
                                        <span>{{ $theme['author'] }}</span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    @if($activeTheme !== $theme['name'])
                                        <form action="{{ route('admin.themes.switch') }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="theme_name" value="{{ $theme['name'] }}">
                                            <button type="submit" 
                                                    class="w-full px-4 py-3 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg">
                                                <i class="ri-checkbox-circle-line ml-2"></i>
                                                تفعيل
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.themes.customize') }}" 
                                           class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-300 text-center shadow-lg">
                                            <i class="ri-settings-3-line ml-2"></i>
                                            تخصيص
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 bg-gradient-to-br from-[#121827] to-[#1a2234] rounded-2xl border border-[#2a3548] shadow-xl p-12 text-center">
                            <i class="ri-layout-line text-6xl text-gray-600 mb-4"></i>
                            <h3 class="text-xl font-bold text-white mb-2">لا توجد ثيمات متاحة</h3>
                            <p class="text-gray-400">لم يتم العثور على أي ثيمات مثبتة في المتجر</p>
                        </div>
                    @endforelse
                </div>

                <!-- Theme Data Info -->
                @if($themeData)
                    <div class="mt-8 bg-gradient-to-br from-[#121827] to-[#1a2234] rounded-2xl border border-[#2a3548] shadow-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500/20 to-cyan-500/20 flex items-center justify-center">
                                <i class="ri-database-2-line text-blue-400"></i>
                            </div>
                            معلومات بيانات الثيم النشط
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-[#0f1623] rounded-xl p-4 border border-[#2a3548]">
                                <p class="text-gray-400 text-sm mb-1">صور البطل (Hero)</p>
                                <p class="text-white font-semibold">
                                    {{ $themeData->hero_data && isset($themeData->hero_data['main_image']) ? 'مضافة ✓' : 'غير مضافة' }}
                                </p>
                            </div>
                            <div class="bg-[#0f1623] rounded-xl p-4 border border-[#2a3548]">
                                <p class="text-gray-400 text-sm mb-1">صور البانر</p>
                                <p class="text-white font-semibold">
                                    {{ $themeData->banner_data && isset($themeData->banner_data['main_image']) ? 'مضافة ✓' : 'غير مضافة' }}
                                </p>
                            </div>
                            <div class="bg-[#0f1623] rounded-xl p-4 border border-[#2a3548]">
                                <p class="text-gray-400 text-sm mb-1">بيانات مخصصة</p>
                                <p class="text-white font-semibold">
                                    {{ $themeData->custom_data ? count($themeData->custom_data) . ' حقول' : 'لا توجد' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Dropdown functionality
        function toggleDropdown(id) {
            const content = document.getElementById(id + '-content');
            const arrow = document.getElementById(id + '-arrow');
            
            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
                arrow.style.transform = 'rotate(180deg)';
            } else {
                content.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Initialize dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-open current dropdown
            @if(request()->routeIs('admin.themes.*'))
                const themesContent = document.getElementById('themes-content');
                const themesArrow = document.getElementById('themes-arrow');
                if (themesContent && themesArrow) {
                    themesContent.style.display = 'block';
                    themesArrow.style.transform = 'rotate(180deg)';
                }
            @endif
        });
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(42, 53, 72, 0.3);
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #15B8A6, #10b981);
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            opacity: 0.8;
        }

        .s-dropdown-content {
            display: none;
        }
    </style>
</body>
</html>
