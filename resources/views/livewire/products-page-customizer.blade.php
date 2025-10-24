<div class="p-6 space-y-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">تخصيص صفحة المنتجات</h1>
            <p class="text-gray-400 mt-1">قم بتخصيص مظهر وخصائص صفحة المنتجات</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="resetToDefaults" 
                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors">
                إعادة تعيين
            </button>
            <button wire:click="previewChanges" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors">
                معاينة
            </button>
            <button wire:click="saveSettings" 
                class="bg-primary hover:bg-primary/90 text-[#0f172a] px-4 py-2 rounded-md transition-colors font-medium">
                حفظ التغييرات
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left Column -->
        <div class="space-y-6">
            
            <!-- Page Header Settings -->
            <div class="section-card p-6">
                <div class="section-header pb-4 mb-4">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="ri-layout-top-line text-primary"></i>
                        إعدادات رأس الصفحة
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">عرض رأس الصفحة</label>
                        <input type="checkbox" wire:model.live="showPageHeader" class="toggle-switch">
                    </div>
                    
                    @if($showPageHeader)
                        <div class="space-y-3 bg-[#111827] p-4 rounded-md">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">عنوان الصفحة</label>
                                <input type="text" wire:model.live="pageTitle" 
                                    class="custom-input p-3 rounded-md w-full" 
                                    placeholder="عنوان الصفحة">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">العنوان الفرعي</label>
                                <input type="text" wire:model.live="pageSubtitle" 
                                    class="custom-input p-3 rounded-md w-full" 
                                    placeholder="العنوان الفرعي">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-4">صورة الخلفية</label>
                                
                                <!-- Enhanced File Upload Section -->
                                <div class="space-y-4">
                                    <!-- Image Preview Section -->
                                    @if($headerImageFile)
                                        <div class="p-4 bg-green-900 rounded-lg border border-green-500">
                                            <h4 class="text-green-400 font-bold mb-3 flex items-center gap-2">
                                                <i class="ri-check-circle-line"></i>
                                                تم رفع ملف جديد
                                            </h4>
                                            <div class="relative">
                                                <div class="w-full h-40 bg-gray-800 rounded-lg overflow-hidden border-2 border-green-500">
                                                    <img src="{{ $headerImageFile->temporaryUrl() }}" 
                                                        alt="Header Preview" 
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <button wire:click="removeHeaderImage" 
                                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition-colors shadow-lg">
                                                    <i class="ri-delete-bin-line text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif($headerImage)
                                        <div class="p-4 bg-blue-900 rounded-lg border border-blue-500">
                                            <h4 class="text-blue-400 font-bold mb-3 flex items-center gap-2">
                                                <i class="ri-image-line"></i>
                                                صورة محفوظة موجودة
                                            </h4>
                                            <div class="relative">
                                                <div class="w-full h-40 bg-gray-800 rounded-lg overflow-hidden border-2 border-blue-500">
                                                    <img src="{{ asset('storage/'.$headerImage) }}" 
                                                        alt="Header Preview" 
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <button wire:click="removeHeaderImage" 
                                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition-colors shadow-lg">
                                                    <i class="ri-delete-bin-line text-sm"></i>
                                                </button>
                                                <div class="absolute bottom-2 left-2 bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                                    {{ basename($headerImage) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Styled File Upload Area -->
                                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center transition-all duration-200 hover:border-primary hover:bg-primary/5">
                                        <div class="space-y-4">
                                            <!-- Upload Icon -->
                                            <div class="mx-auto w-20 h-20 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center">
                                                <i class="ri-upload-cloud-2-line text-3xl text-primary"></i>
                                            </div>
                                            
                                            <!-- Upload Text -->
                                            <div class="space-y-2">
                                                <h4 class="text-lg font-semibold text-gray-200">رفع صورة الخلفية</h4>
                                                <p class="text-gray-400 text-sm">اختر صورة لاستخدامها كخلفية لرأس الصفحة</p>
                                                <p class="text-gray-500 text-xs">PNG, JPG, GIF حتى 2MB</p>
                                            </div>
                                            
                                            <!-- File Input -->
                                            <div class="space-y-3">
                                                <input type="file" 
                                                    wire:model.live="headerImageFile" 
                                                    accept="image/*" 
                                                    class="hidden"
                                                    id="headerImageInput">
                                                
                                                <button type="button" 
                                                    onclick="document.getElementById('headerImageInput').click()"
                                                    class="bg-primary hover:bg-primary/90 text-[#0f172a] px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center gap-2">
                                                    <i class="ri-folder-open-line"></i>
                                                    اختر ملف
                                                </button>
                                                
                                                <!-- Loading indicator -->
                                                <div wire:loading wire:target="headerImageFile" class="text-primary mt-3">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <i class="ri-loader-4-line animate-spin text-xl"></i>
                                                        <span class="font-medium">جاري رفع الصورة...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Error Messages -->
                                    @error('headerImageFile')
                                        <div class="text-red-400 text-sm mt-3 p-3 bg-red-900/20 rounded-lg border border-red-500/30">
                                            <div class="flex items-center gap-2">
                                                <i class="ri-error-warning-line"></i>
                                                <span>{{ $message }}</span>
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Discount Timer Settings -->
            <div class="section-card p-6">
                <div class="section-header pb-4 mb-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="ri-timer-line text-primary"></i>
                            مؤقت العروض والخصومات
                        </h3>
                        <input type="checkbox" wire:model.live="showDiscountTimer" class="toggle-switch">
                    </div>
                </div>
                
                <!-- Active Timer Display -->
                @if($showDiscountTimer)
                    <div class="p-6 bg-gradient-to-r from-red-500 to-pink-500 rounded-xl text-white text-center shadow-lg">
                        <div class="text-lg font-semibold mb-4">{{ $discountText ?: 'عرض خاص - خصم حتى 50%!' }}</div>
                        <div class="flex justify-center items-center gap-4 text-xl font-bold">
                            <div class="bg-black/30 backdrop-blur-sm px-4 py-3 rounded-lg min-w-[70px]">
                                <span id="days" class="block text-2xl">05</span>
                                <div class="text-xs font-medium opacity-90">أيام</div>
                            </div>
                            <div class="text-white/60">:</div>
                            <div class="bg-black/30 backdrop-blur-sm px-4 py-3 rounded-lg min-w-[70px]">
                                <span id="hours" class="block text-2xl">12</span>
                                <div class="text-xs font-medium opacity-90">ساعات</div>
                            </div>
                            <div class="text-white/60">:</div>
                            <div class="bg-black/30 backdrop-blur-sm px-4 py-3 rounded-lg min-w-[70px]">
                                <span id="minutes" class="block text-2xl">34</span>
                                <div class="text-xs font-medium opacity-90">دقائق</div>
                            </div>
                            <div class="text-white/60">:</div>
                            <div class="bg-black/30 backdrop-blur-sm px-4 py-3 rounded-lg min-w-[70px]">
                                <span id="seconds" class="block text-2xl">56</span>
                                <div class="text-xs font-medium opacity-90">ثواني</div>
                            </div>
                        </div>
                        <div class="mt-4 text-sm opacity-90">
                            <i class="ri-fire-line"></i> أسرع قبل انتهاء العرض!
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="ri-timer-line text-4xl mb-2"></i>
                        <p>لا يوجد مؤقت خصم نشط حالياً</p>
                        <p class="text-sm mt-1">انقر على "تفعيل" لإظهار المؤقت</p>
                    </div>
                @endif
            </div>

            <!-- Coupon Banner Settings -->
            <div class="section-card p-6">
                <div class="section-header pb-4 mb-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="ri-coupon-line text-primary"></i>
                            كوبون الخصم النشط
                        </h3>
                        <input type="checkbox" wire:model.live="showCouponBanner" class="toggle-switch">
                    </div>
                </div>
                
                <!-- Active Coupon Display -->
                @if($showCouponBanner)
                    <div class="relative p-6 rounded-xl text-white shadow-lg overflow-hidden" 
                        style="background: linear-gradient(135deg, {{ $couponBackgroundColor ?: '#6366f1' }}, {{ $couponBackgroundColor ? $couponBackgroundColor.'cc' : '#8b5cf6' }});">
                        
                        <!-- Decorative Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 left-0 w-full h-full" 
                                style="background-image: radial-gradient(circle at 25px 25px, white 2px, transparent 2px); background-size: 50px 50px;"></div>
                        </div>
                        
                        <!-- Coupon Content -->
                        <div class="relative flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-coupon-2-line text-xl"></i>
                                    <span class="text-sm font-medium opacity-90">كوبون خصم</span>
                                </div>
                                <div class="text-lg font-bold mb-1">{{ $couponText ?: 'احصل على خصم 25% على جميع المنتجات' }}</div>
                                <div class="text-sm opacity-90">انقر للنسخ واستخدمه عند الدفع</div>
                            </div>
                            
                            <!-- Coupon Code -->
                            <div class="bg-white/20 backdrop-blur-sm border-2 border-white/30 px-6 py-3 rounded-lg cursor-pointer hover:bg-white/30 transition-all duration-200 group">
                                <div class="text-center">
                                    <div class="text-xs font-medium opacity-90 mb-1">كود الخصم</div>
                                    <div class="text-lg font-bold font-mono tracking-wider group-hover:scale-105 transition-transform">
                                        {{ $couponCode ?: 'SAVE25' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Copy Indicator -->
                        <div class="absolute bottom-2 right-2 text-xs opacity-60">
                            <i class="ri-file-copy-line"></i> انقر للنسخ
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="ri-coupon-line text-4xl mb-2"></i>
                        <p>لا يوجد كوبون خصم نشط حالياً</p>
                        <p class="text-sm mt-1">انقر على "تفعيل" لإظهار الكوبون</p>
                    </div>
                @endif
            </div>

            
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            
            <!-- Filter Settings -->
            <div class="section-card p-6">
                <div class="section-header pb-4 mb-4">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="ri-filter-line text-primary"></i>
                        إعدادات الفلاتر والبحث
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">عرض البحث</label>
                        <input type="checkbox" wire:model.live="showSearch" class="toggle-switch">
                    </div>
                    
                    @if($showSearch)
                        <div class="bg-[#111827] p-3 rounded-md">
                            <label class="block text-sm font-medium text-gray-300 mb-2">نص البحث التوضيحي</label>
                            <input type="text" wire:model.live="searchPlaceholder" 
                                class="custom-input p-2 rounded-md w-full text-sm">
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">فلتر السعر</label>
                            <input type="checkbox" wire:model.live="showPriceFilter" class="toggle-switch scale-75">
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">فلتر الفئات</label>
                            <input type="checkbox" wire:model.live="showCategoryFilter" class="toggle-switch scale-75">
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">فلتر العلامات</label>
                            <input type="checkbox" wire:model.live="showBrandFilter" class="toggle-switch scale-75">
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">فلتر التقييم</label>
                            <input type="checkbox" wire:model.live="showRatingFilter" class="toggle-switch scale-75">
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">عرض خيارات الترتيب</label>
                        <input type="checkbox" wire:model.live="showSortOptions" class="toggle-switch">
                    </div>
                    
                    @if($showSortOptions)
                        <div class="bg-[#111827] p-3 rounded-md">
                            <label class="block text-sm font-medium text-gray-300 mb-2">الترتيب الافتراضي</label>
                            <select wire:model.live="defaultSort" class="custom-input p-2 rounded-md w-full text-sm">
                                <option value="latest">الأحدث</option>
                                <option value="oldest">الأقدم</option>
                                <option value="price_low">السعر: من الأقل للأعلى</option>
                                <option value="price_high">السعر: من الأعلى للأقل</option>
                                <option value="name_asc">الاسم: أ - ي</option>
                                <option value="name_desc">الاسم: ي - أ</option>
                                <option value="rating">الأعلى تقييماً</option>
                            </select>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Display Settings -->
            <div class="section-card p-6">
                <div class="section-header pb-4 mb-4">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="ri-shopping-bag-line text-primary"></i>
                        إعدادات عرض المنتجات
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">نمط كرت المنتج</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button wire:click="$set('productCardStyle', 'modern')" 
                                class="p-2 rounded-md border text-center transition-colors text-xs
                                {{ $productCardStyle === 'modern' ? 'border-primary bg-primary/10 text-primary' : 'border-gray-600 text-gray-300 hover:border-gray-500' }}">
                                عصري
                            </button>
                            <button wire:click="$set('productCardStyle', 'classic')" 
                                class="p-2 rounded-md border text-center transition-colors text-xs
                                {{ $productCardStyle === 'classic' ? 'border-primary bg-primary/10 text-primary' : 'border-gray-600 text-gray-300 hover:border-gray-500' }}">
                                كلاسيكي
                            </button>
                            <button wire:click="$set('productCardStyle', 'minimal')" 
                                class="p-2 rounded-md border text-center transition-colors text-xs
                                {{ $productCardStyle === 'minimal' ? 'border-primary bg-primary/10 text-primary' : 'border-gray-600 text-gray-300 hover:border-gray-500' }}">
                                بسيط
                            </button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">عرض التقييم</label>
                            <input type="checkbox" wire:model.live="showProductRating" class="toggle-switch scale-75">
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">عرض الشارات</label>
                            <input type="checkbox" wire:model.live="showProductBadges" class="toggle-switch scale-75">
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">المعاينة السريعة</label>
                            <input type="checkbox" wire:model.live="showQuickView" class="toggle-switch scale-75">
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-300">قائمة الأمنيات</label>
                            <input type="checkbox" wire:model.live="showWishlist" class="toggle-switch scale-75">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">عدد المنتجات في الصفحة</label>
                        <select wire:model.live="productsPerPage" class="custom-input p-3 rounded-md w-full">
                            <option value="6">6 منتجات</option>
                            <option value="9">9 منتجات</option>
                            <option value="12">12 منتج</option>
                            <option value="18">18 منتج</option>
                            <option value="24">24 منتج</option>
                            <option value="36">36 منتج</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">نمط الترقيم</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button wire:click="$set('paginationStyle', 'numbers')" 
                                class="p-2 rounded-md border text-center transition-colors text-sm
                                {{ $paginationStyle === 'numbers' ? 'border-primary bg-primary/10 text-primary' : 'border-gray-600 text-gray-300 hover:border-gray-500' }}">
                                أرقام
                            </button>
                            <button wire:click="$set('paginationStyle', 'loadmore')" 
                                class="p-2 rounded-md border text-center transition-colors text-sm
                                {{ $paginationStyle === 'loadmore' ? 'border-primary bg-primary/10 text-primary' : 'border-gray-600 text-gray-300 hover:border-gray-500' }}">
                                تحميل المزيد
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Color Scheme Settings -->
            <div class="section-card p-6">
                <div class="section-header pb-4 mb-4">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="ri-palette-line text-primary"></i>
                        ألوان الصفحة
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">اللون الرئيسي</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model.live="primaryColor" class="color-picker">
                                <input type="text" wire:model.live="primaryColor" 
                                    class="custom-input p-2 rounded-md flex-1 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">اللون الثانوي</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model.live="secondaryColor" class="color-picker">
                                <input type="text" wire:model.live="secondaryColor" 
                                    class="custom-input p-2 rounded-md flex-1 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">لون التمييز</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model.live="accentColor" class="color-picker">
                                <input type="text" wire:model.live="accentColor" 
                                    class="custom-input p-2 rounded-md flex-1 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">لون الخلفية</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model.live="backgroundColor" class="color-picker">
                                <input type="text" wire:model.live="backgroundColor" 
                                    class="custom-input p-2 rounded-md flex-1 text-sm">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Color Preview -->
                    <div class="mt-4 p-4 rounded-lg border border-gray-600">
                        <div class="text-sm font-medium text-gray-300 mb-3">معاينة الألوان</div>
                        <div class="flex gap-2">
                            <div class="w-8 h-8 rounded-md border" style="background-color: {{ $primaryColor }}"></div>
                            <div class="w-8 h-8 rounded-md border" style="background-color: {{ $secondaryColor }}"></div>
                            <div class="w-8 h-8 rounded-md border" style="background-color: {{ $accentColor }}"></div>
                            <div class="w-8 h-8 rounded-md border" style="background-color: {{ $backgroundColor }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Preview Section -->
   
</div>

<script>
    // Timer Animation
    function updateTimer() {
        const now = new Date().getTime();
        const endDate = new Date(@json($discountEndDate)).getTime();
        const distance = endDate - now;
        
        if (distance > 0) {
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }
    }
    
    // Update timer every second
    setInterval(updateTimer, 1000);
    updateTimer();
    
    // Toast notification function
    function showToast(message, type = 'success') {
        // Remove existing toast if any
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        if (type === 'success') {
            toast.className += ' bg-green-600 text-white';
            toast.innerHTML = `<i class="ri-check-line mr-2"></i>${message}`;
        } else if (type === 'error') {
            toast.className += ' bg-red-600 text-white';
            toast.innerHTML = `<i class="ri-error-warning-line mr-2"></i>${message}`;
        } else if (type === 'info') {
            toast.className += ' bg-blue-600 text-white';
            toast.innerHTML = `<i class="ri-information-line mr-2"></i>${message}`;
        }
        
        document.body.appendChild(toast);
        
        // Show toast
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Hide toast after 4 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 4000);
    }
    
    // Listen for Livewire events
    document.addEventListener('livewire:init', () => {
        // Settings saved successfully
        Livewire.on('settings-saved', (event) => {
            showToast(event[0].message || 'تم حفظ الإعدادات بنجاح!', 'success');
        });
        
        // Settings save error
        Livewire.on('settings-error', (event) => {
            showToast(event[0].message || 'حدث خطأ أثناء حفظ الإعدادات!', 'error');
        });
        
        // Settings reset
        Livewire.on('settings-reset', (event) => {
            showToast(event[0].message || 'تم إعادة تعيين الإعدادات!', 'info');
        });
        
        // Preview updated
        Livewire.on('preview-updated', (event) => {
            showToast('تم تحديث المعاينة!', 'info');
        });
    });
</script>

<!-- Alpine.js for drag and drop functionality -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
