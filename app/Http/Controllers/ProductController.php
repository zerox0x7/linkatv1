<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Visit;
use App\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductsPage;

class ProductController extends Controller
{
    /**
     * عرض قائمة المنتجات
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

          $store = $request->attributes->get('store'); // Get the resolved store
          $theme = $store->active_theme ; // Use default if no theme is set
           $name = $store->name;

       
        $query = Product::query()
            ->where('store_id', $store->id)
            ->whereIn('status', ['active', 'out-of-stock']);

        
        // تعريف متغير $currentCategory بشكل افتراضي
        $currentCategory = null;
        
        // تصفية حسب الفئة
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
            $currentCategory = $category;
        }
        
        // تصفية حسب حالة المنتج
        if ($request->has('status') && $request->status === 'active') {
            $query->where('status', 'active');
        }
        
        // تصفية حسب النوع
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        // تصفية حسب التاغات
        if ($request->has('tag') && !empty($request->tag)) {
            // معالجة التاق إذا كان يحتوي على شرطة
            $tag = $request->tag;
            $tagForSearch = str_replace('-', ' ', $tag); // تحويل الشرطات إلى مسافات للبحث
            
            $query->where(function ($q) use ($tagForSearch) {
                $q->whereJsonContains('tags', $tagForSearch)
                  ->orWhereRaw("JSON_SEARCH(LOWER(tags), 'one', LOWER(?)) IS NOT NULL", ["%{$tagForSearch}%"]);
            });
        }
        
        // البحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // تصفية حسب نطاق السعر
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // تصفية حسب التقييمات
        if ($request->has('rating_filter') && is_numeric($request->rating_filter)) {
            $minRating = (int)$request->rating_filter;
            $query->where('rating', '>=', $minRating);
        }
        
        // الترتيب
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
        }
        
        // إضافة علاقة التصنيف وحساب متوسط التقييمات
        $query->with('category')
              ->withAvg(['reviews' => function($query) {
                  $query->where('is_approved', true);
              }], 'rating');
        
        $products = $query->paginate(12);
        
        $categories = Category::where('store_id', $store->id)
            ->where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->whereIn('status', ['active', 'out-of-stock']);
            }])
            ->orderBy('sort_order')
            ->get();

        // Get flash sale products (products with discounts)
        $flashSaleProducts = Product::whereIn('status', ['active', 'out-of-stock'])
            ->where('store_id', $store->id)
            ->where('has_discount', true)
            ->whereNotNull('old_price')
            ->where('old_price', '>', 'price')
            ->with('category')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Get popular products (best selling products)
        $popularProducts = Product::whereIn('status', ['active', 'out-of-stock'])
            ->where('store_id', $store->id)
            ->with('category')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating');

        // Apply popular products filter based on request
        $popularFilter = $request->get('popular_filter', 'best_selling');
        switch ($popularFilter) {
            case 'newest':
                $popularProducts->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $popularProducts->orderBy('price', 'asc');
                break;
            case 'best_selling':
            default:
                $popularProducts->orderBy('sales_count', 'desc');
                break;
        }

        $popularProducts = $popularProducts->take(8)->get();

        $productsPage = ProductsPage::where('store_id', $store->id)->first();

              // getActiveTheme() is a helper  to get the active theme for the user
            //   $activeTheme = getActiveTheme();
        return view("themes.$theme.pages.products.index", compact('products', 'categories','name', 'currentCategory', 'flashSaleProducts', 'popularProducts', 'popularFilter', 'productsPage'));

            
       // return view('theme::pages.products.index', compact('products', 'categories', 'currentCategory'));
    }
    
    /**
     * عرض منتجات التصنيف
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function category(Request $request, $slug)
    {
        $store = $request->attributes->get('store');
        $theme = $store->active_theme;
        $name = $store->name;

        // البحث عن التصنيف
        $category = Category::where('slug', $slug)
            ->where('store_id', $store->id)
            ->where('is_active', true)
            ->firstOrFail();

        // جلب المنتجات المتعلقة بهذا التصنيف
        $query = Product::query()
            ->where('store_id', $store->id)
            ->where('category_id', $category->id)
            ->whereIn('status', ['active', 'out-of-stock']);

        // تصفية حسب نطاق السعر
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // تصفية حسب التقييمات
        if ($request->has('rating_filter') && is_numeric($request->rating_filter)) {
            $minRating = (int)$request->rating_filter;
            $query->where('rating', '>=', $minRating);
        }
        
        // الترتيب
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }
        
        // إضافة علاقة التصنيف وحساب متوسط التقييمات
        $query->with('category')
              ->withAvg(['reviews' => function($query) {
                  $query->where('is_approved', true);
              }], 'rating');
        
        $products = $query->paginate(12);
        
        // جلب جميع التصنيفات للشريط الجانبي
        $categories = Category::where('store_id', $store->id)
            ->where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->whereIn('status', ['active', 'out-of-stock']);
            }])
            ->orderBy('sort_order')
            ->get();

        // Get flash sale products (products with discounts)
        $flashSaleProducts = Product::whereIn('status', ['active', 'out-of-stock'])
            ->where('store_id', $store->id)
            ->where('category_id', $category->id)
            ->where('has_discount', true)
            ->whereNotNull('old_price')
            ->where('old_price', '>', 'price')
            ->with('category')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Get popular products (best selling products from this category)
        $popularProducts = Product::whereIn('status', ['active', 'out-of-stock'])
            ->where('store_id', $store->id)
            ->where('category_id', $category->id)
            ->with('category')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->orderBy('sales_count', 'desc')
            ->take(8)
            ->get();

        $productsPage = ProductsPage::where('store_id', $store->id)->first();
        $currentCategory = $category;

        return view("themes.$theme.pages.category.show", compact('products', 'categories', 'name', 'category', 'currentCategory', 'flashSaleProducts', 'popularProducts', 'productsPage'));
    }
    
    /**
     * عرض تفاصيل المنتج
     * البحث عن المنتج إما باستخدام slug العشوائي أو share_slug الودي
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, $slug)
    {
        $store = $request->attributes->get('store'); // Get the resolved store
        $theme = $store->active_theme; // Use default if no theme is set
        
        // البحث عن المنتج إما بالـ slug أو الـ share_slug
        $product = Product::where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                      ->orWhere('share_slug', $slug);
            })
            ->where('store_id', $store->id)
            ->whereIn('status', ['active', 'out-of-stock'])
            ->with(['category', 'reviews' => function($query) {
                $query->where('is_approved', true)
                      ->with('user')
                      ->orderBy('created_at', 'desc');
            }])
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->firstOrFail();
        
        // تسجيل الزيارة
        Visit::log($product);
        
        // زيادة عدد المشاهدات
        $product->increment('views_count');
        
        // منتجات ذات صلة
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('store_id', $store->id)
            ->whereIn('status', ['active', 'out-of-stock'])
            ->take(4)
            ->inRandomOrder()
            ->get();
        
        // الحصول على عدد التقييمات وحساب متوسط التقييم
        $reviewsCount = $product->reviews->count();
        $averageRating = $reviewsCount > 0 ? $product->reviews->avg('rating') : 0;
        
        // Use the rating from withAvg as a backup if reviews relationship is not eager loaded correctly
        if ($averageRating === 0 && isset($product->reviews_avg_rating)) {
            $averageRating = $product->reviews_avg_rating;
        }
            
        return view("themes.$theme.pages.products.show", compact('product', 'relatedProducts', 'reviewsCount', 'averageRating'));
    }
    
    /**
     * عرض المنتجات المميزة
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function featured(Request $request)
    {
        $store = $request->attributes->get('store');
        
        $products = Product::where('store_id', $store->id)
            ->where('is_featured', true)
            ->whereIn('status', ['active', 'out-of-stock'])
            ->with('category')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->paginate(12);
            
        return view(Theme::getThemeView('pages.products.featured'), compact('products'));
    }
    
    /**
     * عرض أكثر المنتجات مبيعاً
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function bestSellers(Request $request)
    {
        $store = $request->attributes->get('store');
        
        $products = Product::where('store_id', $store->id)
            ->whereIn('status', ['active', 'out-of-stock'])
            ->orderBy('sales_count', 'desc')
            ->with('category')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->paginate(12);
            
        return view(Theme::getThemeView('pages.products.best_sellers'), compact('products'));
    }
    
    /**
     * تطبيق share_slug على جميع المنتجات التي ليس لديها
     * يستخدم للتحديثات
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateShareSlugs()
    {
        $products = Product::whereNull('share_slug')->get();
        $count = 0;
        
        foreach ($products as $product) {
            $product->share_slug = Product::generateShareSlug($product->name);
            $product->save();
            $count++;
        }
        
        return response()->json([
            'success' => true,
            'message' => "تم إنشاء {$count} share_slug للمنتجات",
        ]);
    }
    
    /**
     * عرض المنتج حسب التاغ
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @param  string  $tag
     * @return \Illuminate\Contracts\View\View
     */
    public function productByTag(Request $request, $productId, $tag = null)
    {   
        $store = $request->attributes->get('store');
        
        // إذا كانت البيانات في التنسيق القديم (في حالة tag/{tag} فقط)
        if ($tag === null && strpos($productId, '-') !== false) {
            $tagParts = explode('-', $productId, 2);
            if (count($tagParts) > 1 && is_numeric($tagParts[0])) {
                $productId = $tagParts[0];
                $tag = $tagParts[1];
            } else {
                return redirect()->route('products.index', ['tag' => $productId]);
            }
        }
        
        try {
            // الحصول على المنتج بواسطة المعرف مع التقييمات
            $product = Product::where('store_id', $store->id)
                ->where('id', $productId)
                ->whereIn('status', ['active', 'out-of-stock'])
                ->with(['category', 'reviews' => function($query) {
                    $query->where('is_approved', true)
                          ->with('user')
                          ->orderBy('created_at', 'desc');
                }])
                ->withAvg(['reviews' => function($query) {
                    $query->where('is_approved', true);
                }], 'rating')
                ->firstOrFail();
            
            // التحقق من أن التاغ موجود فعلاً في المنتج
            $productTags = [];
            if (!empty($product->tags)) {
                if (is_string($product->tags)) {
                    $productTags = json_decode($product->tags, true) ?: [];
                } else if (is_array($product->tags)) {
                    $productTags = $product->tags;
                }
            }
            
            $tagExists = false;
            $tagName = str_replace('-', ' ', $tag);
            
            foreach ($productTags as $singleTag) {
                if (Str::slug($singleTag) == Str::slug($tagName)) {
                    $tagExists = true;
                    break;
                }
            }
            
            if ($tagExists) {
                // تسجيل الزيارة
                Visit::log($product);
                
                // زيادة عدد المشاهدات
                $product->increment('views_count');
                
                // منتجات ذات صلة بنفس التاغ
                $relatedProducts = Product::where('store_id', $store->id)
                    ->where('id', '!=', $product->id)
                    ->whereIn('status', ['active', 'out-of-stock'])
                    ->where(function ($q) use ($tagName) {
                        $q->whereJsonContains('tags', $tagName)
                          ->orWhereRaw("JSON_SEARCH(LOWER(tags), 'one', LOWER(?)) IS NOT NULL", ["%{$tagName}%"]);
                    })
                    ->withAvg(['reviews' => function($query) {
                        $query->where('is_approved', true);
                    }], 'rating')
                    ->take(4)
                    ->inRandomOrder()
                    ->get();
                
                // الحصول على عدد التقييمات وحساب متوسط التقييم
                $reviewsCount = $product->reviews->count();
                $averageRating = $reviewsCount > 0 ? $product->reviews->avg('rating') : 0;
                
                // Use the rating from withAvg as a backup if reviews relationship is not eager loaded correctly
                if ($averageRating === 0 && isset($product->reviews_avg_rating)) {
                    $averageRating = $product->reviews_avg_rating;
                }
                
                return view(Theme::getThemeView('pages.products.show'), compact('product', 'relatedProducts', 'reviewsCount', 'averageRating'));
            }
        } catch (\Exception $e) {
            // إذا حدث أي خطأ، انتقل إلى صفحة المنتجات
        }
        
        // إذا لم يُعثر على المنتج أو التاغ، حول إلى صفحة المنتجات مع تاغ
        return redirect()->route('products.index', ['tag' => $tag]);
    }
    
