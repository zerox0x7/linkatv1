@extends('theme::layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- بطاقة معلومات الملف الشخصي -->
        <div class="glass-effect rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">الملف الشخصي</h1>
                
                @if(session('success'))
                <div class="bg-green-800 bg-opacity-25 border border-green-600 text-green-100 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif
                
                <div class="flex flex-col md:flex-row">
                    <!-- صورة الملف الشخصي -->
                    <div class="w-full md:w-1/3 mb-4 md:mb-0 flex flex-col items-center">
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-800 mb-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-700 text-gray-300">
                                    <i class="ri-user-3-line ri-3x"></i>
                                </div>
                            @endif
                        </div>
                        <h2 class="text-xl font-semibold text-white">{{ $user->name }}</h2>
                        <p class="text-gray-400">عضو منذ {{ $user->created_at->format('Y/m/d') }}</p>
                    </div>
                    
                    <!-- معلومات الملف الشخصي -->
                    <div class="w-full md:w-2/3 md:pr-6">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="name" class="block text-gray-300 mb-2">الاسم</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                    class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-3 text-white focus:outline-none focus:border-primary">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="block text-gray-300 mb-2">البريد الإلكتروني</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                    class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-3 text-white focus:outline-none focus:border-primary">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-300 mb-2">رقم الهاتف</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                    class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-3 text-white focus:outline-none focus:border-primary">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="avatar" class="block text-gray-300 mb-2">تغيير الصورة الشخصية</label>
                                <input type="file" name="avatar" id="avatar" 
                                    class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-3 text-white focus:outline-none focus:border-primary">
                                @error('avatar')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium hover:opacity-90 transition-all neon-glow">
                                    حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- تغيير كلمة المرور -->
        <div class="glass-effect rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">تغيير كلمة المرور</h2>
                
                <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="current_password" class="block text-gray-300 mb-2">كلمة المرور الحالية</label>
                        <input type="password" name="current_password" id="current_password" 
                            class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-3 text-white focus:outline-none focus:border-primary">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-gray-300 mb-2">كلمة المرور الجديدة</label>
                        <input type="password" name="password" id="password" 
                            class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-3 text-white focus:outline-none focus:border-primary">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-300 mb-2">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-3 text-white focus:outline-none focus:border-primary">
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium hover:opacity-90 transition-all neon-glow">
                            تحديث كلمة المرور
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- آخر الطلبات -->
        <div class="glass-effect rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">آخر الطلبات</h2>
                
                @if(isset($orders) && $orders && $orders->count() > 0)
                    <!-- عرض الجدول للشاشات الكبيرة -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-[#3a3a3a]">
                                    <th class="py-3 px-4 text-right">رقم الطلب</th>
                                    <th class="py-3 px-4 text-right">التاريخ</th>
                                    <th class="py-3 px-4 text-right">المبلغ</th>
                                    <th class="py-3 px-4 text-right">الحالة</th>
                                    <th class="py-3 px-4 text-right">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr class="border-b border-[#2a2a2a]">
                                    <td class="py-3 px-4">#{{ $order->order_number }}</td>
                                    <td class="py-3 px-4">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td class="py-3 px-4">{{ $order->total }} {{ \App\Models\Setting::get('currency_symbol', 'ر.س') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-2 py-1 rounded text-xs 
                                            @if($order->status === 'completed') bg-green-900 text-green-300
                                            @elseif($order->status === 'pending') bg-yellow-900 text-yellow-300
                                            @elseif($order->status === 'cancelled') bg-red-900 text-red-300
                                            @else bg-blue-900 text-blue-300 @endif">
                                            {{ $order->status === 'completed' ? 'مكتمل' : 
                                              ($order->status === 'pending' ? 'قيد الانتظار' : 
                                              ($order->status === 'cancelled' ? 'ملغي' : 'قيد المعالجة')) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-primary hover:underline">عرض التفاصيل</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- عرض البطاقات للهواتف والشاشات الصغيرة -->
                    <div class="md:hidden space-y-4">
                        @foreach($orders as $order)
                        <div class="glass-effect rounded-lg p-4 mb-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-white font-bold">#{{ $order->order_number }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $order->created_at->format('Y-m-d') }}</p>
                                </div>
                                <span class="inline-block px-2 py-1 rounded text-xs 
                                    @if($order->status === 'completed') bg-green-900 text-green-300
                                    @elseif($order->status === 'pending') bg-yellow-900 text-yellow-300
                                    @elseif($order->status === 'cancelled') bg-red-900 text-red-300
                                    @else bg-blue-900 text-blue-300 @endif">
                                    {{ $order->status === 'completed' ? 'مكتمل' : 
                                      ($order->status === 'pending' ? 'قيد الانتظار' : 
                                      ($order->status === 'cancelled' ? 'ملغي' : 'قيد المعالجة')) }}
                                </span>
                            </div>
                            <div class="border-t border-gray-700 my-3"></div>
                            <!-- عرض المنتجات المطلوبة -->
                            @if($order->items && $order->items->count() > 0)
                                <div class="mb-3">
                                    <div class="text-xs text-gray-400 mb-1">المنتجات:</div>
                                    <div class="space-y-1">
                                        @foreach($order->items->take(3) as $index => $item)
                                            <div class="text-sm text-gray-300 truncate">{{ $item->name ?? 'منتج #' . $index }}</div>
                                        @endforeach
                                        @if($order->items->count() > 3)
                                            <div class="text-xs text-gray-400">+ {{ $order->items->count() - 3 }} منتجات أخرى</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="flex justify-between items-end">
                                <div class="text-primary font-bold">{{ $order->total }} {{ \App\Models\Setting::get('currency_symbol', 'ر.س') }}</div>
                                <a href="{{ route('orders.show', $order->id) }}" class="flex items-center text-primary hover:underline">
                                    <span>عرض التفاصيل</span>
                                    <i class="ri-arrow-left-line mr-1"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('orders.index') }}" class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-button text-sm font-medium inline-block">عرض كل الطلبات</a>
                    </div>
                @else
                    <div class="bg-[#1e1e1e] rounded p-4 text-center">
                        <p class="text-gray-400">لا توجد طلبات سابقة</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection