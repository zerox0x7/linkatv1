@extends('theme::layouts.app')

@section('title', 'طلباتي')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="glass-effect rounded-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">طلباتي</h1>
                
                @if(session('success'))
                <div class="bg-green-800 bg-opacity-25 border border-green-600 text-green-100 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif
                
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
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
                    
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="bg-[#1e1e1e] rounded p-4 text-center">
                        <p class="text-gray-400">لا توجد طلبات سابقة</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium hover:opacity-90 transition-all neon-glow">
                            تصفح المنتجات
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 