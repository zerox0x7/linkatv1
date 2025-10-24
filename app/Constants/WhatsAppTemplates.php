<?php

namespace App\Constants;

/**
 * نظام قوالب الواتساب
 * 
 * هذا النظام يتيح إدارة قوالب الواتساب المستخدمة في إشعارات الطلبات
 * ويوفر طريقة موحدة للتعامل مع حالات الطلبات المختلفة
 * 
 * كيفية الاستخدام:
 * 1. تحديد حالة الطلب باستخدام الثوابت المحددة (مثال: STATUS_COMPLETED)
 * 2. الحصول على المعلمات المطلوبة للحالة باستخدام getRequiredParamsForStatus
 * 3. تجهيز البيانات المطلوبة للقالب
 * 4. استخدام WhatsAppTemplate لتحضير وإرسال الرسالة
 * 
 * مثال:
 * ```php
 * // تحديد حالة الطلب
 * $status = WhatsAppTemplates::STATUS_COMPLETED;
 * 
 * // الحصول على المعلمات المطلوبة
 * $requiredParams = WhatsAppTemplates::getRequiredParamsForStatus($status);
 * 
 * // تجهيز البيانات
 * $params = [
 *     'customer_name' => 'أحمد',
 *     'order_number' => '12345',
 *     'status' => WhatsAppTemplates::getStatusText($status),
 *     'order_details' => '...',
 *     'total_amount' => '100 ريال',
 *     'payment_status' => 'مدفوع',
 *     'payment_date' => '2024-03-20',
 *     'digital_codes' => 'CODE123',
 *     'order_url' => 'https://...'
 * ];
 * 
 * // إرسال الإشعار
 * $template = WhatsAppTemplate::where('name', WhatsAppTemplates::ORDER_STATUS)->first();
 * $message = $template->prepareContent($params);
 * ```
 */
class WhatsAppTemplates
{
    // أنواع القوالب
    const TYPE_ORDER = 'order';

    // أسماء القوالب
    const ORDER_STATUS = 'order_status';
    const ORDER_COMPLETION = 'order_completion';
    const OTP = 'otp';
    const ORDER_PENDING    = 'order_pending';
    const ORDER_PROCESSING = 'order_processing';
    const ORDER_COMPLETED  = 'order_completed';
    const ORDER_CANCELLED  = 'order_cancelled';
    const ORDER_REFUNDED   = 'order_refunded';
    const ADMIN_NOTIFICATION = 'admin_notification';

    // حالات الطلب
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_PAYMENT_FAILED = 'payment_failed';
    const STATUS_PENDING_CONFIRMATION = 'pending_confirmation';
    const STATUS_DELIVERED = 'delivered';

