<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'visitable_id',
        'visitable_type',
        'user_id',
        'ip',
        'user_agent',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that made the visit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owning visitable model.
     */
    public function visitable()
    {
        return $this->morphTo();
    }
    
    /**
     * Log a visit to a model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param int|null $userId
     * @return \App\Models\Visit
     */
    public static function log($model, $userId = null)
    {
        return static::create([
            'visitable_id' => $model->id,
            'visitable_type' => get_class($model),
            'user_id' => $userId ?: (auth()->check() ? auth()->id() : null),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
} 