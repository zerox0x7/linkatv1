<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?: $title }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $page->meta_description ?: $page->title }}">
    @if(isset($page->meta_keywords) && $page->meta_keywords)
    <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#00c853',
                    secondary: '#2196f3'
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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        font-family: 'Cairo', sans-serif;
        background-color: #0f172a;
        color: #e2e8f0;
    }

    .glass-effect {
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .prose {
        max-width: none;
        color: #e2e8f0;
    }

    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #ffffff;
    }

    .prose p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }

    .prose ul, .prose ol {
        margin-bottom: 1rem;
        padding-right: 1.5rem;
    }

    .prose li {
        margin-bottom: 0.5rem;
    }

    .prose a {
        color: #00c853;
        text-decoration: none;
    }

    .prose a:hover {
        color: #00e676;
        text-decoration: underline;
    }

    .prose img {
        border-radius: 8px;
        margin: 1rem 0;
    }

    .prose blockquote {
        border-right: 4px solid #00c853;
        padding-right: 1rem;
        margin: 1rem 0;
        font-style: italic;
        background: rgba(0, 200, 83, 0.1);
        padding: 1rem;
        border-radius: 8px;
    }

    .prose code {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
    }

    .prose pre {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 8px;
        overflow-x: auto;
    }

    .prose table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    .prose th, .prose td {
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.5rem;
        text-align: right;
    }

    .prose th {
        background: rgba(0, 200, 83, 0.2);
        font-weight: bold;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeInUp 0.6s ease-out;
    }
    </style>
</head>

<body class="min-h-screen">
    @include('themes.greenGame.partials.top-header')
    @include('themes.greenGame.partials.header')

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="glass-effect rounded-xl p-6 md:p-8 fade-in">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    {{ $page->title }}
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
            </div>
            
            <!-- Page Content -->
            <div class="prose prose-lg max-w-none">
                {!! $page->content !!}
            </div>
            
            <!-- Page Footer -->
            <div class="mt-12 pt-8 border-t border-gray-700 text-center">
                <div class="flex items-center justify-center space-x-2 text-gray-400">
                    <i class="ri-calendar-line"></i>
                    <span>تم التحديث الأخير: {{ $page->updated_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </main>

    @include('themes.greenGame.partials.footer')

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 left-6 bg-primary hover:bg-green-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 invisible">
        <i class="ri-arrow-up-line text-xl"></i>
    </button>

    <script>
        // Back to top functionality
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.add('opacity-0', 'invisible');
                backToTopButton.classList.remove('opacity-100', 'visible');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Add smooth scrolling to anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
