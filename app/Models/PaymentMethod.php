<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    /**
     * الخصائص القابلة للتعيين الشامل
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'instructions',
        'logo',
        'config',
        'is_active',
        'sort_order',
        'mode',
    ];

    /**
     * الخصائص التي يجب معاملتها كأنواع بيانات
     *
     * @var array<string, string>
     */
    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * الخصائص التي يجب حمايتها من العرض
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'config',
    ];

    /**
     * التحقق ما إذا كانت طريقة الدفع مفعلة
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * تعيين طريقة الدفع كنشطة
     * 
     * @return bool
     */
    public function activate(): bool
    {
        $this->is_active = true;
        return $this->save();
    }

    /**
     * تعيين طريقة الدفع كغير نشطة
     * 
     * @return bool
     */
    public function deactivate(): bool
    {
        $this->is_active = false;
        return $this->save();
    }

    /**
     * الحصول على إجمالي الرسوم لمبلغ معين
     * 
     * @param float $amount
     * @return float
     */
    public function calculateFee(float $amount): float
    {
        $feePercentage = $this->config['fee_percentage'] ?? 0;
        $feeFixed = $this->config['fee_fixed'] ?? 0;
        return ($amount * $feePercentage / 100) + $feeFixed;
    }

    /**
     * الحصول على المفاتيح الخاصة بطريقة الدفع
     * 
     * @return array
     */
    public function getActiveCredentials(): array
    {
        if (!$this->config) {
            return [];
        }

        return [
            'profile_id' => $this->config['profile_id'] ?? '',
            'server_key' => $this->config['server_key'] ?? '',
        ];
    }
    
    /**
     * التحقق مما إذا كانت بوابة الدفع تدعم عملة معينة
     * 
     * @param string $currency رمز العملة
     * @return bool
     */
    public function supportsCurrency(string $currency): bool
    {
        $defaultCurrency = $this->config['default_currency'] ?? 'SAR';
        $supportedCurrencies = $this->config['supported_currencies'] ?? [];
        
        if (empty($supportedCurrencies)) {
            return $currency === $defaultCurrency;
        }
        
        return in_array($currency, $supportedCurrencies);
    }
    
    /**
     * التحقق مما إذا كان المبلغ ضمن الحدود المسموح بها
     * 
     * @param float $amount المبلغ
     * @return bool
     */
    public function isAmountWithinLimits(float $amount): bool
    {
        $minOrderAmount = $this->config['min_order_amount'] ?? null;
        $maxOrderAmount = $this->config['max_order_amount'] ?? null;
        
        if ($minOrderAmount !== null && $amount < $minOrderAmount) {
            return false;
        }
        
        if ($maxOrderAmount !== null && $amount > $maxOrderAmount) {
            return false;
        }
        
        return true;
    }
    
    /**
     * إنشاء معالج بوابة الدفع (Gateway Handler)
     * 
     * @return mixed
     * @throws \Exception
     */
    public function createGateway()
    {
        // دعم المسار الفرعي لماي فاتورة وادفع باي
        if ($this->code === 'myfatoorah') {
            $gatewayClass = 'App\\PaymentGateways\\Myfatoorah\\SimpleMyFatoorahGateway';
        } elseif ($this->code === 'edfapay') {
            $gatewayClass = 'App\\PaymentGateways\\EdfaPay\\EdfaPayGateway';
        } else {
            $gatewayClass = 'App\\PaymentGateways\\' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $this->code))) . 'Gateway';
        }

        if (!class_exists($gatewayClass)) {
            throw new \Exception("بوابة الدفع غير موجودة: {$this->code}");
        }

        $settings = [];
        $credentials = $this->config ?? [];
        $mode = $this->config['mode'] ?? 'test';

        return new $gatewayClass($settings, $credentials, $mode);
    }

    /**
     * الحصول على القيمة الأصلية للـ config كما هي مخزنة في قاعدة البيانات
     * 
     * @return string|null
     */
    public function getRawCredentials(): ?string
    {
        return $this->getRawOriginal('config');
    }
}
