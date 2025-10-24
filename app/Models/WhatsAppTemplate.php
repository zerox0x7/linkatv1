<?php

namespace App\Models;

use App\Constants\WhatsAppTemplates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppTemplate extends Model
{
    use HasFactory;

    /**
     * اسم الجدول المرتبط بالنموذج
     *
     * @var string
     */
    protected $table = 'whatsapp_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'content',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * الحصول على سجلات استخدام هذا القالب.
     */
    public function logs()
    {
        return $this->hasMany(WhatsAppLog::class, 'template_id');
    }

    /**
     * التحقق من صحة المعلمات المقدمة للقالب
     *
     * @param array $params
     * @return bool
     */
    public function validateParams(array $params): bool
    {
        if (!isset(WhatsAppTemplates::TEMPLATE_PARAMS[$this->name])) {
            return false;
        }

        $requiredParams = WhatsAppTemplates::TEMPLATE_PARAMS[$this->name];
        return empty(array_diff($requiredParams, array_keys($params)));
    }

    /**
     * تحضير محتوى الرسالة مع المعاملات
     *
     * @param array $params
     * @return string
     */
    public function prepareContent(array $params = []): string
    {
        if (!$this->validateParams($params)) {
            throw new \InvalidArgumentException('Invalid template parameters');
        }

        $content = $this->content;
        
        foreach ($params as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        
        return $content;
    }

    /**
     * Get readable template type name
     *
     * @return string
     */
    public function getTypeNameAttribute()
    {
        return config('whatsapp.template_types.' . $this->type, $this->type);
    }

    /**
     * الحصول على المعلمات المطلوبة للقالب
     *
     * @return array
     */
    public function getRequiredParamsAttribute()
    {
        return WhatsAppTemplates::TEMPLATE_PARAMS[$this->name] ?? [];
    }
} 