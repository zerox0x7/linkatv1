<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * ThemeMediaController
 * 
 * This controller manages media assets for any theme activated by store owners.
 * It handles the zain_theme_media table which contains:
 * - Logo, banner, background, and icon management
 * - Gaming-specific assets (character images, weapon icons, platform logos)
 * - Social media assets (profile pictures, cover images, verification badges)
 * - Brand assets with usage guidelines and color extraction
 * - Image optimization, responsive versions, and lazy loading
 * - SEO metadata and structured data for images
 * 
 * Purpose: Provides centralized media management that works across all themes.
 * When store owners upload media or switch themes, this controller ensures
 * all assets are properly categorized, optimized, and available in formats
 * that any theme template can consume.
 * 
 * The controller prepares media data in multiple formats (URLs, base64, 
 * responsive sets) so theme templates can easily access optimized assets
 * without complex media processing logic.
 */
class ThemeMediaController extends Controller
{
    /**
     * Get all theme assets for a store organized by usage context
     * This is the main method theme templates use to access media assets
     * 
     * @param int $storeId
     * @return array
     */
    public function getThemeAssets($storeId)
    {
        $cacheKey = "theme_media_{$storeId}";
        
        return Cache::remember($cacheKey, 3600, function () use ($storeId) {
            $media = DB::table('zain_theme_media')
                ->where('store_id', $storeId)
                ->where('is_active', true)
                ->where('approval_status', 'approved')
                ->orderBy('usage_context')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return [
                'logos' => $this->getLogoAssets($media),
                'headers' => $this->getHeaderAssets($media),
                'heroes' => $this->getHeroAssets($media),
                'backgrounds' => $this->getBackgroundAssets($media),
                'footers' => $this->getFooterAssets($media),
                'icons' => $this->getIconAssets($media),
                'products' => $this->getProductAssets($media),
                'categories' => $this->getCategoryAssets($media),
                'gaming' => $this->getGamingAssets($media),
                'social' => $this->getSocialAssets($media),
                'brand' => $this->getBrandAssets($media),
                'custom' => $this->getCustomAssets($media),
            ];
        });
    }
    
