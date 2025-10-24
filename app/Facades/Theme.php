<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getActiveTheme()
 * @method static bool setActiveTheme(string $theme)
 * @method static bool themeExists(string $theme)
 * @method static array getAllThemes()
 * @method static string getThemeView(string $view)
 *
 * @see \App\Services\ThemeManager
 */
class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'theme';
    }
} 