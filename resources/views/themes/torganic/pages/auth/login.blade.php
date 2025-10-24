@extends('themes.torganic.layouts.app')

@section('title', 'تسجيل الدخول - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">تسجيل الدخول</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تسجيل الدخول</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Login Section -->
<section class="login padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="login__wrapper">
                    <div class="login__header text-center mb-4">
                        <h2>مرحباً بعودتك</h2>
                        <p class="text-muted">قم بتسجيل الدخول للمتابعة</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="login__form">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="أدخل بريدك الإلكتروني" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="أدخل كلمة المرور" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">تذكرني</label>
                        </div>

                        <button type="submit" class="trk-btn trk-btn--primary w-100 mb-3">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> تسجيل الدخول
                        </button>

                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">نسيت كلمة المرور؟</a>
                        </div>
                    </form>

                    <div class="login__divider text-center my-4">
                        <span class="text-muted">أو</span>
                    </div>

                    <div class="login__register text-center">
                        <p class="mb-0">ليس لديك حساب؟ <a href="{{ route('register') }}" class="fw-bold">إنشاء حساب جديد</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.login__wrapper {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.login__header h2 {
    font-size: 28px;
    font-weight: 700;
    color: #333;
}

.form-label {
    font-weight: 500;
    color: #333;
}

.form-control {
    padding: 12px 15px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

.form-control:focus {
    border-color: #7fad39;
    box-shadow: 0 0 0 0.2rem rgba(127, 173, 57, 0.25);
}

.login__divider {
    position: relative;
}

.login__divider::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 45%;
    height: 1px;
    background: #ddd;
}

.login__divider::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    width: 45%;
    height: 1px;
    background: #ddd;
}

.login__divider span {
    background: #fff;
    padding: 0 15px;
    position: relative;
    z-index: 1;
}
</style>
@endpush

