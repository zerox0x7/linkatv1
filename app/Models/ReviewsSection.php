<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewsSection extends Model
{
    use HasFactory;
    
    protected $table = 'reviews_section';
    
    protected $fillable = [
        'store_id',
        'name',
        'description',
        'is_active',
        'display_count'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the store that owns the reviews section.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
