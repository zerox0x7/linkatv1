<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Menu;
use App\Models\HeaderSettings;
use Illuminate\Support\Facades\Storage;

class HeaderCustomizer extends Component
{
    use WithFileUploads;

    // Store ID for multi-store support
    public $storeId;

    // Header General Settings
    public $headerEnabled = true;
    public $headerFont = 'Tajawal';
    public $headerLayout = 'default';
    public $headerHeight = 80;
    public $headerSticky = true;
    public $headerShadow = true;
    public $headerScrollEffects = true;
    public $headerSmoothTransitions = true;
    public $headerCustomCSS = '';

    // Header Colors
    public $headerBackgroundColor = '#ffffff';
    public $headerTextColor = '#000000';
    public $headerLinkColor = '#6366f1';
    public $headerOpacity = 100;

    // Logo Settings
    public $logoEnabled = true;
    public $logoImage;
    public $logoSvg = '';
    public $logoWidth = 150;
    public $logoHeight = 50;
    public $logoPosition = 'left';
    public $logoBorderRadius = 'rounded-lg';
    public $logoShadowEnabled = false;
    public $logoShadowClass = 'shadow-lg';
    public $logoShadowColor = 'gray-500';
    public $logoShadowOpacity = '50';

    // Navigation Menu
    public $navigationEnabled = true;
    public $navigationStyle = 'horizontal';
    public $showHomeLink = true;
    public $mainMenusEnabled = true;
    public $mainMenusNumber = 5;
    public $showCategoriesInMenu = true;
    public $categoriesCount = 5;
    
    // Database menu items
    public $menuItems = [];
    public $newMenuItem = [
        'name' => '',
        'url' => '',
        'svg' => '',
        'image' => null,
        'tailwind_code' => '',
        'uploadedImage' => null
    ];

    // Header Features
    public $searchBarEnabled = true;
    public $userMenuEnabled = true;
    public $shoppingCartEnabled = false;
    public $wishlistEnabled = false;
    public $languageSwitcherEnabled = false;
    public $currencySwitcherEnabled = false;

    // Contact Information
    public $headerContactEnabled = false;
    public $headerPhone = '';
    public $headerEmail = '';
    public $contactPosition = 'top';

    // Mobile Settings
    public $mobileMenuEnabled = true;
    public $mobileSearchEnabled = true;
    public $mobileCartEnabled = true;
    
    // Settings
    public $settingsEnabled = true;

    protected $rules = [
        'headerHeight' => 'nullable|integer|min:60|max:200',
        'headerFont' => 'nullable|string|max:100',
        'headerCustomCSS' => 'nullable|string|max:5000',
        'logoWidth' => 'nullable|integer|min:50|max:500',
        'logoHeight' => 'nullable|integer|min:20|max:200',
        'logoBorderRadius' => 'nullable|string',
        'logoShadowClass' => 'nullable|string',
        'logoShadowColor' => 'nullable|string',
        'logoShadowOpacity' => 'nullable|string',
        'headerPhone' => 'nullable|string|max:50',
        'headerEmail' => 'nullable|email|max:100',
        'categoriesCount' => 'nullable|integer|min:1|max:20',
        'mainMenusNumber' => 'nullable|integer|min:1|max:20',
        // Simplified menu item validation
        'newMenuItem.name' => 'nullable|string|max:255',
        'newMenuItem.url' => 'nullable|string|max:500',
        'newMenuItem.svg' => 'nullable|string|max:100',
        'newMenuItem.tailwind_code' => 'nullable|string|max:1000',
        'newMenuItem.uploadedImage' => 'nullable|image|max:2048',
    ];

    protected $listeners = ['updateWireModel'];

    public function mount()
    {
        // Set store ID (you can modify this logic based on your needs)
        $this->storeId = $this->getCurrentStoreId();
        
        // Load header settings from database
        $this->loadHeaderSettings();
        // Load menu items from database
        $this->loadMenuItems();
    }

    /**
     * Get current store ID based on your application logic
     */
    private function getCurrentStoreId()
    {
        // You can modify this logic based on your needs:
        // - Get from session: session('current_store_id')
        // - Get from authenticated user: auth()->user()->store_id
        // - Get from URL parameter: request()->route('store_id')
        // - For now, we'll use null (default store)
        
        return session('current_store_id') ?? auth()->user()->store_id ?? null;
    }

