<footer class="bg-[#0f172a] py-8 mt-12">
        <style>
            .footer-logo-container {
                display: inline-flex;
                align-items: center;
                justify-content: flex-start;
            }
            
            .footer-logo-container img {
                object-fit: contain;
                width: auto;
                height: auto;
                max-width: 120px;
                max-height: 60px;
            }
            
            @media (max-width: 640px) {
                .footer-logo-container img {
                    max-width: 100px !important;
                    max-height: 50px !important;
                }
            }
        </style>
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="font-['Pacifico'] text-2xl text-white mb-4 footer-logo-container">
                        <img src="{{ asset('storage/'.$homePage->store_logo) }}" alt="logo">
                    </div>
                    <p class="text-gray-400 text-sm mb-4">   
                        {{$homePage->footer_description}}
                    </p>
                    @if(($homePage->footer_social_media_enabled ?? true) && isset($homePage->footer_social_media) && is_array($homePage->footer_social_media))
                    <div class="flex space-x-4 flex-row-reverse">
                        @foreach($homePage->footer_social_media as $social)
                            @if(is_array($social) && isset($social['url']) && isset($social['icon']))
                                <a href="{{ $social['url'] }}" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700">
                                    <i class="{{ $social['icon'] }}"></i>
                                </a>
                            @elseif(is_string($social))
                                <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700">
                                    <i class="{{ $social }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">روابط سريعة</h4>
                    <ul class="space-y-2">
                        @if(isset($homePage->footer_quick_links) && is_array($homePage->footer_quick_links))
                            @foreach($homePage->footer_quick_links as $link)
                                <li><a href="{{ $link['url'] ?? '#' }}" class="text-gray-400 hover:text-primary">{{ $link['title'] ?? $link['name'] ?? 'رابط' }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                @if($homePage->footer_categories_enabled ?? false)
                <div>
                    <h4 class="text-white font-semibold mb-4">التصنيفات</h4>
                    <ul class="space-y-2">
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories->take(5) as $category)
                                <li><a href="{{$category->slug }}" class="text-gray-400 hover:text-primary">{{ $category->name }}</a></li>
                            @endforeach
                        @else
                            <li><a href="#" class="text-gray-400 hover:text-primary">لا توجد تصنيفات متاحة</a></li>
                        @endif
                    </ul>
                </div>
                @endif
                <div>
                    <h4 class="text-white font-semibold mb-4">اشترك في النشرة الإخبارية</h4>
                    <p class="text-gray-400 text-sm mb-4">احصل على آخر الأخبار والعروض الحصرية</p>
                    <div class="flex">
                        <input type="email" placeholder="البريد الإلكتروني" class="bg-gray-800 border-none rounded-r-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary flex-grow">
                        <button class="bg-primary hover:bg-blue-500 text-white rounded-l-full px-4 py-2 text-sm whitespace-nowrap">اشتراك</button>
                    </div>
                    <div class="flex items-center mt-4 space-x-4 flex-row-reverse">
                        @if(($homePage->footer_payment_methods_enabled ?? false) && isset($homePage->footer_payment_methods) && is_array($homePage->footer_payment_methods))
                        <div class="flex items-center space-x-2 flex-row-reverse">
                            @foreach($homePage->footer_payment_methods as $paymentIcon)
                                <i class="{{ $paymentIcon }} text-2xl text-gray-400"></i>
                            @endforeach
                        </div>
                        <div class="text-gray-400 text-xs">طرق الدفع الآمنة</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">{{ $homePage->footer_copyright ?? '© 2025 GamerPro. جميع الحقوق محفوظة.' }}</div>
                <div class="flex space-x-6 flex-row-reverse">
                </div>
            </div>
        </div>
    </footer>