    /**
     * Get logo assets in multiple formats and sizes
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getLogoAssets($media)
    {
        $logos = $media->where('usage_context', 'header')
                      ->where('media_type', 'logo')
                      ->keyBy('media_key');
        
        return [
            'primary' => $this->formatMediaAsset($logos->get('primary_logo')),
            'secondary' => $this->formatMediaAsset($logos->get('secondary_logo')),
            'dark_mode' => $this->formatMediaAsset($logos->get('dark_logo')),
            'light_mode' => $this->formatMediaAsset($logos->get('light_logo')),
            'mobile' => $this->formatMediaAsset($logos->get('mobile_logo')),
            'favicon' => $this->formatMediaAsset($logos->get('favicon')),
            'apple_touch_icon' => $this->formatMediaAsset($logos->get('apple_touch_icon')),
        ];
    }
    
    /**
     * Get header-specific assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getHeaderAssets($media)
    {
        return $media->where('usage_context', 'header')
                    ->map(function ($asset) {
                        return $this->formatMediaAsset($asset);
                    })
                    ->groupBy('media_type')
                    ->toArray();
    }
    
    /**
     * Get hero section assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getHeroAssets($media)
    {
        $heroes = $media->where('usage_context', 'hero');
        
        return [
            'sliders' => $heroes->where('media_type', 'slider')->map(function ($asset) {
                return $this->formatMediaAsset($asset, true); // Include responsive versions
            })->values()->toArray(),
            'backgrounds' => $heroes->where('media_type', 'background')->map(function ($asset) {
                return $this->formatMediaAsset($asset, true);
            })->values()->toArray(),
            'videos' => $heroes->where('media_type', 'video')->map(function ($asset) {
                return $this->formatVideoAsset($asset);
            })->values()->toArray(),
        ];
    }
    
    /**
     * Get background assets for sections
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getBackgroundAssets($media)
    {
        return $media->where('media_type', 'background')
                    ->map(function ($asset) {
                        return $this->formatMediaAsset($asset, true);
                    })
                    ->groupBy('usage_context')
                    ->toArray();
    }
    
    /**
     * Get gaming-specific assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getGamingAssets($media)
    {
        $gaming = $media->where('is_gaming_asset', true);
        
        return [
            'platforms' => $gaming->where('gaming_category', 'platform')->map(function ($asset) {
                return $this->formatMediaAsset($asset);
            })->keyBy('media_key')->toArray(),
            'characters' => $gaming->where('gaming_category', 'character')->map(function ($asset) {
                return $this->formatMediaAsset($asset);
            })->values()->toArray(),
            'weapons' => $gaming->where('gaming_category', 'weapon')->map(function ($asset) {
                return $this->formatMediaAsset($asset);
            })->values()->toArray(),
            'ui_elements' => $gaming->where('gaming_category', 'ui')->map(function ($asset) {
                return $this->formatMediaAsset($asset);
            })->values()->toArray(),
            'backgrounds' => $gaming->where('gaming_category', 'background')->map(function ($asset) {
                return $this->formatMediaAsset($asset, true);
            })->values()->toArray(),
        ];
    }
    
    /**
     * Get social media specific assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getSocialAssets($media)
    {
        $social = $media->where('is_social_asset', true);
        
        return [
            'profile_pictures' => $social->where('social_format', 'profile')->map(function ($asset) {
                return $this->formatMediaAsset($asset);
            })->values()->toArray(),
            'cover_images' => $social->where('social_format', 'cover')->map(function ($asset) {
                return $this->formatMediaAsset($asset, true);
            })->values()->toArray(),
            'verification_badges' => $social->where('media_key', 'like', '%verification%')->map(function ($asset) {
                return $this->formatMediaAsset($asset);
            })->values()->toArray(),
            'platform_icons' => $social->where('social_format', 'icon')->map(function ($asset) {
                return $this->formatMediaAsset($asset);
            })->keyBy('social_platform')->toArray(),
        ];
    }
    
    /**
     * Get icon assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getIconAssets($media)
    {
        return $media->where('media_type', 'icon')
                    ->map(function ($asset) {
                        return $this->formatMediaAsset($asset);
                    })
                    ->keyBy('media_key')
                    ->toArray();
    }
    
    /**
     * Get product-related assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getProductAssets($media)
    {
        return $media->where('usage_context', 'product')
                    ->map(function ($asset) {
                        return $this->formatMediaAsset($asset, true);
                    })
                    ->groupBy('media_type')
                    ->toArray();
    }
    
    /**
     * Get category-related assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getCategoryAssets($media)
    {
        return $media->where('usage_context', 'category')
                    ->map(function ($asset) {
                        return $this->formatMediaAsset($asset);
                    })
                    ->keyBy('media_key')
                    ->toArray();
    }
    
    /**
     * Get footer assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getFooterAssets($media)
    {
        return $media->where('usage_context', 'footer')
                    ->map(function ($asset) {
                        return $this->formatMediaAsset($asset);
                    })
                    ->groupBy('media_type')
                    ->toArray();
    }
    
    /**
     * Get brand-specific assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getBrandAssets($media)
    {
        return $media->where('is_brand_asset', true)
                    ->map(function ($asset) {
                        return $this->formatBrandAsset($asset);
                    })
                    ->keyBy('brand_usage')
                    ->toArray();
    }
    
    /**
     * Get custom/miscellaneous assets
     * 
     * @param \Illuminate\Support\Collection $media
     * @return array
     */
    private function getCustomAssets($media)
    {
        return $media->whereNotIn('usage_context', ['header', 'hero', 'footer', 'product', 'category'])
                    ->where('is_gaming_asset', false)
                    ->where('is_social_asset', false)
                    ->where('is_brand_asset', false)
                    ->map(function ($asset) {
                        return $this->formatMediaAsset($asset);
                    })
                    ->values()
                    ->toArray();
    }
    
