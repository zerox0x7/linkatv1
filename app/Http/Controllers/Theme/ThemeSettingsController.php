<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * ThemeSettingsController
 * 
 * This controller handles the core theme settings for any theme activated by store owners.
 * It manages the zain_theme_settings table which contains:
 * - Theme selection and activation
 * - Global theme preferences (RTL, animations, dark mode)
 * - Logo and favicon management
 * - Custom CSS/JS injections
 * - Google Fonts integration
 * - Analytics codes and social links
 * 
 * Purpose: This is the MASTER controller that coordinates theme data across all other
 * theme controllers. When a store owner switches themes, this controller ensures
 * all theme-related data is properly loaded and cached for optimal performance.
 * 
 * The controller prepares clean, structured data for blade templates so that
 * theme templates (HTML/CSS/JS/Tailwind) can easily access store customizations
 * without cluttering the blade files with complex database queries.
 */
class ThemeSettingsController extends Controller
{
    /**
     * Get complete theme configuration for a store
     * This method aggregates data from ALL zain_theme_* tables to provide
     * a single, comprehensive theme configuration object for the frontend
     * 
     * @param int $storeId - The store ID (user_id from users table)
     * @param string|null $themeName - Optional specific theme name
     * @return array - Complete theme configuration
     */
    public function getStoreThemeConfiguration($storeId, $themeName = null)
    {
        // Cache key for theme configuration
        $cacheKey = "store_theme_config_{$storeId}_" . ($themeName ?? 'active');
        
        return Cache::remember($cacheKey, 3600, function () use ($storeId, $themeName) {
            // Get active theme settings
            $themeSettings = $this->getActiveThemeSettings($storeId, $themeName);
            
            if (!$themeSettings) {
                return $this->getDefaultThemeConfiguration($storeId);
            }
            
            // Aggregate all theme components
            return [
                'settings' => $themeSettings,
                'colors' => app('App\Http\Controllers\Theme\ThemeColorController')->getStoreColorScheme($storeId),
                'fonts' => app('App\Http\Controllers\Theme\ThemeFontController')->getStoreFontConfiguration($storeId),
                'sections' => app('App\Http\Controllers\Theme\ThemeSectionController')->getActiveSections($storeId),
                'header' => app('App\Http\Controllers\Theme\ThemeHeaderController')->getHeaderConfiguration($storeId),
                'hero' => app('App\Http\Controllers\Theme\ThemeHeroController')->getHeroConfiguration($storeId),
                'footer' => app('App\Http\Controllers\Theme\ThemeFooterController')->getFooterConfiguration($storeId),
                'products' => app('App\Http\Controllers\Theme\ThemeProductController')->getProductDisplaySettings($storeId),
                'components' => app('App\Http\Controllers\Theme\ThemeComponentController')->getActiveComponents($storeId),
                'layout' => app('App\Http\Controllers\Theme\ThemeLayoutController')->getLayoutConfiguration($storeId),
                'media' => app('App\Http\Controllers\Theme\ThemeMediaController')->getThemeAssets($storeId),
            ];
        });
    }
    
    /**
     * Get active theme settings for a store
     * 
     * @param int $storeId
     * @param string|null $themeName
     * @return array|null
     */
    public function getActiveThemeSettings($storeId, $themeName = null)
    {
        $query = DB::table('zain_theme_settings')->where('store_id', $storeId);
        
        if ($themeName) {
            $query->where('theme_name', $themeName);
        } else {
            $query->where('is_active', true);
        }
        
        $settings = $query->first();
        
        if (!$settings) {
            return null;
        }
        
        // Parse JSON fields
        return [
            'id' => $settings->id,
            'theme_name' => $settings->theme_name,
            'theme_version' => $settings->theme_version,
            'layout_style' => $settings->layout_style,
            'site_width' => $settings->site_width,
            'rtl_support' => $settings->rtl_support,
            'logos' => [
                'favicon' => $settings->favicon,
                'logo' => $settings->logo,
                'logo_dark' => $settings->logo_dark,
                'mobile_logo' => $settings->mobile_logo,
            ],
            'customizations' => [
                'custom_css' => json_decode($settings->custom_css, true) ?? [],
                'custom_js' => json_decode($settings->custom_js, true) ?? [],
            ],
            'fonts' => [
                'google_fonts' => json_decode($settings->google_fonts, true) ?? [],
            ],
            'features' => [
                'enable_animations' => $settings->enable_animations,
                'enable_dark_mode' => $settings->enable_dark_mode,
                'enable_loading_screen' => $settings->enable_loading_screen,
                'loading_animation' => $settings->loading_animation,
                'enable_back_to_top' => $settings->enable_back_to_top,
            ],
            'integrations' => [
                'social_links' => json_decode($settings->social_links, true) ?? [],
                'analytics_codes' => json_decode($settings->analytics_codes, true) ?? [],
            ],
            'is_active' => $settings->is_active,
        ];
    }
    
