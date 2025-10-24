<div class="min-h-screen bg-gradient-to-br from-[#0f1623] to-[#162033] text-white" dir="rtl">
    <div class="flex gap-6 p-6">
        

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary to-secondary flex items-center justify-center shadow-lg">
                        <i class="ri-coupon-3-line text-black text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">إعدادات الكوبونات المتقدمة</h1>
                        <p class="text-gray-400 text-sm">إدارة الإعدادات المتقدمة لأكواد الخصم</p>
                    </div>
                </div>
                
                <!-- Product Selection Dropdown -->
                <div class="relative w-full max-w-md" x-data="{ open: @entangle('show_product_dropdown') }">
                    <div class="flex items-center gap-2 bg-gradient-to-r from-[#121827] to-[#1a2234] px-4 py-2 rounded-xl border border-[#2a3548] cursor-pointer hover:border-primary/50 transition-all duration-300 w-full" 
                         @click="open = !open" 
                         wire:click="showProductDropdown">
                        <i class="ri-search-line text-primary"></i>
                        <input type="text" 
                               wire:model.live="product_search"
                               placeholder="ابحث عن المنتج..."
                               class="bg-transparent text-gray-300 text-sm outline-none border-none flex-1 placeholder-gray-500 product-search-input"
                               @click.stop
                               @focus="open = true">
                        @if($selected_product)
                            <button wire:click="clearProductSelection" 
                                    class="text-gray-400 hover:text-red-400 transition-colors ml-2"
                                    @click.stop>
                                <i class="ri-close-line"></i>
                            </button>
                        @endif
                        <i class="ri-arrow-down-s-line text-gray-400 transition-transform duration-300" 
                           :class="{ 'rotate-180': open }"></i>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.away="open = false; $wire.hideProductDropdown()"
                         class="absolute top-full left-0 right-0 mt-2 bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] rounded-xl shadow-2xl z-50 max-h-80 overflow-y-auto dropdown-enter product-dropdown-list min-w-[500px]">
                        
                        @if($selected_product)
                            <!-- Selected Product Display -->
                            <div class="p-4 border-b border-[#2a3548] bg-primary/5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-primary/20 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($selected_product->main_image)
                                            <img src="{{ asset('storage/'.$selected_product->main_image) }}" alt="{{ $selected_product->name }}" class="w-full h-full object-cover rounded">
                                        @else
                                            <i class="ri-check-line text-primary"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white font-medium flex items-center gap-2">
                                            <i class="ri-check-line text-primary"></i>
                                            {{ $selected_product->name }}
                                        </h4>
                                        <div class="flex items-center gap-3 text-xs mt-1">
                                            @if($selected_product->sku)
                                                <span class="text-gray-400 bg-gray-600/30 px-2 py-1 rounded">SKU: {{ $selected_product->sku }}</span>
                                            @endif
                                            <span class="text-primary font-medium">{{ number_format($selected_product->price, 2) }} ريال</span>
                                            @if($selected_product->coupon_eligible)
                                                <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded">مؤهل للخصم</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if(count($available_products) > 0)
                            <!-- Available Products List -->
                            <div class="p-2">
                                @foreach($available_products as $product)
                                    <div wire:click="selectProduct({{ $product->id }})" 
                                         class="flex items-center gap-4 p-4 rounded-lg hover:bg-[#0f1623] cursor-pointer transition-all duration-200 group product-dropdown-item">
                                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#0f1623] to-[#1a2234] border border-[#2a3548] flex items-center justify-center group-hover:border-primary/50 overflow-hidden flex-shrink-0">
                                            @if($product->main_image)
                                                <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <i class="ri-image-line text-gray-400 group-hover:text-primary"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-white font-medium text-sm group-hover:text-primary transition-colors truncate">{{ $product->name }}</h4>
                                            <div class="flex items-center gap-3 text-xs text-gray-400 mt-1">
                                                @if($product->sku)
                                                    <span class="bg-gray-600/30 px-2 py-1 rounded text-xs">SKU: {{ $product->sku }}</span>
                                                @endif
                                                <span class="text-primary font-medium">{{ number_format($product->price, 2) }} ريال</span>
                                                @if($product->coupon_eligible)
                                                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded text-xs">مؤهل للخصم</span>
                                                @endif
                                            </div>
                                            @if($product->description)
                                                <p class="text-gray-500 text-xs mt-1 truncate">{{ Str::limit($product->description, 60) }}</p>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="ri-arrow-right-s-line text-gray-400 group-hover:text-primary"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- No Products Found -->
                            <div class="p-6 text-center">
                                <div class="w-16 h-16 rounded-full bg-gray-600/20 flex items-center justify-center mx-auto mb-3">
                                    <i class="ri-search-line text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-400 text-sm">لا توجد منتجات متاحة</p>
                                @if($product_search)
                                    <p class="text-gray-500 text-xs mt-1">جرب البحث بكلمات مختلفة</p>
                                @endif
                            </div>
                        @endif
                        
                        <!-- Quick Actions -->
                        <div class="p-3 border-t border-[#2a3548] bg-[#0f1623]/50">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-400">{{ count($available_products) }} منتج متاح</span>
                                @if($selected_product)
                                    <button wire:click="clearProductSelection" 
                                            class="text-red-400 hover:text-red-300 transition-colors flex items-center gap-1">
                                        <i class="ri-close-line"></i>
                                        <span>إلغاء التحديد</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 text-green-300 rounded-xl shadow-lg">
                    <div class="flex items-center gap-3">
                        <i class="ri-check-line text-green-400"></i>
                        {{ session('message') }}
                    </div>
                </div>
            @endif

            <!-- Selected Product Notice -->
            @if($selected_product)
                <div class="mb-6 p-4 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 border border-blue-500/30 text-blue-300 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                <i class="ri-product-hunt-line text-blue-400"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-200">تم تحديد المنتج: {{ $selected_product->name }}</h4>
                                <p class="text-blue-400 text-sm">ستطبق الإعدادات على هذا المنتج تحديداً</p>
                            </div>
                        </div>
                        <button wire:click="clearProductSelection" 
                                class="text-blue-400 hover:text-blue-300 transition-colors">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                </div>
            @else
                <div class="mb-6 p-4 bg-gradient-to-r from-amber-500/20 to-orange-500/20 border border-amber-500/30 text-amber-300 rounded-xl shadow-lg">
                    <div class="flex items-center gap-3">
                        <i class="ri-information-line text-amber-400"></i>
                        <p>   لم يتم تحديد منتج بعد  - قم بالبحث في المحرك هنا <i class="ri-arrow-left-up-line text-blue-400"></i></p>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="saveSettings" class="space-y-6">
                <!-- Main Form Card -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] shadow-2xl overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] px-6 py-4 border-b border-[#2a3548]">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary/20 flex items-center justify-center">
                                <i class="ri-settings-4-line text-primary"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">طوابة حسابية</h2>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Minimum Order Value -->
                            <div class="space-y-3">
                                <label for="min_coupon_order_value" class="block text-sm font-medium text-gray-300">
                                    الحد الأدنى لقيمة الطلب (min_coupon_order_value)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="min_coupon_order_value"
                                           wire:model="min_coupon_order_value"
                                           class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] text-white rounded-lg focus:border-primary/50 focus:ring-2 focus:ring-primary/20 transition-all duration-300 placeholder-gray-500"
                                           placeholder="100"
                                           step="0.01">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="ri-money-dollar-circle-line"></i>
                                    </div>
                                </div>
                                @error('min_coupon_order_value') 
                                    <span class="text-red-400 text-xs flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Maximum Discount Amount -->
                            <div class="space-y-3">
                                <label for="max_coupon_discount_amount" class="block text-sm font-medium text-gray-300">
                                    الحد الأقصى لمبلغ الخصم (max_coupon_discount_amount)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="max_coupon_discount_amount"
                                           wire:model="max_coupon_discount_amount"
                                           class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] text-white rounded-lg focus:border-primary/50 focus:ring-2 focus:ring-primary/20 transition-all duration-300 placeholder-gray-500"
                                           placeholder="50"
                                           step="0.01">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="ri-discount-percent-line"></i>
                                    </div>
                                </div>
                                @error('max_coupon_discount_amount') 
                                    <span class="text-red-400 text-xs flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Maximum Discount Percentage -->
                            <div class="lg:col-span-2 space-y-3">
                                <label for="max_coupon_discount_percentage" class="block text-sm font-medium text-gray-300">
                                    الحد الأقصى لنسبة الخصم % 
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="max_coupon_discount_percentage"
                                           wire:model="max_coupon_discount_percentage"
                                           class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] text-white rounded-lg focus:border-primary/50 focus:ring-2 focus:ring-primary/20 transition-all duration-300 placeholder-gray-500"
                                           placeholder="25"
                                           min="0"
                                           max="100"
                                           step="0.01">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="ri-percent-line"></i>
                                    </div>
                                </div>
                                @error('max_coupon_discount_percentage') 
                                    <span class="text-red-400 text-xs flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Allow Coupon Stacking -->
                            <div class="lg:col-span-2 space-y-3">
                                <div class="flex items-center justify-between p-4 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                                            <i class="ri-stack-line text-primary"></i>
                                        </div>
                                        <div>
                                            <label for="allow_coupon_stacking" class="text-sm font-medium text-gray-300 cursor-pointer">
                                                السماح بتراكم الكوبونات 
                                            </label>
                                            <p class="text-xs text-gray-500">السماح باستخدام أكثر من كوبون في نفس الطلب</p>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <input type="checkbox" 
                                               id="allow_coupon_stacking"
                                               wire:model="allow_coupon_stacking"
                                               class="sr-only">
                                        <div class="toggle-switch w-12 h-6 bg-gray-600 rounded-full relative cursor-pointer transition-colors duration-300 {{ $allow_coupon_stacking ? 'bg-primary' : '' }}" 
                                             wire:click="$toggle('allow_coupon_stacking')">
                                            <div class="toggle-circle w-5 h-5 bg-white rounded-full absolute top-0.5 transition-transform duration-300 {{ $allow_coupon_stacking ? 'transform -translate-x-6' : 'right-0.5' }}"></div>
                                        </div>
                                    </div>
                                </div>
                                @error('allow_coupon_stacking') 
                                    <span class="text-red-400 text-xs flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Coupon Start Date -->
                            <div class="space-y-3">
                                <label for="coupon_start_date" class="block text-sm font-medium text-gray-300">
                                    تاريخ بداية الكوبون 
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="coupon_start_date"
                                           wire:model="coupon_start_date"
                                           class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] text-white rounded-lg focus:border-primary/50 focus:ring-2 focus:ring-primary/20 transition-all duration-300 coupon-date-input">
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="ri-calendar-line"></i>
                                    </div>
                                </div>
                                @error('coupon_start_date') 
                                    <span class="text-red-400 text-xs flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Coupon End Date -->
                            <div class="space-y-3">
                                <label for="coupon_end_date" class="block text-sm font-medium text-gray-300">
                                    تاريخ انتهاء الكوبون
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="coupon_end_date"
                                           wire:model="coupon_end_date"
                                           class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] text-white rounded-lg focus:border-primary/50 focus:ring-2 focus:ring-primary/20 transition-all duration-300 coupon-date-input">
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="ri-calendar-check-line"></i>
                                    </div>
                                </div>
                                @error('coupon_end_date') 
                                    <span class="text-red-400 text-xs flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="group relative overflow-hidden bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-black font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <div class="flex items-center gap-3">
                            <i class="ri-save-line text-lg group-hover:scale-110 transition-transform"></i>
                            <span>حفظ الإعدادات المتقدمة</span>
                        </div>
                        <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Sidebar -->
        <div class="w-1/3 space-y-6 max-h-screen overflow-y-auto pr-2">
            <!-- Quick Guide Card -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] px-6 py-4 border-b border-[#2a3548]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                            <i class="ri-information-line text-blue-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">دليل سريع</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="ri-money-dollar-circle-line text-primary text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-white text-sm">الحد الأدنى لقيمة الطلب</h4>
                            <p class="text-gray-400 text-xs">تحديد أقل مبلغ يجب أن يصل إليه الطلب لاستخدام الكوبون</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="ri-discount-percent-line text-green-400 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-white text-sm">الحد الأقصى للخصم</h4>
                            <p class="text-gray-400 text-xs">تحديد أقصى مبلغ أو نسبة خصم يمكن تطبيقها</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-purple-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="ri-stack-line text-purple-400 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-white text-sm">تراكم الكوبونات</h4>
                            <p class="text-gray-400 text-xs">السماح باستخدام عدة كوبونات في طلب واحد</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Best Practices Card -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] px-6 py-4 border-b border-[#2a3548]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                            <i class="ri-lightbulb-line text-emerald-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">أفضل الممارسات</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="ri-check-line text-emerald-400 text-sm"></i>
                            <span class="text-emerald-300 text-xs font-medium">نصيحة الخبراء</span>
                        </div>
                        <p class="text-gray-300 text-xs">ابدأ بحد أدنى منخفض للطلبات لتشجيع المزيد من العملاء على الشراء</p>
                    </div>
                    <div class="p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="ri-alert-line text-yellow-400 text-sm"></i>
                            <span class="text-yellow-300 text-xs font-medium">تحذير مهم</span>  
                        </div>
                        <p class="text-gray-300 text-xs">تجنب تفعيل تراكم الكوبونات إذا كنت تقدم خصومات كبيرة</p>
                    </div>
                    <div class="p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="ri-calendar-line text-blue-400 text-sm"></i>
                            <span class="text-blue-300 text-xs font-medium">إدارة التواريخ</span>
                        </div>
                        <p class="text-gray-300 text-xs">حدد تواريخ واضحة للبداية والنهاية لتجنب الاستخدام المفرط</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] px-6 py-4 border-b border-[#2a3548]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center">
                            <i class="ri-bar-chart-line text-orange-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">إحصائيات سريعة</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                            <div class="text-2xl font-bold text-primary mb-1">73%</div>
                            <div class="text-xs text-gray-400">معدل استخدام الكوبونات</div>
                        </div>
                        <div class="text-center p-3 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                            <div class="text-2xl font-bold text-secondary mb-1">45%</div>
                            <div class="text-xs text-gray-400">زيادة في المبيعات</div>
                        </div>
                        <div class="text-center p-3 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                            <div class="text-2xl font-bold text-green-400 mb-1">28%</div>
                            <div class="text-xs text-gray-400">عملاء جدد</div>
                        </div>
                        <div class="text-center p-3 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                            <div class="text-2xl font-bold text-blue-400 mb-1">156</div>
                            <div class="text-xs text-gray-400">كوبونات نشطة</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Examples Card -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] px-6 py-4 border-b border-[#2a3548]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                            <i class="ri-example-line text-purple-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white">أمثلة الاستخدام</h3>
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    <div class="p-3 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-4 h-4 rounded bg-primary/30"></div>
                            <span class="text-white text-xs font-medium">للعملاء الجدد</span>
                        </div>
                        <p class="text-gray-400 text-xs">حد أدنى: 50 ريال | خصم: 15%</p>
                    </div>
                    <div class="p-3 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-4 h-4 rounded bg-green-500/30"></div>
                            <span class="text-white text-xs font-medium">عروض الجمعة البيضاء</span>
                        </div>
                        <p class="text-gray-400 text-xs">حد أدنى: 200 ريال | خصم: 30%</p>
                    </div>
                    <div class="p-3 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-4 h-4 rounded bg-purple-500/30"></div>
                            <span class="text-white text-xs font-medium">للعملاء المميزين</span>
                        </div>
                        <p class="text-gray-400 text-xs">تراكم مفعل | خصم: 25%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Internal Styles -->
    <style>
        /* Custom toggle switch styling */
        .toggle-switch.checked {
            background-color: var(--primary);
        }
        
        /* Hide date input icons on webkit browsers for cleaner look */
        .coupon-date-input::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }

        /* Custom scrollbar for consistency */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(42, 53, 72, 0.3);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            opacity: 0.8;
        }

        /* Input focus effects */
        input:focus {
            outline: none;
        }

        /* Toggle animation */
        .toggle-circle {
            transition: all 0.3s ease;
        }
        
        /* Product dropdown enhancements */
        .product-dropdown-item {
            transition: all 0.2s ease;
        }
        
        .product-dropdown-item:hover {
            transform: translateX(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Search input styling */
        .product-search-input::placeholder {
            color: rgba(156, 163, 175, 0.7);
        }
        
        /* Dropdown animations */
        .dropdown-enter {
            animation: dropdown-fade-in 0.2s ease-out;
        }
        
        @keyframes dropdown-fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        /* Custom scrollbar for dropdown */
        .product-dropdown-list::-webkit-scrollbar {
            width: 4px;
        }
        
        .product-dropdown-list::-webkit-scrollbar-track {
            background: rgba(42, 53, 72, 0.2);
            border-radius: 2px;
        }
        
        .product-dropdown-list::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }
    </style>
</div>
