<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ThemeData;
use App\Models\Setting;
use App\Services\ResponsiveImageService;
use Illuminate\Support\Facades\Storage;

class HomeThemeCustomizer extends Component
{
    use WithFileUploads;

    public $themeData;
    public $themeName;

    // Hero section
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
        $heroData = $this->themeData->hero_data ?? [];
        $this->heroSlides = $heroData['slides'] ?? [];

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

        $imageService = $this->getImageService();
        $imagePaths = $imageService->uploadAndResize(
            $this->tempSlideImage,
            'themes/' . $this->themeName . '/hero',
            'public'
        );

        $previewPath = $imageService->getBestSize($imagePaths, 'hero');

        $this->heroSlides[] = [
            'id' => uniqid(),
            'title' => $this->newHeroSlide['title'],
            'subtitle' => $this->newHeroSlide['subtitle'],
            'button_text' => $this->newHeroSlide['button_text'],
            'button_link' => $this->newHeroSlide['button_link'],
            'image' => $imagePaths,
            'image_preview' => Storage::url($previewPath),
            'order' => count($this->heroSlides),
        ];

        $this->saveHeroSlides();
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

        $this->heroSlides[$this->editingSlideIndex]['title'] = $this->newHeroSlide['title'];
        $this->heroSlides[$this->editingSlideIndex]['subtitle'] = $this->newHeroSlide['subtitle'];
        $this->heroSlides[$this->editingSlideIndex]['button_text'] = $this->newHeroSlide['button_text'];
        $this->heroSlides[$this->editingSlideIndex]['button_link'] = $this->newHeroSlide['button_link'];

        if ($this->tempSlideImage) {
            $imageService = $this->getImageService();
            if (isset($this->heroSlides[$this->editingSlideIndex]['image'])) {
                $oldImage = $this->heroSlides[$this->editingSlideIndex]['image'];
                $imageService->deleteResponsiveImages($oldImage, 'public');
            }

            $imagePaths = $imageService->uploadAndResize(
                $this->tempSlideImage,
                'themes/' . $this->themeName . '/hero',
                'public'
            );

            $previewPath = $imageService->getBestSize($imagePaths, 'hero');

            $this->heroSlides[$this->editingSlideIndex]['image'] = $imagePaths;
            $this->heroSlides[$this->editingSlideIndex]['image_preview'] = Storage::url($previewPath);
        }

        $this->saveHeroSlides();
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
            if (isset($this->heroSlides[$index]['image'])) {
                $imageService = $this->getImageService();
                $imageService->deleteResponsiveImages($this->heroSlides[$index]['image'], 'public');
            }

            unset($this->heroSlides[$index]);
            $this->heroSlides = array_values($this->heroSlides);
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
        $slidesMap = [];
        foreach ($this->heroSlides as $slide) {
            if (isset($slide['id'])) {
                $slidesMap[$slide['id']] = $slide;
            }
        }

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
        return view('livewire.home-theme-customizer');
    }
}


