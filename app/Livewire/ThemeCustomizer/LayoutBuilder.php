<?php

namespace App\Livewire\ThemeCustomizer;

use App\Models\ThemeData;
use App\Models\Setting;
use App\Services\ResponsiveImageService;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class LayoutBuilder extends Component
{
    public $themeData;
    public $themeName;
    
    // Layout Builder for static boxes
    public $layoutBoxes = [];
    public $selectedBox = null;
    public $boxLayouts = [];
    public $imageSizes = [];
    public $heroSlides = [];
    
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
                if (is_array($slide['image'])) {
                    $imageService = $this->getImageService();
                    $bestSize = $imageService->getBestSize($slide['image'], 'hero');
                    $this->heroSlides[$index]['image_preview'] = Storage::url($bestSize);
                } else {
                    $this->heroSlides[$index]['image_preview'] = Storage::url($slide['image']);
                }
            }
        }
        
        // Load layout boxes from hero slides
        $this->loadLayoutBoxes();
    }
    
    /**
     * Load layout boxes from hero slides
     */
    public function loadLayoutBoxes()
    {
        $this->layoutBoxes = [];
        
        // Get the layout configuration for the current theme
        $this->boxLayouts = $this->getThemeLayoutConfig();
        
        // Get theme info to retrieve image sizes
        $themeInfo = \App\Models\ThemesInfo::getBySlug($this->themeName) 
                  ?? \App\Models\ThemesInfo::getByName($this->themeName);
        
        // Get all image sizes mapped by order
        $this->imageSizes = $themeInfo ? $themeInfo->getAllImageSizes() : [];
        
        // Sort heroSlides by their saved order before loading them
        $sortedSlides = collect($this->heroSlides)->sortBy(function($slide) {
            return $slide['order'] ?? 999;
        })->values()->all();
        
        foreach ($sortedSlides as $index => $slide) {
            $savedOrder = $slide['order'] ?? $index;
            $imageSize = $this->imageSizes[$savedOrder + 1] ?? null;
            
            $this->layoutBoxes[] = [
                'id' => $slide['id'] ?? 'box-' . $index,
                'order' => $savedOrder,
                'title' => $slide['title'] ?? '',
                'subtitle' => $slide['subtitle'] ?? '',
                'button_text' => $slide['button_text'] ?? '',
                'button_link' => $slide['button_link'] ?? '',
                'image' => $slide['image'] ?? null,
                'image_preview' => $slide['image_preview'] ?? null,
                'layout_type' => $this->detectBoxLayoutType($savedOrder),
                'extra_fields' => $this->getExtraFields($slide),
                'image_size' => $imageSize,
            ];
        }
    }
    
    /**
     * Get theme layout configuration
     */
    private function getThemeLayoutConfig()
    {
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
     * Get extra fields from slide
     */
    private function getExtraFields($slide)
    {
        $extra = [];
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
        $boxesMap = [];
        $oldPositionsMap = [];
        foreach ($this->layoutBoxes as $box) {
            $boxesMap[$box['id']] = $box;
            $oldPositionsMap[$box['id']] = $box['order'];
        }
        
        $imageService = $this->getImageService();
        
        $reorderedBoxes = [];
        foreach ($orderedIds as $newIndex => $id) {
            if (isset($boxesMap[$id])) {
                $box = $boxesMap[$id];
                $oldPosition = $oldPositionsMap[$id];
                
                if ($oldPosition !== $newIndex && isset($box['image']) && is_array($box['image'])) {
                    $mainImagePath = $box['image']['default'] ?? null;
                    $originalImagePath = $box['image']['original'] ?? null;
                    
                    if ($mainImagePath && $originalImagePath) {
                        try {
                            $this->ensureOriginalCopy($mainImagePath, $imageService);
                            $resizedPath = $imageService->resizeMainImageInPlace($mainImagePath, $originalImagePath, $newIndex, $this->themeName, 'public');
                            $sizeString = $imageService->getSizeForPosition($newIndex, $this->themeName);
                            
                            $box['image'] = [
                                'original' => $originalImagePath,
                                'default' => $resizedPath,
                                'position' => $newIndex,
                                'size' => $sizeString
                            ];
                        } catch (\Exception $e) {
                            \Log::error('Failed to resize image during reorder: ' . $e->getMessage());
                        }
                    }
                }
                
                $box['order'] = $newIndex;
                $box['layout_type'] = $this->detectBoxLayoutType($newIndex);
                $reorderedBoxes[] = $box;
            }
        }
        
        $this->layoutBoxes = $reorderedBoxes;
        $this->updateHeroSlidesFromLayoutBoxes();
        
        session()->flash('message', 'تم إعادة ترتيب الصناديق وتغيير أحجام الصور بنجاح');
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
     * Ensure original copy exists
     */
    private function ensureOriginalCopy($imagePath, $imageService)
    {
        $pathInfo = pathinfo($imagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        $originalCopyPath = $directory . '/' . $filename . '_original.' . $extension;
        
        if (!Storage::disk('public')->exists($originalCopyPath)) {
            $originalCopyPath = $imageService->createOriginalCopy($imagePath, 'public');
        }
        
        return $originalCopyPath;
    }
    
    private function saveHeroSlides()
    {
        $heroData = $this->themeData->hero_data ?? [];
        
        $slidesToSave = array_map(function($slide) {
            unset($slide['image_preview']);
            return $slide;
        }, $this->heroSlides);
        
        $heroData['slides'] = $slidesToSave;
        $this->themeData->hero_data = $heroData;
        $this->themeData->save();
    }
    
    public function render()
    {
        return view('livewire.theme-customizer.layout-builder')
            ->layout('themes.admin.layouts.app');
    }
}

