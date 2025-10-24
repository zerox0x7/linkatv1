<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomePage;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomePage::create([
            'store_name' => 'متجر الإلكترونيات الحديثة',
            'store_description' => 'متجرك الأول للإلكترونيات والأجهزة الذكية بأفضل الأسعار وأعلى جودة. نوفر منتجات أصلية مع ضمان وخدمة توصيل سريعة لجميع أنحاء المملكة.',
            'hero_enabled' => true,
            'hero_title' => 'أحدث الأجهزة الإلكترونية بأفضل الأسعار',
            'hero_subtitle' => 'اكتشف تشكيلة واسعة من المنتجات الأصلية مع ضمان وخدمة توصيل سريعة',
            'hero_button1_text' => 'تسوق الآن',
            'hero_button1_link' => '/products',
            'hero_button2_text' => 'تواصل معنا',
            'hero_button2_link' => '/contact',
            'hero_background_image' => 'https://readdy.ai/api/search-image?query=modern%20electronics%20store%20with%20latest%20gadgets%20and%20smartphones%20displayed%20in%20a%20clean%20minimalist%20setting%20with%20soft%20lighting%20and%20a%20simple%20background&width=800&height=400&seq=1&orientation=landscape',
            'categories_enabled' => true,
            'categories_title' => 'تصفح حسب الفئات',
            'categories_data' => [
                ['name' => 'الهواتف الذكية', 'icon' => 'ri-smartphone-line', 'count' => 23],
                ['name' => 'أجهزة الكمبيوتر المحمولة', 'icon' => 'ri-macbook-line', 'count' => 17],
                ['name' => 'الساعات الذكية', 'icon' => 'ri-watch-line', 'count' => 9],
                ['name' => 'سماعات الرأس', 'icon' => 'ri-headphone-line', 'count' => 14],
            ],
            'featured_enabled' => true,
            'featured_title' => 'منتجاتنا المميزة',
            'featured_count' => 4,
            'featured_products' => [1, 2, 3, 4], // Product IDs
            'services_enabled' => true,
            'services_title' => 'لماذا تختارنا',
            'services_data' => [
                ['title' => 'توصيل سريع', 'description' => 'توصيل لجميع مناطق المملكة خلال 24-48 ساعة', 'icon' => 'ri-truck-line'],
                ['title' => 'ضمان أصلي', 'description' => 'جميع منتجاتنا أصلية 100% مع ضمان الوكيل', 'icon' => 'ri-shield-check-line'],
                ['title' => 'دعم فني 24/7', 'description' => 'فريق دعم فني متاح على مدار الساعة لمساعدتك', 'icon' => 'ri-customer-service-2-line'],
                ['title' => 'استرجاع مجاني', 'description' => 'استرجاع مجاني خلال 14 يوم من الشراء', 'icon' => 'ri-refund-2-line'],
            ],
            'reviews_enabled' => true,
            'reviews_title' => 'ماذا يقول عملاؤنا',
            'reviews_count' => 3,
            'reviews_data' => [
                ['name' => 'عبدالله الشمري', 'city' => 'الرياض', 'rating' => 5, 'text' => 'اشتريت آيفون 15 برو من المتجر وكانت التجربة ممتازة من البداية للنهاية. المنتج أصلي والتوصيل كان سريع جداً. سأتعامل معهم مرة أخرى بالتأكيد.'],
                ['name' => 'سارة العتيبي', 'city' => 'جدة', 'rating' => 4, 'text' => 'خدمة عملاء ممتازة وسرعة في الرد على الاستفسارات. المنتج وصل بحالة ممتازة والتغليف كان آمن جداً. أنصح بالتعامل معهم.'],
                ['name' => 'محمد القحطاني', 'city' => 'الدمام', 'rating' => 5, 'text' => 'اشتريت لابتوب ماك بوك برو وكان السعر منافس جداً مقارنة بالمتاجر الأخرى. التوصيل كان سريع والمنتج أصلي 100%. سأعود للشراء منهم مرة أخرى.'],
            ],
            'location_enabled' => true,
            'location_title' => 'تواصل معنا',
            'location_address' => 'شارع الملك فهد، حي العليا، الرياض',
            'location_phone' => '+966 55 123 4567',
            'location_email' => 'info@electronics-store.com',
            'location_hours' => 'السبت - الخميس: 10:00 ص - 10:00 م',
            'location_map_image' => 'https://public.readdy.ai/gen_page/map_placeholder_1280x720.png',
            'footer_enabled' => true,
            'footer_description' => 'متجر الإلكترونيات الحديثة هو وجهتك الأولى للحصول على أحدث الأجهزة الإلكترونية والهواتف الذكية بأفضل الأسعار وأعلى جودة. نوفر منتجات أصلية مع ضمان الوكيل وخدمة توصيل سريعة لجميع أنحاء المملكة.',
            'footer_quick_links' => [
                ['name' => 'من نحن', 'url' => '/about'],
                ['name' => 'سياسة الخصوصية', 'url' => '/privacy'],
                ['name' => 'الشروط والأحكام', 'url' => '/terms'],
                ['name' => 'اتصل بنا', 'url' => '/contact'],
            ],
            'footer_payment_methods' => [
                'ri-visa-fill',
                'ri-mastercard-fill',
                'ri-paypal-fill',
                'ri-apple-fill',
                'ri-bank-card-fill',
            ],
            'footer_social_media' => [
                ['platform' => 'instagram', 'icon' => 'ri-instagram-line', 'url' => '#'],
                ['platform' => 'twitter', 'icon' => 'ri-twitter-x-line', 'url' => '#'],
                ['platform' => 'facebook', 'icon' => 'ri-facebook-line', 'url' => '#'],
                ['platform' => 'youtube', 'icon' => 'ri-youtube-line', 'url' => '#'],
                ['platform' => 'snapchat', 'icon' => 'ri-snapchat-line', 'url' => '#'],
            ],
            'footer_copyright' => '© 2025 متجر الإلكترونيات الحديثة. جميع الحقوق محفوظة.',
            'primary_color' => '#00e5bb',
            'background_color' => '#0f172a',
            'text_color' => '#ffffff',
            'secondary_text_color' => '#94a3b8',
        ]);
    }
}
