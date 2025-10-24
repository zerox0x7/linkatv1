@extends('themes.torganic.layouts.app')

@section('title', 'حسابي - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">حسابي</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">حسابي</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Profile Section -->
<section class="profile padding-top padding-bottom">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="profile__sidebar">
                    <div class="profile__user text-center mb-4">
                        <div class="profile__avatar mb-3">
                            @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="rounded-circle">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fa-solid fa-user fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small">{{ auth()->user()->email }}</p>
                    </div>

                    <ul class="profile__menu">
                        <li class="active">
                            <a href="{{ route('profile.show') }}">
                                <i class="fa-solid fa-user me-2"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}">
                                <i class="fa-solid fa-box me-2"></i> طلباتي
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.addresses') }}">
                                <i class="fa-solid fa-location-dot me-2"></i> العناوين
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.edit') }}">
                                <i class="fa-solid fa-gear me-2"></i> الإعدادات
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger text-decoration-none w-100 text-start">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Profile Info -->
                <div class="profile__content">
                    <div class="profile__section mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">المعلومات الشخصية</h4>
                            <a href="{{ route('profile.edit') }}" class="trk-btn trk-btn--sm trk-btn--outline">
                                <i class="fa-solid fa-pen me-2"></i> تعديل
                            </a>
                        </div>
                        
                        <div class="info-box p-4 bg-light rounded">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">الاسم الأول:</label>
                                        <p class="info-value">{{ auth()->user()->first_name ?? 'غير محدد' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">الاسم الأخير:</label>
                                        <p class="info-value">{{ auth()->user()->last_name ?? 'غير محدد' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">البريد الإلكتروني:</label>
                                        <p class="info-value">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="info-label">رقم الهاتف:</label>
                                        <p class="info-value">{{ auth()->user()->phone ?? 'غير محدد' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    @if(isset($recentOrders) && $recentOrders->isNotEmpty())
                    <div class="profile__section mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">الطلبات الأخيرة</h4>
                            <a href="{{ route('orders.index') }}" class="text-decoration-none">
                                عرض الكل <i class="fa-solid fa-arrow-left ms-1"></i>
                            </a>
                        </div>
                        
                        <div class="orders-list">
                            @foreach($recentOrders as $order)
                            <div class="order-card mb-3 p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">طلب #{{ $order->id }}</h6>
                                        <p class="text-muted small mb-0">
                                            {{ $order->created_at->format('d/m/Y') }} | {{ number_format($order->total, 2) }} ر.س
                                        </p>
                                    </div>
                                    <div>
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
                                        <span class="badge bg-{{ $statusClasses[$order->status] ?? 'secondary' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Statistics -->
                    <div class="profile__section">
                        <h4 class="mb-4">الإحصائيات</h4>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="stat-card text-center p-4 bg-light rounded">
                                    <i class="fa-solid fa-box fa-2x text-primary mb-2"></i>
                                    <h3 class="mb-1">{{ $ordersCount ?? 0 }}</h3>
                                    <p class="text-muted mb-0">إجمالي الطلبات</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card text-center p-4 bg-light rounded">
                                    <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
                                    <h3 class="mb-1">{{ $pendingOrders ?? 0 }}</h3>
                                    <p class="text-muted mb-0">طلبات قيد المعالجة</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card text-center p-4 bg-light rounded">
                                    <i class="fa-solid fa-check-circle fa-2x text-success mb-2"></i>
                                    <h3 class="mb-1">{{ $completedOrders ?? 0 }}</h3>
                                    <p class="text-muted mb-0">طلبات مكتملة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.profile__sidebar {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 20px;
}

.profile__avatar {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 50%;
}

.profile__avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100px;
    height: 100px;
    background: #f0f0f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
}

.profile__menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.profile__menu li {
    margin-bottom: 10px;
}

.profile__menu li a,
.profile__menu li button {
    display: block;
    padding: 12px 15px;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s;
}

.profile__menu li a:hover,
.profile__menu li.active a {
    background: #7fad39;
    color: #fff;
}

.profile__content {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.info-label {
    font-weight: 600;
    color: #666;
    font-size: 14px;
    margin-bottom: 5px;
    display: block;
}

.info-value {
    color: #333;
    font-size: 16px;
    margin-bottom: 0;
}

.order-card {
    border-left: 3px solid #7fad39;
}

.stat-card {
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}
</style>
@endpush

