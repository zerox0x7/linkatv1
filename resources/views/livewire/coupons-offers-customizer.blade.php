<div>
    <!-- Loading Overlay -->
    <div wire:loading.class="opacity-50 pointer-events-none" wire:target="loadCouponsAndOffers,refreshCoupons,save">
        <!-- Content Area -->
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-white mb-2">تخصيص الكوبونات والعروض</h1>
                <p class="text-gray-400">اختر الكوبونات والعروض المراد عرضها في كل صفحة</p>
            </div>

            <!-- Theme Links Section -->
            <div class="mb-6">
                @livewire('theme-links')
            </div>

            <!-- Refresh Button -->
            <div class="mb-6">
                <button wire:click="refreshCoupons" type="button" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled" wire:target="refreshCoupons">
                    <div wire:loading.remove wire:target="refreshCoupons">
                        <i class="ri-refresh-line ml-2"></i>
                        تحديث قائمة الكوبونات
                    </div>
                    <div wire:loading wire:target="refreshCoupons" class="flex items-center">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2"></div>
                        جاري التحديث...
                    </div>
                </button>
            </div>

            <!-- Loading State for Initial Data Load -->
            <div wire:loading wire:target="loadCouponsAndOffers" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
                <p class="text-gray-400">جاري تحميل البيانات...</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session()->has('success'))
                <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page-based Coupons & Offers Selection -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" wire:loading.remove wire:target="loadCouponsAndOffers">
                <!-- Home Page -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                <i class="ri-home-line text-blue-400"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">الصفحة الرئيسية</h2>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="homePageEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل العروض</span>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="modern-section-title mb-4">
                                <span class="title-text">الكوبونات المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Coupons -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableCoupons) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableCoupons as $coupon)
                                        <div class="coupon-card {{ in_array($coupon['id'], $homePageCoupons ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleHomePageCoupon('{{ $coupon['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleHomePageCoupon">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $coupon['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $coupon['usage_info'] }}</p>
                                                    @if($coupon['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $coupon['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-coupon-line text-3xl mb-2"></i>
                                    <p>لا توجد كوبونات متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد الكوبونات المطلوبة</p>
                            @error('homePageCoupons') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="modern-section-title offers-title mb-4">
                                <span class="title-text">العروض المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Offers -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableOffers) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableOffers as $offer)
                                        <div class="coupon-card {{ in_array($offer['id'], $homePageOffers ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleHomePageOffer('{{ $offer['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleHomePageOffer">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $offer['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $offer['usage_info'] }}</p>
                                                    @if($offer['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $offer['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-gift-line text-3xl mb-2"></i>
                                    <p>لا توجد عروض متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد العروض المطلوبة</p>
                            @error('homePageOffers') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب العرض</label>
                            <select wire:model="homePageOrder" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="newest">الأحدث أولاً</option>
                                <option value="oldest">الأقدم أولاً</option>
                                <option value="highest_discount">أعلى خصم</option>
                                <option value="lowest_discount">أقل خصم</option>
                            </select>
                            @error('homePageOrder') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Shop Page -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center">
                                <i class="ri-store-line text-orange-400"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">صفحة المتجر</h2>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="shopPageEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل العروض</span>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="modern-section-title mb-4">
                                <span class="title-text">الكوبونات المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Coupons -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableCoupons) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableCoupons as $coupon)
                                        <div class="coupon-card {{ in_array($coupon['id'], $shopPageCoupons ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleShopPageCoupon('{{ $coupon['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleShopPageCoupon">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $coupon['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $coupon['usage_info'] }}</p>
                                                    @if($coupon['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $coupon['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-coupon-line text-3xl mb-2"></i>
                                    <p>لا توجد كوبونات متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد الكوبونات المطلوبة</p>
                            @error('shopPageCoupons') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="modern-section-title offers-title mb-4">
                                <span class="title-text">العروض المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Offers -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableOffers) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableOffers as $offer)
                                        <div class="coupon-card {{ in_array($offer['id'], $shopPageOffers ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleShopPageOffer('{{ $offer['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleShopPageOffer">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $offer['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $offer['usage_info'] }}</p>
                                                    @if($offer['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $offer['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-gift-line text-3xl mb-2"></i>
                                    <p>لا توجد عروض متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد العروض المطلوبة</p>
                            @error('shopPageOffers') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب العرض</label>
                            <select wire:model="shopPageOrder" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="newest">الأحدث أولاً</option>
                                <option value="oldest">الأقدم أولاً</option>
                                <option value="highest_discount">أعلى خصم</option>
                                <option value="lowest_discount">أقل خصم</option>
                            </select>
                            @error('shopPageOrder') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Page -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                <i class="ri-shopping-bag-line text-purple-400"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">صفحة المنتج</h2>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="productPageEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل العروض</span>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="modern-section-title mb-4">
                                <span class="title-text">الكوبونات المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Coupons -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableCoupons) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableCoupons as $coupon)
                                        <div class="coupon-card {{ in_array($coupon['id'], $productPageCoupons ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleProductPageCoupon('{{ $coupon['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleProductPageCoupon">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $coupon['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $coupon['usage_info'] }}</p>
                                                    @if($coupon['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $coupon['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-coupon-line text-3xl mb-2"></i>
                                    <p>لا توجد كوبونات متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد الكوبونات المطلوبة</p>
                            @error('productPageCoupons') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="modern-section-title offers-title mb-4">
                                <span class="title-text">العروض المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Offers -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableOffers) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableOffers as $offer)
                                        <div class="coupon-card {{ in_array($offer['id'], $productPageOffers ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleProductPageOffer('{{ $offer['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleProductPageOffer">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $offer['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $offer['usage_info'] }}</p>
                                                    @if($offer['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $offer['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-gift-line text-3xl mb-2"></i>
                                    <p>لا توجد عروض متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد العروض المطلوبة</p>
                            @error('productPageOffers') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب العرض</label>
                            <select wire:model="productPageOrder" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="related">المرتبطة بالمنتج</option>
                                <option value="highest_discount">أعلى خصم</option>
                                <option value="newest">الأحدث أولاً</option>
                                <option value="expiring_soon">الأكثر قرباً للانتهاء</option>
                            </select>
                            @error('productPageOrder') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Cart Page -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center">
                                <i class="ri-shopping-cart-line text-green-400"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">صفحة السلة</h2>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="cartPageEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل العروض</span>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="modern-section-title mb-4">
                                <span class="title-text">الكوبونات المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Coupons -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableCoupons) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableCoupons as $coupon)
                                        <div class="coupon-card {{ in_array($coupon['id'], $cartPageCoupons ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleCartPageCoupon('{{ $coupon['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleCartPageCoupon">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $coupon['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $coupon['usage_info'] }}</p>
                                                    @if($coupon['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $coupon['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-coupon-line text-3xl mb-2"></i>
                                    <p>لا توجد كوبونات متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد الكوبونات المطلوبة</p>
                            @error('cartPageCoupons') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="modern-section-title offers-title mb-4">
                                <span class="title-text">العروض المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Offers -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableOffers) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableOffers as $offer)
                                        <div class="coupon-card {{ in_array($offer['id'], $cartPageOffers ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleCartPageOffer('{{ $offer['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleCartPageOffer">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $offer['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $offer['usage_info'] }}</p>
                                                    @if($offer['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $offer['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-gift-line text-3xl mb-2"></i>
                                    <p>لا توجد عروض متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد العروض المطلوبة</p>
                            @error('cartPageOffers') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب العرض</label>
                            <select wire:model="cartPageOrder" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="applicable">القابلة للتطبيق على السلة</option>
                                <option value="highest_discount">أعلى خصم</option>
                                <option value="expiring_soon">الأكثر قرباً للانتهاء</option>
                                <option value="newest">الأحدث أولاً</option>
                            </select>
                            @error('cartPageOrder') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Checkout Page -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center">
                                <i class="ri-bank-card-line text-red-400"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">صفحة الدفع</h2>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="checkoutPageEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل العروض</span>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="modern-section-title mb-4">
                                <span class="title-text">الكوبونات المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Coupons -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableCoupons) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableCoupons as $coupon)
                                        <div class="coupon-card {{ in_array($coupon['id'], $checkoutPageCoupons ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleCheckoutPageCoupon('{{ $coupon['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleCheckoutPageCoupon">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $coupon['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $coupon['usage_info'] }}</p>
                                                    @if($coupon['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $coupon['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-coupon-line text-3xl mb-2"></i>
                                    <p>لا توجد كوبونات متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد الكوبونات المطلوبة</p>
                            @error('checkoutPageCoupons') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="modern-section-title offers-title mb-4">
                                <span class="title-text">العروض المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Offers -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableOffers) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableOffers as $offer)
                                        <div class="coupon-card {{ in_array($offer['id'], $checkoutPageOffers ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleCheckoutPageOffer('{{ $offer['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleCheckoutPageOffer">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $offer['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $offer['usage_info'] }}</p>
                                                    @if($offer['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $offer['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-gift-line text-3xl mb-2"></i>
                                    <p>لا توجد عروض متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد العروض المطلوبة</p>
                            @error('checkoutPageOffers') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب العرض</label>
                            <select wire:model="checkoutPageOrder" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="last_chance">آخر فرصة</option>
                                <option value="highest_discount">أعلى خصم</option>
                                <option value="expiring_soon">الأكثر قرباً للانتهاء</option>
                                <option value="applicable">القابلة للتطبيق</option>
                            </select>
                            @error('checkoutPageOrder') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Category Pages -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                <i class="ri-list-check text-indigo-400"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">صفحات الفئات</h2>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="categoryPagesEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل العروض</span>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="modern-section-title mb-4">
                                <span class="title-text">الكوبونات المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Coupons -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableCoupons) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableCoupons as $coupon)
                                        <div class="coupon-card {{ in_array($coupon['id'], $categoryPagesCoupons ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleCategoryPagesCoupon('{{ $coupon['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleCategoryPagesCoupon">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $coupon['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $coupon['usage_info'] }}</p>
                                                    @if($coupon['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $coupon['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-coupon-line text-3xl mb-2"></i>
                                    <p>لا توجد كوبونات متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد الكوبونات المطلوبة</p>
                            @error('categoryPagesCoupons') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="modern-section-title offers-title mb-4">
                                <span class="title-text">العروض المعروضة</span>
                                <div class="title-line"></div>
                            </div>
                            @if($isLoading)
                                <!-- Skeleton Loader for Offers -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @for($i = 0; $i < 6; $i++)
                                        <div class="coupon-skeleton">
                                            <div class="skeleton-line h-4 w-3/4 mb-2"></div>
                                            <div class="skeleton-line h-3 w-1/2"></div>
                                        </div>
                                    @endfor
                                </div>
                            @elseif(count($availableOffers) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar">
                                    @foreach($availableOffers as $offer)
                                        <div class="coupon-card {{ in_array($offer['id'], $categoryPagesOffers ?? []) ? 'selected' : '' }}" 
                                             wire:click="toggleCategoryPagesOffer('{{ $offer['id'] }}')"
                                             wire:loading.class="opacity-50 pointer-events-none"
                                             wire:target="toggleCategoryPagesOffer">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white mb-1">{{ $offer['display_name'] }}</h4>
                                                    <p class="text-xs text-gray-400">{{ $offer['usage_info'] }}</p>
                                                    @if($offer['status'] == 'ينتهي قريباً')
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-300">
                                                            {{ $offer['status'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="checkbox-wrapper">
                                                    <i class="ri-check-line check-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="ri-gift-line text-3xl mb-2"></i>
                                    <p>لا توجد عروض متاحة</p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">انقر على الكروت لتحديد العروض المطلوبة</p>
                            @error('categoryPagesOffers') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب العرض</label>
                            <select wire:model="categoryPagesOrder" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="category_specific">خاصة بالفئة</option>
                                <option value="highest_discount">أعلى خصم</option>
                                <option value="newest">الأحدث أولاً</option>
                                <option value="expiring_soon">الأكثر قرباً للانتهاء</option>
                            </select>
                            @error('categoryPagesOrder') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Settings -->
            <div class="mt-6">
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                            <i class="ri-settings-line text-yellow-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">الإعدادات العامة</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">الحد الأقصى للكوبونات في الصفحة</label>
                            <select wire:model="maxCouponsPerPage" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="3">3 كوبونات</option>
                                <option value="6">6 كوبونات</option>
                                <option value="9">9 كوبونات</option>
                                <option value="12">12 كوبون</option>
                            </select>
                            @error('maxCouponsPerPage') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">الحد الأقصى للعروض في الصفحة</label>
                            <select wire:model="maxOffersPerPage" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="3">3 عروض</option>
                                <option value="6">6 عروض</option>
                                <option value="9">9 عروض</option>
                                <option value="12">12 عرض</option>
                            </select>
                            @error('maxOffersPerPage') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">موضع العرض</label>
                            <select wire:model="displayPosition" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="top">أعلى الصفحة</option>
                                <option value="middle">وسط الصفحة</option>
                                <option value="bottom">أسفل الصفحة</option>
                                <option value="sidebar">الشريط الجانبي</option>
                            </select>
                            @error('displayPosition') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-[#2a3548]">
                        <div class="text-sm text-gray-400">
                            <p>يتم عرض الكوبونات والعروض النشطة فقط</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-6 flex justify-end">
                <button wire:click="save" type="button" 
                        class="bg-gradient-to-r from-primary to-secondary text-black px-6 py-3 rounded-lg font-medium hover:from-primary/90 hover:to-secondary/90 transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled" wire:target="save">
                    <div wire:loading.remove wire:target="save">
                        <i class="ri-save-line ml-2"></i>
                        حفظ التغييرات
                    </div>
                    <div wire:loading wire:target="save" class="flex items-center">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-black ml-2"></div>
                        جاري الحفظ...
                    </div>
                </button>
            </div>
        </div>

        <!-- Loading Indicator Overlay -->
        <div wire:loading wire:target="loadCouponsAndOffers,refreshCoupons,save" 
             class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-xl">
                <div class="flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                    <span class="text-white font-medium">جاري المعالجة...</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            background: #374151;
            border-radius: 12px;
            outline: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .toggle-switch:checked {
            background: #00e5bb;
        }

        .toggle-switch::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .toggle-switch:checked::before {
            transform: translateX(20px);
        }

        /* Coupon Card Styles */
        .coupon-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 2px solid #334155;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            min-height: 100px;
        }

        .coupon-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.02) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .coupon-card:hover::before {
            transform: translateX(100%);
        }

        .coupon-card:hover {
            border-color: #00e5bb;
            box-shadow: 0 8px 25px rgba(0, 229, 187, 0.15);
            transform: translateY(-2px);
        }

        .coupon-card.selected {
            border-color: #00e5bb;
            background: linear-gradient(135deg, #065f46 0%, #064e3b 100%);
            box-shadow: 0 8px 25px rgba(0, 229, 187, 0.2);
        }

        .checkbox-wrapper {
            width: 24px;
            height: 24px;
            border: 2px solid #6b7280;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .coupon-card.selected .checkbox-wrapper {
            background: #00e5bb;
            border-color: #00e5bb;
        }

        .check-icon {
            font-size: 14px;
            color: white;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.2s ease;
        }

        .coupon-card.selected .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        /* Custom scrollbar for grid containers */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #374151 #1f2937;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }

        /* Responsive grid adjustments */
        @media (max-width: 640px) {
            .coupon-card {
                padding: 12px;
                min-height: 90px;
            }
        }

        /* Animation for card selection */
        .coupon-card {
            animation: cardEntrance 0.5s ease-out;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Pulse animation for new selections */
        .coupon-card.selected {
            animation: pulseSelection 0.6s ease-out;
        }

        @keyframes pulseSelection {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Loading state (optional for future use) */
        .coupon-card.loading {
            pointer-events: none;
            opacity: 0.6;
        }

        .coupon-card.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            border: 2px solid #00e5bb;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Modern Section Title Styles */
        .modern-section-title {
            position: relative;
            display: flex;
            align-items: center;
            padding-right: 20px;
            margin-bottom: 16px;
        }

        .modern-section-title::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #00e5bb 0%, #00d4aa 50%, #00c299 100%);
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 229, 187, 0.3);
        }

        .modern-section-title .title-text {
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
            position: relative;
            padding-right: 12px;
        }

        .modern-section-title .title-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, 
                rgba(0, 229, 187, 0.6) 0%, 
                rgba(0, 229, 187, 0.3) 30%, 
                rgba(100, 116, 139, 0.3) 70%, 
                rgba(100, 116, 139, 0.1) 100%
            );
            margin-right: 16px;
            position: relative;
        }

        .modern-section-title .title-line::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background: #00e5bb;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(0, 229, 187, 0.6);
        }

        /* Hover effect for modern section titles */
        .modern-section-title:hover .title-text {
            color: #00e5bb;
            transition: color 0.3s ease;
        }

        .modern-section-title:hover::before {
            background: linear-gradient(135deg, #00f5d4 0%, #00e5bb 50%, #00d4aa 100%);
            box-shadow: 0 4px 12px rgba(0, 229, 187, 0.5);
            transition: all 0.3s ease;
        }

        .modern-section-title:hover .title-line {
            background: linear-gradient(90deg, 
                rgba(0, 245, 212, 0.8) 0%, 
                rgba(0, 229, 187, 0.5) 30%, 
                rgba(100, 116, 139, 0.4) 70%, 
                rgba(100, 116, 139, 0.2) 100%
            );
            transition: background 0.3s ease;
        }

        .modern-section-title:hover .title-line::after {
            background: #00f5d4;
            box-shadow: 0 0 12px rgba(0, 245, 212, 0.8);
            transition: all 0.3s ease;
        }

        /* Animation for section titles */
        .modern-section-title {
            animation: titleSlideInRight 0.6s ease-out;
        }

        @keyframes titleSlideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Alternative style for offers (green accent) */
        .modern-section-title.offers-title::before {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .modern-section-title.offers-title .title-line {
            background: linear-gradient(90deg, 
                rgba(16, 185, 129, 0.6) 0%, 
                rgba(16, 185, 129, 0.3) 30%, 
                rgba(100, 116, 139, 0.3) 70%, 
                rgba(100, 116, 139, 0.1) 100%
            );
        }

        .modern-section-title.offers-title .title-line::after {
            background: #10b981;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
        }

        .modern-section-title.offers-title:hover .title-text {
            color: #10b981;
        }

        .modern-section-title.offers-title:hover::before {
            background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.5);
        }

        .modern-section-title.offers-title:hover .title-line {
            background: linear-gradient(90deg, 
                rgba(52, 211, 153, 0.8) 0%, 
                rgba(16, 185, 129, 0.5) 30%, 
                rgba(100, 116, 139, 0.4) 70%, 
                rgba(100, 116, 139, 0.2) 100%
            );
        }

        .modern-section-title.offers-title:hover .title-line::after {
            background: #34d399;
            box-shadow: 0 0 12px rgba(52, 211, 153, 0.8);
        }

        /* Skeleton Loading Styles */
        .coupon-skeleton {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 2px solid #334155;
            border-radius: 12px;
            padding: 16px;
            min-height: 100px;
            position: relative;
            overflow: hidden;
        }

        .skeleton-line {
            background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 4px;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        /* Loading State Improvements */
        .coupon-card[wire\\:loading\\.class] {
            transition: opacity 0.3s ease;
        }

        /* Backdrop blur for loading overlay */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
    </style>
</div>