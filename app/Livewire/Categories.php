<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Category;
use Livewire\WithPagination;

class Categories extends Component
{

        use WithPagination;
    public $selectedCategory = '';
    public $selectedStatus = '';
    public $showCategoryDropdown = false;
    public $showStatusDropdown = false;
    public $search = '';
    public $perPage = 3; // Default value

    // Delete confirmation modal properties
    public $showDeleteModal = false;
    public $categoryToDelete = null;

 protected $listeners = ['categoryAdded'];

  public function categoryAdded()
    {
        // Refresh the categories list when a new category is added
        $this->resetPage();
        session()->flash('success', 'تم إضافة الفئة بنجاح');
    }

    // Delete confirmation methods
    public function confirmDelete($categoryId)
    {
        $this->categoryToDelete = Category::find($categoryId);
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->categoryToDelete = null;
    }

    public function deleteCategory()
    {
        if ($this->categoryToDelete) {
            try {
                // Check if category has products
                $hasProducts = $this->categoryToDelete->products()->count() > 0;
                
                if ($hasProducts) {
                    session()->flash('error', 'لا يمكن حذف هذه الفئة لأنها تحتوي على منتجات');
                    $this->cancelDelete();
                    return;
                }

                $this->categoryToDelete->delete();
                session()->flash('success', 'تم حذف الفئة بنجاح');
                
                // Reset pagination if needed
                $this->resetPage();
                
            } catch (\Exception $e) {
                session()->flash('error', 'حدث خطأ أثناء حذف الفئة');
            }
        }
        
        $this->cancelDelete();
    }

        protected $queryString = [
        'selectedCategory' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 4]
    ];


    public function render(Request $request)
    {

        $store = $request->attributes->get('store');

        // dd($request->all());

         $perPage = (int) $request->input('perPage');

        // if (!isset($perPage) || !is_numeric($perPage) || $perPage <= 0) {
        //         $perPage = 4; // Set default value
        //         dd($perPage);
        //     }

        $cate = Category::where('store_id',$store->id )->withCount('products')->paginate($this->perPage);
      
        // dd($categories[0]);
        // dd($categories);
        // dd($cats);
        return view('livewire.categories', compact('cate'));
    }
}
