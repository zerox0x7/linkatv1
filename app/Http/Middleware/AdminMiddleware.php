<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * التحقق من أن المستخدم هو مسؤول
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }
        
        // إعادة توجيه المستخدم إلى الصفحة الرئيسية مع رسالة خطأ
        return redirect()->route('home')->with('error', 'ليس لديك صلاحية الوصول إلى لوحة المسؤول.');
    }
} 