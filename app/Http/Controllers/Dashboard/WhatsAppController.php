<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppTemplate;
use App\Models\WhatsAppLog;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * عرض لوحة تحكم الواتساب
     */
    public function index()
    {
        $stats = [
            'templatesCount' => WhatsAppTemplate::count(),
            'logsCount' => WhatsAppLog::count(),
            'sentToday' => WhatsAppLog::whereDate('created_at', today())->count(),
            'successRate' => WhatsAppLog::whereDate('created_at', '>=', now()->subDays(7))->where('status', 'success')->count(),
        ];
        
        return view('themes.dashboard.whatsapp.index', compact('stats'));
    }

    /**
     * عرض صفحة إعدادات الواتساب
     */
    public function settings()
    {
        $settings = [
            'api_key' => config('whatsapp.api_key'),
            'instance_id' => config('whatsapp.instance_id'),
            'enable_notifications' => config('whatsapp.enable_notifications', true),
            'default_lang' => config('whatsapp.default_lang', 'ar'),
            'dashboard_phones' => config('whatsapp.dashboard_phones'),
        ];
        
        return view('themes.dashboard.whatsapp.settings', compact('settings'));
    }

    /**
     * تحديث إعدادات الواتساب
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'api_key' => 'required|string',
            'instance_id' => 'required|string',
            'enable_notifications' => 'nullable|boolean',
            'dashboard_phones' => 'required',
        ]);

        // تحديث ملف الإعدادات
        $this->updateConfigFile($validated);
        
        return redirect()->route('dashboard.whatsapp.settings')->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    /**
     * عرض قوالب الرسائل
     */
    public function templates()
    {
        $templates = WhatsAppTemplate::latest()->paginate(15);
        return view('themes.dashboard.whatsapp.templates.index', compact('templates'));
    }

    /**
     * عرض صفحة إنشاء قالب جديد
     */
    public function createTemplate()
    {
        return view('themes.dashboard.whatsapp.templates.create');
    }

    /**
     * حفظ قالب جديد
     */
    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'type' => 'required|string|in:order_pending,order_processing,order_completed,order_cancelled,order_refunded,otp,dashboard_notification',
            'content' => 'required|string',
            'parameters' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);
        
        WhatsAppTemplate::create($validated);
        
        return redirect()->route('dashboard.whatsapp.templates')
            ->with('success', 'تم إنشاء القالب بنجاح');
    }

    /**
     * عرض صفحة تعديل قالب
     */
    public function editTemplate($template)
    {
        // إذا كان $template رقم، اعتبره id وابحث بالطريقة القديمة
        if (is_numeric($template)) {
            $templateModel = WhatsAppTemplate::findOrFail($template);
        } else {
            // ابحث عن القالب بالاسم
            $templateModel = WhatsAppTemplate::where('name', $template)->first();
            if (!$templateModel) {
                // جلب القيم الافتراضية من الثوابت
                $type = $template;
                $name = $template;
                $content = \App\Constants\WhatsAppTemplates::TEMPLATE_CONTENT[$name] ?? 'رسالة افتراضية للقالب ' . $name;
                $is_active = false;
                $templateModel = WhatsAppTemplate::create([
                    'name' => $name,
                    'type' => $type,
                    'content' => $content,
                    'is_active' => $is_active,
                ]);
            }
        }
        return view('themes.dashboard.whatsapp.templates.edit', ['template' => $templateModel]);
    }

    /**
     * تحديث قالب
     */
    public function updateTemplate(Request $request, WhatsAppTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'type' => 'required|string|in:order_pending,order_processing,order_completed,order_cancelled,order_refunded,otp,dashboard_notification',
            'content' => 'required|string',
            'parameters' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);
        
        $template->update($validated);
        
        return redirect()->route('dashboard.whatsapp.templates')
            ->with('success', 'تم تحديث القالب بنجاح');
    }

    /**
     * حذف قالب
     */
    public function destroyTemplate(WhatsAppTemplate $template)
    {
        $template->delete();
        
        return redirect()->route('dashboard.whatsapp.templates')
            ->with('success', 'تم حذف القالب بنجاح');
    }

    /**
     * عرض صفحة اختبار الإرسال
     */
    public function testPage()
    {
        $templates = WhatsAppTemplate::where('is_active', true)->get();
        return view('themes.dashboard.whatsapp.test', compact('templates'));
    }

    /**
     * اختبار اتصال API
     */
    public function testApiConnection()
    {
        $result = $this->whatsappService->testApiConnection();
        return response()->json($result);
    }

    /**
     * إرسال رسالة اختبار
     */
    public function sendTest(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'template_id' => 'required|exists:whatsapp_templates,id',
            'parameters' => 'nullable|array',
        ]);
        
        try {
            $template = WhatsAppTemplate::findOrFail($validated['template_id']);
            $result = $this->whatsappService->sendMessage(
                $validated['phone'],
                $template,
                $validated['parameters'] ?? []
            );
            
            return redirect()->route('dashboard.whatsapp.test')
                ->with('success', 'تم إرسال الرسالة بنجاح: ' . $result['id']);
        } catch (\Exception $e) {
            Log::error('WhatsApp test message error: ' . $e->getMessage());
            return redirect()->route('dashboard.whatsapp.test')
                ->with('error', 'فشل إرسال الرسالة: ' . $e->getMessage());
        }
    }

    /**
     * عرض سجلات الإرسال
     */
    public function logs()
    {
        $logs = WhatsAppLog::with('user')->latest()->paginate(50);
        return view('themes.dashboard.whatsapp.logs', compact('logs'));
    }

    /**
     * الحصول على قالب واتساب
     */
    public function getTemplate(WhatsAppTemplate $template)
    {
        return response()->json([
            'success' => true,
            'content' => $template->content,
            'type' => $template->type,
            'parameters' => $template->parameters,
        ]);
    }

    /**
     * تحديث ملف الإعدادات
     */
    private function updateConfigFile(array $data)
    {
        $path = config_path('whatsapp.php');
        
        $contents = "<?php\n\nreturn [\n";
        
        foreach ($data as $key => $value) {
            $contents .= "    '{$key}' => ";
            
            if (is_bool($value)) {
                $contents .= ($value ? 'true' : 'false');
            } else {
                $contents .= "'{$value}'";
            }
            
            $contents .= ",\n";
        }
        
        $contents .= "];\n";
        
        file_put_contents($path, $contents);
    }

    /**
     * تفعيل أو تعطيل قالب واتساب بسرعة
     */
    public function toggleTemplateStatus(WhatsAppTemplate $template)
    {
        $template->is_active = !$template->is_active;
        $template->save();
        return redirect()->back()->with('success', 'تم تحديث حالة تفعيل القالب بنجاح.');
    }

    /** قسم زارسال تنبيه واتساب للعميل من خلال الطلب تنبيه تصي رسالة تنبيه للعميل 
     * 
     */
    public function sendOrderAlert(Request $request, \App\Models\Order $order)
    {
        \Log::info('WhatsApp sendOrderAlert called', [
            'order_id' => $order->id,
            'user_id' => $order->user->id ?? null,
            'phone' => $order->user->phone ?? null,
            'alert_message' => $request->input('alert_message'),
        ]);

        $request->validate([
            'alert_message' => 'required|string',
        ]);

        $phone = $order->user->phone ?? null;
        $message = $request->input('alert_message');

        if (!$phone) {
            \Log::error('WhatsApp sendOrderAlert: No phone number for order', ['order_id' => $order->id]);
            return response()->json(['success' => false, 'message' => 'لا يوجد رقم جوال للعميل'], 422);
        }

        $result = app(\App\Services\WhatsApp\WhatsAppService::class)
            ->sendMessage($phone, 'text', ['message' => $message]);

        \Log::info('WhatsApp sendOrderAlert result', ['result' => $result]);

        if (isset($result['status']) && $result['status'] === 'success') {
            return response()->json(['success' => true, 'message' => 'تم إرسال الرسالة بنجاح']);
        } else {
            return response()->json(['success' => false, 'message' => 'فشل إرسال الرسالة عبر واتساب'], 500);
        }
    }
} 