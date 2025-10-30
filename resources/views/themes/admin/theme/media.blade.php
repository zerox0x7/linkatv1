<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الوسائط - {{ \App\Models\Setting::get('store_name', config('app.name')) }}</title>
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
        @include('themes.admin.parts.sidebar')

        <div class="flex-1 flex flex-col" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
            <div class="bg-gradient-to-r from-[#0f1623] to-[#162033] border-b border-[#2a3548] sticky top-0 z-40 shadow-lg">
                <div class="flex items-center justify-between p-6">
                    <div>
                        <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                                <i class="ri-image-2-line text-purple-400"></i>
                            </div>
                            إدارة الوسائط للثيم
                        </h1>
                        <p class="text-gray-400 mt-1">صور وفيديوهات وملفات: <span class="text-primary font-semibold">{{ ucfirst($activeTheme) }}</span></p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.themes.index') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-[#1a2234] to-[#0f1623] border border-[#2a3548] text-white rounded-xl hover:border-primary/50 transition-all duration-300 flex items-center gap-2 shadow-lg">
                            <i class="ri-arrow-right-line"></i>
                            <span>رجوع</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex-1 p-8" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
                <div class="bg-gradient-to-br from-[#121827] to-[#1a2234] rounded-2xl border border-[#2a3548] shadow-2xl p-8">
                    @livewire('theme-media')
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    <style>
        .s-dropdown-content { display: none; }
    </style>
    <script>
        // Dropdown functionality (same as customize)
        function toggleDropdown(id) {
            const content = document.getElementById(id + '-content');
            const arrow = document.getElementById(id + '-arrow');
            
            if (content && arrow) {
                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                    arrow.style.transform = 'rotate(180deg)';
                } else {
                    content.style.display = 'none';
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        }

        // Initialize dropdowns to open current section
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-open Themes dropdown on themes pages
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
</body>
</html>


