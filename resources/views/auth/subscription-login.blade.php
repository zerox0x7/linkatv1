<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول - {{ \App\Models\Setting::get('store_name', config('app.name')) }}</title>
    <meta name="description" content="تسجيل الدخول للوصول إلى خطط الاشتراك المميزة وإدارة حسابك">
    
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
            <i class="floating-icon fas fa-user-circle"></i>
            <i class="floating-icon fas fa-lock"></i>
            <i class="floating-icon fas fa-shield-alt"></i>
            <i class="floating-icon fas fa-key"></i>
            <i class="floating-icon fas fa-mobile-alt"></i>
            <i class="floating-icon fas fa-envelope"></i>
            <i class="floating-icon fas fa-user-plus"></i>
            <i class="floating-icon fas fa-sign-in-alt"></i>
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
        </div>
        
        <!-- Network Lines Background -->
        <div class="network-lines"></div>
        
        <!-- Pulsing Rings -->
        <div class="tenant-rings">
            <div class="ring"></div>
            <div class="ring"></div>
            <div class="ring"></div>
        </div>
        
        <div class="hero-overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <!-- Login Form Card -->
                        <div class="auth-card">
                            <div class="auth-header text-center mb-4">
                                <div class="auth-icon mb-3">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <h2 class="auth-title">تسجيل الدخول</h2>
                                <p class="auth-subtitle">سجل دخولك للوصول إلى حسابك والاشتراكات المميزة</p>
                            </div>

                            <!-- Error Messages -->
                            @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <div class="alert-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="alert-content">
                                        @foreach($errors->all() as $error)
                                            <p class="mb-0">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Success Messages -->
                            @if(session('success'))
                                <div class="alert alert-success mb-4">
                                    <div class="alert-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="alert-content">
                                        <p class="mb-0">{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Phone Login Section -->
                            @php
                                $otpTemplateActive = \App\Models\WhatsAppTemplate::where('type', 'otp')->where('is_active', true)->exists();
                            @endphp

                            @if($otpTemplateActive)
                                <!-- Phone Login Form -->
                                <form method="POST" action="{{ route('login.phone.send') }}" class="auth-form" id="phoneLoginForm" data-verify-otp-url="{{ route('login.phone.verify') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="country_code" class="form-label">اختر الدولة</label>
                                        <select id="country_code" name="country_code" class="form-control">
                                            <option value="+966" data-placeholder="5XXXXXXXX" selected>السعودية (+966)</option>
                                            <option value="+971" data-placeholder="5XXXXXXXXX">الإمارات (+971)</option>
                                            <option value="+965" data-placeholder="XXXXXXXX">الكويت (+965)</option>
                                            <option value="+974" data-placeholder="XXXXXXXX">قطر (+974)</option>
                                            <option value="+973" data-placeholder="XXXXXXXX">البحرين (+973)</option>
                                            <option value="+968" data-placeholder="XXXXXXXX">عمان (+968)</option>
                                            <option value="other" data-placeholder="أدخل الرقم كاملاً مع مفتاح الدولة">دولة أخرى</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="form-label">رقم الهاتف</label>
                                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" 
                                               class="form-control" placeholder="5XXXXXXXX" required>
                                    </div>

                                    <button type="submit" class="btn-auth primary w-100">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        إرسال رمز التحقق
                                    </button>

                                    <!-- OTP Entry Section -->
                                    <div id="otpEntrySection" class="otp-section mt-4" style="display: none;">
                                        <div class="otp-info mb-3">
                                            <i class="fas fa-sms text-primary me-2"></i>
                                            <span>تم إرسال رمز التحقق إلى: <strong id="otpSentToPhone"></strong></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="otp" class="form-label">رمز التحقق (OTP)</label>
                                            <input id="otp" type="text" name="otp" class="form-control otp-input" 
                                                   placeholder="ادخل الرمز هنا" maxlength="6" autocomplete="one-time-code">
                                            <div id="otpError" class="form-error"></div>
                                        </div>

                                        <button type="button" id="verifyOtpButton" class="btn-auth primary w-100 mb-3">
                                            <i class="fas fa-check me-2"></i>
                                            تحقق من الرمز
                                        </button>

                                        <div class="text-center">
                                            <button type="button" id="resendOtpButton" class="btn-link" disabled>
                                                إعادة إرسال الرمز
                                            </button>
                                            <span id="resendOtpTimer" class="timer-text"></span>
                                        </div>
                                    </div>

                                    <div class="auth-divider my-4">
                                        <span>أو</span>
                                    </div>

                                    <button type="button" id="switchToEmailLogin" class="btn-auth secondary w-100">
                                        <i class="fas fa-envelope me-2"></i>
                                        تسجيل الدخول بالبريد الإلكتروني
                                    </button>
                                </form>
                            @endif

                            <!-- Email Login Form -->
                            <form method="POST" action="{{ route('login') }}" class="auth-form {{ $otpTemplateActive ? 'd-none' : '' }}" id="emailLoginForm">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                                           class="form-control" placeholder="أدخل بريدك الإلكتروني" required>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">كلمة المرور</label>
                                    <input id="password" type="password" name="password" 
                                           class="form-control" placeholder="أدخل كلمة المرور" required>
                                    @if (Route::has('password.request'))
                                        <div class="form-help mt-2">
                                            <a href="{{ route('password.request') }}" class="forgot-password">
                                                نسيت كلمة المرور؟
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input" 
                                               {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember" class="form-check-label">تذكرني</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn-auth primary w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    تسجيل الدخول
                                </button>

                                @if($otpTemplateActive)
                                    <div class="auth-divider my-4">
                                        <span>أو</span>
                                    </div>

                                    <button type="button" id="switchToPhoneLogin" class="btn-auth secondary w-100">
                                        <i class="fas fa-mobile-alt me-2"></i>
                                        تسجيل الدخول برقم الهاتف
                                    </button>
                                @endif
                            </form>

                            <!-- Footer Links -->
                            <div class="auth-footer mt-4">
                                <div class="text-center">
                                    <p class="footer-text">
                                        ليس لديك حساب؟
                                        <a href="{{ route('subscription.register') }}" class="register-link">
                                            إنشاء حساب جديد
                                        </a>
                                    </p>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <a href="{{ route('subscriptions.index') }}" class="back-link">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        العودة إلى صفحة الاشتراكات
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
            min-height: 100vh;
        }

        /* Hero Section - Same as subscriptions */
        .hero-section {
            background: var(--dark-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 2rem 0;
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

        /* Floating Icons - Auth themed */
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

        /* Network Lines */
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

        /* Auth Card */
        .auth-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 3rem 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            position: relative;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .auth-header .auth-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Form Styles */
        .auth-form {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 0.875rem 1rem;
            color: var(--text-primary);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            background: var(--card-bg);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .otp-input {
            text-align: center;
            font-size: 1.5rem;
            letter-spacing: 0.5rem;
            font-weight: 600;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            background: var(--input-bg);
            cursor: pointer;
        }

        .form-check-input:checked {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-secondary);
            cursor: pointer;
            margin: 0;
        }

        /* Buttons */
        .btn-auth {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-auth.primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-auth.primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-auth.secondary {
            background: var(--input-bg);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn-auth.secondary:hover {
            background: var(--border-color);
            border-color: var(--primary-color);
            color: var(--text-primary);
        }

        .btn-link {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            text-decoration: underline;
            font-size: 0.9rem;
        }

        .btn-link:hover {
            color: var(--primary-dark);
        }

        .btn-link:disabled {
            color: var(--text-muted);
            cursor: not-allowed;
            text-decoration: none;
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            border-radius: var(--border-radius);
            border: 1px solid;
            margin-bottom: 1rem;
        }

        .alert.alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--danger-color);
            color: #fecaca;
        }

        .alert.alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--success-color);
            color: #a7f3d0;
        }

        .alert-icon {
            font-size: 1.2rem;
            margin-top: 0.1rem;
        }

        .alert-content p {
            margin: 0;
            font-size: 0.95rem;
        }

        /* Divider */
        .auth-divider {
            position: relative;
            text-align: center;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .auth-divider span {
            background: var(--card-bg);
            color: var(--text-muted);
            padding: 0 1rem;
            position: relative;
            z-index: 1;
        }

        /* OTP Section */
        .otp-section {
            padding: 1.5rem;
            background: rgba(16, 185, 129, 0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .otp-info {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .timer-text {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-right: 0.5rem;
        }

        /* Footer */
        .auth-footer {
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
        }

        .footer-text {
            color: var(--text-secondary);
            margin: 0;
        }

        .register-link, .back-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .register-link:hover, .back-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        .form-error {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .form-help {
            text-align: left;
        }

        /* Loading States */
        .btn-auth:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .auth-title {
                font-size: 1.75rem;
            }

            .hero-section {
                padding: 1rem 0;
            }

            .floating-icon {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.5rem 1rem;
            }

            .form-control {
                padding: 0.75rem;
            }

            .btn-auth {
                padding: 0.875rem 1.5rem;
            }
        }

        /* Animation Classes */
        .fadeIn {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneLoginForm = document.getElementById('phoneLoginForm');
            const emailLoginForm = document.getElementById('emailLoginForm');
            const switchToEmailLogin = document.getElementById('switchToEmailLogin');
            const switchToPhoneLogin = document.getElementById('switchToPhoneLogin');
            
            const countryCodeSelect = document.getElementById('country_code');
            const phoneInput = document.getElementById('phone');
            const sendOtpButton = phoneLoginForm ? phoneLoginForm.querySelector('button[type="submit"]') : null;
            const originalSendOtpButtonText = sendOtpButton ? sendOtpButton.innerHTML : '';

            const otpEntrySection = document.getElementById('otpEntrySection');
            const otpInput = document.getElementById('otp');
            const verifyOtpButton = document.getElementById('verifyOtpButton');
            const originalVerifyOtpButtonText = verifyOtpButton ? verifyOtpButton.innerHTML : '';
            const resendOtpButton = document.getElementById('resendOtpButton');
            const otpSentToPhone = document.getElementById('otpSentToPhone');
            const otpError = document.getElementById('otpError');
            const resendOtpTimer = document.getElementById('resendOtpTimer');

            let resendInterval;
            let resendCooldown = 60;
            let currentFullPhoneNumber = '';

            // CSRF Token for AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function updatePhonePlaceholder() {
                if (!countryCodeSelect || !phoneInput) return;
                const selectedOption = countryCodeSelect.options[countryCodeSelect.selectedIndex];
                phoneInput.placeholder = selectedOption.dataset.placeholder || 'أدخل رقم هاتفك';
            }

            if (countryCodeSelect) {
                updatePhonePlaceholder();
                countryCodeSelect.addEventListener('change', updatePhonePlaceholder);
            }

            function showOtpForm(fullPhoneNumber) {
                currentFullPhoneNumber = fullPhoneNumber;
                if (countryCodeSelect) countryCodeSelect.disabled = true;
                if (phoneInput) phoneInput.disabled = true;
                if (sendOtpButton) sendOtpButton.style.display = 'none';

                if (otpSentToPhone) otpSentToPhone.textContent = fullPhoneNumber;
                if (otpEntrySection) {
                    otpEntrySection.style.display = 'block';
                    otpEntrySection.classList.add('fadeIn');
                }
                if (otpInput) {
                    otpInput.value = '';
                    otpInput.focus();
                }
                if (otpError) otpError.textContent = '';
                startResendTimer();
            }

            function hideOtpForm() {
                if (countryCodeSelect) countryCodeSelect.disabled = false;
                if (phoneInput) phoneInput.disabled = false;
                if (sendOtpButton) sendOtpButton.style.display = 'block';
                
                if (otpEntrySection) otpEntrySection.style.display = 'none';
                currentFullPhoneNumber = '';
            }

            function startResendTimer() {
                clearInterval(resendInterval);
                if (resendOtpButton) resendOtpButton.disabled = true;
                let timeLeft = resendCooldown;
                if (resendOtpTimer) resendOtpTimer.textContent = `(${timeLeft} ثانية)`;
                
                resendInterval = setInterval(() => {
                    timeLeft--;
                    if (resendOtpTimer) resendOtpTimer.textContent = `(${timeLeft} ثانية)`;
                    if (timeLeft <= 0) {
                        clearInterval(resendInterval);
                        if (resendOtpButton) {
                            resendOtpButton.disabled = false;
                            resendOtpButton.innerHTML = 'إعادة إرسال الرمز';
                        }
                        if (resendOtpTimer) resendOtpTimer.textContent = '';
                    }
                }, 1000);
            }

            // Phone Login Form Handler
            if (phoneLoginForm) {
                phoneLoginForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    if (otpError) otpError.textContent = '';
                    if (sendOtpButton) {
                        sendOtpButton.disabled = true;
                        sendOtpButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جارٍ الإرسال...';
                    }

                    const formData = new FormData(phoneLoginForm);
                    const actionUrl = phoneLoginForm.getAttribute('action');
                    const countryCode = formData.get('country_code');
                    let phoneNumber = formData.get('phone').trim();

                    // Handle "other" country code
                    if (countryCode === 'other') {
                        if (!phoneNumber.startsWith('+')) {
                            phoneNumber = '+' + phoneNumber;
                        }
                        if (!phoneNumber.match(/^\+\d{1,4}\d{6,14}$/)) {
                            if (otpError) otpError.textContent = 'الرجاء إدخال رقم الهاتف بالصيغة الصحيحة مع مفتاح الدولة (مثال: +1234567890)';
                            if (sendOtpButton) {
                                sendOtpButton.disabled = false;
                                sendOtpButton.innerHTML = originalSendOtpButtonText;
                            }
                            return;
                        }
                        formData.set('country_code', '');
                        formData.set('phone', phoneNumber);
                    } else {
                        if (phoneNumber.startsWith('+')) {
                            phoneNumber = phoneNumber.substring(1);
                        }
                        phoneNumber = phoneNumber.replace(/^0+/, '');
                        const cleanCountryCode = countryCode.replace(/^\+/, '');
                        formData.set('country_code', cleanCountryCode);
                        formData.set('phone', phoneNumber);
                    }

                    try {
                        const response = await fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            const fullPhoneNumber = countryCode === 'other' ? phoneNumber : ('+' + countryCode.replace(/^\+/, '') + phoneNumber);
                            showOtpForm(fullPhoneNumber);
                        } else {
                            if (otpError) {
                                otpError.textContent = result.message || 'فشل إرسال رمز التحقق. حاول مرة أخرى.';
                                if (result.errors) {
                                    let errorMsg = [];
                                    for (const key in result.errors) {
                                        errorMsg.push(result.errors[key].join(', '));
                                    }
                                    otpError.textContent = errorMsg.join(' ');
                                }
                            }
                            if (sendOtpButton) {
                                sendOtpButton.disabled = false;
                                sendOtpButton.innerHTML = originalSendOtpButtonText;
                            }
                        }
                    } catch (error) {
                        console.error('Send OTP error:', error);
                        if (otpError) otpError.textContent = 'حدث خطأ ما. يرجى المحاولة مرة أخرى.';
                        if (sendOtpButton) {
                            sendOtpButton.disabled = false;
                            sendOtpButton.innerHTML = originalSendOtpButtonText;
                        }
                    }
                });
            }

            // OTP Verification
            if (verifyOtpButton) {
                verifyOtpButton.addEventListener('click', async function() {
                    const otpValue = otpInput ? otpInput.value.trim() : '';
                    if (!otpValue) {
                        if (otpError) otpError.textContent = 'الرجاء إدخال رمز التحقق.';
                        if (otpInput) otpInput.focus();
                        return;
                    }
                    if (otpError) otpError.textContent = '';
                    verifyOtpButton.disabled = true;
                    verifyOtpButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جارٍ التحقق...';

                    const verifyUrl = phoneLoginForm ? phoneLoginForm.dataset.verifyOtpUrl : '';
                    
                    try {
                        const response = await fetch(verifyUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ 
                                otp: otpValue,
                                phone: currentFullPhoneNumber
                            })
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            if (result.redirect_url) {
                                window.location.href = result.redirect_url;
                            } else {
                                if (otpError) otpError.textContent = 'تم التحقق بنجاح! يتم توجيهك...'; 
                            }
                        } else {
                            if (otpError) otpError.textContent = result.message || 'رمز التحقق غير صحيح أو انتهت صلاحيته.';
                            if (otpInput) otpInput.focus();
                            verifyOtpButton.disabled = false;
                            verifyOtpButton.innerHTML = originalVerifyOtpButtonText;
                        }
                    } catch (error) {
                        console.error('Verify OTP error:', error);
                        if (otpError) otpError.textContent = 'حدث خطأ أثناء التحقق. يرجى المحاولة مرة أخرى.';
                        verifyOtpButton.disabled = false;
                        verifyOtpButton.innerHTML = originalVerifyOtpButtonText;
                    }
                });
            }

            // Resend OTP
            if (resendOtpButton) {
                resendOtpButton.addEventListener('click', async function() {
                    if (resendOtpButton.disabled) return;

                    if (otpError) otpError.textContent = '';
                    resendOtpButton.disabled = true;
                    resendOtpButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جارٍ الإرسال...';

                    try {
                        const formData = new FormData();
                        const actionUrl = phoneLoginForm ? phoneLoginForm.getAttribute('action') : '';
                        
                        if (!currentFullPhoneNumber) {
                            throw new Error('لم يتم العثور على رقم الهاتف');
                        }

                        formData.set('phone', currentFullPhoneNumber);
                        formData.set('country_code', '');

                        const response = await fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            showOtpForm(currentFullPhoneNumber);
                            startResendTimer();
                        } else {
                            if (otpError) {
                                otpError.textContent = result.message || 'فشل إرسال رمز التحقق. حاول مرة أخرى.';
                                if (result.errors) {
                                    let errorMsg = [];
                                    for (const key in result.errors) {
                                        errorMsg.push(result.errors[key].join(', '));
                                    }
                                    otpError.textContent = errorMsg.join(' ');
                                }
                            }
                            resendOtpButton.disabled = false;
                            resendOtpButton.innerHTML = 'إعادة إرسال الرمز';
                        }
                    } catch (error) {
                        console.error('Resend OTP error:', error);
                        if (otpError) otpError.textContent = error.message || 'حدث خطأ ما. يرجى المحاولة مرة أخرى.';
                        resendOtpButton.disabled = false;
                        resendOtpButton.innerHTML = 'إعادة إرسال الرمز';
                    }
                });
            }

            // Form Switching
            if (switchToEmailLogin) {
                switchToEmailLogin.addEventListener('click', function (e) {
                    e.preventDefault();
                    hideOtpForm();
                    if (phoneLoginForm) phoneLoginForm.classList.add('d-none');
                    if (emailLoginForm) {
                        emailLoginForm.classList.remove('d-none');
                        emailLoginForm.classList.add('fadeIn');
                    }
                });
            }

            if (switchToPhoneLogin) {
                switchToPhoneLogin.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (emailLoginForm) emailLoginForm.classList.add('d-none');
                    if (phoneLoginForm) {
                        phoneLoginForm.classList.remove('d-none');
                        phoneLoginForm.classList.add('fadeIn');
                    }
                    hideOtpForm();
                });
            }

            // Handle form errors redirect
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('form') === 'email' || ({{ $errors->has('email') || $errors->has('password') ? 'true' : 'false' }})) {
                if (phoneLoginForm && emailLoginForm && switchToEmailLogin) {
                     switchToEmailLogin.click(); 
                }
            }
        });
    </script>
</body>
</html>
