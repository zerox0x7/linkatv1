<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'rating',
        'comment',
        'review',
        'order_item_id',
        'is_approved',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    /**
     * Get the user that wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviewable model (product, digital card, etc).
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the order item associated with this review.
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function approve()
    {
        $this->update(['is_approved' => true]);
        
        // Update the product or digital card average rating
        $this->updateReviewableRating();
    }

    public function updateReviewableRating()
    {
        $reviewable = $this->reviewable;
        
        if ($reviewable) {
            $averageRating = $reviewable->reviews()->approved()->avg('rating');
            $reviewable->update(['rating' => $averageRating]);
        }
    }
} 