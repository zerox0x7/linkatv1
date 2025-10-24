@extends('layouts.app')

@section('title', 'متجر حسابات الألعاب والسوشيال ميديا')

@section('content')
    <!-- Hero Section -->
    <div class="container mx-auto px-4 mt-6">
        <div class="relative rounded-lg overflow-hidden h-[400px]" 
            style="background-image: url('https://readdy.ai/api/search-image?query=dark%20gaming%20setup%20with%20blue%20and%20purple%20neon%20lights%2C%20gaming%20controllers%2C%20high-end%20gaming%20PC%20with%20RGB%20lighting%2C%20multiple%20monitors%20showing%20popular%20games%2C%20dark%20atmosphere%20with%20glowing%20elements%2C%20detailed%20and%20realistic&width=1200&height=400&seq=1&orientation=landscape'); 
            background-size: cover; background-position: center;">
            <div class="absolute inset-0 hero-gradient"></div>
            <div class="absolute inset-0 flex items-center">
                <div class="container mx-auto px-8 md:px-12">
                    <div class="max-w-xl">
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">أفضل حسابات الألعاب والسوشيال ميديا</h1>
                        <p class="text-lg text-gray-200 mb-6">احصل على حسابات متميزة بأسعار تنافسية وضمان الجودة. تسوق الآن واستمتع بتجربة شراء آمنة وسريعة.</p>
                        <div class="flex space-x-4 space-x-reverse">
                            <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                                تصفح الحسابات
                            </a>
                            <a href="{{ route('products.featured') }}" class="bg-[#1e1e1e] bg-opacity-80 text-white border border-gray-600 px-6 py-3 rounded-button font-medium whitespace-nowrap hover:bg-opacity-100 transition-all">
                                عروض خاصة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 space-x-reverse">
                <span class="w-3 h-3 rounded-full bg-primary"></span>
                <span class="w-3 h-3 rounded-full bg-white bg-opacity-50"></span>
                <span class="w-3 h-3 rounded-full bg-white bg-opacity-50"></span>
                <span class="w-3 h-3 rounded-full bg-white bg-opacity-50"></span>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="container mx-auto px-4 mt-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">تصفح حسب الفئات</h2>
            <a href="{{ route('products.index') }}" class="text-primary hover:underline">عرض الكل</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="glass-effect rounded-lg overflow-hidden transition-all duration-300 card-hover">
                    <div class="h-32 bg-gradient-to-b from-[#1e1e1e] to-[#121212]" 
                        @if($category->image) style="background-image: url('{{ asset('storage/' . $category->image) }}'); background-size: cover; background-position: center;" @endif>
                    </div>
                    <div class="p-3 text-center">
                        <h3 class="text-lg font-bold text-white">{{ $category->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="container mx-auto px-4 mt-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">حسابات الألعاب المميزة</h2>
            <a href="{{ route('products.featured') }}" class="text-primary hover:underline">عرض الكل</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($featuredProducts as $product)
                <div class="glass-effect rounded-lg overflow-hidden transition-all duration-300 card-hover">
                    <div class="relative">
                        <div class="h-48 bg-gradient-to-b from-[#1e1e1e] to-[#121212]" 
                            @if($product->main_image) style="background-image: url('{{ asset('storage/' . $product->main_image) }}'); background-size: cover; background-position: center;" @endif>
                        </div>
                        @if($product->is_featured)
                            <div class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded-full">
                                مميز
                            </div>
                        @endif
                        @if($product->old_price && $product->old_price > $product->price)
                            <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                خصم {{ number_format((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-bold text-white">{{ $product->name }}</h3>
                            @if($product->rating)
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->rating))
                                            <i class="ri-star-fill"></i>
                                        @elseif($i - 0.5 <= $product->rating)
                                            <i class="ri-star-half-fill"></i>
                                        @else
                                            <i class="ri-star-line"></i>
                                        @endif
                                    @endfor
                                    <span class="text-gray-400 mr-1">{{ $product->rating }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="space-y-2 mb-4">
                            @if($product->features)
                                @foreach(json_decode($product->features) as $key => $feature)
                                    @if($loop->index < 3)
                                        <div class="flex items-center text-sm text-gray-300">
                                            <i class="ri-{{ $key == 'level' ? 'gamepad' : ($key == 'items' ? 't-shirt' : 'shield-check') }}-line ml-1"></i>
                                            <span>{{ $feature }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="flex items-center text-sm text-gray-300">
                                <i class="ri-shield-check-line ml-1"></i>
                                <span>ضمان لمدة {{ $product->warranty_days ?? 30 }} يوم</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-auto">
                            <div>
                                <span class="text-primary font-bold text-xl">{{ $product->price }} ر.س</span>
                                @if($product->old_price && $product->old_price > $product->price)
                                    <span class="text-gray-400 line-through text-sm mr-2">{{ $product->old_price }} ر.س</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-button text-sm font-medium whitespace-nowrap hover:opacity-90 transition-all">
                                شراء الآن
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Digital Cards Section -->
    @if($featuredCards->count() > 0)
        <div class="container mx-auto px-4 mt-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">بطاقات رقمية مميزة</h2>
                <a href="{{ route('digital-cards.index') }}" class="text-primary hover:underline">عرض الكل</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($featuredCards as $card)
                    <div class="glass-effect rounded-lg overflow-hidden transition-all duration-300 card-hover">
                        <div class="relative">
                            <div class="h-48 bg-gradient-to-b from-[#1e1e1e] to-[#121212]" 
                                @if($card->image) style="background-image: url('{{ asset('storage/' . $card->image) }}'); background-size: cover; background-position: center;" @endif>
                            </div>
                            @if($card->is_featured)
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded-full">
                                    مميز
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-bold text-white">{{ $card->name }}</h3>
                                <div class="text-white text-sm bg-secondary py-1 px-2 rounded-full">
                                    {{ $card->value }} {{ $card->currency }}
                                </div>
                            </div>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="ri-global-line ml-1"></i>
                                    <span>
                                        @if($card->regions)
                                            {{ implode(', ', json_decode($card->regions)) }}
                                        @else
                                            متاح عالمياً
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="ri-stack-line ml-1"></i>
                                    <span>المتوفر: {{ $card->stock_quantity }} بطاقة</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-auto">
                                <div class="text-primary font-bold text-xl">{{ $card->price }} ر.س</div>
                                <a href="{{ route('digital-cards.show', $card->slug) }}" class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-button text-sm font-medium whitespace-nowrap hover:opacity-90 transition-all">
                                    شراء الآن
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Best Sellers Section -->
    <div class="container mx-auto px-4 mt-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">الأكثر مبيعاً</h2>
            <a href="{{ route('products.best-sellers') }}" class="text-primary hover:underline">عرض الكل</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($bestSellers as $product)
                <div class="glass-effect rounded-lg overflow-hidden transition-all duration-300 card-hover">
                    <div class="relative">
                        <div class="h-48 bg-gradient-to-b from-[#1e1e1e] to-[#121212]" 
                            @if($product->main_image) style="background-image: url('{{ asset('storage/' . $product->main_image) }}'); background-size: cover; background-position: center;" @endif>
                        </div>
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            رائج
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-bold text-white">{{ $product->name }}</h3>
                            @if($product->rating)
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->rating))
                                            <i class="ri-star-fill"></i>
                                        @elseif($i - 0.5 <= $product->rating)
                                            <i class="ri-star-half-fill"></i>
                                        @else
                                            <i class="ri-star-line"></i>
                                        @endif
                                    @endfor
                                    <span class="text-gray-400 mr-1">{{ $product->rating }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="space-y-2 mb-4">
                            @if($product->features)
                                @foreach(json_decode($product->features) as $key => $feature)
                                    @if($loop->index < 3)
                                        <div class="flex items-center text-sm text-gray-300">
                                            <i class="ri-{{ $key == 'level' ? 'gamepad' : ($key == 'items' ? 't-shirt' : 'shield-check') }}-line ml-1"></i>
                                            <span>{{ $feature }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="flex items-center text-sm text-gray-300">
                                <i class="ri-shield-check-line ml-1"></i>
                                <span>ضمان لمدة {{ $product->warranty_days ?? 30 }} يوم</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-auto">
                            <div>
                                <span class="text-primary font-bold text-xl">{{ $product->price }} ر.س</span>
                                @if($product->old_price && $product->old_price > $product->price)
                                    <span class="text-gray-400 line-through text-sm mr-2">{{ $product->old_price }} ر.س</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-button text-sm font-medium whitespace-nowrap hover:opacity-90 transition-all">
                                شراء الآن
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="container mx-auto px-4 mt-16">
        <h2 class="text-2xl font-bold text-white text-center mb-8">لماذا تختارنا؟</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-effect rounded-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-shield-check-line text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">ضمان 100%</h3>
                <p class="text-gray-400">نقدم ضمان كامل على جميع الحسابات المباعة لفترة تصل إلى 30 يوماً</p>
            </div>
            <div class="glass-effect rounded-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-secure-payment-line text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">دفع آمن</h3>
                <p class="text-gray-400">طرق دفع متعددة وآمنة تضمن حماية معلوماتك المالية والشخصية</p>
            </div>
            <div class="glass-effect rounded-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-customer-service-2-line text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">دعم متواصل</h3>
                <p class="text-gray-400">فريق دعم متاح على مدار الساعة للإجابة على استفساراتك ومساعدتك في أي وقت</p>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="container mx-auto px-4 mt-16">
        <h2 class="text-2xl font-bold text-white text-center mb-8">آراء العملاء</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-effect rounded-lg p-6">
                <div class="flex text-yellow-400 mb-4">
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                </div>
                <p class="text-gray-300 mb-4">"تعاملت مع المتجر أكثر من مرة وفي كل مرة تكون الخدمة ممتازة والمنتجات ذات جودة عالية. أنصح به بشدة."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full mr-3"></div>
                    <div>
                        <h4 class="text-white font-bold">أحمد محمد</h4>
                        <span class="text-gray-400 text-sm">عميل منذ 2023</span>
                    </div>
                </div>
            </div>
            <div class="glass-effect rounded-lg p-6">
                <div class="flex text-yellow-400 mb-4">
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-half-fill"></i>
                </div>
                <p class="text-gray-300 mb-4">"اشتريت حساب ببجي من المتجر وكان يحتوي على كل ما تم وصفه. الدعم الفني سريع والتواصل سهل. تجربة شراء ممتازة."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full mr-3"></div>
                    <div>
                        <h4 class="text-white font-bold">سارة خالد</h4>
                        <span class="text-gray-400 text-sm">عميلة منذ 2022</span>
                    </div>
                </div>
            </div>
            <div class="glass-effect rounded-lg p-6">
                <div class="flex text-yellow-400 mb-4">
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-line"></i>
                </div>
                <p class="text-gray-300 mb-4">"موقع موثوق وخدمة عملاء ممتازة. اشتريت عدة حسابات وكلها بمواصفات عالية. سعيد جداً بالتعامل معهم وأنصح الجميع بالتجربة."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full mr-3"></div>
                    <div>
                        <h4 class="text-white font-bold">محمد عبدالله</h4>
                        <span class="text-gray-400 text-sm">عميل منذ 2023</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="container mx-auto px-4 mt-16">
        <div class="glass-effect rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-4">انضم لقائمتنا البريدية</h2>
            <p class="text-gray-300 mb-6 max-w-2xl mx-auto">احصل على آخر العروض والتحديثات مباشرة إلى بريدك الإلكتروني. اشترك الآن للحصول على خصم 10% على أول عملية شراء.</p>
            <form class="flex max-w-md mx-auto">
                <input type="email" placeholder="البريد الإلكتروني" class="flex-1 bg-[#1e1e1e] border border-[#3a3a3a] rounded-r-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary">
                <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-l-lg font-medium whitespace-nowrap hover:opacity-90 transition-all">
                    اشتراك
                </button>
            </form>
        </div>
    </div>
@endsection 