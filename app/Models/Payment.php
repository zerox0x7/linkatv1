<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'payment_id',
        'payer_id',
        'payer_email',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
        'payment_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_data' => 'array',
    ];

    /**
     * Get the order that owns the payment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if payment is completed
     * 
     * @return bool
     */
    public function isCompleted()
    {
        return $this->payment_status === 'completed';
    }

    /**
     * Check if payment is pending
     * 
     * @return bool
     */
    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if payment is failed
     * 
     * @return bool
     */
    public function isFailed()
    {
        return $this->payment_status === 'failed';
    }

    /**
     * Mark payment as completed
     * 
     * @return bool
     */
    public function markAsCompleted()
    {
        $this->payment_status = 'completed';
        return $this->save();
    }

    /**
     * Mark payment as failed
     * 
     * @return bool
     */
    public function markAsFailed()
    {
        $this->payment_status = 'failed';
        return $this->save();
    }
} 