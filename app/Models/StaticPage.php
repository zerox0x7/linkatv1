<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع المتجر (المستخدم)
     */
    public function store()
    {
        return $this->belongsTo(User::class, 'store_id');
    }
}
