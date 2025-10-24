<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ThemeData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'themes_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'theme_name',
        'hero_data',
        'banner_data',
        'feature_data',
        'extra_images',
        'custom_data',
        'custom_css',
        'custom_js',
        'sections_data',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'hero_data' => 'array',
        'banner_data' => 'array',
        'feature_data' => 'array',
        'extra_images' => 'array',
        'custom_data' => 'array',
        'sections_data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the active theme data for a specific store and theme
     *
     * @param int|null $storeId
     * @param string $themeName
     * @return self|null
     */
    public static function getActiveThemeData($storeId = null, $themeName = null)
    {
        $query = self::query();

        if ($storeId) {
            $query->where('store_id', $storeId);
        } else {
            $query->whereNull('store_id');
        }

        if ($themeName) {
            $query->where('theme_name', $themeName);
        }

        return $query->where('is_active', true)->first();
    }

    /**
     * Get theme data by store and theme name
     *
     * @param int|null $storeId
     * @param string $themeName
     * @return self|null
     */
    public static function getByStoreAndTheme($storeId, $themeName)
    {
        return self::where('store_id', $storeId)
            ->where('theme_name', $themeName)
            ->first();
    }

    /**
     * Get hero image URL
     *
     * @param string|null $key
     * @return string|null
     */
    public function getHeroImage($key = 'main_image')
    {
        if (!$this->hero_data || !isset($this->hero_data[$key])) {
            return null;
        }

        return Storage::url($this->hero_data[$key]);
    }

    /**
     * Get banner image URL
     *
     * @param string|null $key
     * @return string|null
     */
    public function getBannerImage($key = 'main_image')
    {
        if (!$this->banner_data || !isset($this->banner_data[$key])) {
            return null;
        }

        return Storage::url($this->banner_data[$key]);
    }

    /**
     * Get extra image URL
     *
     * @param string $key
     * @return string|null
     */
    public function getExtraImage($key)
    {
        if (!$this->extra_images || !isset($this->extra_images[$key])) {
            return null;
        }

        return Storage::url($this->extra_images[$key]);
    }

    /**
     * Get custom data value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getCustomData($key, $default = null)
    {
        if (!$this->custom_data || !isset($this->custom_data[$key])) {
            return $default;
        }

        return $this->custom_data[$key];
    }

    /**
     * Set hero data
     *
     * @param array $data
     * @return void
     */
    public function setHeroData(array $data)
    {
        $currentData = $this->hero_data ?? [];
        $this->hero_data = array_merge($currentData, $data);
        $this->save();
    }

    /**
     * Set banner data
     *
     * @param array $data
     * @return void
     */
    public function setBannerData(array $data)
    {
        $currentData = $this->banner_data ?? [];
        $this->banner_data = array_merge($currentData, $data);
        $this->save();
    }

    /**
     * Set extra image
     *
     * @param string $key
     * @param string $path
     * @return void
     */
    public function setExtraImage($key, $path)
    {
        $currentImages = $this->extra_images ?? [];
        $currentImages[$key] = $path;
        $this->extra_images = $currentImages;
        $this->save();
    }

    /**
     * Set custom data
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setCustomData($key, $value)
    {
        $currentData = $this->custom_data ?? [];
        $currentData[$key] = $value;
        $this->custom_data = $currentData;
        $this->save();
    }
}
