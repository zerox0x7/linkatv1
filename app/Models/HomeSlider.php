<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_url',
        'secondary_button_text',
        'secondary_button_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * الحصول على السلايدرات النشطة مرتبة
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * الحصول على رابط الصورة
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('themes/default/images/default-slider.png');
    }
    
    /**
     * الحصول على الرابط المرتبط بالسلايدر
     */
    public function getButtonUrlAttribute()
    {
        return $this->button_url ?? '#';
    }

    /**
     * الحصول على الرابط الثانوي المرتبط بالسلايدر
     */
    public function getSecondaryButtonUrlAttribute()
    {
        return $this->secondary_button_url ?? '#';
    }
} 