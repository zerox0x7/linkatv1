<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductsPage;
use Illuminate\Http\Request;

class ProductsPageCustomizer extends Component
{
    use WithFileUploads;
    
    // Header Settings
    public $showPageHeader = true;
    public $pageTitle = '';
    public $pageSubtitle = '';
    public $headerImage = '';
    public $headerImageFile;
    
    // Discount Timer Settings
    public $showDiscountTimer = true;
    public $discountEndDate = '';
    public $discountText = '';
    public $timerStyle = 'modern';
    
    // Coupon Settings
    public $showCouponBanner = true;
    public $couponCode = '';
    public $couponText = '';
    public $couponBackgroundColor = '';
    
    // Layout Settings
    public $layoutStyle = 'grid';
    public $productsPerRow = 4;
    public $showSidebar = true;
    public $sidebarPosition = 'left';
    
    // Filter Settings
    public $showSearch = true;
    public $searchPlaceholder = '';
    public $showPriceFilter = true;
    public $showCategoryFilter = true;
    public $showBrandFilter = true;
    public $showRatingFilter = true;
    public $showSortOptions = true;
    public $defaultSort = 'latest';
    
    // Product Display Settings
    public $productCardStyle = 'modern';
    public $showProductRating = true;
    public $showProductBadges = true;
    public $showQuickView = true;
    public $showWishlist = true;
    public $productsPerPage = 12;
    public $paginationStyle = 'numbers';
    
    // Color Scheme
    public $primaryColor = '';
    public $secondaryColor = '';
    public $accentColor = '';
    public $backgroundColor = '';

    protected $settings;
    protected $storeId;
    
    public function mount(Request $request)
    {
        // Get store ID from the request
        $store = $request->attributes->get('store');
        $this->storeId = $store ? $store->id : null;
        
        if (!$this->storeId) {
            throw new \Exception('Store not found');
        }
        
        $this->loadSettings();
    }
    
    /**
     * Load settings from database for the current store
     */
    public function loadSettings()
    {
        $this->settings = ProductsPage::getSettings($this->storeId);
        
        // Load settings into component properties
        $this->showPageHeader = $this->settings->page_header_enabled ?? true;
        $this->pageTitle = $this->settings->page_title ?? 'منتجاتنا';
        $this->pageSubtitle = $this->settings->page_subtitle ?? 'اكتشف منتجات رائعة بأسعار مميزة';
        $this->headerImage = $this->settings->header_image ?? '';
        
        $this->showDiscountTimer = $this->settings->discount_timer_enabled ?? true;
        $this->discountText = $this->settings->discount_text ?? 'عرض خاص - خصم حتى 50%!';
        $this->discountEndDate = $this->settings->discount_end_date ? 
            $this->settings->discount_end_date->format('Y-m-d\TH:i') : 
            now()->addDays(7)->format('Y-m-d\TH:i');
        $this->timerStyle = $this->settings->timer_style ?? 'modern';
        
        $this->showCouponBanner = $this->settings->coupon_banner_enabled ?? true;
        $this->couponCode = $this->settings->coupon_code ?? 'SAVE25';
        $this->couponText = $this->settings->coupon_text ?? 'احصل على خصم 25% على جميع المنتجات';
        $this->couponBackgroundColor = $this->settings->coupon_background_color ?? '#6366f1';
        
        $this->layoutStyle = $this->settings->layout_style ?? 'grid';
        $this->productsPerRow = $this->settings->products_per_row ?? 4;
        $this->showSidebar = $this->settings->sidebar_enabled ?? true;
        $this->sidebarPosition = $this->settings->sidebar_position ?? 'left';
        
        $this->showSearch = $this->settings->search_enabled ?? true;
        $this->searchPlaceholder = $this->settings->search_placeholder ?? 'البحث عن المنتجات...';
        $this->showPriceFilter = $this->settings->price_filter_enabled ?? true;
        $this->showCategoryFilter = $this->settings->category_filter_enabled ?? true;
        $this->showBrandFilter = $this->settings->brand_filter_enabled ?? true;
        $this->showRatingFilter = $this->settings->rating_filter_enabled ?? true;
        $this->showSortOptions = $this->settings->sort_options_enabled ?? true;
        $this->defaultSort = $this->settings->default_sort ?? 'latest';
        
        $this->productCardStyle = $this->settings->product_card_style ?? 'modern';
        $this->showProductRating = $this->settings->product_rating_enabled ?? true;
        $this->showProductBadges = $this->settings->product_badges_enabled ?? true;
        $this->showQuickView = $this->settings->quick_view_enabled ?? true;
        $this->showWishlist = $this->settings->wishlist_enabled ?? true;
        $this->productsPerPage = $this->settings->products_per_page ?? 12;
        $this->paginationStyle = $this->settings->pagination_style ?? 'numbers';
        
        $this->primaryColor = $this->settings->primary_color ?? '#00e5bb';
        $this->secondaryColor = $this->settings->secondary_color ?? '#1e293b';
        $this->accentColor = $this->settings->accent_color ?? '#f59e0b';
        $this->backgroundColor = $this->settings->background_color ?? '#0f172a';
    }
    
