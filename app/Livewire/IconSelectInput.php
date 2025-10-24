<?php

namespace App\Livewire;

use Livewire\Component;

class IconSelectInput extends Component
{
    public $value = '';
    public $searchTerm = '';
    public $isOpen = false;
    public $placeholder = 'اختر أيقونة';
    public $label = '';
    public $customClass = 'custom-input p-3 rounded-md w-full';
    public $wireModel = '';

    protected $icons = [
        // Services & Delivery
        'ri-truck-line' => 'توصيل',
        'ri-ship-line' => 'شحن',
        'ri-plane-line' => 'طيران',
        'ri-car-line' => 'سيارة',
        'ri-bike-line' => 'دراجة',
        'ri-subway-line' => 'مترو',
        
        // Support & Security
        'ri-shield-check-line' => 'ضمان', 
        'ri-customer-service-2-line' => 'دعم فني',
        'ri-refund-2-line' => 'استرجاع',
        'ri-security-scan-line' => 'أمان',
        'ri-lock-line' => 'حماية',
        'ri-key-line' => 'مفتاح',
        
        // Quality & Awards
        'ri-award-line' => 'جودة',
        'ri-medal-line' => 'ميدالية',
        'ri-trophy-line' => 'كأس',
        'ri-vip-crown-line' => 'تاج',
        'ri-star-line' => 'تقييم',
        'ri-star-fill' => 'تقييم مملوء',
        
        // Shopping & Commerce
        'ri-price-tag-line' => 'أسعار',
        'ri-shopping-cart-line' => 'سلة التسوق',
        'ri-shopping-bag-line' => 'حقيبة تسوق',
        'ri-store-line' => 'متجر',
        'ri-store-2-line' => 'متجر 2',
        'ri-building-line' => 'مبنى',
        'ri-bank-line' => 'بنك',
        
        // Communication
        'ri-phone-line' => 'هاتف',
        'ri-mail-line' => 'بريد',
        'ri-chat-1-line' => 'محادثة',
        'ri-message-line' => 'رسالة',
        'ri-notification-line' => 'إشعار',
        'ri-headphone-line' => 'سماعة',
        
        // Users & Teams
        'ri-user-line' => 'مستخدم',
        'ri-user-star-line' => 'مستخدم نجم',
        'ri-team-line' => 'فريق',
        'ri-group-line' => 'مجموعة',
        'ri-admin-line' => 'مدير',
        'ri-parent-line' => 'والد',
        
        // Technology & Tools
        'ri-settings-line' => 'إعدادات',
        'ri-tools-line' => 'أدوات',
        'ri-computer-line' => 'كمبيوتر',
        'ri-smartphone-line' => 'هاتف ذكي',
        'ri-tablet-line' => 'لوح',
        'ri-tv-line' => 'تلفزيون',
        'ri-gamepad-line' => 'ألعاب',
        'ri-headphone-line' => 'سماعات',
        'ri-camera-line' => 'كاميرا',
        'ri-video-line' => 'فيديو',
        
        // Favorites & Social
        'ri-heart-line' => 'مفضلة',
        'ri-heart-fill' => 'مفضلة مملوء',
        'ri-thumb-up-line' => 'إعجاب',
        'ri-share-line' => 'مشاركة',
        'ri-bookmark-line' => 'مرجعية',
        
        // Location & Time
        'ri-home-line' => 'منزل',
        'ri-map-pin-line' => 'موقع',
        'ri-compass-line' => 'بوصلة',
        'ri-road-map-line' => 'خريطة طريق',
        'ri-time-line' => 'وقت',
        'ri-calendar-line' => 'تاريخ',
        'ri-timer-line' => 'مؤقت',
        'ri-history-line' => 'تاريخ',
        
        // Business & Finance
        'ri-money-dollar-circle-line' => 'دولار',
        'ri-coin-line' => 'عملة',
        'ri-bank-card-line' => 'بطاقة بنكية',
        'ri-wallet-line' => 'محفظة',
        'ri-exchange-line' => 'صرف',
        'ri-funds-line' => 'أموال',
        'ri-profit-line' => 'ربح',
        
        // Education & Learning
        'ri-book-line' => 'كتاب',
        'ri-graduation-cap-line' => 'تخرج',
        'ri-pencil-line' => 'قلم',
        'ri-presentation-line' => 'عرض',
        'ri-lightbulb-line' => 'فكرة',
        'ri-brain-line' => 'عقل',
        
        // Health & Wellness
        'ri-heart-pulse-line' => 'نبض',
        'ri-medicine-bottle-line' => 'دواء',
        'ri-first-aid-kit-line' => 'إسعافات',
        'ri-mental-health-line' => 'صحة نفسية',
        'ri-run-line' => 'جري',
        'ri-bike-line' => 'رياضة',
        
        // Food & Dining
        'ri-restaurant-line' => 'مطعم',
        'ri-cake-line' => 'كيك',
        'ri-cup-line' => 'كوب',
        'ri-beer-line' => 'مشروب',
        'ri-knife-line' => 'سكين',
        
        // Entertainment & Fun
        'ri-gift-line' => 'هدية',
        'ri-fire-line' => 'شائع',
        'ri-flashlight-line' => 'مصباح',
        'ri-magic-line' => 'سحر',
        'ri-palette-line' => 'لوحة ألوان',
        'ri-music-line' => 'موسيقى',
        'ri-movie-line' => 'فيلم',
        
        // Weather & Nature
        'ri-sun-line' => 'شمس',
        'ri-moon-line' => 'قمر',
        'ri-cloud-line' => 'سحابة',
        'ri-plant-line' => 'نبات',
        'ri-tree-line' => 'شجرة',
        'ri-leaf-line' => 'ورقة',
        
        // Travel & Transportation
        'ri-suitcase-line' => 'حقيبة سفر',
        'ri-passport-line' => 'جواز سفر',
        'ri-hotel-line' => 'فندق',
        'ri-flight-takeoff-line' => 'إقلاع',
        'ri-earth-line' => 'أرض',
        'ri-global-line' => 'عالمي',
        
        // Documents & Files
        'ri-file-line' => 'ملف',
        'ri-folder-line' => 'مجلد',
        'ri-article-line' => 'مقال',
        'ri-clipboard-line' => 'حافظة',
        'ri-contract-line' => 'عقد',
        'ri-download-line' => 'تنزيل',
        'ri-upload-line' => 'رفع'
    ];

