<?php

namespace App\Services;

use App\Models\ThemesInfo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * ResponsiveImageService
 * 
 * This service handles the creation of multiple image sizes for responsive design.
 * When an image is uploaded, it creates 4 versions: small, medium, large, and xl.
 * 
 * This ensures images display correctly across different screen sizes and improves
 * page load performance by serving appropriately sized images.
 */
class ResponsiveImageService
{
    protected $manager;
    
    /**
     * Image size configurations
     * Format: [size_name => max_width]
     */
    protected $sizes = [
        'thumbnail' => 150,  // Thumbnails
        'small' => 480,      // Mobile devices
        'medium' => 768,     // Tablets
        'large' => 1200,     // Desktop
        'original' => null,  // Keep original size (no resize)
    ];
    
    public function __construct()
    {
        // Initialize Intervention Image with GD driver
        $this->manager = new ImageManager(new Driver());
    }
    
    /**
     * Upload and process image to create multiple responsive sizes
     * 
     * @param \Illuminate\Http\UploadedFile $file The uploaded file
     * @param string $basePath The base storage path (e.g., 'themes/torganic/hero')
     * @param string $disk The storage disk (default: 'public')
     * @return array Array containing paths to all generated image sizes
     */
    public function uploadAndResize($file, $basePath, $disk = 'public')
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid();
        $extension = $file->getClientOriginalExtension();
        
        // Get the uploaded file's real path
        $sourcePath = $file->getRealPath();
        
        // Read the image
        $image = $this->manager->read($sourcePath);
        
        $paths = [];
        
        // Get original dimensions
        $originalWidth = $image->width();
        $originalHeight = $image->height();
        
        // Save only the original image (no multiple sizes)
        $paths['original'] = $this->resizeAndSave(
            $image, 
            $basePath, 
            $filename . '.' . $extension, 
            null, 
            $disk
        );
        
        // COMMENTED OUT: Multiple size generation code
        // This code previously created multiple sizes (thumbnail, small, medium, large)
        // Now we only upload the original size as requested by the user
        
        /*
        // Create each responsive size (always create all sizes)
        foreach ($this->sizes as $sizeName => $maxWidth) {
            // Skip 'original' since we already saved it
            if ($sizeName === 'original' || $maxWidth === null) {
                continue;
            }
            
            // Always create the size file, even if image is smaller (won't upscale)
            if ($originalWidth > $maxWidth) {
                // Image is larger than target, resize it
                $paths[$sizeName] = $this->resizeAndSave(
                    $image, 
                    $basePath, 
                    $filename . '_' . $sizeName . '.' . $extension, 
                    $maxWidth, 
                    $disk
                );
            } else {
                // Image is smaller than target, save a copy at original size with the size name
                $paths[$sizeName] = $this->resizeAndSave(
                    $image, 
                    $basePath, 
                    $filename . '_' . $sizeName . '.' . $extension, 
                    null, // Don't resize, keep original dimensions
                    $disk
                );
            }
        }
        */
        
        // Set the original as default since we're only using one size
        $paths['default'] = $paths['original'];
        
