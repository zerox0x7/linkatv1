@php
// قيم افتراضية
$defaultTitle = $storeName ?? config('app.name', 'متجرك');
$defaultDescription = $storeDescription ?? 'متجر متخصص في بيع الحسابات والألعاب بأسعار منافسة';
$defaultKeywords = $storeKeywords ?? 'حسابات ألعاب, حسابات سوشيال ميديا, تسوق إلكتروني';

// دمج الكلمات المفتاحية
$keywords = isset($metaKeywords) ? $metaKeywords . ', ' . $defaultKeywords : $defaultKeywords;
@endphp

<title>{{ $metaTitle ?? $defaultTitle }}</title>
<meta name="description" content="{{ $metaDescription ?? $defaultDescription }}" />
<meta name="keywords" content="{{ $keywords }}" />
<meta name="author" content="{{ $storeName ?? config('app.name') }}" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType ?? 'website' }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $ogTitle ?? $metaTitle ?? $defaultTitle }}" />
<meta property="og:description" content="{{ $ogDescription ?? $metaDescription ?? $defaultDescription }}" />
<meta property="og:image" content="{{ $ogImage ?? asset('storage/' . \App\Models\Setting::get('store_logo', 'logos/logo.png')) }}" />

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="{{ url()->current() }}" />
<meta property="twitter:title" content="{{ $twitterTitle ?? $metaTitle ?? $defaultTitle }}" />
<meta property="twitter:description" content="{{ $twitterDescription ?? $metaDescription ?? $defaultDescription }}" />
<meta property="twitter:image" content="{{ $twitterImage ?? asset('storage/' . \App\Models\Setting::get('store_logo', 'logos/logo.png')) }}" />
