<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * ThemeSectionController
 * 
 * This controller manages page sections for any theme activated by store owners.
 * It handles the zain_theme_sections table which contains:
 * - Section activation/deactivation per store
 * - Section ordering and positioning
 * - Section-specific settings and styling
 * - Background options, animations, and lazy loading
 * - Responsive settings for different devices
 * - Template file assignments for each section
 * 
 * Purpose: Provides dynamic section management that works across all themes.
 * Store owners can enable/disable sections, reorder them, and customize each
 * section's appearance regardless of which theme they're using.
 * 
 * This controller ensures that theme templates receive clean, ordered section
 * data without needing to handle complex database queries in blade files.
 */
class ThemeSectionController extends Controller
{
    /**
     * Get all active sections for a store, ordered by sort_order
     * This is the main method that theme templates use to render sections
     * 
     * @param int $storeId
     * @return array
     */
    public function getActiveSections($storeId)
    {
        $cacheKey = "theme_sections_{$storeId}";
        
        return Cache::remember($cacheKey, 3600, function () use ($storeId) {
            $sections = DB::table('zain_theme_sections')
                ->where('store_id', $storeId)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();
            
            if ($sections->isEmpty()) {
                $this->createDefaultSections($storeId);
                return $this->getActiveSections($storeId);
            }
            
            return $sections->map(function ($section) {
                return [
                    'id' => $section->id,
                    'section_key' => $section->section_key,
                    'section_name' => $section->section_name,
                    'section_type' => $section->section_type,
                    'description' => $section->description,
                    'sort_order' => $section->sort_order,
                    'template_file' => $section->template_file,
                    'container_type' => $section->container_type,
                    'section_class' => $section->section_class,
                    
                    // Parsed JSON settings
                    'settings' => json_decode($section->settings, true) ?? [],
                    'style_settings' => json_decode($section->style_settings, true) ?? [],
                    'content_settings' => json_decode($section->content_settings, true) ?? [],
                    'display_rules' => json_decode($section->display_rules, true) ?? [],
                    'responsive_settings' => json_decode($section->responsive_settings, true) ?? [],
                    'seo_settings' => json_decode($section->seo_settings, true) ?? [],
                    
                    // Background configuration
                    'background' => [
                        'enabled' => $section->enable_background,
                        'type' => $section->background_type,
                        'value' => $section->background_value,
                    ],
                    
                    // Animation configuration
                    'animation' => [
                        'type' => $section->animation_type,
                        'delay' => $section->animation_delay,
                        'lazy_load' => $section->lazy_load,
                    ],
                    
                    'is_required' => $section->is_required,
                ];
            })->toArray();
        });
    }
    
    /**
     * Get sections organized by type for theme customization interface
     * 
     * @param int $storeId
     * @return array
     */
    public function getSectionsByType($storeId)
    {
        $sections = DB::table('zain_theme_sections')
            ->where('store_id', $storeId)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section_type');
        
        $organized = [];
        foreach ($sections as $type => $sectionList) {
            $organized[$type] = $sectionList->map(function ($section) {
                return [
                    'id' => $section->id,
                    'section_key' => $section->section_key,
                    'section_name' => $section->section_name,
                    'description' => $section->description,
                    'is_active' => $section->is_active,
                    'is_required' => $section->is_required,
                    'sort_order' => $section->sort_order,
                    'settings' => json_decode($section->settings, true) ?? [],
                ];
            })->toArray();
        }
        
        return $organized;
    }
    
