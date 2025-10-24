<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
        'show_in_menu',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
    ];

    /**
     * الحصول على الرابط للصفحة
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('page.show', $this->slug);
    }
} 