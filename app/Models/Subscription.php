<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'amount_paid',
        'payment_method',
        'payment_id',
        'starts_at',
        'ends_at',
        'paid_at',
        'cancelled_at',
        'metadata'
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'metadata' => 'array'
    ];

    /**
     * علاقة مع المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة مع خطة الاشتراك
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * الحصول على الاشتراكات النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('ends_at', '>', now());
    }

    /**
     * الحصول على الاشتراكات المنتهية
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'active')
                     ->where('ends_at', '<=', now());
    }

    /**
     * التحقق من أن الاشتراك نشط
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at > now();
    }

    /**
     * التحقق من أن الاشتراك منتهي
     */
    public function isExpired(): bool
    {
        return $this->status === 'active' && $this->ends_at <= now();
    }

    /**
     * الحصول على الأيام المتبقية
     */
    public function getRemainingDaysAttribute()
    {
        if (!$this->isActive()) {
            return 0;
        }
        
        return max(0, $this->ends_at->diffInDays(now()));
    }

    /**
     * تفعيل الاشتراك
     */
    public function activate()
    {
        $this->update([
            'status' => 'active',
            'paid_at' => now()
        ]);
    }

    /**
     * إلغاء الاشتراك
     */
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);
    }
}
