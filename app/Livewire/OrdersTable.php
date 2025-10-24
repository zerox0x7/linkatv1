<?php

namespace App\Livewire;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Http\Request;

class OrdersTable extends Component
{
    public $orderNumber = '';
    public $customerName = '';
    public $productName = '';
    public $orderPrice = '';
    public $orderDate = '';
   
    public function handleClick()
    {
        // This method will trigger the render method automatically
        // due to Livewire's reactive properties
    }

    public function clearFilters()
    {
        $this->orderNumber = '';
        $this->customerName = '';
        $this->productName = '';
        $this->orderPrice = '';
        $this->orderDate = '';
    }
    
    public function render(Request $request)
    {
        $store = $request->attributes->get('store');

        $query = Order::where('store_id', $store->id)->with(['user', 'items']);

        // Filter by order number
        if (!empty($this->orderNumber)) {
            $query->where('id', 'LIKE', '%' . $this->orderNumber . '%');
        }

        // Filter by customer name
        if (!empty($this->customerName)) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->customerName . '%');
            });
        }

        // Filter by product name
        if (!empty($this->productName)) {
            $query->whereHas('items', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->productName . '%');
            });
        }

        // Filter by order price
        if (!empty($this->orderPrice)) {
            $query->where('total', '=', $this->orderPrice);
        }

        // Filter by order date
        if (!empty($this->orderDate)) {
            $query->whereDate('created_at', $this->orderDate);
        }

        // If no filters are applied, show recent orders
        if (empty($this->orderNumber) && empty($this->customerName) && 
            empty($this->productName) && empty($this->orderPrice) && 
            empty($this->orderDate)) {
            $recentOrders = $query->orderBy('created_at', 'desc')->take(3)->get();
        } else {
            $recentOrders = $query->orderBy('created_at', 'desc')->get();
        }

        return view('livewire.orders-table', compact('recentOrders'));
    }
}