<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تخصيص الصفحة الرئيسية - {{ \App\Models\Setting::get('store_name', config('app.name')) }}</title>
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
                                <i class="ri-home-5-line text-purple-400"></i>
                            </div>
                            تخصيص الصفحة الرئيسية للثيم
                        </h1>
                        <p class="text-gray-400 mt-1">إعدادات تخصيص الصفحة الرئيسية للثيم: <span class="text-primary font-semibold">{{ ucfirst($activeTheme) }}</span></p>
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

            <!-- Content -->
            <div class="flex-1 p-8" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
                @livewire('home-theme-customizer')
            </div>
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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

            // Initialize Sortable for Hero Slides
            initSortableSlides();
        });

        // Livewire hooks to re-init sortable
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', () => {
                initSortableSlides();
            });
        });

        // Initialize Sortable for slides
        function initSortableSlides() {
            const slidesContainer = document.getElementById('hero-slides-container');
            if (slidesContainer && typeof Sortable !== 'undefined') {
                new Sortable(slidesContainer, {
                    animation: 200,
                    handle: '.drag-handle',
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onEnd: function() {
                        const slideElements = slidesContainer.querySelectorAll('[data-slide-id]');
                        const orderedIds = Array.from(slideElements).map(el => el.getAttribute('data-slide-id'));

                        try {
                            if (typeof window.reorderHeroSlides === 'function') {
                                window.reorderHeroSlides(orderedIds);
                                return;
                            }
                            const livewireEl = slidesContainer.closest('[wire\\:id]');
                            if (livewireEl && typeof Livewire !== 'undefined') {
                                const componentId = livewireEl.getAttribute('wire:id');
                                if (componentId) {
                                    const component = Livewire.find(componentId);
                                    if (component) {
                                        component.call('reorderSlides', orderedIds);
                                        return;
                                    }
                                }
                            }
                            window.dispatchEvent(new CustomEvent('reorder-hero-slides', { detail: { orderedIds } }));
                        } catch (error) {
                            console.error('Error calling reorderSlides:', error);
                        }
                    }
                });
            }
        }
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

        /* Sortable Styles */
        .sortable-ghost {
            opacity: 0.4;
            background: rgba(21, 184, 166, 0.1);
            border: 2px dashed #15B8A6 !important;
        }

        .sortable-drag {
            opacity: 0.8;
            cursor: grabbing !important;
        }

        .drag-handle {
            cursor: grab;
            transition: all 0.3s ease;
        }

        .drag-handle:hover {
            color: #15B8A6;
            transform: scale(1.1);
        }

        .drag-handle:active {
            cursor: grabbing;
        }
    </style>
</body>
</html>


