<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;

class CategoryAddNew extends Component
{


    use WithFileUploads;

    public $showModal = false;
    public $name = '';
    public $description = '';
    public $image;
    public $imagePreview;
    public $order = 1;
    public $home_order = 1;
    public $is_active = true;
    public $color = '#10B981'; // Default color
    public $icon = ''; // Add icon property

    // Available colors for categories
    public $availableColors = [
        '#10B981' => 'أخضر',
        '#3B82F6' => 'أزرق', 
        '#F59E0B' => 'برتقالي',
        '#EF4444' => 'أحمر',
        '#8B5CF6' => 'بنفسجي',
        '#F97316' => 'برتقالي داكن',
        '#06B6D4' => 'سماوي',
        '#84CC16' => 'أخضر فاتح',
        '#EC4899' => 'وردي',
        '#6366F1' => 'نيلي'
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048', // 2MB Max
        'order' => 'required|integer|min:1',
        'home_order' => 'required|integer|min:1',
        'color' => 'required|string',
        'icon' => 'nullable|string', // Add icon validation
        'is_active' => 'boolean'
    ];

    protected $messages = [
        'name.required' => 'اسم الفئة مطلوب',
        'name.max' => 'اسم الفئة يجب أن يكون أقل من 255 حرف',
        'description.max' => 'وصف الفئة يجب أن يكون أقل من 1000 حرف',
        'image.image' => 'يجب أن يكون الملف صورة',
        'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
        'order.required' => 'ترتيب الفئة مطلوب',
        'order.min' => 'ترتيب الفئة يجب أن يكون 1 على الأقل',
        'home_order.required' => 'ترتيب الصفحة الرئيسية مطلوب',
        'home_order.min' => 'ترتيب الصفحة الرئيسية يجب أن يكون 1 على الأقل'
    ];

    // Add listener for icon updates and modal opening
    protected $listeners = ['updateWireModel', 'openModal'];

    public function updateWireModel($property, $value)
    {
        if ($property === 'icon') {
            $this->icon = $value;
        }
    }

    public function removeImage()
    {
           $this->image = null;
        $this->imagePreview = null;
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:8192',
        ]);

        if ($this->image) {
            $this->imagePreview = $this->image->temporaryUrl();
        }
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->image = null;
        $this->imagePreview = null;
        $this->order = 1;
        $this->home_order = 1;
        $this->is_active = true;
        $this->color = '#10B981';
        $this->icon = ''; // Reset icon field
    }

    public function store(Request $request )
    {
        
       
         $store = $request->attributes->get('store');

        try {

            
            $imagePath = null;

            if ($this->image) {
                // Store the original image
                $imagePath = $this->image->store('categories', 'public');
                
                // Create thumbnail directory if it doesn't exist
                $thumbnailDir = storage_path('app/public/categories/thumbnails');
                if (!file_exists($thumbnailDir)) {
                    mkdir($thumbnailDir, 0755, true);
                }
                
                // Create thumbnail using Intervention Image v3
                $manager = new ImageManager(new Driver());
                $image = $manager->read(storage_path('app/public/' . $imagePath));
                $image->scale(width: 300, height: 300);
                
                // Save thumbnail
                $thumbnailPath = 'categories/thumbnails/' . basename($imagePath);
                $image->save(storage_path('app/public/' . $thumbnailPath));
            }

       


            //  dd($this->name,$this->description,$imagePath,  $this->order,$this->home_order,$this->color,$this->is_active);
// dd($this->color);
              Category::create([
                'name' => $this->name,
                'description' => $this->description,
                'image' => $imagePath,
                'order' => $this->order,
                'homepage_order' => $this->home_order,
                'bg_color' => $this->color,
                'icon' => $this->icon, // Add icon to database save
                'is_active' => $this->is_active,
                'slug'   => Str::slug($this->name),
                'store_id' => $store->id
            ]);


            
          
            $this->closeModal();

            $this->dispatch('categoryAdded', ['key' => 'value']);

            
            session()->flash('message', 'تم إضافة الفئة بنجاح');

        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء إضافة الفئة');
        }
    }

    public function render()
    {
        return view('livewire.category-add-new');
    }
}