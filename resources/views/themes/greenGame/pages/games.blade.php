<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $homePage->store_name }}</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#57b5e7',
                    secondary: '#8dd3c7'
                },
                borderRadius: {
                    'none': '0px',
                    'sm': '4px',
                    DEFAULT: '8px',
                    'md': '12px',
                    'lg': '16px',
                    'xl': '20px',
                    '2xl': '24px',
                    '3xl': '32px',
                    'full': '9999px',
                    'button': '8px'
                }
            }
        }
    }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        background-color: #0a1525;
        color: #fff;
        font-family: 'Inter', sans-serif;
        direction: rtl;
    }

    .game-card img {
        transform: scaleX(-1);
    }

    [class*="space-x-"]:not(.flex-row-reverse)> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-1> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-2> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-4> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-6> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-8> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .glow-effect {
        box-shadow: 0 0 15px rgba(87, 181, 231, 0.3);
    }

    .card-gradient {
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
    }

    .category-card {
        transition: all 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(87, 181, 231, 0.2);
    }

    .game-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .game-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(87, 181, 231, 0.3);
    }

    .game-card:hover img {
        transform: scale(1.05);
    }

    .game-card img {
        transition: transform 0.5s ease;
    }

    .badge {
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    }

    .epic-badge {
        background: linear-gradient(90deg, #9333ea 0%, #c026d3 100%);
    }

    .rare-badge {
        background: linear-gradient(90deg, #2563eb 0%, #38bdf8 100%);
    }

    .legendary-badge {
        background: linear-gradient(90deg, #16a34a 0%, #22c55e 100%);
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
   @include('themes.greenGame.partials.header')
  
    <!-- Breadcrumb -->
    <div class="container mx-auto py-4 px-4">
        <div class="flex items-center text-sm text-gray-400">
            <a href="#" class="hover:text-primary">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="#" class="hover:text-primary">الألعاب</a>
            <span class="mx-2">/</span>
            <span class="text-primary">FIFA 2025 Ultimate Edition</span>
        </div>
    </div>
    <!-- Product Page -->
    <div class="container mx-auto px-4 pb-12">
        <div class="bg-[#111827] rounded-xl p-6 shadow-lg">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images Section -->
                <div>
                    <div class="product-image-container bg-[#0d1729] rounded-lg mb-4 overflow-hidden relative">
                        <div
                            class="absolute top-3 left-3 bg-primary text-black text-sm font-bold py-1 px-3 rounded-full z-10">
                            خصم 20%
                        </div>
                        <img src="https://readdy.ai/api/search-image?query=FIFA%202025%20Ultimate%20Edition%20video%20game%20cover%20art%2C%20high%20quality%2C%20detailed%2C%20professional%20game%20artwork%20with%20football%20player%2C%20vibrant%20colors%2C%20official%20game%20cover%20style&width=800&height=800&seq=123&orientation=squarish"
                            alt="FIFA 2025 Ultimate Edition" class="w-full h-full object-contain">
                    </div>
                    <div class="thumbnail-container flex space-x-3 space-x-reverse overflow-x-auto pb-2">
                        <div
                            class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-primary cursor-pointer">
                            <img src="https://readdy.ai/api/search-image?query=FIFA%202025%20Ultimate%20Edition%20video%20game%20cover%20art%2C%20high%20quality%2C%20detailed%2C%20professional%20game%20artwork%20with%20football%20player%2C%20vibrant%20colors%2C%20official%20game%20cover%20style&width=100&height=100&seq=123&orientation=squarish"
                                alt="Thumbnail 1" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-gray-700 cursor-pointer">
                            <img src="https://readdy.ai/api/search-image?query=FIFA%202025%20gameplay%20screenshot%2C%20football%20match%20in%20stadium%2C%20realistic%20graphics%2C%20players%20on%20field%2C%20video%20game%20screenshot&width=100&height=100&seq=124&orientation=squarish"
                                alt="Thumbnail 2" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-gray-700 cursor-pointer">
                            <img src="https://readdy.ai/api/search-image?query=FIFA%202025%20menu%20interface%2C%20game%20user%20interface%2C%20team%20selection%20screen%2C%20modern%20UI%20design%20for%20sports%20video%20game&width=100&height=100&seq=125&orientation=squarish"
                                alt="Thumbnail 3" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-gray-700 cursor-pointer">
                            <img src="https://readdy.ai/api/search-image?query=FIFA%202025%20career%20mode%20screenshot%2C%20football%20manager%20view%2C%20statistics%20and%20player%20ratings%2C%20professional%20sports%20game%20interface&width=100&height=100&seq=126&orientation=squarish"
                                alt="Thumbnail 4" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <!-- Product Info Section -->
                <div>
                    <h1 class="text-3xl font-bold mb-2">FIFA 2025 Ultimate Edition</h1>
                    <div class="flex items-center mb-4">
                        <div class="rating-stars flex mr-2">
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-half-fill active"></i>
                        </div>
                        <span class="text-gray-400 text-sm">(128 تقييم)</span>
                    </div>
                    <div class="flex flex-col mb-6">
                        <div class="flex items-center mb-2">
                            <span class="text-3xl font-bold text-white">350 د.ك</span>
                            <span class="text-xl text-gray-400 line-through mr-3">450 د.ك</span>
                            <span
                                class="bg-gradient-to-r from-primary to-blue-500 text-black text-sm font-bold py-1 px-3 rounded-full mr-3">توفير
                                100 د.ك</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 flex items-center justify-center text-primary mr-2">
                                <i class="ri-flashlight-line"></i>
                            </div>
                            <span class="text-primary">Instant Digital Delivery</span>
                        </div>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-300 mb-4">استمتع بتجربة كرة القدم الأكثر واقعية مع FIFA 2025 Ultimate
                            Edition. تتضمن هذه النسخة الخاصة محتوى حصري ومميزات إضافية لتعزيز تجربتك في اللعب.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                            <div class="flex items-center">
                                <div class="w-5 h-5 flex items-center justify-center text-primary mr-2">
                                    <i class="ri-check-line"></i>
                                </div>
                                <span class="text-gray-300">محتوى حصري للنسخة Ultimate</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-5 h-5 flex items-center justify-center text-primary mr-2">
                                    <i class="ri-check-line"></i>
                                </div>
                                <span class="text-gray-300">4600 نقطة FIFA Points</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-5 h-5 flex items-center justify-center text-primary mr-2">
                                    <i class="ri-check-line"></i>
                                </div>
                                <span class="text-gray-300">لاعب أيقوني للاستعارة في FUT</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-5 h-5 flex items-center justify-center text-primary mr-2">
                                    <i class="ri-check-line"></i>
                                </div>
                                <span class="text-gray-300">وصول مبكر قبل 3 أيام من الإصدار</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <span class="text-gray-300 ml-4">License Keys:</span>
                            <div class="custom-number-input flex">
                                <button
                                    class="w-8 h-8 bg-[#1a2234] rounded-r-button flex items-center justify-center border-none !rounded-button">
                                    <i class="ri-subtract-line text-gray-300"></i>
                                </button>
                                <input type="number" value="1" min="1"
                                    class="w-12 h-8 bg-[#1a2234] text-center text-white border-none">
                                <button
                                    class="w-8 h-8 bg-[#1a2234] rounded-l-button flex items-center justify-center border-none !rounded-button">
                                    <i class="ri-add-line text-gray-300"></i>
                                </button>
                            </div>
                        </div>
                        <div class="bg-[#1a2234] p-4 rounded-lg space-y-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-primary/10 rounded-lg mr-3">
                                    <i class="ri-key-2-line text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Instant Key Delivery</h4>
                                    <p class="text-sm text-gray-400">Receive your activation key immediately after
                                        purchase</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-primary/10 rounded-lg mr-3">
                                    <i class="ri-shield-check-line text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Official License</h4>
                                    <p class="text-sm text-gray-400">100% authentic key from authorized distributor</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-primary/10 rounded-lg mr-3">
                                    <i class="ri-customer-service-2-line text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">24/7 Support</h4>
                                    <p class="text-sm text-gray-400">Technical assistance available anytime</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <button
                            class="flex items-center justify-center bg-primary hover:bg-opacity-90 text-black font-bold py-3 px-6 !rounded-button whitespace-nowrap">
                            <i class="ri-shopping-cart-line mr-2"></i>
                            أضف إلى السلة
                        </button>
                        <button
                            class="flex items-center justify-center bg-blue-600 hover:bg-opacity-90 text-white font-bold py-3 px-6 !rounded-button whitespace-nowrap">
                            <i class="ri-shopping-bag-line mr-2"></i>
                            شراء الآن
                        </button>
                        <button
                            class="flex items-center justify-center bg-[#1a2234] hover:bg-opacity-90 text-white py-3 px-4 !rounded-button whitespace-nowrap">
                            <i class="ri-heart-line text-gray-300"></i>
                        </button>
                        <button
                            class="flex items-center justify-center bg-[#1a2234] hover:bg-opacity-90 text-white py-3 px-4 !rounded-button whitespace-nowrap">
                            <i class="ri-share-line text-gray-300"></i>
                        </button>
                    </div>
                </div>
                <div class="border-t border-gray-700 pt-4">
                    <div class="flex items-center mb-3">
                        <div class="w-5 h-5 flex items-center justify-center text-gray-400 mr-2">
                            <i class="ri-secure-payment-line"></i>
                        </div>
                        <span class="text-gray-300">Secure Payment Methods</span>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="w-5 h-5 flex items-center justify-center text-gray-400 mr-2">
                            <i class="ri-download-cloud-line"></i>
                        </div>
                        <span class="text-gray-300">Instant Digital Delivery</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 flex items-center justify-center text-gray-400 mr-2">
                            <i class="ri-refresh-line"></i>
                        </div>
                        <span class="text-gray-300">14-Day Money Back Guarantee</span>
                    </div>
                    <div class="mt-4 p-4 bg-[#1a2234] rounded-lg">
                        <h4 class="font-medium mb-2">How it works:</h4>
                        <ol class="space-y-2 text-sm text-gray-400">
                            <li class="flex items-center">
                                <span
                                    class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center text-primary mr-2 text-xs">1</span>
                                <span>Purchase the product</span>
                            </li>
                            <li class="flex items-center">
                                <span
                                    class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center text-primary mr-2 text-xs">2</span>
                                <span>Receive activation key via email</span>
                            </li>
                            <li class="flex items-center">
                                <span
                                    class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center text-primary mr-2 text-xs">3</span>
                                <span>Download and activate your game</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Details Tabs -->
        <div class="mt-12">
            <div class="border-b border-gray-700 mb-6">
                <div class="flex space-x-8 space-x-reverse">
                    <button class="text-primary border-b-2 border-primary pb-3 font-medium">تفاصيل المنتج</button>
                    <button class="text-gray-400 pb-3 font-medium">المواصفات</button>
                    <button class="text-gray-400 pb-3 font-medium">التقييمات</button>
                    <button class="text-gray-400 pb-3 font-medium">الأسئلة الشائعة</button>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h2 class="text-xl font-bold mb-4">وصف المنتج</h2>
                    <p class="text-gray-300 mb-4">FIFA 2025 Ultimate Edition هي النسخة الأكثر تميزًا من سلسلة ألعاب FIFA
                        الشهيرة. تقدم هذه النسخة تجربة كرة قدم غامرة مع رسومات متطورة وتحسينات في الذكاء الاصطناعي
                        لتوفير تجربة لعب أكثر واقعية من أي وقت مضى.</p>
                    <p class="text-gray-300 mb-4">تتضمن النسخة Ultimate Edition العديد من المميزات الحصرية، بما في ذلك:
                    </p>
                    <ul class="list-disc list-inside text-gray-300 mb-6 pr-4">
                        <li class="mb-2">وصول مبكر للعبة قبل 3 أيام من الإصدار الرسمي</li>
                        <li class="mb-2">4600 نقطة FIFA Points للاستخدام في وضع Ultimate Team</li>
                        <li class="mb-2">لاعب أيقوني للاستعارة في FUT لمدة 5 مباريات</li>
                        <li class="mb-2">عناصر FUT غير قابلة للتداول</li>
                        <li class="mb-2">مكافآت أسبوعية خاصة</li>
                        <li class="mb-2">محتوى حصري للاعبين المميزين</li>
                        <li>أزياء وتصميمات خاصة للاعبين في وضع VOLTA</li>
                    </ul>
                    <h3 class="text-lg font-bold mb-3">أوضاع اللعب</h3>
                    <p class="text-gray-300 mb-4">استمتع بمجموعة متنوعة من أوضاع اللعب، بما في ذلك:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-[#1a2234] p-4 rounded-lg">
                            <h4 class="font-bold mb-2">وضع المهنة</h4>
                            <p class="text-gray-400 text-sm">قم بإدارة ناديك المفضل أو ابدأ مسيرتك كلاعب محترف في وضع
                                المهنة المحسن.</p>
                        </div>
                        <div class="bg-[#1a2234] p-4 rounded-lg">
                            <h4 class="font-bold mb-2">Ultimate Team</h4>
                            <p class="text-gray-400 text-sm">قم ببناء فريق أحلامك مع أفضل اللاعبين من الماضي والحاضر.
                            </p>
                        </div>
                        <div class="bg-[#1a2234] p-4 rounded-lg">
                            <h4 class="font-bold mb-2">VOLTA Football</h4>
                            <p class="text-gray-400 text-sm">استمتع بكرة القدم في الشوارع مع أسلوب لعب سريع ومهارات
                                استعراضية.</p>
                        </div>
                        <div class="bg-[#1a2234] p-4 rounded-lg">
                            <h4 class="font-bold mb-2">Pro Clubs</h4>
                            <p class="text-gray-400 text-sm">انضم إلى أصدقائك وكوّن فريقًا للمنافسة ضد فرق أخرى عبر
                                الإنترنت.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-[#1a2234] p-6 rounded-lg h-fit">
                    <h2 class="text-xl font-bold mb-4">متطلبات النظام</h2>
                    <div class="mb-4">
                        <h3 class="font-bold mb-2">الحد الأدنى:</h3>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li><span class="text-gray-400">نظام التشغيل:</span> Windows 10 64-bit</li>
                            <li><span class="text-gray-400">المعالج:</span> Intel Core i5-6600K / AMD Ryzen 5 1600</li>
                            <li><span class="text-gray-400">الذاكرة:</span> 8 GB RAM</li>
                            <li><span class="text-gray-400">الرسومات:</span> NVIDIA GeForce GTX 1050 Ti / AMD Radeon RX
                                570</li>
                            <li><span class="text-gray-400">مساحة التخزين:</span> 100 GB</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold mb-2">الموصى به:</h3>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li><span class="text-gray-400">نظام التشغيل:</span> Windows 10/11 64-bit</li>
                            <li><span class="text-gray-400">المعالج:</span> Intel Core i7-8700 / AMD Ryzen 7 2700X</li>
                            <li><span class="text-gray-400">الذاكرة:</span> 16 GB RAM</li>
                            <li><span class="text-gray-400">الرسومات:</span> NVIDIA GeForce RTX 2060 / AMD Radeon RX
                                5700</li>
                            <li><span class="text-gray-400">مساحة التخزين:</span> 100 GB SSD</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonials Section -->
    <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">آراء العملاء</h2>
            <a href="#" class="text-primary text-sm hover:underline">عرض الكل</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Testimonial 1 -->
            <div class="bg-[#111827] rounded-xl p-6 border border-gray-800 hover:border-primary transition-colors">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2234] flex items-center justify-center mr-3">
                        <i class="ri-user-3-fill text-primary ri-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">أحمد محمود</h3>
                        <div class="rating-stars flex mt-1">
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-300 mb-3">أفضل نسخة من FIFA حتى الآن! الرسومات مذهلة والذكاء الاصطناعي للاعبين تحسن
                    بشكل كبير. النسخة Ultimate تستحق السعر بالتأكيد مع كل المحتوى الإضافي.</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">14 يونيو 2025</span>
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm ml-1">مفيد؟</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-primary">
                            <i class="ri-thumb-up-line"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Testimonial 2 -->
            <div class="bg-[#111827] rounded-xl p-6 border border-gray-800 hover:border-primary transition-colors">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2234] flex items-center justify-center mr-3">
                        <i class="ri-user-3-fill text-blue-500 ri-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">سارة العلي</h3>
                        <div class="rating-stars flex mt-1">
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-line inactive"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-300 mb-3">تجربة رائعة بشكل عام، وضع Ultimate Team أصبح أكثر متعة هذا العام. الوصول
                    المبكر كان ميزة رائعة، لكن لا تزال هناك بعض المشكلات الصغيرة في الخوادم أحيانًا.</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">10 يونيو 2025</span>
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm ml-1">مفيد؟</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-primary">
                            <i class="ri-thumb-up-line"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Testimonial 3 -->
            <div class="bg-[#111827] rounded-xl p-6 border border-gray-800 hover:border-primary transition-colors">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2234] flex items-center justify-center mr-3">
                        <i class="ri-user-3-fill text-purple-500 ri-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">محمد الخالدي</h3>
                        <div class="rating-stars flex mt-1">
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-half-fill active"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-300 mb-3">وضع المهنة تحسن كثيرًا هذا العام، والتحكم في اللاعبين أصبح أكثر واقعية.
                    أحب المحتوى الإضافي في النسخة Ultimate، خاصة نقاط FIFA Points التي ساعدتني في بناء فريق قوي من
                    البداية.</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">8 يونيو 2025</span>
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm ml-1">مفيد؟</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-primary">
                            <i class="ri-thumb-up-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    </div>
    <!-- Footer -->
    @include('themes.greenGame.partials.footer')
    <script id="product-scripts">
        document.addEventListener('DOMContentLoaded', function () {
            // Image gallery functionality
            const thumbnails = document.querySelectorAll('.thumbnail-container > div');
            const mainImage = document.querySelector('.product-image-container img');
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function () {
                    mainImage.src = this.querySelector('img').src.replace('width=100&height=100', 'width=800&height=800');
                    thumbnails.forEach(t => t.classList.remove('border-primary'));
                    thumbnails.forEach(t => t.classList.add('border-gray-700'));
                    this.classList.remove('border-gray-700');
                    this.classList.add('border-primary');
                });
            });
            // Purchase button click handler
            const purchaseBtn = document.querySelector('button:contains("شراء الآن")');
            if (purchaseBtn) {
                purchaseBtn.addEventListener('click', function () {
                    const modal = document.createElement('div');
                    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                    modal.innerHTML = `
<div class="bg-[#111827] rounded-xl p-6 max-w-md w-full mx-4">
<div class="flex justify-between items-center mb-4">
<h3 class="text-xl font-bold">Complete Purchase</h3>
<button class="text-gray-400 hover:text-white" onclick="this.closest('.fixed').remove()">
<i class="ri-close-line ri-lg"></i>
</button>
</div>
<div class="space-y-4">
<div class="bg-[#1a2234] p-4 rounded-lg">
<div class="flex justify-between mb-2">
<span class="text-gray-400">Product:</span>
<span>FIFA 2025 Ultimate Edition</span>
</div>
<div class="flex justify-between mb-2">
<span class="text-gray-400">Quantity:</span>
<span>1 License Key</span>
</div>
<div class="flex justify-between">
<span class="text-gray-400">Total:</span>
<span class="text-primary font-bold">350 د.ك</span>
</div>
</div>
<div class="space-y-2">
<button class="w-full bg-primary hover:bg-opacity-90 text-black font-bold py-3 !rounded-button flex items-center justify-center">
<i class="ri-bank-card-line mr-2"></i>
Pay with Credit Card
</button>
<button class="w-full bg-[#1a2234] hover:bg-opacity-90 text-white font-bold py-3 !rounded-button flex items-center justify-center">
<i class="ri-paypal-fill mr-2"></i>
Pay with PayPal
</button>
</div>
<p class="text-sm text-gray-400 text-center">
You'll receive your activation key instantly after payment
</p>
</div>
</div>
`;
                    document.body.appendChild(modal);
                });
            }
        });
    </script>
    <script id="quantity-input-script">
        document.addEventListener('DOMContentLoaded', function () {
            const minusBtn = document.querySelector('.custom-number-input button:first-child');
            const plusBtn = document.querySelector('.custom-number-input button:last-child');
            const input = document.querySelector('.custom-number-input input');
            minusBtn.addEventListener('click', function () {
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
            plusBtn.addEventListener('click', function () {
                const currentValue = parseInt(input.value);
                input.value = currentValue + 1;
            });
            input.addEventListener('change', function () {
                if (this.value < 1) {
                    this.value = 1;
                }
            });
        });
    </script>
    <script id="tabs-script">
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.border-b.border-gray-700.mb-6 button');
            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Remove active state from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-primary', 'border-b-2', 'border-primary');
                        btn.classList.add('text-gray-400');
                    });
                    // Add active state to clicked button
                    this.classList.remove('text-gray-400');
                    this.classList.add('text-primary', 'border-b-2', 'border-primary');
                });
            });
        });
    </script>
</body>

</html>