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

            @livewire('coupon-settings-modal',['coupon' => $coupon])     
      
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
































{{-- @extends('themes.admin.layouts.app')

@section('title', 'إدارة كوبونات الخصم')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة كوبونات الخصم</h1>
        <a href="{{ route('admin.coupons.create') }}"
            class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded shadow dark:bg-green-700 dark:hover:bg-green-800">
            <i class="fas fa-plus ml-1"></i> إضافة كوبون جديد
        </a>
    </div>

    @if (session('success'))
    <div
        class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>

    @endif

    @if (session('error'))
    <div
        class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded relative">
        {{ session('error') }}
    </div>
    @endif

    <!-- Coupons Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الكود
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            نوع الخصم
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            قيمة الخصم
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاريخ البدء
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاريخ الانتهاء
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحد الأقصى
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الاستخدام
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($coupons as $coupon)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <code
                                class="text-sm font-medium bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $coupon->code }}</code>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($coupon->type == 'fixed')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                مبلغ ثابت
                            </span>
                            @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                نسبة مئوية
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($coupon->type == 'fixed')
                            {{ $coupon->value }} ر.س
                            @else
                            {{ $coupon->value }}%
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d') : 'غير محدد' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'غير محدد' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->max_uses ?: 'غير محدد' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->orders()->where('status', 'completed')->count() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $coupon->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                {{ $coupon->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <a href="{{ route('admin.coupons.show', $coupon->id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                    class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                    class="inline-block delete-form">
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
                        <td colspan="10" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                            لا توجد كوبونات خصم حالياً. <a href="{{ route('admin.coupons.create') }}"
                                class="text-blue-600 hover:underline">إضافة كوبون جديد</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($coupons->count() > 0)
        <div class="bg-white dark:bg-gray-900 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            <div class="flex justify-center">
                {{ $coupons->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // تأكيد الحذف
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                if (confirm('هل أنت متأكد من رغبتك في حذف هذا الكوبون؟')) {
                    this.submit();
                }
            });
        });
    });

    // تبديل حالة الكوبون (نشط/غير نشط) عبر AJAX
    $('.toggle-status').on('change', function() {
        const couponId = $(this).data('id');
        const isChecked = $(this).prop('checked');
        
        $.ajax({
            url: `{{ route('admin.coupons.toggle-status', '') }}/${couponId}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    // إعادة الحالة إلى ما كانت عليه
                    $(this).prop('checked', !isChecked);
                    toastr.error('حدث خطأ أثناء تغيير الحالة');
                }
            },
            error: function() {
                // إعادة الحالة إلى ما كانت عليه
                $(this).prop('checked', !isChecked);
                toastr.error('حدث خطأ أثناء تغيير الحالة');
            }
        });
    });
</script>
@endpush --}}