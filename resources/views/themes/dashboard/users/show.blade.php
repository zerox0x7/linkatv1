@extends('themes.admin.layouts.app')

@section('title', 'عرض المستخدم: ' . $user->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">عرض تفاصيل المستخدم</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- User Info -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">المعلومات الشخصية</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col items-center pb-4">
                        <img class="h-32 w-32 rounded-full object-cover mb-3" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $user->name }}">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                        <div class="mt-1 flex items-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role == 'admin' ? 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' }}">
                                {{ $user->role == 'admin' ? 'مسؤول' : 'مستخدم' }}
                            </span>
                            <span class="mx-2">•</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4 space-y-3">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">البريد الإلكتروني</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                        </div>
                        @if($user->phone)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">رقم الهاتف</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->phone }}</p>
                        </div>
                        @endif
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">تاريخ التسجيل</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">آخر تحديث</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->updated_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-t dark:border-gray-700 flex justify-end">
                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 ml-2">
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        تعديل
                    </a>
                    <button onclick="if(confirm('هل أنت متأكد من حذف هذا المستخدم؟')) document.getElementById('delete-user').submit();" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        حذف
                    </button>
                    <form id="delete-user" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        <!-- User Activities -->
        <div class="md:col-span-2 space-y-6">
            <!-- Order History -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">آخر الطلبات</h3>
                    <a href="{{ route('admin.orders.index') }}?user_id={{ $user->id }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">عرض جميع الطلبات</a>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($user->orders as $order)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <div class="flex justify-between items-center">
                            <div>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 font-medium">#{{ $order->id }}</a>
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ number_format($order->total, 2) }} ر.س</div>
                                <div class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 
                                        @elseif($order->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                        @elseif($order->status == 'processing') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                        @elseif($order->status == 'cancelled') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                        @else bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 @endif">
                                        {{ trans('orders.status.' . $order->status) ?? $order->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500 dark:text-gray-300">
                        لا توجد طلبات لهذا المستخدم حتى الآن.
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- User Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">إحصائيات المستخدم</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <div class="text-blue-500 dark:text-blue-300 text-sm font-medium">إجمالي الطلبات</div>
                            <div class="text-2xl font-bold text-blue-700 dark:text-blue-200 mt-1">{{ $user->orders->count() }}</div>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <div class="text-green-500 dark:text-green-300 text-sm font-medium">إجمالي المشتريات</div>
                            <div class="text-2xl font-bold text-green-700 dark:text-green-200 mt-1">{{ number_format($user->orders->sum('total'), 2) }} ر.س</div>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                            <div class="text-purple-500 dark:text-purple-300 text-sm font-medium">آخر نشاط</div>
                            <div class="text-xl font-bold text-purple-700 dark:text-purple-200 mt-1">
                                @if($user->orders->isNotEmpty())
                                    {{ $user->orders->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 