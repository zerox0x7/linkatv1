<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Models\ThemeSetting;

class ApplyTheme
{
    public function handle($request, Closure $next)
    {
        // Get the active theme from the database
        $activeTheme = ThemeSetting::get('active_theme', 'zain');

        // Share the active theme with all views
        View::share('activeTheme', $activeTheme);

        return $next($request);
    }
}