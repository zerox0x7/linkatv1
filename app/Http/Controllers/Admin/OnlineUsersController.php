<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OnlineUsersController extends Controller
{
    public function index()
    {
        $onlineUsers = OnlineUser::active()
            ->with('user')
            ->latest('last_activity')
            ->paginate(20);

        $stats = [
            'total' => OnlineUser::active()->count(),
            'guests' => OnlineUser::active()->guests()->count(),
            'registered' => OnlineUser::active()->registered()->count(),
            'admins' => OnlineUser::active()->admins()->count(),
        ];

        // إحصائية إجمالي الزوار الفعليين (بدون البوتات)
        $totalVisits = OnlineUser::where('user_type', '!=', 'bot')->distinct('session_id')->count('session_id');

        return view('themes.admin.online-users.index', compact('onlineUsers', 'stats', 'totalVisits'));
    }

    public function updateActivity(Request $request)
    {
        try {
            $sessionId = session()->getId();
            $userType = auth()->check() ? (auth()->user()->isAdmin() ? 'admin' : 'user') : 'guest';
            
            // استخدام Cache لتقليل عدد الطلبات
            $cacheKey = "user_activity_{$sessionId}";
            if (Cache::has($cacheKey)) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم تحديث النشاط مؤخراً'
                ]);
            }

            // تجاهل طلبات تحديث النشاط
            $pageUrl = $request->input('page_url', $request->url());
            if (strpos($pageUrl, 'update-activity') !== false) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم تجاهل تحديث النشاط'
                ]);
            }

            Log::info('User activity updated', [
                'session_id' => $sessionId,
                'user_type' => $userType,
                'ip' => $request->ip(),
                'url' => $pageUrl
            ]);

            // تحديث أو إنشاء سجل المستخدم
            $user = OnlineUser::updateOrCreate(
                ['session_id' => $sessionId],
                [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'page_url' => $pageUrl,
                    'user_type' => $userType,
                    'user_id' => auth()->id(),
                    'last_activity' => now(),
                ]
            );

            // تحسين طريقة جلب عنوان الصفحة
            $pageTitle = $this->getPageTitle($pageUrl, $request->input('page_title', ''));

            // تحديث مسار المستخدم
            $currentPage = [
                'url' => $pageUrl,
                'title' => $pageTitle,
                'time' => now()->toDateTimeString()
            ];

            $journey = $user->user_journey ?? [];
            
            // إضافة الصفحة الحالية فقط إذا كانت مختلفة عن آخر صفحة
            if (empty($journey) || end($journey)['url'] !== $pageUrl) {
                $journey[] = $currentPage;
            } else {
                // تحديث وقت آخر صفحة فقط
                $journey[count($journey) - 1]['time'] = $currentPage['time'];
            }

            // الاحتفاظ بآخر 5 صفحات فقط
            if (count($journey) > 5) {
                $journey = array_slice($journey, -5);
            }

            $user->update(['user_journey' => $journey]);

            // تخزين في الكاش لمدة 30 ثانية
            Cache::put($cacheKey, true, 30);

            // حذف المستخدمين غير النشطين كل 5 دقائق
            if (Cache::get('cleanup_inactive_users', false)) {
                OnlineUser::where('last_activity', '<', now()->subMinutes(5))->delete();
                Cache::put('cleanup_inactive_users', true, 300); // 5 دقائق
            }

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث النشاط بنجاح',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating user activity: ' . $e->getMessage(), [
                'exception' => $e,
                'session_id' => $sessionId ?? null,
                'user_type' => $userType ?? null,
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث النشاط'
            ], 500);
        }
    }

    protected function getPageTitle($url, $clientTitle = '')
    {
        // إذا كان هناك عنوان من العميل، نستخدمه
        if (!empty($clientTitle)) {
            return $clientTitle;
        }

        // تحليل المسار
        $path = parse_url($url, PHP_URL_PATH);
        $path = trim($path, '/');
        
        // تجاهل المسارات غير المهمة
        if (strpos($path, 'update-activity') !== false) {
            return null;
        }
        
        // تحويل المسار إلى عنوان مقروء
        $segments = explode('/', $path);
        $title = [];
        
        foreach ($segments as $segment) {
            // تجاهل الأجزاء غير المهمة
            if (in_array($segment, ['update-activity'])) {
                continue;
            }
            
            // تحويل الشرطة إلى مسافات
            $segment = str_replace('-', ' ', $segment);
            // تحويل الكلمات إلى حروف كبيرة
            $segment = ucwords($segment);
            $title[] = $segment;
        }
        
        // إذا كان المسار فارغاً، نعيد "الصفحة الرئيسية"
        if (empty($title)) {
            return 'الصفحة الرئيسية';
        }
        
        // دمج الأجزاء مع ">"
        return implode(' > ', $title);
    }

    public function clearInactive()
    {
        try {
            $deleted = OnlineUser::where('last_activity', '<', now()->subMinutes(5))->delete();
            Cache::forget('cleanup_inactive_users');
            return redirect()->back()->with('success', 'تم مسح ' . $deleted . ' مستخدم غير نشط بنجاح');
        } catch (\Exception $e) {
            Log::error('Error clearing inactive users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء مسح المستخدمين غير النشطين');
        }
    }
} 