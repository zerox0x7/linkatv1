# Responsive Images Usage Guide

This guide explains how to use the new responsive image system in your theme templates.

## Overview

When you upload an image through the theme customizer, the system automatically creates 4 versions:
- **Small** (480px width) - For mobile devices
- **Medium** (768px width) - For tablets
- **Large** (1200px width) - For desktop
- **XL** (1920px width) - For large screens

The browser will automatically load the most appropriate size based on the user's screen, improving performance and user experience.

## How Images Are Stored

Previously, images were stored as a single path string:
```php
'image' => 'themes/torganic/hero/image.jpg'
```

Now, they are stored as an array of paths:
```php
'image' => [
    'small' => 'themes/torganic/hero/image_small.jpg',
    'medium' => 'themes/torganic/hero/image_medium.jpg',
    'large' => 'themes/torganic/hero/image_large.jpg',
    'xl' => 'themes/torganic/hero/image_xl.jpg',
    'default' => 'themes/torganic/hero/image_large.jpg'
]
```

The system is **backward compatible** - old single-path images will still work!

## Helper Functions

### 1. `getResponsiveImageUrl($imagePath, $size = 'large', $disk = 'public')`

Get a single size URL from a responsive image.

**Usage:**
```php
// Get the large version (default)
$url = getResponsiveImageUrl($heroSlide['image']);

// Get a specific size
$smallUrl = getResponsiveImageUrl($heroSlide['image'], 'small');
$mediumUrl = getResponsiveImageUrl($heroSlide['image'], 'medium');
$xlUrl = getResponsiveImageUrl($heroSlide['image'], 'xl');
```

### 2. `responsiveImage($imagePath, $alt = '', $class = '', $style = '', $disk = 'public')`

Generate a complete `<img>` tag with srcset for responsive loading.

**Usage:**
```php
// Simple usage
{!! responsiveImage($heroSlide['image'], 'Hero Image') !!}

// With CSS class
{!! responsiveImage($heroSlide['image'], 'Hero Image', 'img-fluid rounded') !!}

// With class and style
{!! responsiveImage($heroSlide['image'], 'Hero Image', 'img-fluid', 'width: 100%; height: auto;') !!}
```

**Generates:**
```html
<img 
    src="/storage/themes/torganic/hero/image_large.jpg" 
    srcset="/storage/themes/torganic/hero/image_small.jpg 480w,
            /storage/themes/torganic/hero/image_medium.jpg 768w,
            /storage/themes/torganic/hero/image_large.jpg 1200w,
            /storage/themes/torganic/hero/image_xl.jpg 1920w"
    sizes="(max-width: 480px) 480px, (max-width: 768px) 768px, (max-width: 1200px) 1200px, 1920px"
    alt="Hero Image"
    class="img-fluid rounded"
>
```

### 3. `getResponsiveBackgroundStyle($imagePath, $additionalStyles = '', $disk = 'public')`

Get inline style for background images (uses XL size for best quality).

**Usage:**
```php
// Simple background
<div style="{{ getResponsiveBackgroundStyle($heroSlide['image']) }}">
    Content here
</div>

// With additional styles
<div style="{{ getResponsiveBackgroundStyle($heroSlide['image'], 'background-size: cover; background-position: center;') }}">
    Content here
</div>
```

### 4. `getResponsiveImageSrcset($imagePath, $disk = 'public')`

Get just the srcset attribute value (useful for manual control).

**Usage:**
```php
<img 
    src="{{ getResponsiveImageUrl($heroSlide['image']) }}" 
    srcset="{{ getResponsiveImageSrcset($heroSlide['image']) }}"
    sizes="{{ getResponsiveImageSizes() }}"
    alt="Hero Image"
>
```

## Migration Examples

### Example 1: Background Image (OLD vs NEW)

**OLD CODE:**
```php
@php
    $backgroundImage = $heroSlide && isset($heroSlide['image']) 
        ? asset('storage/' . $heroSlide['image']) 
        : asset('themes/torganic/assets/images/banner/home2/1.png');
@endphp
<div style="background-image: url({{ $backgroundImage }}); background-size: cover;">
    Content
</div>
```

