{{-- Dynamic Top Header --}}
@php
    use App\Models\TopHeaderSettings;
    
    // Get current store ID with multiple fallbacks
    $currentStoreId = session('current_store_id') ?? 
                     (auth()->user()->store_id ?? null) ?? 
                     (request()->attributes->get('store')->id ?? null);
    
    // Get settings from top_header_settings table
    $settings = TopHeaderSettings::getSettings($currentStoreId);
    
    // Map database columns to variables with defaults
    $enabled = $settings->top_header_enabled ?? true;
    $movementType = $settings->movement_type ?? 'scroll';
    $movementDirection = $settings->movement_direction ?? 'rtl';
    $animationSpeed = $settings->animation_speed ?? 20;
    $headerText = $settings->header_text ?? '🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن واحصل على شحن مجاني! 🎮';
    $headerLink = $settings->header_link ?? '';
    $height = $settings->top_header_height ?? 45;
    $fontSize = $settings->font_size ?? '14px';
    $fontWeight = $settings->font_weight ?? '500';
    $backgroundColor = $settings->background_color ?? '#3b82f6';
    $textColor = $settings->text_color ?? '#ffffff';
    $backgroundGradient = $settings->background_gradient ?? 'none';
    $enableShadow = $settings->enable_shadow ?? true;
    $enableOpacity = $settings->enable_opacity ?? false;
    $contactEnabled = $settings->contact_enabled ?? false;
    $phone = $settings->phone ?? '';
    $email = $settings->email ?? '';
    $showSocialIcons = $settings->show_social_icons ?? false;
    $showCloseButton = $settings->show_close_button ?? true;
    $showCountdown = $settings->show_countdown ?? false;
    $authLinksEnabled = $settings->auth_links_enabled ?? false;
    $textOnly = $settings->text_only ?? true;
    $countdownDate = $settings->countdown_date ?? '';
    $pauseOnHover = $settings->pause_on_hover ?? true;
    $infiniteLoop = $settings->infinite_loop ?? true;
    
    // Additional settings from the new table structure
    $announcementEnabled = $settings->announcement_enabled ?? false;
    $announcementText = $settings->announcement_text ?? '';
    $announcementLink = $settings->announcement_link ?? '';
    $announcementBgColor = $settings->announcement_bg_color ?? '#6366f1';
    $announcementTextColor = $settings->announcement_text_color ?? '#ffffff';
    $announcementScrolling = $settings->announcement_scrolling ?? false;
    $showLoginLink = $settings->show_login_link ?? true;
    $showRegisterLink = $settings->show_register_link ?? true;
    $loginText = $settings->login_text ?? 'تسجيل الدخول';
    $registerText = $settings->register_text ?? 'إنشاء حساب';
    $workingHoursEnabled = $settings->working_hours_enabled ?? false;
    $workingHours = $settings->working_hours ?? '';
    $contactPhone = $settings->contact_phone ?? '';
    $contactEmail = $settings->contact_email ?? '';
    $showContactInfo = $settings->show_contact_info ?? false;
    $quickLinksEnabled = $settings->quick_links_enabled ?? false;
    $quickLinks = json_decode($settings->quick_links ?? '[]', true);
    $socialMediaEnabled = $settings->social_media_enabled ?? false;
    $socialMedia = json_decode($settings->social_media ?? '[]', true);
    $languageSwitcherEnabled = $settings->language_switcher_enabled ?? false;
    $currencySwitcherEnabled = $settings->currency_switcher_enabled ?? false;

    // Determine background style - Fixed Logic
    $backgroundStyle = '';
    if (!empty($backgroundGradient) && $backgroundGradient !== 'none' && $backgroundGradient !== null) {
        $backgroundStyle = "background: {$backgroundGradient};";
    } else {
        $backgroundStyle = "background-color: {$backgroundColor};";
    }
    
    // Add opacity if enabled
    if ($enableOpacity) {
        $backgroundStyle .= " opacity: 0.95;";
    }
    
    // Add shadow if enabled
    $shadowStyle = $enableShadow ? "box-shadow: 0 2px 10px rgba(0,0,0,0.1);" : "";
    
    // Animation class based on movement type and direction
    $animationClass = '';
    if ($movementType === 'scroll') {
        $animationClass = "animate-scroll-{$movementDirection}";
    } elseif ($movementType === 'fade') {
        $animationClass = 'animate-fade';
    } elseif ($movementType === 'slide') {
        $animationClass = "animate-slide-{$movementDirection}";
    }
    
    // Pause on hover class
    $hoverClass = $pauseOnHover ? 'pause-on-hover' : '';
