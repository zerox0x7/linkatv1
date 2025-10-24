<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\OnlineUser;

class TrackOnlineUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تجاهل بعض المسارات مثل لوحة التحكم أو API أو طلبات AJAX
        if ($request->is('admin/*') || $request->ajax()) {
            return $next($request);
        }

        $userAgent = $request->userAgent();
        $isBot = $this->isBot($userAgent);

        // لا تحفظ جلسات البوتات
        if ($isBot) {
            return $next($request);
        }

        // تسجيل بيانات الزائر أو المستخدم فقط (بدون البوتات)
        OnlineUser::updateOrCreate(
            ['session_id' => session()->getId()],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'page_url' => $request->fullUrl(),
                'user_type' => auth()->check() ? (auth()->user()->isAdmin() ? 'admin' : 'user') : 'guest',
                'user_id' => auth()->id(),
                'last_activity' => now(),
            ]
        );

        return $next($request);
    }

    protected function isBot($userAgent)
    {
        $bots = [
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider', 'yandex', 'sogou', 'exabot', 'facebot', 'ia_archiver'
        ];
        $userAgent = strtolower($userAgent);
        foreach ($bots as $bot) {
            if (strpos($userAgent, $bot) !== false) {
                return true;
            }
        }
        return false;
    }
}
