<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\Product;

class ProductStatusToggle extends Component
{
    public $product; // The product model
    public $status;  // The current status of the product

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->status = $product->status; // Load the initial status
    }

    public function toggleStatus()
    {
        // Toggle the status
        if($this->status == "active" )
        {
            $this->status = "inactive";
        }else
        {
            $this->status = "active";
        }
        // dd($this->status);
        // Update the product status in the database
        $this->product->update(['status' => $this->status]);
        // Optional: Emit an event or show a success message
        // session()->flash('message', 'Product status updated successfully!');

        $this->dispatch('childActionTriggered', ['key' => 'value']);

    }

    public function render()
    {
        

        return view('livewire.product-status-toggle');
    }
}