    /**
     * تقييم المنتج
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rateProduct(Request $request)
    {
        // التحقق من البيانات
        $request->validate([
            'product_id' => 'required|numeric',
            'product_type' => 'required|string',
            'order_item_id' => 'required|numeric',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);
        
        // تحديد نوع المنتج
        $productType = $request->product_type;
        $model = null;
        
        // الحصول على نموذج المنتج المناسب بناءً على النوع
        if (strpos($productType, 'Product') !== false) {
            $model = \App\Models\Product::find($request->product_id);
        } elseif (strpos($productType, 'DigitalCard') !== false) {
            $model = \App\Models\DigitalCard::find($request->product_id);
        }
        
        // التحقق من وجود المنتج
        if (!$model) {
            return redirect()->back()->with('error', 'المنتج غير موجود!');
        }
        
        // إنشاء تقييم جديد
        $review = new \App\Models\Review();
        $review->user_id = auth()->id();
        $review->reviewable_id = $request->product_id;
        $review->reviewable_type = $productType;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->order_item_id = $request->order_item_id;
        $review->is_approved = false; // تعيين الحالة كغير معتمدة حتى تتم الموافقة عليها من قبل الإدارة
        $review->save();
        
        // تحديث تقييم المنتج والعدد
        $model->updateRating();
        
        // تحديث حالة العنصر المطلوب لمنع التقييمات المتكررة
        $orderItem = \App\Models\OrderItem::find($request->order_item_id);
        if ($orderItem) {
            $orderItem->is_rated = true;
            $orderItem->save();
        }
        
        return redirect()->back()->with('success', 'تم إرسال تقييمك بنجاح! سيتم مراجعته والموافقة عليه من قبل الإدارة. شكراً لمشاركة رأيك.');
    }

    /**
     * Filter popular products via AJAX
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterPopularProducts(Request $request)
    {
        $store = $request->attributes->get('store');
        $filter = $request->get('filter', 'best_selling');
        
        $query = Product::where('store_id', $store->id)
            ->whereIn('status', ['active', 'out-of-stock'])
            ->with('category')
            ->withAvg(['reviews' => function($query) {
                $query->where('is_approved', true);
            }], 'rating');

        // Apply filter
        switch ($filter) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'best_selling':
            default:
                $query->orderBy('sales_count', 'desc');
                break;
        }

        $products = $query->take(8)->get();

        // Return JSON response with products data
        $productsData = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'old_price' => $product->old_price,
                'rating' => $product->rating ?? 0,
                'reviews_count' => $product->reviews->count() ?? 0,
                'is_featured' => $product->is_featured,
                'discount_percentage' => $product->discount_percentage,
                'stock' => $product->stock,
                'main_image_url' => $product->main_image_url,
                'category_name' => $product->category->name ?? '',
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $productsData,
            'filter' => $filter
        ]);
    }

    /**
     * Search products
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        $store = $request->attributes->get('store');
        $theme = $store->active_theme;
        $name = $store->name;

        $query = Product::query()
            ->where('store_id', $store->id)
            ->whereIn('status', ['active', 'out-of-stock']);
        $searchTerm = $request->get('q', '');
        
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        // Add category filtering if provided
        if ($request->has('category') && !empty($request->category)) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Add sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->with('category')
                          ->withAvg(['reviews' => function($query) {
                              $query->where('is_approved', true);
                          }], 'rating')
                          ->paginate(12);

        $categories = Category::where('store_id', $store->id)
                            ->where('is_active', true)
                            ->orderBy('sort_order')
                            ->get();

        return view("themes.{$theme}.pages.products.search", compact(
            'products', 
            'categories', 
            'searchTerm',
            'store'
        ));
    }
} 