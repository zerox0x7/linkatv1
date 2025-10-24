<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TopHeaderSettings;
use Illuminate\Support\Facades\Storage;

class TopHeaderCustomizer extends Component
{
    use WithFileUploads;

    // Store ID for multi-store support
    public $storeId;

    // Top Header General Settings
    public $topHeaderEnabled = true;
    public $topHeaderPosition = 'top';
    public $topHeaderHeight = 40;
    public $topHeaderSticky = false;
    public $topHeaderBackgroundColor = '#3b82f6';
    public $topHeaderTextColor = '#ffffff';
    public $topHeaderBorderColor = '#374151';
    public $topHeaderOpacity = 100;

    // Movement Settings
    public $movementType = 'scroll';
    public $movementDirection = 'rtl';
    public $animationSpeed = 20;
    public $pauseOnHover = false;
    public $infiniteLoop = true;

    // Content & Style Settings
    public $headerText = '🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن!';
    public $headerLink = '';
    public $fontSize = '14px';
    public $fontWeight = '400';

    // Color Settings
    public $backgroundGradient = 'none';
    public $enableShadow = false;
    public $enableOpacity = false;

    // Additional Content
    public $showContactInfo = false;
    public $contactPhone = '';
    public $contactEmail = '';
    public $showSocialIcons = false;
    public $showCloseButton = false;
    public $showCountdown = false;
    public $countdownDate = '';

    // Contact Information
    public $contactEnabled = true;
    public $topHeaderPhone = '';
    public $topHeaderEmail = '';
    public $topHeaderAddress = '';
    public $contactIcon = 'ri-phone-line';
    public $emailIcon = 'ri-mail-line';
    public $addressIcon = 'ri-map-pin-line';

    // Quick Links
    public $quickLinksEnabled = true;
    public $topHeaderQuickLinks = [];

    // Social Media Links
    public $socialMediaEnabled = true;
    public $topHeaderSocialMedia = [];

    // Language & Currency Settings
    public $languageSwitcherEnabled = false;
    public $currencySwitcherEnabled = false;
    public $supportedLanguages = [];
    public $supportedCurrencies = [];

    // Announcement Bar
    public $announcementEnabled = false;
    public $announcementText = '';
    public $announcementLink = '';
    public $announcementBackgroundColor = '#6366f1';
    public $announcementTextColor = '#ffffff';
    public $announcementScrolling = false;

    // Login/Register Links
    public $authLinksEnabled = true;
    public $showLoginLink = true;
    public $showRegisterLink = true;
    public $loginText = 'تسجيل الدخول';
    public $registerText = 'إنشاء حساب';

    // Working Hours
    public $workingHoursEnabled = false;
    public $workingHours = '';
    public $workingHoursIcon = 'ri-time-line';

    // Text Only Setting
    public $textOnly = false;

    protected $rules = [
        'topHeaderHeight' => 'nullable|integer|min:30|max:120',
        'topHeaderPhone' => 'nullable|string|max:50',
        'topHeaderEmail' => 'nullable|email|max:100',
        'topHeaderAddress' => 'nullable|string|max:255',
        'headerText' => 'nullable|string|max:500',
        'headerLink' => 'nullable|url|max:255',
        'announcementText' => 'nullable|string|max:500',
        'announcementLink' => 'nullable|url|max:255',
        'loginText' => 'nullable|string|max:50',
        'registerText' => 'nullable|string|max:50',
        'workingHours' => 'nullable|string|max:100',
        'contactPhone' => 'nullable|string|max:50',
        'contactEmail' => 'nullable|email|max:100',
        'countdownDate' => 'nullable|date_format:Y-m-d\TH:i',
        'animationSpeed' => 'nullable|integer|min:5|max:60',
        'topHeaderQuickLinks.*.name' => 'nullable|string|max:255',
        'topHeaderQuickLinks.*.url' => 'nullable|string|max:500',
        'topHeaderSocialMedia.*.url' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        // Set store ID
        $this->storeId = $this->getCurrentStoreId();
        
        // Load settings from database
        $this->loadTopHeaderSettings();
    }

