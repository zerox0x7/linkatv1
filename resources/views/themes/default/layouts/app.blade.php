<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    @php
        $storeName = \App\Models\Setting::get('store_name', 'متجرك');
        $storeDescription = \App\Models\Setting::get('store_description', 'متجر متخصص في بيع الحسابات والألعاب بأسعار منافسة');
    @endphp
    
    <meta name="description" content="@yield('meta_description', $storeDescription)" />
    @hasSection('meta_keywords')
        <meta name="keywords" content="@yield('meta_keywords')" />
    @else
        <meta name="keywords" content="{{ $storeName }}, {{ $storeDescription }}" />
    @endif
    <meta name="author" content="{{ $storeName }}" />
    <meta name="robots" content="@yield('meta_robots', 'index, follow')" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:url" content="@yield('og_url', request()->url())" />
    <meta property="og:title" content="@yield('og_title', $storeName)" />
    <meta property="og:description" content="@yield('og_description', $storeDescription)" />
    <meta property="og:image" content="@yield('og_image', asset('storage/' . \App\Models\Setting::get('store_logo', 'logos/logo.png')))" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="@yield('twitter_url', request()->url())" />
    <meta property="twitter:title" content="@yield('twitter_title', $storeName)" />
    <meta property="twitter:description" content="@yield('twitter_description', $storeDescription)" />
    <meta property="twitter:image" content="@yield('twitter_image', asset('storage/' . \App\Models\Setting::get('store_logo', 'logos/logo.png')))" />
    
    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical_url', request()->url())" />
    
    <!-- إضافة بيانات الألوان المخصصة -->
    <meta name="primary-color" content="#{{ \App\Models\Setting::get('primary_color', '2196F3') }}">
    <meta name="secondary-color" content="#{{ \App\Models\Setting::get('secondary_color', '9C27B0') }}">
    
    <title>
        @hasSection('title')
            @if(trim($__env->yieldContent('title')) == $storeName)
                {{ $storeName }}
            @else
                @yield('title') | {{ $storeName }}
            @endif
        @else
            {{ $storeName }}
        @endif
    </title>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#{{ \App\Models\Setting::get('primary_color', '2196F3') }}',
                        secondary: '#{{ \App\Models\Setting::get('secondary_color', '9C27B0') }}',
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
        };
    </script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- الألوان المخصصة -->
    <link rel="stylesheet" href="{{ asset('css/custom-colors.css') }}">
    
    <!-- Theme Styles -->
    <!-- سكريبتات إضافية من الصفحات الفرعية -->
    @yield('head_scripts')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if(\App\Models\Setting::get('store_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/logos/' . basename(\App\Models\Setting::get('store_logo'))) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @endif

    {{-- أكواد CSS/JS المخصصة (الهيدر) --}}
    @if(\App\Models\Setting::get('custom_head_css'))
        <style>
            {!! \App\Models\Setting::get('custom_head_css') !!}
        </style>
    @endif
    @if(\App\Models\Setting::get('custom_head_js'))
        <script>
            {!! \App\Models\Setting::get('custom_head_js') !!}
        </script>
    @endif
</head>
<body class="min-h-screen flex flex-col">
    <!-- Header -->
    @include('theme::partials.header')

    <!-- Flash Messages -->
    @include('theme::partials.alerts')

    <!-- Main Content -->
    <main class="flex-grow relative z-30 flex-shrink-0 flex flex-col">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('theme::partials.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/color-manager.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // تحويل قيم الألوان إلى متغيرات RGB
            const primaryHex = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim();
            const secondaryHex = getComputedStyle(document.documentElement).getPropertyValue('--secondary-color').trim();
            
            // تحويل الألوان من Hex إلى RGB
            const primaryRGB = hexToRgb(primaryHex);
            const secondaryRGB = hexToRgb(secondaryHex);
            
            if (primaryRGB) {
                document.documentElement.style.setProperty('--primary-color-rgb', `${primaryRGB.r}, ${primaryRGB.g}, ${primaryRGB.b}`);
            }
            
            if (secondaryRGB) {
                document.documentElement.style.setProperty('--secondary-color-rgb', `${secondaryRGB.r}, ${secondaryRGB.g}, ${secondaryRGB.b}`);
            }
            
            // دالة تحويل اللون من Hex إلى RGB
            function hexToRgb(hex) {
                hex = hex.replace(/^#/, '');
                
                // تحقق من صلاحية القيمة
                if (!/^[0-9A-F]{6}$/i.test(hex)) {
                    return null;
                }
                
                const r = parseInt(hex.substring(0, 2), 16);
                const g = parseInt(hex.substring(2, 4), 16);
                const b = parseInt(hex.substring(4, 6), 16);
                
                return { r, g, b };
            }
        });
    </script>
    
    @stack('scripts')
    {{-- أكواد JS المخصصة (الفوتر) --}}
    @if(\App\Models\Setting::get('custom_footer_js'))
        <script>
            {!! \App\Models\Setting::get('custom_footer_js') !!}
        </script>
    @endif
</body>
</html> 