<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WhatsAppLog extends Model
{
    use HasFactory;

    /**
     * اسم الجدول المرتبط بالنموذج
     *
     * @var string
     */
    protected $table = 'whatsapp_logs';

    /**
     * الحقول القابلة للتعيين الجماعي.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'phone',
        'template_id',
        'message',
        'parameters',
        'status',
        'external_id',
        'error',
        'related_type',
        'related_id',
    ];

    /**
     * تحويل الحقول.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array',
    ];

    /**
     * الحصول على المستخدم المرتبط.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الحصول على القالب المستخدم.
     */
    public function template()
    {
        return $this->belongsTo(WhatsAppTemplate::class, 'template_id');
    }

    /**
     * الحصول على السجل المرتبط (طلب، عملية دفع، إلخ).
     */
    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * للتحقق مما إذا كانت الرسالة ناجحة.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }

    /**
     * للتحقق مما إذا كانت الرسالة قيد المعالجة.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * للتحقق مما إذا كانت الرسالة فاشلة.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
} 