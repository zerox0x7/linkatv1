{{-- Dynamic Footer with Torganic Design --}}
@php
    // Get footer settings from HomePage model (like greenGame)
    $footerEnabled = $homePage->footer_enabled ?? true;
    $footerDescription = $homePage->footer_description ?? 'نحن نضمن تجربة تسوق ممتعة لكل عميل.';
    $footerQuickLinks = $homePage->footer_quick_links ?? [];
    $footerSocialMedia = $homePage->footer_social_media ?? [];
    $footerSocialEnabled = $homePage->footer_social_media_enabled ?? true;
    $footerPaymentMethods = $homePage->footer_payment_methods ?? [];
    $footerPaymentEnabled = $homePage->footer_payment_methods_enabled ?? true;
    $footerCategoriesEnabled = $homePage->footer_categories_enabled ?? false;
    $footerCopyright = $homePage->footer_copyright ?? '© ' . date('Y') . ' ' . config('app.name') . '. جميع الحقوق محفوظة.';
    $footerPhone = $homePage->footer_phone ?? null;
    $footerEmail = $homePage->footer_email ?? null;
    $footerAddress = $homePage->footer_address ?? null;
    
    // Newsletter settings
    $newsletterEnabled = $homePage->newsletter_enabled ?? true;
    $newsletterTitle = $homePage->newsletter_title ?? 'النشرة البريدية';
    $newsletterDescription = $homePage->newsletter_description ?? 'اشترك للحصول على آخر التحديثات والعروض.';
    
    // Footer styling
    $footerBgColor = $homePage->footer_background_color ?? null;
    $footerTextColor = $homePage->footer_text_color ?? null;
    
    // Decorative shapes settings
    $footerShapesEnabled = $homePage->footer_shapes_enabled ?? true;
@endphp

