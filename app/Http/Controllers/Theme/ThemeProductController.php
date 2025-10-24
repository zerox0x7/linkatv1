<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * ThemeProductController
 * 
 * This controller manages product display settings for any theme activated by store owners.
 * It handles the zain_theme_products table which contains:
 * - Product grid layouts and card designs
 * - Gaming-specific product features (platform, genre, account level, region)
 * - Social media account features (follower count, verification badges, engagement rate)
 * - Product filtering, sorting, and search configurations
 * - Mobile optimizations and responsive settings
 * - E-commerce features (wishlist, quick view, compare, etc.)
 * 
 * Purpose: Provides specialized product display management for digital product stores.
 * Whether selling gaming accounts, social media accounts, UC game currency, or
 * subscription tools, this controller ensures products are displayed optimally
 * for the specific product type while maintaining consistency across themes.
 * 
 * The controller prepares product display data in a format that any theme can
 * consume without needing theme-specific product handling logic.
 */
class ThemeProductController extends Controller
{
    /**
     * Get complete product display settings for a store
     * This method provides all configuration needed to display products
     * in any theme template
     * 
     * @param int $storeId
     * @return array
     */
    public function getProductDisplaySettings($storeId)
    {
        $cacheKey = "theme_products_{$storeId}";
        
        return Cache::remember($cacheKey, 3600, function () use ($storeId) {
            $settings = $this->getActiveProductSettings($storeId);
            
            if (!$settings) {
                $settings = $this->createDefaultProductSettings($storeId);
            }
            
            return [
                'layout' => [
                    'style' => $settings->products_layout,
                    'per_row_desktop' => $settings->products_per_row_desktop,
                    'per_row_tablet' => $settings->products_per_row_tablet,
                    'per_row_mobile' => $settings->products_per_row_mobile,
                    'per_page' => $settings->products_per_page,
                    'spacing' => $settings->products_spacing,
                ],
                'card_design' => [
                    'style' => $settings->card_style,
                    'hover_effect' => $settings->card_hover_effect,
                    'show_badges' => $settings->show_product_badges,
                    'show_wishlist' => $settings->show_wishlist_button,
                    'show_quick_view' => $settings->show_quick_view,
                    'show_compare' => $settings->show_compare_button,
                ],
                'product_info' => [
                    'show_title' => $settings->show_product_title,
                    'show_price' => $settings->show_product_price,
                    'show_old_price' => $settings->show_old_price,
                    'show_rating' => $settings->show_product_rating,
                    'show_reviews_count' => $settings->show_product_reviews_count,
                    'show_category' => $settings->show_product_category,
                    'show_description' => $settings->show_product_description,
                    'show_attributes' => $settings->show_product_attributes,
                    'show_availability' => $settings->show_availability_status,
                ],
                'images' => [
                    'aspect_ratio' => $settings->image_aspect_ratio,
                    'lazy_loading' => $settings->enable_image_lazy_loading,
                    'multiple_images' => $settings->show_multiple_images,
                    'zoom' => $settings->enable_image_zoom,
                    'border_radius' => $settings->image_border_radius,
                ],
                'actions' => [
                    'cart_style' => $settings->add_to_cart_style,
                    'button_size' => $settings->button_size,
                    'quantity_selector' => $settings->show_quantity_selector,
                    'ajax_cart' => $settings->enable_ajax_cart,
                    'cart_button_text' => $settings->cart_button_text,
                    'out_of_stock_text' => $settings->out_of_stock_text,
                ],
                'filtering' => [
                    'enabled' => $settings->enable_filters,
                    'available_filters' => json_decode($settings->available_filters, true) ?? $this->getDefaultFilters(),
                    'style' => $settings->filter_style,
                    'sorting_enabled' => $settings->enable_sorting,
                    'sorting_options' => json_decode($settings->sorting_options, true) ?? $this->getDefaultSortingOptions(),
                    'default_sort' => $settings->default_sort,
                ],
                'search' => [
                    'enabled' => $settings->enable_search,
                    'autocomplete' => $settings->enable_search_autocomplete,
                    'suggestions' => $settings->enable_search_suggestions,
                    'results_per_page' => $settings->search_results_per_page,
                ],
                'categories' => [
                    'show_filter' => $settings->show_categories_filter,
                    'style' => $settings->categories_style,
                    'show_images' => $settings->enable_category_images,
                    'show_count' => $settings->show_category_product_count,
                ],
                'special_sections' => [
                    'featured' => $settings->enable_featured_products,
                    'trending' => $settings->enable_trending_products,
                    'new_arrivals' => $settings->enable_new_arrivals,
                    'sale' => $settings->enable_sale_products,
                    'recently_viewed' => $settings->enable_recently_viewed,
                    'related' => $settings->enable_related_products,
                ],
                'gaming_features' => [
                    'show_platform' => $settings->show_game_platform,
                    'show_genre' => $settings->show_game_genre,
                    'show_account_level' => $settings->show_account_level,
                    'show_region' => $settings->show_account_region,
                ],
                'social_features' => [
                    'show_follower_count' => $settings->show_follower_count,
                    'show_verification' => $settings->show_verification_badge,
                    'show_account_age' => $settings->show_account_age,
                    'show_engagement' => $settings->show_engagement_rate,
                ],
                'pagination' => [
                    'style' => $settings->pagination_style,
                    'show_info' => $settings->show_page_info,
                ],
                'mobile' => [
                    'enable_filters' => $settings->enable_mobile_filters,
                    'filter_style' => $settings->mobile_filter_style,
                    'sticky_cart' => $settings->mobile_sticky_cart,
                ],
                'performance' => [
                    'caching' => $settings->enable_caching,
                    'cache_duration' => $settings->cache_duration,
                    'infinite_scroll' => $settings->enable_infinite_scroll,
                ],
                'custom_settings' => json_decode($settings->custom_settings, true) ?? [],
            ];
        });
    }
    
