<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineUser extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'page_url',
        'user_journey',
        'user_type',
        'user_id',
        'last_activity'
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'user_journey' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('last_activity', '>=', now()->subMinutes(2));
    }

    public function scopeGuests($query)
    {
        return $query->where('user_type', 'guest');
    }

    public function scopeRegistered($query)
    {
        return $query->where('user_type', 'user');
    }

    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }

    public function getPageTitleAttribute()
    {
        $url = parse_url($this->page_url);
        $path = $url['path'] ?? '';
        
        // تحويل المسار إلى عنوان مقروء
        $path = str_replace('/', ' > ', trim($path, '/'));
        $path = str_replace('-', ' ', $path);
        $path = ucwords($path);
        
        return $path ?: 'الصفحة الرئيسية';
    }

    public function getJourneySummaryAttribute()
    {
        if (empty($this->user_journey)) {
            return [];
        }

        $journey = collect($this->user_journey)->map(function ($page) {
            return [
                'title' => $page['title'] ?? $this->getPageTitleFromUrl($page['url']),
                'url' => $page['url'],
                'time' => $page['time']
            ];
        });

        return $journey;
    }

    protected function getPageTitleFromUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $path = str_replace('/', ' > ', trim($path, '/'));
        $path = str_replace('-', ' ', $path);
        return ucwords($path) ?: 'الصفحة الرئيسية';
    }

    public function getPageNameAttribute()
    {
        // إذا كانت الصفحة الرئيسية
        if ($this->page_url == url('/')) {
            return 'الصفحة الرئيسية';
        }

        // إذا كانت صفحة منتج
        if (preg_match('/products\/([^\/]+)/', $this->page_url, $matches)) {
            $slug = $matches[1];
            $product = \App\Models\Product::where('slug', $slug)->first();
            if ($product) {
                return $product->name;
            }
        }

        // الافتراضي: عرض آخر جزء من المسار بشكل مقروء
        $path = parse_url($this->page_url, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));
        $last = end($segments);
        return ucwords(str_replace('-', ' ', $last));
    }
} 