<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إنشاء حساب جديد - {{ \App\Models\Setting::get('store_name', config('app.name')) }}</title>
    <meta name="description" content="إنشاء حساب جديد للوصول إلى خطط الاشتراك المميزة وبدء رحلتك في التجارة الإلكترونية">
    
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
            <i class="floating-icon fas fa-user-plus"></i>
            <i class="floating-icon fas fa-store"></i>
            <i class="floating-icon fas fa-building"></i>
            <i class="floating-icon fas fa-handshake"></i>
            <i class="floating-icon fas fa-rocket"></i>
            <i class="floating-icon fas fa-crown"></i>
            <i class="floating-icon fas fa-chart-line"></i>
            <i class="floating-icon fas fa-users"></i>
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
                    <div class="col-lg-6 col-md-8">
                        <!-- Register Form Card -->
                        <div class="auth-card">
                            <div class="auth-header text-center mb-4">
                                <div class="auth-icon mb-3">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <h2 class="auth-title">إنشاء حساب جديد</h2>
                                <p class="auth-subtitle">ابدأ رحلتك معنا وانضم إلى آلاف التجار الناجحين</p>
                            </div>

                            <!-- Error Messages -->
                            @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <div class="alert-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="alert-content">
                                        @foreach($errors->all() as $error)
                                            <p class="mb-1">{{ $error }}</p>
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

                            <!-- Register Form -->
                            <form method="POST" action="{{ route('subscription.register') }}" class="auth-form">
                                @csrf

                                <!-- Personal Information Section -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fas fa-user me-2"></i>
                                        المعلومات الشخصية
                                    </h4>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label required">الاسم الكامل</label>
                                                <input id="name" type="text" name="name" value="{{ old('name') }}" 
                                                       class="form-control" placeholder="أدخل اسمك الكامل" required autofocus>
                                                @error('name')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label required">البريد الإلكتروني</label>
                                                <input id="email" type="email" name="email" value="{{ $verifiedPhone ? '' : old('email') }}" 
                                                       class="form-control" placeholder="example@domain.com" required>
                                                @error('email')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone" class="form-label required">رقم الهاتف</label>
                                                <input id="phone" type="text" name="phone" 
                                                       value="{{ $verifiedPhone ? ltrim($verifiedPhone, '+') : old('phone') }}" 
                                                       {{ $verifiedPhone ? 'readonly' : '' }}
                                                       class="form-control {{ $verifiedPhone ? 'readonly' : '' }}" 
                                                       placeholder="5xxxxxxxx" required>
                                                @if($verifiedPhone)
                                                    <div class="form-help text-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        تم التحقق من رقم الهاتف
                                                    </div>
                                                @endif
                                                @error('phone')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Information Section -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fas fa-store me-2"></i>
                                        معلومات النشاط التجاري
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="store_name" class="form-label required">اسم المتجر/الشركة</label>
                                                <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" 
                                                       class="form-control" placeholder="اسم متجرك أو شركتك" required>
                                                @error('store_name')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="business_type" class="form-label required">نوع النشاط</label>
                                                <select id="business_type" name="business_type" class="form-control" required>
                                                    <option value="">اختر نوع النشاط</option>
                                                    <option value="retail" {{ old('business_type') == 'retail' ? 'selected' : '' }}>تجارة تجزئة</option>
                                                    <option value="wholesale" {{ old('business_type') == 'wholesale' ? 'selected' : '' }}>تجارة جملة</option>
                                                    <option value="services" {{ old('business_type') == 'services' ? 'selected' : '' }}>خدمات</option>
                                                    <option value="manufacturing" {{ old('business_type') == 'manufacturing' ? 'selected' : '' }}>تصنيع</option>
                                                    <option value="food_beverage" {{ old('business_type') == 'food_beverage' ? 'selected' : '' }}>أغذية ومشروبات</option>
                                                    <option value="fashion" {{ old('business_type') == 'fashion' ? 'selected' : '' }}>أزياء وموضة</option>
                                                    <option value="electronics" {{ old('business_type') == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                                                    <option value="health_beauty" {{ old('business_type') == 'health_beauty' ? 'selected' : '' }}>صحة وجمال</option>
                                                    <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>أخرى</option>
                                                </select>
                                                @error('business_type')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="expected_monthly_sales" class="form-label">المبيعات المتوقعة شهرياً</label>
                                                <select id="expected_monthly_sales" name="expected_monthly_sales" class="form-control">
                                                    <option value="">اختر المبلغ</option>
                                                    <option value="under_5000" {{ old('expected_monthly_sales') == 'under_5000' ? 'selected' : '' }}>أقل من 5,000 ريال</option>
                                                    <option value="5000_15000" {{ old('expected_monthly_sales') == '5000_15000' ? 'selected' : '' }}>5,000 - 15,000 ريال</option>
                                                    <option value="15000_50000" {{ old('expected_monthly_sales') == '15000_50000' ? 'selected' : '' }}>15,000 - 50,000 ريال</option>
                                                    <option value="50000_100000" {{ old('expected_monthly_sales') == '50000_100000' ? 'selected' : '' }}>50,000 - 100,000 ريال</option>
                                                    <option value="over_100000" {{ old('expected_monthly_sales') == 'over_100000' ? 'selected' : '' }}>أكثر من 100,000 ريال</option>
                                                </select>
                                                @error('expected_monthly_sales')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website_url" class="form-label">موقع الويب (اختياري)</label>
                                                <input id="website_url" type="url" name="website_url" value="{{ old('website_url') }}" 
                                                       class="form-control" placeholder="https://example.com">
                                                @error('website_url')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="business_license" class="form-label">رقم السجل التجاري (اختياري)</label>
                                        <input id="business_license" type="text" name="business_license" value="{{ old('business_license') }}" 
                                               class="form-control" placeholder="رقم السجل التجاري">
                                        @error('business_license')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Security Information Section -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        معلومات الأمان
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label required">كلمة المرور</label>
                                                <div class="password-field">
                                                    <input id="password" type="password" name="password" 
                                                           class="form-control" placeholder="أدخل كلمة المرور" required>
                                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="password-strength mt-2">
                                                    <div class="strength-bar">
                                                        <div class="strength-fill" id="strengthBar"></div>
                                                    </div>
                                                    <div class="strength-text" id="strengthText">قوة كلمة المرور</div>
                                                </div>
                                                @error('password')
                                                    <div class="form-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation" class="form-label required">تأكيد كلمة المرور</label>
                                                <div class="password-field">
                                                    <input id="password_confirmation" type="password" name="password_confirmation" 
                                                           class="form-control" placeholder="أعد إدخال كلمة المرور" required>
                                                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="password-match mt-2" id="passwordMatch"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="form-section">
                                    <div class="form-group">
                                        <div class="form-check large">
                                            <input type="checkbox" name="terms" id="terms" class="form-check-input" required>
                                            <label for="terms" class="form-check-label">
                                                أوافق على 
                                                <a href="{{ route('terms') }}" target="_blank" class="terms-link">الشروط والأحكام</a> 
                                                و 
                                                <a href="{{ route('privacy-policy') }}" target="_blank" class="terms-link">سياسة الخصوصية</a>
                                            </label>
                                        </div>
                                        @error('terms')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" name="marketing" id="marketing" class="form-check-input">
                                            <label for="marketing" class="form-check-label">
                                                أرغب في تلقي النشرات الإخبارية والعروض الخاصة
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn-auth primary w-100 btn-large">
                                    <i class="fas fa-rocket me-2"></i>
                                    إنشاء الحساب والبدء
                                </button>

                                <!-- Footer Links -->
                                <div class="auth-footer mt-4">
                                    <div class="text-center">
                                        <p class="footer-text">
                                            لديك حساب بالفعل؟
                                            <a href="{{ route('subscription.login') }}" class="login-link">
                                                تسجيل الدخول
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
                            </form>
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

        /* Hero Section - Same as login */
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

        /* Floating Icons - Register themed */
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

        .floating-icon:nth-child(1) { top: 10%; left: 10%; animation: float1 8s; }
        .floating-icon:nth-child(2) { top: 20%; right: 15%; animation: float2 6s; }
        .floating-icon:nth-child(3) { top: 40%; left: 8%; animation: float3 10s; }
        .floating-icon:nth-child(4) { top: 60%; right: 12%; animation: float1 7s; }
        .floating-icon:nth-child(5) { top: 80%; left: 20%; animation: float2 9s; }
        .floating-icon:nth-child(6) { top: 30%; right: 25%; animation: float3 8s; }
        .floating-icon:nth-child(7) { top: 70%; left: 25%; animation: float1 6s; }
        .floating-icon:nth-child(8) { top: 50%; right: 8%; animation: float2 11s; }

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

        /* Network Lines & Particles - Same as login */
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

        /* Auth Card - Larger for register */
        .auth-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 3rem 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            position: relative;
            backdrop-filter: blur(10px);
            overflow: hidden;
            max-width: 100%;
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

        /* Form Sections */
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(55, 65, 81, 0.3);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            font-size: 1rem;
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
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: ' *';
            color: var(--danger-color);
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

        .form-control.readonly {
            background: rgba(75, 85, 99, 0.5);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .form-control option {
            background: var(--input-bg);
            color: var(--text-primary);
        }

        /* Password Field */
        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.25rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--text-primary);
        }

        .password-field .form-control {
            padding-left: 3rem;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            background: var(--border-color);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: var(--transition);
            border-radius: 2px;
        }

        .strength-fill.weak {
            width: 25%;
            background: var(--danger-color);
        }

        .strength-fill.fair {
            width: 50%;
            background: var(--warning-color);
        }

        .strength-fill.good {
            width: 75%;
            background: #3b82f6;
        }

        .strength-fill.strong {
            width: 100%;
            background: var(--success-color);
        }

        .strength-text {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .strength-text.weak { color: var(--danger-color); }
        .strength-text.fair { color: var(--warning-color); }
        .strength-text.good { color: #3b82f6; }
        .strength-text.strong { color: var(--success-color); }

        /* Password Match */
        .password-match {
            font-size: 0.85rem;
            height: 1.2rem;
        }

        .password-match.match {
            color: var(--success-color);
        }

        .password-match.no-match {
            color: var(--danger-color);
        }

        /* Checkboxes */
        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .form-check.large {
            gap: 1rem;
            padding: 1rem;
            background: rgba(16, 185, 129, 0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            background: var(--input-bg);
            cursor: pointer;
            margin-top: 0.1rem;
            flex-shrink: 0;
        }

        .form-check-input:checked {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-secondary);
            cursor: pointer;
            margin: 0;
            line-height: 1.5;
        }

        .terms-link, .login-link, .back-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .terms-link:hover, .login-link:hover, .back-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
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

        .btn-auth.btn-large {
            padding: 1.25rem 2rem;
            font-size: 1.1rem;
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
            flex-shrink: 0;
        }

        .alert-content p {
            margin: 0 0 0.25rem 0;
            font-size: 0.95rem;
        }

        .alert-content p:last-child {
            margin-bottom: 0;
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

        /* Form Error & Help */
        .form-error {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .form-help {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .form-help.text-success {
            color: var(--success-color);
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

            .form-section {
                padding: 1rem;
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

            .form-section {
                padding: 0.75rem;
            }

            .section-title {
                font-size: 1rem;
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
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const passwordMatch = document.getElementById('passwordMatch');

            // Password Strength Checker
            if (passwordField && strengthBar && strengthText) {
                passwordField.addEventListener('input', function() {
                    const password = this.value;
                    const strength = checkPasswordStrength(password);
                    
                    strengthBar.className = 'strength-fill ' + strength.class;
                    strengthText.textContent = strength.text;
                    strengthText.className = 'strength-text ' + strength.class;
                });
            }

            // Password Match Checker
            if (confirmPasswordField && passwordMatch) {
                confirmPasswordField.addEventListener('input', checkPasswordMatch);
                passwordField.addEventListener('input', checkPasswordMatch);

                function checkPasswordMatch() {
                    const password = passwordField.value;
                    const confirmPassword = confirmPasswordField.value;
                    
                    if (confirmPassword.length > 0) {
                        if (password === confirmPassword) {
                            passwordMatch.textContent = 'كلمات المرور متطابقة ✓';
                            passwordMatch.className = 'password-match match';
                        } else {
                            passwordMatch.textContent = 'كلمات المرور غير متطابقة';
                            passwordMatch.className = 'password-match no-match';
                        }
                    } else {
                        passwordMatch.textContent = '';
                        passwordMatch.className = 'password-match';
                    }
                }
            }

            function checkPasswordStrength(password) {
                let score = 0;
                
                if (password.length >= 8) score += 1;
                if (password.match(/[a-z]/)) score += 1;
                if (password.match(/[A-Z]/)) score += 1;
                if (password.match(/\d/)) score += 1;
                if (password.match(/[^a-zA-Z\d]/)) score += 1;

                switch (score) {
                    case 0:
                    case 1:
                        return { class: 'weak', text: 'ضعيفة جداً' };
                    case 2:
                        return { class: 'weak', text: 'ضعيفة' };
                    case 3:
                        return { class: 'fair', text: 'متوسطة' };
                    case 4:
                        return { class: 'good', text: 'جيدة' };
                    case 5:
                        return { class: 'strong', text: 'قوية جداً' };
                    default:
                        return { class: '', text: 'قوة كلمة المرور' };
                }
            }

            // Form Validation Enhancement
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const password = passwordField.value;
                    const confirmPassword = confirmPasswordField.value;
                    
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('كلمات المرور غير متطابقة');
                        confirmPasswordField.focus();
                        return false;
                    }
                    
                    if (password.length < 8) {
                        e.preventDefault();
                        alert('كلمة المرور يجب أن تكون 8 أحرف على الأقل');
                        passwordField.focus();
                        return false;
                    }
                });
            }

            // Animate form sections on scroll
            const formSections = document.querySelectorAll('.form-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fadeIn');
                    }
                });
            }, { threshold: 0.1 });

            formSections.forEach(section => {
                observer.observe(section);
            });
        });

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>
