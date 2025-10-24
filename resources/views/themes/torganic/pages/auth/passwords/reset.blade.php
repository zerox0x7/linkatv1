@extends('themes.torganic.layouts.app')

@section('title', 'إعادة تعيين كلمة المرور - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">إعادة تعيين كلمة المرور</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">إعادة تعيين كلمة المرور</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Section -->
<section class="reset-password padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="reset-password__wrapper">
                    <div class="reset-password__header text-center mb-4">
                        <i class="fa-solid fa-lock-open fa-3x text-primary mb-3"></i>
                        <h2>إنشاء كلمة مرور جديدة</h2>
                        <p class="text-muted">أدخل كلمة المرور الجديدة لحسابك</p>
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

                    <form action="{{ route('password.update') }}" method="POST" class="reset-password__form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $email ?? old('email') }}" placeholder="أدخل بريدك الإلكتروني" required readonly>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور الجديدة <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="8 أحرف على الأقل" required>
                            <small class="text-muted">يجب أن تحتوي على 8 أحرف على الأقل</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="أعد إدخال كلمة المرور" required>
                        </div>

                        <button type="submit" class="trk-btn trk-btn--primary w-100 mb-3">
                            <i class="fa-solid fa-check me-2"></i> إعادة تعيين كلمة المرور
                        </button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fa-solid fa-arrow-right me-2"></i> العودة إلى تسجيل الدخول
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.reset-password__wrapper {
    background: #fff;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.reset-password__header h2 {
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

@media (max-width: 768px) {
    .reset-password__wrapper {
        padding: 30px 20px;
    }
}
</style>
@endpush

