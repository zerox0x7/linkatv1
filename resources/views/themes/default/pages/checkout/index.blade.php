@extends('themes.default.layouts.app')

@section('title', 'إتمام الطلب')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <div class="flex items-center text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a>
        <i class="ri-arrow-left-s-line mx-2"></i>
        <a href="{{ route('cart.index') }}" class="hover:text-primary">سلة التسوق</a>
        <i class="ri-arrow-left-s-line mx-2"></i>
        <span class="text-gray-300">إتمام الطلب</span>
    </div>

    <h1 class="text-3xl font-bold text-white mb-6">إتمام الطلب</h1>
    
    @if(session('error'))
        <div class="bg-red-600 bg-opacity-20 border border-red-600 text-red-100 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- معلومات الطلب -->
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <!-- طريقة الدفع -->
                <div class="glass-effect rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-white mb-4">اختر طريقة الدفع</h2>
                    
                    <div class="space-y-4">
                        @forelse($paymentMethods as $method)
                            <div class="flex items-center p-4 border rounded-lg @if(old('payment_method') == $method->code) border-primary bg-gray-800 @else border-gray-700 bg-gray-900/50 @endif hover:border-primary transition-all">
                                <input type="radio" name="payment_method" id="{{ $method->code }}" value="{{ $method->code }}" class="h-5 w-5 text-primary" @if(old('payment_method') == $method->code || $loop->first) checked @endif required>
                                <label for="{{ $method->code }}" class="mr-3 flex flex-grow items-center cursor-pointer">
                                    @if($method->logo)
                                        <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" class="h-8 ml-3">
                                    @else
                                        <div class="text-primary text-2xl ml-2">
                                            @if($method->code == 'credit_card')
                                                <i class="ri-bank-card-line"></i>
                                            @elseif($method->code == 'clickpay')
                                                <i class="ri-secure-payment-line"></i>
                                            @elseif($method->code == 'bank_transfer')
                                                <i class="ri-bank-line"></i>
                                            @elseif($method->code == 'balance')
                                                <i class="ri-wallet-3-line"></i>
                                            @else
                                                <i class="ri-money-dollar-circle-line"></i>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <span class="text-white font-medium">{{ $method->name }}</span>
                                        @if($method->description)
                                            <span class="text-gray-400 text-sm block">{{ $method->description }}</span>
                                        @endif
                                    </div>
                                    @if($method->code == 'balance')
                                        <span class="text-primary text-sm mr-auto font-bold">رصيدك: {{ auth()->user()->balance ?? 0 }} ر.س</span>
                                    @endif
                                </label>
                            </div>
                        @empty
                            <div class="bg-yellow-900/20 border-r-4 border-yellow-500 p-4 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0 text-yellow-500 text-xl ml-3">
                                        <i class="ri-alert-line"></i>
                                    </div>
                                    <div>
                                        <p class="text-yellow-200">
                                            لا توجد طرق دفع متاحة حالياً. يرجى التواصل مع إدارة الموقع.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- زر إتمام الطلب -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-button font-medium text-center hover:opacity-90 transition-all">
                        <i class="ri-secure-payment-line ml-2"></i> إتمام الطلب
                    </button>
                </div>
            </form>
        </div>
        
        <!-- ملخص الطلب -->
        <div class="lg:col-span-1">
            <div class="glass-effect rounded-lg p-6 sticky top-6">
                <h2 class="text-xl font-bold text-white mb-4">ملخص الطلب</h2>
                
                <div class="space-y-4 divide-y divide-gray-700">
                    @foreach($cart->items as $item)
                        <div class="pt-4 first:pt-0">
                            <div class="flex items-start space-x-4 space-x-reverse">
                                <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-700 bg-gray-800">
                                    <img src="{{ $item->cartable->image_url ?? asset('images/placeholder.png') }}" 
                                         alt="{{ $item->cartable->name }}" 
                                         class="h-full w-full object-cover object-center">
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-white font-medium">{{ $item->cartable->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $item->quantity }} × {{ $item->price }} ر.س</p>
                                    
                                    <!-- عرض الخدمة المطلوبة (التنسيق المحسن) -->
                                    {{-- تم إخفاء قسم الخدمة المطلوبة بناءً على طلب العميل --}}
                                    
                                    <!-- عرض الخدمة المطلوبة (التنسيق القديم) -->
                                    {{-- تم إخفاء قسم الخدمة المطلوبة بناءً على طلب العميل --}}
                                </div>
                                <div class="text-white font-medium">
                                    {{ $item->price * $item->quantity }} ر.س
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between border-b border-gray-700 pb-4">
                        <span class="text-gray-300">المجموع</span>
                        <span class="text-white font-medium">{{ $cart->getTotal() }} ر.س</span>
                    </div>
                    
                    @if(session('coupon'))
                    <div class="flex justify-between border-b border-gray-700 pb-4" id="discount-section">
                        <span class="text-gray-300">الخصم ({{ session('coupon')['code'] }})</span>
                        <span class="text-red-400 font-medium">- {{ session('coupon')['discount'] }} ر.س</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between border-b border-gray-700 pb-4">
                        <span class="text-gray-300">الشحن</span>
                        <span class="text-white font-medium">مجاني</span>
                    </div>
                    
                    <div class="flex justify-between pb-4">
                        <span class="text-lg text-white font-medium">الإجمالي</span>
                        <span class="text-lg text-primary font-bold total-amount">
                            @if(session('coupon'))
                                {{ $cart->getTotal() - session('coupon')['discount'] }} ر.س
                            @else
                                {{ $cart->getTotal() }} ر.س
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // تحديث طريقة الدفع عند الاختيار
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            paymentMethods.forEach(m => {
                const container = m.closest('.border');
                if (m.checked) {
                    container.classList.add('border-primary', 'bg-gray-800');
                    container.classList.remove('border-gray-700', 'bg-gray-900/50');
                } else {
                    container.classList.remove('border-primary', 'bg-gray-800');
                    container.classList.add('border-gray-700', 'bg-gray-900/50');
                }
            });
        });
    });
</script>
@endpush 