@endphp

@if($enabled)
{{-- Announcement Bar (if enabled and different from main header) --}}
@if($announcementEnabled && $announcementText && !$textOnly)
<div class="announcement-bar" 
     style="background: {{ $announcementBgColor }}; color: {{ $announcementTextColor }}; height: 35px; position: relative; overflow: hidden; z-index: 1001;">
    <div class="flex items-center justify-center h-full">
        @if($announcementScrolling)
            <div class="scrolling-content animate-scroll-rtl whitespace-nowrap">
                @if($announcementLink)
                    <a href="{{ $announcementLink }}" class="text-current hover:opacity-80 transition-opacity">
                        {{ $announcementText }}
                    </a>
                @else
                    {{ $announcementText }}
                @endif
            </div>
        @else
            <div class="text-center">
                @if($announcementLink)
                    <a href="{{ $announcementLink }}" class="text-current hover:opacity-80 transition-opacity">
                        {{ $announcementText }}
                    </a>
                @else
                    {{ $announcementText }}
                @endif
            </div>
        @endif
    </div>
</div>
@endif

<div id="top-header" class="top-header-wrapper {{ $hoverClass }}" 
     style="{{ $backgroundStyle }} {{ $shadowStyle }} height: {{ $height }}px; color: {{ $textColor }}; font-size: {{ $fontSize }}; font-weight: {{ $fontWeight }}; position: relative; overflow: hidden; z-index: 1000;">
    
    {{-- Close Button --}}
    @if($showCloseButton)
    <button id="close-top-header" class="absolute top-1/2 right-2 transform -translate-y-1/2 text-current hover:opacity-70 transition-opacity z-10" 
            onclick="document.getElementById('top-header').style.display='none'">
        <i class="ri-close-line text-lg"></i>
    </button>
    @endif

    {{-- Main Content Container --}}
    <div class="flex items-center justify-between h-full  relative">
        
        {{-- Left Side Content --}}
        <div class="flex items-center space-x-4 flex-shrink-0 ml-4">
            {{-- Contact Information --}}
            @if($showContactInfo && !$textOnly)
            <div class="flex items-center space-x-4 text-sm">
                @if($contactPhone)
                <div class="flex items-center space-x-1 mr-8">
                    <i class="ri-phone-line"></i>
                    <span>{{ $contactPhone }}</span>
                </div>
                @endif
                @if($contactEmail)
                <div class="flex items-center space-x-1">
                    <i class="ri-mail-line"></i>
                    <span>{{ $contactEmail }}</span>
                </div>
                @endif
            </div>
            @elseif($contactEnabled && !$textOnly)
            <div class="flex items-center space-x-4 text-sm">
                @if($phone)
                <div class="flex items-center space-x-1 mr-8">
                    <i class="ri-phone-line"></i>
                    <span>{{ $phone }}</span>
                </div>
                @endif
                @if($email)
                <div class="flex items-center space-x-1">
                    <i class="ri-mail-line"></i>
                    <span>{{ $email }}</span>
                </div>
                @endif
            </div>
            @endif

            {{-- Working Hours --}}
            @if($workingHoursEnabled && $workingHours && !$textOnly)
            <div class="flex items-center space-x-1 text-sm">
                <i class="ri-time-line"></i>
                <span>{{ $workingHours }}</span>
            </div>
            @endif

            {{-- Quick Links --}}
            @if($quickLinksEnabled && !empty($quickLinks) && !$textOnly)
            <div class="flex items-center space-x-2 text-sm">
                @foreach($quickLinks as $link)
                    @if(!empty($link['name']) && !empty($link['url']))
                    <a href="{{ $link['url'] }}" class="text-current hover:opacity-70 transition-opacity">
                        {{ $link['name'] }}
                    </a>
                    @endif
                @endforeach
            </div>
            @endif
        </div>

        {{-- Center Content --}}
        <div class="flex-1 flex items-center justify-center h-full">
            @if($movementType === 'scroll')
                {{-- Scrolling Text --}}
                <div class="scrolling-content {{ $animationClass }} whitespace-nowrap">
                    @if($headerLink)
                        <a href="{{ $headerLink }}" class="text-current hover:opacity-80 transition-opacity">
                            {{ $headerText }}
                        </a>
                    @else
                        {{ $headerText }}
                    @endif
                    
                    {{-- Countdown Timer --}}
                    @if($showCountdown && $countdownDate && !$textOnly)
                    <span class="mx-4">|</span>
                    <span id="countdown-timer" class="font-semibold"></span>
                    @endif
                </div>
            @else
                {{-- Static/Fixed Content --}}
                <div class="text-center {{ $animationClass }}">
                    @if($headerLink)
                        <a href="{{ $headerLink }}" class="text-current hover:opacity-80 transition-opacity">
                            {{ $headerText }}
                        </a>
                    @else
                        {{ $headerText }}
                    @endif
                    
                    {{-- Countdown Timer --}}
                    @if($showCountdown && $countdownDate && !$textOnly)
                    <span class="mx-2">|</span>
                    <span id="countdown-timer" class="font-semibold"></span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Right Side Content --}}
        <div class="flex items-center space-x-4 flex-shrink-0">
            {{-- Language Switcher --}}
            @if($languageSwitcherEnabled && !$textOnly)
            <div class="flex items-center space-x-2 text-sm">
                <i class="ri-global-line"></i>
                <select class="bg-transparent text-current text-sm outline-none">
                    <option value="ar">العربية</option>
                    <option value="en">English</option>
                </select>
            </div>
            @endif

            {{-- Currency Switcher --}}
            @if($currencySwitcherEnabled && !$textOnly)
            <div class="flex items-center space-x-2 text-sm">
                <i class="ri-money-dollar-circle-line"></i>
                <select class="bg-transparent text-current text-sm outline-none">
                    <option value="SAR">ريال</option>
                    <option value="USD">$</option>
                </select>
            </div>
            @endif

            {{-- Social Icons --}}
            @if($socialMediaEnabled && !empty($socialMedia) && !$textOnly)
            <div class="flex items-center space-x-2">
                @foreach($socialMedia as $social)
                    @if(!empty($social['url']))
                    <a href="{{ $social['url'] }}" class="text-current hover:opacity-70 transition-opacity" target="_blank">
                        @if($social['platform'] === 'facebook')
                            <i class="ri-facebook-fill"></i>
                        @elseif($social['platform'] === 'twitter')
                            <i class="ri-twitter-fill"></i>
                        @elseif($social['platform'] === 'instagram')
                            <i class="ri-instagram-line"></i>
                        @elseif($social['platform'] === 'youtube')
                            <i class="ri-youtube-line"></i>
                        @elseif($social['platform'] === 'linkedin')
                            <i class="ri-linkedin-fill"></i>
                        @elseif($social['platform'] === 'tiktok')
                            <i class="ri-tiktok-line"></i>
                        @else
                            <i class="ri-links-line"></i>
                        @endif
                    </a>
                    @endif
                @endforeach
            </div>
            @elseif($showSocialIcons && !$textOnly)
            {{-- Fallback to default social icons --}}
            <div class="flex items-center space-x-2">
                <a href="#" class="text-current hover:opacity-70 transition-opacity">
                    <i class="ri-facebook-fill"></i>
                </a>
                <a href="#" class="text-current hover:opacity-70 transition-opacity">
                    <i class="ri-twitter-fill"></i>
                </a>
                <a href="#" class="text-current hover:opacity-70 transition-opacity">
                    <i class="ri-instagram-line"></i>
                </a>
                <a href="#" class="text-current hover:opacity-70 transition-opacity">
                    <i class="ri-youtube-line"></i>
                </a>
            </div>
            @endif

            {{-- Auth Links --}}
            @if($authLinksEnabled && !$textOnly)
            <div class="flex items-center space-x-2 text-sm">
                @guest
                @if($showLoginLink)
                <a href="{{ route('login') }}" class="text-current hover:opacity-70 transition-opacity">
                    <i class="ri-login-box-line ml-1"></i>
                    {{ $loginText }}
                </a>
                @endif
                @if($showLoginLink && $showRegisterLink)
                <span>|</span>
                @endif
                @if($showRegisterLink)
                <a href="{{ route('register') }}" class="text-current hover:opacity-70 transition-opacity">
                    <i class="ri-user-add-line ml-1"></i>
                    {{ $registerText }}
                </a>
                @endif
                @else
                {{-- Only show greeting for scrolling headers --}}
                @if($movementType === 'scroll')
                <span>مرحباً، {{ Auth::user()->name }}</span>
                @endif
                @endguest
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Styles and Animations --}}
<style>
    .top-header-wrapper {
        position: sticky;
        top: 0;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    /* Scrolling Animations */
    @keyframes scroll-rtl {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

    @keyframes scroll-ltr {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes scroll-up {
        0% { transform: translateY(100%); }
        100% { transform: translateY(-100%); }
    }

    @keyframes scroll-down {
        0% { transform: translateY(-100%); }
        100% { transform: translateY(100%); }
    }

    .animate-scroll-rtl {
        animation: scroll-rtl {{ $animationSpeed }}s linear {{ $infiniteLoop ? 'infinite' : '1' }};
    }

    .animate-scroll-ltr {
        animation: scroll-ltr {{ $animationSpeed }}s linear {{ $infiniteLoop ? 'infinite' : '1' }};
    }

    .animate-scroll-up {
        animation: scroll-up {{ $animationSpeed }}s linear {{ $infiniteLoop ? 'infinite' : '1' }};
    }

    .animate-scroll-down {
        animation: scroll-down {{ $animationSpeed }}s linear {{ $infiniteLoop ? 'infinite' : '1' }};
    }

    /* Fade Animation */
    @keyframes fade {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .animate-fade {
        animation: fade {{ $animationSpeed }}s ease-in-out {{ $infiniteLoop ? 'infinite' : '1' }};
    }

    /* Slide Animations */
    @keyframes slide-rtl {
        0% { transform: translateX(50px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }

    @keyframes slide-ltr {
        0% { transform: translateX(-50px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }

    .animate-slide-rtl {
        animation: slide-rtl 1s ease-out;
    }

    .animate-slide-ltr {
        animation: slide-ltr 1s ease-out;
    }

    /* Pause on Hover */
    .pause-on-hover:hover .scrolling-content {
        animation-play-state: paused;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .top-header-wrapper {
            font-size: 12px !important;
            height: 35px !important;
        }
        
        .top-header-wrapper .flex {
            flex-wrap: nowrap;
            overflow: hidden;
        }
        
        .top-header-wrapper .space-x-4 {
            gap: 8px;
        }
        
        .animate-scroll-rtl,
        .animate-scroll-ltr {
            animation-duration: 15s;
        }
    }

    @media (max-width: 480px) {
        .top-header-wrapper {
            font-size: 11px !important;
            height: 30px !important;
        }
        
        .top-header-wrapper .space-x-2 {
            gap: 4px;
        }
    }
</style>

{{-- JavaScript for Countdown and Interactions --}}
@if($showCountdown && $countdownDate)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownDate = new Date("{{ $countdownDate }}").getTime();
        const countdownElement = document.getElementById('countdown-timer');
        
        if (countdownElement && countdownDate) {
            const timer = setInterval(function() {
                const now = new Date().getTime();
                const distance = countdownDate - now;
                
                if (distance < 0) {
                    clearInterval(timer);
                    countdownElement.innerHTML = "انتهى العرض";
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                countdownElement.innerHTML = `${days}د ${hours}س ${minutes}د ${seconds}ث`;
            }, 1000);
        }
    });
</script>
@endif

{{-- Additional JavaScript for Enhanced Features --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide feature (optional)
        const topHeader = document.getElementById('top-header');
        if (topHeader) {
            // Add smooth transitions
            topHeader.style.transition = 'all 0.3s ease';
            
            // Optional: Auto-hide after certain time
            // setTimeout(() => {
            //     topHeader.style.opacity = '0.8';
            // }, 30000); // 30 seconds
        }
        
        // Smooth scroll to top when header is clicked (if no link)
        @if(!$headerLink)
        const headerContent = topHeader?.querySelector('.scrolling-content, .text-center');
        if (headerContent) {
            headerContent.style.cursor = 'pointer';
            headerContent.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
        @endif
    });
</script>
@endif
