<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'user_id',
        'order_number',
        'order_token',
        'status',
        'total',
        'sub_total',
        'tax',
        'discount',
        'payment_method',
        'payment_status',
        'payment_id',
        'coupon_code',
        'notes',
        'custom_data',
        'has_custom_products',
        'paid_at',
        'fulfilled_at',
        'cancelled_at'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'paid_at' => 'datetime',
        'fulfilled_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'custom_data' => 'array',
        'has_custom_products' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment() {
        return $this->hasOne(Payment::class);
    }
    
    public function digitalCardCodes(): HasMany
    {
        return $this->hasMany(DigitalCardCode::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function markAsPaid($paymentId = null)
    {
        $this->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'payment_id' => $paymentId
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'fulfilled_at' => now()
        ]);
    }

    public function markAsCancelled()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);
    }

    public static function generateOrderNumber()
    {
        $prefix = 'ORD-';
        $uniqueNumber = $prefix . strtoupper(uniqid());
        
        // Check if the order number already exists
        while (self::where('order_number', $uniqueNumber)->exists()) {
            $uniqueNumber = $prefix . strtoupper(uniqid());
        }
        
        return $uniqueNumber;
    }
    
    /**
     * الحصول على معرفات العميل من البيانات المخصصة
     *
     * @return array
     */
    public function getPlayerIdentifiers()
    {
        if (!$this->has_custom_products || empty($this->custom_data)) {
            return [];
        }
        
        $identifiers = [];
        
        foreach ($this->custom_data as $itemId => $data) {
            $itemInfo = [
                'product_name' => $data['name'] ?? 'منتج مخصص',
                'product_id' => $data['product_id'] ?? null,
            ];
            
            // استخراج معرفات اللاعب إذا وجدت
            if (isset($data['player_data'])) {
                $playerData = $data['player_data'];
                
                // معالجة التنسيق المحسّن مع العناوين والقيم
                $processedData = [];
                
                foreach ($playerData as $key => $field) {
                    // حقول معلومات اللاعب
                    if (is_array($field) && isset($field['value'])) {
                        // التنسيق الجديد - استخراج العنوان والقيمة
                        $displayKey = $field['label'] ?? $key;
                        
                        // تخزين القيمة النصية فقط
                        if ($key === 'price_option' && isset($field['value']['name']) && isset($field['value']['price'])) {
                            $processedData[$displayKey] = $field['value']['name'] . ' - ' . $field['value']['price'] . ' ر.س';
                        } else {
                            $processedData[$displayKey] = $field['value'];
                        }
                    } else {
                        // التنسيق القديم
                        $processedData[$key] = $field;
                    }
                }
                
                // معالجة خيارات السعر المخصصة
                if (isset($data['service_option'])) {
                    $serviceOption = $data['service_option'];
                    $optionDisplay = isset($serviceOption['name']) ? $serviceOption['name'] : '';
                    $optionPrice = isset($serviceOption['price']) ? $serviceOption['price'] . ' ر.س' : '';
                    
                    $processedData['خيار الخدمة'] = $optionDisplay . ($optionPrice ? ' - ' . $optionPrice : '');
                }
                
                $itemInfo['identifiers'] = $processedData;
                $identifiers[] = $itemInfo;
            } elseif (isset($data['data'])) {
                // للتوافق مع البيانات القديمة
                $itemInfo['identifiers'] = $data['data'];
            } else {
                $itemInfo['identifiers'] = [];
            }
            
            // إضافة معلومات الخدمة المختارة إذا وجدت
            if (isset($data['service'])) {
                $itemInfo['service'] = [
                    'name' => $data['service']['name'] ?? 'خدمة مخصصة',
                    'price' => $data['service']['price'] ?? null
                ];
            }
        }
        
        return $identifiers;
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->order_token)) {
                $order->order_token = Str::random(32);
            }
        });
    }

    /**
     * تسليم الأكواد الرقمية للطلب بعد الدفع
     */
    public function deliverDigitalCodes()
    {
        \Log::info('تشغيل deliverDigitalCodes', ['order_id' => $this->id]);
        foreach ($this->items as $item) {
            // فقط المنتجات الرقمية
            if (
                ($item->orderable_type === 'App\\Models\\Product' && $item->orderable && $item->orderable->type === 'digital_card') ||
                $item->orderable_type === 'App\\Models\\DigitalCard'
            ) {
                // تحقق إذا تم تسليم الأكواد مسبقًا لهذا المنتج فقط
                $alreadyDelivered = DB::table('digital_card_codes')
                    ->where('order_id', $this->id)
                    ->where('user_id', $this->user_id)
                    ->where('product_id', $item->orderable_id)
                    ->count();

                if ($alreadyDelivered >= $item->quantity) {
                    continue; // تم التسليم مسبقًا
                }

                // جلب الأكواد المتاحة بعدد الكمية المطلوبة
                $needed = $item->quantity - $alreadyDelivered;
                if ($needed <= 0) continue;

                $codes = DB::table('digital_card_codes')
                    ->where('product_id', $item->orderable_id)
                    ->whereNull('order_id')
                    ->where('status', 'available')
                    ->limit($needed)
                    ->get();

                if ($codes->count() < $needed) {
                    // سجل أو أرسل تنبيه بنقص الأكواد
                    Log::warning('نقص في الأكواد الرقمية للطلب رقم ' . $this->id);
                    continue;
                }

                foreach ($codes as $code) {
                    DB::table('digital_card_codes')
                        ->where('id', $code->id)
                        ->update([
                            'status' => 'used',
                            'sold_at' => now(),
                            'order_id' => $this->id,
                            'user_id' => $this->user_id,
                        ]);
                }
                // تحديث حالة المنتج إذا نفدت الأكواد الرقمية
                $productId = null;
                if ($item->orderable_type === 'App\\Models\\Product') {
                    $productId = $item->orderable_id;
                } elseif ($item->orderable_type === 'App\\Models\\DigitalCard' && $item->orderable) {
                    $productId = $item->orderable->product_id;
                }
                if ($productId) {
                    $product = \App\Models\Product::find($productId);
                    if ($product && $product->type === 'digital_card') {
                        $availableCodes = \App\Models\DigitalCardCode::where('product_id', $product->id)
                            ->where('status', 'available')
                            ->whereNull('order_id')
                            ->count();
                        // فحص وتحديث حالة المنتج الرقمي بعد التسليم
                        \Log::info('فحص حالة المنتج الرقمي بعد التسليم', [
                            'product_id' => $product->id,
                            'available_codes' => $availableCodes,
                            'current_status' => $product->status,
                        ]);
                        if ($availableCodes == 0 && $product->status !== 'out-of-stock') {
                            $product->status = 'out-of-stock';
                            $product->save();
                            \Log::info('تم تحديث المنتج إلى out-of-stock', ['product_id' => $product->id]);
                        } elseif ($availableCodes > 0 && $product->status !== 'active') {
                            $product->status = 'active';
                            $product->save();
                            \Log::info('تم تحديث المنتج إلى active', ['product_id' => $product->id]);
                        }
                    }
                }
            }
            // إضافة منطق الحسابات الرقمية
            elseif ($item->orderable_type === 'App\\Models\\Product' && $item->orderable && $item->orderable->type === 'account') {
                $product = $item->orderable;
                // حساب عدد الحسابات المتاحة
                $availableAccounts = \App\Models\AccountDigetal::where('product_id', $product->id)
                    ->where('status', 'available')
                    ->count();
                // تحديث حالة المنتج بناءً على المخزون
                if ($availableAccounts == 0 && $product->status !== 'out-of-stock') {
                    $product->status = 'out-of-stock';
                    $product->save();
                    \Log::info('تم تحديث منتج الحساب الرقمي إلى out-of-stock', ['product_id' => $product->id]);
                } elseif ($availableAccounts > 0 && $product->status !== 'active') {
                    $product->status = 'active';
                    $product->save();
                    \Log::info('تم تحديث منتج الحساب الرقمي إلى active', ['product_id' => $product->id]);
                }
            }
        }
    }
} 