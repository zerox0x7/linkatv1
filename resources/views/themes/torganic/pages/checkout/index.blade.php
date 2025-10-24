@extends('themes.torganic.layouts.app')

@section('title', 'إتمام الطلب - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">إتمام الطلب</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">السلة</a></li>
                        <li class="breadcrumb-item active" aria-current="page">إتمام الطلب</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Section -->
<section class="checkout padding-top padding-bottom">
    <div class="container">
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row g-4">
                <!-- Billing Details -->
                <div class="col-lg-7">
                    <div class="checkout__form">
                        <h4 class="mb-4">تفاصيل الفواتير والشحن</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">الاسم الأول <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">الاسم الأخير <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="country" class="form-label">الدولة <span class="text-danger">*</span></label>
                                <select name="country" id="country" class="form-select" required>
                                    <option value="">اختر الدولة</option>
                                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>المملكة العربية السعودية</option>
                                    <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>الإمارات العربية المتحدة</option>
                                    <option value="KW" {{ old('country') == 'KW' ? 'selected' : '' }}>الكويت</option>
                                    <option value="BH" {{ old('country') == 'BH' ? 'selected' : '' }}>البحرين</option>
                                    <option value="QA" {{ old('country') == 'QA' ? 'selected' : '' }}>قطر</option>
                                    <option value="OM" {{ old('country') == 'OM' ? 'selected' : '' }}>عمان</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="city" class="form-label">المدينة <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">الرمز البريدي</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code') }}">
                            </div>
                            
                            <div class="col-12">
                                <label for="address" class="form-label">العنوان <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="notes" class="form-label">ملاحظات الطلب (اختياري)</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="ملاحظات حول طلبك، مثل تعليمات التوصيل...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="checkout__summary">
                        <h4 class="mb-4">طلبك</h4>
                        
                        <!-- Order Items -->
                        <div class="checkout__items">
                            <div class="checkout__items-header">
                                <span>المنتج</span>
                                <span>المجموع</span>
                            </div>
                            
                            @foreach($cart->items as $item)
                            <div class="checkout__item">
                                <div class="checkout__item-info">
                                    <span class="checkout__item-name">{{ $item->cartable->name ?? 'منتج غير محدد' }}</span>
                                    <span class="checkout__item-qty">× {{ $item->quantity }}</span>
                                    
                                    <!-- عرض بيانات المنتج المخصص -->
                                    @if(isset($item->options['player_data']) && is_array($item->options['player_data']))
                                    <div class="checkout__custom-data">
                                        <small class="text-muted">بيانات المستخدم:</small>
                                        <ul class="list-unstyled small">
                                            @foreach($item->options['player_data'] as $fieldName => $fieldData)
                                                @if($fieldName != 'price_option')
                                                <li>
                                                    @if(is_array($fieldData) && isset($fieldData['label']))
                                                        <strong>{{ $fieldData['label'] }}:</strong>
                                                        @if(isset($fieldData['value']))
                                                            @if(is_array($fieldData['value']))
                                                                @if(isset($fieldData['value']['name']) && isset($fieldData['value']['price']))
                                                                    {{ $fieldData['value']['name'] }} - {{ $fieldData['value']['price'] }} ر.س
                                                                @else
                                                                    {{ implode(', ', array_map(function($v) { return is_array($v) ? '' : $v; }, $fieldData['value'])) }}
                                                                @endif
                                                            @else
                                                                {{ $fieldData['value'] }}
                                                            @endif
                                                        @endif
                                                    @else
                                                        <strong>{{ $fieldName }}:</strong>
                                                        @if(is_array($fieldData))
                                                            {{ implode(', ', array_map(function($v) { return is_array($v) ? '' : $v; }, $fieldData)) }}
                                                        @else
                                                            {{ $fieldData }}
                                                        @endif
                                                    @endif
                                                </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    
                                    <!-- عرض الخدمة المطلوبة -->
                                    @if(isset($item->options['service_option']) && is_array($item->options['service_option']))
                                    <div class="checkout__service-data">
                                        <small class="text-muted">الخدمة المطلوبة:</small>
                                        <div class="small">
                                            {{ $item->options['service_option']['name'] ?? 'خدمة مخصصة' }}
                                            @if(isset($item->options['service_option']['price']))
                                                <span class="text-success">({{ $item->options['service_option']['price'] }} ر.س)</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <span class="checkout__item-price">{{ number_format($item->price * $item->quantity, 2) }} ر.س</span>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Order Totals -->
                        <div class="checkout__totals">
                            <div class="checkout__total-item">
                                <span>المجموع الفرعي:</span>
                                <span>{{ number_format($cart->getSubtotal(), 2) }} ر.س</span>
                            </div>
                            
                            <div class="checkout__total-item">
                                <span>الشحن:</span>
                                <span>مجاني</span>
                            </div>
                            
                            @if(session('coupon'))
                            <div class="checkout__total-item text-success">
                                <span>الخصم ({{ session('coupon')['code'] }}):</span>
                                <span>-{{ number_format(session('coupon')['discount'], 2) }} ر.س</span>
                            </div>
                            @endif
                            
                            <div class="checkout__total-item checkout__total-final">
                                <span>المجموع الكلي:</span>
                                <span>
                                    @if(session('coupon'))
                                        {{ number_format($cart->getTotal() - session('coupon')['discount'], 2) }} ر.س
                                    @else
                                        {{ number_format($cart->getTotal(), 2) }} ر.س
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <!-- Payment Methods -->
                        <div class="checkout__payment mt-4">
                            <h5 class="mb-3">طريقة الدفع</h5>
                            
                            @forelse($paymentMethods as $method)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="{{ $method->code }}" value="{{ $method->code }}" @if(old('payment_method') == $method->code || $loop->first) checked @endif required>
                                    <label class="form-check-label" for="{{ $method->code }}">
                                        @if($method->logo)
                                            <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" class="payment-method-logo me-2" style="height: 20px;">
                                        @endif
                                        {{ $method->name }}
                                        @if($method->description)
                                            <small class="text-muted d-block">{{ $method->description }}</small>
                                        @endif
                                        @if($method->code == 'balance')
                                            <small class="text-primary d-block">رصيدك: {{ auth()->user()->balance ?? 0 }} ر.س</small>
                                        @endif
                                    </label>
                                </div>
                            @empty
                                <div class="alert alert-warning">
                                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                                    لا توجد طرق دفع متاحة حالياً. يرجى التواصل مع إدارة الموقع.
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Terms -->
                        <div class="checkout__terms mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    لقد قرأت ووافقت على <a href="#">الشروط والأحكام</a> <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="trk-btn trk-btn--primary w-100 mt-4">
                            إتمام الطلب <i class="fa-solid fa-lock ms-2"></i>
                        </button>
                        
                        <!-- Security Info -->
                        <div class="checkout__security text-center mt-3">
                            <small class="text-muted">
                                <i class="fa-solid fa-shield-halved me-1"></i>
                                معاملتك آمنة ومحمية
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<style>
.checkout__form,
.checkout__summary {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.checkout__items-header {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    margin-bottom: 15px;
}

.checkout__item {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.checkout__item-info {
    flex: 1;
}

.checkout__item-name {
    display: block;
    font-weight: 500;
}

.checkout__item-qty {
    display: block;
    color: #666;
    font-size: 14px;
}

.checkout__totals {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #dee2e6;
}

.checkout__total-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 15px;
}

.checkout__total-final {
    font-size: 20px;
    font-weight: 700;
    padding-top: 15px;
    margin-top: 15px;
    border-top: 2px solid #333;
}

.form-label {
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control,
.form-select {
    border-radius: 6px;
    padding: 12px 15px;
}

.checkout__custom-data,
.checkout__service-data {
    margin-top: 8px;
    padding: 8px;
    background-color: #f8f9fa;
    border-radius: 4px;
    border-left: 3px solid #007bff;
}

.checkout__custom-data ul {
    margin: 4px 0 0 0;
    padding-right: 15px;
}

.checkout__custom-data li {
    margin-bottom: 2px;
}

.payment-method-logo {
    vertical-align: middle;
}

.checkout__item {
    border-bottom: 1px solid #f0f0f0;
    padding: 15px 0;
}

.checkout__item:last-child {
    border-bottom: none;
}

.payment-method-active {
    background-color: #e3f2fd !important;
    border: 2px solid #2196f3 !important;
    border-radius: 8px !important;
    padding: 10px !important;
}

.form-check {
    transition: all 0.3s ease;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
}

.form-check:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            e.preventDefault();
            alert('يرجى الموافقة على الشروط والأحكام');
            return false;
        }
    });
    
    // Handle payment method selection styling
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            // Remove active class from all payment method containers
            paymentMethods.forEach(m => {
                const container = m.closest('.form-check');
                if (container) {
                    container.classList.remove('payment-method-active');
                }
            });
            
            // Add active class to selected payment method
            if (this.checked) {
                const container = this.closest('.form-check');
                if (container) {
                    container.classList.add('payment-method-active');
                }
            }
        });
        
        // Set initial active state
        if (method.checked) {
            const container = method.closest('.form-check');
            if (container) {
                container.classList.add('payment-method-active');
            }
        }
    });
});
</script>
@endpush