    private function getCurrentStoreId()
    {
        return session('current_store_id') ?? auth()->user()->store_id ?? null;
    }

    public function loadTopHeaderSettings()
    {
        try {
            $settings = TopHeaderSettings::getSettings($this->storeId);
            
            if ($settings) {
                // Load existing settings from database
                // General Settings
                $this->topHeaderEnabled = $settings->top_header_enabled ?? true;
                $this->topHeaderPosition = $settings->top_header_position ?? 'top';
                $this->topHeaderHeight = $settings->top_header_height ?? 40;
                $this->topHeaderSticky = $settings->top_header_sticky ?? false;
                $this->topHeaderBackgroundColor = $settings->background_color ?? '#3b82f6';
                $this->topHeaderTextColor = $settings->text_color ?? '#ffffff';
                $this->topHeaderBorderColor = $settings->border_color ?? '#374151';
                $this->topHeaderOpacity = $settings->opacity ?? 100;

                // Contact Information
                $this->contactEnabled = $settings->contact_enabled ?? true;
                $this->topHeaderPhone = $settings->phone ?? '';
                $this->topHeaderEmail = $settings->email ?? '';
                $this->topHeaderAddress = $settings->address ?? '';

                // Quick Links
                $this->quickLinksEnabled = $settings->quick_links_enabled ?? true;
                $this->topHeaderQuickLinks = json_decode($settings->quick_links ?? '[]', true);

                // Social Media
                $this->socialMediaEnabled = $settings->social_media_enabled ?? true;
                $this->topHeaderSocialMedia = json_decode($settings->social_media ?? '[]', true);

                // Language & Currency
                $this->languageSwitcherEnabled = $settings->language_switcher_enabled ?? false;
                $this->currencySwitcherEnabled = $settings->currency_switcher_enabled ?? false;

                // Announcement
                $this->announcementEnabled = $settings->announcement_enabled ?? false;
                $this->announcementText = $settings->announcement_text ?? '';
                $this->announcementLink = $settings->announcement_link ?? '';
                $this->announcementBackgroundColor = $settings->announcement_bg_color ?? '#6366f1';
                $this->announcementTextColor = $settings->announcement_text_color ?? '#ffffff';
                $this->announcementScrolling = $settings->announcement_scrolling ?? false;

                // Auth Links
                $this->authLinksEnabled = $settings->auth_links_enabled ?? true;
                $this->showLoginLink = $settings->show_login_link ?? true;
                $this->showRegisterLink = $settings->show_register_link ?? true;
                $this->loginText = $settings->login_text ?? 'تسجيل الدخول';
                $this->registerText = $settings->register_text ?? 'إنشاء حساب';

                // Working Hours
                $this->workingHoursEnabled = $settings->working_hours_enabled ?? false;
                $this->workingHours = $settings->working_hours ?? '';
                
                // Movement Settings
                $this->movementType = $settings->movement_type ?? 'scroll';
                $this->movementDirection = $settings->movement_direction ?? 'rtl';
                $this->animationSpeed = $settings->animation_speed ?? 20;
                $this->pauseOnHover = $settings->pause_on_hover ?? false;
                $this->infiniteLoop = $settings->infinite_loop ?? true;
                
                // Content & Style Settings
                $this->headerText = $settings->header_text ?? '🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن!';
                $this->headerLink = $settings->header_link ?? '';
                $this->fontSize = $settings->font_size ?? '14px';
                $this->fontWeight = $settings->font_weight ?? '400';
                
                // Color Settings
                $this->backgroundGradient = $settings->background_gradient ?? 'none';
                $this->enableShadow = $settings->enable_shadow ?? false;
                $this->enableOpacity = $settings->enable_opacity ?? false;
                
                // Additional Content
                $this->showContactInfo = $settings->show_contact_info ?? false;
                $this->contactPhone = $settings->contact_phone ?? '';
                $this->contactEmail = $settings->contact_email ?? '';
                $this->showSocialIcons = $settings->show_social_icons ?? false;
                $this->showCloseButton = $settings->show_close_button ?? false;
                $this->showCountdown = $settings->show_countdown ?? false;
                $this->countdownDate = $settings->countdown_date ? $settings->countdown_date->format('Y-m-d\TH:i') : '';
                
                // Text Only Setting
                $this->textOnly = $settings->text_only ?? false;
            } else {
                // No settings exist yet, use default values from component properties
                // The component properties are already initialized with default values
                // This allows the user to modify the form and save their actual data
            }
            
        } catch (\Exception $e) {
            // If there's any error, set default values
            $this->setDefaultValues();
        }
    }