    /**
     * Format a media asset for theme consumption
     * 
     * @param \stdClass|null $asset
     * @param bool $includeResponsive
     * @return array|null
     */
    private function formatMediaAsset($asset, $includeResponsive = false)
    {
        if (!$asset) {
            return null;
        }
        
        $formatted = [
            'id' => $asset->id,
            'key' => $asset->media_key,
            'name' => $asset->media_name,
            'type' => $asset->media_type,
            'file_type' => $asset->file_type,
            'url' => $asset->file_url,
            'path' => $asset->file_path,
            'mime_type' => $asset->mime_type,
            'file_size' => $asset->file_size,
            'dimensions' => [
                'width' => $asset->width,
                'height' => $asset->height,
                'aspect_ratio' => $asset->width && $asset->height ? ($asset->width / $asset->height) : null,
            ],
            'alt_text' => $asset->alt_text,
            'description' => $asset->description,
            'primary_color' => $asset->primary_color,
            'color_palette' => json_decode($asset->color_palette, true),
            'has_transparency' => $asset->has_transparency,
            'lazy_loading_placeholder' => $asset->lazy_loading_placeholder,
            'seo' => [
                'title' => $asset->seo_title,
                'description' => $asset->seo_description,
            ],
        ];
        
        // Add responsive versions if requested
        if ($includeResponsive && $asset->responsive_versions) {
            $formatted['responsive'] = json_decode($asset->responsive_versions, true);
        }
        
        // Add optimized versions if available
        if ($asset->webp_version_exists) {
            $formatted['webp_url'] = str_replace(pathinfo($asset->file_url, PATHINFO_EXTENSION), 'webp', $asset->file_url);
        }
        
        if ($asset->avif_version_exists) {
            $formatted['avif_url'] = str_replace(pathinfo($asset->file_url, PATHINFO_EXTENSION), 'avif', $asset->file_url);
        }
        
        // Add animation data if animated
        if ($asset->is_animated) {
            $formatted['animation'] = [
                'duration' => $asset->animation_duration,
                'auto_play' => $asset->auto_play,
                'loop' => $asset->loop_animation,
                'settings' => json_decode($asset->animation_settings, true),
            ];
        }
        
        return $formatted;
    }
    
    /**
     * Format a video asset for theme consumption
     * 
     * @param \stdClass $asset
     * @return array
     */
    private function formatVideoAsset($asset)
    {
        $formatted = $this->formatMediaAsset($asset);
        
        $formatted['video'] = [
            'duration' => $asset->video_duration,
            'codec' => $asset->video_codec,
            'resolution' => $asset->video_resolution,
            'has_audio' => $asset->has_audio,
            'poster' => $asset->video_poster,
            'auto_play' => $asset->auto_play,
            'loop' => $asset->loop_animation,
        ];
        
        return $formatted;
    }
    
    /**
     * Format a brand asset with additional brand information
     * 
     * @param \stdClass $asset
     * @return array
     */
    private function formatBrandAsset($asset)
    {
        $formatted = $this->formatMediaAsset($asset);
        
        $formatted['brand'] = [
            'usage' => $asset->brand_usage,
            'guidelines' => json_decode($asset->brand_guidelines, true),
            'color_scheme' => $asset->brand_color_scheme,
            'copyright' => $asset->copyright,
            'license' => $asset->license,
            'attribution' => $asset->attribution,
        ];
        
        return $formatted;
    }
    
