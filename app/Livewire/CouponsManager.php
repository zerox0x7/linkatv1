<?php

namespace App\Livewire;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class CouponsManager extends Component
{
    use WithPagination;

    public $showCouponSettings = false;
    public $selectedCoupon = null;
    public $perPage = 2; // Default value
    
    // Delete confirmation modal properties
    public $showDeleteModal = false;
    public $couponToDelete = null;
    
    // Copy functionality properties
    public $showCopySuccess = false;
    public $copiedCouponCode = '';

    protected $listeners = ['couponSettingsUpdated' => 'refreshCoupons'];
    protected $queryString = [
        
        'perPage' => ['except' => 2] // Default value
    ];
    
    public function refreshCoupons()
    {
        Log::info('couponSettingsUpdated event received');
        $this->showCouponSettings = false;
        $this->selectedCoupon = null;
        $this->resetPage();
    }

    public function openCouponSettings($couponId)  

    {
        try {
            Log::info('openCouponSettings called', ['coupon_id' => $couponId]);
            $this->selectedCoupon = Coupon::findOrFail($couponId);
            $this->showCouponSettings = true;
            Log::info('Coupon settings modal opened successfully');
        } catch (\Exception $e) {
            Log::error('Error opening coupon settings: ' . $e->getMessage());
            session()->flash('error', 'خطأ في فتح إعدادات الكوبون');
        }
    }

    public function closeCouponSettings()
    {
        $this->showCouponSettings = false;
        $this->selectedCoupon = null;
    }
    
    // Delete confirmation methods
    public function confirmDelete($couponId)
    {
        try {
            $this->couponToDelete = Coupon::findOrFail($couponId);
            $this->showDeleteModal = true;
        } catch (\Exception $e) {
            Log::error('Error finding coupon for deletion: ' . $e->getMessage());
            session()->flash('error', 'Coupon not found');
        }
    }
    
    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->couponToDelete = null;
    }
    
    public function deleteCoupon()
    {
        try {
            if ($this->couponToDelete) {
                $couponCode = $this->couponToDelete->code;
                $this->couponToDelete->delete();
                
                $this->showDeleteModal = false;
                $this->couponToDelete = null;
                
                session()->flash('success', "Coupon '{$couponCode}' has been deleted successfully");
                
                // Reset pagination if needed
                $this->resetPage();
            }
        } catch (\Exception $e) {
            Log::error('Error deleting coupon: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete coupon. Please try again.');
            $this->showDeleteModal = false;
            $this->couponToDelete = null;
        }
    }
    
    // Copy coupon functionality
    public function copyCoupon($couponId)
    {
        try {
            $coupon = Coupon::findOrFail($couponId);
            $this->copiedCouponCode = $coupon->code;
            
            // Emit event to trigger JavaScript copy
            $this->dispatch('copyToClipboard', code: $coupon->code);
            
            // Show success feedback
            $this->showCopySuccess = true;
            
            // Hide success message after 3 seconds
            $this->dispatch('hideCopySuccess');
            
        } catch (\Exception $e) {
            Log::error('Error copying coupon: ' . $e->getMessage());
            session()->flash('error', 'Failed to copy coupon code');
        }
    }
    
    public function hideCopySuccess()
    {
        $this->showCopySuccess = false;
        $this->copiedCouponCode = '';
    }

    public function render()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')
            ->paginate($this->perPage);  // Use the perPage query string this will be send with the request query string

        return view('livewire.coupons-manager', compact('coupons'));
    }
}