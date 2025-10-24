@extends('themes.torganic.layouts.app')

@section('title', 'تتبع الطلب - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">تتبع طلبك</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تتبع الطلب</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Order Tracking Section -->
<section class="order-tracking padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Tracking Form -->
                @if(!isset($order))
                <div class="tracking-form">
                    <div class="tracking-form__header text-center mb-4">
                        <i class="fa-solid fa-box-open fa-3x text-primary mb-3"></i>
                        <h3>أدخل رقم الطلب لتتبعه</h3>
                        <p class="text-muted">يمكنك العثور على رقم الطلب في رسالة التأكيد المرسلة عبر البريد الإلكتروني</p>
                    </div>

                    <form action="{{ route('orders.track') }}" method="POST" class="tracking-form__body">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="order_id" class="form-label">رقم الطلب <span class="text-danger">*</span></label>
                                <input type="text" name="order_id" id="order_id" class="form-control" placeholder="#12345" value="{{ old('order_id') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="example@domain.com" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="trk-btn trk-btn--primary px-5">
                                    <i class="fa-solid fa-search me-2"></i> تتبع الطلب
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <!-- Order Status -->
                <div class="order-status">
                    <div class="order-status__header text-center mb-5">
                        <div class="order-status__icon mb-3">
                            @if($order->status == 'delivered')
                            <i class="fa-solid fa-check-circle fa-4x text-success"></i>
                            @elseif($order->status == 'cancelled')
                            <i class="fa-solid fa-times-circle fa-4x text-danger"></i>
                            @else
                            <i class="fa-solid fa-shipping-fast fa-4x text-primary"></i>
                            @endif
                        </div>
                        <h3>طلب #{{ $order->id }}</h3>
                        <p class="text-muted">تاريخ الطلب: {{ $order->created_at->format('d/m/Y h:i A') }}</p>
                    </div>

                    <!-- Order Timeline -->
                    <div class="order-timeline mb-5">
                        <div class="timeline">
                            <div class="timeline-item {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>تم استلام الطلب</h5>
                                    <p class="text-muted small">{{ $order->created_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            </div>

                            <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fa-solid fa-cog"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>جاري التجهيز</h5>
                                    @if($order->status != 'pending')
                                    <p class="text-muted small">{{ $order->updated_at->format('d/m/Y h:i A') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fa-solid fa-truck"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>تم الشحن</h5>
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                    <p class="text-muted small">{{ $order->shipped_at ? $order->shipped_at->format('d/m/Y h:i A') : $order->updated_at->format('d/m/Y h:i A') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="timeline-item {{ $order->status == 'delivered' ? 'completed' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fa-solid fa-home"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>تم التوصيل</h5>
                                    @if($order->status == 'delivered')
                                    <p class="text-muted small">{{ $order->delivered_at ? $order->delivered_at->format('d/m/Y h:i A') : $order->updated_at->format('d/m/Y h:i A') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="order-details__card">
                        <h4 class="mb-4">تفاصيل الطلب</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>المنتج</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price * $item->quantity, 2) }} ر.س</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="2" class="text-end"><strong>المجموع الكلي:</strong></td>
                                        <td><strong>{{ number_format($order->total, 2) }} ر.س</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="text-center mt-4">
                        <a href="{{ route('orders.show', $order->id) }}" class="trk-btn trk-btn--outline me-2">
                            <i class="fa-solid fa-eye me-2"></i> عرض التفاصيل الكاملة
                        </a>
                        <a href="{{ route('orders.track') }}" class="trk-btn trk-btn--outline">
                            <i class="fa-solid fa-search me-2"></i> تتبع طلب آخر
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.tracking-form,
.order-status {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    transform: translateX(50%);
    width: 2px;
    height: 100%;
    background: #e0e0e0;
}

.timeline-item {
    position: relative;
    margin-bottom: 50px;
    text-align: center;
}

.timeline-icon {
    width: 60px;
    height: 60px;
    background: #f0f0f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    position: relative;
    z-index: 2;
    border: 3px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.timeline-item.completed .timeline-icon {
    background: #7fad39;
    color: #fff;
}

.timeline-item .timeline-icon i {
    font-size: 24px;
}

.timeline-content h5 {
    margin-bottom: 5px;
    font-weight: 600;
}

.order-details__card {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .tracking-form,
    .order-status {
        padding: 25px 20px;
    }
}
</style>
@endpush