    private function setDefaultValues()
    {
        $this->topHeaderEnabled = true;
        $this->topHeaderPosition = 'top';
        $this->topHeaderHeight = 40;
        $this->topHeaderSticky = false;
        $this->topHeaderBackgroundColor = '#3b82f6';
        $this->topHeaderTextColor = '#ffffff';
        $this->topHeaderBorderColor = '#374151';
        $this->topHeaderOpacity = 100;
        $this->contactEnabled = true;
        $this->quickLinksEnabled = true;
        $this->socialMediaEnabled = true;
        $this->authLinksEnabled = true;
        $this->topHeaderQuickLinks = [];
        $this->topHeaderSocialMedia = [];
    }

    public function addQuickLink()
    {
        $this->topHeaderQuickLinks[] = [
            'name' => '',
            'url' => '',
            'icon' => 'ri-link',
            'target' => '_self'
        ];
    }

    public function removeQuickLink($index)
    {
        unset($this->topHeaderQuickLinks[$index]);
        $this->topHeaderQuickLinks = array_values($this->topHeaderQuickLinks);
    }

    public function addSocialLink()
    {
        $this->topHeaderSocialMedia[] = [
            'icon' => 'ri-facebook-fill',
            'url' => '',
            'target' => '_blank'
        ];
    }

    public function removeSocialLink($index)
    {
        unset($this->topHeaderSocialMedia[$index]);
        $this->topHeaderSocialMedia = array_values($this->topHeaderSocialMedia);
    }