    // المعلمات المطلوبة لكل حالة
    const STATUS_PARAMS = [
        self::STATUS_PENDING => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'payment_status',
            'order_url'
        ],
        self::STATUS_PROCESSING => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'payment_status',
            'order_url'
        ],
        self::STATUS_COMPLETED => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'payment_status',
            'payment_date',
            'digital_codes',
            'digital_accounts',
            'order_url'
        ],
        self::STATUS_CANCELLED => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'cancellation_reason',
            'order_url'
        ],
        self::STATUS_PAYMENT_FAILED => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'payment_error',
            'order_url'
        ],
        self::STATUS_PENDING_CONFIRMATION => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'payment_method',
            'order_url'
        ],
        self::STATUS_DELIVERED => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'delivery_date',
            'tracking_number',
            'order_url'
        ]
    ];

    // المعلمات لكل قالب
    const TEMPLATE_PARAMS = [
        self::ORDER_PENDING => [
            'customer_name', 'order_number', 'status', 'order_details', 'order_url'
        ],
        self::ORDER_PROCESSING => [
            'customer_name', 'order_number', 'status', 'order_details', 'order_url'
        ],
        self::ORDER_COMPLETED => [
            'customer_name', 'order_number', 'status', 'order_details', 'total_amount', 'payment_status', 'payment_date', 'digital_codes', 'digital_accounts', 'delivery_date', 'tracking_number', 'order_url'
        ],
        self::ORDER_CANCELLED => [
            'customer_name', 'order_number', 'status', 'order_details', 'cancellation_reason', 'order_url'
        ],
        self::ORDER_REFUNDED => [
            'customer_name', 'order_number', 'status', 'order_details', 'total_amount', 'order_url'
        ],
        self::ORDER_STATUS => [
            'customer_name',
            'order_number',
            'status',
            'order_details',
            'total_amount',
            'payment_status',
            'payment_date',
            'digital_codes',
            'digital_accounts',
            'cancellation_reason',
            'payment_error',
            'payment_method',
            'delivery_date',
            'tracking_number',
            'order_url'
        ],
        self::ORDER_COMPLETION => [
            'customer_name',
            'order_number',
            'order_details',
            'total_amount',
            'payment_status',
            'payment_date',
            'digital_accounts',
            'order_url'
        ],
        self::OTP => [
            'otp',
            'app_name'
        ],
        self::ADMIN_NOTIFICATION => [
            'order_number',
            'customer_name',
            'status',
            'order_details',
            'total_amount',
            'payment_status',
            'payment_date',
            'digital_codes',
            'digital_accounts',
            'cancellation_reason',
            'payment_error',
            'payment_method',
            'delivery_date',
            'tracking_number',
            'order_url'
        ],
    ];

    // محتوى القوالب الافتراضي
    const TEMPLATE_CONTENT = [
        self::ORDER_STATUS => "مرحبًا {{customer_name}}،\n\nنود إعلامك بتحديث حالة طلبك:\n\nرقم الطلب: #{{order_number}}\nالحالة الجديدة: {{status}}\n\nتفاصيل الطلب:\n{{order_details}}\n\nالمبلغ الإجمالي: {{total_amount}}\n\n{{#if payment_status}}حالة الدفع: {{payment_status}}\n{{/if}}\n{{#if payment_date}}تاريخ الدفع: {{payment_date}}\n{{/if}}\n{{#if payment_method}}طريقة الدفع: {{payment_method}}\n{{/if}}\n{{#if payment_error}}سبب فشل الدفع: {{payment_error}}\n{{/if}}\n{{#if cancellation_reason}}سبب الإلغاء: {{cancellation_reason}}\n{{/if}}\n{{#if delivery_date}}تاريخ التسليم: {{delivery_date}}\n{{/if}}\n{{#if tracking_number}}رقم التتبع: {{tracking_number}}\n{{/if}}\n{{#if digital_codes}}الأكواد الرقمية الخاصة بك:\n{{digital_codes}}\n{{/if}}\n{{#if digital_accounts}}الحسابات الرقمية الخاصة بك:\n{{digital_accounts}}\n{{/if}}\n\nيمكنك متابعة تفاصيل طلبك من خلال الرابط:\n{{order_url}}\n\nشكرًا لاختيارك متجرنا!",
        
        self::ORDER_COMPLETION => "مرحبًا {{customer_name}}،\n\nنشكرك على إتمام طلبك!\n\nرقم الطلب: #{{order_number}}\n\nتفاصيل الطلب:\n{{order_details}}\n\nالمبلغ الإجمالي: {{total_amount}}\nحالة الدفع: {{payment_status}}\nتاريخ الدفع: {{payment_date}}\n\n{{#if digital_accounts}}الحسابات الرقمية الخاصة بك:\n{{digital_accounts}}\n{{/if}}\nيمكنك متابعة تفاصيل طلبك من خلال الرابط:\n{{order_url}}\n\nشكرًا لاختيارك متجرنا!"
    ];

    /**
     * الحصول على النص العربي لحالة الطلب
     *
     * @param string $status
     * @return string
     */
    public static function getStatusText(string $status): string
    {
        return match($status) {
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_PROCESSING => 'قيد المعالجة',
            self::STATUS_COMPLETED => 'مكتمل',
            self::STATUS_CANCELLED => 'ملغي',
            self::STATUS_PAYMENT_FAILED => 'فشل الدفع',
            self::STATUS_PENDING_CONFIRMATION => 'بانتظار تأكيد الدفع',
            self::STATUS_DELIVERED => 'تم التوصيل',
            default => $status
        };
    }

    /**
     * الحصول على المعلمات المطلوبة لحالة معينة
     *
     * @param string $status
     * @return array
     */
    public static function getRequiredParamsForStatus(string $status): array
    {
        return self::STATUS_PARAMS[$status] ?? [];
    }

    
} 
