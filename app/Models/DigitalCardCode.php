<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalCardCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'digital_card_id',
        'product_id',
        'code',
        'status',
        'expiry_date',
        'sold_at',
        'order_id',
        'user_id'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'sold_at' => 'datetime',
    ];

    public function digitalCard(): BelongsTo
    {
        return $this->belongsTo(DigitalCard::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * البطاقات المتاحة (غير المباعة)
     */
    public function scopeAvailable($query)
    {
        return $query->whereNull('user_id')->where('status', 'available');
    }

    /**
     * البطاقات المباعة
     */
    public function scopeSold($query)
    {
        return $query->whereNotNull('user_id')->where('status', 'sold');
    }

    /**
     * البطاقات المنتهية
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * البطاقات المستخدمة
     */
    public function scopeUsed($query)
    {
        return $query->where('status', 'used');
    }

    /**
     * تعليم الكود كمباع
     */
    public function markAsSold(Order $order, User $user)
    {
        $this->update([
            'status' => 'used',
            'sold_at' => now(),
            'order_id' => $order->id,
            'user_id' => $user->id
        ]);
    }

    /**
     * التحقق مما إذا كان الكود منتهي الصلاحية
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date && $this->expiry_date < now();
    }

    /**
     * التحقق مما إذا كان الكود متاح
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->status === 'available' && !$this->user_id && !$this->is_expired;
    }
} 