    public function updatedLayoutStyle()
    {
        if ($this->layoutStyle === 'list') {
            $this->productsPerRow = 1;
        }
    }
    
    public function resetToDefaults()
    {
        // Get default settings
        $defaults = ProductsPage::getDefaultSettings();
        
        // Apply defaults to component properties
        $this->showPageHeader = $defaults['page_header_enabled'];
        $this->pageTitle = $defaults['page_title'];
        $this->pageSubtitle = $defaults['page_subtitle'];
        $this->headerImage = $defaults['header_image'];
        
        $this->showDiscountTimer = $defaults['discount_timer_enabled'];
        $this->discountText = $defaults['discount_text'];
        $this->discountEndDate = $defaults['discount_end_date']->format('Y-m-d\TH:i');
        $this->timerStyle = $defaults['timer_style'];
        
        $this->showCouponBanner = $defaults['coupon_banner_enabled'];
        $this->couponCode = $defaults['coupon_code'];
        $this->couponText = $defaults['coupon_text'];
        $this->couponBackgroundColor = $defaults['coupon_background_color'];
        
        $this->layoutStyle = $defaults['layout_style'];
        $this->productsPerRow = $defaults['products_per_row'];
        $this->showSidebar = $defaults['sidebar_enabled'];
        $this->sidebarPosition = $defaults['sidebar_position'];
        
        $this->showSearch = $defaults['search_enabled'];
        $this->searchPlaceholder = $defaults['search_placeholder'];
        $this->showPriceFilter = $defaults['price_filter_enabled'];
        $this->showCategoryFilter = $defaults['category_filter_enabled'];
        $this->showBrandFilter = $defaults['brand_filter_enabled'];
        $this->showRatingFilter = $defaults['rating_filter_enabled'];
        $this->showSortOptions = $defaults['sort_options_enabled'];
        $this->defaultSort = $defaults['default_sort'];
        
        $this->productCardStyle = $defaults['product_card_style'];
        $this->showProductRating = $defaults['product_rating_enabled'];
        $this->showProductBadges = $defaults['product_badges_enabled'];
        $this->showQuickView = $defaults['quick_view_enabled'];
        $this->showWishlist = $defaults['wishlist_enabled'];
        $this->productsPerPage = $defaults['products_per_page'];
        $this->paginationStyle = $defaults['pagination_style'];
        
        $this->primaryColor = $defaults['primary_color'];
        $this->secondaryColor = $defaults['secondary_color'];
        $this->accentColor = $defaults['accent_color'];
        $this->backgroundColor = $defaults['background_color'];
        
        $this->dispatch('settings-reset', [
            'message' => 'تم إعادة تعيين الإعدادات إلى القيم الافتراضية!'
        ]);
    }
    
    public function previewChanges()
    {
        $this->dispatch('preview-updated');
    }
    
