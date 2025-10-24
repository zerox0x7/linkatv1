<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HomePage;

class FooterCustomizer extends Component
{
    // Footer settings
    public $footerEnabled = true;
    public $footerCopyright = '';
    public $footerBackgroundColor = '#1e293b';
    public $footerTextColor = '#d1d5db';
    public $footerDescription = '';
    
    // Contact information
    public $footerPhone = '';
    public $footerEmail = '';
    public $footerAddress = '';
    
    // Footer links
    public $footerQuickLinks = [];
    public $footerLinksEnabled = true;
    
    // Social media links
    public $footerSocialMedia = [];
    public $socialLinksEnabled = true;
    
    // Contact section
    public $contactEnabled = true;
    
    // Footer section toggles
    public $footerSocialMediaEnabled = true;
    public $footerPaymentMethodsEnabled = false;
    public $footerCategoriesEnabled = false;
    
    protected $rules = [
        'footerCopyright' => 'nullable|string|max:255',
        'footerBackgroundColor' => 'required|string|max:7',
        'footerTextColor' => 'required|string|max:7',
        'footerDescription' => 'nullable|string|max:1000',
        'footerPhone' => 'nullable|string|max:20',
        'footerEmail' => 'nullable|email|max:255',
        'footerAddress' => 'nullable|string|max:500',
        'footerQuickLinks' => 'nullable|array',
        'footerQuickLinks.*.name' => 'nullable|string|max:100',
        'footerQuickLinks.*.url' => 'nullable|string|max:255',
        'footerSocialMedia' => 'nullable|array',
        'footerSocialMedia.*.icon' => 'required|string|max:50',
        'footerSocialMedia.*.url' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->loadFooterData();
    }

    public function loadFooterData()
    {
        $homePage = HomePage::first();
        
        if ($homePage) {
            $this->footerEnabled = $homePage->footer_enabled ?? true;
            $this->footerCopyright = $homePage->footer_copyright ?? '© 2024 جميع الحقوق محفوظة';
            $this->footerBackgroundColor = $homePage->footer_background_color ?? '#1e293b';
            $this->footerTextColor = $homePage->footer_text_color ?? '#d1d5db';
            $this->footerDescription = $homePage->footer_description ?? '';
            $this->footerPhone = $homePage->footer_phone ?? '';
            $this->footerEmail = $homePage->footer_email ?? '';
            $this->footerAddress = $homePage->footer_address ?? '';
            
            // Load footer quick links
            $this->footerQuickLinks = $homePage->footer_quick_links ?? [
                ['name' => 'سياسة الخصوصية', 'url' => '/privacy-policy'],
                ['name' => 'شروط الاستخدام', 'url' => '/terms-of-service']
            ];
            
            // Load social media links
            $this->footerSocialMedia = $homePage->footer_social_media ?? [
                ['icon' => 'ri-facebook-fill', 'url' => 'https://facebook.com/yourpage'],
                ['icon' => 'ri-twitter-fill', 'url' => 'https://twitter.com/yourhandle']
            ];
            
            // Load footer section toggles
            $this->footerSocialMediaEnabled = $homePage->footer_social_media_enabled ?? true;
            $this->footerPaymentMethodsEnabled = $homePage->footer_payment_methods_enabled ?? false;
            $this->footerCategoriesEnabled = $homePage->footer_categories_enabled ?? false;
        } else {
            // Set default values
            $this->setDefaultValues();
        }
    }

    private function setDefaultValues()
    {
        $this->footerCopyright = '© 2024 جميع الحقوق محفوظة';
        $this->footerBackgroundColor = '#1e293b';
        $this->footerTextColor = '#d1d5db';
        $this->footerPhone = '+966 55 123 4567';
        $this->footerEmail = 'info@example.com';
        $this->footerAddress = 'الرياض، المملكة العربية السعودية';
        
        $this->footerQuickLinks = [
            ['name' => 'سياسة الخصوصية', 'url' => '/privacy-policy'],
            ['name' => 'شروط الاستخدام', 'url' => '/terms-of-service']
        ];
        
        $this->footerSocialMedia = [
            ['icon' => 'ri-facebook-fill', 'url' => 'https://facebook.com/yourpage'],
            ['icon' => 'ri-twitter-fill', 'url' => 'https://twitter.com/yourhandle']
        ];
    }

    public function addFooterLink()
    {
        $this->footerQuickLinks[] = ['name' => '', 'url' => ''];
    }

    public function removeFooterLink($index)
    {
        unset($this->footerQuickLinks[$index]);
        $this->footerQuickLinks = array_values($this->footerQuickLinks);
    }

    public function addSocialLink()
    {
        $this->footerSocialMedia[] = ['icon' => 'ri-facebook-fill', 'url' => ''];
    }

    public function removeSocialLink($index)
    {
        unset($this->footerSocialMedia[$index]);
        $this->footerSocialMedia = array_values($this->footerSocialMedia);
    }

    public function save()
    {
        // Simple validation - just check that we have data
        $this->validate([
            'footerCopyright' => 'nullable|string|max:255',
            'footerBackgroundColor' => 'required|string|max:7',
            'footerTextColor' => 'required|string|max:7',
            'footerDescription' => 'nullable|string|max:1000',
            'footerPhone' => 'nullable|string|max:20',
            'footerEmail' => 'nullable|email|max:255',
            'footerAddress' => 'nullable|string|max:500',
        ]);

        try {
            $homePage = HomePage::first();
            
            if (!$homePage) {
                $homePage = HomePage::getDefault();
            }

            $updateData = [
                'footer_enabled' => $this->footerEnabled,
                'footer_copyright' => $this->footerCopyright,
                'footer_background_color' => $this->footerBackgroundColor,
                'footer_text_color' => $this->footerTextColor,
                'footer_description' => $this->footerDescription,
                'footer_phone' => $this->footerPhone,
                'footer_email' => $this->footerEmail,
                'footer_address' => $this->footerAddress,
                'footer_quick_links' => $this->footerQuickLinks,
                'footer_social_media' => $this->footerSocialMedia,
                'footer_social_media_enabled' => $this->footerSocialMediaEnabled,
                'footer_payment_methods_enabled' => $this->footerPaymentMethodsEnabled,
                'footer_categories_enabled' => $this->footerCategoriesEnabled,
            ];

            $homePage->update($updateData);

            session()->flash('success', 'تم حفظ إعدادات الفوتر بنجاح!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.footer-customizer');
    }
}