    public function loadHeaderSettings()
    {
        try {
            $settings = HeaderSettings::getSettings($this->storeId);
            
            // Map database fields to component properties with proper defaults
            // General Header Settings
            $this->headerEnabled = $settings->header_enabled ?? true;
            $this->headerFont = $settings->header_font ?? 'Tajawal';
            $this->headerSticky = $settings->header_sticky ?? true;
            $this->headerShadow = $settings->header_shadow ?? true;
            $this->headerScrollEffects = $settings->header_scroll_effects ?? true;
            $this->headerSmoothTransitions = $settings->header_smooth_transitions ?? true;
            $this->headerCustomCSS = $settings->header_custom_css ?? '';
            $this->headerLayout = $settings->header_layout ?? 'default';
            $this->headerHeight = $settings->header_height ?? 80;
            
            // Logo Settings
            $this->logoEnabled = $settings->logo_enabled ?? true;
            $this->logoImage = $settings->logo_image;
            $this->logoSvg = $settings->logo_svg ?? '';
            $this->logoWidth = $settings->logo_width ?? 150;
            $this->logoHeight = $settings->logo_height ?? 50;
            $this->logoPosition = $settings->logo_position ?? 'left';
            $this->logoBorderRadius = $settings->logo_border_radius ?? 'rounded-lg';
            $this->logoShadowEnabled = $settings->logo_shadow_enabled ?? false;
            $this->logoShadowClass = $settings->logo_shadow_class ?? 'shadow-lg';
            $this->logoShadowColor = $settings->logo_shadow_color ?? 'gray-500';
            $this->logoShadowOpacity = $settings->logo_shadow_opacity ?? '50';
            
            // Navigation Settings
            $this->navigationEnabled = $settings->navigation_enabled ?? true;
            $this->showHomeLink = $settings->show_home_link ?? true;
            $this->mainMenusEnabled = $settings->main_menus_enabled ?? true;
            $this->mainMenusNumber = $settings->main_menus_number ?? 5;
            $this->showCategoriesInMenu = $settings->show_categories_in_menu ?? true;
            $this->categoriesCount = $settings->categories_count ?? 5;
            
            // Header Features
            $this->searchBarEnabled = $settings->search_bar_enabled ?? true;
            $this->userMenuEnabled = $settings->user_menu_enabled ?? true;
            $this->shoppingCartEnabled = $settings->shopping_cart_enabled ?? false;
            $this->wishlistEnabled = $settings->wishlist_enabled ?? false;
            $this->languageSwitcherEnabled = $settings->language_switcher_enabled ?? false;
            $this->currencySwitcherEnabled = $settings->currency_switcher_enabled ?? false;
            
            // Contact Information
            $this->headerContactEnabled = $settings->header_contact_enabled ?? false;
            $this->headerPhone = $settings->header_phone ?? '';
            $this->headerEmail = $settings->header_email ?? '';
            $this->contactPosition = $settings->contact_position ?? 'top';
            
            // Mobile Settings
            $this->mobileMenuEnabled = $settings->mobile_menu_enabled ?? true;
            $this->mobileSearchEnabled = $settings->mobile_search_enabled ?? true;
            $this->mobileCartEnabled = $settings->mobile_cart_enabled ?? true;
            
            // Settings
            $this->settingsEnabled = $settings->settings_enabled ?? true;
            
        } catch (\Exception $e) {
            // Set default values if loading fails
            $this->setDefaultValues();
        }
    }

    /**
     * Set default values for all properties
     */
    private function setDefaultValues()
    {
        // General Header Settings
        $this->headerEnabled = true;
        $this->headerFont = 'Tajawal';
        $this->headerSticky = true;
        $this->headerShadow = true;
        $this->headerScrollEffects = true;
        $this->headerSmoothTransitions = true;
        $this->headerCustomCSS = '';
        $this->headerLayout = 'default';
        $this->headerHeight = 80;
        
        // Logo Settings
        $this->logoEnabled = true;
        $this->logoImage = null;
        $this->logoSvg = '';
        $this->logoWidth = 150;
        $this->logoHeight = 50;
        $this->logoPosition = 'left';
        $this->logoBorderRadius = 'rounded-lg';
        $this->logoShadowEnabled = false;
        $this->logoShadowClass = 'shadow-lg';
        $this->logoShadowColor = 'gray-500';
        $this->logoShadowOpacity = '50';
        
        // Navigation Settings
        $this->navigationEnabled = true;
        $this->showHomeLink = true;
        $this->mainMenusEnabled = true;
        $this->mainMenusNumber = 5;
        $this->showCategoriesInMenu = true;
        $this->categoriesCount = 5;
        
        // Header Features
        $this->searchBarEnabled = true;
        $this->userMenuEnabled = true;
        $this->shoppingCartEnabled = false;
        $this->wishlistEnabled = false;
        $this->languageSwitcherEnabled = false;
        $this->currencySwitcherEnabled = false;
        
        // Contact Information
        $this->headerContactEnabled = false;
        $this->headerPhone = '';
        $this->headerEmail = '';
        $this->contactPosition = 'top';
        
        // Mobile Settings
        $this->mobileMenuEnabled = true;
        $this->mobileSearchEnabled = true;
        $this->mobileCartEnabled = true;
    }

