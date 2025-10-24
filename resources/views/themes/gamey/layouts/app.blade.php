<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $themeConfig['settings']['rtl_support'] ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Gamey Store - Gaming Paradise')</title>
    <meta name="description" content="@yield('description', 'Your ultimate gaming store for accounts, items, and digital goods')">
    
    <!-- Favicon -->
    @if(isset($themeConfig['settings']['logos']['favicon']))
        <link rel="icon" href="{{ $themeConfig['settings']['logos']['favicon'] }}" type="image/x-icon">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'gaming': ['Orbitron', 'monospace'],
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'neon-blue': '#00BFFF',
                        'neon-green': '#39FF14',
                        'neon-purple': '#BF00FF',
                        'neon-orange': '#FF6600',
                        'dark-bg': '#0a0a0a',
                        'dark-surface': '#1a1a1a',
                        'dark-card': '#242424',
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        glow: {
                            '0%': { 'box-shadow': '0 0 5px rgba(0, 191, 255, 0.5)' },
                            '100%': { 'box-shadow': '0 0 20px rgba(0, 191, 255, 0.8)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    },
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <link href="{{ asset('themes/gamey/css/style.css') }}" rel="stylesheet">
    @if(isset($themeConfig['settings']['customizations']['custom_css']))
        <style>
            {!! implode("\n", $themeConfig['settings']['customizations']['custom_css']) !!}
        </style>
    @endif
    
    @stack('head')
</head>
<body class="bg-dark-bg text-white min-h-screen {{ $themeConfig['settings']['features']['enable_dark_mode'] ? 'dark' : '' }}">
    
    @if($themeConfig['settings']['features']['enable_loading_screen'])
        <div id="loading-screen" class="fixed inset-0 bg-dark-bg z-50 flex items-center justify-center">
            <div class="text-center">
                <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-neon-blue mx-auto mb-4"></div>
                <div class="font-gaming text-neon-blue text-xl animate-pulse">Loading Game...</div>
            </div>
        </div>
    @endif
    
    <!-- Header -->
    @include('themes.gamey.partials.header')
    
    <!-- Navigation -->
    @include('themes.gamey.partials.nav')
    
    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('themes.gamey.partials.footer')
    
    <!-- Back to Top Button -->
    @if($themeConfig['settings']['features']['enable_back_to_top'])
        <button id="back-to-top" class="fixed bottom-6 right-6 bg-neon-blue hover:bg-blue-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 translate-y-10 z-40">
            <i class="fas fa-arrow-up"></i>
        </button>
    @endif
    
    <!-- Cart Sidebar -->
    <div id="cart-sidebar" class="fixed right-0 top-0 h-full w-80 bg-dark-surface transform translate-x-full transition-transform duration-300 z-40 border-l border-gray-700">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-gaming text-neon-blue">Shopping Cart</h3>
                <button id="close-cart" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="cart-items">
                <!-- Cart items will be loaded here -->
            </div>
        </div>
    </div>
    
    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('themes/gamey/js/app.js') }}"></script>
    
    @if(isset($themeConfig['settings']['customizations']['custom_js']))
        <script>
            {!! implode("\n", $themeConfig['settings']['customizations']['custom_js']) !!}
        </script>
    @endif
    
    @if(isset($themeConfig['settings']['integrations']['analytics_codes']))
        @foreach($themeConfig['settings']['integrations']['analytics_codes'] as $code)
            {!! $code !!}
        @endforeach
    @endif
    
    @stack('scripts')
</body>
</html> 