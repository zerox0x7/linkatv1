@extends('themes.admin.layouts.app')

@section('title', 'إدارة طرق الدفع')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة طرق الدفع</h1>
        <a href="{{ route('admin.payment-methods.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow dark:bg-blue-700 dark:hover:bg-blue-800">
            إضافة طريقة دفع جديدة
        </a>
    </div>
    
    <!-- Payment Methods Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الشعار
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الاسم
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الكود
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            وضع التشغيل
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الرسوم
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            إجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-800">
                    @forelse ($paymentMethods as $method)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-10 w-10 rounded overflow-hidden">
                                @if($method->logo)
                                    <img src="{{ asset('storage/' . $method->logo) }}" 
                                         class="h-10 w-10 object-contain" alt="{{ $method->name }}"
                                         onerror="this.src='{{ asset('images/payment-icon.svg') }}'">
                                @else
                                    <div class="h-10 w-10 flex items-center justify-center bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $method->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ Str::limit($method->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $method->code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $method->mode == 'live' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                {{ $method->mode == 'live' ? 'مباشر' : 'تجريبي' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            @if($method->fee_percentage > 0 || $method->fee_fixed > 0)
                                <div>{{ $method->fee_percentage }}% + {{ $method->fee_fixed }} ر.س</div>
                            @else
                                <div>بدون رسوم</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.payment-methods.toggle-status', $method) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full cursor-pointer {{ $method->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $method->is_active ? 'مفعل' : 'معطل' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف طريقة الدفع هذه؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                            لا توجد طرق دفع متاحة. <a href="{{ route('admin.payment-methods.create') }}" class="text-blue-600 hover:underline">إضافة طريقة دفع جديدة</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 