    public function mount($value = '', $label = '', $placeholder = 'اختر أيقونة', $customClass = 'custom-input p-3 rounded-md w-full', $wireModel = '')
    {
        $this->value = $value;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->customClass = $customClass;
        $this->wireModel = $wireModel;
    }

    public function updatedValue()
    {
        if ($this->wireModel) {
            $this->dispatch('updateWireModel', $this->wireModel, $this->value);
        }
    }

    public function selectIcon($iconValue)
    {
        $this->value = $iconValue;
        $this->isOpen = false;
        
        if ($this->wireModel) {
            $this->dispatch('updateWireModel', $this->wireModel, $this->value);
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->searchTerm = '';
    }

    public function clearSelection()
    {
        $this->value = '';
        if ($this->wireModel) {
            $this->dispatch('updateWireModel', $this->wireModel, '');
        }
    }

    public function getFilteredIcons()
    {
        if (empty($this->searchTerm)) {
            return $this->icons;
        }

        return array_filter($this->icons, function($label) {
            return stripos($label, $this->searchTerm) !== false;
        });
    }

    public function getSelectedIconLabel()
    {
        return $this->icons[$this->value] ?? null;
    }

    public function render()
    {
        return view('livewire.icon-select-input', [
            'filteredIcons' => $this->getFilteredIcons(),
            'selectedLabel' => $this->getSelectedIconLabel()
        ]);
    }
} 