@if($footerEnabled)
<footer class="footer" style="background-color:rgb(18, 80, 87); {{ $footerTextColor ? 'color: ' . $footerTextColor . ';' : '' }}">
    <div class="footer__top">
        <div class="container">
            <div class="footer__top-wrapper">
                <div class="row gy-5 gx-1">
                    <!-- About Column -->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="footer__about">
                            <a href="{{ route('home') }}" class="footer__about-logo">
                                @if($headerSettings && $headerSettings->logo_image)
                                    <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                                         alt="{{ config('app.name') }}" 
                                         style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: 60px; object-fit: contain;">
                                @elseif($headerSettings && $headerSettings->logo_svg)
                                    <div style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: 60px;">
                                        {!! $headerSettings->logo_svg !!}
                                    </div>
                                @elseif(isset($homePage) && $homePage->store_logo)
                                    <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                         alt="{{ config('app.name') }}" 
                                         style="max-width: 150px; max-height: 60px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('themes/torganic/assets/images/logo/logo-dark.svg') }}" alt="{{ config('app.name') }}">
                                @endif
                            </a>
                            <p class="footer__about-moto footer__about-moto--min">
                                {{ $footerDescription }}
                            </p>
                            
                            @if($footerSocialEnabled && !empty($footerSocialMedia))
                            <div class="footer__social">
                                <ul class="social social--style2">
                                    @foreach($footerSocialMedia as $social)
                                        @if(is_array($social) && isset($social['url']) && isset($social['icon']))
                                        <li class="social__item">
                                            <a href="{{ $social['url'] }}" class="social__link" target="_blank">
                                                <i class="{{ $social['icon'] }}"></i>
                                            </a>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Support Links -->
                    <div class="col-xl-2 col-md-3 col-sm-6 col-6">
                        <div class="footer__links">
                            <div class="footer__links-tittle">
                                <h4>الدعم</h4>
                            </div>
                            <div class="footer__links-content">
                                <ul class="footer__linklist">
                                    @if($footerPhone)
                                    <li class="footer__linklist-item">
                                        <a href="tel:{{ $footerPhone }}">المساعدة</a>
                                    </li>
                                    @endif
                                    @if($footerPhone)
                                    <li class="footer__linklist-item">
                                        <a href="tel:{{ $footerPhone }}">الخط الساخن</a>
                                    </li>
                                    @endif
                                    <li class="footer__linklist-item">
                                        <a href="{{ route('page.show', 'contact') ?? '#' }}">اتصل بنا</a>
                                    </li>
                                    <li class="footer__linklist-item">
                                        <a href="{{ route('page.show', 'contact') ?? '#' }}">دردش الآن</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Account Links -->
                    <div class="col-xl-2 col-md-3 col-sm-6 col-6">
                        <div class="footer__links">
                            <div class="footer__links-tittle">
                                <h4>الحساب</h4>
                            </div>
                            <div class="footer__links-content">
                                <ul class="footer__linklist">
                                    @auth
                                    <li class="footer__linklist-item">
                                        <a href="{{ route('profile.show') }}">حسابي</a>
                                    </li>
                                    @else
                                    <li class="footer__linklist-item">
                                        <a href="{{ route('login') }}">تسجيل الدخول</a>
                                    </li>
                                    @endauth
                                    <li class="footer__linklist-item">
                                        <a href="{{ route('cart.index') }}">عرض السلة</a>
                                    </li>
                                    <li class="footer__linklist-item">
                                        <a href="{{ route('cart.index') }}">قائمة المفضلة</a>
                                    </li>
                                    <li class="footer__linklist-item">
                                        <a href="{{ route('orders.index') ?? '#' }}">تفاصيل الشحن</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-xl-2 col-md-6 col-sm-6">
                        <div class="footer__links">
                            <div class="footer__links-tittle">
                                <h4>روابط سريعة</h4>
                            </div>
                            <div class="footer__links-content">
                                <ul class="footer__linklist">
                                    @if(!empty($footerQuickLinks))
                                        @foreach($footerQuickLinks as $link)
                                        <li class="footer__linklist-item">
                                            <a href="{{ $link['url'] ?? '#' }}">{{ $link['name'] ?? $link['title'] ?? 'رابط' }}</a>
                                        </li>
                                        @endforeach
                                    @else
                                        <li class="footer__linklist-item">
                                            <a href="{{ route('page.show', 'contact') ?? '#' }}">دعم العملاء</a>
                                        </li>
                                        <li class="footer__linklist-item">
                                            <a href="{{ route('page.show', 'shipping') ?? '#' }}">تفاصيل التوصيل</a>
                                        </li>
                                        <li class="footer__linklist-item">
                                            <a href="{{ route('page.show', 'terms') ?? '#' }}">الشروط والأحكام</a>
                                        </li>
                                        <li class="footer__linklist-item">
                                            <a href="{{ route('page.show', 'privacy') ?? '#' }}">سياسة الخصوصية</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    @if($newsletterEnabled)
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="footer__links">
                            <div class="footer__links-tittle">
                                <h4>{{ $newsletterTitle }}</h4>
                            </div>
                            <div class="footer__links-content">
                                <p class="footer__about-moto">{{ $newsletterDescription }}</p>
                                <form action="#" method="POST" class="newsletter__form">
                                    @csrf
                                    <input type="email" name="email" class="newsletter__input" placeholder="عنوان البريد الإلكتروني" required>
                                    <button type="submit" class="trk-btn trk-btn--yellow">اشترك</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottom-wrapper">
                @if($footerPaymentEnabled && !empty($footerPaymentMethods))
                <div class="footer__bottom-payment">
                    <ul class="payment">
                        @foreach($footerPaymentMethods as $index => $payment)
                            @if(is_string($payment) && str_contains($payment, 'ri-'))
                                {{-- Icon class --}}
                                <li class="payment__item">
                                    <i class="{{ $payment }} text-2xl"></i>
                                </li>
                            @elseif(is_array($payment) && isset($payment['icon']))
                                <li class="payment__item">
                                    <i class="{{ $payment['icon'] }} text-2xl"></i>
                                </li>
                            @else
                                {{-- Image path --}}
                                <li class="payment__item">
                                    <img src="{{ asset('themes/torganic/assets/images/payment/' . ($index + 1) . '.png') }}" alt="payment method">
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <div class="footer__bottom-copyright">
                    <p class="mb-0">
                        {!! $footerCopyright !!}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Shapes -->
    @if($footerShapesEnabled)
    <div class="footer__shape">
        <span class="footer__shape-item footer__shape-item--1">
            <img src="{{ asset('themes/torganic/assets/images/banner/home1/leaf.png') }}" alt="shape icon">
        </span>
        <span class="footer__shape-item footer__shape-item--2">
            <img src="{{ asset('themes/torganic/assets/images/banner/home1/tomato.png') }}" alt="shape icon">
        </span>
        <span class="footer__shape-item footer__shape-item--3">
            <img src="{{ asset('themes/torganic/assets/images/banner/home1/chilli.png') }}" alt="shape icon">
        </span>
    </div>
    @endif
</footer>
@endif