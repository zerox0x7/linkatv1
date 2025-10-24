<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PhoneAuthController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->middleware('guest')->except(['sendOtp', 'verifyOtp']); // Allow access to OTP methods even if logged in, guest for others.
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Display the form to request a phone number.
     */
    public function showPhoneEntryForm()
    {
        // This will point to a blade view we will create later
        // For now, let's return a placeholder response or view path
        return view('auth.phone_entry'); // e.g., resources/views/auth/phone_entry.blade.php
    }

    /**
     * Send OTP to the provided phone number.
     */
    public function sendOtp(Request $request)
    {
        // 1. تعديل قواعد التحقق
        $validator = Validator::make($request->all(), [
            'country_code' => ['nullable', 'string'], // جعل الحقل اختيارياً
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{7,15}$/'], // السماح بـ + في بداية الرقم
        ], [
            'country_code.string' => 'رمز الدولة يجب أن يكون نصاً.',
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.regex' => 'رقم الهاتف يجب أن يتكون من 7 إلى 15 رقمًا.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // 2. بناء رقم الهاتف الكامل
        $countryCode = $request->input('country_code');
        $localPhoneNumber = $request->input('phone');
        
        // إذا كان الرقم يبدأ بـ +، نعتبره رقماً دولياً كاملاً
        if (str_starts_with($localPhoneNumber, '+')) {
            $fullPhoneNumber = $localPhoneNumber;
        } else {
            // في حالة الدول المحددة مسبقاً، نضيف رمز الدولة المحدد فقط
            if ($countryCode && $countryCode !== 'other') {
                // إزالة أي + من رمز الدولة إذا وجد
                $cleanCountryCode = ltrim($countryCode, '+');
                // إزالة أي 0 من بداية الرقم المحلي
                $cleanPhoneNumber = ltrim($localPhoneNumber, '0');
                $fullPhoneNumber = '+' . $cleanCountryCode . $cleanPhoneNumber;
            } else {
                // في حالة "دولة أخرى" أو عدم وجود رمز دولة، نستخدم الرقم كما هو
                $fullPhoneNumber = '+' . ltrim($localPhoneNumber, '0');
            }
        }

        // 3. تطبيع الرقم (إزالة أي مسافات أو شرطات)
        $fullPhoneNumber = preg_replace('/[\\s\\-\\( )\\)]+/', '', $fullPhoneNumber);
        // تأكد أن الرقم الكامل يبدأ بـ + واحدة فقط
        if (substr_count($fullPhoneNumber, '+') > 1) {
            $fullPhoneNumber = '+' . ltrim(str_replace('+', '', $fullPhoneNumber), '+');
        }

        // التحقق من Cooldown
        $cacheKey = 'otp_data_' . Str::slug($fullPhoneNumber); // للمعلوملت الاساسية للOTP
        $cooldownCacheKey = 'otp_cooldown_' . Str::slug($fullPhoneNumber); // للتحقق من محاولات الارسال المتكررة

        if (Cache::has($cooldownCacheKey)) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى الانتظار دقيقة واحدة قبل محاولة إرسال رمز تحقق آخر لنفس الرقم.'
            ], 429); // Too Many Requests
        }

        // 4. توليد OTP
        $otp = random_int(100000, 999999); // 6 أرقام OTP

        // 5. تخزين OTP في Cache
        $otpExpiryMinutes = config('auth.otp_expiry_minutes', 5); // الافتراضي 5 دقائق
        Cache::put($cacheKey, [
            'otp' => $otp,
            'attempts' => 0,
            'phone_number' => $fullPhoneNumber, // خزن الرقم الكامل للتحقق لاحقًا
        ], now()->addMinutes($otpExpiryMinutes));

        // وضع علامة cooldown
        Cache::put($cooldownCacheKey, true, now()->addMinutes(1)); // Cooldown لمدة دقيقة واحدة

        // 6. إرسال OTP عبر الخدمة
        try {
            $message = "رمز التحقق الخاص بك هو: " . $otp;
            // تأكد أن sendOTP تتوقع الرقم الكامل الآن
            $response = $this->whatsAppService->sendOTP($fullPhoneNumber, (string)$otp);

            if (isset($response['status']) && $response['status'] === 'success') {
                session(['otp_phone_for_verification' => $fullPhoneNumber]); // مهم للتحقق
                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال رمز التحقق إلى ' . $fullPhoneNumber,
                    'full_phone_number' => $fullPhoneNumber // أرجع الرقم الكامل للواجهة الأمامية
                ]);
            } else {
                \Log::error('WhatsAppService sendOTP failed.', ['response' => $response, 'phone' => $fullPhoneNumber]);
                Cache::forget($cooldownCacheKey); // إزالة الـ cooldown إذا فشل الإرسال للسماح بإعادة المحاولة
                return response()->json([
                    'success' => false,
                    'message' => $response['message'] ?? 'فشل إرسال رمز التحقق. حاول مرة أخرى.'
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Error sending OTP: ' . $e->getMessage(), ['phone' => $fullPhoneNumber, 'exception' => $e]);
            Cache::forget($cooldownCacheKey); // إزالة الـ cooldown إذا فشل الإرسال
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء محاولة إرسال رمز التحقق.'
            ], 500);
        }
    }

    /**
     * Display the form to enter OTP.
     */
    public function showOtpEntryForm(Request $request)
    {
        $phone = $request->query('phone');
        if (!$phone || !Cache::has('otp_data_' . $phone)) {
            // If no phone in query or no OTP data in cache for this phone, redirect to phone entry
            return redirect()->route('login.phone.form')->withErrors(['phone' => 'يرجى إدخال رقم هاتفك أولاً.']);
        }
        return view('auth.otp_entry', ['phone' => $phone]); // e.g., resources/views/auth/otp_entry.blade.php
    }

    /**
     * Verify OTP and process login or registration.
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'], // Expecting full international number
            'otp'   => ['required', 'string', 'digits_between:4,6'], // OTP can be 4 to 6 digits
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $fullPhoneNumber = $request->input('phone');
        $otpEntered = $request->input('otp');

        // Verify that this phone number is the one we sent OTP to recently from session
        if (session('otp_phone_for_verification') !== $fullPhoneNumber) {
            return response()->json(['success' => false, 'message' => 'رقم الهاتف لا يتطابق مع الرقم الذي تم إرسال الرمز إليه.'], 400);
        }

        $cacheKeyForOtp = 'otp_data_' . Str::slug($fullPhoneNumber);
        $otpData = Cache::get($cacheKeyForOtp);

        if (!$otpData) {
            return response()->json(['success' => false, 'message' => 'انتهت صلاحية جلسة رمز التحقق أو أن رقم الهاتف غير صحيح. يرجى طلب رمز جديد.'], 400);
        }
        
        $maxAttempts = config('auth.otp_max_attempts', 3);
        if ($otpData['attempts'] >= $maxAttempts) {
            Cache::forget($cacheKeyForOtp);
            return response()->json(['success' => false, 'message' => 'لقد تجاوزت الحد الأقصى لمحاولات إدخال الرمز. يرجى طلب رمز جديد.'], 429); // Too Many Requests
        }

        if ((string)$otpData['otp'] === (string)$otpEntered) {
            Cache::forget('otp_data_' . $fullPhoneNumber);
            session()->forget('otp_phone_for_verification');

            // Normalize the phone number to match the database format (remove leading '+')
            $normalizedPhoneFromRequest = ltrim($fullPhoneNumber, '+');

            $user = User::where('phone', $normalizedPhoneFromRequest)->first(); // Search using normalized phone

            $intendedUrl = session()->pull('url.intended', route(config('fortify.home', 'home')));

            if ($user) {
                Auth::login($user, $request->boolean('remember')); // Use remember from request if available
                $request->session()->regenerate();
                return response()->json(['success' => true, 'redirect_url' => $intendedUrl, 'message' => 'تم تسجيل الدخول بنجاح.']);
            } else {
                // User does not exist, prepare for registration
                $request->session()->put('verified_phone', $fullPhoneNumber); // Use unified session key, store original full number
                return response()->json(['success' => true, 'redirect_url' => route('register'), 'message' => 'تم التحقق من رقم الهاتف. يرجى إكمال التسجيل.']);
            }
        } else {
            $otpData['attempts']++;
            Cache::put('otp_data_' . $fullPhoneNumber, $otpData, now()->addMinutes(config('auth.otp_expiry_minutes', 5)));

            return response()->json(['success' => false, 'message' => 'رمز التحقق الذي أدخلته غير صحيح.'], 422);
        }
    }

    // The old verifyOtpAndProcess can be removed or kept if used elsewhere, for now, it's effectively replaced by verifyOtp for the AJAX flow.
    // public function verifyOtpAndProcess(Request $request) { ... existing code ... }
}
