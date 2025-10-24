<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isCustomer()) {
            return $next($request);
        }
        
        // إعادة توجيه المستخدم إلى الصفحة الرئيسية مع رسالة خطأ
        return redirect()->route('home')->with('error', 'ليس لديك صلاحية الوصول إلى لوحة المسؤول.');
    }
}
