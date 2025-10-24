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
    public $imageSizes = [];  // Image sizes from themes_info table
    
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
        
        // Get theme info to retrieve image sizes
        $themeInfo = \App\Models\ThemesInfo::getBySlug($this->themeName) 
                  ?? \App\Models\ThemesInfo::getByName($this->themeName);
        
        // Get all image sizes mapped by order
        $this->imageSizes = $themeInfo ? $themeInfo->getAllImageSizes() : [];
        
        // Sort heroSlides by their saved order before loading them
        $sortedSlides = collect($this->heroSlides)->sortBy(function($slide) {
            return $slide['order'] ?? 999; // Put slides without order at the end
        })->values()->all();
        
        foreach ($sortedSlides as $index => $slide) {
            // Each slide is a static box
            // Use the saved order from the slide, not the array index
            $savedOrder = $slide['order'] ?? $index;
            
            // Get the image size for this position (order + 1 because themes_info uses 1-based indexing)
            $imageSize = $this->imageSizes[$savedOrder + 1] ?? null;
            
            $this->layoutBoxes[] = [
                'id' => $slide['id'] ?? 'box-' . $index,
                'order' => $savedOrder,  // Use saved order from database
                'title' => $slide['title'] ?? '',
                'subtitle' => $slide['subtitle'] ?? '',
                'button_text' => $slide['button_text'] ?? '',
                'button_link' => $slide['button_link'] ?? '',
                'image' => $slide['image'] ?? null,
                'image_preview' => $slide['image_preview'] ?? null,
                'layout_type' => $this->detectBoxLayoutType($savedOrder),  // Use saved order for layout type
                'extra_fields' => $this->getExtraFields($slide),
                'image_size' => $imageSize,  // Add image size from themes_info
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
        // Create a map of boxes by their IDs with old positions
        $boxesMap = [];
        $oldPositionsMap = [];
        foreach ($this->layoutBoxes as $box) {
            $boxesMap[$box['id']] = $box;
            $oldPositionsMap[$box['id']] = $box['order'];
        }
        
        // Get the image service for dynamic resizing
        $imageService = $this->getImageService();
        
        // Reorder boxes based on new order and resize images
        $reorderedBoxes = [];
        foreach ($orderedIds as $newIndex => $id) {
            if (isset($boxesMap[$id])) {
                $box = $boxesMap[$id];
                $oldPosition = $oldPositionsMap[$id];
                
                // Only resize if position actually changed
                if ($oldPosition !== $newIndex && isset($box['image']) && is_array($box['image'])) {
                    $mainImagePath = $box['image']['default'] ?? null;
                    $originalImagePath = $box['image']['original'] ?? null;
                    
                    if ($mainImagePath && $originalImagePath) {
                        try {
                            // Ensure original copy exists
                            $this->ensureOriginalCopy($mainImagePath, $imageService);
                            
                            // Resize the image to match the new position size
                            $resizedPath = $imageService->resizeMainImageInPlace($mainImagePath, $originalImagePath, $newIndex, $this->themeName, 'public');
                            
                            // Get the size string for the new position
                            $sizeString = $imageService->getSizeForPosition($newIndex, $this->themeName);
                            
                            // Update the box's image data
                            $box['image'] = [
                                'original' => $originalImagePath,
                                'default' => $resizedPath,
                                'position' => $newIndex,
                                'size' => $sizeString
                            ];
                            
                        } catch (\Exception $e) {
                            // Log error but don't break the functionality
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
        
        // Update hero slides with new order
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
     * Move a box to a specific position in the layout with dynamic image resizing
     */
    public function moveBoxToPosition($boxId, $newPosition)
    {
        \Log::info("=== moveBoxToPosition START ===");
        \Log::info("moveBoxToPosition: boxId={$boxId}, newPosition={$newPosition}, themeName={$this->themeName}");
        
        // Find the box being moved
        $boxIndex = null;
        foreach ($this->layoutBoxes as $index => $box) {
            if ($box['id'] == $boxId) {
                $boxIndex = $index;
                break;
            }
        }
        
        if ($boxIndex === null) {
            \Log::warning("moveBoxToPosition: Box not found with id={$boxId}");
            return;
        }
        
        $oldPosition = $this->layoutBoxes[$boxIndex]['order'];
        \Log::info("moveBoxToPosition: Found box at index={$boxIndex}, oldPosition={$oldPosition}");
        
        // If box is being moved to same position, do nothing
        if ($oldPosition == $newPosition) {
            \Log::info("moveBoxToPosition: Same position, no action needed");
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
        
        // Get the image service for dynamic resizing
        $imageService = $this->getImageService();
        
        // Swap positions if target position is occupied
        if ($targetBoxIndex !== null) {
            \Log::info("moveBoxToPosition: TARGET BOX FOUND at index={$targetBoxIndex}, swapping positions");
            $this->layoutBoxes[$targetBoxIndex]['order'] = $oldPosition;
            
            // Handle image resizing for the target box (being swapped)
            $targetBox = $this->layoutBoxes[$targetBoxIndex];
            if (isset($targetBox['image']) && is_array($targetBox['image'])) {
                $targetMainImagePath = $targetBox['image']['default'] ?? null;
                $targetOriginalImagePath = $targetBox['image']['original'] ?? null;
                
                \Log::info("moveBoxToPosition: TARGET BOX has image, mainPath={$targetMainImagePath}");
                
                if ($targetMainImagePath && $targetOriginalImagePath) {
                    try {
                        // Ensure original copy exists
                        $this->ensureOriginalCopy($targetMainImagePath, $imageService);
                        
                        \Log::info("moveBoxToPosition: Resizing TARGET BOX image to position={$oldPosition}");
                        // Resize the target box's image to match the old position size
                        $resizedTargetPath = $imageService->resizeMainImageInPlace($targetMainImagePath, $targetOriginalImagePath, $oldPosition, $this->themeName, 'public');
                        
                        // Get the size string for the old position
                        $targetSizeString = $imageService->getSizeForPosition($oldPosition, $this->themeName);
                        
                        // Update the target box's image data
                        $this->layoutBoxes[$targetBoxIndex]['image'] = [
                            'original' => $targetOriginalImagePath,
                            'default' => $resizedTargetPath,
                            'position' => $oldPosition,
                            'size' => $targetSizeString
                        ];
                        
                        // Update layout type for the target box
                        $this->layoutBoxes[$targetBoxIndex]['layout_type'] = $this->detectBoxLayoutType($oldPosition);
                        
                        \Log::info("moveBoxToPosition: TARGET BOX resized successfully to size={$targetSizeString}");
                        
                    } catch (\Exception $e) {
                        // Log error but don't break the functionality
                        \Log::error('Failed to resize target box image for position swap: ' . $e->getMessage());
                    }
                }
            } else {
                \Log::info("moveBoxToPosition: TARGET BOX has no image or image is not an array");
            }
        } else {
            \Log::info("moveBoxToPosition: No target box at position={$newPosition}, no swap needed");
        }
        
        // Handle image resizing for the moved box
        $movedBox = $this->layoutBoxes[$boxIndex];
        \Log::info("moveBoxToPosition: Processing MOVED BOX");
        if (isset($movedBox['image']) && is_array($movedBox['image'])) {
            // Get the main image path (without _original suffix)
            $mainImagePath = $movedBox['image']['default'] ?? null;
            $originalImagePath = $movedBox['image']['original'] ?? null;
            
            \Log::info("moveBoxToPosition: MOVED BOX has image, mainPath={$mainImagePath}");
            
            if ($mainImagePath && $originalImagePath) {
                try {
                    // Ensure original copy exists
                    $this->ensureOriginalCopy($mainImagePath, $imageService);
                    
                    \Log::info("moveBoxToPosition: Resizing MOVED BOX image to position={$newPosition}");
                    // Resize the main image file in place using the original as source
                    $resizedMainPath = $imageService->resizeMainImageInPlace($mainImagePath, $originalImagePath, $newPosition, $this->themeName, 'public');
                    
                    // Get the size string for the message
                    $sizeString = $imageService->getSizeForPosition($newPosition, $this->themeName);
                    
                    // Update the box's image data
                    $this->layoutBoxes[$boxIndex]['image'] = [
                        'original' => $originalImagePath,
                        'default' => $resizedMainPath, // Same path, but now resized
                        'position' => $newPosition,
                        'size' => $sizeString
                    ];
                    
                    \Log::info("moveBoxToPosition: MOVED BOX resized successfully to size={$sizeString}");
                    
                } catch (\Exception $e) {
                    // Log error but don't break the functionality
                    \Log::error('Failed to resize image for position change: ' . $e->getMessage());
                }
            }
        } else {
            \Log::info("moveBoxToPosition: MOVED BOX has no image or image is not an array");
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
        
        // Get size info for the message
        $sizeString = $imageService->getSizeForPosition($newPosition, $this->themeName);
        
        if ($targetBoxIndex !== null) {
            $oldSizeString = $imageService->getSizeForPosition($oldPosition, $this->themeName);
            session()->flash('message', 'تم تبديل الصناديق - الصندوق المنقول: الموضع #' . ($newPosition + 1) . ' (حجم: ' . $sizeString . ')، الصندوق المستبدل: الموضع #' . ($oldPosition + 1) . ' (حجم: ' . $oldSizeString . ')');
        } else {
            session()->flash('message', 'تم نقل الصندوق إلى الموضع #' . ($newPosition + 1) . ' مع تغيير حجم الصورة إلى ' . $sizeString);
        }
        
        \Log::info("=== moveBoxToPosition END === Moved box to position={$newPosition}");
    }
    
    /**
     * Ensure original copy exists for dynamic resizing
     * 
     * @param string $imagePath The current main image path
     * @param ResponsiveImageService $imageService
     * @return string The path to the original copy
     */
    private function ensureOriginalCopy($imagePath, $imageService)
    {
        // Extract path info
        $pathInfo = pathinfo($imagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        // Check if original copy already exists
        $originalCopyPath = $directory . '/' . $filename . '_original.' . $extension;
        
        if (!Storage::disk('public')->exists($originalCopyPath)) {
            // Create original copy from the main image
            $originalCopyPath = $imageService->createOriginalCopy($imagePath, 'public');
        }
        
        return $originalCopyPath;
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
        
        session()->flash('message', 'تم إضافة الصورة بنجاح');
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
        
        session()->flash('message', 'تم تحديث الصورة بنجاح');
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