        return $paths;
    }
    
    /**
     * Resize and save image
     * 
     * @param \Intervention\Image\Image $image
     * @param string $basePath
     * @param string $filename
     * @param int|null $maxWidth
     * @param string $disk
     * @return string The storage path
     */
    protected function resizeAndSave($image, $basePath, $filename, $maxWidth = null, $disk = 'public')
    {
        $path = $basePath . '/' . $filename;
        
        // Clone the image to avoid modifying the original
        $resizedImage = clone $image;
        
        if ($maxWidth !== null) {
            // Resize while maintaining aspect ratio
            $resizedImage->scale(width: $maxWidth);
        }
        
        // Encode the image
        $encoded = $resizedImage->encode();
        
        // Save to storage
        Storage::disk($disk)->put($path, (string) $encoded);
        
        return $path;
    }
    
    /**
     * Delete all sizes of a responsive image
     * 
     * @param array|string $paths Array of paths or single path
     * @param string $disk The storage disk (default: 'public')
     * @return void
     */
    public function deleteResponsiveImages($paths, $disk = 'public')
    {
        if (is_string($paths)) {
            // Single path - try to find and delete all related sizes
            $this->deleteSingleImageAllSizes($paths, $disk);
        } elseif (is_array($paths)) {
            // Array of paths - delete each one
            foreach ($paths as $path) {
                if (is_string($path)) {
                    Storage::disk($disk)->delete($path);
                    
                    // Also delete the _original copy if it exists
                    $pathInfo = pathinfo($path);
                    $directory = $pathInfo['dirname'] ?? '';
                    $filename = $pathInfo['filename'] ?? '';
                    $extension = $pathInfo['extension'] ?? '';
                    
                    // Only proceed if we have an extension
                    if ($extension && !str_ends_with($filename, '_original')) {
                        $originalPath = $directory . '/' . $filename . '_original.' . $extension;
                        Storage::disk($disk)->delete($originalPath);
                    }
                }
            }
        }
    }
    
    /**
     * Delete all sizes of a single image path
     * 
     * @param string $path
     * @param string $disk
     * @return void
     */
    protected function deleteSingleImageAllSizes($path, $disk = 'public')
    {
        // Extract path info
        $pathInfo = pathinfo($path);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        // Try to delete all possible size variations
        $suffixes = ['_thumbnail', '_small', '_medium', '_large', '_original', ''];
        
        foreach ($suffixes as $suffix) {
            $possiblePath = $directory . '/' . str_replace($suffix, '', $filename) . $suffix . '.' . $extension;
            Storage::disk($disk)->delete($possiblePath);
        }
        
        // Also try to delete the original path
        Storage::disk($disk)->delete($path);
    }
    
    /**
     * Get srcset string for HTML img tag
     * 
     * @param array $paths Array of image paths
     * @return string srcset attribute value
     */
    public function getSrcset($paths)
    {
        if (!is_array($paths)) {
            return '';
        }
        
        $srcset = [];
        
        foreach ($this->sizes as $sizeName => $maxWidth) {
            if ($maxWidth && isset($paths[$sizeName])) {
                $url = Storage::url($paths[$sizeName]);
                $srcset[] = $url . ' ' . $maxWidth . 'w';
            }
        }
        
        return implode(', ', $srcset);
    }
    
    /**
     * Get sizes attribute for HTML img tag
     * 
     * @return string sizes attribute value
     */
    public function getSizesAttribute()
    {
        return '(max-width: 150px) 150px, (max-width: 480px) 480px, (max-width: 768px) 768px, 1200px';
    }
    
    /**
     * Get the best size for a given context
     * 
     * @param array $paths Array of image paths
     * @param string $context The context (e.g., 'thumbnail', 'hero', 'banner')
     * @return string The path to the most appropriate image
     */
    public function getBestSize($paths, $context = 'default')
    {
        if (!is_array($paths)) {
            return $paths;
        }
        
        // Context-based size selection
        $contextMap = [
            'thumbnail' => 'thumbnail',
            'card' => 'medium',
            'hero' => 'original',
            'banner' => 'large',
            'default' => 'large',
        ];
        
        $preferredSize = $contextMap[$context] ?? 'large';
        
        // Return preferred size if available, otherwise fall back to default or first available
        if (isset($paths[$preferredSize])) {
            return $paths[$preferredSize];
        }
        
        if (isset($paths['default'])) {
            return $paths['default'];
        }
        
        if (isset($paths['large'])) {
            return $paths['large'];
        }
        
        if (isset($paths['original'])) {
            return $paths['original'];
        }
        
        // Return any available path
        return reset($paths);
    }
    
    /**
     * Get the required image size for a specific layout position from themes_info table
     * 
     * @param int $position The layout position (0-8)
     * @param string $themeName The theme name (e.g., 'torganic')
     * @return string The required size string (e.g., "400x300") or fallback size
     */
    public function getSizeForPosition($position, $themeName = 'torganic')
    {
        // Try to get size from themes_info table
        // Note: themes_info order is 1-indexed, but position is 0-indexed
        
        \Log::info("getSizeForPosition CALLED: position={$position}, themeName={$themeName}, timestamp=" . now());
        
        // Use direct query without model caching to ensure fresh data
        $themeInfoData = \DB::table('themes_info')
            ->where('name', $themeName)
            ->first();
        
        \Log::info("getSizeForPosition: Query executed, found: " . ($themeInfoData ? 'YES' : 'NO'));
        
        if ($themeInfoData) {
            // Decode the JSON images column
            $images = json_decode($themeInfoData->images, true);
            
            \Log::info("getSizeForPosition: Decoded images array, count=" . count($images ?? []));
            
            if ($images && is_array($images)) {
                // Convert 0-indexed position to 1-indexed order for themes_info lookup
                $order = $position + 1;
                
                \Log::info("getSizeForPosition: Looking for order={$order} in images array");
                
                // Find the size for this order
                foreach ($images as $index => $image) {
                    if (isset($image['order']) && $image['order'] == $order) {
                        $sizeString = $image['size'] ?? null;
                        \Log::info("getSizeForPosition: FOUND at index={$index}, order={$order}, size={$sizeString}");
                        if ($sizeString) {
                            return $sizeString;
                        }
                    }
                }
                
                \Log::warning("getSizeForPosition: No size found for position={$position}, order={$order} in themes_info. Available orders: " . json_encode(array_column($images, 'order')));
            }
        } else {
            \Log::warning("getSizeForPosition: Theme '{$themeName}' not found in themes_info");
        }
        
        // Fallback to hardcoded mapping if not found in themes_info table
        $positionSizeMap = [
            0 => '1200x800',   // Hero Principal - Large hero banner
            1 => '480x320',    // Top Right - Small side promo
            2 => '480x320',    // Bottom Right - Small side promo  
            3 => '480x320',    // Left Side - Small product highlight
            4 => '1200x800',   // Center Large - Large promotional banner
            5 => '480x320',    // Right Side - Small product highlight
            6 => '768x512',    // Secondary 1 - Medium category banner
            7 => '768x512',    // Secondary 2 - Medium category banner
            8 => '1920x1080',  // Full Width - XL campaign banner
        ];
        
        $fallbackSize = $positionSizeMap[$position] ?? '768x512';
        \Log::info("getSizeForPosition: Using fallback size={$fallbackSize} for position={$position}");
        return $fallbackSize;
    }
    
    /**
     * Parse size string to width and height
     * 
     * @param string $sizeString Size string like "400x300"
     * @return array Array with 'width' and 'height' keys
     */
    public function parseSizeString($sizeString)
    {
        if (preg_match('/^(\d+)x(\d+)$/', $sizeString, $matches)) {
            return [
                'width' => (int) $matches[1],
                'height' => (int) $matches[2]
            ];
        }
        
        // Default fallback
        return [
            'width' => 768,
            'height' => 512
        ];
    }
    
    /**
     * Resize image to specific size and save with position-specific naming
     * 
     * @param string $originalImagePath The path to the original image
     * @param int $position The layout position
     * @param string $disk The storage disk (default: 'public')
     * @return string The path to the resized image
     */
    public function resizeImageForPosition($originalImagePath, $position, $disk = 'public')
    {
        // Get the required size for this position
        $requiredSize = $this->getSizeForPosition($position);
        
        // Get the max width for this size
        $maxWidth = $this->sizes[$requiredSize] ?? null;
        
        // Check if original image exists
        if (!Storage::disk($disk)->exists($originalImagePath)) {
            throw new \Exception("Original image not found: {$originalImagePath}");
        }
        
        // Read the original image
        $imageContent = Storage::disk($disk)->get($originalImagePath);
        $image = $this->manager->read($imageContent);
        
        // Extract path info for naming
        $pathInfo = pathinfo($originalImagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        // Create new filename with position and size info
        $newFilename = $filename . '_pos' . $position . '_' . $requiredSize . '.' . $extension;
        $newPath = $directory . '/' . $newFilename;
        
        // Resize and save the image
        $resizedImage = clone $image;
        if ($maxWidth !== null) {
            $resizedImage->scale(width: $maxWidth);
        }
        
        // Encode and save
        $encoded = $resizedImage->encode();
        Storage::disk($disk)->put($newPath, (string) $encoded);
        
        return $newPath;
    }
    
    /**
     * Create a copy of original image with _original suffix for source reference
     * 
     * @param string $imagePath The current image path
     * @param string $disk The storage disk (default: 'public')
     * @return string The path to the original copy
     */
    public function createOriginalCopy($imagePath, $disk = 'public')
    {
        // Check if image exists
        if (!Storage::disk($disk)->exists($imagePath)) {
            throw new \Exception("Image not found: {$imagePath}");
        }
        
        // Extract path info
        $pathInfo = pathinfo($imagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        // Create original copy filename
        $originalFilename = $filename . '_original.' . $extension;
        $originalPath = $directory . '/' . $originalFilename;
        
        // Copy the file
        $imageContent = Storage::disk($disk)->get($imagePath);
        Storage::disk($disk)->put($originalPath, $imageContent);
        
        return $originalPath;
    }
    
    /**
     * Resize the main image file in place based on position requirements from themes_info table
     * 
     * @param string $mainImagePath The main image path (e.g., 1761319824_68fb9b903bb86.png)
     * @param string $originalImagePath The original source image path (e.g., 1761319824_68fb9b903bb86_original.png)
     * @param int $position The layout position
     * @param string $themeName The theme name (e.g., 'torganic')
     * @param string $disk The storage disk (default: 'public')
     * @return string The path to the resized main image (same as input)
     */
    public function resizeMainImageInPlace($mainImagePath, $originalImagePath, $position, $themeName = 'torganic', $disk = 'public')
    {
        \Log::info("resizeMainImageInPlace START: position={$position}, theme={$themeName}, mainPath={$mainImagePath}");
        
        // Get the required size string for this position from themes_info table
        $sizeString = $this->getSizeForPosition($position, $themeName);
        
        // Parse the size string to get width and height
        $dimensions = $this->parseSizeString($sizeString);
        $targetWidth = $dimensions['width'];
        $targetHeight = $dimensions['height'];
        
        \Log::info("resizeMainImageInPlace: targetSize={$sizeString}, width={$targetWidth}, height={$targetHeight}");
        
        // Check if original image exists
        if (!Storage::disk($disk)->exists($originalImagePath)) {
            \Log::error("resizeMainImageInPlace: Original image not found: {$originalImagePath}");
            throw new \Exception("Original image not found: {$originalImagePath}");
        }
        
        // Read the original image (source)
        $imageContent = Storage::disk($disk)->get($originalImagePath);
        $image = $this->manager->read($imageContent);
        
        \Log::info("resizeMainImageInPlace: Original image loaded, dimensions: " . $image->width() . "x" . $image->height());
        
        // Resize the image to exact dimensions
        $resizedImage = clone $image;
        $resizedImage->resize($targetWidth, $targetHeight);
        
        // Encode the resized image
        $encoded = $resizedImage->encode();
        
        // Overwrite the main image file with the resized version
        Storage::disk($disk)->put($mainImagePath, (string) $encoded);
        
        \Log::info("resizeMainImageInPlace SUCCESS: Resized to {$targetWidth}x{$targetHeight} and saved to {$mainImagePath}");
        
        return $mainImagePath;
    }
}

