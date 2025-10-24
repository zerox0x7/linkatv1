<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HomePage as HomePageModel;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;

class HomePage extends Component
{
    use WithFileUploads;
    
    protected $listeners = ['updateWireModel'];
    
    // Store Info
    public $store_name = '';
    public $store_description = '';
    public $store_logo = '';
    public $store_logo_file;
    
    // Hero Section
    public $hero_enabled = true;
    public $hero_title = '';
    public $hero_subtitle = '';
    public $hero_button1_text = '';
    public $hero_button1_link = '';
    public $hero_button2_text = '';
    public $hero_button2_link = '';
    public $hero_background_image = '';
    public $hero_background_image_file;
    
    // Categories Section
    public $categories_enabled = true;
    public $categories_title = '';
    public $selected_categories = [];
    
    // Featured Products Section
    public $featured_enabled = true;
    public $featured_title = '';
    public $featured_count = 4;
    public $selected_featured_products = [];
    
    // Brand Section
    public $brand_enabled = true;
    public $brand_title = '';
    public $brand_count = 6;
    public $selected_brand_products = [];
    
    // Services Section
    public $services_enabled = true;
    public $services_title = '';
    public $services_data = [];
    
    // Reviews Section
    public $reviews_enabled = true;
    public $reviews_title = '';
    public $reviews_count = 3;
    public $selected_reviews = [];
    
    // Location Section
    public $location_enabled = true;
    public $location_title = '';
    public $location_address = '';
    public $location_phone = '';
    public $location_email = '';
    public $location_hours = '';
    public $location_map_image = '';
    
    // Footer Section
    public $footer_enabled = true;
    public $footer_description = '';
    public $footer_quick_links = [];
    public $footer_payment_methods = [];
    public $footer_social_media = [];
    public $footer_copyright = '';
    
    // Theme Colors
    public $primary_color = '#00e5bb';
    public $background_color = '#0f172a';
    public $text_color = '#ffffff';
    public $secondary_text_color = '#94a3b8';
    
    // UI State
    public $showProductModal = false;
    public $showBrandModal = false;
    public $showCategoryModal = false;
    public $showReviewModal = false;
    public $showServiceModal = false;
    public $available_products = [];
    public $available_categories = [];
    public $available_reviews = [];
    
    // New Service/Review/Link Forms
    public $new_service = ['title' => '', 'description' => '', 'icon' => 'ri-service-line'];
    public $new_review = ['name' => '', 'city' => '', 'rating' => 5, 'comment' => ''];
    public $new_link = ['title' => '', 'url' => ''];
    
    public $store;
    protected $homePage;
    
    public function mount(Request $request)
    {
        $this->store = $request->attributes->get('store');
        // dd($this->store);
        $this->loadHomePageData();
        $this->loadAvailableData();
    }
    
