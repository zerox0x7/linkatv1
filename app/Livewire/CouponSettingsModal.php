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

class CouponSettingsModal extends Component
{
    public Coupon $coupon;
    public string $code;
    public string $searchCategories = '';
    public string $searchProducts = '';
    public array $selectedCategories = [];
    public array $selectedProducts = [];
    public bool $isActive = false;
    
    // New public variables for all coupon settings
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
        'code' => 'required|string|max:255',
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

    

    public function mount(Coupon $coupon)
    {
        $this->coupon = $coupon;
        
        try {
            // Debug: Check what we're getting from the model
            Log::info('Loading coupon data in mount', [
                'coupon_id' => $coupon->id,
                'category_ids_raw' => $coupon->getRawOriginal('category_ids'),
                'product_ids_raw' => $coupon->getRawOriginal('product_ids'),
                'category_ids_cast' => $coupon->category_ids,
                'product_ids_cast' => $coupon->product_ids,
                'category_ids_type' => gettype($coupon->category_ids),
                'product_ids_type' => gettype($coupon->product_ids),
            ]);
            
            // Load existing IDs from JSON fields in coupons table
            // Ensure we handle both array and string cases properly
            if (is_array($coupon->category_ids)) {
                $this->selectedCategories = $coupon->category_ids;
            } elseif (is_string($coupon->category_ids)) {
                $this->selectedCategories = json_decode($coupon->category_ids, true) ?? [];
            } else {
                $this->selectedCategories = [];
            }
            
            if (is_array($coupon->product_ids)) {
                $this->selectedProducts = $coupon->product_ids;
            } elseif (is_string($coupon->product_ids)) {
                $this->selectedProducts = json_decode($coupon->product_ids, true) ?? [];
            } else {
                $this->selectedProducts = [];
            }
            
            // Ensure arrays are properly formatted
            if (!is_array($this->selectedCategories)) {
                $this->selectedCategories = [];
            }
            if (!is_array($this->selectedProducts)) {
                $this->selectedProducts = [];
            }
            
            // Load all coupon data into public variables
            $this->code = $coupon->code ?? '';
            $this->type = $coupon->type ?? 'percentage';
            $this->value = $coupon->value ?? 0;
            $this->maxUses = $coupon->max_uses;
            $this->userLimit = $coupon->user_limit;
            $this->minOrderAmount = $coupon->min_order_amount;
            $this->maxDiscountAmount = $coupon->max_discount_amount;
            $this->priority = $coupon->priority ?? 'medium';
            $this->storeId = $coupon->store_id;
            $this->isActive = $coupon->is_active ?? false;
            $this->autoApply = $coupon->auto_apply ?? false;
            $this->stackable = $coupon->stackable ?? false;
            $this->emailNotifications = $coupon->email_notifications ?? false;
            $this->showOnHomepage = $coupon->show_on_homepage ?? false;
            
            // Ensure data integrity
            $this->ensureDataIntegrity();
            
            // Format dates for datetime-local input only if they exist and are valid
            if ($coupon->starts_at) {
                try {
                    // If it's already a Carbon instance, use it directly
                    if ($coupon->starts_at instanceof \Carbon\Carbon) {
                        $this->startsAt = $coupon->starts_at->format('Y-m-d\TH:i');
                    } else {
                        // Parse the string date
                        $this->startsAt = Carbon::parse($coupon->starts_at)->format('Y-m-d\TH:i');
                    }
                } catch (\Exception $e) {
                    Log::warning('Error formatting starts_at date in mount', [
                        'starts_at' => $coupon->starts_at,
                        'error' => $e->getMessage(),
                        'coupon_id' => $coupon->id
                    ]);
                    $this->startsAt = null;
                }
            }
            if ($coupon->expires_at) {
                try {
                    // If it's already a Carbon instance, use it directly
                    if ($coupon->expires_at instanceof \Carbon\Carbon) {
                        $this->expiresAt = $coupon->expires_at->format('Y-m-d\TH:i');
                    } else {
                        // Parse the string date
                        $this->expiresAt = Carbon::parse($coupon->expires_at)->format('Y-m-d\TH:i');
                    }
                } catch (\Exception $e) {
                    Log::warning('Error formatting expires_at date in mount', [
                        'expires_at' => $coupon->expires_at,
                        'error' => $e->getMessage(),
                        'coupon_id' => $coupon->id
                    ]);
                    $this->expiresAt = null;
                }
            }
                
            Log::info('CouponSettingsModal mounted successfully', [
                'coupon_id' => $coupon->id,
                'selected_categories_count' => count($this->selectedCategories),
                'selected_products_count' => count($this->selectedProducts),
                'selected_categories' => $this->selectedCategories,
                'selected_products' => $this->selectedProducts,
                'coupon_data' => [
                    'code' => $this->code,
                    'type' => $this->type,
                    'value' => $this->value,
                    'is_active' => $this->isActive,
                    'auto_apply' => $this->autoApply,
                    'stackable' => $this->stackable,
                    'show_on_homepage' => $this->showOnHomepage,
                    'email_notifications' => $this->emailNotifications,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error mounting CouponSettingsModal: ' . $e->getMessage());
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'خطأ في تحميل إعدادات الكوبون: ' . $e->getMessage()
            ]);
        }
    }

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
            // Ensure selectedCategories is an array
            if (!is_array($this->selectedCategories)) {
                $this->selectedCategories = [];
            }
            
            $categoryId = (int) $categoryId; // Ensure it's an integer
            
            if (in_array($categoryId, $this->selectedCategories)) {
                // Remove category
                $this->selectedCategories = array_values(array_diff($this->selectedCategories, [$categoryId]));
                Log::info('Category removed from selection', ['category_id' => $categoryId]);
            } else {
                // Add category
                $this->selectedCategories[] = $categoryId;
                $this->selectedCategories = array_values(array_unique($this->selectedCategories)); // Remove duplicates
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
            // Ensure selectedProducts is an array
            if (!is_array($this->selectedProducts)) {
                $this->selectedProducts = [];
            }
            
            $productId = (int) $productId; // Ensure it's an integer
            
            if (in_array($productId, $this->selectedProducts)) {
                // Remove product
                $this->selectedProducts = array_values(array_diff($this->selectedProducts, [$productId]));
                Log::info('Product removed from selection', ['product_id' => $productId]);
            } else {
                // Add product
                $this->selectedProducts[] = $productId;
                $this->selectedProducts = array_values(array_unique($this->selectedProducts)); // Remove duplicates
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
        // This method will be called when searchCategories changes
        Log::info('Search categories updated', ['search' => $this->searchCategories]);
    }

    public function updatedSearchProducts()
    {
        // This method will be called when searchProducts changes
        Log::info('Search products updated', ['search' => $this->searchProducts]);
    }

    public function resetForm()
    {
        try {
            // Reload the original coupon data from database
            $this->coupon->refresh();
            
            // Re-sync all data from the database
            $this->syncFromDatabase();
            
            // Reload all public variables from the refreshed coupon
            $this->code = $this->coupon->code ?? '';
            $this->type = $this->coupon->type ?? 'percentage';
            $this->value = $this->coupon->value ?? 0;
            $this->maxUses = $this->coupon->max_uses;
            $this->userLimit = $this->coupon->user_limit;
            $this->minOrderAmount = $this->coupon->min_order_amount;
            $this->maxDiscountAmount = $this->coupon->max_discount_amount;
            $this->priority = $this->coupon->priority ?? 'medium';
            $this->storeId = $this->coupon->store_id;
            $this->isActive = $this->coupon->is_active ?? false;
            $this->autoApply = $this->coupon->auto_apply ?? false;
            $this->stackable = $this->coupon->stackable ?? false;
            $this->emailNotifications = $this->coupon->email_notifications ?? false;
            $this->showOnHomepage = $this->coupon->show_on_homepage ?? false;
            
            // Format dates again safely for the form inputs
            if ($this->coupon->starts_at) {
                try {
                    // If it's already a Carbon instance, use it directly
                    if ($this->coupon->starts_at instanceof \Carbon\Carbon) {
                        $this->startsAt = $this->coupon->starts_at->format('Y-m-d\TH:i');
                    } else {
                        // Parse the string date
                        $this->startsAt = Carbon::parse($this->coupon->starts_at)->format('Y-m-d\TH:i');
                    }
                } catch (\Exception $e) {
                    Log::warning('Error formatting starts_at date in reset', [
                        'starts_at' => $this->coupon->starts_at,
                        'error' => $e->getMessage(),
                        'coupon_id' => $this->coupon->id
                    ]);
                    $this->startsAt = null;
                }
            }
            if ($this->coupon->expires_at) {
                try {
                    // If it's already a Carbon instance, use it directly
                    if ($this->coupon->expires_at instanceof \Carbon\Carbon) {
                        $this->expiresAt = $this->coupon->expires_at->format('Y-m-d\TH:i');
                    } else {
                        // Parse the string date
                        $this->expiresAt = Carbon::parse($this->coupon->expires_at)->format('Y-m-d\TH:i');
                    }
                } catch (\Exception $e) {
                    Log::warning('Error formatting expires_at date in reset', [
                        'expires_at' => $this->coupon->expires_at,
                        'error' => $e->getMessage(),
                        'coupon_id' => $this->coupon->id
                    ]);
                    $this->expiresAt = null;
                }
            }
            
            // Clear any validation errors
            $this->resetErrorBag();
            
            // Dispatch success notification
            $this->dispatch('showNotification', [
                'type' => 'success',
                'message' => 'تم إعادة تعيين النموذج بنجاح'
            ]);
            
            Log::info('Form reset successfully', [
                'coupon_id' => $this->coupon->id,
                'categories_count' => count($this->selectedCategories),
                'products_count' => count($this->selectedProducts)
            ]);
        } catch (\Exception $e) {
            Log::error('Error resetting form: ' . $e->getMessage());
            // Dispatch error notification
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'خطأ في إعادة تعيين النموذج'
            ]);
        }
    }

