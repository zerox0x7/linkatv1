<?php

namespace App\Livewire\ThemeCustomizer;

use App\Models\ThemeData;
use App\Models\Setting;
use Livewire\Component;

class SectionsActivation extends Component
{
    public $themeData;
    public $themeName;
    public $sectionsData = [];
    
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
        $this->sectionsData = $this->themeData->sections_data ?? $this->getDefaultSectionsData();
    }
    
    /**
     * Get default sections data structure
     */
    private function getDefaultSectionsData()
    {
        $sections = [];
        for ($i = 1; $i <= 10; $i++) {
            $sections['section' . $i] = [
                'name' => 'firstSection',
                'is_active' => true,
            ];
            
            switch($i) {
                case 1: $sections['section' . $i]['name'] = 'firstSection'; break;
                case 2: $sections['section' . $i]['name'] = 'secondSection'; break;
                case 3: $sections['section' . $i]['name'] = 'thirdSection'; break;
                case 4: $sections['section' . $i]['name'] = 'fourthSection'; break;
                case 5: $sections['section' . $i]['name'] = 'fifthSection'; break;
                case 6: $sections['section' . $i]['name'] = 'sixthSection'; break;
                case 7: $sections['section' . $i]['name'] = 'seventhSection'; break;
                case 8: $sections['section' . $i]['name'] = 'eighthSection'; break;
                case 9: $sections['section' . $i]['name'] = 'ninthSection'; break;
                case 10: $sections['section' . $i]['name'] = 'tenthSection'; break;
            }
        }
        return $sections;
    }
    
    /**
     * Toggle section activation
     */
    public function toggleSection($sectionKey)
    {
        if (isset($this->sectionsData[$sectionKey])) {
            $this->sectionsData[$sectionKey]['is_active'] = !$this->sectionsData[$sectionKey]['is_active'];
            
            $this->themeData->sections_data = $this->sectionsData;
            $this->themeData->save();
            
            $status = $this->sectionsData[$sectionKey]['is_active'] ? 'تم تفعيل' : 'تم إلغاء تفعيل';
            $sectionName = $this->sectionsData[$sectionKey]['name'];
            session()->flash('message', "{$status} القسم: {$sectionName}");
        }
    }
    
    public function render()
    {
        return view('livewire.theme-customizer.sections-activation')
            ->layout('themes.admin.layouts.app');
    }
}

