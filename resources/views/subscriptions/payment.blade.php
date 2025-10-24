<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دفع الاشتراك - {{ \App\Models\Setting::get('store_name') }}</title>
    <meta name="description" content="إتمام عملية دفع الاشتراك في منصتنا بطرق دفع آمنة ومتنوعة">
    
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
            <i class="floating-icon fas fa-credit-card"></i>
            <i class="floating-icon fas fa-shield-alt"></i>
            <i class="floating-icon fas fa-lock"></i>
            <i class="floating-icon fas fa-handshake"></i>
            <i class="floating-icon fas fa-check-circle"></i>
            <i class="floating-icon fas fa-wallet"></i>
            <i class="floating-icon fas fa-mobile-alt"></i>
            <i class="floating-icon fas fa-globe"></i>
            <i class="floating-icon fas fa-building"></i>
            <i class="floating-icon fas fa-star"></i>
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
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h1 class="hero-title">إتمام عملية الدفع</h1>
                            <p class="hero-subtitle">اختر طريقة الدفع المناسبة لإتمام اشتراكك بأمان وثقة</p>
                            
                            <!-- Trust Indicators -->
                            <div class="trust-indicators">
                                <div class="trust-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>دفع آمن 100%</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-lock"></i>
                                    <span>تشفير متقدم</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>ضمان الجودة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="payment-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- تفاصيل الاشتراك -->
                    <div class="subscription-details-card mb-4">
                        <div class="card-header">
                            <div class="header-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3>تفاصيل الاشتراك</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <i class="fas fa-tag"></i>
                                        <div>
                                            <span class="label">اسم الخطة:</span>
                                            <span class="value">{{ $subscription->subscriptionPlan->name }}</span>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <div>
                                            <span class="label">المدة:</span>
                                            <span class="value">{{ $subscription->subscriptionPlan->duration_in_months }} شهر</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <div>
                                            <span class="label">المبلغ:</span>
                                            <span class="value price">{{ number_format($subscription->amount_paid, 2) }} ريال</span>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <div>
                                            <span class="label">تاريخ الانتهاء:</span>
                                            <span class="value">{{ $subscription->ends_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($subscription->subscriptionPlan->features && is_array($subscription->subscriptionPlan->features))
                                <div class="features-section">
                                    <h4 class="features-title">
                                        <i class="fas fa-star"></i>
                                        مميزات الخطة
                                    </h4>
                                    <div class="features-grid">
                                        @foreach($subscription->subscriptionPlan->features as $feature)
                                            <div class="feature-item">
                                                <i class="fas fa-check"></i>
                                                <span>{{ $feature }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- طرق الدفع -->
                    <div class="payment-methods-card">
                        <div class="card-header">
                            <div class="header-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h3>اختر طريقة الدفع</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('subscriptions.payment.complete', $subscription) }}" method="POST" id="paymentForm">
                                @csrf
                                
                                @if($paymentMethods->isNotEmpty())
                                    <div class="payment-methods-grid">
                                        @foreach($paymentMethods as $method)
                                            <div class="payment-method-card" data-method="{{ $method->code }}">
                                                <div class="method-radio">
                                                    <input type="radio" name="payment_method" value="{{ $method->code }}" 
                                                           id="method_{{ $method->code }}">
                                                    <label for="method_{{ $method->code }}"></label>
                                                </div>
                                                
                                                @if($method->logo)
                                                    <div class="method-logo">
                                                        <img src="{{ asset('storage/' . $method->logo) }}" 
                                                             alt="{{ $method->name }}">
                                                    </div>
                                                @endif
                                                
                                                <div class="method-info">
                                                    <h5>{{ $method->name }}</h5>
                                                    <p>{{ $method->description }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <h4>لا توجد طرق دفع متاحة</h4>
                                        <p>لا توجد طرق دفع متاحة حالياً. يرجى المحاولة لاحقاً أو التواصل مع الدعم الفني.</p>
                                    </div>
                                @endif

                                @if($paymentMethods->isNotEmpty())
                                    <div class="payment-actions">
                                        <button type="submit" class="btn-payment" id="submitBtn" disabled>
                                            <i class="fas fa-lock"></i>
                                            <span>دفع {{ number_format($subscription->amount_paid, 2) }} ريال</span>
                                        </button>
                                        <a href="{{ route('subscriptions.index') }}" class="btn-back">
                                            <i class="fas fa-arrow-right"></i>
                                            <span>العودة لخطط الاشتراك</span>
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- معلومات الأمان -->
                    <div class="security-info">
                        <div class="security-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="security-content">
                            <h4>عملية دفع آمنة</h4>
                            <p>جميع المعاملات محمية بتقنيات التشفير المتقدمة. بياناتك المالية في أمان تام.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="payment-footer">
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

        /* Floating Icons */
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

        /* Store Grid Background */
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
                radial-gradient(circle at 30% 80%, rgba(239, 68, 68, 0.15) 1px, transparent 1px);
            background-size: 200px 200px, 250px 250px, 180px 180px, 220px 220px;
            animation: storeGridMove 25s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes storeGridMove {
            0%, 100% { 
                background-position: 0% 0%, 100% 0%, 50% 100%, 0% 100%;
            }
            25% { 
                background-position: 25% 25%, 75% 25%, 75% 75%, 25% 75%;
            }
            50% { 
                background-position: 50% 50%, 50% 50%, 100% 50%, 50% 50%;
            }
            75% { 
                background-position: 75% 75%, 25% 75%, 25% 25%, 75% 25%;
            }
        }

        /* Network Lines Background */
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

        /* Pulsing Rings */
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

        /* Payment Section */
        .payment-section {
            padding: 4rem 0;
            background: var(--darker-color);
        }

        /* Subscription Details Card */
        .subscription-details-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .subscription-details-card .card-header {
            background: var(--gradient-primary);
            color: white;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .subscription-details-card .card-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .subscription-details-card .card-body {
            padding: 2rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .detail-item .label {
            font-weight: 600;
            color: var(--text-secondary);
            margin-left: 0.5rem;
        }

        .detail-item .value {
            color: var(--text-primary);
            font-weight: 500;
        }

        .detail-item .value.price {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .features-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .features-title {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .features-title i {
            color: var(--primary-color);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: var(--border-radius);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .feature-item i {
            color: var(--success-color);
            font-size: 0.9rem;
        }

        .feature-item span {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        /* Payment Methods Card */
        .payment-methods-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .payment-methods-card .card-header {
            background: var(--gradient-secondary);
            color: white;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .payment-methods-card .card-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .payment-methods-card .card-body {
            padding: 2rem;
        }

        .payment-methods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .payment-method-card {
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .payment-method-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .payment-method-card.selected {
            border-color: var(--primary-color);
            background: rgba(16, 185, 129, 0.1);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
        }

        .method-radio {
            position: relative;
        }

        .method-radio input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .method-radio label {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            display: block;
            cursor: pointer;
            transition: var(--transition);
        }

        .method-radio input[type="radio"]:checked + label {
            border-color: var(--primary-color);
            background: var(--primary-color);
        }

        .method-radio input[type="radio"]:checked + label::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
        }

        .method-logo {
            flex-shrink: 0;
        }

        .method-logo img {
            max-height: 40px;
            max-width: 80px;
            filter: grayscale(100%);
            transition: filter 0.3s ease;
        }

        .payment-method-card.selected .method-logo img,
        .payment-method-card:hover .method-logo img {
            filter: grayscale(0%);
        }

        .method-info {
            flex-grow: 1;
        }

        .method-info h5 {
            color: var(--text-primary);
            font-weight: 600;
            margin: 0 0 0.5rem 0;
        }

        .method-info p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        .payment-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-payment {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        .btn-payment:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-payment:disabled {
            background: var(--border-color);
            color: var(--text-muted);
            cursor: not-allowed;
            transform: none;
        }

        .btn-back {
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1rem 2rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back:hover {
            background: var(--border-color);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Security Info */
        .security-info {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .security-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .security-content h4 {
            color: var(--text-primary);
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .security-content p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.95rem;
        }

        /* Footer */
        .payment-footer {
            background: var(--darker-color);
            color: var(--text-secondary);
            padding: 2rem 0;
            margin-top: 4rem;
            border-top: 1px solid var(--border-color);
        }

        .payment-footer p {
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

            .payment-methods-grid {
                grid-template-columns: 1fr;
            }

            .payment-actions {
                flex-direction: column;
            }

            .btn-payment,
            .btn-back {
                width: 100%;
                justify-content: center;
            }

            .security-info {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 2rem 0;
            }

            .payment-section {
                padding: 2rem 0;
            }

            .subscription-details-card .card-body,
            .payment-methods-card .card-body {
                padding: 1.5rem;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentCards = document.querySelectorAll('.payment-method-card');
            const radioButtons = document.querySelectorAll('input[name="payment_method"]');
            const submitBtn = document.getElementById('submitBtn');
            
            // Handle card clicks
            paymentCards.forEach(card => {
                card.addEventListener('click', function() {
                    const method = this.dataset.method;
                    const radio = document.getElementById('method_' + method);
                    
                    // Clear all selections
                    paymentCards.forEach(c => c.classList.remove('selected'));
                    radioButtons.forEach(r => r.checked = false);
                    
                    // Select current
                    this.classList.add('selected');
                    radio.checked = true;
                    
                    // Enable submit button
                    submitBtn.disabled = false;
                });
            });
            
            // Handle radio button changes
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        // Clear all selections
                        paymentCards.forEach(c => c.classList.remove('selected'));
                        
                        // Select current card
                        const card = document.querySelector(`[data-method="${this.value}"]`);
                        if (card) {
                            card.classList.add('selected');
                        }
                        
                        // Enable submit button
                        submitBtn.disabled = false;
                    }
                });
            });
            
            // Form submission
            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
                
                if (!selectedMethod) {
                    e.preventDefault();
                    alert('يرجى اختيار طريقة دفع');
                    return false;
                }
                
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>جاري المعالجة...</span>';
                submitBtn.disabled = true;
            });

            // Add smooth animations
            const cards = document.querySelectorAll('.subscription-details-card, .payment-methods-card, .security-info');
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
