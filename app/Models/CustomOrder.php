<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'title',
        'description',
        'budget',
        'status',
        'admin_notes',
        'deadline',
        'final_price',
        'assigned_to',
        'completed_at',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'final_price' => 'decimal:2',
        'deadline' => 'date',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CustomOrderMessage::class);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function markAsUnderReview($adminNotes = null)
    {
        $this->update([
            'status' => 'under_review',
            'admin_notes' => $adminNotes ?? $this->admin_notes,
        ]);
    }

    public function markAsInProgress($assignedUserId = null, $finalPrice = null)
    {
        $this->update([
            'status' => 'in_progress',
            'assigned_to' => $assignedUserId ?? $this->assigned_to,
            'final_price' => $finalPrice ?? $this->final_price,
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsRejected($adminNotes = null)
    {
        $this->update([
            'status' => 'rejected',
            'admin_notes' => $adminNotes ?? $this->admin_notes,
        ]);
    }
} 