    /**
     * Ensure data integrity after operations
     */
    private function ensureDataIntegrity()
    {
        // Ensure arrays are properly formatted
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

    public function saveCoupons(Request $request)
    {        
        $store = $request->attributes->get('store');
        // dd($store);
        try {
            // Ensure data integrity before saving
            $this->ensureDataIntegrity();
            
            // Complete validation with all required fields
            $this->validate([
                'code' => 'required|string|max:255|unique:coupons,code,' . $this->coupon->id,
                'type' => 'required|in:percentage,fixed,free_shipping',
                'value' => 'required|numeric|min:0',
                'startsAt' => 'nullable|date',
                'expiresAt' => 'nullable|date|after:startsAt',
                'maxUses' => 'nullable|integer|min:1',
                'minOrderAmount' => 'nullable|numeric|min:0',
                'maxDiscountAmount' => 'nullable|numeric|min:0',
                'userLimit' => 'nullable|integer|min:1',
                'priority' => 'required|in:high,medium,low',
            ]);
            
            Log::info('Validation passed successfully');
            
            // Prepare data for update - use all public variables
            $updateData = [
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
                // The model's casting will handle converting arrays to JSON automatically
                'category_ids' => $this->selectedCategories,
                'product_ids' => $this->selectedProducts,
            ];

            // Handle datetime fields
            if ($this->startsAt) {
                try {
                    if (strpos($this->startsAt, 'T') !== false) {
                        // It's in datetime-local format (Y-m-d\TH:i)
                        $updateData['starts_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $this->startsAt);
                    } else {
                        // Try to parse as is
                        $updateData['starts_at'] = Carbon::parse($this->startsAt);
                    }
                } catch (\Exception $e) {
                    Log::warning('Error parsing starts_at date', [
                        'starts_at' => $this->startsAt, 
                        'error' => $e->getMessage(),
                        'coupon_id' => $this->coupon->id
                    ]);
                    $updateData['starts_at'] = null;
                }
            } else {
                $updateData['starts_at'] = null;
            }

            if ($this->expiresAt) {
                try {
                    if (strpos($this->expiresAt, 'T') !== false) {
                        // It's in datetime-local format (Y-m-d\TH:i)
                        $updateData['expires_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $this->expiresAt);
                    } else {
                        // Try to parse as is
                        $updateData['expires_at'] = Carbon::parse($this->expiresAt);
                    }
                } catch (\Exception $e) {
                    Log::warning('Error parsing expires_at date', [
                        'expires_at' => $this->expiresAt, 
                        'error' => $e->getMessage(),
                        'coupon_id' => $this->coupon->id
                    ]);
                    $updateData['expires_at'] = null;
                }
            } else {
                $updateData['expires_at'] = null;
            }

            // Log the data being saved
            Log::info('About to update coupon with data:', [
                'coupon_id' => $this->coupon->id,
                'update_data' => $updateData,
            ]);
            
            // Update the coupon - let the model's casting handle JSON conversion
            $this->coupon->update($updateData);

            // Refresh the coupon model to get the latest data from database
            $this->coupon->refresh();
            
            // Re-sync our local arrays with the database after save
            $this->syncFromDatabase();

            Log::info('Coupon settings saved successfully', [
                'coupon_id' => $this->coupon->id,
                'final_categories_count' => count($this->selectedCategories),
                'final_products_count' => count($this->selectedProducts)
            ]);

            // Dispatch success event for popup notification
            $this->dispatch('showNotification', [
                'type' => 'success',
                'message' => 'تم حفظ إعدادات الكوبون بنجاح!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed for coupon settings', ['errors' => $e->errors()]);
            
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'يرجى تصحيح الأخطاء في النموذج'
            ]);
            
            // Re-throw to show validation errors in the form
            throw $e;
            
        } catch (\Exception $e) {
            Log::error('Error saving coupon settings: ' . $e->getMessage(), [
                'coupon_id' => $this->coupon->id,
                'starts_at' => $this->startsAt,
                'expires_at' => $this->expiresAt,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->dispatch('showNotification', [
                'type' => 'error',
                'message' => 'خطأ في حفظ إعدادات الكوبون: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Sync local arrays with database data
     */
    private function syncFromDatabase()
    {
        // Handle the fact that the model might return arrays or strings depending on casting
        if (is_array($this->coupon->category_ids)) {
            $this->selectedCategories = $this->coupon->category_ids;
        } elseif (is_string($this->coupon->category_ids)) {
            $this->selectedCategories = json_decode($this->coupon->category_ids, true) ?? [];
        } else {
            $this->selectedCategories = [];
        }
        
        if (is_array($this->coupon->product_ids)) {
            $this->selectedProducts = $this->coupon->product_ids;
        } elseif (is_string($this->coupon->product_ids)) {
            $this->selectedProducts = json_decode($this->coupon->product_ids, true) ?? [];
        } else {
            $this->selectedProducts = [];
        }
        
        $this->ensureDataIntegrity();
    }

    public function testSave()
    {
        Log::info('Test save method called', [
            'coupon_id' => $this->coupon->id,
            'categories' => $this->selectedCategories,
            'products' => $this->selectedProducts,
        ]);
        
        $this->dispatch('showNotification', [
            'type' => 'success',
            'message' => 'Test save method called successfully!'
        ]);
    }

    public function render()
    {
        return view('livewire.coupon-settings-modal');
    }
}