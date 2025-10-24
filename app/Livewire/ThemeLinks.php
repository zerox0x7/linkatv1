<?php

namespace App\Livewire;

use App\Models\ThemeLink;
use Livewire\Component;

class ThemeLinks extends Component
{
    public $themeLinks = [];
    public $activeTheme = null;

    protected $listeners = ['refreshThemeLinks' => 'mount'];

    public function mount()
    {
        $this->loadThemeLinks();
    }

    public function loadThemeLinks()
    {
        $this->activeTheme = ThemeLink::getActiveTheme();
        $this->themeLinks = $this->activeTheme ? $this->activeTheme->links : [];
    }

    public function copyToClipboard($route)
    {
        $this->dispatch('copy-to-clipboard', url: $route);
        $this->dispatch('notify', message: 'Route copied to clipboard!', type: 'success');
    }

    public function render()
    {
        return view('livewire.theme-links');
    }
}
