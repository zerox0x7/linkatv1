@extends('themes.torganic.layouts.app')

@section('title', '404 - الصفحة غير موجودة')

@section('content')
<section class="error-page padding-top padding-bottom" style="min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="error-content">
                    <!-- Error Image or Icon -->
                    @if(file_exists(public_path('themes/torganic/assets/images/others/error.png')))
                    <img src="{{ asset('themes/torganic/assets/images/others/error.png') }}" alt="404" class="mb-4" style="max-width: 400px; width: 100%;">
                    @else
                    <div class="error-icon mb-4">
                        <i class="fa-solid fa-exclamation-triangle" style="font-size: 100px; color: #7fad39;"></i>
                    </div>
                    @endif

                    <!-- Error Code -->
                    <h1 class="error-code" style="font-size: 120px; font-weight: 800; color: #7fad39; line-height: 1; margin-bottom: 20px;">404</h1>
                    
                    <!-- Error Message -->
                    <h2 class="error-title mb-3" style="font-size: 36px; font-weight: 700; color: #333;">عذراً، الصفحة غير موجودة!</h2>
                    <p class="error-description text-muted mb-5" style="font-size: 18px;">
                        الصفحة التي تبحث عنها قد تكون محذوفة أو تم تغيير اسمها أو غير متاحة مؤقتاً.
                    </p>

                    <!-- Actions -->
                    <div class="error-actions">
                        <a href="{{ route('home') }}" class="trk-btn trk-btn--primary me-3 mb-2">
                            <i class="fa-solid fa-home me-2"></i> العودة للرئيسية
                        </a>
                        <a href="{{ route('products.index') }}" class="trk-btn trk-btn--outline mb-2">
                            <i class="fa-solid fa-shopping-bag me-2"></i> تصفح المنتجات
                        </a>
                    </div>

                    <!-- Search Box -->
                    <div class="error-search mt-5">
                        <p class="mb-3">أو يمكنك البحث عن ما تريد:</p>
                        <form action="{{ route('products.search') }}" method="GET" class="d-flex justify-content-center">
                            <div class="input-group" style="max-width: 500px;">
                                <input type="text" name="q" class="form-control" placeholder="ابحث عن منتج..." required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.error-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

@media (max-width: 768px) {
    .error-code {
        font-size: 80px !important;
    }
    
    .error-title {
        font-size: 24px !important;
    }
    
    .error-description {
        font-size: 16px !important;
    }
}
</style>
@endpush