    public function applyTemplate($templateType)
    {
        switch ($templateType) {
            case 'rtl_news':
                $this->movementType = 'scroll';
                $this->movementDirection = 'rtl';
                $this->animationSpeed = 20;
                $this->topHeaderBackgroundColor = '#3b82f6';
                $this->topHeaderTextColor = '#ffffff';
                $this->backgroundGradient = 'linear-gradient(90deg, #3b82f6, #1d4ed8)';
                $this->headerText = '🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن!';
                $this->topHeaderHeight = 40;
                $this->fontSize = '14px';
                $this->fontWeight = '400';
                $this->showContactInfo = false;
                $this->showSocialIcons = false;
                break;
                
            case 'ltr_news':
                $this->movementType = 'scroll';
                $this->movementDirection = 'ltr';
                $this->animationSpeed = 20;
                $this->topHeaderBackgroundColor = '#10b981';
                $this->topHeaderTextColor = '#ffffff';
                $this->backgroundGradient = 'linear-gradient(90deg, #10b981, #047857)';
                $this->headerText = '✨ أحدث المنتجات وصلت! تسوق الآن واحصل على شحن مجاني';
                $this->topHeaderHeight = 40;
                $this->fontSize = '14px';
                $this->fontWeight = '400';
                $this->showContactInfo = false;
                $this->showSocialIcons = false;
                break;
                
            case 'fixed_contact':
                $this->movementType = 'fixed';
                $this->topHeaderBackgroundColor = '#1e293b';
                $this->topHeaderTextColor = '#ffffff';
                $this->backgroundGradient = 'none';
                $this->headerText = '';
                $this->topHeaderHeight = 40;
                $this->fontSize = '14px';
                $this->fontWeight = '400';
                $this->showContactInfo = true;
                $this->contactPhone = '+966 55 123 4567';
                $this->contactEmail = 'info@example.com';
                $this->showSocialIcons = true;
                break;
        }
        
        session()->flash('success', 'تم تطبيق القالب بنجاح!');
        $this->dispatch('updatePreview');
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                // General Settings
                'top_header_enabled' => $this->topHeaderEnabled ?? true,
                'top_header_position' => $this->topHeaderPosition ?? 'top',
                'top_header_height' => $this->topHeaderHeight ?? 40,
                'top_header_sticky' => $this->topHeaderSticky ?? false,
                'background_color' => $this->topHeaderBackgroundColor ?? '#3b82f6',
                'text_color' => $this->topHeaderTextColor ?? '#ffffff',
                'border_color' => $this->topHeaderBorderColor ?? '#374151',
                'opacity' => $this->topHeaderOpacity ?? 100,

                // Contact Information
                'contact_enabled' => $this->contactEnabled ?? true,
                'phone' => $this->topHeaderPhone,
                'email' => $this->topHeaderEmail,
                'address' => $this->topHeaderAddress,

                // Quick Links
                'quick_links_enabled' => $this->quickLinksEnabled ?? true,
                'quick_links' => json_encode($this->topHeaderQuickLinks ?? []),

                // Social Media
                'social_media_enabled' => $this->socialMediaEnabled ?? true,
                'social_media' => json_encode($this->topHeaderSocialMedia ?? []),

                // Language & Currency
                'language_switcher_enabled' => $this->languageSwitcherEnabled ?? false,
                'currency_switcher_enabled' => $this->currencySwitcherEnabled ?? false,

                // Announcement
                'announcement_enabled' => $this->announcementEnabled ?? false,
                'announcement_text' => $this->announcementText,
                'announcement_link' => $this->announcementLink,
                'announcement_bg_color' => $this->announcementBackgroundColor ?? '#6366f1',
                'announcement_text_color' => $this->announcementTextColor ?? '#ffffff',
                'announcement_scrolling' => $this->announcementScrolling ?? false,

                // Auth Links
                'auth_links_enabled' => $this->authLinksEnabled ?? true,
                'show_login_link' => $this->showLoginLink ?? true,
                'show_register_link' => $this->showRegisterLink ?? true,
                'login_text' => $this->loginText ?? 'تسجيل الدخول',
                'register_text' => $this->registerText ?? 'إنشاء حساب',

                // Working Hours
                'working_hours_enabled' => $this->workingHoursEnabled ?? false,
                'working_hours' => $this->workingHours,
                
                // Movement Settings
                'movement_type' => $this->movementType ?? 'scroll',
                'movement_direction' => $this->movementDirection ?? 'rtl',
                'animation_speed' => $this->animationSpeed ?? 20,
                'pause_on_hover' => $this->pauseOnHover ?? false,
                'infinite_loop' => $this->infiniteLoop ?? true,
                
                // Content & Style Settings
                'header_text' => $this->headerText ?? '',
                'header_link' => $this->headerLink ?? '',
                'font_size' => $this->fontSize ?? '14px',
                'font_weight' => $this->fontWeight ?? '400',
                
                // Color Settings
                'background_gradient' => $this->backgroundGradient ?? 'none',
                'enable_shadow' => $this->enableShadow ?? false,
                'enable_opacity' => $this->enableOpacity ?? false,
                
                // Additional Content
                'show_contact_info' => $this->showContactInfo ?? false,
                'contact_phone' => $this->topHeaderPhone ?? '',
                'contact_email' => $this->topHeaderEmail ?? '',
                'show_social_icons' => $this->showSocialIcons ?? false,
                'show_close_button' => $this->showCloseButton ?? false,
                'show_countdown' => $this->showCountdown ?? false,
                'countdown_date' => !empty($this->countdownDate) ? $this->countdownDate : null,
                'text_only' => $this->textOnly ?? false,
            ];

            TopHeaderSettings::updateSettings($data, $this->storeId);

            session()->flash('success', 'تم حفظ إعدادات الهيدر العلوي بنجاح!');
            
            $this->dispatch('top-header-settings-updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حفظ الإعدادات: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.top-header-customizer');
    }
}
