<!DOCTYPE html>
<html lang="en" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Management</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00e5c9',
                        secondary: '#1f2937'
                     
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
    <style>
        /* :where([class^="ri-"])::before {
            content: "\f3c2";
        } */

        body {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .coupon-card {
            position: relative;
            overflow: hidden;
            height: 180px;
        }

        .coupon-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .coupon-content {
            position: relative;
            z-index: 1;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: rgba(0, 0, 0, 0.4);
        }

        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #4b5563;
            border-radius: 4px;
            background-color: transparent;
            display: inline-block;
            position: relative;
            cursor: pointer;
        }

        input[type="checkbox"]:checked {
            background-color: #00e5c9;
            border-color: #00e5c9;
        }

        input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .status-inactive {
            background-color: rgba(156, 163, 175, 0.2);
            color: #9ca3af;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 229, 201, 0.3);
        }

        .pagination-item {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            cursor: pointer;
        }

        .pagination-item.active {
            background-color: #00e5c9;
            color: #1a202c;
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

    {{-- <div
        class="relative w-full max-w-3xl h-80 mx-auto bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300 rounded-3xl shadow-2xl overflow-hidden">
        <!-- Marble veining -->
        <div class="absolute inset-0 opacity-40">
            <div
                class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent transform rotate-12 scale-150">
            </div>
            <div
                class="absolute top-12 left-0 w-full h-px bg-gradient-to-r from-gray-500 via-transparent to-gray-600 transform -rotate-6 scale-125">
            </div>
            <div
                class="absolute top-24 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-700 to-gray-500 transform rotate-3 scale-110">
            </div>
            <div
                class="absolute bottom-16 left-0 w-full h-px bg-gradient-to-r from-gray-600 via-gray-400 to-transparent transform -rotate-12 scale-140">
            </div>
        </div>

        <!-- Marble highlights -->
        <div class="absolute inset-0 bg-gradient-to-tr from-white/30 via-transparent to-white/20"></div>

        <!-- Content -->
        <div class="relative flex items-center justify-center h-full">
            <div class="text-center">
                <!-- Engraved text effect -->
                <h1 class="text-7xl md:text-9xl font-bold tracking-wider relative">
                    <!-- Engraved shadow -->
                    <span class="absolute inset-0 text-gray-400 transform translate-x-1 translate-y-1">AABCCN</span>

                    <!-- Main text -->
                    <span class="relative text-gray-700"
                        style="text-shadow: -1px -1px 0 rgba(255,255,255,0.8), 1px 1px 2px rgba(0,0,0,0.3);">
                        AABCCN
                    </span>
                </h1>

                <!-- Decorative elements -->
                <div class="mt-8 flex justify-center items-center space-x-4">
                    <div class="w-8 h-px bg-gradient-to-r from-transparent to-gray-500"></div>
                    <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                    <div class="w-8 h-px bg-gradient-to-l from-transparent to-gray-500"></div>
                </div>
            </div>
        </div>

        <!-- Marble polish shine -->
        <div class="absolute top-8 left-8 w-32 h-32 bg-white/20 rounded-full blur-3xl"></div>
    </div> --}}

    <div class="flex">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')
        <!-- Main Content -->
        <div class="flex-1 ">
            <!-- Header -->
            @include('themes.admin.parts.header')
            <!-- Content -->
            @livewire('create-coupon');
      
        </div>


    </div>
    <script id="checkboxScript">
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const couponCard = this.closest('.bg-gray-800');
                    if (this.checked) {
                        couponCard.classList.add('ring-2', 'ring-primary');
                    } else {
                        couponCard.classList.remove('ring-2', 'ring-primary');
                    }
                });
            });
        });
    </script>
    <script id="paginationScript">
        document.addEventListener('DOMContentLoaded', function() {
            const paginationItems = document.querySelectorAll('.pagination-item');
            paginationItems.forEach(item => {
                item.addEventListener('click', function() {
                    paginationItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
    <script id="buttonsScript">
        document.addEventListener('DOMContentLoaded', function() {
            const actionButtons = document.querySelectorAll('.bg-gray-700');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.classList.add('bg-gray-600');
                });
                button.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-gray-600');
                });
            });
        });
    </script>











</body>

</html>
































