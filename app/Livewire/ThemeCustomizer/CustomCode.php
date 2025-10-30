<?php

namespace App\Livewire\ThemeCustomizer;

use App\Models\ThemeData;
use App\Models\Setting;
use Livewire\Component;

class CustomCode extends Component
{
    public $themeData;
    public $themeName;
    public $customCss;
    public $customJs;
    
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
        $this->customCss = $this->themeData->custom_css ?? '';
        $this->customJs = $this->themeData->custom_js ?? '';
    }
    
    public function save()
    {
        $this->validate([
            'customCss' => 'nullable|string',
            'customJs' => 'nullable|string',
        ]);
        
        $this->themeData->custom_css = $this->customCss;
        $this->themeData->custom_js = $this->customJs;
        $this->themeData->save();
        
        session()->flash('message', 'تم حفظ أكواد CSS/JS المخصصة بنجاح');
    }
    
    public function render()
    {
        return view('livewire.theme-customizer.custom-code')
            ->layout('themes.admin.layouts.app');
    }
}

