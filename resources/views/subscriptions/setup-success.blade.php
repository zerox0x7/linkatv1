<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم إعداد متجرك بنجاح! - {{ \App\Models\Setting::get('store_name') }}</title>
    <meta name="description" content="متجرك جاهز الآن!">
    
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
    <section class="success-section">
        <!-- Celebration Background -->
        <div class="celebration-bg">
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
        </div>

        <!-- Floating Icons Background -->
        <div class="floating-icons">
            <i class="floating-icon fas fa-store"></i>
            <i class="floating-icon fas fa-check-circle"></i>
            <i class="floating-icon fas fa-rocket"></i>
            <i class="floating-icon fas fa-star"></i>
            <i class="floating-icon fas fa-trophy"></i>
            <i class="floating-icon fas fa-gem"></i>
            <i class="floating-icon fas fa-crown"></i>
            <i class="floating-icon fas fa-heart"></i>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="success-card">
                        <!-- Success Icon -->
                        <div class="success-icon-wrapper">
                            <div class="success-icon">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <h1 class="success-title">🎉 مبروك! متجرك جاهز الآن</h1>
                        <p class="success-subtitle">تم إعداد متجرك الإلكتروني بنجاح وجاهز للعمل</p>

                        <!-- Store URL Card -->
                        <div class="store-url-card">
                            <div class="url-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="url-content">
                                <h3>رابط متجرك:</h3>
                                <a href="{{ $store_url }}" target="_blank" class="store-link">
                                    {{ $custom_domain }}
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div class="next-steps">
                            <h3>
                                <i class="fas fa-list-check"></i>
                                الخطوات التالية
                            </h3>
                            <div class="steps-grid">
                                <div class="step-item">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <h4>تأكد من إعدادات الدومين</h4>
                                        <p>تأكد من أن الدومين يشير إلى خوادمنا بشكل صحيح</p>
                                    </div>
                                </div>
                                <div class="step-item">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <h4>انتقل إلى لوحة التحكم</h4>
                                        <p>ابدأ في إضافة المنتجات وتخصيص متجرك</p>
                                    </div>
                                </div>
                                <div class="step-item">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <h4>قم بزيارة متجرك</h4>
                                        <p>تحقق من أن كل شيء يعمل بشكل صحيح</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Important Note -->
                        <div class="important-note">
                            <div class="note-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="note-content">
                                <h4>ملاحظة هامة</h4>
                                <p>قد يستغرق الأمر من 24 إلى 48 ساعة حتى يتم نشر تغييرات DNS بالكامل. إذا لم يعمل الدومين فوراً، لا تقلق! يمكنك الوصول إلى لوحة التحكم من خلال الرابط أدناه.</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>انتقل إلى لوحة التحكم</span>
                            </a>
                            <a href="{{ $store_url }}" target="_blank" class="btn-secondary">
                                <i class="fas fa-store"></i>
                                <span>زيارة المتجر</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="success-footer">
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
            overflow-x: hidden;
        }

        /* Success Section */
        .success-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--darker-color) 0%, var(--dark-color) 100%);
        }

        /* Celebration Background */
        .celebration-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: var(--primary-color);
            animation: confettiFall 5s linear infinite;
        }

        .confetti:nth-child(1) { left: 10%; animation-delay: 0s; background: #10b981; }
        .confetti:nth-child(2) { left: 20%; animation-delay: 1s; background: #6366f1; }
        .confetti:nth-child(3) { left: 30%; animation-delay: 2s; background: #f59e0b; }
        .confetti:nth-child(4) { left: 40%; animation-delay: 0.5s; background: #ef4444; }
        .confetti:nth-child(5) { left: 50%; animation-delay: 1.5s; background: #8b5cf6; }
        .confetti:nth-child(6) { left: 60%; animation-delay: 2.5s; background: #10b981; }
        .confetti:nth-child(7) { left: 70%; animation-delay: 0.8s; background: #6366f1; }
        .confetti:nth-child(8) { left: 80%; animation-delay: 1.8s; background: #f59e0b; }
        .confetti:nth-child(9) { left: 90%; animation-delay: 2.8s; background: #ef4444; }
        .confetti:nth-child(10) { left: 15%; animation-delay: 3s; background: #8b5cf6; }

        @keyframes confettiFall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
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
            color: rgba(16, 185, 129, 0.1);
            font-size: 3rem;
            animation: float 8s ease-in-out infinite;
        }

        .floating-icon:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; color: rgba(99, 102, 241, 0.1); }
        .floating-icon:nth-child(3) { top: 50%; left: 5%; animation-delay: 2s; }
        .floating-icon:nth-child(4) { top: 70%; right: 10%; animation-delay: 1.5s; color: rgba(245, 158, 11, 0.1); }
        .floating-icon:nth-child(5) { top: 30%; left: 25%; animation-delay: 0.5s; }
        .floating-icon:nth-child(6) { top: 60%; right: 20%; animation-delay: 2.5s; }
        .floating-icon:nth-child(7) { top: 80%; left: 20%; animation-delay: 1s; color: rgba(99, 102, 241, 0.1); }
        .floating-icon:nth-child(8) { top: 40%; right: 30%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }

        /* Success Card */
        .success-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            padding: 3rem;
            position: relative;
            z-index: 10;
            animation: slideIn 0.6s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Success Icon */
        .success-icon-wrapper {
            text-align: center;
            margin-bottom: 2rem;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            animation: scaleIn 0.5s ease;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .success-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Store URL Card */
        .store-url-card {
            background: rgba(16, 185, 129, 0.1);
            border: 2px solid var(--primary-color);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: var(--transition);
        }

        .store-url-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }

        .url-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            flex-shrink: 0;
        }

        .url-content {
            flex-grow: 1;
        }

        .url-content h3 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .store-link {
            color: var(--primary-color);
            font-size: 1.3rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .store-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Next Steps */
        .next-steps {
            margin-bottom: 2rem;
        }

        .next-steps h3 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
        }

        .next-steps h3 i {
            color: var(--primary-color);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .step-item {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            display: flex;
            gap: 1rem;
            transition: var(--transition);
        }

        .step-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .step-content h4 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .step-content p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        /* Important Note */
        .important-note {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid var(--secondary-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
        }

        .note-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .note-content h4 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .note-content p {
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.6;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-secondary {
            padding: 1rem 2.5rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.7rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
            transform: translateY(-2px);
            color: var(--text-primary);
            text-decoration: none;
        }

        /* Footer */
        .success-footer {
            background: var(--darker-color);
            color: var(--text-secondary);
            padding: 2rem 0;
            border-top: 1px solid var(--border-color);
        }

        .success-footer p {
            margin: 0;
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .success-card {
                padding: 2rem 1.5rem;
            }

            .success-title {
                font-size: 2rem;
            }

            .success-subtitle {
                font-size: 1rem;
            }

            .store-url-card {
                flex-direction: column;
                text-align: center;
            }

            .store-link {
                justify-content: center;
                flex-wrap: wrap;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .important-note {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .success-section {
                padding: 2rem 0;
            }

            .success-icon {
                width: 80px;
                height: 80px;
                font-size: 2.5rem;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

