<?php

namespace App\Services;

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
        
        // First, always save the original
        $paths['original'] = $this->resizeAndSave(
            $image, 
            $basePath, 
            $filename . '_original.' . $extension, 
            null, 
            $disk
        );
        
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
        
        // Set the large size as default, or original if large doesn't exist
        $paths['default'] = $paths['large'] ?? $paths['original'];
        
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
     * Convert old single-path format to responsive format
     * This is useful for migrating existing images
     * 
     * @param string $oldPath The old single image path
     * @param string $disk The storage disk (default: 'public')
     * @return array Array containing paths to all generated image sizes
     */
    public function convertToResponsive($oldPath, $disk = 'public')
    {
        if (!Storage::disk($disk)->exists($oldPath)) {
            return null;
        }
        
        // Get the file content
        $content = Storage::disk($disk)->get($oldPath);
        
        // Read the image
        $image = $this->manager->read($content);
        
        // Extract path info
        $pathInfo = pathinfo($oldPath);
        $directory = $pathInfo['dirname'];
        $filename = pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        $paths = [];
        $originalWidth = $image->width();
        
        // Create each responsive size
        foreach ($this->sizes as $sizeName => $maxWidth) {
            if ($originalWidth > $maxWidth) {
                $paths[$sizeName] = $this->resizeAndSave(
                    $image, 
                    $directory, 
                    $filename . '_' . $sizeName . '.' . $extension, 
                    $maxWidth, 
                    $disk
                );
            }
        }
        
        if (empty($paths)) {
            // Image is already small, just reference it as all sizes
            foreach (array_keys($this->sizes) as $sizeName) {
                $paths[$sizeName] = $oldPath;
            }
        }
        
        $paths['original'] = $oldPath;
        $paths['default'] = end($paths);
        
        return $paths;
    }
}

