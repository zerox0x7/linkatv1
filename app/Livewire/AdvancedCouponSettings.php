<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AdvancedCouponSettings extends Component
{
    public $min_coupon_order_value = '';
    public $max_coupon_discount_amount = '';
    public $max_coupon_discount_percentage = '';
    public $allow_coupon_stacking = false;
    public $coupon_start_date = '';
    public $coupon_end_date = '';
    
    // Product selection properties
    public $selected_product_id = null;
    public $selected_product = null;
    public $product_search = '';
    public $show_product_dropdown = false;
    public $available_products = [];

    protected $rules = [
        'min_coupon_order_value' => 'nullable|numeric|min:0',
        'max_coupon_discount_amount' => 'nullable|numeric|min:0',
        'max_coupon_discount_percentage' => 'nullable|numeric|min:0|max:100',
        'allow_coupon_stacking' => 'boolean',
        'coupon_start_date' => 'nullable|date',
        'coupon_end_date' => 'nullable|date|after_or_equal:coupon_start_date',
        'selected_product_id' => 'nullable|exists:products,id',
    ];

    protected $messages = [
        'min_coupon_order_value.numeric' => 'الحد الأدنى لقيمة الطلب يجب أن يكون رقم صحيح',
        'min_coupon_order_value.min' => 'الحد الأدنى لقيمة الطلب يجب أن يكون أكبر من أو يساوي 0',
        'max_coupon_discount_amount.numeric' => 'الحد الأقصى لمبلغ الخصم يجب أن يكون رقم صحيح',
        'max_coupon_discount_amount.min' => 'الحد الأقصى لمبلغ الخصم يجب أن يكون أكبر من أو يساوي 0',
        'max_coupon_discount_percentage.numeric' => 'الحد الأقصى لنسبة الخصم يجب أن يكون رقم صحيح',
        'max_coupon_discount_percentage.min' => 'الحد الأقصى لنسبة الخصم يجب أن يكون أكبر من أو يساوي 0',
        'max_coupon_discount_percentage.max' => 'الحد الأقصى لنسبة الخصم يجب أن يكون أقل من أو يساوي 100',
        'coupon_start_date.date' => 'تاريخ بداية الكوبون يجب أن يكون تاريخ صحيح',
        'coupon_end_date.date' => 'تاريخ انتهاء الكوبون يجب أن يكون تاريخ صحيح',
        'coupon_end_date.after_or_equal' => 'تاريخ انتهاء الكوبون يجب أن يكون بعد أو يساوي تاريخ البداية',
        'selected_product_id.exists' => 'المنتج المحدد غير موجود',
    ];

    public function mount()
    {
        // Load existing settings if they exist
        $this->loadSettings();
        // Initialize available products
        $this->loadAvailableProducts();
    }

    public function updatedProductSearch()
    {
        $this->loadAvailableProducts();
        $this->show_product_dropdown = true;
    }

    public function loadAvailableProducts()
    {
        $query = Product::where('status', '!=', 'deleted')
                       ->orderBy('name');
        
        if (!empty($this->product_search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->product_search . '%')
                  ->orWhere('sku', 'like', '%' . $this->product_search . '%')
                  ->orWhere('description', 'like', '%' . $this->product_search . '%');
            });
        }
        
        $this->available_products = $query->limit(20)->get();
    }

    public function selectProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->selected_product_id = $productId;
            $this->selected_product = $product;
            $this->product_search = $product->name;
            $this->show_product_dropdown = false;
            
            // Auto-fill coupon settings based on product's existing values
            $this->min_coupon_order_value = $product->min_coupon_order_value ?: '';
            $this->max_coupon_discount_amount = $product->max_coupon_discount_amount ?: '';
            $this->max_coupon_discount_percentage = $product->max_coupon_discount_percentage ?: '';
            $this->allow_coupon_stacking = $product->allow_coupon_stacking ?: false;
            $this->coupon_start_date = $product->coupon_start_date ? $product->coupon_start_date->format('Y-m-d') : '';
            $this->coupon_end_date = $product->coupon_end_date ? $product->coupon_end_date->format('Y-m-d') : '';
        }
    }

    public function clearProductSelection()
    {
        $this->selected_product_id = null;
        $this->selected_product = null;
        $this->product_search = '';
        $this->show_product_dropdown = false;
        
        // Reset form fields when clearing selection
        $this->resetFormFields();
    }

    public function showProductDropdown()
    {
        $this->show_product_dropdown = true;
        $this->loadAvailableProducts();
    }

    public function hideProductDropdown()
    {
        $this->show_product_dropdown = false;
    }

    public function saveSettings()
    {
        $this->validate();

        // If a product is selected, update the product's coupon settings
        if ($this->selected_product_id) {
            $product = Product::find($this->selected_product_id);
            if ($product) {
                // Prepare the data for updating
                $updateData = [
                    'min_coupon_order_value' => !empty($this->min_coupon_order_value) ? (float)$this->min_coupon_order_value : null,
                    'max_coupon_discount_amount' => !empty($this->max_coupon_discount_amount) ? (float)$this->max_coupon_discount_amount : null,
                    'max_coupon_discount_percentage' => !empty($this->max_coupon_discount_percentage) ? (float)$this->max_coupon_discount_percentage : null,
                    'allow_coupon_stacking' => (bool)$this->allow_coupon_stacking,
                    'coupon_start_date' => !empty($this->coupon_start_date) ? \Carbon\Carbon::parse($this->coupon_start_date) : null,
                    'coupon_end_date' => !empty($this->coupon_end_date) ? \Carbon\Carbon::parse($this->coupon_end_date) : null,
                ];

                // Update the product with coupon settings
                $product->update($updateData);
                
                // Mark product as having coupon settings configured
                $product->update(['coupon_eligible' => true]);
                
                session()->flash('message', 'تم حفظ إعدادات الكوبون للمنتج "' . $product->name . '" بنجاح!');
                
                // Refresh the selected product data
                $this->selected_product = $product->fresh();
            }
        } else {
            // If no product is selected, apply settings to all eligible products
            // Or save as global settings - implement based on your requirements
            session()->flash('message', 'يرجى تحديد منتج أولاً لحفظ الإعدادات عليه');
        }
    }

    private function resetFormFields()
    {
        $this->min_coupon_order_value = '';
        $this->max_coupon_discount_amount = '';
        $this->max_coupon_discount_percentage = '';
        $this->allow_coupon_stacking = false;
        $this->coupon_start_date = '';
        $this->coupon_end_date = '';
    }

    private function loadSettings()
    {
        // Load existing settings from database or config if needed
        // This method can be extended to load global coupon settings
    }

    public function render()
    {
        return view('livewire.advanced-coupon-settings');
    }
}