    public function loadHomePageData()
    {
        $this->homePage = HomePageModel::where('store_id', $this->store->id)->first();
        
        if ($this->homePage) {
            $this->fill([
                'store_name' => $this->homePage->store_name ?? '',
                'store_description' => $this->homePage->store_description ?? '',
                'store_logo' => $this->homePage->store_logo ?? '',
                'hero_enabled' => $this->homePage->hero_enabled ?? true,
                'hero_title' => $this->homePage->hero_title ?? '',
                'hero_subtitle' => $this->homePage->hero_subtitle ?? '',
                'hero_button1_text' => $this->homePage->hero_button1_text ?? '',
                'hero_button1_link' => $this->homePage->hero_button1_link ?? '',
                'hero_button2_text' => $this->homePage->hero_button2_text ?? '',
                'hero_button2_link' => $this->homePage->hero_button2_link ?? '',
                'hero_background_image' => $this->homePage->hero_background_image ?? '',
                'hero_background_image_file' => $this->homePage->hero_background_image_file ?? '',
                'categories_enabled' => $this->homePage->categories_enabled ?? true,
                'categories_title' => $this->homePage->categories_title ?? '',
                'selected_categories' => $this->homePage->categories_data ?? [],
                'featured_enabled' => $this->homePage->featured_enabled ?? true,
                'featured_title' => $this->homePage->featured_title ?? '',
                'featured_count' => $this->homePage->featured_count ?? 4,
                'selected_featured_products' => $this->homePage->featured_products ?? [],
                'brand_enabled' => $this->homePage->brand_enabled ?? true,
                'brand_title' => $this->homePage->brand_title ?? '',
                'brand_count' => $this->homePage->brand_count ?? 6,
                'selected_brand_products' => $this->homePage->brand_products ?? [],
                'services_enabled' => $this->homePage->services_enabled ?? true,
                'services_title' => $this->homePage->services_title ?? '',
                'services_data' => $this->homePage->services_data ?? $this->getDefaultServices(),
                'reviews_enabled' => $this->homePage->reviews_enabled ?? true,
                'reviews_title' => $this->homePage->reviews_title ?? '',
                'reviews_count' => $this->homePage->reviews_count ?? 3,
                'selected_reviews' => $this->homePage->reviews_data ?? [],
                'location_enabled' => $this->homePage->location_enabled ?? true,
                'location_title' => $this->homePage->location_title ?? '',
                'location_address' => $this->homePage->location_address ?? '',
                'location_phone' => $this->homePage->location_phone ?? '',
                'location_email' => $this->homePage->location_email ?? '',
                'location_hours' => $this->homePage->location_hours ?? '',
                'location_map_image' => $this->homePage->location_map_image ?? '',
                'footer_enabled' => $this->homePage->footer_enabled ?? true,
                'footer_description' => $this->homePage->footer_description ?? '',
                'footer_quick_links' => $this->homePage->footer_quick_links ?? $this->getDefaultQuickLinks(),
                'footer_payment_methods' => $this->homePage->footer_payment_methods ?? $this->getDefaultPaymentMethods(),
                'footer_social_media' => $this->homePage->footer_social_media ?? $this->getDefaultSocialMedia(),
                'footer_copyright' => $this->homePage->footer_copyright ?? '',
                'primary_color' => $this->homePage->primary_color ?? '#00e5bb',
                'background_color' => $this->homePage->background_color ?? '#0f172a',
                'text_color' => $this->homePage->text_color ?? '#ffffff',
                'secondary_text_color' => $this->homePage->secondary_text_color ?? '#94a3b8',
            ]);
        } else {
            $this->setDefaultValues();
        }
    }
    
    public function loadAvailableData()
    {
        $this->available_products = Product::where('store_id', $this->store->id)
            ->where('status', 'active')
            ->select('id', 'name', 'price', 'main_image')
            ->get();
            
        $this->available_categories = Category::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->withCount('products')
            ->select('id', 'name', 'icon', 'image')
            ->get();
            
        $this->available_reviews = Review::where('store_id', $this->store->id)
            ->where('is_approved', true)
            ->with('user')
            ->select('id', 'rating', 'comment', 'user_id', 'created_at')
            ->get();
    }
    
    public function setDefaultValues()
    {
        $this->store_name = 'متجر الإلكترونيات الحديثة';
        $this->store_description = 'متجرك الأول للإلكترونيات والأجهزة الذكية بأفضل الأسعار وأعلى جودة.';
        $this->hero_title = 'أحدث الأجهزة الإلكترونية بأفضل الأسعار';
        $this->hero_subtitle = 'اكتشف تشكيلة واسعة من المنتجات الأصلية مع ضمان وخدمة توصيل سريعة';
        $this->hero_button1_text = 'تسوق الآن';
        $this->hero_button1_link = '/products';
        $this->hero_button2_text = 'تواصل معنا';
        $this->hero_button2_link = '/contact';
        $this->hero_background_image = 'https://readdy.ai/api/search-image?query=modern%20electronics%20store%20with%20latest%20gadgets%20and%20smartphones%20displayed%20in%20a%20clean%20minimalist%20setting%20with%20soft%20lighting%20and%20a%20simple%20background&width=800&height=400&seq=1&orientation=landscape';
        $this->hero_background_image_file = null;
        $this->categories_title = 'تصفح حسب الفئات';
        $this->featured_title = 'منتجاتنا المميزة';
        $this->brand_title = 'العلامات التجارية المميزة';
        $this->services_title = 'لماذا تختارنا';
        $this->services_data = $this->getDefaultServices();
        $this->reviews_title = 'ماذا يقول عملاؤنا';
        $this->location_title = 'تواصل معنا';
        $this->location_address = 'شارع الملك فهد، حي العليا، الرياض';
        $this->location_phone = '+966 55 123 4567';
        $this->location_email = 'info@electronics-store.com';
        $this->location_hours = 'السبت - الخميس: 10:00 ص - 10:00 م';
        $this->footer_description = 'متجر الإلكترونيات الحديثة هو وجهتك الأولى للحصول على أحدث الأجهزة الإلكترونية والهواتف الذكية بأفضل الأسعار وأعلى جودة.';
        $this->footer_quick_links = $this->getDefaultQuickLinks();
        $this->footer_payment_methods = $this->getDefaultPaymentMethods();
        $this->footer_social_media = $this->getDefaultSocialMedia();
        $this->footer_copyright = '© 2025 متجر الإلكترونيات الحديثة. جميع الحقوق محفوظة.';
    }
    
