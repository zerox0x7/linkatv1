<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إدارة الفئات</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }

        .status-badge {
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 0.75rem;
        }

        .status-active {
            background-color: #10b981;
            color: white;
        }

        .status-inactive {
            background-color: #6b7280;
            color: white;
        }

        input:focus,
        button:focus {
            outline: none;
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


    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#00e5c9",
                        secondary: "#6b46c1"
                    },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "8px",
                        md: "12px",
                        lg: "16px",
                        xl: "20px",
                        "2xl": "24px",
                        "3xl": "32px",
                        full: "9999px",
                        button: "8px",
                    },
                },
            },
        };
    </script>


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
    <div class="flex">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')


        <!-- Main Content -->
        <div class="flex-1 ">
            <!-- Top Bar -->
            <!-- Header -->
            @include('themes.admin.parts.header')
            <!-- Page Content -->
            @livewire('categories')
        </div>
    </div>


 


 
 <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        @livewire('category-add-new')

        <style>
            /* تحسين زر التبديل */
            #statusToggle:checked+label {
                background-color: #10B981;
                /* لون أخضر للحالة النشطة */
            }

            #statusToggle:not(:checked)+label {
                background-color: #6B7280;
                /* لون رمادي للحالة غير النشطة */
            }

            #statusToggle:checked+label+div {
                transform: translateX(28px);
            }

            #statusToggle:not(:checked)+label+div {
                transform: translateX(1px);
            }

            /* تحسين الأزرار */
            .rounded-button {
                border-radius: 8px;
            }
        </style>

        <script>
            // JavaScript لتحديث نص الحالة
            document.getElementById('statusToggle').addEventListener('change', function() {
                const statusText = document.getElementById('statusText');
                const statusDescription = document.getElementById('statusDescription');

                if (this.checked) {
                    statusText.textContent = 'نشط';
                    statusDescription.textContent = 'الفئة متاحة للعرض';
                } else {
                    statusText.textContent = 'غير نشط';
                    statusDescription.textContent = 'الفئة مخفية عن العرض';
                }
            });
        </script>
