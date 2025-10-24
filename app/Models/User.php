<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role',
        'is_active',
        'vip',
        'last_login_at',
        'balance',
        'orders_count',
        'custom_domain',
        'store_id',
        'client_to_store',
        'active_theme',
        // Business/Tenant Information
        'store_name',
        'business_type',
        'expected_monthly_sales',
        'website_url',
        'business_license'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'vip' => 'boolean',
        'last_login_at' => 'datetime',
        'balance' => 'decimal:2',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    /**
     * Get the is_admin attribute
     * 
     * @return bool
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    



        public function isCustomer(): bool
    {
        return $this->role === 'admin';
    }
    
    /**
     * Get the is_admin attribute
     * 
     * @return bool
     */
    public function getIsCustomerAttribute(): bool
    {
        return $this->isCustomer();
    }


    /**
     * Get the orders for the user
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the reviews for the user
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the custom orders for the user
     */
    public function customOrders(): HasMany
    {
        return $this->hasMany(CustomOrder::class);
    }

    /**
     * Get the assigned custom orders for the user
     */
    public function assignedCustomOrders(): HasMany
    {
        return $this->hasMany(CustomOrder::class, 'assigned_to');
    }

    /**
     * Get the digital card codes for the user
     */
    public function digitalCardCodes(): HasMany
    {
        return $this->hasMany(DigitalCardCode::class);
    }

    /**
     * Get the custom order messages for the user
     */
    public function customOrderMessages(): HasMany
    {
        return $this->hasMany(CustomOrderMessage::class);
    }

    /**
     * Get the cart for the user
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class)->latest();
    }

    /**
     * Get the visits for the user
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Get all of the user's notifications.
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Record the user's last login.
     */
    public function recordLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Add amount to user balance
     * 
     * @param float $amount
     * @return bool
     */
    public function addBalance($amount)
    {
        $this->balance += $amount;
        return $this->save();
    }

    /**
     * Deduct amount from user balance
     * 
     * @param float $amount
     * @return bool
     */
    public function deductBalance($amount)
    {
        if ($this->balance < $amount) {
            return false;
        }
        
        $this->balance -= $amount;
        return $this->save();
    }

    /**
     * الحصول على رابط الصورة الرمزية للمستخدم
     */
    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return asset('images/placeholder-avatar.png');
        }
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/placeholder-avatar.png');
    }

    /**
     * Get all subscriptions for the user
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the active subscription for the user
     */
    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
                    ->where('status', 'active')
                    ->where('ends_at', '>', now())
                    ->latest();
    }

    /**
     * Check if user has an active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Get the current subscription plan
     */
    public function getCurrentSubscriptionPlan()
    {
        $activeSubscription = $this->activeSubscription;
        return $activeSubscription ? $activeSubscription->subscriptionPlan : null;
    }
}