    /**
     * Update section order for a store
     * 
     * @param Request $request
     * @param int $storeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSectionOrder(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'sections' => 'required|array',
            'sections.*.id' => 'required|integer|exists:zain_theme_sections,id',
            'sections.*.sort_order' => 'required|integer|min:0',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            foreach ($request->sections as $sectionData) {
                DB::table('zain_theme_sections')
                    ->where('id', $sectionData['id'])
                    ->where('store_id', $storeId)
                    ->update([
                        'sort_order' => $sectionData['sort_order'],
                        'updated_at' => now(),
                    ]);
            }
            
            DB::commit();
            
            // Clear cache
            Cache::forget("theme_sections_{$storeId}");
            
            return response()->json([
                'message' => 'Section order updated successfully',
                'sections' => $this->getActiveSections($storeId)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update section order'], 500);
        }
    }
    
    /**
     * Toggle section activation status
     * 
     * @param Request $request
     * @param int $storeId
     * @param int $sectionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleSection(Request $request, $storeId, $sectionId)
    {
        try {
            $section = DB::table('zain_theme_sections')
                ->where('id', $sectionId)
                ->where('store_id', $storeId)
                ->first();
            
            if (!$section) {
                return response()->json(['error' => 'Section not found'], 404);
            }
            
            if ($section->is_required) {
                return response()->json(['error' => 'This section is required and cannot be disabled'], 422);
            }
            
            $newStatus = !$section->is_active;
            
            DB::table('zain_theme_sections')
                ->where('id', $sectionId)
                ->update([
                    'is_active' => $newStatus,
                    'updated_at' => now(),
                ]);
            
            // Clear cache
            Cache::forget("theme_sections_{$storeId}");
            
            return response()->json([
                'message' => $newStatus ? 'Section activated' : 'Section deactivated',
                'section_id' => $sectionId,
                'is_active' => $newStatus,
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to toggle section'], 500);
        }
    }
    
    /**
     * Update section settings
     * 
     * @param Request $request
     * @param int $storeId
     * @param int $sectionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSectionSettings(Request $request, $storeId, $sectionId)
    {
        $validator = Validator::make($request->all(), [
            'section_name' => 'string|max:255',
            'description' => 'string',
            'template_file' => 'string|max:255',
            'container_type' => 'string|in:container,full-width,boxed',
            'section_class' => 'string|max:255',
            'settings' => 'array',
            'style_settings' => 'array',
            'content_settings' => 'array',
            'responsive_settings' => 'array',
            'background_type' => 'string|in:color,image,video,gradient,none',
            'background_value' => 'string',
            'animation_type' => 'string',
            'animation_delay' => 'integer|min:0',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            $section = DB::table('zain_theme_sections')
                ->where('id', $sectionId)
                ->where('store_id', $storeId)
                ->first();
            
            if (!$section) {
                return response()->json(['error' => 'Section not found'], 404);
            }
            
            $updateData = [];
            
            if ($request->has('section_name')) {
                $updateData['section_name'] = $request->section_name;
            }
            if ($request->has('description')) {
                $updateData['description'] = $request->description;
            }
            if ($request->has('template_file')) {
                $updateData['template_file'] = $request->template_file;
            }
            if ($request->has('container_type')) {
                $updateData['container_type'] = $request->container_type;
            }
            if ($request->has('section_class')) {
                $updateData['section_class'] = $request->section_class;
            }
            if ($request->has('settings')) {
                $updateData['settings'] = json_encode($request->settings);
            }
            if ($request->has('style_settings')) {
                $updateData['style_settings'] = json_encode($request->style_settings);
            }
            if ($request->has('content_settings')) {
                $updateData['content_settings'] = json_encode($request->content_settings);
            }
            if ($request->has('responsive_settings')) {
                $updateData['responsive_settings'] = json_encode($request->responsive_settings);
            }
            if ($request->has('background_type')) {
                $updateData['background_type'] = $request->background_type;
                $updateData['enable_background'] = $request->background_type !== 'none';
            }
            if ($request->has('background_value')) {
                $updateData['background_value'] = $request->background_value;
            }
            if ($request->has('animation_type')) {
                $updateData['animation_type'] = $request->animation_type;
            }
            if ($request->has('animation_delay')) {
                $updateData['animation_delay'] = $request->animation_delay;
            }
            
            $updateData['updated_at'] = now();
            
            DB::table('zain_theme_sections')
                ->where('id', $sectionId)
                ->update($updateData);
            
            // Clear cache
            Cache::forget("theme_sections_{$storeId}");
            
            return response()->json([
                'message' => 'Section settings updated successfully',
                'section' => $this->getSectionById($sectionId, $storeId)
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update section settings'], 500);
        }
    }
    
    /**
     * Get section by ID
     * 
     * @param int $sectionId
     * @param int $storeId
     * @return array|null
     */
    private function getSectionById($sectionId, $storeId)
    {
        $section = DB::table('zain_theme_sections')
            ->where('id', $sectionId)
            ->where('store_id', $storeId)
            ->first();
        
        if (!$section) {
            return null;
        }
        
        return [
            'id' => $section->id,
            'section_key' => $section->section_key,
            'section_name' => $section->section_name,
            'section_type' => $section->section_type,
            'description' => $section->description,
            'sort_order' => $section->sort_order,
            'is_active' => $section->is_active,
            'settings' => json_decode($section->settings, true) ?? [],
            'style_settings' => json_decode($section->style_settings, true) ?? [],
            'content_settings' => json_decode($section->content_settings, true) ?? [],
        ];
    }
    