</div>




 <script id="modalScript">
        document.addEventListener("DOMContentLoaded", function() {
            const addCategoryBtn = document.querySelector("#addCategoryModel");
            const modal = document.getElementById("addCategoryModal");
            const closeModal = document.getElementById("closeModal");
            const cancelButton = document.getElementById("cancelButton");

            addCategoryBtn.addEventListener("click", function() {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            });

            const hideModal = function() {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            };

            closeModal.addEventListener("click", hideModal);
            cancelButton.addEventListener("click", hideModal);

            // Close modal when clicking outside
            modal.addEventListener("click", function(e) {
                if (e.target === modal) {
                    hideModal();
                }
            });
        });
    </script>









 
    <!-- Add Category Modal (Hidden by default) -->
    {{-- <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-[#1A202C] rounded-lg w-full max-w-md p-6 shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">إضافة فئة جديدة</h2>
                <button id="closeModal" class="text-gray-400 hover:text-white">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="ri-close-line"></i>
                    </div>
                </button>
            </div>

            <form>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">اسم الفئة</label>
                    <input type="text" class="w-full bg-gray-800 text-white py-2 px-4 rounded border-none"
                        placeholder="أدخل اسم الفئة">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">وصف الفئة</label>
                    <textarea class="w-full bg-gray-800 text-white py-2 px-4 rounded border-none h-24 resize-none"
                        placeholder="أدخل وصف الفئة"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">صورة الفئة</label>
                    <div class="border-2 border-dashed border-gray-700 rounded-lg p-4 text-center">
                        <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center bg-gray-800 rounded-full">
                            <i class="ri-upload-2-line text-gray-400"></i>
                        </div>
                        <p class="text-sm text-gray-400">
                            اسحب الصورة هنا أو انقر للتصفح
                        </p>
                        <input type="file" class="hidden" id="categoryImage">
                        <button type="button" class="mt-2 text-xs text-primary"
                            onclick="document.getElementById('categoryImage').click()">
                            تصفح الملفات
                        </button>
                    </div>
                </div>

                <!-- الترتيب والحالة في نفس الصف -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <!-- ترتيب الفئة -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">ترتيب الفئة</label>
                        <input type="number" class="w-full bg-gray-800 text-white py-2 px-4 rounded border-none"
                            placeholder="1" min="1">
                    </div>

                    <!-- ترتيب الصفحة الرئيسية -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">ترتيب الصفحة الرئيسية</label>
                        <input type="number" class="w-full bg-gray-800 text-white py-2 px-4 rounded border-none"
                            placeholder="1" min="1">
                    </div>
                </div>

                <!-- زر الحالة المحسن -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">الحالة</label>
                    <div class="flex items-center">
                        <div class="relative inline-block w-14 h-7 ml-3">
                            <input type="checkbox" id="statusToggle" class="sr-only" checked>
                            <label for="statusToggle"
                                class="block overflow-hidden h-7 rounded-full cursor-pointer transition-colors duration-300 bg-primary"></label>
                            <div
                                class="absolute right-8 top-1 bg-white w-5 h-5 rounded-full transition-transform duration-300 ease-in-out transform translate-x-7 shadow-lg">
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-white" id="statusText">نشط</span>
                            <span class="text-xs text-gray-400" id="statusDescription">الفئة متاحة للعرض</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelButton"
                        class="bg-gray-800 text-white px-4 py-2 rounded-button whitespace-nowrap hover:bg-gray-700 transition-colors">
                        إلغاء
                    </button>
                    <button type="submit"
                        class="bg-primary text-gray-900 px-4 py-2 rounded-button whitespace-nowrap hover:bg-primary/90 transition-colors">
                        إضافة الفئة
                    </button>
                </div>
            </form>
        </div>

        <style>
            /* تحسين زر التبديل */
            #statusToggle:checked+label {
                background-color: #10B981;
                /* لون أخضر للحالة النشطة */
            }

            #statusToggle:not(:checked)+label {
                background-color: #6B7280;
                /* لون رمادي للحالة غير النشطة */
            }

            #statusToggle:checked+label+div {
                transform: translateX(28px);
            }

            #statusToggle:not(:checked)+label+div {
                transform: translateX(1px);
            }

            /* تحسين الأزرار */
            .rounded-button {
                border-radius: 8px;
            }
        </style>

        <script>
            // JavaScript لتحديث نص الحالة
            document.getElementById('statusToggle').addEventListener('change', function() {
                const statusText = document.getElementById('statusText');
                const statusDescription = document.getElementById('statusDescription');

                if (this.checked) {
                    statusText.textContent = 'نشط';
                    statusDescription.textContent = 'الفئة متاحة للعرض';
                } else {
                    statusText.textContent = 'غير نشط';
                    statusDescription.textContent = 'الفئة مخفية عن العرض';
                }
            });
        </script>
    </div> --}}

    {{-- <script id="toggleScript">
        document.addEventListener("DOMContentLoaded", function() {
            const statusToggle = document.getElementById("statusToggle");
            const toggleLabel = statusToggle.nextElementSibling;

            statusToggle.checked = true; // Default to active

            statusToggle.addEventListener("change", function() {
                if (this.checked) {
                    toggleLabel.classList.add("bg-primary");
                    toggleLabel.classList.remove("bg-gray-700");
                    toggleLabel.nextElementSibling.classList.add("translate-x-6");
                } else {
                    toggleLabel.classList.remove("bg-primary");
                    toggleLabel.classList.add("bg-gray-700");
                    toggleLabel.nextElementSibling.classList.remove("translate-x-6");
                }
            });

            // Trigger change event to set initial state
            statusToggle.dispatchEvent(new Event("change"));
        });
    </script> --}}

    





    {{-- <!-- JavaScript للتحكم في القوائم المنسدلة -->
    <script>
        function toggleDropdown(section) {
            const content = document.getElementById(section + '-content');
            const arrow = document.getElementById(section + '-arrow');

            // تبديل القائمة الحالية فقط
            content.classList.toggle('show');
            arrow.classList.toggle('rotate-180');
        }

        // فتح قسم إدارة المتجر افتراضياً
        // document.addEventListener('DOMContentLoaded', function() {
        //     toggleDropdown('store');
        // });
    </script> --}}





    {{-- <script id="notification-handler">
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBtn = document.getElementById('notification-btn');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const markAllReadBtn = document.getElementById('mark-all-read');
            const languageButton = document.getElementById('language-button');
            const languageDropdown = document.getElementById('language-dropdown');
            let isDropdownOpen = false;
            let isLanguageDropdownOpen = false;
            notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                isDropdownOpen = !isDropdownOpen;
                notificationDropdown.classList.toggle('hidden');
            });
            languageButton.addEventListener('click', (e) => {
                e.stopPropagation();
                isLanguageDropdownOpen = !isLanguageDropdownOpen;
                languageDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!notificationBtn.contains(e.target) && isDropdownOpen) {
                    notificationDropdown.classList.add('hidden');
                    isDropdownOpen = false;
                }
                if (!languageButton.contains(e.target) && isLanguageDropdownOpen) {
                    languageDropdown.classList.add('hidden');
                    isLanguageDropdownOpen = false;
                }
            });
            markAllReadBtn.addEventListener('click', () => {
                const unreadDots = document.querySelectorAll('.notification-item .bg-primary');
                unreadDots.forEach(dot => {
                    dot.classList.remove('bg-primary');
                    dot.classList.add('bg-gray-600');
                });
                const notificationDot = notificationBtn.querySelector('.bg-primary');
                if (notificationDot) {
                    notificationDot.classList.add('hidden');
                }
            });
        });
    </script> --}}



