<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * ThemeColorController
 * 
 * This controller manages color schemes for any theme activated by store owners.
 * It handles the zain_theme_colors table which contains:
 * - Primary, secondary, accent colors
 * - Background and surface colors
 * - Text colors (primary, secondary, muted)
 * - UI element colors (buttons, links, borders)
 * - Status colors (success, warning, error, info)
 * - Header, footer, sidebar specific colors
 * - Gradient combinations and custom CSS properties
 * 
 * Purpose: Provides centralized color management for all themes. When a store owner
 * customizes colors, this controller ensures the color scheme works across all
 * theme templates without requiring template-specific color handling.
 * 
 * The controller generates CSS custom properties and provides color data
 * in formats ready for use in any theme template (gaming, social, minimal, etc.)
 */
class ThemeColorController extends Controller
{
    /**
     * Get complete color scheme configuration for a store
     * Returns colors formatted for CSS custom properties and theme templates
     * 
     * @param int $storeId
     * @param string|null $schemeName
     * @return array
     */
    public function getStoreColorScheme($storeId, $schemeName = null)
    {
        $cacheKey = "theme_colors_{$storeId}_" . ($schemeName ?? 'active');
        
        return Cache::remember($cacheKey, 3600, function () use ($storeId, $schemeName) {
            $colors = $this->getActiveColorScheme($storeId, $schemeName);
            
            if (!$colors) {
                $colors = $this->createDefaultColorScheme($storeId);
            }
            
            return [
                'scheme_info' => [
                    'id' => $colors->id,
                    'scheme_name' => $colors->scheme_name,
                    'is_default' => $colors->is_default,
                    'is_active' => $colors->is_active,
                ],
                'brand_colors' => [
                    'primary' => $colors->primary_color,
                    'secondary' => $colors->secondary_color,
                    'accent' => $colors->accent_color,
                ],
                'background_colors' => [
                    'main' => $colors->background_color,
                    'surface' => $colors->surface_color,
                    'hover' => $colors->hover_color,
                ],
                'text_colors' => [
                    'primary' => $colors->text_primary,
                    'secondary' => $colors->text_secondary,
                    'muted' => $colors->text_muted,
                ],
                'ui_colors' => [
                    'border' => $colors->border_color,
                    'button_primary' => $colors->button_primary,
                    'button_secondary' => $colors->button_secondary,
                    'button_text' => $colors->button_text,
                    'link' => $colors->link_color,
                    'link_hover' => $colors->link_hover,
                ],
                'status_colors' => [
                    'success' => $colors->success_color,
                    'warning' => $colors->warning_color,
                    'error' => $colors->error_color,
                    'info' => $colors->info_color,
                ],
                'layout_colors' => [
                    'header_bg' => $colors->header_bg,
                    'header_text' => $colors->header_text,
                    'footer_bg' => $colors->footer_bg,
                    'footer_text' => $colors->footer_text,
                    'sidebar_bg' => $colors->sidebar_bg,
                    'sidebar_text' => $colors->sidebar_text,
                ],
                'gradients' => json_decode($colors->gradient_colors, true) ?? [],
                'custom_properties' => json_decode($colors->custom_properties, true) ?? [],
                'css_variables' => $this->generateCSSVariables($colors),
                'tailwind_colors' => $this->generateTailwindColors($colors),
            ];
        });
    }
    
    /**
     * Get active color scheme for a store
     * 
     * @param int $storeId
     * @param string|null $schemeName
     * @return \stdClass|null
     */
    private function getActiveColorScheme($storeId, $schemeName = null)
    {
        $query = DB::table('zain_theme_colors')->where('store_id', $storeId);
        
        if ($schemeName) {
            $query->where('scheme_name', $schemeName);
        } else {
            $query->where('is_active', true);
        }
        
        return $query->first();
    }
    