    /**
     * Create default sections for a new store
     * These are the essential sections that most themes will need
     * 
     * @param int $storeId
     */
    private function createDefaultSections($storeId)
    {
        $defaultSections = [
            [
                'store_id' => $storeId,
                'section_key' => 'header',
                'section_name' => 'Header',
                'section_type' => 'header',
                'description' => 'Site header with navigation and logo',
                'sort_order' => 10,
                'is_active' => true,
                'is_required' => true,
                'template_file' => 'sections.header',
                'container_type' => 'full-width',
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'hero',
                'section_name' => 'Hero Section',
                'section_type' => 'hero',
                'description' => 'Main hero banner or slider',
                'sort_order' => 20,
                'is_active' => true,
                'is_required' => false,
                'template_file' => 'sections.hero',
                'container_type' => 'full-width',
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'featured_products',
                'section_name' => 'Featured Products',
                'section_type' => 'products',
                'description' => 'Display featured products',
                'sort_order' => 30,
                'is_active' => true,
                'is_required' => false,
                'template_file' => 'sections.featured-products',
                'container_type' => 'container',
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'categories',
                'section_name' => 'Categories',
                'section_type' => 'categories',
                'description' => 'Product categories showcase',
                'sort_order' => 40,
                'is_active' => true,
                'is_required' => false,
                'template_file' => 'sections.categories',
                'container_type' => 'container',
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'testimonials',
                'section_name' => 'Customer Reviews',
                'section_type' => 'testimonials',
                'description' => 'Customer testimonials and reviews',
                'sort_order' => 50,
                'is_active' => false,
                'is_required' => false,
                'template_file' => 'sections.testimonials',
                'container_type' => 'container',
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'footer',
                'section_name' => 'Footer',
                'section_type' => 'footer',
                'description' => 'Site footer with links and information',
                'sort_order' => 100,
                'is_active' => true,
                'is_required' => true,
                'template_file' => 'sections.footer',
                'container_type' => 'full-width',
            ],
        ];
        
        foreach ($defaultSections as $section) {
            $section['settings'] = json_encode([]);
            $section['style_settings'] = json_encode([]);
            $section['content_settings'] = json_encode([]);
            $section['created_at'] = now();
            $section['updated_at'] = now();
            
            DB::table('zain_theme_sections')->insert($section);
        }
    }
    
    /**
     * Get available section types for adding new sections
     * 
     * @return array
     */
    public function getAvailableSectionTypes()
    {
        return [
            'header' => [
                'name' => 'Header',
                'description' => 'Site header with navigation',
                'icon' => 'header',
                'category' => 'layout'
            ],
            'hero' => [
                'name' => 'Hero Section',
                'description' => 'Main banner or slider',
                'icon' => 'image',
                'category' => 'content'
            ],
            'products' => [
                'name' => 'Products',
                'description' => 'Product listings and showcases',
                'icon' => 'shopping-bag',
                'category' => 'ecommerce'
            ],
            'categories' => [
                'name' => 'Categories',
                'description' => 'Product category displays',
                'icon' => 'grid',
                'category' => 'ecommerce'
            ],
            'testimonials' => [
                'name' => 'Testimonials',
                'description' => 'Customer reviews and feedback',
                'icon' => 'star',
                'category' => 'social-proof'
            ],
            'features' => [
                'name' => 'Features',
                'description' => 'Service features and benefits',
                'icon' => 'check-circle',
                'category' => 'content'
            ],
            'contact' => [
                'name' => 'Contact',
                'description' => 'Contact forms and information',
                'icon' => 'mail',
                'category' => 'utility'
            ],
            'newsletter' => [
                'name' => 'Newsletter',
                'description' => 'Email subscription forms',
                'icon' => 'send',
                'category' => 'marketing'
            ],
            'footer' => [
                'name' => 'Footer',
                'description' => 'Site footer with links',
                'icon' => 'layout',
                'category' => 'layout'
            ],
        ];
    }
} 