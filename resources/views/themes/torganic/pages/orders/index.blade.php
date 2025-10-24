@extends('themes.torganic.layouts.app')

@section('title', 'طلباتي - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">طلباتي</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">حسابي</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الطلبات</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Orders Section -->
<section class="orders padding-top padding-bottom">
    <div class="container">
        @if(isset($orders) && $orders->isNotEmpty())
        <div class="orders__list">
            @foreach($orders as $order)
            <div class="order__item mb-4">
                <div class="order__header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-2">طلب #{{ $order->id }}</h5>
                            <div class="order__meta">
                                <span class="me-3"><i class="fa-regular fa-calendar me-1"></i> {{ $order->created_at->format('d/m/Y') }}</span>
                                <span class="me-3"><i class="fa-solid fa-box me-1"></i> {{ $order->items_count ?? 0 }} منتج</span>
                                <span><i class="fa-solid fa-money-bill me-1"></i> {{ number_format($order->total, 2) }} ر.س</span>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            @php
                                $statusClasses = [
                                    'pending' => 'warning',
                                    'processing' => 'info',
                                    'shipped' => 'primary',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                ];
                                $statusLabels = [
                                    'pending' => 'قيد الانتظار',
                                    'processing' => 'قيد المعالجة',
                                    'shipped' => 'تم الشحن',
                                    'delivered' => 'تم التوصيل',
                                    'cancelled' => 'ملغي',
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusClasses[$order->status] ?? 'secondary' }} px-3 py-2">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="order__body mt-3">
                    @if(isset($order->items) && $order->items->isNotEmpty())
                    <div class="order__products">
                        @foreach($order->items as $item)
                        <div class="order__product-item">
                            <div class="d-flex align-items-center">
                                <div class="order__product-thumb me-3">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product_name }}">
                                    @else
                                        <img src="{{ asset('themes/torganic/assets/images/product/order/1.png') }}" alt="{{ $item->product_name }}">
                                    @endif
                                </div>
                                <div class="order__product-info flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                    <p class="text-muted mb-0 small">الكمية: {{ $item->quantity }} × {{ number_format($item->price, 2) }} ر.س</p>
                                </div>
                                <div class="order__product-price">
                                    <strong>{{ number_format($item->price * $item->quantity, 2) }} ر.س</strong>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                
                <div class="order__footer mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('orders.show', $order->id) }}" class="trk-btn trk-btn--outline trk-btn--sm">
                                <i class="fa-solid fa-eye me-2"></i> عرض التفاصيل
                            </a>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            @if($order->status == 'delivered')
                            <a href="{{ route('orders.invoice', $order->id) }}" class="trk-btn trk-btn--outline trk-btn--sm" target="_blank">
                                <i class="fa-solid fa-file-invoice me-2"></i> الفاتورة
                            </a>
                            @endif
                            
                            @if(in_array($order->status, ['pending', 'processing']))
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="trk-btn trk-btn--outline trk-btn--sm text-danger border-danger" onclick="return confirm('هل أنت متأكد من إلغاء هذا الطلب؟')">
                                    <i class="fa-solid fa-times me-2"></i> إلغاء الطلب
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper mt-4">
            {{ $orders->links() }}
        </div>
        @else
        <!-- No Orders -->
        <div class="orders__empty text-center p-5">
            <i class="fa-solid fa-box-open fa-5x text-muted mb-4"></i>
            <h3>لا توجد طلبات بعد</h3>
            <p class="text-muted mb-4">لم تقم بأي طلبات حتى الآن. ابدأ التسوق الآن!</p>
            <a href="{{ route('products.index') }}" class="trk-btn trk-btn--primary">
                تصفح المنتجات
            </a>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.order__item {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
}

.order__header {
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.order__header h5 {
    color: #333;
    font-weight: 600;
}

.order__meta {
    color: #666;
    font-size: 14px;
}

.order__product-item {
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.order__product-item:last-child {
    border-bottom: none;
}

.order__product-thumb {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border-radius: 6px;
}

.order__product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.order__product-info h6 {
    color: #333;
    font-size: 15px;
}

.order__footer {
    padding-top: 15px;
    border-top: 1px solid #f0f0f0;
}

.orders__empty {
    background: #f8f9fa;
    border-radius: 8px;
}

.badge {
    font-size: 13px;
    font-weight: 500;
}
</style>
@endpush