    /**
     * Update color scheme for a store
     * 
     * @param Request $request
     * @param int $storeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateColorScheme(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'scheme_name' => 'required|string|max:255',
            'primary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'string|regex:/^#[0-9A-Fa-f]{6}$/',
            'background_color' => 'string|regex:/^#[0-9A-Fa-f]{6}$/',
            'surface_color' => 'string|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_primary' => 'string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Deactivate other color schemes
            DB::table('zain_theme_colors')
                ->where('store_id', $storeId)
                ->update(['is_active' => false]);
            
            $colorData = [
                'store_id' => $storeId,
                'scheme_name' => $request->scheme_name,
                'primary_color' => $request->primary_color,
                'secondary_color' => $request->secondary_color,
                'accent_color' => $request->accent_color ?? '#4CAF50',
                'background_color' => $request->background_color ?? '#121212',
                'surface_color' => $request->surface_color ?? '#1e1e1e',
                'text_primary' => $request->text_primary ?? '#ffffff',
                'text_secondary' => $request->text_secondary ?? '#b3b3b3',
                'text_muted' => $request->text_muted ?? '#666666',
                'border_color' => $request->border_color ?? '#333333',
                'hover_color' => $request->hover_color ?? '#2c2c2c',
                'success_color' => $request->success_color ?? '#4CAF50',
                'warning_color' => $request->warning_color ?? '#FF9800',
                'error_color' => $request->error_color ?? '#F44336',
                'info_color' => $request->info_color ?? '#2196F3',
                'button_primary' => $request->button_primary ?? $request->primary_color,
                'button_secondary' => $request->button_secondary ?? '#6c757d',
                'button_text' => $request->button_text ?? '#ffffff',
                'link_color' => $request->link_color ?? $request->primary_color,
                'link_hover' => $request->link_hover ?? $this->darkenColor($request->primary_color, 10),
                'header_bg' => $request->header_bg ?? '#1e1e1e',
                'header_text' => $request->header_text ?? '#ffffff',
                'footer_bg' => $request->footer_bg ?? '#121212',
                'footer_text' => $request->footer_text ?? '#b3b3b3',
                'sidebar_bg' => $request->sidebar_bg ?? '#1e1e1e',
                'sidebar_text' => $request->sidebar_text ?? '#ffffff',
                'gradient_colors' => json_encode($request->gradient_colors ?? []),
                'custom_properties' => json_encode($request->custom_properties ?? []),
                'is_default' => $request->is_default ?? false,
                'is_active' => true,
                'updated_at' => now(),
            ];
            
            DB::table('zain_theme_colors')->updateOrInsert(
                ['store_id' => $storeId, 'scheme_name' => $request->scheme_name],
                $colorData + ['created_at' => now()]
            );
            
            DB::commit();
            
            // Clear cache
            Cache::forget("theme_colors_{$storeId}_" . $request->scheme_name);
            Cache::forget("theme_colors_{$storeId}_active");
            
            return response()->json([
                'message' => 'Color scheme updated successfully',
                'colors' => $this->getStoreColorScheme($storeId)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update color scheme'], 500);
        }
    }
    
    /**
     * Generate CSS custom properties from color scheme
     * These variables can be used in any theme template
     * 
     * @param \stdClass $colors
     * @return array
     */
    private function generateCSSVariables($colors)
    {
        return [
            '--color-primary' => $colors->primary_color,
            '--color-secondary' => $colors->secondary_color,
            '--color-accent' => $colors->accent_color,
            '--color-background' => $colors->background_color,
            '--color-surface' => $colors->surface_color,
            '--color-text-primary' => $colors->text_primary,
            '--color-text-secondary' => $colors->text_secondary,
            '--color-text-muted' => $colors->text_muted,
            '--color-border' => $colors->border_color,
            '--color-hover' => $colors->hover_color,
            '--color-success' => $colors->success_color,
            '--color-warning' => $colors->warning_color,
            '--color-error' => $colors->error_color,
            '--color-info' => $colors->info_color,
            '--color-button-primary' => $colors->button_primary,
            '--color-button-secondary' => $colors->button_secondary,
            '--color-button-text' => $colors->button_text,
            '--color-link' => $colors->link_color,
            '--color-link-hover' => $colors->link_hover,
            '--color-header-bg' => $colors->header_bg,
            '--color-header-text' => $colors->header_text,
            '--color-footer-bg' => $colors->footer_bg,
            '--color-footer-text' => $colors->footer_text,
            '--color-sidebar-bg' => $colors->sidebar_bg,
            '--color-sidebar-text' => $colors->sidebar_text,
            
            // RGB values for transparency usage
            '--color-primary-rgb' => $this->hexToRgb($colors->primary_color),
            '--color-secondary-rgb' => $this->hexToRgb($colors->secondary_color),
            '--color-background-rgb' => $this->hexToRgb($colors->background_color),
        ];
    }
    
    /**
     * Generate Tailwind color configuration
     * Useful for themes that use Tailwind CSS
     * 
     * @param \stdClass $colors
     * @return array
     */
    private function generateTailwindColors($colors)
    {
        return [
            'primary' => [
                '50' => $this->lightenColor($colors->primary_color, 40),
                '100' => $this->lightenColor($colors->primary_color, 30),
                '200' => $this->lightenColor($colors->primary_color, 20),
                '300' => $this->lightenColor($colors->primary_color, 10),
                '400' => $this->lightenColor($colors->primary_color, 5),
                '500' => $colors->primary_color,
                '600' => $this->darkenColor($colors->primary_color, 5),
                '700' => $this->darkenColor($colors->primary_color, 10),
                '800' => $this->darkenColor($colors->primary_color, 20),
                '900' => $this->darkenColor($colors->primary_color, 30),
            ],
            'secondary' => [
                '50' => $this->lightenColor($colors->secondary_color, 40),
                '100' => $this->lightenColor($colors->secondary_color, 30),
                '200' => $this->lightenColor($colors->secondary_color, 20),
                '300' => $this->lightenColor($colors->secondary_color, 10),
                '400' => $this->lightenColor($colors->secondary_color, 5),
                '500' => $colors->secondary_color,
                '600' => $this->darkenColor($colors->secondary_color, 5),
                '700' => $this->darkenColor($colors->secondary_color, 10),
                '800' => $this->darkenColor($colors->secondary_color, 20),
                '900' => $this->darkenColor($colors->secondary_color, 30),
            ],
        ];
    }
    
