<?php

namespace App\Livewire;

use Livewire\Component;

class CouponCard extends Component
{
    public $couponCode = 'FLASH50';
    public $discount = '50%';
    public $validUntil = 'Jun 7, 2025';
    public $validFrom = 'Jun 5, 2025';
    public $used = 89;
    public $usageLimit = 200;
    public $type = 'Percentage';
    public $status = 'Active';

    public function render()
    {
        return view('livewire.coupon-card');
    }

    public function updatedCouponCode()
    {
        // You can add validation or formatting logic here
        $this->couponCode = strtoupper($this->couponCode);
    }
}