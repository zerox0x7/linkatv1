<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Debounce;
use App\Models\Product;
use App\Models\Category;

class ProductSearch extends Component
{
    public $searchTerm = '';
    public $activeTab = 'products'; // 'products' or 'categories'
    public $selectedProducts = [];
    public $selectedCategories = [];
    public $searchResults = [];
    public $categories = [];

    public function mount($selectedProducts = [], $selectedCategories = [])
    {
        $this->selectedProducts = $selectedProducts;
        $this->selectedCategories = $selectedCategories;
        $this->loadInitialData();
    }

    public function loadInitialData()
    {
        $store = request()->attributes->get('store');
        $this->categories = Category::where('store_id', $store->id)
            ->orderBy('name')
            ->get();
        $this->searchProducts();
    }

    public function updatedActiveTab()
    {
        $this->searchTerm = '';
        if ($this->activeTab === 'products') {
            $this->searchProducts();
        } else {
            $this->searchCategories();
        }
    }

    #[Debounce(300)]
    public function updatedSearchTerm()
    {
        if ($this->activeTab === 'products') {
            $this->searchProducts();
        } else {
            $this->searchCategories();
        }
    }

    public function searchProducts()
    {
        $store = request()->attributes->get('store');
        $query = Product::where('store_id', $store->id);
        
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        $this->searchResults = $query->orderBy('name')->limit(50)->get();
    }

    public function searchCategories()
    {
        $store = request()->attributes->get('store');
        $query = Category::where('store_id', $store->id);
        
        if (!empty($this->searchTerm)) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }
        
        $this->searchResults = $query->orderBy('name')->limit(50)->get();
    }

    public function toggleProduct($productId)
    {
        if (in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts = array_filter($this->selectedProducts, function($id) use ($productId) {
                return $id != $productId;
            });
            $this->dispatch('product-deselected', productId: $productId);
        } else {
            $this->selectedProducts[] = $productId;
            $this->dispatch('product-selected', productId: $productId);
        }
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_filter($this->selectedCategories, function($id) use ($categoryId) {
                return $id != $categoryId;
            });
            $this->dispatch('category-deselected', categoryId: $categoryId);
        } else {
            $this->selectedCategories[] = $categoryId;
            $this->dispatch('category-selected', categoryId: $categoryId);
        }
    }

    public function render()
    {
        return view('livewire.product-search');
    }
}