**NEW CODE (Option 1 - Simple):**
```php
<div style="{{ getResponsiveBackgroundStyle($heroSlide['image'] ?? null, 'background-size: cover;') }}">
    Content
</div>
```

**NEW CODE (Option 2 - With Fallback):**
```php
@php
    $backgroundImage = $heroSlide['image'] ?? 'themes/torganic/assets/images/banner/home2/1.png';
@endphp
<div style="{{ getResponsiveBackgroundStyle($backgroundImage, 'background-size: cover; background-position: center;') }}">
    Content
</div>
```

### Example 2: Regular Image Tag (OLD vs NEW)

**OLD CODE:**
```php
@php
    $slide4Image = $heroSlide4 && isset($heroSlide4['image']) 
        ? asset('storage/' . $heroSlide4['image']) 
        : asset('themes/torganic/assets/images/product/sale-banner/5.png');
@endphp
<img src="{{ $slide4Image }}" alt="Product" style="width: 220px; height: 167px;">
```

**NEW CODE:**
```php
{!! responsiveImage(
    $heroSlide4['image'] ?? 'themes/torganic/assets/images/product/sale-banner/5.png',
    'Product',
    '',
    'width: 220px; height: 167px; object-fit: contain;'
) !!}
```

### Example 3: Image with CSS Classes (OLD vs NEW)

**OLD CODE:**
```php
<img src="{{ asset('storage/' . $heroSlide9['image']) }}" 
     alt="Banner" 
     class="sale-banner__image">
```

**NEW CODE:**
```php
{!! responsiveImage($heroSlide9['image'], 'Banner', 'sale-banner__image') !!}
```

## Complete Template Example

Here's a complete example of updating a banner section:

**BEFORE:**
```blade
<div class="banner__wrapper" style="background-image: url({{ asset('storage/' . $heroSlide['image']) }});">
    <div class="banner__content">
        <h1>{{ $heroSlide['title'] }}</h1>
        <p>{{ $heroSlide['subtitle'] }}</p>
    </div>
</div>
```

**AFTER:**
```blade
<div class="banner__wrapper" style="{{ getResponsiveBackgroundStyle($heroSlide['image'], 'background-size: cover; background-position: center;') }}">
    <div class="banner__content">
        <h1>{{ $heroSlide['title'] }}</h1>
        <p>{{ $heroSlide['subtitle'] }}</p>
    </div>
</div>
```

## Testing

To test if responsive images are working:

1. Upload a new image through the theme customizer
2. Check the storage folder - you should see multiple versions (e.g., `image_small.jpg`, `image_medium.jpg`, etc.)
3. Open your browser's Developer Tools (F12)
4. Go to the Network tab
5. Refresh the page
6. Check which image size is loaded - it should match your screen size
7. Resize your browser window and refresh - a different size should load

## Performance Benefits

- **Faster Page Load**: Mobile users download smaller images
- **Bandwidth Savings**: Users only download what they need
- **Better UX**: Images load faster, especially on slow connections
- **SEO Improvement**: Google favors fast-loading sites

## Backward Compatibility

The system is fully backward compatible:
- Old images (stored as strings) continue to work
- Helper functions detect the format automatically
- No need to migrate existing images (they'll work as-is)
- New images get the responsive treatment automatically

## Size Configuration

Image sizes are defined in `app/Services/ResponsiveImageService.php`:

```php
protected $sizes = [
    'small' => 480,    // Mobile devices
    'medium' => 768,   // Tablets
    'large' => 1200,   // Desktop
    'xl' => 1920,      // Large screens
];
```

You can modify these values to suit your needs.

## FAQ

**Q: What if I upload a small image (e.g., 400px)?**
A: The system detects this and won't upscale. It will use the original for all sizes.

**Q: Do I need to update all my templates now?**
A: No! Old code continues to work. Update templates gradually as needed.

**Q: Can I use this for product images?**
A: Yes! The helper functions work with any image path.

**Q: What image formats are supported?**
A: JPEG, PNG, GIF, WebP - anything supported by Intervention Image.

**Q: Will this increase storage usage?**
A: Yes, but the tradeoff is worth it for better performance. Each image creates 4 versions, but they're optimized and smaller than the original.

