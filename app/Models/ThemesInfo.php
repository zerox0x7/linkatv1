<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemesInfo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'themes_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'screenshot_image',
        'links',
        'images',
        'version',
        'author',
        'features',
        'category',
        'tags',
        'status',
        'is_featured',
        'is_premium',
        'downloads_count',
        'views_count',
        'rating',
        'reviews_count',
        'release_date',
        'last_updated',
        'requirements',
        'installation_notes',
        'custom_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'links' => 'array',
        'images' => 'array',
        'tags' => 'array',
        'custom_data' => 'array',
        'is_featured' => 'boolean',
        'is_premium' => 'boolean',
        'price' => 'decimal:2',
        'rating' => 'float',
        'release_date' => 'date',
        'last_updated' => 'date',
    ];

    /**
     * Get theme info by slug
     *
     * @param string $slug
     * @return self|null
     */
    public static function getBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * Get theme info by name
     *
     * @param string $name
     * @return self|null
     */
    public static function getByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * Get image size for a specific order position
     *
     * @param int $order
     * @return string|null The size string (e.g., "400x300") or null if not found
     */
    public function getImageSizeForOrder($order)
    {
        if (!$this->images || !is_array($this->images)) {
            return null;
        }

        foreach ($this->images as $image) {
            if (isset($image['order']) && $image['order'] == $order) {
                return $image['size'] ?? null;
            }
        }

        return null;
    }

    /**
     * Get all image sizes mapped by order
     *
     * @return array Array with order as key and size as value
     */
    public function getAllImageSizes()
    {
        $sizes = [];
        
        if ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                if (isset($image['order']) && isset($image['size'])) {
                    $sizes[$image['order']] = $image['size'];
                }
            }
        }

        return $sizes;
    }
}
