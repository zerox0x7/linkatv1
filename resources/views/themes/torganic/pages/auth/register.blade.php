@extends('themes.torganic.layouts.app')

@section('title', 'إنشاء حساب - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">إنشاء حساب جديد</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">التسجيل</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Register Section -->
<section class="register padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">
                <div class="register__wrapper">
                    <div class="register__header text-center mb-4">
                        <h2>انضم إلينا اليوم</h2>
                        <p class="text-muted">أنشئ حسابك للاستمتاع بتجربة تسوق مميزة</p>
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

                    <form action="{{ route('register') }}" method="POST" class="register__form">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">الاسم الأول <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="أدخل اسمك الأول" required>
                            </div>

                            <div class="col-md-6">
                                <label for="last_name" class="form-label">الاسم الأخير <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="أدخل اسمك الأخير" required>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="example@domain.com" required>
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="05xxxxxxxx" required>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="8 أحرف على الأقل" required>
                                <small class="text-muted">يجب أن تحتوي على 8 أحرف على الأقل</small>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="أعد إدخال كلمة المرور" required>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="terms" id="terms" class="form-check-input" required>
                                    <label for="terms" class="form-check-label">
                                        أوافق على <a href="#" target="_blank">الشروط والأحكام</a> و <a href="#" target="_blank">سياسة الخصوصية</a>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="trk-btn trk-btn--primary w-100">
                                    <i class="fa-solid fa-user-plus me-2"></i> إنشاء حساب
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="register__divider text-center my-4">
                        <span class="text-muted">أو</span>
                    </div>

                    <div class="register__login text-center">
                        <p class="mb-0">لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="fw-bold">تسجيل الدخول</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.register__wrapper {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.register__header h2 {
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

.register__divider {
    position: relative;
}

.register__divider::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 45%;
    height: 1px;
    background: #ddd;
}

.register__divider::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    width: 45%;
    height: 1px;
    background: #ddd;
}

.register__divider span {
    background: #fff;
    padding: 0 15px;
    position: relative;
    z-index: 1;
}
</style>
@endpush