    public function getDefaultServices()
    {
        return [
            ['title' => 'توصيل سريع', 'description' => 'توصيل لجميع مناطق المملكة خلال 24-48 ساعة', 'icon' => 'ri-truck-line'],
            ['title' => 'ضمان أصلي', 'description' => 'جميع منتجاتنا أصلية 100% مع ضمان الوكيل', 'icon' => 'ri-shield-check-line'],
            ['title' => 'دعم فني 24/7', 'description' => 'فريق دعم فني متاح على مدار الساعة لمساعدتك', 'icon' => 'ri-customer-service-2-line'],
            ['title' => 'استرجاع مجاني', 'description' => 'استرجاع مجاني خلال 14 يوم من الشراء', 'icon' => 'ri-refund-2-line'],
        ];
    }
    
    public function getDefaultQuickLinks()
    {
        return [
            ['title' => 'من نحن', 'url' => '/about'],
            ['title' => 'سياسة الخصوصية', 'url' => '/privacy'],
            ['title' => 'الشروط والأحكام', 'url' => '/terms'],
            ['title' => 'اتصل بنا', 'url' => '/contact'],
        ];
    }
    
    public function getDefaultPaymentMethods()
    {
        return [
            'ri-visa-fill',
            'ri-mastercard-fill',
            'ri-paypal-fill',
            'ri-apple-fill',
            'ri-bank-card-fill'
        ];
    }
    
    public function getDefaultSocialMedia()
    {
        return [
            'ri-instagram-line',
            'ri-twitter-x-line',
            'ri-facebook-line',
            'ri-youtube-line',
            'ri-snapchat-line'
        ];
    }
    
    // Product Management
    public function openProductModal()
    {
        $this->showProductModal = true;
    }
    
