<?php

namespace App\Traits;

use App\Models\ProductsPage;

trait HasProductsPageSettings
{
    protected $productsPageSettings = null;

    /**
     * Get the products page settings
     */
    public function getProductsPageSettings()
    {
        if ($this->productsPageSettings === null) {
            $this->productsPageSettings = ProductsPage::getSettings();
        }

        return $this->productsPageSettings;
    }

    /**
     * Check if a products page feature is enabled
     */
    public function isProductsPageFeatureEnabled($feature)
    {
        return ProductsPage::isEnabled($feature);
    }

    /**
     * Get a specific products page setting
     */
    public function getProductsPageSetting($key, $default = null)
    {
        return ProductsPage::getSetting($key, $default);
    }

    /**
     * Get products page colors
     */
    public function getProductsPageColors()
    {
        return $this->getProductsPageSettings()->colors;
    }

    /**
     * Get products per page setting
     */
    public function getProductsPerPage()
    {
        return $this->getProductsPageSetting('products_per_page', 12);
    }

    /**
     * Get default sort setting
     */
    public function getDefaultSort()
    {
        return $this->getProductsPageSetting('default_sort', 'latest');
    }

    /**
     * Check if discount is currently active
     */
    public function isDiscountActive()
    {
        return $this->getProductsPageSettings()->isDiscountActive();
    }

    /**
     * Get discount information
     */
    public function getDiscountInfo()
    {
        $settings = $this->getProductsPageSettings();
        
        if (!$settings->isDiscountActive()) {
            return null;
        }

        return [
            'text' => $settings->discount_text,
            'end_date' => $settings->discount_end_date,
            'time_remaining' => $settings->getDiscountTimeRemaining(),
            'style' => $settings->timer_style
        ];
    }

    /**
     * Get coupon information
     */
    public function getCouponInfo()
    {
        $settings = $this->getProductsPageSettings();
        
        if (!$settings->coupon_banner_enabled) {
            return null;
        }

        return [
            'code' => $settings->coupon_code,
            'text' => $settings->coupon_text,
            'background_color' => $settings->coupon_background_color
        ];
    }
} 