<script>
    /**
     * Handles the image drop event.
     * @param {DragEvent} event - The drag event with the dropped file.
     */
    function handleImageDrop(event) {
        event.preventDefault();
        const inputFile = document.getElementById('categoryImage');
        const files = event.dataTransfer.files;

        // Check if a file was dropped and it's an image
        if (files && files.length > 0) {
            const file = files[0];
            
            // Validate file type
            if (file.type.startsWith('image/')) {
                // Create a new FileList-like object
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                inputFile.files = dataTransfer.files;

                // Trigger a change event to let Livewire handle the upload
                const changeEvent = new Event('change', { bubbles: true });
                inputFile.dispatchEvent(changeEvent);
            } else {
                alert('يرجى رفع ملف صورة فقط');
            }
        }
    }
</script>





</body>
</html>



</body>

</html>










{{-- @extends('themes.admin.layouts.app')

@section('title', 'إدارة التصنيفات')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">قائمة التصنيفات</h1>
            <p class="text-gray-600 dark:text-gray-300">عرض وإدارة تصنيفات المنتجات</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            إضافة تصنيف
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
        @if ($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-500 dark:text-gray-300">
                    <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">الصورة</th>
                            <th scope="col" class="px-6 py-3">الاسم</th>
                            <th scope="col" class="px-6 py-3">التصنيف الأب</th>
                            <th scope="col" class="px-6 py-3">عدد المنتجات</th>
                            <th scope="col" class="px-6 py-3">الحالة</th>
                            <th scope="col" class="px-6 py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-6 py-4">{{ $category->id }}</td>
                                <td class="px-6 py-4">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200">لا توجد صورة</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
                                <td class="px-6 py-4">
                                    @if ($category->parent)
                                        {{ $category->parent->name }}
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">تصنيف رئيسي</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">{{ $category->products_count }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($category->is_active)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">نشط</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">غير نشط</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900" title="عرض">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-900" title="تعديل">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-900" onclick="confirmDelete('{{ $category->id }}', '{{ $category->name }}', {{ $category->products_count }}, {{ $category->children->count() }})" title="حذف">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- قالب نافذة الحذف المنبثقة - سيتم استدعاؤه باستخدام جافاسكريبت -->
                                    <div id="deleteModal{{ $category->id }}" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-80 transition-opacity" aria-hidden="true"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                <div class="bg-white dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                                                تأكيد الحذف
                                                            </h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                                                    هل أنت متأكد من حذف تصنيف "<span id="categoryName{{ $category->id }}"></span>"؟
                                                                </p>
                                                                <div id="warningSection{{ $category->id }}" class="mt-2 text-sm text-red-500">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <form id="deleteForm{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                            حذف
                                                        </button>
                                                    </form>
                                                    <button type="button" onclick="closeModal('{{ $category->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-700 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        إلغاء
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500 mb-4">لا توجد تصنيفات متاحة حاليًا.</p>
                <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    إضافة تصنيف جديد
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name, productsCount, childrenCount) {
        document.getElementById('categoryName' + id).textContent = name;
        
        let warningText = '';
        if (productsCount > 0) {
            warningText += '<strong>تحذير:</strong> هذا التصنيف يحتوي على ' + productsCount + ' منتج.<br>';
        }
        
        if (childrenCount > 0) {
            warningText += '<strong>تحذير:</strong> هذا التصنيف يحتوي على ' + childrenCount + ' تصنيف فرعي.';
        }
        
        document.getElementById('warningSection' + id).innerHTML = warningText;
        document.getElementById('deleteModal' + id).style.display = 'block';
    }
    
    function closeModal(id) {
        document.getElementById('deleteModal' + id).style.display = 'none';
    }
</script>
@endpush  --}}
