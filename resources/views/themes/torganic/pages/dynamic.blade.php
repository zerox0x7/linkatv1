@extends('themes.torganic.layouts.app')

@section('title', $page->meta_title ?? $page->title . ' - ' . config('app.name'))
@section('description', $page->meta_description ?? $page->title)

@if(isset($page->meta_keywords) && $page->meta_keywords)
@section('keywords', $page->meta_keywords)
@endif

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">{{ $page->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Page Content -->
<section class="page-content padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content__wrapper">
                    <!-- Page Title -->
                    <div class="page-content__header text-center mb-5">
                        <h2 class="page-content__title">{{ $page->title }}</h2>
                        <div class="page-content__divider mx-auto" style="width: 80px; height: 3px; background: linear-gradient(90deg, #7fad39, #5c8829); border-radius: 3px;"></div>
                    </div>

                    <!-- Page Content -->
                    <div class="page-content__body">
                        <div class="content-area">
                            {!! $page->content !!}
                        </div>
                    </div>

                    <!-- Page Footer Meta -->
                    <div class="page-content__footer mt-5 pt-4 border-top text-center">
                        <div class="page-meta text-muted">
                            <i class="fa-regular fa-calendar me-2"></i>
                            <span>آخر تحديث: {{ $page->updated_at->format('d/m/Y') }}</span>
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
.page-content__wrapper {
    background: #fff;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.page-content__title {
    font-size: 36px;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
}

.content-area {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
}

.content-area h1,
.content-area h2,
.content-area h3,
.content-area h4,
.content-area h5,
.content-area h6 {
    color: #333;
    margin-top: 30px;
    margin-bottom: 15px;
    font-weight: 600;
}

.content-area h1 {
    font-size: 32px;
}

.content-area h2 {
    font-size: 28px;
}

.content-area h3 {
    font-size: 24px;
}

.content-area h4 {
    font-size: 20px;
}

.content-area p {
    margin-bottom: 15px;
}

.content-area ul,
.content-area ol {
    margin-bottom: 20px;
    padding-right: 20px;
}

.content-area li {
    margin-bottom: 10px;
}

.content-area a {
    color: #7fad39;
    text-decoration: none;
}

.content-area a:hover {
    color: #5c8829;
    text-decoration: underline;
}

.content-area img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
}

.content-area blockquote {
    border-right: 4px solid #7fad39;
    padding: 15px 20px;
    background: #f8f9fa;
    margin: 20px 0;
    border-radius: 5px;
}

.content-area table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
}

.content-area table th,
.content-area table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: right;
}

.content-area table th {
    background: #f8f9fa;
    font-weight: 600;
}

.page-meta {
    font-size: 14px;
}

@media (max-width: 768px) {
    .page-content__wrapper {
        padding: 30px 20px;
    }
    
    .page-content__title {
        font-size: 28px;
    }
    
    .content-area {
        font-size: 15px;
    }
}
</style>
@endpush

