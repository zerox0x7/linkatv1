<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // تخطي التحقق للصفحات العامة ومسارات الاشتراك
        $excludedRoutes = [
            'subscriptions.*',
            'home',
            'login',
            'register',
            'password.*',
            'products.*',
            'page.*',
            'cart.*',
        ];
        
        foreach ($excludedRoutes as $pattern) {
            if ($request->routeIs($pattern)) {
                return $next($request);
            }
        }
        
        // إذا كان المستخدم أدمين، تخطي التحقق
        if ($user && $user->isAdmin()) {
            return $next($request);
        }
        
        // إذا كان المستخدم مسجلاً وليس لديه اشتراك نشط
        if ($user && !$user->hasActiveSubscription()) {
            // توجيه إلى صفحة الاشتراك مع رسالة
            return redirect()->route('subscriptions.index')
                ->with('warning', 'يجب أن يكون لديك اشتراك نشط للوصول لهذه الصفحة');
        }
        
        return $next($request);
    }
}
