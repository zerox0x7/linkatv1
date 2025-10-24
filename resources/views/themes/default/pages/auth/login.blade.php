@extends('theme::layouts.app')

@section('title', 'تسجيل الدخول - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-[#1e1e1e] rounded-lg overflow-hidden">
        <div class="p-6">
            @php
                $otpTemplateActive = \App\Models\WhatsAppTemplate::where('type', 'otp')->where('is_active', true)->exists();
            @endphp
            @if($otpTemplateActive)
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-white" id="loginTitle">تسجيل الدخول برقم الهاتف</h2>
                    <p class="text-gray-400 mt-2" id="loginSubtitle">أدخل رقم هاتفك لإرسال رمز التحقق</p>
                </div>
            @endif

            @if($otpTemplateActive)
            {{-- Phone Login Form (Visible by default) --}}
            <form method="POST" action="{{ route('login.phone.send') }}" class="space-y-6" id="phoneLoginForm" data-verify-otp-url="{{ route('login.phone.verify') }}">
                @csrf
                <div>
                    <label for="country_code" class="block text-white mb-2">اختر الدولة</label>
                    <select id="country_code" name="country_code" 
                            class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white focus:outline-none focus:border-primary appearance-none">
                        <option value="+966" data-placeholder="5XXXXXXXX" selected>السعودية (+966)</option>
                        <option value="+971" data-placeholder="5XXXXXXXXX">الإمارات (+971)</option>
                        <option value="+965" data-placeholder="XXXXXXXX">الكويت (+965)</option>
                        <option value="+974" data-placeholder="XXXXXXXX">قطر (+974)</option>
                        <option value="+973" data-placeholder="XXXXXXXX">البحرين (+973)</option>
                        <option value="+968" data-placeholder="XXXXXXXX">عمان (+968)</option>
                        <option value="other" data-placeholder="أدخل الرقم كاملاً مع مفتاح الدولة">دولة أخرى</option>
                    </select>
                </div>

                <div>
                    <label for="phone" class="block text-white mb-2">رقم الهاتف</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel" 
                           class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                           placeholder="5XXXXXXXX">
                    @error('phone')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    @error('country_code')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                    إرسال رمز التحقق
                </button>

                {{-- OTP Entry Section (Hidden by default) --}}
                <div id="otpEntrySection" class="space-y-6 hidden pt-4 mt-4 border-t border-gray-700">
                    <div>
                        <p class="text-sm text-gray-300 mb-2">
                            تم إرسال رمز التحقق إلى: <strong id="otpSentToPhone" class="font-mono"></strong>
                        </p>
                        <label for="otp" class="block text-white mb-2">رمز التحقق (OTP)</label>
                        <input id="otp" type="text" name="otp" 
                               class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary text-center tracking-widest text-lg"
                               placeholder="ادخل الرمز هنا" maxlength="6" autocomplete="one-time-code">
                        <div id="otpError" class="text-red-500 text-sm mt-2"></div>
                    </div>

                    <button type="button" id="verifyOtpButton" class="w-full bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                        تحقق من الرمز
                    </button>

                    <div class="text-center text-sm">
                        <button type="button" id="resendOtpButton" class="text-primary hover:underline" disabled>إعادة إرسال الرمز</button>
                        <span id="resendOtpTimer" class="text-gray-400 ml-2"></span>
                    </div>
                </div>

                <div class="text-center mt-4" id="switchToEmailContainer">
                    <a href="#" id="switchToEmailLogin" class="text-primary hover:underline text-sm">أو تسجيل الدخول بالبريد الإلكتروني</a>
                </div>
                
            </form>
            @else
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white">تسجيل الدخول عبر البريد الإلكتروني</h2>
            </div>
            @endif

            {{-- Email Login Form (Hidden by default) --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6 {{ $otpTemplateActive ? 'hidden' : '' }}" id="emailLoginForm">
                @csrf
                <div>
                    <label for="email" class="block text-white mb-2">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="text-white">كلمة المرور</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-primary text-sm hover:underline">
                                نسيت كلمة المرور؟
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="أدخل كلمة المرور">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="text-primary bg-[#1e1e1e] border-[#3a3a3a] rounded focus:ring-0">
                    <label for="remember" class="text-white mr-3">
                        تذكرني
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                    تسجيل الدخول بالبريد
                </button>

                @if($otpTemplateActive)
                    <div class="text-center mt-4">
                        <a href="#" id="switchToPhoneLogin" class="text-primary hover:underline text-sm">أو تسجيل الدخول برقم الهاتف</a>
                    </div>
                @endif
                
                <div class="text-center mt-6">
                    <p class="text-gray-400">
                        ليس لديك حساب؟
                        <a href="{{ route('register') }}" class="text-primary hover:underline">
                            إنشاء حساب جديد
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneLoginForm = document.getElementById('phoneLoginForm');
        const emailLoginForm = document.getElementById('emailLoginForm');
        const switchToEmailLogin = document.getElementById('switchToEmailLogin');
        const switchToPhoneLogin = document.getElementById('switchToPhoneLogin');
        const loginTitle = document.getElementById('loginTitle');
        const loginSubtitle = document.getElementById('loginSubtitle');
        
        const countryCodeSelect = document.getElementById('country_code');
        const phoneInput = document.getElementById('phone');
        const sendOtpButton = phoneLoginForm.querySelector('button[type="submit"]');
        const originalSendOtpButtonText = sendOtpButton.innerHTML;

        const otpEntrySection = document.getElementById('otpEntrySection');
        const otpInput = document.getElementById('otp');
        const verifyOtpButton = document.getElementById('verifyOtpButton');
        const originalVerifyOtpButtonText = verifyOtpButton.innerHTML;
        const resendOtpButton = document.getElementById('resendOtpButton');
        const otpSentToPhone = document.getElementById('otpSentToPhone');
        const otpError = document.getElementById('otpError');
        const resendOtpTimer = document.getElementById('resendOtpTimer');

        const switchToEmailContainer = document.getElementById('switchToEmailContainer');
        const registerLinkContainer = document.getElementById('registerLinkContainer');

        let resendInterval;
        let resendCooldown = 60; // seconds
        let currentFullPhoneNumber = ''; // To store the number for OTP verification and resend

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
            countryCodeSelect.disabled = true;
            phoneInput.disabled = true;
            sendOtpButton.classList.add('hidden');
            // switchToEmailContainer.classList.add('hidden');
            // registerLinkContainer.classList.add('hidden'); // Optionally hide register link too

            otpSentToPhone.textContent = fullPhoneNumber;
            otpEntrySection.classList.remove('hidden');
            otpInput.value = '';
            otpError.textContent = '';
            otpInput.focus();
            startResendTimer();
            loginSubtitle.textContent = 'أدخل رمز التحقق المرسل إلى هاتفك';
        }

        function hideOtpForm() {
            countryCodeSelect.disabled = false;
            phoneInput.disabled = false;
            sendOtpButton.classList.remove('hidden');
            switchToEmailContainer.classList.remove('hidden');
            // registerLinkContainer.classList.remove('hidden');
            
            otpEntrySection.classList.add('hidden');
            currentFullPhoneNumber = '';
            loginSubtitle.textContent = 'أدخل رقم هاتفك لإرسال رمز التحقق';
        }

        function startResendTimer() {
            clearInterval(resendInterval);
            resendOtpButton.disabled = true;
            let timeLeft = resendCooldown;
            resendOtpTimer.textContent = `(${timeLeft} ثانية)`;
            resendInterval = setInterval(() => {
                timeLeft--;
                resendOtpTimer.textContent = `(${timeLeft} ثانية)`;
                if (timeLeft <= 0) {
                    clearInterval(resendInterval);
                    resendOtpButton.disabled = false;
                    resendOtpTimer.textContent = '';
                    resendOtpButton.innerHTML = 'إعادة إرسال الرمز';
                }
            }, 1000);
        }

        phoneLoginForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            otpError.textContent = '';
            sendOtpButton.disabled = true;
            sendOtpButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white inline-block" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> جارٍ الإرسال...';

            const formData = new FormData(phoneLoginForm);
            const actionUrl = phoneLoginForm.getAttribute('action');
            const countryCode = formData.get('country_code');
            let phoneNumber = formData.get('phone').trim();

            // التحقق من صحة الرقم في حالة "دولة أخرى"
            if (countryCode === 'other') {
                // إضافة + إذا لم يكن موجوداً
                if (!phoneNumber.startsWith('+')) {
                    phoneNumber = '+' + phoneNumber;
                }

                // التحقق من أن الرقم يبدأ بـ + متبوعاً برقم
                if (!phoneNumber.match(/^\+\d{1,4}\d{6,14}$/)) {
                    otpError.textContent = 'الرجاء إدخال رقم الهاتف بالصيغة الصحيحة مع مفتاح الدولة (مثال: +1234567890)';
                    sendOtpButton.disabled = false;
                    sendOtpButton.innerHTML = originalSendOtpButtonText;
                    return;
                }

                // في حالة "دولة أخرى"، نستخدم الرقم الكامل في حقل phone فقط
                formData.set('country_code', ''); // نترك حقل country_code فارغاً
                formData.set('phone', phoneNumber); // نضع الرقم الكامل مع +
            } else {
                // في حالة الدول المحددة مسبقاً
                // إزالة + من الرقم إذا وجد
                if (phoneNumber.startsWith('+')) {
                    phoneNumber = phoneNumber.substring(1);
                }
                // إزالة أي أصفار في بداية الرقم
                phoneNumber = phoneNumber.replace(/^0+/, '');
                // إزالة + من رمز الدولة إذا وجد
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
                    // في حالة "دولة أخرى"، نستخدم الرقم كما هو
                    const fullPhoneNumber = countryCode === 'other' ? phoneNumber : ('+' + countryCode.replace(/^\+/, '') + phoneNumber);
                    showOtpForm(fullPhoneNumber);
                } else {
                    otpError.textContent = result.message || 'فشل إرسال رمز التحقق. حاول مرة أخرى.';
                    if (result.errors) {
                        let errorMsg = [];
                        for (const key in result.errors) {
                            errorMsg.push(result.errors[key].join(', '));
                        }
                        otpError.textContent = errorMsg.join(' ');
                    }
                    sendOtpButton.disabled = false;
                    sendOtpButton.innerHTML = originalSendOtpButtonText;
                }
            } catch (error) {
                console.error('Send OTP error:', error);
                otpError.textContent = 'حدث خطأ ما. يرجى المحاولة مرة أخرى.';
                sendOtpButton.disabled = false;
                sendOtpButton.innerHTML = originalSendOtpButtonText;
            }
        });

        verifyOtpButton.addEventListener('click', async function() {
            const otpValue = otpInput.value.trim();
            if (!otpValue) {
                otpError.textContent = 'الرجاء إدخال رمز التحقق.';
                otpInput.focus();
                return;
            }
            otpError.textContent = '';
            verifyOtpButton.disabled = true;
            verifyOtpButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white inline-block" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> جارٍ التحقق...';

            const verifyUrl = phoneLoginForm.dataset.verifyOtpUrl;
            
            console.log('Verify OTP URL:', verifyUrl);
            console.log('Sending for OTP verification (data):', JSON.stringify({ otp: otpValue, phone: currentFullPhoneNumber }));
            console.log('CSRF Token being sent:', csrfToken);
            
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
                        phone: currentFullPhoneNumber // Send the full phone number used for OTP
                    })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    } else {
                        // Handle case where redirect_url is not provided but login might be successful
                        // For now, assume redirect_url is always provided on success
                        otpError.textContent = 'تم التحقق بنجاح! يتم توجيهك...'; 
                    }
                } else {
                    otpError.textContent = result.message || 'رمز التحقق غير صحيح أو انتهت صلاحيته.';
                    otpInput.focus();
                    verifyOtpButton.disabled = false;
                    verifyOtpButton.innerHTML = originalVerifyOtpButtonText;
                }
            } catch (error) {
                console.error('Verify OTP error:', error);
                otpError.textContent = 'حدث خطأ أثناء التحقق. يرجى المحاولة مرة أخرى.';
                verifyOtpButton.disabled = false;
                verifyOtpButton.innerHTML = originalVerifyOtpButtonText;
            }
        });

        resendOtpButton.addEventListener('click', async function() {
            if (resendOtpButton.disabled) {
                return; // لا تفعل شيئاً إذا كان الزر معطلاً
            }

            otpError.textContent = '';
            resendOtpButton.disabled = true;
            resendOtpButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white inline-block" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> جارٍ الإرسال...';

            try {
                const formData = new FormData();
                const actionUrl = phoneLoginForm.getAttribute('action');
                
                // استخدام الرقم المحفوظ بدلاً من قراءته من النموذج
                if (!currentFullPhoneNumber) {
                    throw new Error('لم يتم العثور على رقم الهاتف');
                }

                // إرسال الرقم الكامل في حقل phone فقط
                formData.set('phone', currentFullPhoneNumber);
                formData.set('country_code', ''); // نترك حقل country_code فارغاً

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
                    startResendTimer(); // إعادة تشغيل العداد
                } else {
                    otpError.textContent = result.message || 'فشل إرسال رمز التحقق. حاول مرة أخرى.';
                    if (result.errors) {
                        let errorMsg = [];
                        for (const key in result.errors) {
                            errorMsg.push(result.errors[key].join(', '));
                        }
                        otpError.textContent = errorMsg.join(' ');
                    }
                    resendOtpButton.disabled = false;
                    resendOtpButton.innerHTML = 'إعادة إرسال الرمز';
                }
            } catch (error) {
                console.error('Resend OTP error:', error);
                otpError.textContent = error.message || 'حدث خطأ ما. يرجى المحاولة مرة أخرى.';
                resendOtpButton.disabled = false;
                resendOtpButton.innerHTML = 'إعادة إرسال الرمز';
            }
        });


        // --- Email/Phone Form Toggling Logic (existing) ---
        if (switchToEmailLogin) {
            switchToEmailLogin.addEventListener('click', function (e) {
                e.preventDefault();
                hideOtpForm(); // Ensure OTP form is hidden if switching from phone view
                phoneLoginForm.classList.add('hidden');
                emailLoginForm.classList.remove('hidden');
                loginTitle.textContent = 'تسجيل الدخول بالبريد الإلكتروني';
                loginSubtitle.textContent = 'أدخل بريدك الإلكتروني وكلمة المرور';
            });
        }

        if (switchToPhoneLogin) {
            switchToPhoneLogin.addEventListener('click', function (e) {
                e.preventDefault();
                emailLoginForm.classList.add('hidden');
                phoneLoginForm.classList.remove('hidden');
                hideOtpForm(); // Reset to phone entry state
                loginTitle.textContent = 'تسجيل الدخول برقم الهاتف';
                loginSubtitle.textContent = 'أدخل رقم هاتفك لإرسال رمز التحقق';
            });
        }

        // Handle redirect with specific form showing (e.g. if email login failed, show email form)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('form') === 'email' || ({{ $errors->has('email') || $errors->has('password') ? 'true' : 'false' }})) {
            if (phoneLoginForm && emailLoginForm && switchToEmailLogin) {
                 switchToEmailLogin.click(); 
            }
        }
    });
</script>

 
@endpush