    /**
     * Create default color scheme for a store
     * 
     * @param int $storeId
     * @return \stdClass
     */
    private function createDefaultColorScheme($storeId)
    {
        $defaultColors = [
            'store_id' => $storeId,
            'scheme_name' => 'default',
            'primary_color' => '#2196F3',
            'secondary_color' => '#FF5722',
            'accent_color' => '#4CAF50',
            'background_color' => '#121212',
            'surface_color' => '#1e1e1e',
            'text_primary' => '#ffffff',
            'text_secondary' => '#b3b3b3',
            'text_muted' => '#666666',
            'border_color' => '#333333',
            'hover_color' => '#2c2c2c',
            'success_color' => '#4CAF50',
            'warning_color' => '#FF9800',
            'error_color' => '#F44336',
            'info_color' => '#2196F3',
            'button_primary' => '#2196F3',
            'button_secondary' => '#6c757d',
            'button_text' => '#ffffff',
            'link_color' => '#2196F3',
            'link_hover' => '#1976D2',
            'header_bg' => '#1e1e1e',
            'header_text' => '#ffffff',
            'footer_bg' => '#121212',
            'footer_text' => '#b3b3b3',
            'sidebar_bg' => '#1e1e1e',
            'sidebar_text' => '#ffffff',
            'gradient_colors' => json_encode([]),
            'custom_properties' => json_encode([]),
            'is_default' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        DB::table('zain_theme_colors')->insert($defaultColors);
        
        return (object) $defaultColors;
    }
    
    /**
     * Get predefined color schemes for different theme types
     * These are starter templates that store owners can choose from
     * 
     * @return array
     */
    public function getPredefinedColorSchemes()
    {
        return [
            'gaming_dark' => [
                'name' => 'Gaming Dark',
                'primary_color' => '#00FF88',
                'secondary_color' => '#FF0080',
                'accent_color' => '#00FFFF',
                'background_color' => '#0A0A0A',
                'surface_color' => '#1A1A2E',
                'text_primary' => '#FFFFFF',
            ],
            'gaming_neon' => [
                'name' => 'Gaming Neon',
                'primary_color' => '#FF6B35',
                'secondary_color' => '#00F5FF',
                'accent_color' => '#FFFF00',
                'background_color' => '#16213E',
                'surface_color' => '#0F3460',
                'text_primary' => '#FFFFFF',
            ],
            'social_modern' => [
                'name' => 'Social Modern',
                'primary_color' => '#E1306C',
                'secondary_color' => '#405DE6',
                'accent_color' => '#FFDC80',
                'background_color' => '#FAFAFA',
                'surface_color' => '#FFFFFF',
                'text_primary' => '#262626',
            ],
            'social_dark' => [
                'name' => 'Social Dark',
                'primary_color' => '#1DA1F2',
                'secondary_color' => '#FF1744',
                'accent_color' => '#00E676',
                'background_color' => '#15202B',
                'surface_color' => '#192734',
                'text_primary' => '#FFFFFF',
            ],
            'minimal_light' => [
                'name' => 'Minimal Light',
                'primary_color' => '#667EEA',
                'secondary_color' => '#764BA2',
                'accent_color' => '#F093FB',
                'background_color' => '#FFFFFF',
                'surface_color' => '#F8F9FA',
                'text_primary' => '#212529',
            ],
            'business_professional' => [
                'name' => 'Business Professional',
                'primary_color' => '#2C3E50',
                'secondary_color' => '#3498DB',
                'accent_color' => '#E74C3C',
                'background_color' => '#FFFFFF',
                'surface_color' => '#ECF0F1',
                'text_primary' => '#2C3E50',
            ],
        ];
    }
    
    /**
     * Helper function to convert hex color to RGB
     * 
     * @param string $hex
     * @return string
     */
    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        return "{$r}, {$g}, {$b}";
    }
    
    /**
     * Helper function to lighten a color
     * 
     * @param string $hex
     * @param int $percent
     * @return string
     */
    private function lightenColor($hex, $percent)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r = min(255, $r + ($percent * 255 / 100));
        $g = min(255, $g + ($percent * 255 / 100));
        $b = min(255, $b + ($percent * 255 / 100));
        
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
    
    /**
     * Helper function to darken a color
     * 
     * @param string $hex
     * @param int $percent
     * @return string
     */
    private function darkenColor($hex, $percent)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r = max(0, $r - ($percent * 255 / 100));
        $g = max(0, $g - ($percent * 255 / 100));
        $b = max(0, $b - ($percent * 255 / 100));
        
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
} 