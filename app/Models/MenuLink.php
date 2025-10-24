<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MenuLink extends Model
{
    protected $fillable = [
        'title',
        'url',
        'section',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active links.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to include links from a specific section.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $section
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Get the full URL for the link.
     * If it starts with http or https, return as is.
     * Otherwise, prepend the site URL.
     *
     * @return string
     */
    public function getFullUrlAttribute()
{
    $url = $this->attributes['url']; // افترض أن لديك عمود URL

    // استخدم Str::startsWith بدلاً من starts_with
    if (Str::startsWith($url, 'http')) {
        return $url;
    }

    return 'http://' . $url;
}

} 