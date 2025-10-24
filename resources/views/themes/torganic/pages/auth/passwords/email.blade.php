@extends('themes.torganic.layouts.app')

@section('title', 'استعادة كلمة المرور - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">استعادة كلمة المرور</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">استعادة كلمة المرور</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Section -->
<section class="forgot-password padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="forgot-password__wrapper">
                    <div class="forgot-password__header text-center mb-4">
                        <i class="fa-solid fa-key fa-3x text-primary mb-3"></i>
                        <h2>نسيت كلمة المرور؟</h2>
                        <p class="text-muted">لا تقلق! أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور</p>
                    </div>

                    @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST" class="forgot-password__form">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="أدخل بريدك الإلكتروني" required autofocus>
                        </div>

                        <button type="submit" class="trk-btn trk-btn--primary w-100 mb-3">
                            <i class="fa-solid fa-paper-plane me-2"></i> إرسال رابط الاستعادة
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
.forgot-password__wrapper {
    background: #fff;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.forgot-password__header h2 {
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
    .forgot-password__wrapper {
        padding: 30px 20px;
    }
}
</style>
@endpush

