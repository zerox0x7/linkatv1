<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعداد المتجر - {{ \App\Models\Setting::get('store_name') }}</title>
    <meta name="description" content="اختر الثيم والدومين المخصص لمتجرك">
    
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
            <i class="floating-icon fas fa-palette"></i>
            <i class="floating-icon fas fa-globe"></i>
            <i class="floating-icon fas fa-magic"></i>
            <i class="floating-icon fas fa-rocket"></i>
            <i class="floating-icon fas fa-paint-brush"></i>
            <i class="floating-icon fas fa-cog"></i>
            <i class="floating-icon fas fa-star"></i>
            <i class="floating-icon fas fa-gem"></i>
            <i class="floating-icon fas fa-crown"></i>
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
                                <i class="fas fa-store"></i>
                            </div>
                            <h1 class="hero-title">إعداد متجرك</h1>
                            <p class="hero-subtitle">اختر الثيم المناسب والدومين المخصص لمتجرك الإلكتروني</p>
                            
                            <!-- Trust Indicators -->
                            <div class="trust-indicators">
                                <div class="trust-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>اشتراك نشط</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-paint-brush"></i>
                                    <span>ثيمات جاهزة</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-rocket"></i>
                                    <span>إطلاق سريع</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="setup-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="{{ route('subscriptions.setup.complete') }}" method="POST" id="setupForm">
                        @csrf
                        
                        <!-- Store ID Section -->
                        <div class="setup-card mb-4">
                            <div class="card-header">
                                <div class="header-icon">
                                    <i class="fas fa-id-badge"></i>
                                </div>
                                <div class="header-content">
                                    <h3>معرف المتجر</h3>
                                    <p>معرف فريد لمتجرك (يستخدم في الرابط والإعدادات)</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="store_id" class="form-label">
                                        <i class="fas fa-store me-2"></i>
                                        معرف المتجر
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('store_id') is-invalid @enderror" 
                                           id="store_id" 
                                           name="store_id" 
                                           value="{{ old('store_id') }}"
                                           placeholder="مثال: my-store-123"
                                           required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i>
                                        يمكنك استخدام الأحرف الإنجليزية والأرقام والشرطة فقط
                                    </div>
                                    @error('store_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Theme Selection Section -->
                        <div class="setup-card mb-4">
                            <div class="card-header">
                                <div class="header-icon">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <div class="header-content">
                                    <h3>اختر ثيم المتجر</h3>
                                    <p>اختر التصميم الذي يناسب نشاطك التجاري</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="themes-grid">
                                    @php
                                        $themes = [
                                            [
                                                'name' => 'default',
                                                'display_name' => 'الافتراضي',
                                                'description' => 'تصميم عصري ونظيف مناسب لجميع أنواع المتاجر',
                                                'icon' => 'fa-store',
                                                'color' => '#10b981'
                                            ],
                                            [
                                                'name' => 'gamey',
                                                'display_name' => 'جيمي',
                                                'description' => 'مثالي للألعاب وحسابات الألعاب مع تأثيرات نيون',
                                                'icon' => 'fa-gamepad',
                                                'color' => '#8b5cf6'
                                            ],
                                            [
                                                'name' => 'greenGame',
                                                'display_name' => 'جرين جيم',
                                                'description' => 'تصميم رياضي مع لون أخضر جذاب',
                                                'icon' => 'fa-trophy',
                                                'color' => '#22c55e'
                                            ],
                                            [
                                                'name' => 'zain',
                                                'display_name' => 'زين',
                                                'description' => 'تصميم أنيق ومحترف للمتاجر الإلكترونية',
                                                'icon' => 'fa-gem',
                                                'color' => '#3b82f6'
                                            ]
                                        ];
                                    @endphp
                                    
                                    @foreach($themes as $theme)
                                        <div class="theme-card" data-theme="{{ $theme['name'] }}">
                                            <input type="radio" 
                                                   name="active_theme" 
                                                   value="{{ $theme['name'] }}" 
                                                   id="theme_{{ $theme['name'] }}"
                                                   {{ old('active_theme') === $theme['name'] ? 'checked' : '' }}
                                                   required>
                                            <label for="theme_{{ $theme['name'] }}">
                                                <div class="theme-preview" style="background: {{ $theme['color'] }}">
                                                    <i class="fas {{ $theme['icon'] }}"></i>
                                                </div>
                                                <div class="theme-info">
                                                    <h5>{{ $theme['display_name'] }}</h5>
                                                    <p>{{ $theme['description'] }}</p>
                                                </div>
                                                <div class="theme-check">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('active_theme')
                                    <div class="text-danger mt-2">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Custom Domain Section -->
                        <div class="setup-card mb-4">
                            <div class="card-header">
                                <div class="header-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="header-content">
                                    <h3>الدومين المخصص (اختياري)</h3>
                                    <p>أضف دومينك الخاص لمتجرك</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="custom_domain" class="form-label">
                                        <i class="fas fa-link me-2"></i>
                                        الدومين المخصص
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-globe"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control @error('custom_domain') is-invalid @enderror" 
                                               id="custom_domain" 
                                               name="custom_domain" 
                                               value="{{ old('custom_domain') }}"
                                               placeholder="مثال: mystore.com">
                                        @error('custom_domain')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i>
                                        اترك هذا الحقل فارغاً إذا لم يكن لديك دومين مخصص حالياً. يمكنك إضافته لاحقاً.
                                    </div>
                                </div>

                                <!-- Domain Instructions -->
                                <div class="domain-info">
                                    <h5>
                                        <i class="fas fa-question-circle"></i>
                                        كيفية ربط الدومين:
                                    </h5>
                                    <ol>
                                        <li>انتقل إلى لوحة تحكم الدومين الخاص بك</li>
                                        <li>أضف سجل DNS جديد من نوع A أو CNAME</li>
                                        <li>وجه الدومين إلى عنوان IP الخاص بالمنصة</li>
                                        <li>انتظر حتى يتم نشر التغييرات (قد يستغرق 24-48 ساعة)</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="setup-actions">
                            <button type="submit" class="btn-complete" id="completeBtn">
                                <i class="fas fa-rocket"></i>
                                <span>إطلاق المتجر</span>
                            </button>
                            <a href="{{ route('subscriptions.index') }}" class="btn-skip">
                                <i class="fas fa-forward"></i>
                                <span>تخطي الآن (يمكن الإعداد لاحقاً)</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="setup-footer">
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

        /* Hero Section - Same as payment page */
        .hero-section {
            background: var(--dark-color);
            min-height: 50vh;
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
            padding: 3rem 0;
            position: relative;
            z-index: 11;
            backdrop-filter: blur(1px);
            background: rgba(31, 41, 55, 0.1);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
        }

        .hero-icon {
            font-size: 3.5rem;
            opacity: 0.9;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3), 0 0 20px rgba(16, 185, 129, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.1rem;
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
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(55, 65, 81, 0.6);
            padding: 0.7rem 1.3rem;
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

        /* Setup Section */
        .setup-section {
            padding: 4rem 0;
            background: var(--darker-color);
        }

        /* Setup Card */
        .setup-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .setup-card .card-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1.5rem 2rem;
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
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .header-content {
            flex-grow: 1;
        }

        .header-content h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .header-content p {
            margin: 0.3rem 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .setup-card .card-body {
            padding: 2rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.8rem;
            display: block;
        }

        .form-control {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            background: var(--input-bg);
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-text {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .input-group-text {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        .is-invalid {
            border-color: var(--danger-color);
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Themes Grid */
        .themes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .theme-card {
            position: relative;
        }

        .theme-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .theme-card label {
            display: block;
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            height: 100%;
        }

        .theme-card:hover label {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
        }

        .theme-card input:checked + label {
            border-color: var(--primary-color);
            background: rgba(16, 185, 129, 0.1);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
        }

        .theme-preview {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1rem;
        }

        .theme-info h5 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .theme-info p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.5;
        }

        .theme-check {
            position: absolute;
            top: 1rem;
            left: 1rem;
            width: 30px;
            height: 30px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            opacity: 0;
            transform: scale(0);
            transition: var(--transition);
        }

        .theme-card input:checked + label .theme-check {
            opacity: 1;
            transform: scale(1);
        }

        /* Domain Info */
        .domain-info {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .domain-info h5 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .domain-info h5 i {
            color: var(--primary-color);
        }

        .domain-info ol {
            margin: 0;
            padding-right: 1.5rem;
            color: var(--text-secondary);
        }

        .domain-info li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        /* Setup Actions */
        .setup-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            padding: 2rem 0;
        }

        .btn-complete {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 3rem;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.7rem;
            box-shadow: var(--shadow-sm);
        }

        .btn-complete:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-skip {
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

        .btn-skip:hover {
            background: var(--border-color);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Footer */
        .setup-footer {
            background: var(--darker-color);
            color: var(--text-secondary);
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 1px solid var(--border-color);
        }

        .setup-footer p {
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

            .themes-grid {
                grid-template-columns: 1fr;
            }

            .setup-actions {
                flex-direction: column;
            }

            .btn-complete,
            .btn-skip {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 2rem 1rem;
            }

            .setup-section {
                padding: 2rem 0;
            }

            .setup-card .card-body {
                padding: 1.5rem;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeCards = document.querySelectorAll('.theme-card');
            const setupForm = document.getElementById('setupForm');
            const completeBtn = document.getElementById('completeBtn');
            
            // Handle theme card clicks
            themeCards.forEach(card => {
                card.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                    
                    // Remove selection from all cards
                    themeCards.forEach(c => c.querySelector('label').classList.remove('selected'));
                    // Add selection to clicked card
                    this.querySelector('label').classList.add('selected');
                });
            });
            
            // Form submission
            setupForm.addEventListener('submit', function(e) {
                // Show loading state
                completeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>جاري الإعداد...</span>';
                completeBtn.disabled = true;
            });

            // Add smooth animations
            const cards = document.querySelectorAll('.setup-card');
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

