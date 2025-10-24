<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\DigitalCard;
use App\Models\HomeSection;
use App\Models\HomeSlider;
use App\Models\SiteReview;
use App\Models\ReviewsSection;
use App\Models\HomePage;
use App\Facades\Theme;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية للموقع
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Check if it's local development environment or local network
        $host = $request->getHost();
        // Allow access from localhost, 127.0.0.1, and any IP in the 192.168.x.x range (local network)
        if ($host === 'localhost' || $host === '127.0.0.1' || $host === '192.168.1.107') {
            return redirect()->route('subscriptions.index');
        }

        $store = $request->attributes->get('store'); // Get the resolved store
        
        $theme = $store->active_theme ; // Use default if no theme is set
        $name = $store->name;
        // استرجاع الأقسام النشطة مرتبة حسب الترتيب
        $homeSections = HomeSection::where('store_id',$store->id)->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        // البيانات الأخرى التي قد تحتاجها الصفحة الرئيسية
        $sliders = HomeSlider::getActive();
        
        // Get home page configuration
        $homePageConfig = HomePage::where('store_id', $store->id)->first();
        
        // Get categories and products based on home page configuration
        if ($homePageConfig) {
            // Get categories from home_page configuration
            $categoryIds = [];
            if ($homePageConfig->categories_data && is_array($homePageConfig->categories_data)) {
                $categoryIds = array_column($homePageConfig->categories_data, 'id');
                $categoryIds = array_filter($categoryIds); // Remove null values
            }
            
            if (!empty($categoryIds)) {
                $categories = Category::where('store_id', $store->id)
                    ->where('is_active', 1)
                    ->whereIn('id', $categoryIds)
                    ->withCount('products')
                    ->orderByRaw('FIELD(id, ' . implode(',', $categoryIds) . ')')
                    ->get();
            } else {
                $categories = collect(); // Empty collection
            }
            
            // Get featured products based on is_featured column
            $featuredProducts = Product::where('store_id', $store->id)
                ->available()
                ->where('is_featured', true)
                ->withAvg(['reviews' => function($query) {
                    $query->where('is_approved', true);
                }], 'rating')
                ->withCount(['reviews' => function($query) {
                    $query->where('is_approved', true);
                }])
                ->latest()
                ->get();
            
            // Get brand products from home_page configuration
            $brandProductIds = [];
            if ($homePageConfig->brand_products && is_array($homePageConfig->brand_products)) {
                $brandProductIds = array_column($homePageConfig->brand_products, 'id');
                $brandProductIds = array_filter($brandProductIds); // Remove null values
            }
            
            if (!empty($brandProductIds)) {
                $brandProducts = Product::where('store_id', $store->id)
                    ->where('status', 'active')
                    ->whereIn('id', $brandProductIds)
                    ->orderByRaw('FIELD(id, ' . implode(',', $brandProductIds) . ')')
                    ->get();
            } else {
                $brandProducts = collect(); // Empty collection
            }
            
            // Get services from home_page configuration
            $services = [];
            if ($homePageConfig->services_data && is_array($homePageConfig->services_data)) {
                $services = $homePageConfig->services_data;
            }
        } else {
            // Fallback to empty collections if no home page config found
            $categories = collect();
            $featuredProducts = collect();
            $brandProducts = collect();
            $services = [];
        }
        
        // المنتجات المميزة للقسم الافتراضي - commented out, now using home_page config
        // $featuredProducts = Product::where('store_id', $store->id )->where('status','active')->where('is_featured',1)
        //     ->latest()
        //     ->limit(8)
        //     ->get();
        // dd($featuredProducts);
        
        // أحدث المنتجات للقسم الافتراضي
        $latestProducts = Product::where('store_id', $store->id)->available()
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->latest()
            ->limit(8)
            ->get();
        
        // الأكثر مبيعاً للقسم الافتراضي - من جدول order_items (only products ordered more than once)
        $bestSellers = Product::where('store_id', $store->id)
            ->available()
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->withCount(['orderItems' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->whereIn('status', ['completed', 'processing', 'shipped']);
                });
            }])
            ->having('order_items_count', '>', 1) // Only products ordered more than once
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();
        
        // Popular Products - الأكثر مشاهدة
        $popularProducts = Product::where('store_id', $store->id)
            ->available()
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();
        
        // New Arrivals - أحدث المنتجات
        $newArrivals = Product::where('store_id', $store->id)
            ->available()
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->latest()
            ->limit(10)
            ->get();
        
        // Top Selling Products - الأكثر مبيعاً (top 3, only products ordered more than once)
        $topSellingProducts = Product::where('store_id', $store->id)
            ->available()
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->withCount(['orderItems' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->whereIn('status', ['completed', 'processing', 'shipped']);
                });
            }])
            ->having('order_items_count', '>', 1) // Only products ordered more than once
            ->orderBy('order_items_count', 'desc')
            ->limit(3)
            ->get();
        
        // Trending Products - المنتجات الرائجة (حديثة ومبيعات جيدة)
        $trendingProducts = Product::where('store_id', $store->id)
            ->available()
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->withCount(['orderItems' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->whereIn('status', ['completed', 'processing', 'shipped'])
                      ->where('created_at', '>=', now()->subDays(30));
                });
            }])
            ->where('created_at', '>=', now()->subDays(90))
            ->orderBy('order_items_count', 'desc')
            ->limit(3)
            ->get();
        
        // New Products - منتجات جديدة
        $newProducts = Product::where('store_id', $store->id)
            ->available()
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->latest()
            ->limit(3)
            ->get();
        
        // Flash Sale Products - منتجات العروض السريعة (التي عليها خصم)
        $flashSaleProducts = Product::where('store_id', $store->id)
            ->available()
            ->whereNotNull('old_price')
            ->whereColumn('old_price', '>', 'price')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->orderByRaw('((old_price - price) / old_price) DESC')
            ->limit(2)
            ->get();
        
        // الفئات - commented out, now using home_page config
        // $categories = Category::where('store_id', $store->id )->where('is_active', 1)
        //     ->where('show_in_homepage', 1)
        //     ->withCount('products')
        //     ->orderBy('sort_order')
        //     ->limit(14)
        //     ->get();
        
        // آراء العملاء - من جدول site_reviews
        $reviews = SiteReview::with('user')
            ->where('is_approved', true)
            ->where('store_id', $store->id )
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get hero data from home page configuration
        $hero = null;
        if ($homePageConfig && $homePageConfig->hero_enabled) {
            $hero = (object) [
                'hero_title' => $homePageConfig->hero_title,
                'hero_subtitle' => $homePageConfig->hero_subtitle,
                'hero_button1_text' => $homePageConfig->hero_button1_text,
                'hero_button1_link' => $homePageConfig->hero_button1_link,
                'hero_button2_text' => $homePageConfig->hero_button2_text,
                'hero_button2_link' => $homePageConfig->hero_button2_link,
                'hero_background_image' => $homePageConfig->hero_background_image,
            ];
        }
        
        $reviewsSection   = ReviewsSection::where('store_id', $store->id)->first();
        // dd($store);
        // Get homePage and headerSettings for greenGame theme
        $homePage = HomePage::where('store_id', $store->id)->first() ?? HomePage::getDefault($store->id);
        $headerSettings = \App\Models\HeaderSettings::getSettings($store->id);
        
        // Get active menus ordered
        $menus = \App\Models\Menu::where('owner_id', $store->id)
            ->active()
            ->ordered()
            ->get();
        
        // Get active theme data from themes_data table
        // Use store_id from users table, not the store's id
        $themeDataRecord = \App\Models\ThemeData::getByStoreAndTheme($store->store_id, $theme);
        $themeData = null;
        $sectionsData = null;
        
        if ($themeDataRecord) {
            $themeData = $themeDataRecord->toArray();
            $sectionsData = $themeDataRecord->sections_data ?? null;
        }
        
        return view("themes.$theme.pages.home", compact(
            'homeSections',
            'sliders',
            'featuredProducts',
            'brandProducts',
            'latestProducts',
            'bestSellers',
            'popularProducts',
            'newArrivals',
            'topSellingProducts',
            'trendingProducts',
            'newProducts',
            'flashSaleProducts',
            'categories',
            'reviews',
            'name',
            'hero',
            'reviewsSection',
            'services',
            'homePage',
            'headerSettings',
            'menus',
            'themeData',
            'sectionsData'
        ));
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
} 