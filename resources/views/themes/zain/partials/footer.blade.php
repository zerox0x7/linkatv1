<footer class="glass-effect py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-{{ 
            (\App\Models\Setting::get('show_footer_about', true) ? 1 : 0) + 
            (\App\Models\Setting::get('show_footer_links', true) ? 1 : 0) + 
            (\App\Models\Setting::get('show_footer_policies', true) ? 1 : 0) + 
            (\App\Models\Setting::get('show_footer_payment', true) ? 1 : 0) 
        }} gap-8">
            @if(\App\Models\Setting::get('show_footer_about', true))
            <div class="col-span-1">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full">
                        <i class="ri-shopping-cart-2-line text-white ri-lg"></i>
                    </div>
                    <span class="text-2xl font-['Pacifico'] text-white mr-2">{{ \App\Models\Setting::get('store_name', config('app.name', 'متجر الحسابات')) }}</span>
                </div>
                <p class="text-gray-400 mb-4">{{ \App\Models\Setting::get('footer_description', 'أفضل متجر لشراء حسابات الألعاب والسوشيال ميديا. نقدم خدمات آمنة وموثوقة لجميع عملائنا.') }}</p>
                <div class="flex space-x-3 space-x-reverse">
                    @if(\App\Models\Setting::get('show_facebook', true))
                    <a href="{{ \App\Models\Setting::get('social_facebook_url', '#') }}" class="w-10 h-10 rounded-full bg-[#1e1e1e] flex items-center justify-center text-gray-300 hover:text-primary hover:bg-[#2a2a2a] transition">
                        <i class="ri-facebook-fill"></i>
                    </a>
                    @endif
                    
                    @if(\App\Models\Setting::get('show_twitter', true))
                    <a href="{{ \App\Models\Setting::get('social_twitter_url', '#') }}" class="w-10 h-10 rounded-full bg-[#1e1e1e] flex items-center justify-center text-gray-300 hover:text-primary hover:bg-[#2a2a2a] transition">
                        <i class="ri-twitter-x-fill"></i>
                    </a>
                    @endif
                    
                    @if(\App\Models\Setting::get('show_instagram', true))
                    <a href="{{ \App\Models\Setting::get('social_instagram_url', '#') }}" class="w-10 h-10 rounded-full bg-[#1e1e1e] flex items-center justify-center text-gray-300 hover:text-primary hover:bg-[#2a2a2a] transition">
                        <i class="ri-instagram-line"></i>
                    </a>
                    @endif
                    
                    @if(\App\Models\Setting::get('show_whatsapp', true))
                    <a href="{{ \App\Models\Setting::get('social_whatsapp_url', '#') }}" class="w-10 h-10 rounded-full bg-[#1e1e1e] flex items-center justify-center text-gray-300 hover:text-primary hover:bg-[#2a2a2a] transition">
                        <i class="ri-whatsapp-line"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endif
            
            @if(\App\Models\Setting::get('show_footer_links', true))
            <div class="col-span-1">
                <h3 class="text-white text-lg font-bold mb-4">{{ \App\Models\Setting::get('footer_links_title', 'روابط سريعة') }}</h3>
                <ul class="space-y-3">
                    @php
                    $quickLinks = \App\Models\MenuLink::where('section', 'quick_links')
                                    ->where('is_active', true)
                                    ->orderBy('order')
                                    ->get();
                    @endphp
                    
                    @forelse($quickLinks as $link)
                        @php
                            $displayUrl = $link->url;
                            if (preg_match('/^\//', $displayUrl)) {
                                $displayUrl = url($displayUrl);
                            }
                        @endphp
                        <li>
                            <a href="{{ $displayUrl }}" class="text-gray-400 hover:text-primary transition flex items-center">
                                <i class="ri-arrow-left-line ml-1"></i> {{ $link->title }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> الرئيسية</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> حسابات الألعاب</a></li>
                        <li><a href="{{ route('products.index', ['type' => 'social']) }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> حسابات السوشيال</a></li>
                        <li><a href="{{ route('custom-orders.create') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> طلب خاص</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> تسجيل الدخول</a></li>
                    @endforelse
                </ul>
            </div>
            @endif
            
            @if(\App\Models\Setting::get('show_footer_policies', true))
            <div class="col-span-1">
                <h3 class="text-white text-lg font-bold mb-4">{{ \App\Models\Setting::get('footer_policies_title', 'السياسات') }}</h3>
                <ul class="space-y-3">
                    @php
                    $policyLinks = \App\Models\MenuLink::where('section', 'policies')
                                    ->where('is_active', true)
                                    ->orderBy('order')
                                    ->get();
                    @endphp
                    
                    @forelse($policyLinks as $link)
                        @php
                            $displayUrl = $link->url;
                            if (preg_match('/^\//', $displayUrl)) {
                                $displayUrl = url($displayUrl);
                            }
                        @endphp
                        <li>
                            <a href="{{ $displayUrl }}" class="text-gray-400 hover:text-primary transition flex items-center">
                                <i class="ri-arrow-left-line ml-1"></i> {{ $link->title }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('page.show', 'terms') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> شروط الاستخدام</a></li>
                        <li><a href="{{ route('page.show', 'privacy') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> سياسة الخصوصية</a></li>
                        <li><a href="{{ route('page.show', 'refund') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> سياسة الاسترجاع</a></li>
                        <li><a href="{{ route('page.show', 'faq') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> الأسئلة الشائعة</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-primary transition flex items-center"><i class="ri-arrow-left-line ml-1"></i> اتصل بنا</a></li>
                    @endforelse
                </ul>
            </div>
            @endif
            
            @if(\App\Models\Setting::get('show_footer_payment', true))
            <div class="col-span-1 flex flex-col items-start">
                <h3 class="text-white text-lg font-bold mb-4">{{ \App\Models\Setting::get('footer_payment_title', 'وسائل الدفع') }}</h3>
                <div class="flex flex-row flex-wrap gap-3 justify-start" dir="ltr">
                    @php
                        $paymentIcons = json_decode(\App\Models\Setting::get('footer_payment_icons', '[]'), true);
                    @endphp
                    @forelse($paymentIcons as $icon)
                        <div class="w-10 h-6 flex items-center justify-center bg-white rounded">
                            <img src="{{ asset('storage/' . $icon) }}" alt="Payment Icon" class="max-h-4">
                        </div>
                    @empty
                        <span class="text-gray-300 text-xs">لا توجد أيقونات دفع مضافة بعد.</span>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
        
        <div class="border-t border-[#2a2a2a] mt-8 pt-8 text-center">
            <p class="text-gray-400">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::get('store_name', config('app.name', 'متجر الحسابات')) }}. {{ \App\Models\Setting::get('footer_copyright', 'جميع الحقوق محفوظة.') }}
            </p>
        </div>
    </div>
</footer> 