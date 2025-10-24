<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CouponsOffersCustomizer extends Component
{
    // Page-based settings
    public $homePageEnabled = true;
    public $homePageCoupons = [];
    public $homePageOffers = [];
    public $homePageOrder = 'newest';
    
    public $shopPageEnabled = true;
    public $shopPageCoupons = [];
    public $shopPageOffers = [];
    public $shopPageOrder = 'newest';
    
    public $productPageEnabled = true;
    public $productPageCoupons = [];
    public $productPageOffers = [];
    public $productPageOrder = 'related';
    
    public $cartPageEnabled = true;
    public $cartPageCoupons = [];
    public $cartPageOffers = [];
    public $cartPageOrder = 'applicable';
    
    public $checkoutPageEnabled = true;
    public $checkoutPageCoupons = [];
    public $checkoutPageOffers = [];
    public $checkoutPageOrder = 'last_chance';
    
    public $categoryPagesEnabled = true;
    public $categoryPagesCoupons = [];
    public $categoryPagesOffers = [];
    public $categoryPagesOrder = 'category_specific';
    
    // Global settings
    public $maxCouponsPerPage = 6;
    public $maxOffersPerPage = 6;
    public $displayPosition = 'top';
    public $showExpiredOffers = false;
    public $autoHideExpired = true;
    
    // Available data
    public $availableCoupons = [];
    public $availableOffers = [];
    
    // Performance optimization properties
    public $isLoading = false;
    public $dataLoaded = false;
    
    public function mount()
    {
        $this->loadSavedSettings();
        // Defer coupon loading to improve initial load time
        $this->dispatch('loadCouponsData');
    }
    
    public function loadCouponsAndOffers()
    {
        $this->isLoading = true;
        
        try {
            $storeId = Auth::user()->store_id ?? Auth::id();
            $cacheKey = "coupons_data_{$storeId}";
            
            // Try to get from cache first (5 minutes cache)
            $this->availableCoupons = Cache::remember($cacheKey, 300, function () use ($storeId) {
                return Coupon::where('store_id', $storeId)
                    ->active()
                    ->where(function ($query) {
                        // Only include coupons that haven't expired
                        $query->whereNull('expires_at')
                              ->orWhere('expires_at', '>=', now());
                    })
                    ->where(function ($query) {
                        // Only include coupons that haven't reached max usage
                        $query->whereNull('max_uses')
                              ->orWhereRaw('used_times < max_uses');
                    })
                    ->select('id', 'code', 'category', 'type', 'value', 'expires_at', 'used_times', 'max_uses', 'min_order_amount', 'is_active', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->limit(100) // Limit to improve performance
                    ->get()
                    ->map(function ($coupon) {
                        $status = $this->getCouponStatus($coupon);
                        $expiryInfo = $coupon->expires_at ? 
                            ' (ينتهي: ' . $coupon->expires_at->format('Y-m-d') . ')' : '';
                            
                        return [
                            'id' => $coupon->id,
                            'code' => $coupon->code,
                            'category' => $coupon->category,
                            'discount' => $coupon->value,
                            'type' => $coupon->type,
                            'expires_at' => $coupon->expires_at,
                            'status' => $status,
                            'display_name' => $coupon->code . 
                                ($coupon->category ? ' [' . $coupon->category . ']' : '') . 
                                ' - ' . $coupon->value . ($coupon->type == 'percentage' ? '%' : ' ر.س') .
                                $expiryInfo,
                            'usage_info' => $coupon->max_uses ? 
                                ' (' . $coupon->used_times . '/' . $coupon->max_uses . ' مستخدم)' : '',
                        ];
                    })
                    ->filter(function ($coupon) {
                        // Additional filter to ensure only truly active coupons are shown
                        return in_array($coupon['status'], ['نشط', 'ينتهي قريباً']);
                    })
                    ->values() // Re-index the array after filtering
                    ->toArray();
            });
            
            // For now, using coupons as offers too (you can create a separate Offer model later)
            $this->availableOffers = $this->availableCoupons;
            
            $this->dataLoaded = true;
            
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ في تحميل البيانات: ' . $e->getMessage());
            $this->availableCoupons = [];
            $this->availableOffers = [];
        } finally {
            $this->isLoading = false;
        }
    }
    
    private function getCouponStatus($coupon)
    {
        if ($coupon->expires_at && $coupon->expires_at < now()) {
            return 'منتهي';
        }
        
        if ($coupon->max_uses && $coupon->used_times >= $coupon->max_uses) {
            return 'مستنفد';
        }
        
        if ($coupon->expires_at && $coupon->expires_at->diffInDays(now()) <= 7) {
            return 'ينتهي قريباً';
        }
        
        return 'نشط';
    }
    
    public function loadSavedSettings()
    {
        $storeId = Auth::user()->store_id ?? Auth::id();
        $cacheKey = "coupon_settings_{$storeId}";
        
        // Use cache with fallback to database
        $settings = Cache::remember($cacheKey, 1800, function () use ($storeId) { // 30 minutes cache
            $settingsRecord = DB::table('coupon_page_settings')
                ->where('store_id', $storeId)
                ->first();
                
            return $settingsRecord ? json_decode($settingsRecord->settings, true) : null;
        });
        
        if ($settings) {
            $this->homePageCoupons = $settings['home_page_coupons'] ?? [];
            $this->homePageOffers = $settings['home_page_offers'] ?? [];
            $this->homePageOrder = $settings['home_page_order'] ?? 'newest';
            
            $this->shopPageCoupons = $settings['shop_page_coupons'] ?? [];
            $this->shopPageOffers = $settings['shop_page_offers'] ?? [];
            $this->shopPageOrder = $settings['shop_page_order'] ?? 'newest';
            
            $this->productPageCoupons = $settings['product_page_coupons'] ?? [];
            $this->productPageOffers = $settings['product_page_offers'] ?? [];
            $this->productPageOrder = $settings['product_page_order'] ?? 'related';
            
            $this->cartPageCoupons = $settings['cart_page_coupons'] ?? [];
            $this->cartPageOffers = $settings['cart_page_offers'] ?? [];
            $this->cartPageOrder = $settings['cart_page_order'] ?? 'applicable';
            
            $this->checkoutPageCoupons = $settings['checkout_page_coupons'] ?? [];
            $this->checkoutPageOffers = $settings['checkout_page_offers'] ?? [];
            $this->checkoutPageOrder = $settings['checkout_page_order'] ?? 'last_chance';
            
            $this->categoryPagesCoupons = $settings['category_pages_coupons'] ?? [];
            $this->categoryPagesOffers = $settings['category_pages_offers'] ?? [];
            $this->categoryPagesOrder = $settings['category_pages_order'] ?? 'category_specific';
            
            $this->maxCouponsPerPage = $settings['max_coupons_per_page'] ?? 6;
            $this->maxOffersPerPage = $settings['max_offers_per_page'] ?? 6;
            $this->displayPosition = $settings['display_position'] ?? 'top';
        }
    }
    
    public function getSavedSettings()
    {
        $storeId = Auth::user()->store_id ?? Auth::id();
        $cacheKey = "coupon_settings_{$storeId}";
        
        return Cache::get($cacheKey, function () use ($storeId) {
            $settingsRecord = DB::table('coupon_page_settings')
                ->where('store_id', $storeId)
                ->first();
                
            return $settingsRecord ? json_decode($settingsRecord->settings, true) : null;
        });
    }
    
    public function save()
    {
        try {
            $settings = [
                'store_id' => Auth::user()->store_id ?? Auth::id(),
                'home_page_enabled' => $this->homePageEnabled,
                'home_page_coupons' => $this->homePageCoupons,
                'home_page_offers' => $this->homePageOffers,
                'home_page_order' => $this->homePageOrder,
                
                'shop_page_enabled' => $this->shopPageEnabled,
                'shop_page_coupons' => $this->shopPageCoupons,
                'shop_page_offers' => $this->shopPageOffers,
                'shop_page_order' => $this->shopPageOrder,
                
                'product_page_enabled' => $this->productPageEnabled,
                'product_page_coupons' => $this->productPageCoupons,
                'product_page_offers' => $this->productPageOffers,
                'product_page_order' => $this->productPageOrder,
                
                'cart_page_enabled' => $this->cartPageEnabled,
                'cart_page_coupons' => $this->cartPageCoupons,
                'cart_page_offers' => $this->cartPageOffers,
                'cart_page_order' => $this->cartPageOrder,
                
                'checkout_page_enabled' => $this->checkoutPageEnabled,
                'checkout_page_coupons' => $this->checkoutPageCoupons,
                'checkout_page_offers' => $this->checkoutPageOffers,
                'checkout_page_order' => $this->checkoutPageOrder,
                
                'category_pages_enabled' => $this->categoryPagesEnabled,
                'category_pages_coupons' => $this->categoryPagesCoupons,
                'category_pages_offers' => $this->categoryPagesOffers,
                'category_pages_order' => $this->categoryPagesOrder,
                
                'max_coupons_per_page' => $this->maxCouponsPerPage,
                'max_offers_per_page' => $this->maxOffersPerPage,
                'display_position' => $this->displayPosition,
                'show_expired_offers' => $this->showExpiredOffers,
                'auto_hide_expired' => $this->autoHideExpired,
            ];
            
            // Save to database or cache
            $this->saveSettings($settings);
            
            session()->flash('success', 'تم حفظ إعدادات العروض والكوبونات بنجاح!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حفظ الإعدادات: ' . $e->getMessage());
        }
    }
    
    public function saveSettings($settings)
    {
        $storeId = $settings['store_id'];
        
        try {
            // Save to database
            DB::table('coupon_page_settings')->updateOrInsert(
                ['store_id' => $storeId],
                [
                    'settings' => json_encode($settings),
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
            
            // Clear and update cache
            $cacheKey = "coupon_settings_{$storeId}";
            Cache::put($cacheKey, $settings, 1800); // 30 minutes
            
        } catch (\Exception $e) {
            // If database fails, at least cache it
            $cacheKey = "coupon_settings_{$storeId}";
            Cache::put($cacheKey, $settings, 1800);
            throw $e;
        }
    }
    
    public function refreshCoupons()
    {
        $storeId = Auth::user()->store_id ?? Auth::id();
        
        // Clear cache to force fresh data load
        Cache::forget("coupons_data_{$storeId}");
        
        $this->dataLoaded = false;
        $this->loadCouponsAndOffers();
        
        session()->flash('success', 'تم تحديث قائمة الكوبونات والعروض!');
    }
    
    public function getSelectedCouponsForPage($page)
    {
        $property = $page . 'PageCoupons';
        $selectedIds = $this->$property ?? [];
        
        return collect($this->availableCoupons)->whereIn('id', $selectedIds);
    }
    
    public function getSelectedOffersForPage($page)
    {
        $property = $page . 'PageOffers';
        $selectedIds = $this->$property ?? [];
        
        return collect($this->availableOffers)->whereIn('id', $selectedIds);
    }

    // Toggle methods for card-based selection
    public function toggleHomePageCoupon($couponId)
    {
        $this->toggleSelection($this->homePageCoupons, $couponId);
    }

    public function toggleHomePageOffer($offerId)
    {
        $this->toggleSelection($this->homePageOffers, $offerId);
    }

    public function toggleShopPageCoupon($couponId)
    {
        $this->toggleSelection($this->shopPageCoupons, $couponId);
    }

    public function toggleShopPageOffer($offerId)
    {
        $this->toggleSelection($this->shopPageOffers, $offerId);
    }

    public function toggleProductPageCoupon($couponId)
    {
        $this->toggleSelection($this->productPageCoupons, $couponId);
    }

    public function toggleProductPageOffer($offerId)
    {
        $this->toggleSelection($this->productPageOffers, $offerId);
    }

    public function toggleCartPageCoupon($couponId)
    {
        $this->toggleSelection($this->cartPageCoupons, $couponId);
    }

    public function toggleCartPageOffer($offerId)
    {
        $this->toggleSelection($this->cartPageOffers, $offerId);
    }

    public function toggleCheckoutPageCoupon($couponId)
    {
        $this->toggleSelection($this->checkoutPageCoupons, $couponId);
    }

    public function toggleCheckoutPageOffer($offerId)
    {
        $this->toggleSelection($this->checkoutPageOffers, $offerId);
    }

    public function toggleCategoryPagesCoupon($couponId)
    {
        $this->toggleSelection($this->categoryPagesCoupons, $couponId);
    }

    public function toggleCategoryPagesOffer($offerId)
    {
        $this->toggleSelection($this->categoryPagesOffers, $offerId);
    }

    /**
     * Helper method to toggle item selection in an array
     */
    private function toggleSelection(&$array, $itemId)
    {
        $key = array_search($itemId, $array);
        
        if ($key !== false) {
            // Item is selected, remove it
            unset($array[$key]);
            $array = array_values($array); // Re-index array
        } else {
            // Item is not selected, add it
            $array[] = $itemId;
        }
    }

    public function render()
    {
        // Load data on first render if not already loaded
        if (!$this->dataLoaded && !$this->isLoading) {
            $this->loadCouponsAndOffers();
        }
        
        return view('livewire.coupons-offers-customizer');
    }
}
