<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    /**
     * عرض قائمة طرق الدفع
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->get();
        return view('themes.dashboard.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * عرض نموذج إنشاء طريقة دفع جديدة
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('themes.dashboard.payment-methods.create');
    }

    /**
     * تخزين طريقة دفع جديدة
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:1024',
            'fee_percentage' => 'nullable|numeric|min:0',
            'fee_fixed' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'mode' => 'required|in:live,test',
            'is_active' => 'nullable|boolean',
        ]);

        // تحميل الشعار إذا تم توفيره
        if ($request->hasFile('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('payment-methods', 'public');
        }

        // معالجة بيانات الاعتماد حسب كل طريقة دفع
        $credentials = [];
        switch ($request->code) {
            case 'paypal':
                $credentials = [
                    'test' => [
                        'client_id' => $request->input('test_client_id'),
                        'client_secret' => $request->input('test_client_secret'),
                    ],
                    'live' => [
                        'client_id' => $request->input('live_client_id'),
                        'client_secret' => $request->input('live_client_secret'),
                    ],
                ];
                break;
            case 'stripe':
                $credentials = [
                    'test' => [
                        'publishable_key' => $request->input('test_publishable_key'),
                        'secret_key' => $request->input('test_secret_key'),
                    ],
                    'live' => [
                        'publishable_key' => $request->input('live_publishable_key'),
                        'secret_key' => $request->input('live_secret_key'),
                    ],
                ];
                break;
            case 'myfatoorah':
                $config = [
                    'apiKey' => $request->input('api_key'),
                    'vcCode' => $request->input('vcCode', 'SAU'),
                    'mode' => $request->input('mode')
                ];
                $settings = [
                    'currency' => $request->input('currency')
                ];
                $validatedData['config'] = $config;
                $validatedData['settings'] = $settings;
                $validatedData['mode'] = $request->input('mode');
                break;
            case 'bank_transfer':
                $credentials = [
                    'bank_name' => $request->input('bank_name'),
                    'account_name' => $request->input('account_name'),
                    'account_number' => $request->input('account_number'),
                    'iban' => $request->input('iban'),
                    'swift_code' => $request->input('swift_code'),
                ];
                break;
            default:
                $credentials = $request->input('credentials', []);
                break;
        }

        $validatedData['credentials'] = $credentials;
        if ($request->code === 'myfatoorah') {
            $validatedData['config'] = $credentials;
        }
        $validatedData['is_active'] = $request->has('is_active');

        PaymentMethod::create($validatedData);

        return redirect()->route('dashboard.payment-methods.index')
                        ->with('success', 'تم إضافة طريقة الدفع بنجاح.');
    }

    /**
     * عرض صفحة تعديل طريقة دفع
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\View\View
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('themes.dashboard.payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * تحديث طريقة دفع
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        // تسجيل بيانات الطلب للتحقق
        \Illuminate\Support\Facades\Log::debug('بيانات طلب تحديث طريقة دفع', [
            'payment_id' => $paymentMethod->id,
            'payment_code' => $paymentMethod->code,
            'request_data' => $request->all()
        ]);
        
        try {
            // التحقق من صحة البيانات
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => ['required', 'string', 'max:50', Rule::unique('payment_methods')->ignore($paymentMethod->id)],
                'description' => 'nullable|string',
                'logo' => 'nullable|image|max:1024',
                'fee_percentage' => 'nullable|numeric|min:0',
                'fee_fixed' => 'nullable|numeric|min:0',
                'sort_order' => 'nullable|integer|min:0'
            ]);
            
            // تحديد وضع التشغيل
            $mode = $request->input('mode');
            // في حالة كليك باي، نقوم بتحويل الوضع دائماً إلى live
            if ($paymentMethod->code == 'clickpay') {
                $mode = 'live';
            }
            
            // تجهيز البيانات الأساسية للتحديث
            // تحويل القيم الفارغة أو null إلى أصفار
            $feePercentage = $request->input('fee_percentage');
            $feeFixed = $request->input('fee_fixed');
            $sortOrder = $request->input('sort_order');
            
            // التأكد من أن القيم هي أرقام صالحة
            $feePercentage = (is_null($feePercentage) || $feePercentage === '') ? 0 : (float)$feePercentage;
            $feeFixed = (is_null($feeFixed) || $feeFixed === '') ? 0 : (float)$feeFixed;
            $sortOrder = (is_null($sortOrder) || $sortOrder === '') ? 0 : (int)$sortOrder;
            
            $updateData = [
                'name' => $request->input('name'),
                'description' => $request->input('description', ''),
                'mode' => $mode,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'fee_percentage' => $feePercentage,
                'fee_fixed' => $feeFixed,
                'sort_order' => $sortOrder,
                'updated_at' => now()
            ];
            
            // تسجيل البيانات الأساسية للتأكد من صحتها
            \Illuminate\Support\Facades\Log::info('بيانات التحديث الأساسية', [
                'fee_percentage_input' => $request->input('fee_percentage'),
                'fee_fixed_input' => $request->input('fee_fixed'),
                'sort_order_input' => $request->input('sort_order'),
                'update_data' => $updateData
            ]);
            
            // معالجة الشعار إذا تم رفعه
            if ($request->hasFile('logo')) {
                if ($paymentMethod->logo) {
                    Storage::disk('public')->delete($paymentMethod->logo);
                }
                $updateData['logo'] = $request->file('logo')->store('payment-methods', 'public');
            }
            
            // معالجة بيانات الاعتماد حسب نوع بوابة الدفع
            if ($paymentMethod->code == 'clickpay') {
                // معالجة خاصة لكليك باي
                $credentials = [
                    'profile_id' => $request->input('config.profile_id', ''),
                    'server_key' => $request->input('config.server_key', '')
                ];
                
                // الاحتفاظ بالقيم القديمة إذا لم يتم تقديم قيم جديدة
                $existingConfig = $paymentMethod->config ?: [];
                
                if (empty($credentials['profile_id']) && isset($existingConfig['profile_id'])) {
                    $credentials['profile_id'] = $existingConfig['profile_id'];
                }
                
                if (empty($credentials['server_key']) && isset($existingConfig['server_key'])) {
                    $credentials['server_key'] = $existingConfig['server_key'];
                }
                
                // إضافة وضع التشغيل (mode) إلى بيانات الاعتماد
                $credentials['mode'] = $mode;
                
                // تسجيل البيانات للتأكد من صحتها
                \Illuminate\Support\Facades\Log::info('تحديث بيانات كليك باي', [
                    'credentials' => $credentials,
                    'mode' => $mode
                ]);
                
                // تحديث البيانات
                $updateData['config'] = $credentials;
            } else {
                // معالجة بوابات الدفع الأخرى
                switch ($paymentMethod->code) {
                    case 'paypal':
                        $config = [
                            'test' => [
                                'client_id' => $request->input('test_client_id'),
                                'client_secret' => $request->input('test_client_secret'),
                            ],
                            'live' => [
                                'client_id' => $request->input('live_client_id'),
                                'client_secret' => $request->input('live_client_secret'),
                            ],
                            'mode' => $mode
                        ];
                        break;
                    case 'stripe':
                        $config = [
                            'test' => [
                                'publishable_key' => $request->input('test_publishable_key'),
                                'secret_key' => $request->input('test_secret_key'),
                            ],
                            'live' => [
                                'publishable_key' => $request->input('live_publishable_key'),
                                'secret_key' => $request->input('live_secret_key'),
                            ],
                            'mode' => $mode
                        ];
                        break;
                    case 'myfatoorah':
                        $configInput = $request->input('config', []);
                        // نستخرج العملة مباشرة من الـ request
                        $currency = $request->input('settings.currency', 'SAR');
                        
                        $config = [
                            'apiKey' => isset($configInput['apiKey']) ? (string)$configInput['apiKey'] : '',
                            'vcCode' => isset($configInput['vcCode']) ? (string)$configInput['vcCode'] : 'SAU',
                            'mode' => $request->input('mode')
                        ];
                        
                        // نقوم بتحديث الـ settings مباشرة
                        $settings = [
                            'currency' => $currency
                        ];
                        
                        // تسجيل القيم للتحقق
                        \Illuminate\Support\Facades\Log::info('تحديث ماي فاتورة', [
                            'mode_from_request' => $request->input('mode'),
                            'current_mode' => $paymentMethod->mode,
                            'currency_from_request' => $currency,
                            'settings' => $settings,
                            'update_data' => $updateData
                        ]);
                        
                        // نستخدم القيمة المختارة مباشرة من النموذج
                        $updateData['mode'] = $request->input('mode');
                        
                        // نقوم بتحديث الـ settings مباشرة
                        $paymentMethod->settings = $settings;
                        $paymentMethod->save();
                        
                        break;
                    case 'bank_transfer':
                        $config = [
                            'bank_name' => $request->input('bank_name'),
                            'account_name' => $request->input('account_name'),
                            'account_number' => $request->input('account_number'),
                            'iban' => $request->input('iban'),
                            'swift_code' => $request->input('swift_code'),
                            'mode' => $mode
                        ];
                        break;
                    default:
                        $config = [];
                        break;
                }
                
                // حفظ بيانات الاعتماد في حقل config بدلاً من credentials
                $updateData['config'] = $config ?? $updateData['config'] ?? [];
            }
            
            // تحويل settings إلى JSON إذا كانت مصفوفة
            if (isset($updateData['settings']) && is_array($updateData['settings'])) {
                $updateData['settings'] = json_encode($updateData['settings'], JSON_UNESCAPED_UNICODE);
            }
            
            // تسجيل البيانات النهائية للتحديث
            \Illuminate\Support\Facades\Log::info('بيانات التحديث النهائية', [
                'update_data' => $updateData
            ]);
            
            // تحديث بيانات طريقة الدفع
            $result = $paymentMethod->update($updateData);
                
            \Illuminate\Support\Facades\Log::info('نتيجة تحديث طريقة الدفع', [
                'payment_id' => $paymentMethod->id,
                'payment_code' => $paymentMethod->code,
                'updated' => $result,
                'update_data' => $updateData
            ]);
            
            return redirect()->route('dashboard.payment-methods.index')
                ->with('success', 'تم تحديث طريقة الدفع بنجاح.');
                
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('خطأ في تحديث طريقة الدفع', [
                'payment_id' => $paymentMethod->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث طريقة الدفع: ' . $e->getMessage());
        }
    }

    /**
     * حذف طريقة دفع
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        // حذف الشعار إذا كان موجودًا
        if ($paymentMethod->logo) {
            Storage::disk('public')->delete($paymentMethod->logo);
        }
        
        $paymentMethod->delete();
        
        return redirect()->route('dashboard.payment-methods.index')
                        ->with('success', 'تم حذف طريقة الدفع بنجاح.');
    }

    /**
     * تغيير حالة التفعيل لطريقة دفع
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->is_active) {
            $paymentMethod->deactivate();
            $message = 'تم تعطيل طريقة الدفع بنجاح.';
        } else {
            $paymentMethod->activate();
            $message = 'تم تفعيل طريقة الدفع بنجاح.';
        }
        
        return redirect()->route('dashboard.payment-methods.index')
                        ->with('success', $message);
    }
}
