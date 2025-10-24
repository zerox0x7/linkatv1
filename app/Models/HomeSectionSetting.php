<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSectionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'description',
        'order',
        'is_active',
        'content'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'content' => 'array',
    ];

    /**
     * البحث عن قسم باستخدام المفتاح
     */
    public static function getByKey($key)
    {
        return self::where('key', $key)->first();
    }

    /**
     * الحصول على قيمة محدده من محتوى القسم
     */
    public function getContent($key = null, $default = null)
    {
        if ($key === null) {
            return $this->content ?? [];
        }
        
        return $this->content[$key] ?? $default;
    }

    /**
     * تحديث محتوى محدد مع الاحتفاظ بالمحتوى الآخر
     */
    public function updateContent($key, $value)
    {
        $content = $this->content ?? [];
        $content[$key] = $value;
        $this->content = $content;
        $this->save();
        
        return $this;
    }

    /**
     * الحصول على جميع الأقسام النشطة مرتبة حسب الترتيب
     */
    public static function getActiveSections()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}