    public function closeProductModal()
    {
        $this->showProductModal = false;
    }
    
    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if ($product && !collect($this->selected_featured_products)->contains('id', $productId)) {
            $this->selected_featured_products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->main_image,
            ];
        }
    }
    
    public function removeProduct($index)
    {
        unset($this->selected_featured_products[$index]);
        $this->selected_featured_products = array_values($this->selected_featured_products);
    }
    
    // Brand Product Management
    public function openBrandModal()
    {
        $this->showBrandModal = true;
    }
    
    public function closeBrandModal()
    {
        $this->showBrandModal = false;
    }
    
    public function addBrandProduct($productId)
    {
        $product = Product::find($productId);
        if ($product && !collect($this->selected_brand_products)->contains('id', $productId)) {
            $this->selected_brand_products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->main_image,
            ];
        }
    }
    
    public function removeBrandProduct($index)
    {
        unset($this->selected_brand_products[$index]);
        $this->selected_brand_products = array_values($this->selected_brand_products);
    }
    
    // Category Management
    public function openCategoryModal()
    {
        $this->showCategoryModal = true;
    }
    
    public function closeCategoryModal()
    {
        $this->showCategoryModal = false;
    }
    
    public function addCategory($categoryId)
    {
        $category = Category::withCount('products')->find($categoryId);
        if ($category && !collect($this->selected_categories)->contains('id', $categoryId)) {
            $this->selected_categories[] = [
                'id' => $category->id,
               'name' => $category->name,
               'icon' => $category->icon,
               'image' => $category->image,
               'products_count' => $category->products_count,
            ];
        }
    }
    
    public function removeCategory($index)
    {
        unset($this->selected_categories[$index]);
        $this->selected_categories = array_values($this->selected_categories);
    }
    
    // Review Management
    public function openReviewModal()
    {
        $this->showReviewModal = true;
    }
    
    public function closeReviewModal()
    {
        $this->showReviewModal = false;
    }
    
    public function addReview($reviewId)
    {
        $review = Review::with('user')->find($reviewId);
        if ($review && !collect($this->selected_reviews)->contains('id', $reviewId)) {
            $this->selected_reviews[] = [
                'id' => $review->id,
                'name' => $review->user->name ?? 'عميل',
                'city' => $review->user->city ?? 'غير محدد',
                'rating' => $review->rating,
                'comment' => $review->comment,
            ];
        }
    }
    
    public function removeReview($index)
    {
        unset($this->selected_reviews[$index]);
        $this->selected_reviews = array_values($this->selected_reviews);
    }
    
    // Service Management
    public function openServiceModal()
    {
        $this->showServiceModal = true;
        $this->new_service = ['title' => '', 'description' => '', 'icon' => 'ri-service-line'];
    }
    
    public function closeServiceModal()
    {
        $this->showServiceModal = false;
    }
    
    public function addService()
    {
        if (!empty($this->new_service['title']) && !empty($this->new_service['description'])) {
            $this->services_data[] = $this->new_service;
            $this->closeServiceModal();
            session()->flash('message', 'تمت إضافة الخدمة بنجاح');
        }
    }
    
    public function updateWireModel($property, $value)
    {
        // Handle nested properties like 'new_service.icon'
        $keys = explode('.', $property);
        $target = &$this;
        
        for ($i = 0; $i < count($keys) - 1; $i++) {
            $target = &$target->{$keys[$i]};
        }
        
        $target[end($keys)] = $value;
    }
    
    public function removeService($index)
    {
        unset($this->services_data[$index]);
        $this->services_data = array_values($this->services_data);
    }
    
    // Store Logo Management
    public function updatedStoreLogoFile()
    {
        $this->validate([
            'store_logo_file' => 'image|max:2048', // 2MB Max
        ]);

        // Store the uploaded file
        $path = $this->store_logo_file->store('store-logos', 'public');
        
        // Delete old logo if exists
        if ($this->store_logo && \Storage::disk('public')->exists($this->store_logo)) {
            \Storage::disk('public')->delete($this->store_logo);
        }
        
        // Update the logo path
        $this->store_logo = $path;
        
        // Clear the file input
        $this->store_logo_file = null;
        
        session()->flash('message', 'تم رفع شعار المتجر بنجاح');
    }
    
    public function removeStoreLogo()
    {
        if ($this->store_logo && \Storage::disk('public')->exists($this->store_logo)) {
            \Storage::disk('public')->delete($this->store_logo);
        }
        
        $this->store_logo = '';
        session()->flash('message', 'تم حذف شعار المتجر بنجاح');
    }
    
    // Hero Background Image Management
    public function updatedHeroBackgroundImageFile()
    {
        $this->validate([
            'hero_background_image_file' => 'image|max:2048', // 2MB Max
        ]);

        // Store the uploaded file
        $path = $this->hero_background_image_file->store('hero-backgrounds', 'public');
        
        // Delete old background image if exists
        if ($this->hero_background_image && \Storage::disk('public')->exists($this->hero_background_image)) {
            \Storage::disk('public')->delete($this->hero_background_image);
        }
        
        // Update the background image path
        $this->hero_background_image = $path;
        
        // Clear the file input
        $this->hero_background_image_file = null;
        
        session()->flash('message', 'تم رفع صورة الخلفية بنجاح');
    }
    
    public function removeHeroBackgroundImage()
    {
        if ($this->hero_background_image && \Storage::disk('public')->exists($this->hero_background_image)) {
            \Storage::disk('public')->delete($this->hero_background_image);
        }
        
        $this->hero_background_image = '';
        session()->flash('message', 'تم حذف صورة الخلفية بنجاح');
    }
    
    // Quick Link Management
    public function addQuickLink()
    {
        if (!empty($this->new_link['title']) && !empty($this->new_link['url'])) {
            $this->footer_quick_links[] = $this->new_link;
            $this->new_link = ['title' => '', 'url' => ''];
        }
    }
    
    public function removeQuickLink($index)
    {
        unset($this->footer_quick_links[$index]);
        $this->footer_quick_links = array_values($this->footer_quick_links);
    }
    
    // Payment Method Management
    public function addPaymentMethod($icon)
    {
        if (!in_array($icon, $this->footer_payment_methods)) {
            $this->footer_payment_methods[] = $icon;
        }
    }
    
    public function removePaymentMethod($index)
    {
        unset($this->footer_payment_methods[$index]);
        $this->footer_payment_methods = array_values($this->footer_payment_methods);
    }
    
    // Save Functions
    public function saveAll(Request $request)
    {
        $store = $request->attributes->get('store');
        // dd($store);
        $data = [
            'store_id' => $store->id,
            'store_name' => $this->store_name,
            'store_description' => $this->store_description,
            'store_logo' => $this->store_logo,
            'hero_enabled' => $this->hero_enabled,
            'hero_title' => $this->hero_title,
            'hero_subtitle' => $this->hero_subtitle,
            'hero_button1_text' => $this->hero_button1_text,
            'hero_button1_link' => $this->hero_button1_link,
            'hero_button2_text' => $this->hero_button2_text,
            'hero_button2_link' => $this->hero_button2_link,
            'hero_background_image' => $this->hero_background_image,
            'hero_background_image_file' => $this->hero_background_image_file,
            'categories_enabled' => $this->categories_enabled,
            'categories_title' => $this->categories_title,
            'categories_data' => $this->selected_categories,
            'featured_enabled' => $this->featured_enabled,
            'featured_title' => $this->featured_title,
            'featured_count' => $this->featured_count,
            'featured_products' => $this->selected_featured_products,
            'brand_enabled' => $this->brand_enabled,
            'brand_title' => $this->brand_title,
            'brand_count' => $this->brand_count,
            'brand_products' => $this->selected_brand_products,
            'services_enabled' => $this->services_enabled,
            'services_title' => $this->services_title,
            'services_data' => $this->services_data,
            'reviews_enabled' => $this->reviews_enabled,
            'reviews_title' => $this->reviews_title,
            'reviews_count' => $this->reviews_count,
            'reviews_data' => $this->selected_reviews,
            'location_enabled' => $this->location_enabled,
            'location_title' => $this->location_title,
            'location_address' => $this->location_address,
            'location_phone' => $this->location_phone,
            'location_email' => $this->location_email,
            'location_hours' => $this->location_hours,
            'location_map_image' => $this->location_map_image,
            'footer_enabled' => $this->footer_enabled,
            'footer_description' => $this->footer_description,
            'footer_quick_links' => $this->footer_quick_links,
            'footer_payment_methods' => $this->footer_payment_methods,
            'footer_social_media' => $this->footer_social_media,
            'footer_copyright' => $this->footer_copyright,
            'primary_color' => $this->primary_color,
            'background_color' => $this->background_color,
            'text_color' => $this->text_color,
            'secondary_text_color' => $this->secondary_text_color,
        ];
        
        HomePageModel::updateOrCreate(
            ['store_id' => $store->id],
            $data
        );
        
        session()->flash('message', 'تم حفظ إعدادات الصفحة الرئيسية بنجاح');
    }
    
    public function saveStoreInfo()
    {
        HomePageModel::updateOrCreate(
            ['store_id' => $this->store->id],
            [
                'store_name' => $this->store_name,
                'store_description' => $this->store_description,
                'store_logo' => $this->store_logo,
            ]
        );
        
        session()->flash('message', 'تم حفظ معلومات المتجر بنجاح');
    }
    
    public function saveColors()
    {
        HomePageModel::updateOrCreate(
            ['store_id' => $this->store->id],
            [
                'primary_color' => $this->primary_color,
                'background_color' => $this->background_color,
                'text_color' => $this->text_color,
                'secondary_text_color' => $this->secondary_text_color,
            ]
        );
        
        session()->flash('message', 'تم حفظ الألوان بنجاح');
    }
    
    public function render()
    {
        return view('livewire.home-page');
    }
}
