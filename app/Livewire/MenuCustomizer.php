<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MenuCustomizer extends Component
{
    use WithFileUploads;
    
    public $menuItems = [];
    public $newMenuItem = [
        'title' => '',
        'url' => '',
        'svg' => '',
        'image' => null,
        'uploadedImage' => null,
        'tailwind_code' => '',
        'is_active' => true,
        'order' => 0
    ];
    
    public $editingImages = [];
    public $isLoading = false;
    public $pendingChanges = [];

    protected $listeners = ['updateWireModel', 'iconSelected', 'refreshMenuItems'];

    public function mount()
    {
        $this->loadMenuItems();
    }

    public function loadMenuItems()
    {
        try {
            $this->isLoading = true;
            $this->menuItems = Menu::where('owner_id', Auth::id() ?? 1)
                ->orderBy('order')
                ->get()
                ->toArray();
            
            // Reset pending changes when loading fresh data
            $this->pendingChanges = [];
            
        } catch (\Exception $e) {
            Log::error('Error loading menu items: ' . $e->getMessage());
            session()->flash('error', 'خطأ في تحميل عناصر القائمة');
        } finally {
            $this->isLoading = false;
        }
    }

    public function rules()
    {
        return [
            'newMenuItem.title' => 'required|string|max:255',
            'newMenuItem.url' => 'required|string|max:255',
            'newMenuItem.svg' => 'nullable|string|max:100',
            'newMenuItem.uploadedImage' => 'nullable|image|max:2048',
            'newMenuItem.tailwind_code' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'newMenuItem.title.required' => 'عنوان العنصر مطلوب',
            'newMenuItem.title.max' => 'عنوان العنصر يجب ألا يتجاوز 255 حرف',
            'newMenuItem.url.required' => 'رابط العنصر مطلوب',
            'newMenuItem.url.max' => 'رابط العنصر يجب ألا يتجاوز 255 حرف',
            'newMenuItem.svg.max' => 'كود الأيقونة يجب ألا يتجاوز 100 حرف',
            'newMenuItem.uploadedImage.image' => 'يجب أن يكون الملف صورة',
            'newMenuItem.uploadedImage.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            'newMenuItem.tailwind_code.max' => 'كود Tailwind يجب ألا يتجاوز 1000 حرف',
        ];
    }

    public function addMenuItem()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $this->isLoading = true;
            
            // Calculate next order
            $nextOrder = Menu::where('owner_id', Auth::id() ?? 1)->max('order') + 1;
            
            // Handle image upload
            $imagePath = null;
            if ($this->newMenuItem['uploadedImage']) {
                $imagePath = $this->newMenuItem['uploadedImage']->store('menu-images', 'public');
            }
            
            // Prepare clean data
            $menuData = [
                'title' => trim($this->newMenuItem['title']),
                'url' => trim($this->newMenuItem['url']),
                'svg' => $this->newMenuItem['svg'] ?: null,
                'image' => $imagePath,
                'tailwind_code' => $this->newMenuItem['tailwind_code'] ?: null,
                'owner_id' => Auth::id() ?? 1,
                'order' => $nextOrder,
                'is_active' => $this->newMenuItem['is_active'] ? 1 : 0
            ];
            
            // Create menu item
            $created = Menu::create($menuData);
            
            if (!$created) {
                throw new \Exception('فشل في إنشاء العنصر في قاعدة البيانات');
            }
            
            DB::commit();
            
            // Reload menu items
            $this->loadMenuItems();
            
            // Reset form
            $this->resetForm();
            
            session()->flash('message', 'تم إضافة العنصر بنجاح');
            $this->dispatch('refreshMenuItems');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded image if exists
            if (isset($imagePath) && $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            Log::error('Menu creation error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'menu_data' => $this->newMenuItem
            ]);
            
            session()->flash('error', 'حدث خطأ أثناء إضافة العنصر: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function updateMenuItem($index, $field, $value)
    {
        if (!isset($this->menuItems[$index])) {
            session()->flash('error', 'العنصر المحدد غير موجود');
            return;
        }

        try {
            // Validate input
            if ($field === 'title' && empty(trim($value))) {
                session()->flash('error', 'عنوان العنصر لا يمكن أن يكون فارغاً');
                return;
            }
            
            if ($field === 'url' && empty(trim($value))) {
                session()->flash('error', 'رابط العنصر لا يمكن أن يكون فارغاً');
                return;
            }

            // Convert value based on field type
            $processedValue = $this->processFieldValue($field, $value);
            
            // Update local array
            $this->menuItems[$index][$field] = $processedValue;
            
            // Mark as pending change for batch processing
            $menuId = $this->menuItems[$index]['id'];
            if (!isset($this->pendingChanges[$menuId])) {
                $this->pendingChanges[$menuId] = [];
            }
            $this->pendingChanges[$menuId][$field] = $processedValue;
            
            // Update database immediately for critical fields
            if (in_array($field, ['title', 'url', 'is_active'])) {
                $this->saveSingleMenuItem($index, $field, $processedValue);
            }
            
        } catch (\Exception $e) {
            Log::error('Menu update error: ' . $e->getMessage(), [
                'index' => $index,
                'field' => $field,
                'value' => $value
            ]);
            
            session()->flash('error', 'حدث خطأ أثناء تحديث العنصر');
        }
    }

    private function processFieldValue($field, $value)
    {
        switch ($field) {
            case 'is_active':
                return $value ? 1 : 0;
            case 'order':
                return (int) $value;
            case 'title':
            case 'url':
                return trim($value);
            default:
                return $value;
        }
    }

    private function saveSingleMenuItem($index, $field, $value)
    {
        try {
            $menuId = $this->menuItems[$index]['id'];
            
            $updateData = [
                $field => $value,
                'updated_at' => now()
            ];
            
            $updated = Menu::where('id', $menuId)->update($updateData);
            
            if ($updated) {
                // Remove from pending changes since it's saved
                if (isset($this->pendingChanges[$menuId][$field])) {
                    unset($this->pendingChanges[$menuId][$field]);
                    if (empty($this->pendingChanges[$menuId])) {
                        unset($this->pendingChanges[$menuId]);
                    }
                }
                
                $this->dispatch('menuItemUpdated', $index);
            } else {
                throw new \Exception('لم يتم العثور على العنصر أو لم يتم التحديث');
            }
            
        } catch (\Exception $e) {
            Log::error('Single menu item save error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function uploadMenuImage($index)
    {
        if (!isset($this->editingImages[$index]) || !$this->editingImages[$index]) {
            session()->flash('error', 'لم يتم اختيار ملف للرفع');
            return;
        }

        try {
            $this->validate([
                "editingImages.{$index}" => 'required|image|max:2048'
            ]);

            $imagePath = $this->editingImages[$index]->store('menu-images', 'public');
            
            // Delete old image if exists
            if ($this->menuItems[$index]['image']) {
                Storage::disk('public')->delete($this->menuItems[$index]['image']);
            }
            
            $this->updateMenuItem($index, 'image', $imagePath);
            $this->editingImages[$index] = null;
            
            session()->flash('message', 'تم رفع الصورة بنجاح');
            
        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            session()->flash('error', 'حدث خطأ أثناء رفع الصورة: ' . $e->getMessage());
        }
    }

    public function deleteMenuItem($index)
    {
        if (!isset($this->menuItems[$index])) {
            session()->flash('error', 'العنصر المحدد غير موجود');
            return;
        }

        DB::beginTransaction();
        try {
            $menuItem = $this->menuItems[$index];
            
            // Delete associated image file
            if ($menuItem['image']) {
                Storage::disk('public')->delete($menuItem['image']);
            }
            
            // Delete from database
            $deleted = Menu::where('id', $menuItem['id'])->delete();
            
            if (!$deleted) {
                throw new \Exception('فشل في حذف العنصر من قاعدة البيانات');
            }
            
            DB::commit();
            
            // Reload menu items to get fresh order
            $this->loadMenuItems();
            
            session()->flash('message', 'تم حذف العنصر بنجاح');
            $this->dispatch('refreshMenuItems');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Menu deletion error: ' . $e->getMessage(), [
                'menu_item' => $menuItem
            ]);
            
            session()->flash('error', 'حدث خطأ أثناء حذف العنصر: ' . $e->getMessage());
        }
    }

    public function saveAllChanges()
    {
        if (empty($this->pendingChanges) && empty($this->menuItems)) {
            session()->flash('error', 'لا توجد تغييرات للحفظ');
            return;
        }

        DB::beginTransaction();
        try {
            $this->isLoading = true;
            $updated = 0;
            $errors = [];
            
            // Save pending changes first
            foreach ($this->pendingChanges as $menuId => $changes) {
                if (empty($changes)) continue;
                
                $changes['updated_at'] = now();
                $result = Menu::where('id', $menuId)->update($changes);
                
                if ($result) {
                    $updated++;
                } else {
                    $errors[] = "فشل في حفظ العنصر رقم {$menuId}";
                }
            }
            
            // Update order for all items
            foreach ($this->menuItems as $index => $item) {
                $newOrder = $index + 1;
                if ($item['order'] != $newOrder) {
                    Menu::where('id', $item['id'])->update([
                        'order' => $newOrder,
                        'updated_at' => now()
                    ]);
                    $updated++;
                }
            }
            
            if (!empty($errors)) {
                throw new \Exception('بعض العناصر لم يتم حفظها: ' . implode(', ', $errors));
            }
            
            DB::commit();
            
            // Clear pending changes
            $this->pendingChanges = [];
            
            // Reload fresh data
            $this->loadMenuItems();
            
            if ($updated > 0) {
                session()->flash('message', "تم حفظ {$updated} عنصر بنجاح");
            } else {
                session()->flash('message', 'لا توجد تغييرات جديدة للحفظ');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Menu bulk update error: ' . $e->getMessage(), [
                'pending_changes' => $this->pendingChanges,
                'menu_items_count' => count($this->menuItems)
            ]);
            
            session()->flash('error', 'حدث خطأ أثناء حفظ التغييرات: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    #[On('updateWireModel')]
    public function updateWireModel($property, $value)
    {
        try {
            // Handle menu items icon updates
            if (preg_match('/^menuItems\.(\d+)\.svg$/', $property, $matches)) {
                $index = (int)$matches[1];
                if (isset($this->menuItems[$index])) {
                    $this->updateMenuItem($index, 'svg', $value);
                }
                return;
            }
            
            // Handle new menu item properties
            if (strpos($property, 'newMenuItem.') === 0) {
                $field = str_replace('newMenuItem.', '', $property);
                if (array_key_exists($field, $this->newMenuItem)) {
                    $this->newMenuItem[$field] = $value;
                }
                return;
            }
            
            // Generic property assignment with validation
            $this->assignNestedProperty($property, $value);
            
        } catch (\Exception $e) {
            Log::error('UpdateWireModel error: ' . $e->getMessage(), [
                'property' => $property,
                'value' => $value
            ]);
            
            session()->flash('error', 'حدث خطأ أثناء تحديث البيانات');
        }
    }

    private function assignNestedProperty($property, $value)
    {
        $keys = explode('.', $property);
        $current = &$this;
        
        foreach ($keys as $i => $key) {
            if ($i === count($keys) - 1) {
                // Last key - assign the value
                if (is_array($current)) {
                    $current[$key] = $value;
                } else {
                    $current->{$key} = $value;
                }
            } else {
                // Navigate deeper
                if (is_numeric($key)) {
                    if (!isset($current[$key])) {
                        $current[$key] = [];
                    }
                    $current = &$current[$key];
                } else {
                    if (!property_exists($current, $key)) {
                        $current->{$key} = [];
                    }
                    $current = &$current->{$key};
                }
            }
        }
    }

    public function toggleActive($index)
    {
        if (!isset($this->menuItems[$index])) {
            session()->flash('error', 'العنصر المحدد غير موجود');
            return;
        }

        try {
            $newStatus = !$this->menuItems[$index]['is_active'];
            $this->updateMenuItem($index, 'is_active', $newStatus);
            
            $status = $newStatus ? 'تم تفعيل' : 'تم إلغاء تفعيل';
            session()->flash('message', $status . ' العنصر بنجاح');
            
        } catch (\Exception $e) {
            Log::error('Toggle active error: ' . $e->getMessage());
            session()->flash('error', 'حدث خطأ أثناء تغيير حالة العنصر');
        }
    }

    public function updateMenuOrder($orderedIds)
    {
        if (empty($orderedIds)) {
            session()->flash('error', 'لا توجد عناصر لإعادة ترتيبها');
            return;
        }

        DB::beginTransaction();
        try {
            $updated = 0;
            
            foreach ($orderedIds as $order => $id) {
                $result = Menu::where('id', $id)
                    ->where('owner_id', Auth::id() ?? 1)
                    ->update([
                        'order' => $order + 1,
                        'updated_at' => now()
                    ]);
                
                if ($result) {
                    $updated++;
                }
            }
            
            DB::commit();
            
            if ($updated > 0) {
                $this->loadMenuItems();
                session()->flash('message', "تم تحديث ترتيب {$updated} عنصر بنجاح");
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Menu order update error: ' . $e->getMessage(), [
                'ordered_ids' => $orderedIds
            ]);
            
            session()->flash('error', 'حدث خطأ أثناء تحديث الترتيب');
        }
    }

    public function duplicateMenuItem($index)
    {
        if (!isset($this->menuItems[$index])) {
            session()->flash('error', 'العنصر المحدد غير موجود');
            return;
        }

        DB::beginTransaction();
        try {
            $item = $this->menuItems[$index];
            
            // Prepare data for duplication
            $duplicateData = [
                'title' => $item['title'] . ' (نسخة)',
                'url' => $item['url'],
                'svg' => $item['svg'],
                'tailwind_code' => $item['tailwind_code'],
                'owner_id' => $item['owner_id'],
                'order' => Menu::where('owner_id', $item['owner_id'])->max('order') + 1,
                'is_active' => $item['is_active']
            ];
            
            // Copy image file if exists
            if ($item['image']) {
                try {
                    $extension = pathinfo($item['image'], PATHINFO_EXTENSION);
                    $newImagePath = 'menu-images/' . uniqid() . '.' . $extension;
                    
                    if (Storage::disk('public')->exists($item['image'])) {
                        Storage::disk('public')->copy($item['image'], $newImagePath);
                        $duplicateData['image'] = $newImagePath;
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to copy image during duplication: ' . $e->getMessage());
                    // Continue without image
                }
            }
            
            $created = Menu::create($duplicateData);
            
            if (!$created) {
                throw new \Exception('فشل في إنشاء النسخة المطلوبة');
            }
            
            DB::commit();
            
            $this->loadMenuItems();
            session()->flash('message', 'تم نسخ العنصر بنجاح');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up any copied image
            if (isset($duplicateData['image'])) {
                Storage::disk('public')->delete($duplicateData['image']);
            }
            
            Log::error('Menu duplication error: ' . $e->getMessage());
            session()->flash('error', 'حدث خطأ أثناء نسخ العنصر: ' . $e->getMessage());
        }
    }

    public function testDatabaseConnection()
    {
        try {
            $count = Menu::count();
            $userMenus = Menu::where('owner_id', Auth::id() ?? 1)->count();
            $latestMenu = Menu::where('owner_id', Auth::id() ?? 1)->latest()->first();
            
            $message = "✅ الاتصال بقاعدة البيانات ناجح!";
            $message .= "\n📊 إجمالي العناصر: {$count}";
            $message .= "\n👤 عناصرك: {$userMenus}";
            
            if ($latestMenu) {
                $message .= "\n🔗 آخر عنصر: {$latestMenu->title}";
            }
            
            session()->flash('message', $message);
            
        } catch (\Exception $e) {
            Log::error('Database connection test failed: ' . $e->getMessage());
            session()->flash('error', 'خطأ في الاتصال بقاعدة البيانات: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->reset('newMenuItem');
        $this->newMenuItem = [
            'title' => '',
            'url' => '',
            'svg' => '',
            'image' => null,
            'uploadedImage' => null,
            'tailwind_code' => '',
            'is_active' => true,
            'order' => 0
        ];
    }

    public function getPendingChangesCount()
    {
        return array_sum(array_map('count', $this->pendingChanges));
    }

    #[On('iconSelected')]
    public function handleIconSelected($data)
    {
        // Legacy support for icon selector
        if (isset($data['fieldName']) && isset($data['icon'])) {
            $this->updateWireModel($data['fieldName'], $data['icon']);
        }
    }

    #[On('refreshMenuItems')]
    public function refreshMenuItems()
    {
        $this->loadMenuItems();
    }

    public function render()
    {
        return view('livewire.menu-customizer', [
            'pendingChangesCount' => $this->getPendingChangesCount()
        ]);
    }
}
