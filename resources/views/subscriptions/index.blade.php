<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطط الاشتراك المميزة - {{ \App\Models\Setting::get('store_name') }}</title>
    <meta name="description" content="اختر خطة الاشتراك المناسبة لك - خطط شهرية وسنوية بمميزات متنوعة وأسعار تنافسية">
    
    <!-- Bootstrap 5 RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Floating Icons Background -->
        <div class="floating-icons">
            <i class="floating-icon fas fa-store"></i>
            <i class="floating-icon fas fa-shopping-cart"></i>
            <i class="floating-icon fas fa-users"></i>
            <i class="floating-icon fas fa-handshake"></i>
            <i class="floating-icon fas fa-chart-line"></i>
            <i class="floating-icon fas fa-credit-card"></i>
            <i class="floating-icon fas fa-shipping-fast"></i>
            <i class="floating-icon fas fa-mobile-alt"></i>
            <i class="floating-icon fas fa-globe"></i>
            <i class="floating-icon fas fa-building"></i>
        </div>
        
        <!-- Animated Particles -->
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <!-- Store Grid Background -->
        <div class="store-grid"></div>
        
        <!-- Network Lines Background -->
        <div class="network-lines"></div>
        
        <!-- Pulsing Rings for Multi-tenant Effect -->
        <div class="tenant-rings">
            <div class="ring"></div>
            <div class="ring"></div>
            <div class="ring"></div>
        </div>
        
        <div class="hero-overlay">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <div class="hero-icon mb-4">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h1 class="hero-title">خطط الاشتراك المميزة</h1>
                            <p class="hero-subtitle">اختر الخطة المثالية لنجاح أعمالك واستمتع بمميزات لا محدودة</p>
                            
                            <!-- Trust Indicators -->
                            <div class="trust-indicators">
                                <div class="trust-item">
                                    <i class="fas fa-users"></i>
                                    <span>+{{ number_format(rand(2000, 8000)) }} عميل</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-star"></i>
                                    <span>4.9 تقييم</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-shield-check"></i>
                                    <span>آمان 100%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="subscription-section">
        <div class="container">
            <!-- Current Subscription Status -->
            @auth
                @if($userSubscription)
                    <div class="current-subscription mb-5">
                        <div class="status-card active">
                            <div class="status-header">
                                <i class="fas fa-check-circle"></i>
                                <h3>اشتراكك النشط</h3>
                            </div>
                            <div class="status-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="subscription-details">
                                            <h4 class="plan-title">{{ $userSubscription->subscriptionPlan->name }}</h4>
                                            <p class="expiry-date">
                                                <i class="fas fa-calendar"></i>
                                                ينتهي في {{ $userSubscription->ends_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="days-remaining">
                                            <div class="days-counter">
                                                <span class="days-number">{{ $userSubscription->remaining_days }}</span>
                                                <span class="days-label">يوم متبقي</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Welcome Message for Guests -->
                <div class="welcome-section mb-5">
                    <div class="welcome-card">
                        <div class="welcome-content">
                            <div class="welcome-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h3>ابدأ رحلتك معنا</h3>
                            <p>سجل الآن واحصل على إمكانيات لا محدودة لتطوير أعمالك</p>
                            <div class="welcome-actions">
                                <a href="{{ route('subscription.register') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>
                                    إنشاء حساب مجاني
                                </a>
                                <a href="{{ route('subscription.login') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    تسجيل الدخول
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Subscription Plans -->
            <div class="plans-container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">اختر خطتك المثالية</h2>
                    <p class="section-subtitle">خطط مرنة مصممة خصيصاً لتلبية احتياجاتك</p>
                </div>

                <div class="row g-4 justify-content-center">
                    @forelse($subscriptionPlans as $plan)
                        <div class="col-lg-4 col-md-6">
                            <div class="pricing-card {{ $plan->is_featured ? 'featured' : '' }}">
                                @if($plan->is_featured)
                                    <div class="popular-badge">
                                        <i class="fas fa-star"></i>
                                        <span>الأكثر شعبية</span>
                                    </div>
                                @endif
                                
                                <div class="card-header">
                                    <div class="plan-icon">
                                        <i class="fas {{ $plan->is_featured ? 'fa-crown' : ($loop->index == 0 ? 'fa-seedling' : ($loop->index == 1 ? 'fa-rocket' : 'fa-gem')) }}"></i>
                                    </div>
                                    <h3 class="plan-name">{{ $plan->name }}</h3>
                                    <div class="plan-price">
                                        <span class="price">{{ $plan->formatted_price }}</span>
                                        <span class="period">/ {{ $plan->duration_in_months }} شهر</span>
                                    </div>
                                    @if($plan->description)
                                        <p class="plan-description">{{ $plan->description }}</p>
                                    @endif
                                </div>
                                
                                <div class="card-body">
                                    <ul class="features-list">
                                        @if($plan->features && is_array($plan->features))
                                            @foreach($plan->features as $feature)
                                                <li class="feature-item">
                                                    <i class="fas fa-check"></i>
                                                    <span>{{ $feature }}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                        
                                        <li class="feature-item">
                                            <i class="fas fa-check"></i>
                                            <span>
                                                @if($plan->max_products)
                                                    حتى {{ $plan->max_products }} منتج
                                                @else
                                                    منتجات غير محدودة
                                                @endif
                                            </span>
                                        </li>
                                        
                                        <li class="feature-item">
                                            <i class="fas fa-check"></i>
                                            <span>
                                                @if($plan->max_orders)
                                                    حتى {{ $plan->max_orders }} طلب شهرياً
                                                @else
                                                    طلبات غير محدودة
                                                @endif
                                            </span>
                                        </li>
                                        
                                        @if($plan->commission_rate > 0)
                                            <li class="feature-item commission">
                                                <i class="fas fa-info-circle"></i>
                                                <span>عمولة {{ $plan->commission_rate }}% على المبيعات</span>
                                            </li>
                                        @else
                                            <li class="feature-item">
                                                <i class="fas fa-check"></i>
                                                <span>بدون عمولات إضافية</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                
                                <div class="card-footer">
                                    @auth
                                        @if($userSubscription)
                                            <button class="btn-subscribe disabled" disabled>
                                                <i class="fas fa-check-circle"></i>
                                                اشتراك نشط
                                            </button>
                                        @else
                                            <form action="{{ route('subscriptions.subscribe', $plan) }}" method="POST" class="w-100">
                                                @csrf
                                                <button type="submit" class="btn-subscribe {{ $plan->is_featured ? 'primary' : '' }}">
                                                    <i class="fas fa-rocket"></i>
                                                    اختيار هذه الخطة
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('subscription.login') }}" class="btn-subscribe {{ $plan->is_featured ? 'primary' : '' }}">
                                            <i class="fas fa-sign-in-alt"></i>
                                            تسجيل الدخول للاشتراك
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h3>لا توجد خطط اشتراك متاحة حالياً</h3>
                                <p>يرجى المحاولة مرة أخرى لاحقاً أو التواصل مع فريق الدعم</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    <i class="fas fa-home me-2"></i>
                                    العودة للرئيسية
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="features-section">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">لماذا تختار منصتنا؟</h2>
                    <p class="section-subtitle">نقدم أفضل الخدمات وأكثرها موثوقية</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon security">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>أمان وحماية متقدمة</h4>
                            <p>نحمي بياناتك بأعلى معايير الأمان والتشفير المتقدم</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon support">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h4>دعم فني مستمر</h4>
                            <p>فريق دعم متخصص متاح 24/7 لمساعدتك في أي وقت</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon performance">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h4>أداء استثنائي</h4>
                            <p>سرعة وأداء عالي مع استقرار تام في جميع الأوقات</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            @guest
                <div class="cta-section text-center">
                    <div class="cta-content">
                        <h2>ابدأ نجاحك اليوم</h2>
                        <p>انضم إلى آلاف العملاء الراضين واختر الخطة المناسبة لك</p>
                        <div class="cta-buttons">
                            <a href="{{ route('subscription.register') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-rocket me-2"></i>
                                ابدأ الآن مجاناً
                            </a>
                            <a href="{{ route('subscription.login') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                لديك حساب؟ سجل دخولك
                            </a>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="subscription-footer">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('store_name') }}. جميع الحقوق محفوظة</p>
        </div>
    </footer>

    <style>
        :root {
            --primary-color: #10b981;
            --primary-dark: #059669;
            --secondary-color: #6366f1;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --darker-color: #111827;
            --card-bg: #374151;
            --input-bg: #4b5563;
            --light-color: #f9fafb;
            --text-primary: #ffffff;
            --text-secondary: #d1d5db;
            --text-muted: #9ca3af;
            --border-color: #4b5563;
            --gradient-primary: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-secondary: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.3);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.4);
            --border-radius: 16px;
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: var(--darker-color);
            margin: 0;
            padding: 0;
        }

        /* Hero Section */
        .hero-section {
            background: var(--dark-color);
            min-height: 60vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            opacity: 0.1;
        }

        /* Multi-tenant Background Animation */
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                /* Store Icons */
                radial-gradient(circle at 15% 30%, rgba(16, 185, 129, 0.4) 2px, transparent 3px),
                radial-gradient(circle at 85% 20%, rgba(99, 102, 241, 0.4) 2px, transparent 3px),
                radial-gradient(circle at 75% 80%, rgba(16, 185, 129, 0.3) 3px, transparent 4px),
                radial-gradient(circle at 25% 70%, rgba(99, 102, 241, 0.3) 2px, transparent 3px),
                radial-gradient(circle at 45% 15%, rgba(245, 158, 11, 0.4) 2px, transparent 3px),
                radial-gradient(circle at 90% 60%, rgba(239, 68, 68, 0.3) 2px, transparent 3px),
                radial-gradient(circle at 10% 85%, rgba(16, 185, 129, 0.2) 4px, transparent 5px),
                radial-gradient(circle at 60% 90%, rgba(99, 102, 241, 0.2) 3px, transparent 4px);
            animation: floatingStores 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes floatingStores {
            0%, 100% { 
                transform: translateY(0px) scale(1);
                opacity: 1;
            }
            25% { 
                transform: translateY(-15px) scale(1.1);
                opacity: 0.8;
            }
            50% { 
                transform: translateY(-8px) scale(1.05);
                opacity: 0.9;
            }
            75% { 
                transform: translateY(-20px) scale(0.95);
                opacity: 0.7;
            }
        }

        /* Floating Store and Seller Icons */
        .floating-icons {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 0;
        }

        .floating-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            font-size: 2rem;
            animation-timing-function: ease-in-out;
            animation-iteration-count: infinite;
            animation-direction: alternate;
        }

        .floating-icon:nth-child(1) { top: 20%; left: 10%; animation: float1 8s; }
        .floating-icon:nth-child(2) { top: 15%; right: 15%; animation: float2 6s; }
        .floating-icon:nth-child(3) { top: 60%; left: 8%; animation: float3 10s; }
        .floating-icon:nth-child(4) { top: 70%; right: 12%; animation: float1 7s; }
        .floating-icon:nth-child(5) { top: 35%; left: 20%; animation: float2 9s; }
        .floating-icon:nth-child(6) { top: 45%; right: 25%; animation: float3 8s; }
        .floating-icon:nth-child(7) { top: 80%; left: 25%; animation: float1 6s; }
        .floating-icon:nth-child(8) { top: 25%; right: 35%; animation: float2 11s; }
        .floating-icon:nth-child(9) { top: 55%; left: 35%; animation: float3 7s; }
        .floating-icon:nth-child(10) { top: 30%; right: 8%; animation: float1 9s; }

        @keyframes float1 {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes float2 {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-25px) rotate(-3deg); }
        }

        @keyframes float3 {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-15px) rotate(2deg); }
        }

        /* Network Connection Lines */
        .network-lines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(45deg, transparent 48%, rgba(16, 185, 129, 0.1) 49%, rgba(16, 185, 129, 0.1) 51%, transparent 52%),
                linear-gradient(-45deg, transparent 48%, rgba(99, 102, 241, 0.1) 49%, rgba(99, 102, 241, 0.1) 51%, transparent 52%);
            background-size: 100px 100px, 150px 150px;
            animation: networkPulse 15s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes networkPulse {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.4; }
        }

        /* Animated Particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: particleFloat 12s linear infinite;
            opacity: 0;
        }

        .particle:nth-child(1) { left: 10%; width: 4px; height: 4px; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; width: 6px; height: 6px; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; width: 3px; height: 3px; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; width: 5px; height: 5px; animation-delay: 1s; }
        .particle:nth-child(5) { left: 50%; width: 4px; height: 4px; animation-delay: 6s; }
        .particle:nth-child(6) { left: 60%; width: 7px; height: 7px; animation-delay: 3s; }
        .particle:nth-child(7) { left: 70%; width: 3px; height: 3px; animation-delay: 8s; }
        .particle:nth-child(8) { left: 80%; width: 5px; height: 5px; animation-delay: 5s; }
        .particle:nth-child(9) { left: 90%; width: 4px; height: 4px; animation-delay: 7s; }
        .particle:nth-child(10) { left: 15%; width: 6px; height: 6px; animation-delay: 9s; }

        @keyframes particleFloat {
            0% { 
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { 
                opacity: 1;
            }
            90% { 
                opacity: 1;
            }
            100% { 
                transform: translateY(-10vh) rotate(180deg);
                opacity: 0;
            }
        }

        /* Store Connection Grid */
        .store-grid {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(16, 185, 129, 0.15) 1px, transparent 1px),
                radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.15) 1px, transparent 1px),
                radial-gradient(circle at 60% 70%, rgba(245, 158, 11, 0.15) 1px, transparent 1px),
                radial-gradient(circle at 30% 80%, rgba(239, 68, 68, 0.15) 1px, transparent 1px),
                radial-gradient(circle at 70% 40%, rgba(16, 185, 129, 0.12) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(99, 102, 241, 0.12) 1px, transparent 1px);
            background-size: 200px 200px, 250px 250px, 180px 180px, 220px 220px, 300px 300px, 160px 160px;
            animation: storeGridMove 25s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes storeGridMove {
            0%, 100% { 
                background-position: 0% 0%, 100% 0%, 50% 100%, 0% 100%, 100% 50%, 25% 25%;
            }
            25% { 
                background-position: 25% 25%, 75% 25%, 75% 75%, 25% 75%, 75% 75%, 50% 50%;
            }
            50% { 
                background-position: 50% 50%, 50% 50%, 100% 50%, 50% 50%, 50% 100%, 75% 75%;
            }
            75% { 
                background-position: 75% 75%, 25% 75%, 25% 25%, 75% 25%, 25% 25%, 100% 100%;
            }
        }

        /* Pulsing Rings for Multi-tenant Effect */
        .tenant-rings {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        .ring {
            position: absolute;
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 50%;
            animation: ringPulse 8s ease-in-out infinite;
        }

        .ring:nth-child(1) { 
            width: 200px; 
            height: 200px; 
            margin: -100px 0 0 -100px;
            animation-delay: 0s;
        }
        .ring:nth-child(2) { 
            width: 400px; 
            height: 400px; 
            margin: -200px 0 0 -200px;
            animation-delay: 2s;
            border-color: rgba(99, 102, 241, 0.2);
        }
        .ring:nth-child(3) { 
            width: 600px; 
            height: 600px; 
            margin: -300px 0 0 -300px;
            animation-delay: 4s;
            border-color: rgba(245, 158, 11, 0.2);
        }

        @keyframes ringPulse {
            0%, 100% { 
                transform: scale(0.8);
                opacity: 0;
            }
            50% { 
                transform: scale(1.2);
                opacity: 1;
            }
        }

        .hero-overlay {
            background: transparent;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        .hero-content {
            color: var(--text-primary);
            padding: 4rem 0;
            position: relative;
            z-index: 11;
            backdrop-filter: blur(1px);
            background: rgba(31, 41, 55, 0.1);
            border-radius: var(--border-radius);
            padding: 4rem 2rem;
        }

        .hero-icon {
            font-size: 4rem;
            opacity: 0.9;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3), 0 0 20px rgba(16, 185, 129, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .hero-title::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(16, 185, 129, 0.1) 100%);
            border-radius: var(--border-radius);
            z-index: -1;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem 2rem;
            border-radius: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .trust-indicators {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(55, 65, 81, 0.6);
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(75, 85, 99, 0.3);
            color: var(--text-secondary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
        }

        .trust-item:hover {
            transform: translateY(-2px);
            background: rgba(55, 65, 81, 0.8);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .trust-item i {
            color: var(--primary-color);
            text-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        /* Subscription Section */
        .subscription-section {
            padding: 4rem 0;
            background: var(--darker-color);
        }

        /* Current Subscription */
        .status-card {
            background: var(--gradient-primary);
            border-radius: var(--border-radius);
            padding: 2rem;
            color: white;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .status-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .status-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .status-header i {
            font-size: 1.5rem;
        }

        .status-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .status-body {
            position: relative;
            z-index: 2;
        }

        .plan-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .expiry-date {
            opacity: 0.9;
            margin: 0;
        }

        .days-counter {
            background: rgba(255,255,255,0.2);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .days-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 900;
            line-height: 1;
        }

        .days-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Welcome Section */
        .welcome-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .welcome-card h3 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .welcome-card p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .welcome-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
        }

        /* Pricing Cards */
        .pricing-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border: 2px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-color);
        }

        .pricing-card.featured {
            border-color: var(--primary-color);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.25);
            transform: scale(1.05);
        }

        .pricing-card.featured:hover {
            transform: scale(1.05) translateY(-5px);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gradient-secondary);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            z-index: 10;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pricing-card .card-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            background: var(--card-bg);
        }

        .pricing-card.featured .card-header {
            background: var(--gradient-primary);
            color: white;
            border-bottom: none;
        }

        .plan-icon {
            width: 70px;
            height: 70px;
            background: rgba(16, 185, 129, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .pricing-card.featured .plan-icon {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .plan-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .pricing-card.featured .plan-name {
            color: white;
        }

        .plan-price .price {
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary-color);
            display: block;
        }

        .pricing-card.featured .plan-price .price {
            color: white;
        }

        .plan-price .period {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
            display: block;
        }

        .pricing-card.featured .plan-price .period {
            color: rgba(255,255,255,0.8);
        }

        .plan-description {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin-top: 1rem;
            margin-bottom: 0;
        }

        .pricing-card.featured .plan-description {
            color: rgba(255,255,255,0.9);
        }

        .pricing-card .card-body {
            padding: 2rem;
            flex-grow: 1;
            background: var(--card-bg);
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.7rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .feature-item:last-child {
            border-bottom: none;
        }

        .feature-item i {
            color: var(--success-color);
            font-size: 0.9rem;
            width: 16px;
            text-align: center;
        }

        .feature-item.commission i {
            color: var(--warning-color);
        }

        .feature-item span {
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .pricing-card .card-footer {
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            background: var(--card-bg);
        }

        .btn-subscribe {
            width: 100%;
            padding: 1rem 2rem;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1rem;
            transition: var(--transition);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-subscribe:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            text-decoration: none;
            background: var(--border-color);
            color: var(--text-primary);
        }

        .btn-subscribe.primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--primary-color);
        }

        .btn-subscribe.primary:hover {
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-subscribe.disabled {
            background: var(--border-color);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .btn-subscribe.disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        /* Features Section */
        .features-section {
            padding: 4rem 0;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            margin: 3rem 0;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .feature-card {
            text-align: center;
            padding: 2rem 1rem;
            height: 100%;
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .feature-icon.security {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }

        .feature-icon.support {
            background: linear-gradient(135deg, #4299e1, #3182ce);
        }

        .feature-icon.performance {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
        }

        .feature-card h4 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            background: var(--gradient-primary);
            color: white;
            padding: 4rem 2rem;
            border-radius: var(--border-radius);
            margin: 3rem 0;
            border: 1px solid var(--primary-color);
        }

        .cta-content h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Footer */
        .subscription-footer {
            background: var(--darker-color);
            color: var(--text-secondary);
            padding: 2rem 0;
            margin-top: 4rem;
            border-top: 1px solid var(--border-color);
        }

        .subscription-footer p {
            margin: 0;
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .trust-indicators {
                gap: 1rem;
            }

            .trust-item {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .pricing-card.featured {
                transform: none;
            }

            .pricing-card.featured:hover {
                transform: translateY(-5px);
            }

            .welcome-actions,
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 2rem 0;
            }

            .subscription-section {
                padding: 2rem 0;
            }

            .pricing-card .card-header,
            .pricing-card .card-body,
            .pricing-card .card-footer {
                padding: 1.5rem;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add smooth scrolling and simple animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const cards = document.querySelectorAll('.pricing-card, .feature-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    }
                });
            }, { threshold: 0.1 });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                observer.observe(card);
            });

            // Add click effects to buttons
            const buttons = document.querySelectorAll('.btn-subscribe, .btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.disabled) {
                        this.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 100);
                    }
                });
            });
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
