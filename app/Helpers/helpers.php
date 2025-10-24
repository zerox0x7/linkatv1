<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getActiveTheme')) {
    /**
     * Get the active theme for the authenticated user.
     *
     * @return string
     */
    function getActiveTheme()
    {
        // Check if the user is authenticated and return their active theme
        return Auth::check() ? Auth::user()->active_theme : 'default';
    }
}


if (!function_exists('storeCheck')) {
    /**
     * Get the active theme for the authenticated user.
     *
     * @return string
     */
    function storeCheck()
    {
        $store = $request->attributes->get('store');
        if($request->input('store_id') != $store->id )
        {
             abort(403, 'Unauthorized action.');

        }
    }
}

if (!function_exists('getResponsiveImageUrl')) {
    /**
     * Get URL for a responsive image (single size).
     * 
     * @param array|string $imagePath Can be array of responsive sizes or single path
     * @param string $size The desired size: small, medium, large, xl
     * @param string $disk Storage disk
     * @return string The image URL
     */
    function getResponsiveImageUrl($imagePath, $size = 'large', $disk = 'public')
    {
        if (is_array($imagePath)) {
            // If it's a responsive image array, get the requested size
            if (isset($imagePath[$size])) {
                return Storage::disk($disk)->url($imagePath[$size]);
            }
            
            // Fallback to default or first available
            if (isset($imagePath['default'])) {
                return Storage::disk($disk)->url($imagePath['default']);
            }
            
            if (isset($imagePath['large'])) {
                return Storage::disk($disk)->url($imagePath['large']);
            }
            
            // Return first available
            return Storage::disk($disk)->url(reset($imagePath));
        }
        
        // Single path, return as is
        return Storage::disk($disk)->url($imagePath);
    }
}

if (!function_exists('getResponsiveImageSrcset')) {
    /**
     * Get srcset attribute for responsive images.
     * 
     * @param array|string $imagePath Can be array of responsive sizes or single path
     * @param string $disk Storage disk
     * @return string The srcset attribute value
     */
    function getResponsiveImageSrcset($imagePath, $disk = 'public')
    {
        if (!is_array($imagePath)) {
            return '';
        }
        
        $sizes = [
            'thumbnail' => 150,
            'small' => 480,
            'medium' => 768,
            'large' => 1200,
        ];
        
        $srcset = [];
        
        foreach ($sizes as $sizeName => $width) {
            if (isset($imagePath[$sizeName])) {
                $url = Storage::disk($disk)->url($imagePath[$sizeName]);
                $srcset[] = $url . ' ' . $width . 'w';
            }
        }
        
        return implode(', ', $srcset);
    }
}

if (!function_exists('getResponsiveImageSizes')) {
    /**
     * Get sizes attribute for responsive images.
     * 
     * @return string The sizes attribute value
     */
    function getResponsiveImageSizes()
    {
        return '(max-width: 150px) 150px, (max-width: 480px) 480px, (max-width: 768px) 768px, 1200px';
    }
}

if (!function_exists('responsiveImage')) {
    /**
     * Generate a complete img tag with responsive srcset.
     * 
     * @param array|string $imagePath Can be array of responsive sizes or single path
     * @param string $alt Alt text for the image
     * @param string $class CSS classes
     * @param string $style Inline styles
     * @param string $disk Storage disk
     * @return string The complete img tag HTML
     */
    function responsiveImage($imagePath, $alt = '', $class = '', $style = '', $disk = 'public')
    {
        $src = is_array($imagePath) 
            ? getResponsiveImageUrl($imagePath, 'large', $disk)
            : Storage::disk($disk)->url($imagePath);
        
        $srcset = getResponsiveImageSrcset($imagePath, $disk);
        $sizes = getResponsiveImageSizes();
        
        $attributes = [
            'src' => $src,
            'alt' => $alt,
        ];
        
        if ($srcset) {
            $attributes['srcset'] = $srcset;
            $attributes['sizes'] = $sizes;
        }
        
        if ($class) {
            $attributes['class'] = $class;
        }
        
        if ($style) {
            $attributes['style'] = $style;
        }
        
        $attributesHtml = [];
        foreach ($attributes as $key => $value) {
            $attributesHtml[] = $key . '="' . htmlspecialchars($value) . '"';
        }
        
        return '<img ' . implode(' ', $attributesHtml) . '>';
    }
}

if (!function_exists('getResponsiveBackgroundStyle')) {
    /**
     * Get inline style for background image with fallback sizes.
     * For backgrounds, we typically want to use the largest available image (original).
     * 
     * @param array|string $imagePath Can be array of responsive sizes or single path
     * @param string $additionalStyles Additional CSS styles
     * @param string $disk Storage disk
     * @return string The style attribute value
     */
    function getResponsiveBackgroundStyle($imagePath, $additionalStyles = '', $disk = 'public')
    {
        $url = is_array($imagePath) 
            ? getResponsiveImageUrl($imagePath, 'original', $disk)
            : Storage::disk($disk)->url($imagePath);
        
        $style = 'background-image: url(' . $url . ');';
        
        if ($additionalStyles) {
            $style .= ' ' . $additionalStyles;
        }
        
        return $style;
    }
}