    /**
     * Create or update theme settings for a store
     * 
     * @param Request $request
     * @param int $storeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateThemeSettings(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'theme_name' => 'required|string|max:255',
            'layout_style' => 'required|in:modern,classic,minimal,gaming,social',
            'site_width' => 'required|in:full,boxed,wide',
            'rtl_support' => 'boolean',
            'enable_animations' => 'boolean',
            'enable_dark_mode' => 'boolean',
            'custom_css' => 'array',
            'custom_js' => 'array',
            'google_fonts' => 'array',
            'social_links' => 'array',
            'analytics_codes' => 'array',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Deactivate other themes for this store
            DB::table('zain_theme_settings')
                ->where('store_id', $storeId)
                ->update(['is_active' => false]);
            
            // Create or update theme settings
            $themeData = [
                'store_id' => $storeId,
                'theme_name' => $request->theme_name,
                'theme_version' => $request->theme_version ?? '1.0',
                'layout_style' => $request->layout_style,
                'site_width' => $request->site_width,
                'rtl_support' => $request->rtl_support ?? true,
                'favicon' => $request->favicon,
                'logo' => $request->logo,
                'logo_dark' => $request->logo_dark,
                'mobile_logo' => $request->mobile_logo,
                'custom_css' => json_encode($request->custom_css ?? []),
                'custom_js' => json_encode($request->custom_js ?? []),
                'google_fonts' => json_encode($request->google_fonts ?? []),
                'enable_animations' => $request->enable_animations ?? true,
                'enable_dark_mode' => $request->enable_dark_mode ?? false,
                'enable_loading_screen' => $request->enable_loading_screen ?? true,
                'loading_animation' => $request->loading_animation ?? 'spinner',
                'enable_back_to_top' => $request->enable_back_to_top ?? true,
                'social_links' => json_encode($request->social_links ?? []),
                'analytics_codes' => json_encode($request->analytics_codes ?? []),
                'is_active' => true,
                'updated_at' => now(),
            ];
            
            DB::table('zain_theme_settings')->updateOrInsert(
                ['store_id' => $storeId, 'theme_name' => $request->theme_name],
                $themeData + ['created_at' => now()]
            );
            
            DB::commit();
            
            // Clear cache
            $this->clearThemeCache($storeId);
            
            return response()->json([
                'message' => 'Theme settings updated successfully',
                'theme_config' => $this->getStoreThemeConfiguration($storeId)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update theme settings'], 500);
        }
    }
    
    /**
     * Switch active theme for a store
     * This method handles theme switching without losing existing customizations
     * 
     * @param Request $request
     * @param int $storeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function switchTheme(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'theme_name' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Deactivate current theme
            DB::table('zain_theme_settings')
                ->where('store_id', $storeId)
                ->update(['is_active' => false]);
            
            // Check if theme settings exist for this theme
            $existingTheme = DB::table('zain_theme_settings')
                ->where('store_id', $storeId)
                ->where('theme_name', $request->theme_name)
                ->first();
            
            if ($existingTheme) {
                // Activate existing theme
                DB::table('zain_theme_settings')
                    ->where('id', $existingTheme->id)
                    ->update(['is_active' => true]);
            } else {
                // Create new theme with default settings
                $this->createDefaultThemeSettings($storeId, $request->theme_name);
            }
            
            DB::commit();
            
            // Clear cache
            $this->clearThemeCache($storeId);
            
            return response()->json([
                'message' => 'Theme switched successfully',
                'theme_config' => $this->getStoreThemeConfiguration($storeId)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to switch theme'], 500);
        }
    }
    
    /**
     * Get default theme configuration when no custom theme is set
     * 
     * @param int $storeId
     * @return array
     */
    private function getDefaultThemeConfiguration($storeId)
    {
        // Create default theme settings if none exist
        $this->createDefaultThemeSettings($storeId, 'default');
        
        return $this->getStoreThemeConfiguration($storeId, 'default');
    }
    
