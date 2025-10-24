<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDigetal extends Model
{
    use HasFactory;

    protected $table = 'account_digetal';

    protected $fillable = [
        'product_id', 'status', 'order_id', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
