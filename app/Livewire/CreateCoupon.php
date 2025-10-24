<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CreateCoupon extends Component
{
    public string $code = '';
    public string $searchCategories = '';
    public string $searchProducts = '';
    public array $selectedCategories = [];
    public array $selectedProducts = [];
    public bool $isActive = true;
    
    // Coupon settings properties
    public ?string $startsAt = null;
    public ?string $expiresAt = null;
    public ?int $maxUses = null;
    public ?int $userLimit = null;
    public string $type = 'percentage';
    public float $value = 0;
    public ?float $minOrderAmount = null;
    public ?float $maxDiscountAmount = null;
    public string $priority = 'medium';
    public ?int $storeId = null;
    public bool $autoApply = false;
    public bool $stackable = false;
    public bool $emailNotifications = false;
    public bool $showOnHomepage = false;

    protected $rules = [
        'code' => 'required|string|max:255|unique:coupons,code',
        'type' => 'required|in:percentage,fixed,free_shipping',
        'value' => 'required|numeric|min:0',
        'startsAt' => 'nullable|date',
        'expiresAt' => 'nullable|date|after:startsAt',
        'maxUses' => 'nullable|integer|min:1',
        'minOrderAmount' => 'nullable|numeric|min:0',
        'maxDiscountAmount' => 'nullable|numeric|min:0',
        'userLimit' => 'nullable|integer|min:1',
        'priority' => 'required|in:high,medium,low',
        'storeId' => 'nullable|integer',
    ];

    protected $messages = [
        'code.required' => 'رمز الكوبون مطلوب',
        'code.unique' => 'رمز الكوبون موجود بالفعل',
        'type.required' => 'نوع الكوبون مطلوب',
        'value.required' => 'قيمة الكوبون مطلوبة',
        'value.numeric' => 'قيمة الكوبون يجب أن تكون رقم',
        'value.min' => 'قيمة الكوبون يجب أن تكون أكبر من أو تساوي صفر',
        'expiresAt.after' => 'تاريخ انتهاء الصلاحية يجب أن يكون بعد تاريخ البداية',
        'maxUses.min' => 'الحد الأقصى للاستخدام يجب أن يكون أكبر من صفر',
        'userLimit.min' => 'حد المستخدم الواحد يجب أن يكون أكبر من صفر',
    ];

    public function getAvailableCategoriesProperty()
    {
        return Category::when($this->searchCategories, function ($query) {
            $query->where('name', 'like', '%' . $this->searchCategories . '%');
        })
        ->where('is_active', true)
        ->orderBy('name')
        ->limit(50)
        ->get();
    }

    public function getAvailableProductsProperty()
    {
        return Product::when($this->searchProducts, function ($query) {
            $query->where('name', 'like', '%' . $this->searchProducts . '%');
        })
        ->where('status', 'active')
        ->orderBy('name')
        ->limit(50)
        ->get();
    }

    public function getSelectedCategoriesModelsProperty()
    {
        if (empty($this->selectedCategories) || !is_array($this->selectedCategories)) {
            return collect();
        }
        
        return Category::whereIn('id', $this->selectedCategories)
            ->orderBy('name')
            ->get();
    }

    public function getSelectedProductsModelsProperty()
    {
        if (empty($this->selectedProducts) || !is_array($this->selectedProducts)) {
            return collect();
        }
        
        return Product::whereIn('id', $this->selectedProducts)
            ->orderBy('name')
            ->get();
    }

    public function toggleCategory($categoryId)
    {
        try {
            if (!is_array($this->selectedCategories)) {
                $this->selectedCategories = [];
            }
            
            $categoryId = (int) $categoryId;
            
            if (in_array($categoryId, $this->selectedCategories)) {
                $this->selectedCategories = array_values(array_diff($this->selectedCategories, [$categoryId]));
                Log::info('Category removed from selection', ['category_id' => $categoryId]);
            } else {
                $this->selectedCategories[] = $categoryId;
                $this->selectedCategories = array_values(array_unique($this->selectedCategories));
                Log::info('Category added to selection', ['category_id' => $categoryId]);
            }
        } catch (\Exception $e) {
            Log::error('Error toggling category: ' . $e->getMessage());
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'خطأ في تحديث الفئة'
            ]);
        }
    }

    public function toggleProduct($productId)
    {
        try {
            if (!is_array($this->selectedProducts)) {
                $this->selectedProducts = [];
            }
            
            $productId = (int) $productId;
            
            if (in_array($productId, $this->selectedProducts)) {
                $this->selectedProducts = array_values(array_diff($this->selectedProducts, [$productId]));
                Log::info('Product removed from selection', ['product_id' => $productId]);
            } else {
                $this->selectedProducts[] = $productId;
                $this->selectedProducts = array_values(array_unique($this->selectedProducts));
                Log::info('Product added to selection', ['product_id' => $productId]);
            }
        } catch (\Exception $e) {
            Log::error('Error toggling product: ' . $e->getMessage());
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'خطأ في تحديث المنتج'
            ]);
        }
    }

    public function removeCategory($categoryId)
    {
        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = [];
        }
        
        $categoryId = (int) $categoryId;
        $this->selectedCategories = array_values(array_diff($this->selectedCategories, [$categoryId]));
        Log::info('Category removed via tag', ['category_id' => $categoryId]);
    }

    public function removeProduct($productId)
    {
        if (!is_array($this->selectedProducts)) {
            $this->selectedProducts = [];
        }
        
        $productId = (int) $productId;
        $this->selectedProducts = array_values(array_diff($this->selectedProducts, [$productId]));
        Log::info('Product removed via tag', ['product_id' => $productId]);
    }

    // Toggle methods for boolean fields
    public function toggleActive()
    {
        $this->isActive = !$this->isActive;
        Log::info('Coupon active status toggled', ['is_active' => $this->isActive]);
    }

    public function toggleAutoApply()
    {
        $this->autoApply = !$this->autoApply;
        Log::info('Coupon auto_apply toggled', ['auto_apply' => $this->autoApply]);
    }

    public function toggleStackable()
    {
        $this->stackable = !$this->stackable;
        Log::info('Coupon stackable toggled', ['stackable' => $this->stackable]);
    }

    public function toggleEmailNotifications()
    {
        $this->emailNotifications = !$this->emailNotifications;
        Log::info('Coupon email_notifications toggled', ['email_notifications' => $this->emailNotifications]);
    }

    public function toggleShowOnHomepage()
    {
        $this->showOnHomepage = !$this->showOnHomepage;
        Log::info('Coupon show_on_homepage toggled', ['show_on_homepage' => $this->showOnHomepage]);
    }

    public function updateDiscountType()
    {
        // Clear value and max_discount_amount when switching to free_shipping
        if ($this->type === 'free_shipping') {
            $this->value = 0;
            $this->maxDiscountAmount = null;
        }
        
        Log::info('Discount type updated', [
            'type' => $this->type,
            'value' => $this->value,
            'max_discount_amount' => $this->maxDiscountAmount
        ]);
    }

    public function updatedSearchCategories()
    {
        Log::info('Search categories updated', ['search' => $this->searchCategories]);
    }

    public function updatedSearchProducts()
    {
        Log::info('Search products updated', ['search' => $this->searchProducts]);
    }

    public function resetForm()
    {
        try {
            // Reset all form fields to default values
            $this->code = '';
            $this->type = 'percentage';
            $this->value = 0;
            $this->startsAt = null;
            $this->expiresAt = null;
            $this->maxUses = null;
            $this->userLimit = null;
            $this->minOrderAmount = null;
            $this->maxDiscountAmount = null;
            $this->priority = 'medium';
            $this->storeId = null;
            $this->isActive = true;
            $this->autoApply = false;
            $this->stackable = false;
            $this->emailNotifications = false;
            $this->showOnHomepage = false;
            $this->selectedCategories = [];
            $this->selectedProducts = [];
            $this->searchCategories = '';
            $this->searchProducts = '';
            
            // Clear any validation errors
            $this->resetErrorBag();
            
            $this->dispatch('showNotification', [
                'type' => 'success',
                'message' => 'تم إعادة تعيين النموذج بنجاح'
            ]);
            
            Log::info('Create coupon form reset successfully');
        } catch (\Exception $e) {
            Log::error('Error resetting form: ' . $e->getMessage());
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'خطأ في إعادة تعيين النموذج'
            ]);
        }
    }

    /**
     * Ensure data integrity
     */
    private function ensureDataIntegrity()
    {
        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = [];
        }
        if (!is_array($this->selectedProducts)) {
            $this->selectedProducts = [];
        }
        
        // Remove any null or invalid values and convert to integers
        $this->selectedCategories = array_values(array_filter(array_map('intval', $this->selectedCategories), function($id) {
            return $id > 0;
        }));
        
        $this->selectedProducts = array_values(array_filter(array_map('intval', $this->selectedProducts), function($id) {
            return $id > 0;
        }));
        
        // Remove duplicates and ensure proper indexing
        $this->selectedCategories = array_values(array_unique($this->selectedCategories));
        $this->selectedProducts = array_values(array_unique($this->selectedProducts));
    }

    public function createCoupon(Request $request)
    {
        $store = $request->attributes->get('store');
        
        try {
            // Ensure data integrity before saving
            $this->ensureDataIntegrity();
            
            // Validate all fields
            $this->validate();
            
            Log::info('Validation passed successfully for new coupon');
            
            // Prepare data for creation
            $couponData = [
                'code' => $this->code,
                'type' => $this->type,
                'value' => $this->value,
                'max_uses' => $this->maxUses,
                'min_order_amount' => $this->minOrderAmount,
                'max_discount_amount' => $this->maxDiscountAmount,
                'user_limit' => $this->userLimit,
                'priority' => $this->priority,
                'store_id' => $store->id,
                'is_active' => $this->isActive,
                'auto_apply' => $this->autoApply,
                'stackable' => $this->stackable,
                'email_notifications' => $this->emailNotifications,
                'show_on_homepage' => $this->showOnHomepage,
                'category_ids' => $this->selectedCategories,
                'product_ids' => $this->selectedProducts,
            ];

            // Handle datetime fields
            if ($this->startsAt) {
                try {
                    if (strpos($this->startsAt, 'T') !== false) {
                        $couponData['starts_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $this->startsAt);
                    } else {
                        $couponData['starts_at'] = Carbon::parse($this->startsAt);
                    }
                } catch (\Exception $e) {
                    Log::warning('Error parsing starts_at date', [
                        'starts_at' => $this->startsAt, 
                        'error' => $e->getMessage()
                    ]);
                    $couponData['starts_at'] = null;
                }
            } else {
                $couponData['starts_at'] = null;
            }

            if ($this->expiresAt) {
                try {
                    if (strpos($this->expiresAt, 'T') !== false) {
                        $couponData['expires_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $this->expiresAt);
                    } else {
                        $couponData['expires_at'] = Carbon::parse($this->expiresAt);
                    }
                } catch (\Exception $e) {
                    Log::warning('Error parsing expires_at date', [
                        'expires_at' => $this->expiresAt, 
                        'error' => $e->getMessage()
                    ]);
                    $couponData['expires_at'] = null;
                }
            } else {
                $couponData['expires_at'] = null;
            }

            // Log the data being saved
            Log::info('About to create new coupon with data:', [
                'coupon_data' => $couponData,
            ]);
            
            // Create the new coupon
            $newCoupon = Coupon::create($couponData);

            Log::info('New coupon created successfully', [
                'coupon_id' => $newCoupon->id,
                'code' => $newCoupon->code,
                'categories_count' => count($this->selectedCategories),
                'products_count' => count($this->selectedProducts)
            ]);

            // Reset form after successful creation
            $this->resetForm();

            // Dispatch success event
            $this->dispatch('showNotification', [
                'type' => 'success',
                'message' => 'تم إنشاء الكوبون بنجاح!'
            ]);

            // Optionally redirect or emit event to refresh coupon list
            $this->dispatch('couponCreated', ['coupon' => $newCoupon]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed for new coupon', ['errors' => $e->errors()]);
            
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'يرجى تصحيح الأخطاء في النموذج'
            ]);
            
            throw $e;
            
        } catch (\Exception $e) {
            Log::error('Error creating new coupon: ' . $e->getMessage(), [
                'starts_at' => $this->startsAt,
                'expires_at' => $this->expiresAt,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'خطأ في إنشاء الكوبون: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.create-coupon');
    }
}