    /**
     * Create default theme settings for a store
     * 
     * @param int $storeId
     * @param string $themeName
     */
    private function createDefaultThemeSettings($storeId, $themeName = 'default')
    {
        $defaultSettings = [
            'store_id' => $storeId,
            'theme_name' => $themeName,
            'theme_version' => '1.0',
            'layout_style' => 'modern',
            'site_width' => 'full',
            'rtl_support' => true,
            'custom_css' => json_encode([]),
            'custom_js' => json_encode([]),
            'google_fonts' => json_encode([]),
            'enable_animations' => true,
            'enable_dark_mode' => false,
            'enable_loading_screen' => true,
            'loading_animation' => 'spinner',
            'enable_back_to_top' => true,
            'social_links' => json_encode([]),
            'analytics_codes' => json_encode([]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        DB::table('zain_theme_settings')->insert($defaultSettings);
    }
    
    /**
     * Clear theme cache for a store
     * 
     * @param int $storeId
     */
    private function clearThemeCache($storeId)
    {
        $patterns = [
            "store_theme_config_{$storeId}_*",
            "theme_colors_{$storeId}",
            "theme_fonts_{$storeId}",
            "theme_sections_{$storeId}",
            "theme_header_{$storeId}",
            "theme_hero_{$storeId}",
            "theme_footer_{$storeId}",
            "theme_products_{$storeId}",
            "theme_components_{$storeId}",
            "theme_layout_{$storeId}",
            "theme_media_{$storeId}",
        ];
        
        foreach ($patterns as $pattern) {
            Cache::forget($pattern);
        }
    }
    
    /**
     * Get available themes for the platform
     * This method returns all available themes that store owners can choose from
     * 
     * @return array
     */
    public function getAvailableThemes()
    {
        return [
            [
                'name' => 'default',
                'display_name' => 'Default Modern',
                'description' => 'Clean and modern design suitable for all types of stores',
                'preview_image' => '/themes/previews/default.jpg',
                'category' => 'general',
                'features' => ['responsive', 'rtl', 'dark_mode', 'animations']
            ],
            [
                'name' => 'gaming',
                'display_name' => 'Gaming Elite',
                'description' => 'Perfect for gaming accounts and UC sales with neon effects',
                'preview_image' => '/themes/previews/gaming.jpg',
                'category' => 'gaming',
                'features' => ['gaming_effects', 'neon_animations', 'particle_bg', 'leaderboards']
            ],
            [
                'name' => 'social',
                'display_name' => 'Social Media Pro',
                'description' => 'Optimized for social media account sales and subscriptions',
                'preview_image' => '/themes/previews/social.jpg',
                'category' => 'social',
                'features' => ['social_widgets', 'verification_badges', 'follower_displays']
            ],
            [
                'name' => 'minimal',
                'display_name' => 'Minimal Clean',
                'description' => 'Simple and clean design focusing on products',
                'preview_image' => '/themes/previews/minimal.jpg',
                'category' => 'general',
                'features' => ['fast_loading', 'clean_design', 'mobile_first']
            ],
            [
                'name' => 'classic',
                'display_name' => 'Classic Business',
                'description' => 'Traditional e-commerce design with trust elements',
                'preview_image' => '/themes/previews/classic.jpg',
                'category' => 'business',
                'features' => ['trust_badges', 'testimonials', 'professional_look']
            ]
        ];
    }
} 