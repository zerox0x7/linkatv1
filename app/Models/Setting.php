<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (is_array($key)) {
            return self::getMultiple($key, $default);
        }
        
        // محاولة استرجاع القيمة من الكاش أولاً
        $cachedValue = Cache::get('setting_' . $key);
        if ($cachedValue !== null) {
            return $cachedValue;
        }
        
        // إذا لم تكن في الكاش، قم بجلبها من قاعدة البيانات
        $setting = self::where('key', $key)->first();
        $value = $setting ? $setting->value : $default;
        
        // تخزين القيمة في الكاش
        Cache::put('setting_' . $key, $value, now()->addYear());
        
        return $value;
    }

    /**
     * Get multiple settings by keys
     *
     * @param array $keys
     * @param mixed $default
     * @return array
     */
    public static function getMultiple(array $keys, $default = null)
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = self::get($key, $default);
        }
        return $values;
    }

    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set($key, $value)
    {
        if (is_array($key)) {
            return self::setMultiple($key);
        }
        
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $result = $setting->save();
        
        // مسح الكاش القديم
        Cache::forget('setting_' . $key);
        
        // تخزين القيمة الجديدة في الكاش
        Cache::put('setting_' . $key, $value, now()->addYear());
        
        return $result;
    }

    /**
     * Set multiple settings
     *
     * @param array $settings
     * @return bool
     */
    public static function setMultiple(array $settings)
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value);
        }
        return true;
    }

    /**
     * Get all settings as key-value pairs
     *
     * @return array
     */
    public static function getAllSettings()
    {
        return Cache::rememberForever('all_settings', function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear settings cache
     *
     * @return void
     */
    public static function clearCache()
    {
        Cache::forget('all_settings');
        
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget('setting_' . $setting->key);
        }
    }

    /**
     * Boot the model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saved(function () {
            self::clearCache();
        });
        
        static::deleted(function () {
            self::clearCache();
        });
    }
} 