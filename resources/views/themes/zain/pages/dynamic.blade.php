@extends('theme::layouts.app')

@section('title', $title . ' - ' . config('app.name'))

@section('meta_description', $page->meta_description ?: $page->title)
@section('meta_title', $page->meta_title ?: $page->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="glass-effect rounded-lg p-6 md:p-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-6">{{ $page->title }}</h1>
        
        <div class="prose prose-invert max-w-none">
            {!! $page->content !!}
        </div>
        
        <div class="mt-8 text-center text-gray-400">
            <p>تم التحديث الأخير: {{ $page->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>
</div>
@endsection 