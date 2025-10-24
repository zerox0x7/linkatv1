<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeLink extends Model
{
    use HasFactory;

    protected $table = 'theme_links';

    protected $fillable = [
        'name',
        'links',
        'is_active',
        'description',
    ];

    protected $casts = [
        'links' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active themes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the first active theme
     */
    public static function getActiveTheme()
    {
        return self::active()->first();
    }

    /**
     * Get all active theme links
     */
    public static function getActiveThemeLinks()
    {
        $activeTheme = self::getActiveTheme();
        return $activeTheme ? $activeTheme->links : [];
    }
} 