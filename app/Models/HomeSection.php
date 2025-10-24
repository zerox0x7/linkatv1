<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'type', 'title', 'subtitle', 'category_id', 'order', 'is_active', 'settings', 'content' , 'max_items', 'key'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * البحث عن قسم باستخدام المفتاح
     */
    public static function getByKey($key)
    {
        return self::where('key', $key)->first();
    }

    /**
     * الحصول على قيمة إعداد محدد
     */
    public function getSetting($key, $default = null)
    {
        if (!is_array($this->settings)) {
            return $default;
        }
        
        return $this->settings[$key] ?? $default;
    }

    /**
     * العلاقة مع نموذج المتجر
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * العلاقة مع نموذج التصنيف
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * الحصول على المنتجات المرتبطة بهذا القسم حسب نوعه
     */
    public function getProducts($limit = 16, $storeId)
    {
        $reviewsAvgQuery = function($query) {
            $query->where('is_approved', true);
        };
        
        switch ($this->type) {
            case 'featured':
                return Product::where('is_featured', true)->where('store_id',$storeId)
                    ->whereIn('status', ['active', 'out-of-stock'])
                    ->withAvg(['reviews' => $reviewsAvgQuery], 'rating')
                    ->latest()
                    ->limit($limit)
                    ->get();
            case 'latest':
                return Product::whereIn('status', ['active', 'out-of-stock'])
                    ->withAvg(['reviews' => $reviewsAvgQuery], 'rating')
                    ->latest()
                    ->limit($limit)
                    ->get();
            case 'best_sellers':
                return Product::whereIn('status', ['active', 'out-of-stock'])
                    ->withAvg(['reviews' => $reviewsAvgQuery], 'rating')
                    ->orderBy('sales_count', 'desc')
                    ->limit($limit)
                    ->get();
            case 'category':
                if ($this->category_id) {
                    return Product::whereIn('status', ['active', 'out-of-stock'])
                        ->where('category_id', $this->category_id)
                        ->withAvg(['reviews' => $reviewsAvgQuery], 'rating')
                        ->latest()
                        ->limit($limit)
                        ->get();
                }
                return collect();
            case 'custom_content':
                // قسم المحتوى المخصص لا يحتاج لعرض منتجات
                return collect();
            case 'custom':
                // يمكن تنفيذ منطق مخصص هنا لعرض منتجات محددة
                return collect();
            case 'all':
                return Product::whereIn('status', ['active', 'out-of-stock'])
                    ->withAvg(['reviews' => $reviewsAvgQuery], 'rating')
                    ->latest()
                    ->limit($limit)
                    ->get();
            default:
                return collect();
        }
    }
} 