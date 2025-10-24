<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhatsAppTemplate;
use App\Constants\WhatsAppTemplates;
use Illuminate\Support\Facades\DB;

class WhatsAppTemplatesSeeder extends Seeder
{
    /**
     * تشغيل عملية البذر.
     */
    public function run(): void
    {
        $addedTemplates = 0;
        $updatedTemplates = 0;

        // إدخال القوالب في قاعدة البيانات
        foreach (WhatsAppTemplates::TEMPLATE_CONTENT as $name => $content) {
            $template = WhatsAppTemplate::where('name', $name)->first();

            if (!$template) {
                // إنشاء قالب جديد
                WhatsAppTemplate::create([
                    'name' => $name,
                    'type' => $this->getTemplateType($name),
                    'content' => $content,
                    'is_active' => true,
                ]);
                $addedTemplates++;
                $this->command->info("تم إضافة قالب جديد: {$name}");
            } else {
                // تحديث القالب الموجود
                $template->update([
                    'content' => $content,
                    'type' => $this->getTemplateType($name),
                ]);
                $updatedTemplates++;
                $this->command->info("تم تحديث قالب: {$name}");
            }
        }
        
        $this->command->info("تم الانتهاء من البذر: تمت إضافة {$addedTemplates} قالب جديد وتحديث {$updatedTemplates} قالب موجود.");
    }

    /**
     * تحديد نوع القالب
     *
     * @param string $name
     * @return string
     */
    private function getTemplateType(string $name): string
    {
        return match($name) {
            WhatsAppTemplates::ORDER_STATUS_UPDATE => WhatsAppTemplates::TYPE_ORDER_STATUS,
            WhatsAppTemplates::PAYMENT_COMPLETE => WhatsAppTemplates::TYPE_PAYMENT,
            WhatsAppTemplates::DELIVERY_NOTIFICATION,
            WhatsAppTemplates::DIGITAL_PRODUCT_DELIVERY,
            WhatsAppTemplates::SERVICE_ACTIVATION => WhatsAppTemplates::TYPE_DELIVERY,
            default => 'other'
        };
    }
} 