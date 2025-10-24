<?php

namespace App\Livewire;

use Livewire\Component;

class IconPicker extends Component
{
    public $selectedIcon = '';
    public $searchTerm = '';
    public $isOpen = false;
    public $fieldName = 'icon';
    public $placeholder = 'اختر أيقونة';
    public $label = 'الأيقونة';

    // Common Remix icons categorized
    public $icons = [
        'business' => [
            'ri-briefcase-line', 'ri-building-line', 'ri-bank-line', 'ri-store-line',
            'ri-shopping-bag-line', 'ri-money-dollar-circle-line', 'ri-pie-chart-line',
            'ri-bar-chart-line', 'ri-line-chart-line', 'ri-stock-line'
        ],
        'tech' => [
            'ri-computer-line', 'ri-smartphone-line', 'ri-tablet-line', 'ri-tv-line',
            'ri-webcam-line', 'ri-router-line', 'ri-cpu-line', 'ri-hard-drive-line',
            'ri-database-line', 'ri-server-line', 'ri-code-line', 'ri-terminal-line'
        ],
        'communication' => [
            'ri-mail-line', 'ri-phone-line', 'ri-message-line', 'ri-chat-line',
            'ri-notification-line', 'ri-send-plane-line', 'ri-whatsapp-line',
            'ri-telegram-line', 'ri-twitter-line', 'ri-facebook-line'
        ],
        'media' => [
            'ri-image-line', 'ri-video-line', 'ri-music-line', 'ri-camera-line',
            'ri-film-line', 'ri-play-line', 'ri-pause-line', 'ri-volume-up-line',
            'ri-headphone-line', 'ri-mic-line'
        ],
        'navigation' => [
            'ri-home-line', 'ri-dashboard-line', 'ri-menu-line', 'ri-more-line',
            'ri-arrow-right-line', 'ri-arrow-left-line', 'ri-arrow-up-line',
            'ri-arrow-down-line', 'ri-external-link-line', 'ri-links-line'
        ],
        'actions' => [
            'ri-add-line', 'ri-subtract-line', 'ri-edit-line', 'ri-delete-bin-line',
            'ri-save-line', 'ri-download-line', 'ri-upload-line', 'ri-refresh-line',
            'ri-search-line', 'ri-filter-line', 'ri-settings-line', 'ri-tools-line'
        ],
        'status' => [
            'ri-check-line', 'ri-close-line', 'ri-error-warning-line', 'ri-information-line',
            'ri-question-line', 'ri-thumb-up-line', 'ri-thumb-down-line',
            'ri-heart-line', 'ri-star-line', 'ri-bookmark-line'
        ],
        'user' => [
            'ri-user-line', 'ri-team-line', 'ri-account-circle-line', 'ri-user-settings-line',
            'ri-admin-line', 'ri-customer-service-line', 'ri-contacts-line',
            'ri-group-line', 'ri-parent-line', 'ri-user-add-line'
        ],
        'files' => [
            'ri-file-line', 'ri-folder-line', 'ri-file-text-line', 'ri-file-pdf-line',
            'ri-file-word-line', 'ri-file-excel-line', 'ri-file-ppt-line',
            'ri-file-zip-line', 'ri-attachment-line', 'ri-cloud-line'
        ],
        'shopping' => [
            'ri-shopping-cart-line', 'ri-price-tag-line', 'ri-coupon-line',
            'ri-gift-line', 'ri-wallet-line', 'ri-bank-card-line',
            'ri-refund-line', 'ri-secure-payment-line', 'ri-truck-line', 'ri-box-line'
        ]
    ];

    public function mount($selectedIcon = '', $fieldName = 'icon', $placeholder = 'اختر أيقونة', $label = 'الأيقونة')
    {
        $this->selectedIcon = $selectedIcon;
        $this->fieldName = $fieldName;
        $this->placeholder = $placeholder;
        $this->label = $label;
    }

    public function selectIcon($icon)
    {
        $this->selectedIcon = $icon;
        $this->isOpen = false;
        $this->dispatch('iconSelected', [
            'icon' => $icon,
            'fieldName' => $this->fieldName
        ]);
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

    public function getFilteredIcons()
    {
        if (empty($this->searchTerm)) {
            return $this->icons;
        }

        $filteredIcons = [];
        foreach ($this->icons as $category => $categoryIcons) {
            $filtered = array_filter($categoryIcons, function($icon) {
                return strpos($icon, strtolower($this->searchTerm)) !== false;
            });
            
            if (!empty($filtered)) {
                $filteredIcons[$category] = $filtered;
            }
        }
        
        return $filteredIcons;
    }

    public function render()
    {
        return view('livewire.icon-picker', [
            'filteredIcons' => $this->getFilteredIcons()
        ]);
    }
} 