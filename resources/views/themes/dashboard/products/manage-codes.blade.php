@extends('themes.admin.layouts.app')

@section('title', 'إدارة الأكواد الرقمية: ' . $product->name)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">إدارة الأكواد الرقمية</h1>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-900">
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                رجوع
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-6">
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-xl shadow-2xl">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">معلومات المنتج</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">معلومات أساسية عن المنتج</p>
                </div>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <div class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 py-1 px-3 rounded-full text-sm">
                        {{ $product->stock }} في المخزون
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <dl>
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">اسم المنتج</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $product->name }}</dd>
                    </div>
                    <div class="bg-white dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">رمز SKU</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $product->sku ?: 'غير محدد' }}</dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">السعر</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $product->price }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- إضافة كود جديد -->
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-xl shadow-2xl">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">إضافة كود جديد</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">أضف كود رقمي جديد إلى المنتج</p>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <form action="{{ route('admin.products.add-code', $product) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الكود الرقمي</label>
                        <div class="mt-1">
                            <input type="text" name="code" id="code" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md" placeholder="أدخل الكود الرقمي هنا" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900">
                            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            إضافة
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- إضافة عدة أكواد دفعة واحدة -->
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-xl shadow-2xl">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">إضافة مجموعة أكواد جديدة</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">أضف مجموعة من الأكواد الجديدة دفعة واحدة (كود واحد في كل سطر)</p>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <form action="{{ route('admin.products.add-multiple-codes', $product) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="new_digital_codes" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الأكواد الجديدة</label>
                        <div class="mt-1">
                            <textarea name="new_digital_codes" id="new_digital_codes" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md" placeholder="أدخل كود واحد في كل سطر"></textarea>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900">
                            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            إضافة الأكواد
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-6 grid grid-cols-1 gap-6">
        <!-- جدول الأكواد مع تبويبات -->
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-xl shadow-2xl">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">الأكواد الرقمية</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">جميع الأكواد الرقمية المرتبطة بهذا المنتج</p>
            </div>
            
            <!-- التبويبات -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex -mb-px" aria-label="Tabs">
                    <button id="tab-available" class="tab-btn px-6 py-4 text-center border-b-2 font-medium text-sm border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-300 focus:outline-none active-tab" type="button">
                        الأكواد المتاحة ({{ count($digitalCodes) }})
                    </button>
                    <button id="tab-sold" class="tab-btn px-6 py-4 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 hover:border-gray-300 focus:outline-none" type="button">
                        الأكواد المباعة ({{ count($soldCodes) }})
                    </button>
                </nav>
            </div>
            
            <!-- محتوى التبويبات -->
            <div id="content-available" class="tab-content">
                @if(count($digitalCodes) > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الكود</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ الإضافة</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($digitalCodes as $code)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $code }}</td>
                                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ \Carbon\Carbon::now()->format('Y-m-d') }}</td>
                                 <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                     <form action="{{ route('admin.products.delete-code', ['product' => $product->id, 'code' => base64_encode($code)]) }}" method="POST" class="inline-block">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200" onclick="return confirm('هل أنت متأكد من حذف هذا الكود؟')">
                                             <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                             </svg>
                                             حذف
                                         </button>
                                     </form>
                                 </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-4 py-5 text-center text-sm text-gray-500">
                        لا توجد أكواد متاحة حالياً
                    </div>
                @endif
            </div>
            
            <div id="content-sold" class="tab-content hidden">
                @if(count($soldCodes) > 0)
                    <!-- عرض كبطاقات في الجوال -->
                    <div class="block sm:hidden space-y-4">
                        @foreach($soldCodes as $code)
                            <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg shadow p-4 flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $code->code }}</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">تم البيع</span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-300">رقم الطلب:
                                    @if(isset($code->order_id))
                                        <a href="{{ route('admin.orders.show', $code->order_id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">#{{ $code->order_id }}</a>
                                    @else
                                        -
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-300">العميل: {{ (isset($code->order) && isset($code->order->user)) ? $code->order->user->name : '-' }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-300">تاريخ البيع: {{ isset($code->updated_at) ? $code->updated_at->format('Y-m-d H:i') : '-' }}</div>
                            </div>
                        @endforeach
                    </div>
                    <!-- جدول في الشاشات الأكبر -->
                    <table class="hidden sm:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الكود</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">رقم الطلب</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">العميل</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ البيع</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($soldCodes as $code)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $code->code }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        @if(isset($code->order_id))
                                            <a href="{{ route('admin.orders.show', $code->order_id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">#{{ $code->order_id }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        @if(isset($code->order) && isset($code->order->user))
                                            {{ $code->order->user->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ isset($code->updated_at) ? $code->updated_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            تم البيع
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-4 py-5 text-center text-sm text-gray-500 dark:text-gray-300">
                        لا توجد أكواد مباعة حالياً
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div id="successAlert" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-md shadow-lg z-50">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 3000);
    </script>
@endif

@if(session('error'))
    <div id="errorAlert" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-md shadow-lg z-50">
        {{ session('error') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('errorAlert').style.display = 'none';
        }, 3000);
    </script>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        // تبديل التبويبات
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // إلغاء تنشيط جميع الأزرار
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-indigo-500', 'text-indigo-600', 'active-tab');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                
                // تنشيط الزر الحالي
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-indigo-500', 'text-indigo-600', 'active-tab');
                
                // إخفاء جميع المحتويات
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                // إظهار المحتوى المناسب
                const tabId = this.id.replace('tab-', 'content-');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    });
</script>
@endpush
@endsection 