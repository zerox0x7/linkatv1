<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomOrderMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_order_id',
        'user_id',
        'message',
        'attachment',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function customOrder(): BelongsTo
    {
        return $this->belongsTo(CustomOrder::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
} 