    /**
     * Get active product settings for a store
     * 
     * @param int $storeId
     * @return \stdClass|null
     */
    private function getActiveProductSettings($storeId)
    {
        return DB::table('zain_theme_products')
            ->where('store_id', $storeId)
            ->where('is_active', true)
            ->first();
    }
    
    /**
     * Update product display settings
     * 
     * @param Request $request
     * @param int $storeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductSettings(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'products_layout' => 'string|in:grid,list,masonry,carousel',
            'products_per_row_desktop' => 'integer|min:1|max:6',
            'products_per_row_tablet' => 'integer|min:1|max:4',
            'products_per_row_mobile' => 'integer|min:1|max:2',
            'products_per_page' => 'integer|min:8|max:100',
            'card_style' => 'string|in:modern,classic,minimal,gaming,social',
            'card_hover_effect' => 'string|in:lift,zoom,fade,glow,none',
            'image_aspect_ratio' => 'string|in:square,landscape,portrait,auto',
            'add_to_cart_style' => 'string|in:button,icon,text',
            'button_size' => 'string|in:small,medium,large',
            'filter_style' => 'string|in:sidebar,top,modal,dropdown',
            'categories_style' => 'string|in:tree,list,tags,grid',
            'pagination_style' => 'string|in:numbers,load_more,infinite_scroll',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Deactivate other product settings
            DB::table('zain_theme_products')
                ->where('store_id', $storeId)
                ->update(['is_active' => false]);
            
            $productData = [
                'store_id' => $storeId,
                'products_layout' => $request->products_layout ?? 'grid',
                'products_per_row_desktop' => $request->products_per_row_desktop ?? 4,
                'products_per_row_tablet' => $request->products_per_row_tablet ?? 3,
                'products_per_row_mobile' => $request->products_per_row_mobile ?? 2,
                'products_per_page' => $request->products_per_page ?? 16,
                'products_spacing' => $request->products_spacing ?? 'normal',
                'card_style' => $request->card_style ?? 'modern',
                'card_hover_effect' => $request->card_hover_effect ?? 'lift',
                'show_product_badges' => $request->show_product_badges ?? true,
                'show_wishlist_button' => $request->show_wishlist_button ?? true,
                'show_quick_view' => $request->show_quick_view ?? true,
                'show_compare_button' => $request->show_compare_button ?? false,
                'show_product_title' => $request->show_product_title ?? true,
                'show_product_price' => $request->show_product_price ?? true,
                'show_old_price' => $request->show_old_price ?? true,
                'show_product_rating' => $request->show_product_rating ?? true,
                'show_product_reviews_count' => $request->show_product_reviews_count ?? true,
                'show_product_category' => $request->show_product_category ?? true,
                'show_product_description' => $request->show_product_description ?? false,
                'show_product_attributes' => $request->show_product_attributes ?? true,
                'show_availability_status' => $request->show_availability_status ?? true,
                'image_aspect_ratio' => $request->image_aspect_ratio ?? 'square',
                'enable_image_lazy_loading' => $request->enable_image_lazy_loading ?? true,
                'show_multiple_images' => $request->show_multiple_images ?? true,
                'enable_image_zoom' => $request->enable_image_zoom ?? false,
                'image_border_radius' => $request->image_border_radius ?? '8px',
                'add_to_cart_style' => $request->add_to_cart_style ?? 'button',
                'button_size' => $request->button_size ?? 'medium',
                'show_quantity_selector' => $request->show_quantity_selector ?? false,
                'enable_ajax_cart' => $request->enable_ajax_cart ?? true,
                'cart_button_text' => $request->cart_button_text ?? 'إضافة للسلة',
                'out_of_stock_text' => $request->out_of_stock_text ?? 'نفذت الكمية',
                'enable_filters' => $request->enable_filters ?? true,
                'available_filters' => json_encode($request->available_filters ?? $this->getDefaultFilters()),
                'filter_style' => $request->filter_style ?? 'sidebar',
                'enable_sorting' => $request->enable_sorting ?? true,
                'sorting_options' => json_encode($request->sorting_options ?? $this->getDefaultSortingOptions()),
                'default_sort' => $request->default_sort ?? 'popularity',
                'enable_search' => $request->enable_search ?? true,
                'enable_search_autocomplete' => $request->enable_search_autocomplete ?? true,
                'enable_search_suggestions' => $request->enable_search_suggestions ?? true,
                'search_results_per_page' => $request->search_results_per_page ?? 12,
                'show_categories_filter' => $request->show_categories_filter ?? true,
                'categories_style' => $request->categories_style ?? 'tree',
                'enable_category_images' => $request->enable_category_images ?? true,
                'show_category_product_count' => $request->show_category_product_count ?? true,
                
                // Gaming-specific features
                'show_game_platform' => $request->show_game_platform ?? true,
                'show_game_genre' => $request->show_game_genre ?? true,
                'show_account_level' => $request->show_account_level ?? true,
                'show_account_region' => $request->show_account_region ?? true,
                
                // Social media-specific features
                'show_follower_count' => $request->show_follower_count ?? true,
                'show_verification_badge' => $request->show_verification_badge ?? true,
                'show_account_age' => $request->show_account_age ?? true,
                'show_engagement_rate' => $request->show_engagement_rate ?? false,
                
                // Special sections
                'enable_featured_products' => $request->enable_featured_products ?? true,
                'enable_trending_products' => $request->enable_trending_products ?? true,
                'enable_new_arrivals' => $request->enable_new_arrivals ?? true,
                'enable_sale_products' => $request->enable_sale_products ?? true,
                'enable_recently_viewed' => $request->enable_recently_viewed ?? true,
                'enable_related_products' => $request->enable_related_products ?? true,
                
                'pagination_style' => $request->pagination_style ?? 'numbers',
                'show_page_info' => $request->show_page_info ?? true,
                'enable_mobile_filters' => $request->enable_mobile_filters ?? true,
                'mobile_filter_style' => $request->mobile_filter_style ?? 'bottom_sheet',
                'mobile_sticky_cart' => $request->mobile_sticky_cart ?? false,
                'enable_caching' => $request->enable_caching ?? true,
                'cache_duration' => $request->cache_duration ?? 3600,
                'enable_infinite_scroll' => $request->enable_infinite_scroll ?? false,
                'custom_settings' => json_encode($request->custom_settings ?? []),
                'is_active' => true,
                'updated_at' => now(),
            ];
            
            DB::table('zain_theme_products')->updateOrInsert(
                ['store_id' => $storeId],
                $productData + ['created_at' => now()]
            );
            
            DB::commit();
            
            // Clear cache
            Cache::forget("theme_products_{$storeId}");
            
            return response()->json([
                'message' => 'Product display settings updated successfully',
                'settings' => $this->getProductDisplaySettings($storeId)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update product settings'], 500);
        }
    }
    
    /**
     * Create default product settings for a store
     * 
     * @param int $storeId
     * @return \stdClass
     */
    private function createDefaultProductSettings($storeId)
    {
        $defaultSettings = [
            'store_id' => $storeId,
            'products_layout' => 'grid',
            'products_per_row_desktop' => 4,
            'products_per_row_tablet' => 3,
            'products_per_row_mobile' => 2,
            'products_per_page' => 16,
            'products_spacing' => 'normal',
            'card_style' => 'modern',
            'card_hover_effect' => 'lift',
            'show_product_badges' => true,
            'show_wishlist_button' => true,
            'show_quick_view' => true,
            'show_compare_button' => false,
            'show_product_title' => true,
            'show_product_price' => true,
            'show_old_price' => true,
            'show_product_rating' => true,
            'show_product_reviews_count' => true,
            'show_product_category' => true,
            'show_product_description' => false,
            'show_product_attributes' => true,
            'show_availability_status' => true,
            'image_aspect_ratio' => 'square',
            'enable_image_lazy_loading' => true,
            'show_multiple_images' => true,
            'enable_image_zoom' => false,
            'image_border_radius' => '8px',
            'add_to_cart_style' => 'button',
            'button_size' => 'medium',
            'show_quantity_selector' => false,
            'enable_ajax_cart' => true,
            'cart_button_text' => 'إضافة للسلة',
            'out_of_stock_text' => 'نفذت الكمية',
            'enable_filters' => true,
            'available_filters' => json_encode($this->getDefaultFilters()),
            'filter_style' => 'sidebar',
            'enable_sorting' => true,
            'sorting_options' => json_encode($this->getDefaultSortingOptions()),
            'default_sort' => 'popularity',
            'enable_search' => true,
            'enable_search_autocomplete' => true,
            'enable_search_suggestions' => true,
            'search_results_per_page' => 12,
            'show_categories_filter' => true,
            'categories_style' => 'tree',
            'enable_category_images' => true,
            'show_category_product_count' => true,
            'enable_featured_products' => true,
            'enable_trending_products' => true,
            'enable_new_arrivals' => true,
            'enable_sale_products' => true,
            'enable_recently_viewed' => true,
            'enable_related_products' => true,
            'show_game_platform' => true,
            'show_game_genre' => true,
            'show_account_level' => true,
            'show_account_region' => true,
            'show_follower_count' => true,
            'show_verification_badge' => true,
            'show_account_age' => true,
            'show_engagement_rate' => false,
            'pagination_style' => 'numbers',
            'show_page_info' => true,
            'enable_mobile_filters' => true,
            'mobile_filter_style' => 'bottom_sheet',
            'mobile_sticky_cart' => false,
            'enable_caching' => true,
            'cache_duration' => 3600,
            'enable_infinite_scroll' => false,
            'custom_settings' => json_encode([]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        DB::table('zain_theme_products')->insert($defaultSettings);
        
        return (object) $defaultSettings;
    }
    
    /**
     * Get default filter options
     * These filters are optimized for digital product stores
     * 
     * @return array
     */
    private function getDefaultFilters()
    {
        return [
            'price' => [
                'enabled' => true,
                'type' => 'range',
                'label' => 'السعر',
                'ranges' => [
                    ['min' => 0, 'max' => 50, 'label' => 'أقل من 50 ر.س'],
                    ['min' => 50, 'max' => 100, 'label' => '50 - 100 ر.س'],
                    ['min' => 100, 'max' => 200, 'label' => '100 - 200 ر.س'],
                    ['min' => 200, 'max' => 500, 'label' => '200 - 500 ر.س'],
                    ['min' => 500, 'max' => null, 'label' => 'أكثر من 500 ر.س'],
                ]
            ],
            'category' => [
                'enabled' => true,
                'type' => 'checkbox',
                'label' => 'الفئة',
            ],
            'platform' => [
                'enabled' => true,
                'type' => 'checkbox',
                'label' => 'المنصة',
                'options' => ['PS5', 'PS4', 'Xbox', 'PC', 'Mobile', 'Nintendo Switch']
            ],
            'region' => [
                'enabled' => true,
                'type' => 'checkbox',
                'label' => 'المنطقة',
                'options' => ['السعودية', 'الخليج', 'العالم العربي', 'عالمي']
            ],
            'verification_status' => [
                'enabled' => true,
                'type' => 'checkbox',
                'label' => 'حالة التوثيق',
                'options' => ['موثق', 'غير موثق']
            ],
            'follower_range' => [
                'enabled' => true,
                'type' => 'checkbox',
                'label' => 'عدد المتابعين',
                'options' => ['أقل من 1K', '1K - 10K', '10K - 100K', '100K - 1M', 'أكثر من 1M']
            ],
            'availability' => [
                'enabled' => true,
                'type' => 'checkbox',
                'label' => 'التوفر',
                'options' => ['متوفر', 'نفذت الكمية', 'قريباً']
            ],
            'rating' => [
                'enabled' => true,
                'type' => 'rating',
                'label' => 'التقييم',
                'min_rating' => 1
            ]
        ];
    }
    
    /**
     * Get default sorting options
     * 
     * @return array
     */
    private function getDefaultSortingOptions()
    {
        return [
            'popularity' => [
                'label' => 'الأكثر شعبية',
                'field' => 'popularity_score',
                'direction' => 'desc'
            ],
            'newest' => [
                'label' => 'الأحدث',
                'field' => 'created_at',
                'direction' => 'desc'
            ],
            'price_low' => [
                'label' => 'السعر: من الأقل للأعلى',
                'field' => 'price',
                'direction' => 'asc'
            ],
            'price_high' => [
                'label' => 'السعر: من الأعلى للأقل',
                'field' => 'price',
                'direction' => 'desc'
            ],
            'rating' => [
                'label' => 'الأعلى تقييماً',
                'field' => 'average_rating',
                'direction' => 'desc'
            ],
            'name_asc' => [
                'label' => 'الاسم: أ - ي',
                'field' => 'name',
                'direction' => 'asc'
            ],
            'name_desc' => [
                'label' => 'الاسم: ي - أ',
                'field' => 'name',
                'direction' => 'desc'
            ]
        ];
    }
    
    /**
     * Get product display presets for different store types
     * These presets optimize product display for specific business models
     * 
     * @return array
     */
    public function getProductDisplayPresets()
    {
        return [
            'gaming_accounts' => [
                'name' => 'حسابات الألعاب',
                'description' => 'مُحسن لعرض حسابات الألعاب مع المنصة والمستوى',
                'settings' => [
                    'card_style' => 'gaming',
                    'show_game_platform' => true,
                    'show_account_level' => true,
                    'show_account_region' => true,
                    'products_per_row_desktop' => 4,
                    'enable_quick_view' => true,
                ]
            ],
            'social_media' => [
                'name' => 'حسابات التواصل الاجتماعي',
                'description' => 'مُحسن لعرض حسابات السوشيال ميديا مع المتابعين والتوثيق',
                'settings' => [
                    'card_style' => 'social',
                    'show_follower_count' => true,
                    'show_verification_badge' => true,
                    'show_account_age' => true,
                    'products_per_row_desktop' => 3,
                ]
            ],
            'digital_products' => [
                'name' => 'المنتجات الرقمية',
                'description' => 'مُحسن للمنتجات الرقمية والاشتراكات',
                'settings' => [
                    'card_style' => 'minimal',
                    'show_product_attributes' => true,
                    'enable_instant_download' => true,
                    'products_per_row_desktop' => 4,
                ]
            ],
            'uc_currency' => [
                'name' => 'عملة UC',
                'description' => 'مُحسن لعرض عملات الألعاب والشحن',
                'settings' => [
                    'card_style' => 'modern',
                    'show_quantity_selector' => true,
                    'enable_bulk_pricing' => true,
                    'products_per_row_desktop' => 5,
                ]
            ]
        ];
    }
} 