    public function loadMenuItems()
    {
        // Get current user's menus, ordered by the 'order' column
        $this->menuItems = Menu::where('owner_id', auth()->id() ?? 1)
            ->ordered()
            ->get()
            ->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'name' => $menu->title,
                    'url' => $menu->url,
                    'svg' => $menu->svg,
                    'image' => $menu->image,
                    'order' => $menu->order,
                    'is_active' => $menu->is_active,
                    'tailwind_code' => $menu->tailwind_code,
                ];
            })
            ->toArray();
    }

    public function addMenuItem()
    {
        $this->validate([
            'newMenuItem.name' => 'required|string|max:255',
            'newMenuItem.url' => 'nullable|string|max:255',
            'newMenuItem.uploadedImage' => 'nullable|image|max:2048',
        ]);

        try {
            // Debug: Log the current newMenuItem data
            \Log::info('Adding menu item with data:', $this->newMenuItem);
            
            // Get the next order number
            $nextOrder = Menu::where('owner_id', auth()->id() ?? 1)->max('order') + 1;

            // Handle image upload
            $imagePath = null;
            if ($this->newMenuItem['uploadedImage']) {
                $imagePath = $this->newMenuItem['uploadedImage']->store('menu-images', 'public');
            }

            // Debug: Log the SVG value specifically
            \Log::info('SVG value being saved:', ['svg' => $this->newMenuItem['svg'] ?? 'NULL']);

            // Create the menu item in database
            $menu = Menu::create([
                'title' => $this->newMenuItem['name'],
                'url' => $this->newMenuItem['url'],
                'svg' => $this->newMenuItem['svg'] ?? null,
                'image' => $imagePath,
                'tailwind_code' => $this->newMenuItem['tailwind_code'] ?? null,
                'owner_id' => auth()->id() ?? 1,
                'order' => $nextOrder,
                'is_active' => true,
            ]);

            // Debug: Log the created menu item
            \Log::info('Created menu item:', $menu->toArray());

            // Reload menu items from database
            $this->loadMenuItems();

            // Reset the form
            $this->newMenuItem = [
                'name' => '',
                'url' => '',
                'svg' => '',
                'image' => null,
                'tailwind_code' => '',
                'uploadedImage' => null
            ];

            session()->flash('success', 'تم إضافة العنصر بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error adding menu item:', ['error' => $e->getMessage(), 'data' => $this->newMenuItem]);
            session()->flash('error', 'حدث خطأ أثناء إضافة العنصر: ' . $e->getMessage());
        }
    }

    public function removeMenuItem($index)
    {
        try {
            // Get the menu item ID from the array
            if (isset($this->menuItems[$index]['id'])) {
                $menuId = $this->menuItems[$index]['id'];
                $menuItem = Menu::find($menuId);
                
                // Delete image file if exists
                if ($menuItem && $menuItem->image && \Storage::disk('public')->exists($menuItem->image)) {
                    \Storage::disk('public')->delete($menuItem->image);
                }
                
                // Delete from database
                Menu::where('id', $menuId)
                    ->where('owner_id', auth()->id() ?? 1)
                    ->delete();

                // Reload menu items from database
                $this->loadMenuItems();

                session()->flash('success', 'تم حذف العنصر بنجاح');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حذف العنصر: ' . $e->getMessage());
        }
    }

    public function updateMenuOrder($orderedIds)
    {
        try {
            foreach ($orderedIds as $index => $id) {
                Menu::where('id', $id)
                    ->where('owner_id', auth()->id() ?? 1)
                    ->update(['order' => $index + 1]);
            }
            
            $this->loadMenuItems();
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء إعادة ترتيب العناصر: ' . $e->getMessage());
        }
    }

    public function reorderMenuItems($orderedItems)
    {
        try {
            foreach ($orderedItems as $index => $item) {
                if (isset($item['id'])) {
                    Menu::where('id', $item['id'])
                        ->where('owner_id', auth()->id() ?? 1)
                        ->update(['order' => $index + 1]);
                }
            }
            
            $this->loadMenuItems();
        } catch (\Exception $e) {
            session()->flash('error', 'خطأ في إعادة الترتيب: ' . $e->getMessage());
        }
    }

    public function toggleMenuItemStatus($index)
    {
        try {
            if (isset($this->menuItems[$index]['id'])) {
                $menuId = $this->menuItems[$index]['id'];
                $menu = Menu::where('id', $menuId)
                    ->where('owner_id', auth()->id() ?? 1)
                    ->first();
                
                if ($menu) {
                    $menu->update([
                        'is_active' => !$menu->is_active
                    ]);
                    
                    $this->loadMenuItems();
                    
                    $status = $menu->is_active ? 'تم تفعيل' : 'تم إلغاء تفعيل';
                    session()->flash('success', $status . ' العنصر بنجاح');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء تغيير حالة العنصر: ' . $e->getMessage());
        }
    }

    public function save()
    {
        // Validate all data first
        $this->validate();

        try {
            // Prepare data for database - match all column names from your table structure
            $data = [
                // General Header Settings
                'header_enabled' => $this->headerEnabled ?? true,
                'header_font' => $this->headerFont ?? 'Tajawal',
                'header_sticky' => $this->headerSticky ?? true,
                'header_shadow' => $this->headerShadow ?? true,
                'header_scroll_effects' => $this->headerScrollEffects ?? true,
                'header_smooth_transitions' => $this->headerSmoothTransitions ?? true,
                'header_custom_css' => $this->headerCustomCSS,
                'header_layout' => $this->headerLayout ?? 'default',
                'header_height' => $this->headerHeight ?? 80,
                
                // Logo Settings
                'logo_enabled' => $this->logoEnabled ?? true,
                'logo_image' => $this->logoImage,
                'logo_svg' => $this->logoSvg,
                'logo_width' => $this->logoWidth ?? 150,
                'logo_height' => $this->logoHeight ?? 50,
                'logo_position' => $this->logoPosition ?? 'left',
                'logo_border_radius' => $this->logoBorderRadius ?? 'rounded-lg',
                'logo_shadow_enabled' => $this->logoShadowEnabled ?? false,
                'logo_shadow_class' => $this->logoShadowClass,
                'logo_shadow_color' => $this->logoShadowColor ?? 'gray-500',
                'logo_shadow_opacity' => $this->logoShadowOpacity ?? '50',
                
                // Navigation Settings
                'navigation_enabled' => $this->navigationEnabled ?? true,
                'show_home_link' => $this->showHomeLink ?? true,
                'main_menus_enabled' => $this->mainMenusEnabled ?? true,
                'main_menus_number' => $this->mainMenusNumber ?? 5,
                'show_categories_in_menu' => $this->showCategoriesInMenu ?? true,
                'categories_count' => $this->categoriesCount ?? 5,
                'menu_items' => !empty($this->menuItems) ? json_encode($this->menuItems) : null,
                
                // Header Features
                'search_bar_enabled' => $this->searchBarEnabled ?? true,
                'user_menu_enabled' => $this->userMenuEnabled ?? true,
                'shopping_cart_enabled' => $this->shoppingCartEnabled ?? false,
                'wishlist_enabled' => $this->wishlistEnabled ?? false,
                'language_switcher_enabled' => $this->languageSwitcherEnabled ?? false,
                'currency_switcher_enabled' => $this->currencySwitcherEnabled ?? false,
                
                // Contact Information
                'header_contact_enabled' => $this->headerContactEnabled ?? false,
                'header_phone' => $this->headerPhone,
                'header_email' => $this->headerEmail,
                'contact_position' => $this->contactPosition ?? 'top',
                
                // Mobile Settings
                'mobile_menu_enabled' => $this->mobileMenuEnabled ?? true,
                'mobile_search_enabled' => $this->mobileSearchEnabled ?? true,
                'mobile_cart_enabled' => $this->mobileCartEnabled ?? true,
                
                // Settings
                'settings_enabled' => $this->settingsEnabled ?? true,
            ];

            // Save to database with store ID
            $settings = HeaderSettings::updateSettings($data, $this->storeId);

            session()->flash('success', 'تم حفظ إعدادات الهيدر بنجاح!');
            
            // Emit event for other components if needed
            $this->dispatch('header-settings-updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حفظ الإعدادات: ' . $e->getMessage());
        }
    }

    public function updateWireModel($wireModel, $value)
    {
        // Debug: Log the wire model update
        \Log::info('HeaderCustomizer updateWireModel called:', [
            'wireModel' => $wireModel,
            'value' => $value,
            'current_newMenuItem' => $this->newMenuItem
        ]);
        
        // Handle nested properties like 'newMenuItem.svg'
        if (strpos($wireModel, '.') !== false) {
            $keys = explode('.', $wireModel);
            $target = &$this;
            
            // Navigate to the parent of the final property
            for ($i = 0; $i < count($keys) - 1; $i++) {
                if (!isset($target->{$keys[$i]})) {
                    $target->{$keys[$i]} = [];
                }
                $target = &$target->{$keys[$i]};
            }
            
            // Set the final property value
            $finalKey = end($keys);
            if (is_array($target)) {
                $target[$finalKey] = $value;
            } else {
                $target->{$finalKey} = $value;
            }
        } else {
            // Handle simple properties
            $this->{$wireModel} = $value;
        }
        
        // Debug: Log the updated state
        \Log::info('HeaderCustomizer after updateWireModel:', [
            'wireModel' => $wireModel,
            'newMenuItem' => $this->newMenuItem
        ]);
    }

    public function render()
    {
        return view('livewire.header-customizer');
    }
}