    public function updatedHeaderImageFile()
    {
        try {
            $this->validate([
                'headerImageFile' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB Max
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Clear the invalid file
            $this->headerImageFile = null;
            // Re-throw the validation error to show the message
            throw $e;
        }
    }
    
    public function removeHeaderImage()
    {
        // Delete the old file if it exists
        if ($this->headerImage && Storage::disk('public')->exists($this->headerImage)) {
            Storage::disk('public')->delete($this->headerImage);
        }
        
        // Clear both properties
        $this->headerImageFile = null;
        $this->headerImage = '';
    }
    
    public function getHeaderImageUrl()
    {
        if ($this->headerImageFile) {
            return $this->headerImageFile->temporaryUrl();
        }
        
        if ($this->headerImage) {
            return Storage::url($this->headerImage);
        }
        
        return null;
    }
    
    public function hasHeaderImage()
    {
        return $this->headerImageFile || $this->headerImage;
    }
    
    public function saveSettings(Request $request)
    {
        $store = $request->attributes->get('store');
        try {
            // Handle file upload
            $headerImagePath = $this->headerImage;
            if ($this->headerImageFile) {
                // Delete old image if exists
                if ($this->headerImage && Storage::disk('public')->exists($this->headerImage)) {
                    Storage::disk('public')->delete($this->headerImage);
                }
                
                // Store new image
                $headerImagePath = $this->headerImageFile->store('header-images', 'public');
                
                // Clear the temporary file after storing
                $this->headerImageFile = null;
            }
            
            // Prepare data for saving
            $data = [
                // Store ID
                'store_id' => $store->id,
                
                // Page Header Settings
                'page_header_enabled' => $this->showPageHeader,
                'page_title' => $this->pageTitle,
                'page_subtitle' => $this->pageSubtitle,
                'header_image' => $headerImagePath,
                
                // Discount Timer Settings
                'discount_timer_enabled' => $this->showDiscountTimer,
                'discount_text' => $this->discountText,
                'discount_end_date' => $this->discountEndDate ? \Carbon\Carbon::parse($this->discountEndDate) : null,
                'timer_style' => $this->timerStyle,
                
                // Coupon Banner Settings
                'coupon_banner_enabled' => $this->showCouponBanner,
                'coupon_code' => $this->couponCode,
                'coupon_text' => $this->couponText,
                'coupon_background_color' => $this->couponBackgroundColor,
                
                // Layout Settings
                'layout_style' => $this->layoutStyle,
                'products_per_row' => $this->productsPerRow,
                'sidebar_enabled' => $this->showSidebar,
                'sidebar_position' => $this->sidebarPosition,
                
                // Filter Settings
                'search_enabled' => $this->showSearch,
                'search_placeholder' => $this->searchPlaceholder,
                'price_filter_enabled' => $this->showPriceFilter,
                'category_filter_enabled' => $this->showCategoryFilter,
                'brand_filter_enabled' => $this->showBrandFilter,
                'rating_filter_enabled' => $this->showRatingFilter,
                'sort_options_enabled' => $this->showSortOptions,
                'default_sort' => $this->defaultSort,
                
                // Product Display Settings
                'product_card_style' => $this->productCardStyle,
                'product_rating_enabled' => $this->showProductRating,
                'product_badges_enabled' => $this->showProductBadges,
                'quick_view_enabled' => $this->showQuickView,
                'wishlist_enabled' => $this->showWishlist,
                'products_per_page' => $this->productsPerPage,
                'pagination_style' => $this->paginationStyle,
                
                // Color Scheme Settings
                'primary_color' => $this->primaryColor,
                'secondary_color' => $this->secondaryColor,
                'accent_color' => $this->accentColor,
                'background_color' => $this->backgroundColor,
            ];
            
            // Update or create the settings record based on store_id
            $this->settings = ProductsPage::updateOrCreate(
                ['store_id' => $store->id],
                $data
            );
            
            // Update the headerImage property with the saved path
            $this->headerImage = $headerImagePath;
            
            $this->dispatch('settings-saved', [
                'message' => 'تم حفظ إعدادات صفحة المنتجات بنجاح!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('settings-error', [
                'message' => 'حدث خطأ أثناء حفظ الإعدادات: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.products-page-customizer');
    }
}