    /**
     * Upload and process media asset
     * 
     * @param Request $request
     * @param int $storeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadMedia(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'media_key' => 'required|string|max:255',
            'media_name' => 'required|string|max:255',
            'media_type' => 'required|string|in:logo,banner,background,icon,slider,video',
            'usage_context' => 'required|string|in:header,hero,footer,product,category,custom',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp,mp4,webm|max:10240', // 10MB max
            'alt_text' => 'string|max:255',
            'description' => 'string',
            'is_gaming_asset' => 'boolean',
            'is_social_asset' => 'boolean',
            'is_brand_asset' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $relativePath = "stores/{$storeId}/media/{$fileName}";

            $bunny = app(\App\Services\BunnyStorage::class);
            if ($bunny->isConfigured()) {
                $uploadedUrl = $bunny->uploadUploadedFile($file, $relativePath);
                if ($uploadedUrl) {
                    $filePath = $relativePath;
                    $fileUrl = $uploadedUrl;
                } else {
                    // Fallback to local if Bunny upload fails
                    $stored = $file->storeAs("stores/{$storeId}/media", $fileName, 'public');
                    $filePath = $stored;
                    $fileUrl = Storage::url($stored);
                }
            } else {
                $stored = $file->storeAs("stores/{$storeId}/media", $fileName, 'public');
                $filePath = $stored;
                $fileUrl = Storage::url($stored);
            }
            
            // Get image dimensions if it's an image
            $dimensions = null;
            if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                $imagePath = $file->getRealPath();
                $imageInfo = getimagesize($imagePath);
                if ($imageInfo) {
                    $dimensions = ['width' => $imageInfo[0], 'height' => $imageInfo[1]];
                }
            }
            
            $mediaData = [
                'store_id' => $storeId,
                'media_key' => $request->media_key,
                'media_name' => $request->media_name,
                'media_type' => $request->media_type,
                'file_type' => $file->getClientOriginalExtension(),
                'file_path' => $filePath,
                'file_url' => $fileUrl,
                'original_filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'width' => $dimensions['width'] ?? null,
                'height' => $dimensions['height'] ?? null,
                'alt_text' => $request->alt_text,
                'description' => $request->description,
                'usage_context' => $request->usage_context,
                'is_gaming_asset' => $request->is_gaming_asset ?? false,
                'is_social_asset' => $request->is_social_asset ?? false,
                'is_brand_asset' => $request->is_brand_asset ?? false,
                'approval_status' => 'approved',
                'approved_at' => now(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Check if media with same key exists
            $existingMedia = DB::table('zain_theme_media')
                ->where('store_id', $storeId)
                ->where('media_key', $request->media_key)
                ->first();
            
            if ($existingMedia) {
                // Update existing media
                DB::table('zain_theme_media')
                    ->where('id', $existingMedia->id)
                    ->update($mediaData);
                $mediaId = $existingMedia->id;
            } else {
                // Insert new media
                $mediaId = DB::table('zain_theme_media')->insertGetId($mediaData);
            }
            
            DB::commit();
            
            // Clear cache
            Cache::forget("theme_media_{$storeId}");
            
            return response()->json([
                'message' => 'Media uploaded successfully',
                'media_id' => $mediaId,
                'media_url' => $fileUrl
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to upload media: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Delete media asset
     * 
     * @param int $storeId
     * @param int $mediaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMedia($storeId, $mediaId)
    {
        try {
            $media = DB::table('zain_theme_media')
                ->where('id', $mediaId)
                ->where('store_id', $storeId)
                ->first();
            
            if (!$media) {
                return response()->json(['error' => 'Media not found'], 404);
            }
            
            // Delete file from storage
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            
            // Delete database record
            DB::table('zain_theme_media')->where('id', $mediaId)->delete();
            
            // Clear cache
            Cache::forget("theme_media_{$storeId}");
            
            return response()->json(['message' => 'Media deleted successfully']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete media'], 500);
        }
    }
    
    /**
     * Get media usage statistics for a store
     * Useful for dashboard analytics
     * 
     * @param int $storeId
     * @return array
     */
    public function getMediaStatistics($storeId)
    {
        $stats = DB::table('zain_theme_media')
            ->where('store_id', $storeId)
            ->selectRaw('
                COUNT(*) as total_assets,
                SUM(file_size) as total_size,
                COUNT(CASE WHEN is_gaming_asset = 1 THEN 1 END) as gaming_assets,
                COUNT(CASE WHEN is_social_asset = 1 THEN 1 END) as social_assets,
                COUNT(CASE WHEN is_brand_asset = 1 THEN 1 END) as brand_assets,
                COUNT(CASE WHEN media_type = "logo" THEN 1 END) as logos,
                COUNT(CASE WHEN media_type = "background" THEN 1 END) as backgrounds,
                COUNT(CASE WHEN media_type = "icon" THEN 1 END) as icons
            ')
            ->first();
        
        return [
            'total_assets' => $stats->total_assets,
            'total_size_mb' => round($stats->total_size / (1024 * 1024), 2),
            'by_type' => [
                'gaming' => $stats->gaming_assets,
                'social' => $stats->social_assets,
                'brand' => $stats->brand_assets,
                'logos' => $stats->logos,
                'backgrounds' => $stats->backgrounds,
                'icons' => $stats->icons,
            ]
        ];
    }
} 