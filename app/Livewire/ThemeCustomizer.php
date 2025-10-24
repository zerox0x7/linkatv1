<?php

namespace App\Livewire;

use App\Models\ThemeData;
use App\Models\Setting;
use App\Services\ResponsiveImageService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ThemeCustomizer extends Component
{
    use WithFileUploads;

    public $themeData;
    public $themeName;
    
    // Hero section - Multiple slides (up to 10)
    public $heroSlides = [];
    public $newHeroSlide = [
        'title' => '',
        'subtitle' => '',
        'button_text' => '',
        'button_link' => '',
        'image' => null,
        'image_preview' => null,
    ];
    public $editingSlideIndex = null;
    public $tempSlideImage;
    
    // Banner section (deprecated - now using layout builder)
    public $bannerTitle;
    public $bannerDescription;
    public $bannerLink;
    public $bannerImage;
    public $bannerImagePreview;
    
    // Layout Builder for static boxes
    public $layoutBoxes = [];
    public $selectedBox = null;
    public $boxLayouts = [];
    
    // Extra images
    public $extraImages = [];
    public $extraImagePreviews = [];
    
    // Custom data
    public $customData = [];
    
    // Custom CSS/JS
    public $customCss;
    public $customJs;
    
    // Sections Activation (10 sections)
    public $sectionsData = [];
    
    /**
     * Get image service instance
     */
    protected function getImageService()
    {
        return new ResponsiveImageService();
    }
    
    public function mount()
    {
        $storeId = auth()->user()->store_id ?? null;
        $this->themeName = auth()->user()->active_theme ?? Setting::get('active_theme', 'default');
        
        $this->themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $this->themeName)
            ->first();
        
        if (!$this->themeData) {
            $this->themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $this->themeName,
                'is_active' => true,
            ]);
        }
        
        $this->loadData();
    }
    
    public function loadData()
    {
        // Load hero slides data
        $heroData = $this->themeData->hero_data ?? [];
        $this->heroSlides = $heroData['slides'] ?? [];
        
        // Add image preview URLs for existing slides
        foreach ($this->heroSlides as $index => $slide) {
            if (isset($slide['image'])) {
                // Check if it's an array (responsive images) or string (old format)
                if (is_array($slide['image'])) {
                    $imageService = $this->getImageService();
                    $bestSize = $imageService->getBestSize($slide['image'], 'hero');
                    $this->heroSlides[$index]['image_preview'] = Storage::url($bestSize);
                } else {
                    $this->heroSlides[$index]['image_preview'] = Storage::url($slide['image']);
                }
            }
        }
        
        // Load layout boxes from hero slides for layout builder
        $this->loadLayoutBoxes();
        
        // Load banner data
        $bannerData = $this->themeData->banner_data ?? [];
        $this->bannerTitle = $bannerData['title'] ?? '';
        $this->bannerDescription = $bannerData['description'] ?? '';
        $this->bannerLink = $bannerData['link'] ?? '';
        if (isset($bannerData['main_image'])) {
            $this->bannerImagePreview = Storage::url($bannerData['main_image']);
        }
        
        // Load custom data
        $this->customData = $this->themeData->custom_data ?? [];
        
        // Load custom CSS/JS
        $this->customCss = $this->themeData->custom_css ?? '';
        $this->customJs = $this->themeData->custom_js ?? '';
        
        // Load sections data (initialize all 10 sections if not exists)
        $this->sectionsData = $this->themeData->sections_data ?? $this->getDefaultSectionsData();
    }
    
    /**
     * Get default sections data structure
     * All sections are active by default
     */
    private function getDefaultSectionsData()
    {
        $sections = [];
        for ($i = 1; $i <= 10; $i++) {
            $sections['section' . $i] = [
                'name' => 'firstSection',
                'is_active' => true,
            ];
            
            // Set proper names based on position
            switch($i) {
                case 1:
                    $sections['section' . $i]['name'] = 'firstSection';
                    break;
                case 2:
                    $sections['section' . $i]['name'] = 'secondSection';
                    break;
                case 3:
                    $sections['section' . $i]['name'] = 'thirdSection';
                    break;
                case 4:
                    $sections['section' . $i]['name'] = 'fourthSection';
                    break;
                case 5:
                    $sections['section' . $i]['name'] = 'fifthSection';
                    break;
                case 6:
                    $sections['section' . $i]['name'] = 'sixthSection';
                    break;
                case 7:
                    $sections['section' . $i]['name'] = 'seventhSection';
                    break;
                case 8:
                    $sections['section' . $i]['name'] = 'eighthSection';
                    break;
                case 9:
                    $sections['section' . $i]['name'] = 'ninthSection';
                    break;
                case 10:
                    $sections['section' . $i]['name'] = 'tenthSection';
                    break;
            }
        }
        return $sections;
    }
    
    /**
     * Load layout boxes from hero slides
     * Detects static boxes (those with image, title, link - no dynamic content)
     */
    public function loadLayoutBoxes()
    {
        $this->layoutBoxes = [];
        
        // Get the layout configuration for the current theme
        $this->boxLayouts = $this->getThemeLayoutConfig();
        
        foreach ($this->heroSlides as $index => $slide) {
            // Each slide is a static box
            $this->layoutBoxes[] = [
                'id' => $slide['id'] ?? 'box-' . $index,
                'order' => $index,
                'title' => $slide['title'] ?? '',
                'subtitle' => $slide['subtitle'] ?? '',
                'button_text' => $slide['button_text'] ?? '',
                'button_link' => $slide['button_link'] ?? '',
                'image' => $slide['image'] ?? null,
                'image_preview' => $slide['image_preview'] ?? null,
                'layout_type' => $this->detectBoxLayoutType($index),
                'extra_fields' => $this->getExtraFields($slide),
            ];
        }
    }
    
    /**
     * Get theme layout configuration
     * Maps box positions to their visual representation
     */
    private function getThemeLayoutConfig()
    {
        // Configuration based on torganic theme layout
        return [
            ['position' => 0, 'name' => 'Hero Principal', 'size' => 'large', 'col' => 'col-xl-8'],
            ['position' => 1, 'name' => 'Banner Superior Derecho', 'size' => 'medium', 'col' => 'col-md-6 col-xl-12'],
            ['position' => 2, 'name' => 'Banner Inferior Derecho', 'size' => 'medium', 'col' => 'col-md-6 col-xl-12'],
            ['position' => 3, 'name' => 'Banner Lateral 1', 'size' => 'small', 'col' => 'col-xl-3 col-md-6'],
            ['position' => 4, 'name' => 'Banner Central Grande', 'size' => 'large', 'col' => 'col-xl-6 col-lg-12'],
            ['position' => 5, 'name' => 'Banner Lateral 2', 'size' => 'small', 'col' => 'col-xl-3 col-md-6'],
            ['position' => 6, 'name' => 'Banner Secundario 1', 'size' => 'medium', 'col' => 'col-lg-6'],
            ['position' => 7, 'name' => 'Banner Secundario 2', 'size' => 'medium', 'col' => 'col-lg-6'],
            ['position' => 8, 'name' => 'Banner Largo Inferior', 'size' => 'xlarge', 'col' => 'col-12'],
        ];
    }
    
    /**
     * Detect the layout type based on box position
     */
    private function detectBoxLayoutType($index)
    {
        $layouts = $this->getThemeLayoutConfig();
        return $layouts[$index] ?? ['position' => $index, 'name' => 'Box ' . ($index + 1), 'size' => 'medium', 'col' => 'col-md-6'];
    }
    
    /**
     * Get extra fields from slide (for extended customization)
     */
    private function getExtraFields($slide)
    {
        $extra = [];
        
        // Check for additional fields used in torganic theme
        $possibleFields = ['discount_text', 'discount_amount', 'description', 'badge_text', 'badge_amount', 'badge_label'];
        
        foreach ($possibleFields as $field) {
            if (isset($slide[$field])) {
                $extra[$field] = $slide[$field];
            }
        }
        
        return $extra;
    }
    
    /**
     * Update box order when user drags and drops
     */
    public function updateBoxOrder($orderedIds)
    {
        // Create a map of boxes by their IDs
        $boxesMap = [];
        foreach ($this->layoutBoxes as $box) {
            $boxesMap[$box['id']] = $box;
        }
        
        // Reorder boxes based on new order
        $reorderedBoxes = [];
        foreach ($orderedIds as $newIndex => $id) {
            if (isset($boxesMap[$id])) {
                $box = $boxesMap[$id];
                $box['order'] = $newIndex;
                $reorderedBoxes[] = $box;
            }
        }
        
        $this->layoutBoxes = $reorderedBoxes;
        
        // Update hero slides with new order
        $this->updateHeroSlidesFromLayoutBoxes();
        
        session()->flash('message', 'تم إعادة ترتيب الصناديق بنجاح');
    }
    
    /**
     * Update hero slides from layout boxes
     */
    private function updateHeroSlidesFromLayoutBoxes()
    {
        $newSlides = [];
        
        foreach ($this->layoutBoxes as $box) {
            $slide = [
                'id' => $box['id'],
                'title' => $box['title'],
                'subtitle' => $box['subtitle'],
                'button_text' => $box['button_text'],
                'button_link' => $box['button_link'],
                'image' => $box['image'],
                'order' => $box['order'],
            ];
            
            // Add extra fields
            if (!empty($box['extra_fields'])) {
                $slide = array_merge($slide, $box['extra_fields']);
            }
            
            $newSlides[] = $slide;
        }
        
        $this->heroSlides = $newSlides;
        $this->saveHeroSlides();
    }
    
    /**
     * Select a box for editing
     */
    public function selectBox($boxId)
    {
        foreach ($this->layoutBoxes as $box) {
            if ($box['id'] == $boxId) {
                $this->selectedBox = $box;
                break;
            }
        }
    }
    
    /**
     * Update selected box
     */
    public function updateSelectedBox()
    {
        if (!$this->selectedBox) {
            return;
        }
        
        // Find and update the box
        foreach ($this->layoutBoxes as $index => $box) {
            if ($box['id'] == $this->selectedBox['id']) {
                $this->layoutBoxes[$index] = $this->selectedBox;
                break;
            }
        }
        
        $this->updateHeroSlidesFromLayoutBoxes();
        $this->selectedBox = null;
        
        session()->flash('message', 'تم تحديث الصندوق بنجاح');
    }
    
    /**
     * Move a box to a specific position in the layout
     */
    public function moveBoxToPosition($boxId, $newPosition)
    {
        // Find the box being moved
        $boxIndex = null;
        foreach ($this->layoutBoxes as $index => $box) {
            if ($box['id'] == $boxId) {
                $boxIndex = $index;
                break;
            }
        }
        
        if ($boxIndex === null) {
            return;
        }
        
        $oldPosition = $this->layoutBoxes[$boxIndex]['order'];
        
        // If box is being moved to same position, do nothing
        if ($oldPosition == $newPosition) {
            return;
        }
        
        // Find if there's already a box at the target position
        $targetBoxIndex = null;
        foreach ($this->layoutBoxes as $index => $box) {
            if ($box['order'] == $newPosition) {
                $targetBoxIndex = $index;
                break;
            }
        }
        
        // Swap positions if target position is occupied
        if ($targetBoxIndex !== null) {
            $this->layoutBoxes[$targetBoxIndex]['order'] = $oldPosition;
        }
        
        // Update the moved box's position
        $this->layoutBoxes[$boxIndex]['order'] = $newPosition;
        
        // Update layout type for the new position
        $this->layoutBoxes[$boxIndex]['layout_type'] = $this->detectBoxLayoutType($newPosition);
        
        // Sort boxes by order
        usort($this->layoutBoxes, function($a, $b) {
            return $a['order'] - $b['order'];
        });
        
        // Save to database
        $this->updateHeroSlidesFromLayoutBoxes();
        
        session()->flash('message', 'تم نقل الصندوق إلى الموضع #' . ($newPosition + 1));
    }
    
    public function updatedTempSlideImage()
    {
        $this->validate([
            'tempSlideImage' => 'image|max:2048',
        ]);
        
        if ($this->editingSlideIndex !== null) {
            $this->heroSlides[$this->editingSlideIndex]['image_preview'] = $this->tempSlideImage->temporaryUrl();
        } else {
            $this->newHeroSlide['image_preview'] = $this->tempSlideImage->temporaryUrl();
        }
    }
    
    public function updatedBannerImage()
    {
        $this->validate([
            'bannerImage' => 'image|max:2048',
        ]);
        
        $this->bannerImagePreview = $this->bannerImage->temporaryUrl();
    }
    
    public function addHeroSlide()
    {
        if (count($this->heroSlides) >= 10) {
            session()->flash('error', 'لا يمكن إضافة أكثر من 10 صور للبطل والصفحة الرئيسية');
            return;
        }
        
        $this->validate([
            'newHeroSlide.title' => 'required|string|max:255',
            'newHeroSlide.subtitle' => 'nullable|string|max:500',
            'newHeroSlide.button_text' => 'nullable|string|max:100',
            'newHeroSlide.button_link' => 'nullable|string|max:255',
            'tempSlideImage' => 'required|image|max:2048',
        ], [
            'newHeroSlide.title.required' => 'العنوان مطلوب',
            'tempSlideImage.required' => 'الصورة مطلوبة',
            'tempSlideImage.image' => 'يجب أن يكون الملف صورة',
            'tempSlideImage.max' => 'حجم الصورة يجب أن لا يتجاوز 2MB',
        ]);
        
        // Upload image and create responsive versions (small, medium, large, xl)
        $imageService = $this->getImageService();
        $imagePaths = $imageService->uploadAndResize(
            $this->tempSlideImage,
            'themes/' . $this->themeName . '/hero',
            'public'
        );
        
        // Get preview URL (use large size for preview)
        $previewPath = $imageService->getBestSize($imagePaths, 'hero');
        
        // Add new slide
        $this->heroSlides[] = [
            'id' => uniqid(),
            'title' => $this->newHeroSlide['title'],
            'subtitle' => $this->newHeroSlide['subtitle'],
            'button_text' => $this->newHeroSlide['button_text'],
            'button_link' => $this->newHeroSlide['button_link'],
            'image' => $imagePaths, // Store array of all sizes
            'image_preview' => Storage::url($previewPath),
            'order' => count($this->heroSlides),
        ];
        
        // Save immediately
        $this->saveHeroSlides();
        
        // Reset form
        $this->resetNewHeroSlide();
        
        session()->flash('message', 'تم إضافة الصورة بنجاح مع 5 أحجام مختلفة (صورة مصغرة، صغير، متوسط، كبير، أصلي)');
    }
    
    public function editHeroSlide($index)
    {
        $this->editingSlideIndex = $index;
        $this->newHeroSlide = $this->heroSlides[$index];
        $this->newHeroSlide['image_preview'] = $this->heroSlides[$index]['image_preview'] ?? null;
    }
    
    public function updateHeroSlide()
    {
        if ($this->editingSlideIndex === null) {
            return;
        }
        
        $this->validate([
            'newHeroSlide.title' => 'required|string|max:255',
            'newHeroSlide.subtitle' => 'nullable|string|max:500',
            'newHeroSlide.button_text' => 'nullable|string|max:100',
            'newHeroSlide.button_link' => 'nullable|string|max:255',
            'tempSlideImage' => 'nullable|image|max:2048',
        ], [
            'newHeroSlide.title.required' => 'العنوان مطلوب',
        ]);
        
        // Update slide data
        $this->heroSlides[$this->editingSlideIndex]['title'] = $this->newHeroSlide['title'];
        $this->heroSlides[$this->editingSlideIndex]['subtitle'] = $this->newHeroSlide['subtitle'];
        $this->heroSlides[$this->editingSlideIndex]['button_text'] = $this->newHeroSlide['button_text'];
        $this->heroSlides[$this->editingSlideIndex]['button_link'] = $this->newHeroSlide['button_link'];
        
        // Update image if new one uploaded
        if ($this->tempSlideImage) {
            $imageService = $this->getImageService();
            
            // Delete old image(s)
            if (isset($this->heroSlides[$this->editingSlideIndex]['image'])) {
                $oldImage = $this->heroSlides[$this->editingSlideIndex]['image'];
                $imageService->deleteResponsiveImages($oldImage, 'public');
            }
            
            // Upload new image with responsive sizes
            $imagePaths = $imageService->uploadAndResize(
                $this->tempSlideImage,
                'themes/' . $this->themeName . '/hero',
                'public'
            );
            
            // Get preview URL
            $previewPath = $imageService->getBestSize($imagePaths, 'hero');
            
            $this->heroSlides[$this->editingSlideIndex]['image'] = $imagePaths;
            $this->heroSlides[$this->editingSlideIndex]['image_preview'] = Storage::url($previewPath);
        }
        
        // Save
        $this->saveHeroSlides();
        
        // Reset form
        $this->resetNewHeroSlide();
        $this->editingSlideIndex = null;
        
        session()->flash('message', 'تم تحديث الصورة بنجاح مع 5 أحجام مختلفة (صورة مصغرة، صغير، متوسط، كبير، أصلي)');
    }
    
    public function cancelEdit()
    {
        $this->resetNewHeroSlide();
        $this->editingSlideIndex = null;
    }
    
    public function deleteHeroSlide($index)
    {
        if (isset($this->heroSlides[$index])) {
            // Delete image(s) from storage
            if (isset($this->heroSlides[$index]['image'])) {
                $imageService = $this->getImageService();
                $imageService->deleteResponsiveImages($this->heroSlides[$index]['image'], 'public');
            }
            
            // Remove slide
            unset($this->heroSlides[$index]);
            $this->heroSlides = array_values($this->heroSlides); // Re-index array
            
            // Save
            $this->saveHeroSlides();
            
            session()->flash('message', 'تم حذف الصورة وجميع الأحجام بنجاح');
        }
    }
    
    public function moveSlideUp($index)
    {
        if ($index > 0) {
            $temp = $this->heroSlides[$index];
            $this->heroSlides[$index] = $this->heroSlides[$index - 1];
            $this->heroSlides[$index - 1] = $temp;
            
            $this->saveHeroSlides();
            session()->flash('message', 'تم تغيير ترتيب الصورة');
        }
    }
    
    public function moveSlideDown($index)
    {
        if ($index < count($this->heroSlides) - 1) {
            $temp = $this->heroSlides[$index];
            $this->heroSlides[$index] = $this->heroSlides[$index + 1];
            $this->heroSlides[$index + 1] = $temp;
            
            $this->saveHeroSlides();
            session()->flash('message', 'تم تغيير ترتيب الصورة');
        }
    }
    
    public function reorderSlides($orderedIds)
    {
        // Create a map of slides by their IDs
        $slidesMap = [];
        foreach ($this->heroSlides as $slide) {
            if (isset($slide['id'])) {
                $slidesMap[$slide['id']] = $slide;
            }
        }
        
        // Reorder slides based on the new order
        $reorderedSlides = [];
        foreach ($orderedIds as $id) {
            if (isset($slidesMap[$id])) {
                $reorderedSlides[] = $slidesMap[$id];
            }
        }
        
        $this->heroSlides = $reorderedSlides;
        $this->saveHeroSlides();
        
        session()->flash('message', 'تم إعادة ترتيب الصور بنجاح');
    }
    
    private function resetNewHeroSlide()
    {
        $this->newHeroSlide = [
            'title' => '',
            'subtitle' => '',
            'button_text' => '',
            'button_link' => '',
            'image' => null,
            'image_preview' => null,
        ];
        $this->tempSlideImage = null;
    }
    
    private function saveHeroSlides()
    {
        $heroData = $this->themeData->hero_data ?? [];
        
        // Clean slides data (remove preview URLs)
        $slidesToSave = array_map(function($slide) {
            unset($slide['image_preview']);
            return $slide;
        }, $this->heroSlides);
        
        $heroData['slides'] = $slidesToSave;
        $this->themeData->hero_data = $heroData;
        $this->themeData->save();
    }
    
    public function save()
    {
        $this->validate([
            'bannerTitle' => 'nullable|string|max:255',
            'bannerDescription' => 'nullable|string',
            'bannerLink' => 'nullable|string|max:255',
            'bannerImage' => 'nullable|image|max:2048',
            'customCss' => 'nullable|string',
            'customJs' => 'nullable|string',
        ]);
        
        // Hero slides are saved separately via addHeroSlide/updateHeroSlide/deleteHeroSlide
        
        // Update banner data
        $bannerData = $this->themeData->banner_data ?? [];
        $bannerData['title'] = $this->bannerTitle;
        $bannerData['description'] = $this->bannerDescription;
        $bannerData['link'] = $this->bannerLink;
        
        // Handle banner image upload
        if ($this->bannerImage) {
            $imageService = $this->getImageService();
            
            // Delete old image if exists
            if (isset($bannerData['main_image'])) {
                $imageService->deleteResponsiveImages($bannerData['main_image'], 'public');
            }
            
            // Upload with responsive sizes
            $imagePaths = $imageService->uploadAndResize(
                $this->bannerImage,
                'themes/' . $this->themeName . '/banner',
                'public'
            );
            
            $bannerData['main_image'] = $imagePaths;
        }
        
        $this->themeData->banner_data = $bannerData;
        
        // Update custom data
        $this->themeData->custom_data = $this->customData;
        
        // Update custom CSS/JS
        $this->themeData->custom_css = $this->customCss;
        $this->themeData->custom_js = $this->customJs;
        
        // Update sections data
        $this->themeData->sections_data = $this->sectionsData;
        
        $this->themeData->save();
        
        // Reset file uploads
        $this->bannerImage = null;
        
        $this->dispatch('theme-saved');
        session()->flash('message', 'تم حفظ إعدادات الثيم بنجاح');
    }
    
    /**
     * Toggle section activation
     */
    public function toggleSection($sectionKey)
    {
        if (isset($this->sectionsData[$sectionKey])) {
            $this->sectionsData[$sectionKey]['is_active'] = !$this->sectionsData[$sectionKey]['is_active'];
            
            // Save immediately
            $this->themeData->sections_data = $this->sectionsData;
            $this->themeData->save();
            
            $status = $this->sectionsData[$sectionKey]['is_active'] ? 'تم تفعيل' : 'تم إلغاء تفعيل';
            $sectionName = $this->sectionsData[$sectionKey]['name'];
            session()->flash('message', "{$status} القسم: {$sectionName}");
        }
    }
    
    public function deleteBannerImage()
    {
        $bannerData = $this->themeData->banner_data ?? [];
        
        if (isset($bannerData['main_image'])) {
            $imageService = $this->getImageService();
            $imageService->deleteResponsiveImages($bannerData['main_image'], 'public');
            unset($bannerData['main_image']);
            $this->themeData->banner_data = $bannerData;
            $this->themeData->save();
            
            $this->bannerImagePreview = null;
            session()->flash('message', 'تم حذف صورة البانر وجميع الأحجام بنجاح');
        }
    }
    
    public function addCustomDataField($key, $value)
    {
        $this->customData[$key] = $value;
    }
    
    public function removeCustomDataField($key)
    {
        unset($this->customData[$key]);
    }
    
    public function render()
    {
        return view('livewire.theme-customizer');
    }
}
