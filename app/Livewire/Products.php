<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Admin\ImageUploadController;
use Illuminate\Support\Facades\Crypt;
use Livewire\WithPagination;

class Products extends Component
{

    use WithPagination;

    public $selectedCategory = '';
    public $selectedStatus = '';
    public $showCategoryDropdown = false;
    public $showStatusDropdown = false;
    public $search = '';
    public $perPage = 4; // Default value
        

    // listen to the toggle componet and run when it run 




    // protected $listeners = ['closeDropdowns','toggleChanged'];
 protected $listeners = ['childActionTriggered' => 'handleChildAction','closeDropdowns'];

    public function handleChildAction($data)
    {
        // Handle the event from the child component
        // dd('Event received from child:', $data);
    }

    

    public function statusToggled()
{
    // This will refresh the component when status changes
    $this->render();
}
    public function closeDropdowns()
    {
        $this->showCategoryDropdown = false;
        $this->showStatusDropdown = false;
    }

    public function getCategoryName($category)
{
    $categories = [
        'electronics' => 'إلكترونيات',
        'clothing' => 'ملابس', 
        'home' => 'المنزل والمطبخ',
        'beauty' => 'الجمال'
    ];
    
    return $categories[$category] ?? 'جميع الفئات';
}

public function getStatusName($status)
{
    $statuses = [
        'active' => 'نشط',
        'inactive' => 'غير نشط'
    ];
    
    return $statuses[$status] ?? 'حالة المنتج';
}


    protected $queryString = [
        'selectedCategory' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'perPage' => ['except' => 4]
    ];

    public function updatedSelectedCategory()
    {
        $this->resetPage();
        $this->showCategoryDropdown = false;
    }

    public function updatedSelectedStatus()
    {
        $this->resetPage();
        $this->showStatusDropdown = false;
    }

    public function toggleCategoryDropdown()
    {
        $this->showCategoryDropdown = !$this->showCategoryDropdown;
        $this->showStatusDropdown = false;
    }

    public function toggleStatusDropdown()
    {
        $this->showStatusDropdown = !$this->showStatusDropdown;
        $this->showCategoryDropdown = false;
    }

      public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->showCategoryDropdown = false;
    }

    public function selectStatus($status)
    {
        $this->selectedStatus = $status;
        $this->showStatusDropdown = false;
    }

    public function clearFilters()
    {
        $this->selectedCategory = '';
        $this->selectedStatus = '';
        $this->showCategoryDropdown = false;
        $this->showStatusDropdown = false;
        $this->resetPage();
    }

    public function destroy($productId)
    {
        // Your deletion logic here
        Product::findOrFail($productId)->delete();
        
        // Optional: Add a success message
        session()->flash('message', 'تم حذف المنتج بنجاح');
    }



        public function getSelectedCategoryName()
    {
        if ($this->selectedCategory) {
            $category = Category::find($this->selectedCategory);
            return $category ? $category->name : 'جميع الفئات';
        }
        return 'جميع الفئات';
    }

    public function search()
    {

    }

    public function render(Request $request)
    {


        $store = $request->attributes->get('store');
             $query = Product::query();

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedStatus) {
            // dd($this->selectedStatus);
            $query->where('status', $this->selectedStatus);
        }
        // $products = Product::where('store_id',$store->id )->with('category')
        //                 ->orderBy('created_at', 'desc')
        //                 ->paginate(15);

        // dd($products);

        // Dynamic pagination - uses per_page parameter or defaults to 15
        $perPage = (int) $request->input('per_page');


        if (!isset($perPage) || !is_numeric($perPage) || $perPage <= 0) {
                $perPage = 4; // Set default value
            }
                    

        $products = $query->where('store_id',$store->id )->paginate($this->perPage);

        $categories = Category::where('store_id',$store->id )->get();

        return view('livewire.products', compact('products','categories'));
    }
}
