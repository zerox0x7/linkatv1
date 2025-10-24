<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\StaticPage;
use Livewire\WithPagination;

class StaticPages extends Component
{
    use WithPagination;
    
    public $search = '';
    public $perPage = 10;
    
    // Delete confirmation modal properties
    public $showDeleteModal = false;
    public $pageToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    // Delete confirmation methods
    public function confirmDelete($pageId)
    {
        $this->pageToDelete = StaticPage::find($pageId);
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->pageToDelete = null;
    }

    public function deletePage()
    {
        if ($this->pageToDelete) {
            try {
                $this->pageToDelete->delete();
                session()->flash('success', 'تم حذف الصفحة بنجاح');
                $this->resetPage();
            } catch (\Exception $e) {
                session()->flash('error', 'حدث خطأ أثناء حذف الصفحة');
            }
        }
        
        $this->cancelDelete();
    }

    // Toggle active status
    public function toggleStatus($pageId)
    {
        try {
            $store = request()->attributes->get('store');
            
            // البحث عن الصفحة مع التحقق من أنها تابعة للمتجر
            $page = StaticPage::where('id', $pageId)
                ->where('store_id', $store->id)
                ->first();
            
            if ($page) {
                // تبديل الحالة
                $page->is_active = !$page->is_active;
                $page->save();
                
                // رسالة النجاح
                $status = $page->is_active ? 'تم تفعيل الصفحة' : 'تم تعطيل الصفحة';
                session()->flash('success', $status);
                
                // إعادة تحميل المكون بدون إعادة تحميل الصفحة
                $this->dispatch('refreshComponent');
            } else {
                session()->flash('error', 'الصفحة غير موجودة أو لا تملك صلاحية للتعديل');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء تغيير حالة الصفحة: ' . $e->getMessage());
        }
    }

    public function render(Request $request)
    {
        $store = $request->attributes->get('store');

        $pages = StaticPage::where('store_id', $store->id)
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.static-pages', compact('pages'));
    }
}