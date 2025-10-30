<?php

namespace App\Livewire\ThemeCustomizer;

use App\Models\ThemeData;
use App\Models\Setting;
use Livewire\Component;

class CustomData extends Component
{
    public $themeData;
    public $themeName;
    public $customData = [];
    
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
        $this->customData = $this->themeData->custom_data ?? [];
    }
    
    public function addCustomDataField($key, $value)
    {
        $this->customData[$key] = $value;
        $this->save();
    }
    
    public function removeCustomDataField($key)
    {
        unset($this->customData[$key]);
        $this->save();
    }
    
    public function save()
    {
        $this->themeData->custom_data = $this->customData;
        $this->themeData->save();
        
        session()->flash('message', 'تم حفظ البيانات المخصصة بنجاح');
    }
    
    public function render()
    {
        return view('livewire.theme-customizer.custom-data')
            ->layout('themes.admin.layouts.app');
    }
}

