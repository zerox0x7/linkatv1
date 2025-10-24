  <!-- Main Content -->
        <div class=" w-[calc(100%-16rem)] p-6">
            <!-- Header -->
            <!-- @include('themes.admin.parts.header') -->
            <!-- Progress Steps -->
           <div class="flex justify-between items-center mb-8 px-4">
                <div class="flex flex-col items-center cursor-pointer" data-step="1">
                    <div id="step1-circle"
                        class="w-8 h-8 rounded-full bg-primary text-black flex items-center justify-center mb-2">
                        1
                    </div>
                    <span id="step1-label" class="text-sm text-primary">المعلومات الأساسية</span>
                </div>
                <div class="h-0.5 flex-1 bg-[#1a2234] mx-2 relative">
                    <div id="progress1" class="absolute top-0 left-0 h-full w-0 bg-primary transition-all duration-300">
                    </div>
                </div>
                <div class="flex flex-col items-center cursor-pointer" data-step="2">
                    <div id="step2-circle"
                        class="w-8 h-8 rounded-full bg-[#1a2234] text-white flex items-center justify-center mb-2">
                        2
                    </div>
                    <span id="step2-label" class="text-sm text-gray-400">الوصف والصور</span>
                </div>
                <div class="h-0.5 flex-1 bg-[#1a2234] mx-2 relative">
                    <div id="progress2" class="absolute top-0 left-0 h-full w-0 bg-primary transition-all duration-300">
                    </div>
                </div>
                <div class="flex flex-col items-center cursor-pointer" data-step="3">
                    <div id="step3-circle"
                        class="w-8 h-8 rounded-full bg-[#1a2234] text-white flex items-center justify-center mb-2">
                        3
                    </div>
                    <span id="step3-label" class="text-sm text-gray-400">تحسين محركات البحث</span>
                </div>
                <div class="h-0.5 flex-1 bg-[#1a2234] mx-2 relative">
                    <div id="progress3" class="absolute top-0 left-0 h-full w-0 bg-primary transition-all duration-300">
                    </div>
                </div>
                <div class="flex flex-col items-center cursor-pointer" data-step="4">
                    <div id="step4-circle"
                        class="w-8 h-8 rounded-full bg-[#1a2234] text-white flex items-center justify-center mb-2">
                        4
                    </div>
                    <span id="step4-label" class="text-sm text-gray-400">إعدادات إضافية</span>
                </div>
            </div>
            <!-- Form Container -->
            <div wire:ignore class="grid grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="col-span-2 space-y-6">
                    <!-- Step 1: Basic Info Card -->
                    <div wire:ignore.self id="step1-content" class="step-content bg-[#1a2234] rounded-lg p-6">
                        <h2 class="text-lg font-semibold mb-6 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                <i class="ri-information-line text-black text-sm"></i>
                            </div>
                            معلومات المنتج الأساسية
                        </h2>

                        <!-- Product Name Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                    <i class="ri-product-hunt-line text-blue-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">تفاصيل المنتج</h3>
                                    <p class="text-xs text-gray-400">الاسم والمعرف الفريد للمنتج</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-text text-primary text-sm"></i>
                                        اسم المنتج
                                    </label>
                                    <input id="productName" type="text"
                                        class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558]"
                                        placeholder="أدخل اسم المنتج الجذاب..." required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-barcode-line text-primary text-sm"></i>
                                        رمز المنتج (SKU)
                                    </label>
                                    <input id="productSKU" type="text"
                                        class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558]"
                                        placeholder="مثال: PRD-2024-001" />
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                                    <i class="ri-money-dollar-circle-line text-green-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">التسعير</h3>
                                    <p class="text-xs text-gray-400">تحديد أسعار المنتج والعروض</p>
                                </div>
                            </div>

                            <!-- Currency Selector -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-300 mb-3 flex items-center gap-2">
                                    <i class="ri-money-cny-circle-line text-primary text-sm"></i>
                                    اختر العملة
                                </label>
                                <div
                                    class="flex items-center gap-2 p-3 bg-[#0f1623] rounded-lg border border-[#2a3548]">
                                    <!-- Saudi Riyal -->
                                    <button type="button"
                                        class="currency-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-[#3a4558] hover:border-primary/50 transition-all duration-200 group"
                                        data-currency="SAR" data-symbol="ر.س">
                                        <div
                                            class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center text-white text-xs font-bold">
                                            <span>🇸🇦</span>
                                        </div>
                                        <span class="text-sm text-gray-300 group-hover:text-white">SAR</span>
                                    </button>

                                    <!-- US Dollar -->
                                    <button type="button"
                                        class="currency-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-[#3a4558] hover:border-primary/50 transition-all duration-200 group active bg-primary/10 border-primary"
                                        data-currency="USD" data-symbol="$">
                                        <div
                                            class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                            <span>🇺🇸</span>
                                        </div>
                                        <span class="text-sm text-primary font-medium">USD</span>
                                    </button>

                                    <!-- Bitcoin -->
                                    <button type="button"
                                        class="currency-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-[#3a4558] hover:border-primary/50 transition-all duration-200 group"
                                        data-currency="BTC" data-symbol="₿">
                                        <div
                                            class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-white text-xs">
                                            <i class="ri-bit-coin-line"></i>
                                        </div>
                                        <span class="text-sm text-gray-300 group-hover:text-white">BTC</span>
                                    </button>

                                    <!-- Qatar Riyal -->
                                    <button type="button"
                                        class="currency-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-[#3a4558] hover:border-primary/50 transition-all duration-200 group"
                                        data-currency="QAR" data-symbol="ر.ق">
                                        <div
                                            class="w-6 h-6 rounded-full bg-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                            <span>🇶🇦</span>
                                        </div>
                                        <span class="text-sm text-gray-300 group-hover:text-white">QAR</span>
                                    </button>

                                    <!-- Egyptian Pound -->
                                    <button type="button"
                                        class="currency-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-[#3a4558] hover:border-primary/50 transition-all duration-200 group"
                                        data-currency="EGP" data-symbol="ج.م">
                                        <div
                                            class="w-6 h-6 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold">
                                            <span>🇪🇬</span>
                                        </div>
                                        <span class="text-sm text-gray-300 group-hover:text-white">EGP</span>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-price-tag-line text-primary text-sm"></i>
                                        السعر الأصلي
                                    </label>
                                    <div class="relative">
                                        <input id="originalPrice" type="number" step="0.01"
                                            class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 pr-12 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558]"
                                            placeholder="0.00" required />
                                        <div id="originalPriceCurrency"
                                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 bg-[#2a3548] px-2 py-1 rounded text-sm">
                                            $
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-price-tag-3-line text-primary text-sm"></i>
                                        السعر الحالي
                                    </label>
                                    <div class="relative">
                                        <input id="currentPrice" type="number" step="0.01"
                                            class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 pr-12 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558]"
                                            placeholder="0.00" required />
                                        <div id="currentPriceCurrency"
                                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 bg-[#2a3548] px-2 py-1 rounded text-sm">
                                            $
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Configuration Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                    <i class="ri-settings-4-line text-purple-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">إعدادات المنتج</h3>
                                    <p class="text-xs text-gray-400">النوع والحالة والتصنيف</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-stack-line text-primary text-sm"></i>
                                        نوع المنتج
                                    </label>
                                    <div class="relative">
                                        <button id="productTypeBtn" type="button"
                                            class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white flex justify-between items-center hover:border-[#3a4558] focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 group">
                                            <span id="selectedProductType" class="flex items-center gap-2">
                                                <i
                                                    class="ri-question-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                                اختر نوع المنتج
                                            </span>
                                            <i
                                                class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transition-all duration-200 group-hover:rotate-180"></i>
                                        </button>
                                        <div id="productTypeDropdown"
                                            class="absolute z-10 w-full mt-2 bg-[#0f1623] border-2 border-[#2a3548] rounded-lg shadow-xl hidden overflow-hidden">
                                            <div class="p-2">
                                                <div class="p-3 hover:bg-[#1a2234] rounded-lg cursor-pointer transition-all duration-200 flex items-center gap-3 group"
                                                    data-value="account">
                                                    <i
                                                        class="ri-user-line text-blue-400 group-hover:text-primary transition-colors"></i>
                                                    <span class="group-hover:text-white transition-colors">حساب</span>
                                                </div>
                                                <div class="p-3 hover:bg-[#1a2234] rounded-lg cursor-pointer transition-all duration-200 flex items-center gap-3 group"
                                                    data-value="digital">
                                                    <i
                                                        class="ri-smartphone-line text-green-400 group-hover:text-primary transition-colors"></i>
                                                    <span class="group-hover:text-white transition-colors">منتج
                                                        رقمي</span>
                                                </div>
                                                <div class="p-3 hover:bg-[#1a2234] rounded-lg cursor-pointer transition-all duration-200 flex items-center gap-3 group"
                                                    data-value="custom">
                                                    <i
                                                        class="ri-tools-line text-purple-400 group-hover:text-primary transition-colors"></i>
                                                    <span class="group-hover:text-white transition-colors">مخصص</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-toggle-line text-primary text-sm"></i>
                                        الحالة
                                    </label>
                                    <div class="relative">
                                        <button id="statusBtn" type="button"
                                            class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white flex justify-between items-center hover:border-[#3a4558] focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 group">
                                            <span id="selectedStatus" class="flex items-center gap-2">
                                                <i
                                                    class="ri-question-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                                اختر الحالة
                                            </span>
                                            <i
                                                class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transition-all duration-200 group-hover:rotate-180"></i>
                                        </button>
                                        <div id="statusDropdown"
                                            class="absolute z-10 w-full mt-2 bg-[#0f1623] border-2 border-[#2a3548] rounded-lg shadow-xl hidden overflow-hidden">
                                            <div class="p-2">
                                                <div class="p-3 hover:bg-[#1a2234] rounded-lg cursor-pointer transition-all duration-200 flex items-center gap-3 group"
                                                    data-value="active">
                                                    <div
                                                        class="w-3 h-3 rounded-full bg-green-500 shadow-lg shadow-green-500/30">
                                                    </div>
                                                    <span class="group-hover:text-white transition-colors">نشط</span>
                                                </div>
                                                <div class="p-3 hover:bg-[#1a2234] rounded-lg cursor-pointer transition-all duration-200 flex items-center gap-3 group"
                                                    data-value="inactive">
                                                    <div
                                                        class="w-3 h-3 rounded-full bg-gray-500 shadow-lg shadow-gray-500/30">
                                                    </div>
                                                    <span class="group-hover:text-white transition-colors">غير
                                                        نشط</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-folder-line text-primary text-sm"></i>
                                        التصنيف
                                    </label>
                                    <div class="relative">
                                        <button id="categoryBtn" type="button"
                                            class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white flex justify-between items-center hover:border-[#3a4558] focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 group">
                                            <span id="selectedCategory" class="flex items-center gap-2">
                                                <i
                                                    class="ri-question-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                                اختر التصنيف
                                            </span>
                                            <i
                                                class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transition-all duration-200 group-hover:rotate-180"></i>
                                        </button>
                                        <div id="categoryDropdown"
                                            class="absolute z-10 w-full mt-2 bg-[#0f1623] border-2 border-[#2a3548] rounded-lg shadow-xl hidden overflow-hidden">
                                            <div class="p-2">
                                                <div class="relative mb-3">
                                                    <input type="text" id="categorySearch"
                                                        class="w-full bg-[#1a2234] border border-[#3a4558] rounded-lg p-3 pr-10 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-sm transition-all duration-200"
                                                        placeholder="بحث عن تصنيف..." />
                                                    <div
                                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                                        <i class="ri-search-line"></i>
                                                    </div>
                                                </div>
                                                <div class="max-h-48 overflow-y-auto custom-scrollbar space-y-1" id="categoryList">
                                                    @if($categories->count() > 0)
                                                        @foreach($categories as $category)
                                                            <div class="p-3 hover:bg-[#1a2234] rounded-lg cursor-pointer transition-all duration-200 flex items-center gap-3 group category-item"
                                                                data-value="{{ $category->id }}"
                                                                data-name="{{ $category->name }}"
                                                                data-search="{{ strtolower($category->name) }}">
                                                                <i class="{{ $category->icon ?? 'ri-folder-line' }} text-primary group-hover:text-primary transition-colors"></i>
                                                                <span class="group-hover:text-white transition-colors">{{ $category->name }}</span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="p-3 text-center text-gray-400">
                                                            <i class="ri-folder-open-line text-2xl mb-2"></i>
                                                            <p class="text-sm">لا توجد تصنيفات متاحة</p>
                                                            <p class="text-xs">يرجى إضافة تصنيفات أولاً</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Link Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                    <i class="ri-link text-indigo-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">الرابط المخصص</h3>
                                    <p class="text-xs text-gray-400">تخصيص رابط المنتج في المتجر</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-global-line text-primary text-sm"></i>
                                        رابط المنتج
                                    </label>
                                    <div
                                        class="flex rounded-lg overflow-hidden border-2 border-[#2a3548] hover:border-[#3a4558] focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/50 transition-all duration-200">
                                        <div
                                            class="bg-[#2a3548] px-4 py-4 text-gray-300 text-sm font-medium flex items-center gap-2 border-l border-[#3a4558]">
                                            <i class="ri-store-line text-primary"></i>
                                            yourstore.com/product/
                                        </div>
                                        <input type="text" id="productSlug"
                                            class="flex-1 bg-[#0f1623] p-4 text-white placeholder-gray-400 outline-none"
                                            placeholder="product-slug" />
                                    </div>
                                </div>

                                <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-indigo-500/30">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 flex items-center justify-center text-indigo-400 mt-0.5">
                                            <i class="ri-information-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-300 leading-relaxed">
                                                سيتم إنشاء الرابط تلقائيًا من اسم المنتج، أو يمكنك تخصيصه لتحسين محركات
                                                البحث.
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                استخدم الأحرف الإنجليزية والأرقام والشرطات فقط
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden input for category ID -->
                        <input type="hidden" id="selectedCategoryId" name="category_id" value="">

                        <!-- Navigation Button -->
                        <div class="flex justify-end pt-6 border-t border-[#2a3548]">
                            <button id="nextToStep2" type="button"
                                class="group flex items-center gap-2 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-black font-semibold px-8 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none"
                                disabled>
                                <span>التالي: الوصف والصور</span>
                                <i
                                    class="ri-arrow-left-line group-hover:translate-x-1 transition-transform duration-200"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Description and Images -->
                    <div id="step2-content" class="step-content bg-[#1a2234] rounded-lg p-6 hidden">
                        <h2 class="text-lg font-semibold mb-6 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                <i class="ri-image-line text-black text-sm"></i>
                            </div>
                            وصف المنتج والصور
                        </h2>

                        <!-- Product Description Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                    <i class="ri-file-text-line text-blue-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">وصف المنتج التفصيلي</h3>
                                    <p class="text-xs text-gray-400">اكتب وصفاً جذاباً ومفصلاً لمنتجك</p>
                                </div>
                            </div>

                            <!-- Rich Text Editor Toolbar -->
                            <div class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548] mb-4">
                                <div
                                    class="flex items-center gap-1 mb-3 p-2 bg-[#1a2234] rounded-lg border border-[#3a4558]">
                                    <div class="flex items-center gap-1 pr-2 border-l border-[#3a4558]">
                                        <button type="button"
                                            class="p-2 rounded hover:bg-[#2a3548] transition-all duration-200 text-gray-400 hover:text-white group">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-bold group-hover:scale-110 transition-transform"></i>
                                            </div>
                                        </button>
                                        <button type="button"
                                            class="p-2 rounded hover:bg-[#2a3548] transition-all duration-200 text-gray-400 hover:text-white group">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-italic group-hover:scale-110 transition-transform"></i>
                                            </div>
                                        </button>
                                        <button type="button"
                                            class="p-2 rounded hover:bg-[#2a3548] transition-all duration-200 text-gray-400 hover:text-white group">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-underline group-hover:scale-110 transition-transform"></i>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1 px-2 border-l border-[#3a4558]">
                                        <button type="button"
                                            class="p-2 rounded hover:bg-[#2a3548] transition-all duration-200 text-gray-400 hover:text-white group">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i
                                                    class="ri-list-unordered group-hover:scale-110 transition-transform"></i>
                                            </div>
                                        </button>
                                        <button type="button"
                                            class="p-2 rounded hover:bg-[#2a3548] transition-all duration-200 text-gray-400 hover:text-white group">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i
                                                    class="ri-list-ordered group-hover:scale-110 transition-transform"></i>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1 px-2">
                                        <button type="button"
                                            class="p-2 rounded hover:bg-[#2a3548] transition-all duration-200 text-gray-400 hover:text-white group">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-link group-hover:scale-110 transition-transform"></i>
                                            </div>
                                        </button>
                                        <button type="button"
                                            class="p-2 rounded hover:bg-[#2a3548] transition-all duration-200 text-gray-400 hover:text-white group">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-image-line group-hover:scale-110 transition-transform"></i>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <textarea id="productDescription"
                                    class="w-full bg-[#121827] border-2 border-[#2a3548] rounded-lg p-4 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558] outline-none min-h-[200px] resize-none"
                                    placeholder="اكتب وصفاً تفصيليًا وجذاباً لمنتجك هنا... 

              • اذكر المميزات الرئيسية
              • وضح كيفية الاستخدام
              • أضف أي تفاصيل مهمة للعملاء" required></textarea>
                            </div>

                            <!-- Description Tips -->
                            <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-blue-500/30">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center text-blue-400 mt-0.5">
                                        <i class="ri-lightbulb-line"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-300 leading-relaxed mb-2">
                                            <strong class="text-white">نصائح لكتابة وصف فعال:</strong>
                                        </p>
                                        <ul class="text-xs text-gray-400 space-y-1">
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                استخدم نقاط واضحة ومنظمة
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                اذكر الفوائد وليس المميزات فقط
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                استخدم كلمات مفتاحية مناسبة
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Product Image Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                                    <i class="ri-image-add-line text-green-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">الصورة الرئيسية للمنتج</h3>
                                    <p class="text-xs text-gray-400">صورة عالية الجودة تمثل المنتج بشكل واضح</p>
                                </div>
                            </div>

                            <div class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548]">
                                <div id="mainImageUpload"
                                    class="relative h-64 rounded-lg border-2 border-dashed border-[#3a4558] hover:border-primary/50 transition-all duration-300 cursor-pointer group bg-gradient-to-br from-[#1a2234] to-[#121827] hover:from-[#232b3e] hover:to-[#1a2234]">
                                    
                                    <!-- Default upload state -->
                                    <div id="uploadPrompt"
                                        class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                                        <div
                                            class="w-16 h-16 rounded-full bg-gradient-to-r from-primary/20 to-secondary/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                            <i
                                                class="ri-upload-cloud-2-line text-2xl text-primary group-hover:text-white transition-colors"></i>
                                        </div>
                                        <p
                                            class="text-white font-medium mb-2 group-hover:text-primary transition-colors">
                                            اسحب وأفلت الصورة هنا
                                        </p>
                                        <p class="text-gray-400 text-sm mb-3">
                                            أو انقر للتصفح واختيار الصورة
                                        </p>
                                        <div class="flex items-center gap-4 text-xs text-gray-500">
                                            <div class="flex items-center gap-1">
                                                <i class="ri-file-image-line"></i>
                                                <span>PNG, JPG, WEBP</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <i class="ri-file-line"></i>
                                                <span>حتى 5MB</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image preview state -->
                                    <div id="imagePreview" class="absolute inset-0 hidden">
                                        <img id="previewImg" src="" class="w-full h-full object-cover rounded-lg" />
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                            <div class="flex gap-2">
                                                <button type="button" id="changeImageBtn"
                                                    class="bg-primary hover:bg-primary/90 text-black px-4 py-2 rounded-lg transition-colors text-sm font-medium">
                                                    <i class="ri-image-edit-line mr-1"></i>
                                                    تغيير الصورة
                                                </button>
                                                <button type="button" id="removeImageBtn"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium">
                                                    <i class="ri-delete-bin-line mr-1"></i>
                                                    حذف
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Loading state -->
                                    <div id="uploadLoading" class="absolute inset-0 bg-[#1a2234] bg-opacity-90 flex items-center justify-center hidden">
                                        <div class="text-center">
                                            <div class="w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                                            <p class="text-sm text-gray-300">جاري رفع الصورة...</p>
                                        </div>
                                    </div>

                                    <!-- Hidden file input -->
                                    <input type="file" id="mainImageInput" wire:model="mainImage" 
                                           accept="image/jpeg,image/jpg,image/png,image/webp"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>
                            </div>

                            <!-- Image Requirements -->
                            <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-green-500/30 mt-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center text-green-400 mt-0.5">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-300 leading-relaxed mb-2">
                                            <strong class="text-white">متطلبات الصورة المثالية:</strong>
                                        </p>
                                        <ul class="text-xs text-gray-400 space-y-1">
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                أبعاد مُوصى بها: 1200x800 بكسل أو أكبر
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                خلفية بيضاء أو شفافة لأفضل عرض
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                المنتج يجب أن يكون واضحاً ومُضاءً جيداً
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-6 border-t border-[#2a3548]">
                            <button id="backToStep1"
                                class="group flex items-center gap-2 bg-[#232b3e] hover:bg-[#2a3548] px-6 py-3 rounded-xl transition-all duration-200 border border-[#3a4558] hover:border-[#4a5568]">
                                <i
                                    class="ri-arrow-right-line group-hover:-translate-x-1 transition-transform duration-200"></i>
                                <span>العودة: المعلومات الأساسية</span>
                            </button>
                            <button id="nextToStep3"
                                class="group flex items-center gap-2 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-black font-semibold px-8 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none"
                                disabled>
                                <span>التالي: تحسين محركات البحث</span>
                                <i
                                    class="ri-arrow-left-line group-hover:translate-x-1 transition-transform duration-200"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: SEO -->
                    <div id="step3-content" class="step-content bg-[#1a2234] rounded-lg p-6 hidden">
                        <h2 class="text-lg font-semibold mb-6 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                <i class="ri-search-line text-black text-sm"></i>
                            </div>
                            تحسين محركات البحث (SEO)
                        </h2>

                        <!-- SEO Title Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                    <i class="ri-h-1 text-blue-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">عنوان المنتج لمحركات البحث</h3>
                                    <p class="text-xs text-gray-400">العنوان الذي سيظهر في نتائج البحث</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-text text-primary text-sm"></i>
                                        عنوان SEO
                                    </label>
                                    <input id="seoTitle" type="text"
                                        class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558]"
                                        placeholder="عنوان جذاب ومحسن لمحركات البحث..." required />
                                    <div class="flex justify-between items-center mt-2">
                                        <span id="seoTitleCounter" class="text-xs text-gray-400">0/60</span>
                                        <div class="flex items-center gap-1 text-xs text-gray-500">
                                            <i class="ri-information-line"></i>
                                            <span>الطول المثالي: 50-60 حرف</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Title Tips -->
                            <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-blue-500/30 mt-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center text-blue-400 mt-0.5">
                                        <i class="ri-lightbulb-line"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-300 leading-relaxed mb-2">
                                            <strong class="text-white">نصائح لعنوان SEO فعال:</strong>
                                        </p>
                                        <ul class="text-xs text-gray-400 space-y-1">
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                ضع الكلمة المفتاحية في البداية
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                استخدم عنواناً واضحاً وجذاباً
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                تجنب التكرار المفرط للكلمات
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Keywords Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                                    <i class="ri-key-2-line text-green-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">الكلمات المفتاحية</h3>
                                    <p class="text-xs text-gray-400">كلمات مهمة تساعد في العثور على منتجك</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-hashtag text-primary text-sm"></i>
                                        الكلمات المفتاحية الرئيسية
                                    </label>
                                    <input id="seoKeywords" type="text"
                                        class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558]"
                                        placeholder="كلمة مفتاحية 1, كلمة مفتاحية 2, كلمة مفتاحية 3..." required />
                                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                        <i class="ri-separator"></i>
                                        استخدم الفواصل للفصل بين الكلمات المفتاحية
                                    </p>
                                </div>
                            </div>

                            <!-- Keywords Tips -->
                            <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-green-500/30 mt-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center text-green-400 mt-0.5">
                                        <i class="ri-search-2-line"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-300 leading-relaxed mb-2">
                                            <strong class="text-white">اختيار الكلمات المفتاحية:</strong>
                                        </p>
                                        <ul class="text-xs text-gray-400 space-y-1">
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                ابحث عن كلمات يبحث عنها العملاء
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                استخدم 3-5 كلمات مفتاحية رئيسية
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                اجمع بين الكلمات العامة والمتخصصة
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tags Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                    <i class="ri-price-tag-3-line text-purple-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">العلامات (Tags)</h3>
                                    <p class="text-xs text-gray-400">علامات تساعد في تصنيف وتنظيم المنتج</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-bookmark-line text-primary text-sm"></i>
                                        العلامات
                                    </label>
                                    <div id="tagsContainer"
                                        class="bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-3 min-h-16 flex flex-wrap gap-2 focus-within:ring-2 focus-within:ring-primary/50 focus-within:border-primary transition-all duration-200 hover:border-[#3a4558]">
                                        <div
                                            class="bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full px-3 py-1.5 text-sm flex items-center gap-2 border border-primary/30">
                                            <i class="ri-smartphone-line text-primary text-xs"></i>
                                            <span class="text-white">إلكترونيات</span>
                                            <button type="button"
                                                class="text-primary/70 hover:text-primary ml-1 hover:bg-primary/10 rounded-full p-0.5 transition-all duration-200">
                                                <i class="ri-close-line text-xs"></i>
                                            </button>
                                        </div>
                                        <div
                                            class="bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full px-3 py-1.5 text-sm flex items-center gap-2 border border-primary/30">
                                            <i class="ri-cpu-line text-primary text-xs"></i>
                                            <span class="text-white">تقنية</span>
                                            <button type="button"
                                                class="text-primary/70 hover:text-primary ml-1 hover:bg-primary/10 rounded-full p-0.5 transition-all duration-200">
                                                <i class="ri-close-line text-xs"></i>
                                            </button>
                                        </div>
                                        <input id="tagInput" type="text"
                                            class="bg-transparent border-none outline-none text-white flex-1 min-w-[150px] placeholder-gray-400"
                                            placeholder="أضف علامة جديدة واضغط Enter..." />
                                    </div>
                                </div>
                            </div>

                            <!-- Tags Tips -->
                            <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-purple-500/30 mt-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center text-purple-400 mt-0.5">
                                        <i class="ri-price-tag-line"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-300 leading-relaxed mb-2">
                                            <strong class="text-white">استخدام العلامات بفعالية:</strong>
                                        </p>
                                        <ul class="text-xs text-gray-400 space-y-1">
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                استخدم 5-10 علامات ذات صلة
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                اجمع بين العلامات العامة والمتخصصة
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                تجنب العلامات غير المرتبطة بالمنتج
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Meta Description Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                    <i class="ri-file-text-line text-indigo-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">وصف الميتا (Meta Description)</h3>
                                    <p class="text-xs text-gray-400">الوصف الذي يظهر تحت العنوان في نتائج البحث</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-2">
                                        <i class="ri-article-line text-primary text-sm"></i>
                                        وصف الميتا
                                    </label>
                                    <textarea id="metaDescription"
                                        class="w-full bg-[#0f1623] border-2 border-[#2a3548] rounded-lg p-4 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 hover:border-[#3a4558] outline-none min-h-[120px] resize-none"
                                        placeholder="اكتب وصفاً قصيراً وجذاباً يلخص المنتج ويشجع على النقر من نتائج البحث..."
                                        required></textarea>
                                    <div class="flex justify-between items-center mt-2">
                                        <span id="metaDescCounter" class="text-xs text-gray-400">0/160</span>
                                        <div class="flex items-center gap-1 text-xs text-gray-500">
                                            <i class="ri-information-line"></i>
                                            <span>الطول المثالي: 150-160 حرف</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Description Tips -->
                            <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-indigo-500/30 mt-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center text-indigo-400 mt-0.5">
                                        <i class="ri-magic-line"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-300 leading-relaxed mb-2">
                                            <strong class="text-white">وصف ميتا مؤثر:</strong>
                                        </p>
                                        <ul class="text-xs text-gray-400 space-y-1">
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                اجعله جذاباً يشجع على النقر
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                أدرج الكلمة المفتاحية الرئيسية
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="ri-arrow-left-s-line text-primary"></i>
                                                اذكر فائدة واضحة للمستخدم
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-6 border-t border-[#2a3548]">
                            <button id="backToStep2"
                                class="group flex items-center gap-2 bg-[#232b3e] hover:bg-[#2a3548] px-6 py-3 rounded-xl transition-all duration-200 border border-[#3a4558] hover:border-[#4a5568]">
                                <i
                                    class="ri-arrow-right-line group-hover:-translate-x-1 transition-transform duration-200"></i>
                                <span>العودة: الوصف والصور</span>
                            </button>
                            <button id="nextToStep4"
                                class="group flex items-center gap-2 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-black font-semibold px-8 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none"
                                disabled>
                                <span>التالي: الإعدادات الإضافية</span>
                                <i
                                    class="ri-arrow-left-line group-hover:translate-x-1 transition-transform duration-200"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Additional Settings -->
                    <div id="step4-content" class="step-content bg-[#1a2234] rounded-lg p-6 hidden">
                        <h2 class="text-lg font-semibold mb-6 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                <i class="ri-settings-3-line text-black text-sm"></i>
                            </div>
                            الإعدادات الإضافية
                        </h2>

                        <!-- Coupon Eligible Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                        <i class="ri-coupon-3-line text-primary text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-white">دعم الكوبونات</h3>
                                        <p class="text-xs text-gray-400">تفعيل إمكانية استخدام كوبونات الخصم</p>
                                    </div>
                                </div>
                                <!-- Modern Toggle Switch -->
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="couponEligible" class="sr-only peer">
                                    <div
                                        class="relative w-11 h-6 bg-[#2a3548] peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-primary peer-checked:to-secondary">
                                    </div>
                                </label>
                            </div>
                            <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-primary/30">
                                <p class="text-sm text-gray-300 leading-relaxed">
                                    عند تفعيل هذا الخيار، سيتمكن العملاء من استخدام كوبونات الخصم على هذا المنتج. يمكنك
                                    تحديد فئات الكوبونات المسموحة والمستبعدة أدناه.
                                </p>
                            </div>
                        </div>

                        <!-- Coupon Categories Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                                    <i class="ri-checkbox-circle-line text-green-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">فئات الكوبونات المسموحة</h3>
                                    <p class="text-xs text-gray-400">اختر الفئات التي يمكن استخدامها مع هذا المنتج</p>
                                </div>

                            </div>

                            <div class="bg-[#0f1623] rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <!-- Modern Checkbox Items -->
                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="coupon_general" value="general"
                                            class="coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-primary peer-checked:to-secondary peer-checked:border-primary transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-check-line text-black text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-global-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                عامة</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="coupon_seasonal" value="seasonal"
                                            class="coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-primary peer-checked:to-secondary peer-checked:border-primary transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-check-line text-black text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-sun-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                موسمية</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="coupon_loyalty" value="loyalty"
                                            class="coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-primary peer-checked:to-secondary peer-checked:border-primary transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-check-line text-black text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-heart-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                الولاء</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="coupon_new_customer" value="new_customer"
                                            class="coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-primary peer-checked:to-secondary peer-checked:border-primary transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-check-line text-black text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-user-add-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                العملاء الجدد</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="coupon_vip" value="vip"
                                            class="coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-primary peer-checked:to-secondary peer-checked:border-primary transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-check-line text-black text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-vip-crown-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                VIP</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="coupon_bulk" value="bulk"
                                            class="coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-primary peer-checked:to-secondary peer-checked:border-primary transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-check-line text-black text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-stack-line text-gray-400 group-hover:text-primary transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                الكمية</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Selected Categories Display -->
                            <div class="min-h-12 bg-[#0f1623] rounded-lg p-3 border-2 border-dashed border-[#2a3548]">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-price-tag-3-line text-primary text-sm"></i>
                                    <span class="text-xs text-gray-400 font-medium">الفئات المحددة:</span>
                                </div>
                                <div id="selectedCouponCategories" class="flex flex-wrap gap-2">
                                    <div class="text-xs text-gray-500 py-1">لم يتم اختيار أي فئة بعد</div>
                                </div>
                            </div>
                        </div>

                        <!-- Excluded Coupon Categories Section -->
                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 mb-6 border border-[#2a3548] shadow-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-red-500/10 flex items-center justify-center">
                                    <i class="ri-close-circle-line text-red-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-white">فئات الكوبونات المستبعدة</h3>
                                    <p class="text-xs text-gray-400">اختر الفئات التي لا يمكن استخدامها مع هذا المنتج
                                    </p>
                                </div>
                            </div>

                            <div class="bg-[#0f1623] rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <!-- Modern Checkbox Items for Excluded -->
                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-red-400/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="excluded_general" value="general"
                                            class="excluded-coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-red-500 peer-checked:to-red-600 peer-checked:border-red-400 transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-close-line text-white text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-global-line text-gray-400 group-hover:text-red-400 transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                عامة</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-red-400/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="excluded_seasonal" value="seasonal"
                                            class="excluded-coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-red-500 peer-checked:to-red-600 peer-checked:border-red-400 transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-close-line text-white text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-sun-line text-gray-400 group-hover:text-red-400 transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                موسمية</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-red-400/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="excluded_loyalty" value="loyalty"
                                            class="excluded-coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-red-500 peer-checked:to-red-600 peer-checked:border-red-400 transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-close-line text-white text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-heart-line text-gray-400 group-hover:text-red-400 transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                الولاء</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-red-400/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="excluded_new_customer" value="new_customer"
                                            class="excluded-coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-red-500 peer-checked:to-red-600 peer-checked:border-red-400 transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-close-line text-white text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-user-add-line text-gray-400 group-hover:text-red-400 transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                العملاء الجدد</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-red-400/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="excluded_vip" value="vip"
                                            class="excluded-coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-red-500 peer-checked:to-red-600 peer-checked:border-red-400 transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-close-line text-white text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-vip-crown-line text-gray-400 group-hover:text-red-400 transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                VIP</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 rounded-lg bg-[#1a2234] border border-[#2a3548] hover:border-red-400/30 transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" id="excluded_bulk" value="bulk"
                                            class="excluded-coupon-category sr-only peer">
                                        <div
                                            class="w-5 h-5 bg-[#2a3548] border-2 border-[#3a4558] rounded peer-checked:bg-gradient-to-r peer-checked:from-red-500 peer-checked:to-red-600 peer-checked:border-red-400 transition-all duration-200 flex items-center justify-center">
                                            <i
                                                class="ri-close-line text-white text-sm opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="mr-3 flex items-center gap-2">
                                            <i
                                                class="ri-stack-line text-gray-400 group-hover:text-red-400 transition-colors"></i>
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white transition-colors">كوبونات
                                                الكمية</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Selected Excluded Categories Display -->
                            <div class="min-h-12 bg-[#0f1623] rounded-lg p-3 border-2 border-dashed border-red-500/20">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-forbid-line text-red-400 text-sm"></i>
                                    <span class="text-xs text-gray-400 font-medium">الفئات المستبعدة:</span>
                                </div>
                                <div id="selectedExcludedCategories" class="flex flex-wrap gap-2">
                                    <div class="text-xs text-gray-500 py-1">لم يتم استبعاد أي فئة بعد</div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden inputs to store JSON data -->
                        <input type="hidden" id="couponCategoriesJson" name="coupon_categories" value="[]">
                        <input type="hidden" id="excludedCouponCategoriesJson" name="excluded_coupon_categories"
                            value="[]">
                        <input type="hidden" id="selectedCategoryId" name="category_id" value="">

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-6 border-t border-[#2a3548]">
                            <button id="backToStep3"
                                class="group flex items-center gap-2 bg-[#232b3e] hover:bg-[#2a3548] px-6 py-3 rounded-xl transition-all duration-200 border border-[#3a4558] hover:border-[#4a5568]">
                                <i
                                    class="ri-arrow-right-line group-hover:-translate-x-1 transition-transform duration-200"></i>
                                <span>العودة: تحسين محركات البحث</span>
                            </button>
                            <button id="finishProduct"
                                class="group flex items-center gap-2 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-black font-semibold px-8 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <span>إنهاء وحفظ المنتج</span>
                                <i class="ri-check-line group-hover:scale-110 transition-transform duration-200"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-span-1 space-y-6">
                    <!-- Additional Images Card (Step 2 only) -->
                    <div id="additionalImagesCard" class="bg-[#1a2234] rounded-lg p-6 hidden">
                        <h2 class="text-lg font-semibold mb-6 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-500 to-red-500 flex items-center justify-center">
                                <i class="ri-gallery-line text-white text-sm"></i>
                            </div>
                            صور إضافية
                        </h2>

                        <div
                            class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-4 border border-[#2a3548] shadow-lg mb-4">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 rounded-full bg-orange-500/10 flex items-center justify-center">
                                    <i class="ri-image-2-line text-orange-400 text-sm"></i>
                                </div>
                                <span class="text-sm text-gray-300">حتى 12 صورة إضافية</span>
                            </div>

                            <div class="grid grid-cols-3 gap-2" id="galleryGrid">
                                <!-- Gallery upload slots -->
                                @for($i = 0; $i < 12; $i++)
                                    <div class="gallery-slot relative aspect-square" data-index="{{ $i }}">
                                        <!-- Empty state -->
                                        <div class="upload-area h-full rounded-lg flex items-center justify-center cursor-pointer transition-all duration-300 bg-gradient-to-br from-[#1a2234] to-[#121827] hover:from-[#232b3e] hover:to-[#1a2234] border-2 border-dashed border-[#3a4558] hover:border-primary/50 group">
                                            <div class="w-8 h-8 flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors group-hover:scale-110 transform duration-200">
                                                <i class="ri-add-line"></i>
                                            </div>
                                            <input type="file" wire:model="galleryImages.{{ $i }}" 
                                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                        </div>

                                        <!-- Image preview state -->
                                        <div class="image-preview h-full rounded-lg relative hidden">
                                            <img src="" class="w-full h-full object-cover rounded-lg" />
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                                <button type="button" class="remove-gallery-image bg-red-500 hover:bg-red-600 text-white p-1 rounded transition-colors"
                                                        onclick="removeGalleryImage({{ $i }})">
                                                    <i class="ri-delete-bin-line text-sm"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Loading state -->
                                        <div class="upload-loading h-full rounded-lg bg-[#1a2234] bg-opacity-90 flex items-center justify-center hidden">
                                            <div class="w-4 h-4 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Additional Images Tips -->
                        <div class="bg-[#0f1623] rounded-lg p-4 border-l-4 border-orange-500/30">
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 flex items-center justify-center text-orange-400 mt-0.5">
                                    <i class="ri-gallery-line"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-300 leading-relaxed mb-2">
                                        <strong class="text-white">نصائح للصور الإضافية:</strong>
                                    </p>
                                    <ul class="text-xs text-gray-400 space-y-1">
                                        <li class="flex items-center gap-2">
                                            <i class="ri-arrow-left-s-line text-primary"></i>
                                            أضف صور من زوايا مختلفة
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <i class="ri-arrow-left-s-line text-primary"></i>
                                            اعرض تفاصيل مهمة في المنتج
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <i class="ri-arrow-left-s-line text-primary"></i>
                                            استخدم صور عالية الجودة
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Preview Card -->
                    <div class="bg-[#1a2234] rounded-lg p-6">
                        <h2 class="text-lg font-semibold mb-4">معاينة المنتج</h2>
                        <div class="bg-[#121827] rounded-lg overflow-hidden">
                            <div class="relative">
                                <div id="previewImage"
                                    class="aspect-video bg-[#232b3e] flex items-center justify-center bg-cover bg-center">
                                    <div class="w-12 h-12 flex items-center justify-center text-gray-400">
                                        <i class="ri-image-line ri-2x"></i>
                                    </div>
                                </div>
                                <div
                                    class="absolute top-3 left-3 bg-green-500 text-xs text-black px-2 py-0.5 rounded-full">
                                    Active
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div id="previewTitle" class="text-lg font-medium line-clamp-1">
                                        اسم المنتج
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <div class="w-4 h-4 flex items-center justify-center text-yellow-500">
                                            <i class="ri-star-fill"></i>
                                        </div>
                                        <span class="text-sm">4.5</span>
                                    </div>
                                </div>
                                <div id="previewDescription" class="text-sm text-gray-400 mb-3 line-clamp-2">
                                    وصف المنتج
                                </div>
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div id="previewCurrentPrice" class="text-lg font-semibold">
                                            $0.00
                                        </div>
                                        <div id="previewOriginalPrice" class="text-sm text-gray-400 line-through">
                                            $0.00
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-400">Stock: 45</div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-8 flex-1 bg-primary rounded-button flex items-center justify-center text-black text-sm">
                                        Add to Cart
                                    </div>
                                    <div class="h-8 w-8 bg-[#232b3e] rounded-button flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center">
                                            <i class="ri-heart-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        
        </div>


















        <script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentStep = 1;
        let hasMainImage = false;

        // Step validation requirements
        const stepRequirements = {
            1: ['productName', 'originalPrice', 'currentPrice', 'productSKU', 'selectedProductType',
                'selectedStatus', 'selectedCategory'
            ],
            2: ['productDescription', 'hasMainImage'],
            3: ['seoTitle', 'seoKeywords', 'metaDescription'],
            4: [] // Step 4 has no required fields by default
        };

        // Initialize
        updateStepDisplay();
        checkStepCompletion();

        // Currency selection
        setupCurrencySelector();

        // Step navigation
        document.querySelectorAll('[data-step]').forEach(stepElement => {
            stepElement.addEventListener('click', function() {
                const targetStep = parseInt(this.dataset.step);
                if (targetStep <= getMaxAvailableStep()) {
                    goToStep(targetStep);
                }
            });
        });

        // Next/Back buttons
        document.getElementById('nextToStep2').addEventListener('click', () => goToStep(2));
        document.getElementById('backToStep1').addEventListener('click', () => goToStep(1));
        document.getElementById('nextToStep3').addEventListener('click', () => goToStep(3));
        document.getElementById('backToStep2').addEventListener('click', () => goToStep(2));
        document.getElementById('nextToStep4').addEventListener('click', () => goToStep(4));
        document.getElementById('backToStep3').addEventListener('click', () => goToStep(3));

        // Input validation listeners
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('input', checkStepCompletion);
            input.addEventListener('change', checkStepCompletion);
        });

        function goToStep(step) {
            currentStep = step;
            // Update Livewire component step - COMMENTED OUT to prevent conflicts
            // @this.call('setStep', step);
            updateStepDisplay();
            checkStepCompletion();
        }

        function updateStepDisplay() {
            // Hide all step contents
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Show current step content
            document.getElementById(`step${currentStep}-content`).classList.remove('hidden');

            // Update step indicators
            for (let i = 1; i <= 4; i++) {
                const circle = document.getElementById(`step${i}-circle`);
                const label = document.getElementById(`step${i}-label`);

                if (i <= currentStep) {
                    circle.classList.remove('bg-[#1a2234]', 'text-white');
                    circle.classList.add('bg-primary', 'text-black');
                    label.classList.remove('text-gray-400');
                    label.classList.add('text-primary');
                } else {
                    circle.classList.remove('bg-primary', 'text-black');
                    circle.classList.add('bg-[#1a2234]', 'text-white');
                    label.classList.remove('text-primary');
                    label.classList.add('text-gray-400');
                }
            }

            // Update progress bars with proper animation
            const progress1 = document.getElementById('progress1');
            const progress2 = document.getElementById('progress2');
            const progress3 = document.getElementById('progress3');
            
            // Debug: Log the current step and expected progress bar states
            console.log('Current Step:', currentStep);
            console.log('Progress1 should be:', currentStep >= 2 ? '100%' : '0%');
            console.log('Progress2 should be:', currentStep >= 3 ? '100%' : '0%');
            console.log('Progress3 should be:', currentStep >= 4 ? '100%' : '0%');
            
            // Force reflow to ensure animations work properly
            progress1.style.transition = 'none';
            progress2.style.transition = 'none';
            progress3.style.transition = 'none';
            
            // Set widths immediately
            progress1.style.width = currentStep >= 2 ? '100%' : '0%';
            progress2.style.width = currentStep >= 3 ? '100%' : '0%';
            progress3.style.width = currentStep >= 4 ? '100%' : '0%';
            
            // Re-enable transitions after a small delay
            setTimeout(() => {
                progress1.style.transition = 'all 0.3s ease';
                progress2.style.transition = 'all 0.3s ease';
                progress3.style.transition = 'all 0.3s ease';
            }, 10);

            // Show/hide additional images card for step 2
            const additionalImagesCard = document.getElementById('additionalImagesCard');
            if (currentStep === 2) {
                additionalImagesCard.classList.remove('hidden');
            } else {
                additionalImagesCard.classList.add('hidden');
            }
        }

        function checkStepCompletion() {
            const step1Complete = checkStep1();
            const step2Complete = checkStep2();
            const step3Complete = checkStep3();
            const step4Complete = checkStep4();

            // Update button states
            document.getElementById('nextToStep2').disabled = !step1Complete;
            document.getElementById('nextToStep3').disabled = !step2Complete;
            document.getElementById('nextToStep4').disabled = !step3Complete;
            document.getElementById('finishProduct').disabled = false; // Step 4 is always available
        }

        function checkStep1() {
            const productName = document.getElementById('productName').value.trim();
            const originalPrice = document.getElementById('originalPrice').value.trim();
            const currentPrice = document.getElementById('currentPrice').value.trim();
            const productSKU = document.getElementById('productSKU').value.trim();
            const productType = document.getElementById('selectedProductType').innerHTML;
            const status = document.getElementById('selectedStatus').innerHTML;
            const categoryId = document.getElementById('selectedCategoryId').value.trim();

            return productName && originalPrice && currentPrice && productSKU &&
                !productType.includes('اختر نوع المنتج') &&
                !status.includes('اختر الحالة') &&
                categoryId; // Check for category ID instead of text
        }

        function checkStep2() {
            const description = document.getElementById('productDescription').value.trim();
            return description && hasMainImage;
        }

        function checkStep3() {
            const seoTitle = document.getElementById('seoTitle').value.trim();
            const seoKeywords = document.getElementById('seoKeywords').value.trim();
            const metaDescription = document.getElementById('metaDescription').value.trim();

            return seoTitle && seoKeywords && metaDescription;
        }

        function checkStep4() {
            // Step 4 validation - no required fields by default
            return true;
        }

        function getMaxAvailableStep() {
            if (!checkStep1()) return 1;
            if (!checkStep2()) return 2;
            if (!checkStep3()) return 3;
            return 4;
        }

        // Dropdown handlers
        setupDropdowns();

        // Text area and preview handlers
        setupPreviewUpdates();

        // Image upload handlers
        setupImageUploads();

        // Tag handlers
        setupTagHandlers();

        // SEO character counters
        setupSEOCounters();

        // Coupon category handlers
        setupCouponCategories();

        function setupDropdowns() {
            const dropdownConfigs = [{
                    btn: 'productTypeBtn',
                    dropdown: 'productTypeDropdown',
                    selected: 'selectedProductType'
                },
                {
                    btn: 'statusBtn',
                    dropdown: 'statusDropdown',
                    selected: 'selectedStatus'
                },
                {
                    btn: 'categoryBtn',
                    dropdown: 'categoryDropdown',
                    selected: 'selectedCategory'
                }
            ];

            dropdownConfigs.forEach(config => {
                const btn = document.getElementById(config.btn);
                const dropdown = document.getElementById(config.dropdown);
                const selected = document.getElementById(config.selected);

                btn.addEventListener("click", function() {
                    dropdown.classList.toggle("hidden");
                    dropdownConfigs.forEach(otherConfig => {
                        if (otherConfig !== config) {
                            document.getElementById(otherConfig.dropdown).classList.add(
                                "hidden");
                        }
                    });
                });

                dropdown.querySelectorAll("div[data-value]").forEach((item) => {
                    item.addEventListener("click", function() {
                        const value = this.dataset.value;
                        const text = this.textContent.trim();
                        const icon = this.querySelector('i');

                        if (config.selected === 'selectedProductType') {
                            if (value === 'account') {
                                selected.innerHTML =
                                    `<i class="ri-user-line text-primary"></i> ${text}`;
                            } else if (value === 'digital') {
                                selected.innerHTML =
                                    `<i class="ri-smartphone-line text-primary"></i> ${text}`;
                            } else if (value === 'custom') {
                                selected.innerHTML =
                                    `<i class="ri-tools-line text-primary"></i> ${text}`;
                            }
                        } else if (config.selected === 'selectedStatus') {
                            if (value === 'active') {
                                selected.innerHTML =
                                    `<div class="w-3 h-3 rounded-full bg-green-500 shadow-lg shadow-green-500/30"></div> ${text}`;
                            } else if (value === 'inactive') {
                                selected.innerHTML =
                                    `<div class="w-3 h-3 rounded-full bg-gray-500 shadow-lg shadow-gray-500/30"></div> ${text}`;
                            }
                        } else if (config.selected === 'selectedCategory') {
                            // For categories, use the icon from the database or default
                            const iconClass = icon ? icon.className : 'ri-folder-line text-primary';
                            selected.innerHTML = `<i class="${iconClass}"></i> ${text}`;
                            // Store the category ID for form submission
                            selected.setAttribute('data-category-id', value);
                            // Update hidden input with category ID
                            document.getElementById('selectedCategoryId').value = value;
                        }

                        dropdown.classList.add("hidden");
                        checkStepCompletion();
                    });
                });
            });

            // Setup category search functionality
            setupCategorySearch();

            document.addEventListener("click", function(event) {
                dropdownConfigs.forEach(config => {
                    const btn = document.getElementById(config.btn);
                    const dropdown = document.getElementById(config.dropdown);
                    if (!btn.contains(event.target) && !dropdown.contains(event.target)) {
                        dropdown.classList.add("hidden");
                    }
                });
            });
        }

        function setupCategorySearch() {
            const searchInput = document.getElementById('categorySearch');
            const categoryList = document.getElementById('categoryList');
            
            if (searchInput && categoryList) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const categoryItems = categoryList.querySelectorAll('.category-item');
                    
                    categoryItems.forEach(item => {
                        const searchText = item.dataset.search || '';
                        if (searchText.includes(searchTerm)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        }

        function setupPreviewUpdates() {
            const productNameInput = document.getElementById('productName');
            const productDescTextarea = document.getElementById('productDescription');
            const originalPriceInput = document.getElementById('originalPrice');
            const currentPriceInput = document.getElementById('currentPrice');
            const previewTitle = document.getElementById("previewTitle");
            const previewDescription = document.getElementById("previewDescription");
            const previewOriginalPrice = document.getElementById("previewOriginalPrice");
            const previewCurrentPrice = document.getElementById("previewCurrentPrice");

            productNameInput.addEventListener("input", function() {
                previewTitle.textContent = this.value || "اسم المنتج";
            });

            productDescTextarea.addEventListener("input", function() {
                previewDescription.textContent = this.value || "وصف المنتج";
            });

            originalPriceInput.addEventListener("input", function() {
                const currency = document.querySelector('.currency-btn.active').dataset.symbol;
                previewOriginalPrice.textContent = this.value ? `${currency}${this.value}` :
                    `${currency}0.00`;
            });

            currentPriceInput.addEventListener("input", function() {
                const currency = document.querySelector('.currency-btn.active').dataset.symbol;
                previewCurrentPrice.textContent = this.value ? `${currency}${this.value}` :
                    `${currency}0.00`;
            });
        }

        function setupImageUploads() {
            // Main image upload handling
            const mainImageInput = document.getElementById('mainImageInput');
            const uploadPrompt = document.getElementById('uploadPrompt');
            const imagePreview = document.getElementById('imagePreview');
            const uploadLoading = document.getElementById('uploadLoading');
            const previewImg = document.getElementById('previewImg');
            const changeImageBtn = document.getElementById('changeImageBtn');
            const removeImageBtn = document.getElementById('removeImageBtn');

            // Handle main image change
            mainImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    showMainImageLoading();
                    // Livewire will handle the upload automatically
                }
            });

            // Change image button
            changeImageBtn.addEventListener('click', function() {
                mainImageInput.click();
            });

            // Remove image button
            removeImageBtn.addEventListener('click', function() {
                @this.call('removeMainImage');
            });

            // Handle gallery image uploads
            document.querySelectorAll('input[wire\\:model^="galleryImages"]').forEach((input, index) => {
                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        showGalleryImageLoading(index);
                        // Livewire will handle the upload automatically
                    }
                });
            });

            function showMainImageLoading() {
                uploadPrompt.classList.add('hidden');
                imagePreview.classList.add('hidden');
                uploadLoading.classList.remove('hidden');
            }

            function showMainImagePreview(url) {
                uploadPrompt.classList.add('hidden');
                uploadLoading.classList.add('hidden');
                previewImg.src = url;
                imagePreview.classList.remove('hidden');
                
                // Update preview in right sidebar
                const previewImage = document.getElementById("previewImage");
                previewImage.style.backgroundImage = `url(${url})`;
                previewImage.innerHTML = "";
                
                hasMainImage = true;
                checkStepCompletion();
            }

            function showMainImageError() {
                uploadLoading.classList.add('hidden');
                uploadPrompt.classList.remove('hidden');
                showNotification('error', 'فشل في رفع الصورة. يرجى المحاولة مرة أخرى.');
            }

            function resetMainImage() {
                uploadPrompt.classList.remove('hidden');
                imagePreview.classList.add('hidden');
                uploadLoading.classList.add('hidden');
                previewImg.src = '';
                
                // Reset preview in right sidebar
                const previewImage = document.getElementById("previewImage");
                previewImage.style.backgroundImage = '';
                previewImage.innerHTML = '<div class="w-12 h-12 flex items-center justify-center text-gray-400"><i class="ri-image-line ri-2x"></i></div>';
                
                hasMainImage = false;
                checkStepCompletion();
            }

            function showGalleryImageLoading(index) {
                const slot = document.querySelector(`[data-index="${index}"]`);
                if (slot) {
                    slot.querySelector('.upload-area').classList.add('hidden');
                    slot.querySelector('.image-preview').classList.add('hidden');
                    slot.querySelector('.upload-loading').classList.remove('hidden');
                }
            }

            function showGalleryImagePreview(index, url) {
                const slot = document.querySelector(`[data-index="${index}"]`);
                if (slot) {
                    slot.querySelector('.upload-area').classList.add('hidden');
                    slot.querySelector('.upload-loading').classList.add('hidden');
                    slot.querySelector('.image-preview img').src = url;
                    slot.querySelector('.image-preview').classList.remove('hidden');
                }
            }

            function resetGalleryImage(index) {
                const slot = document.querySelector(`[data-index="${index}"]`);
                if (slot) {
                    slot.querySelector('.upload-area').classList.remove('hidden');
                    slot.querySelector('.image-preview').classList.add('hidden');
                    slot.querySelector('.upload-loading').classList.add('hidden');
                    slot.querySelector('.image-preview img').src = '';
                }
            }

            // Global functions for Livewire events
            window.showMainImagePreview = showMainImagePreview;
            window.showMainImageError = showMainImageError;
            window.resetMainImage = resetMainImage;
            window.showGalleryImagePreview = showGalleryImagePreview;
            window.resetGalleryImage = resetGalleryImage;

            // Listen for Livewire events - these should NOT change the step
            Livewire.on('mainImageUploaded', (event) => {
                const data = event[0] || event;
                if (data.success) {
                    showMainImagePreview(data.url);
                    showNotification('success', 'تم رفع الصورة الرئيسية بنجاح');
                } else {
                    showMainImageError();
                }
            });

            Livewire.on('mainImageUploadError', (event) => {
                const data = event[0] || event;
                showMainImageError();
                showNotification('error', data.message || 'فشل في رفع الصورة');
            });

            Livewire.on('mainImageRemoved', (event) => {
                const data = event[0] || event;
                resetMainImage();
                showNotification('success', 'تم حذف الصورة الرئيسية');
            });

            Livewire.on('galleryImageUploaded', (event) => {
                const data = event[0] || event;
                if (data.success) {
                    showGalleryImagePreview(data.index, data.url);
                    showNotification('success', 'تم رفع الصورة بنجاح');
                }
            });

            Livewire.on('galleryImageUploadError', (event) => {
                const data = event[0] || event;
                showNotification('error', data.message || 'فشل في رفع الصورة');
            });

            Livewire.on('galleryImageRemoved', (event) => {
                const data = event[0] || event;
                resetGalleryImage(data.index);
                showNotification('success', 'تم حذف الصورة');
            });

            // Listen for step changes from Livewire
            // COMMENTED OUT: This was causing conflicts with progress bar animation
            // Livewire.on('stepChanged', (event) => {
            //     const data = event[0] || event;
            //     // Only update if different from current step
            //     if (data.step !== currentStep) {
            //         currentStep = data.step;
            //         updateStepDisplay();
            //         checkStepCompletion();
            //     }
            // });
        }

        // Global function for removing gallery images
        window.removeGalleryImage = function(index) {
            @this.call('removeGalleryImage', index);
        };

        function setupTagHandlers() {
            const tagContainer = document.getElementById('tagsContainer');
            const tagInput = document.getElementById('tagInput');

            tagInput.addEventListener("keydown", function(e) {
                if (e.key === "Enter" && this.value.trim() !== "") {
                    e.preventDefault();
                    addTag(this.value.trim());
                    this.value = "";
                }
            });

            tagContainer.addEventListener("click", function(e) {
                if (e.target.closest("button")) {
                    e.target.closest("button").parentElement.remove();
                }
            });

            function addTag(text) {
                const tag = document.createElement("div");
                tag.className =
                    "bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full px-3 py-1.5 text-sm flex items-center gap-2 border border-primary/30";
                tag.innerHTML = `
              <i class="ri-price-tag-line text-primary text-xs"></i>
              <span class="text-white">${text}</span>
              <button type="button" class="text-primary/70 hover:text-primary ml-1 hover:bg-primary/10 rounded-full p-0.5 transition-all duration-200">
                <i class="ri-close-line text-xs"></i>
              </button>
            `;
                tagContainer.insertBefore(tag, tagInput);
            }
        }

        function setupSEOCounters() {
            const seoTitleInput = document.getElementById('seoTitle');
            const seoTitleCounter = document.getElementById('seoTitleCounter');

            seoTitleInput.addEventListener("input", function() {
                const length = this.value.length;
                seoTitleCounter.textContent = `${length}/60`;
                if (length > 60) {
                    seoTitleCounter.classList.add("text-red-500");
                    seoTitleCounter.classList.remove("text-gray-400");
                } else {
                    seoTitleCounter.classList.remove("text-red-500");
                    seoTitleCounter.classList.add("text-gray-400");
                }
            });

            const metaDescTextarea = document.getElementById('metaDescription');
            const metaDescCounter = document.getElementById('metaDescCounter');

            metaDescTextarea.addEventListener("input", function() {
                const length = this.value.length;
                metaDescCounter.textContent = `${length}/160`;
                if (length > 160) {
                    metaDescCounter.classList.add("text-red-500");
                    metaDescCounter.classList.remove("text-gray-400");
                } else {
                    metaDescCounter.classList.remove("text-red-500");
                    metaDescCounter.classList.add("text-gray-400");
                }
            });
        }

        function setupCouponCategories() {
            // Prevent multiple initialization
            if (window.couponCategoriesInitialized) {
                return;
            }
            window.couponCategoriesInitialized = true;
            
            // Global arrays for better state management
            window.couponCategories = [];
            window.excludedCouponCategories = [];

            // Handle allowed coupon categories
            document.querySelectorAll('.coupon-category').forEach(checkbox => {
                // Remove any existing event listeners first
                checkbox.removeEventListener('change', handleCouponCategoryChange);
                checkbox.addEventListener('change', handleCouponCategoryChange);
            });

            // Handle excluded coupon categories
            document.querySelectorAll('.excluded-coupon-category').forEach(checkbox => {
                // Remove any existing event listeners first
                checkbox.removeEventListener('change', handleExcludedCategoryChange);
                checkbox.addEventListener('change', handleExcludedCategoryChange);
            });

            function handleCouponCategoryChange(event) {
                const value = event.target.value;
                const isChecked = event.target.checked;
                
                if (isChecked) {
                    if (!window.couponCategories.includes(value)) {
                        window.couponCategories.push(value);
                    }
                } else {
                    const index = window.couponCategories.indexOf(value);
                    if (index > -1) {
                        window.couponCategories.splice(index, 1);
                    }
                }
                updateCouponCategoriesDisplay();
                updateCouponCategoriesJson();
            }

            function handleExcludedCategoryChange(event) {
                const value = event.target.value;
                const isChecked = event.target.checked;
                
                if (isChecked) {
                    if (!window.excludedCouponCategories.includes(value)) {
                        window.excludedCouponCategories.push(value);
                    }
                } else {
                    const index = window.excludedCouponCategories.indexOf(value);
                    if (index > -1) {
                        window.excludedCouponCategories.splice(index, 1);
                    }
                }
                updateExcludedCategoriesDisplay();
                updateExcludedCategoriesJson();
            }

            function updateCouponCategoriesDisplay() {
                const container = document.getElementById('selectedCouponCategories');
                if (!container) return;
                
                // Always clear the container first to prevent duplicates
                container.innerHTML = '';

                if (window.couponCategories.length === 0) {
                    container.innerHTML =
                        '<div class="text-xs text-gray-500 py-1">لم يتم اختيار أي فئة بعد</div>';
                    return;
                }

                // Create unique tags for each category
                window.couponCategories.forEach((category) => {
                    const tag = document.createElement('div');
                    tag.className =
                        'bg-gradient-to-r from-primary to-secondary text-black rounded-full px-3 py-1.5 text-xs font-medium flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-200';
                    tag.innerHTML = `
                <i class="ri-price-tag-3-line text-xs"></i>
                <span>${getCategoryDisplayName(category)}</span>
                <button type="button" class="text-black/70 hover:text-black/90 ml-1 hover:bg-black/10 rounded-full p-0.5 transition-all duration-200" onclick="removeCouponCategory('${category}')">
                  <i class="ri-close-line text-xs"></i>
                </button>
              `;
                    container.appendChild(tag);
                });
            }

            function updateExcludedCategoriesDisplay() {
                const container = document.getElementById('selectedExcludedCategories');
                if (!container) return;
                
                // Always clear the container first to prevent duplicates
                container.innerHTML = '';

                if (window.excludedCouponCategories.length === 0) {
                    container.innerHTML =
                        '<div class="text-xs text-gray-500 py-1">لم يتم استبعاد أي فئة بعد</div>';
                    return;
                }

                // Create unique tags for each category
                window.excludedCouponCategories.forEach((category) => {
                    const tag = document.createElement('div');
                    tag.className =
                        'bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full px-3 py-1.5 text-xs font-medium flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-200';
                    tag.innerHTML = `
                <i class="ri-forbid-line text-xs"></i>
                <span>${getCategoryDisplayName(category)}</span>
                <button type="button" class="text-white/70 hover:text-white/90 ml-1 hover:bg-white/10 rounded-full p-0.5 transition-all duration-200" onclick="removeExcludedCategory('${category}')">
                  <i class="ri-close-line text-xs"></i>
                </button>
              `;
                    container.appendChild(tag);
                });
            }

            function updateCouponCategoriesJson() {
                // Remove duplicates before saving to JSON
                const uniqueCategories = [...new Set(window.couponCategories)];
                window.couponCategories = uniqueCategories; // Update the global array too
                const jsonField = document.getElementById('couponCategoriesJson');
                if (jsonField) {
                    jsonField.value = JSON.stringify(uniqueCategories);
                }
            }

            function updateExcludedCategoriesJson() {
                // Remove duplicates before saving to JSON
                const uniqueExcluded = [...new Set(window.excludedCouponCategories)];
                window.excludedCouponCategories = uniqueExcluded; // Update the global array too
                const jsonField = document.getElementById('excludedCouponCategoriesJson');
                if (jsonField) {
                    jsonField.value = JSON.stringify(uniqueExcluded);
                }
            }

            function getCategoryDisplayName(value) {
                const names = {
                    'general': 'كوبونات عامة',
                    'seasonal': 'كوبونات موسمية',
                    'loyalty': 'كوبونات الولاء',
                    'new_customer': 'كوبونات العملاء الجدد',
                    'vip': 'كوبونات VIP',
                    'bulk': 'كوبونات الكمية'
                };
                return names[value] || value;
            }

            // Make functions available globally
            window.updateCouponCategoriesDisplay = updateCouponCategoriesDisplay;
            window.updateExcludedCategoriesDisplay = updateExcludedCategoriesDisplay;
            window.updateCouponCategoriesJson = updateCouponCategoriesJson;
            window.updateExcludedCategoriesJson = updateExcludedCategoriesJson;
            window.getCategoryDisplayName = getCategoryDisplayName;

            // Global functions for removing categories - rewrite with better logic
            window.removeCouponCategory = function(category) {
                const index = window.couponCategories.indexOf(category);
                if (index > -1) {
                    window.couponCategories.splice(index, 1);
                    // Also uncheck the corresponding checkbox
                    const checkbox = document.getElementById(`coupon_${category}`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    updateCouponCategoriesDisplay();
                    updateCouponCategoriesJson();
                }
            };

            window.removeExcludedCategory = function(category) {
                const index = window.excludedCouponCategories.indexOf(category);
                if (index > -1) {
                    window.excludedCouponCategories.splice(index, 1);
                    // Also uncheck the corresponding checkbox
                    const checkbox = document.getElementById(`excluded_${category}`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    updateExcludedCategoriesDisplay();
                    updateExcludedCategoriesJson();
                }
            };
        }

        function setupCurrencySelector() {
            let selectedCurrency = 'USD';
            let selectedSymbol = '$';

            document.querySelectorAll('.currency-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    document.querySelectorAll('.currency-btn').forEach(b => {
                        b.classList.remove('active', 'bg-primary/10', 'border-primary');
                        b.classList.add('border-[#3a4558]');
                        const span = b.querySelector('span:last-child');
                        span.classList.remove('text-primary', 'font-medium');
                        span.classList.add('text-gray-300');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-primary/10', 'border-primary');
                    this.classList.remove('border-[#3a4558]');
                    const span = this.querySelector('span:last-child');
                    span.classList.add('text-primary', 'font-medium');
                    span.classList.remove('text-gray-300');

                    // Update selected currency
                    selectedCurrency = this.dataset.currency;
                    selectedSymbol = this.dataset.symbol;

                    // Update currency symbols in price inputs
                    document.getElementById('originalPriceCurrency').textContent =
                        selectedSymbol;
                    document.getElementById('currentPriceCurrency').textContent =
                    selectedSymbol;

                    // Update preview prices
                    const originalPrice = document.getElementById('originalPrice').value;
                    const currentPrice = document.getElementById('currentPrice').value;

                    document.getElementById('previewOriginalPrice').textContent =
                        originalPrice ? `${selectedSymbol}${originalPrice}` :
                        `${selectedSymbol}0.00`;
                    document.getElementById('previewCurrentPrice').textContent = currentPrice ?
                        `${selectedSymbol}${currentPrice}` : `${selectedSymbol}0.00`;
                });
            });
        }

        // Form submission handler
        function setupFormSubmission() {
            document.getElementById('finishProduct').addEventListener('click', function() {
                // Show loading state
                this.disabled = true;
                this.innerHTML = `
                    <span class="flex items-center gap-2">
                        <div class="w-4 h-4 border-2 border-current border-t-transparent rounded-full animate-spin"></div>
                        جاري الحفظ...
                    </span>
                `;

                // Collect all form data
                const formData = {
                    productName: document.getElementById('productName').value,
                    productSKU: document.getElementById('productSKU').value,
                    originalPrice: document.getElementById('originalPrice').value,
                    currentPrice: document.getElementById('currentPrice').value,
                    selectedProductType: document.getElementById('selectedProductType').innerHTML,
                    selectedStatus: document.getElementById('selectedStatus').innerHTML,
                    selectedCategory: document.getElementById('selectedCategory').innerHTML,
                    categoryId: document.getElementById('selectedCategoryId').value,
                    productDescription: document.getElementById('productDescription').value,
                    seoTitle: document.getElementById('seoTitle').value,
                    seoKeywords: document.getElementById('seoKeywords').value,
                    metaDescription: document.getElementById('metaDescription').value,
                    couponEligible: document.getElementById('couponEligible').checked,
                    couponCategories: JSON.parse(document.getElementById('couponCategoriesJson').value || '[]'),
                    excludedCouponCategories: JSON.parse(document.getElementById('excludedCouponCategoriesJson').value || '[]')
                };

                console.log('Submitting product data:', formData);

                // Call Livewire method
                @this.call('updateProduct', formData);

                // Fallback timeout in case Livewire event doesn't fire (30 seconds)
                setTimeout(() => {
                    if (this.disabled && this.innerHTML.includes('جاري الحفظ')) {
                        console.warn('Livewire event timeout - resetting button');
                        this.disabled = false;
                        this.innerHTML = `
                            <span>إنهاء وحفظ المنتج</span>
                            <i class="ri-check-line group-hover:scale-110 transition-transform duration-200"></i>
                        `;
                        showNotification('error', 'انتهت مهلة العملية. يرجى المحاولة مرة أخرى.');
                    }
                }, 30000);
            });
        }

        // Initialize form submission
        setupFormSubmission();

        // Event listeners for Livewire responses - Move outside DOMContentLoaded
        // Listen for productUpdated event from Livewire
        Livewire.on('productUpdated', (event) => {
            console.log('Received productUpdated event:', event);
            const data = event[0] || event; // Handle both array and object formats
            const finishButton = document.getElementById('finishProduct');
            
            if (data.success) {
                // Show success message
                showNotification('success', data.message);
                
                // Reset button state with success state temporarily
                finishButton.disabled = true;
                finishButton.innerHTML = `
                    <span class="flex items-center gap-2">
                        <i class="ri-check-line text-lg"></i>
                        تم الحفظ بنجاح
                    </span>
                `;
                finishButton.classList.remove('from-primary', 'to-secondary');
                finishButton.classList.add('from-green-500', 'to-green-600');
                
                // Reset form and go back to step 1 after a short delay
                setTimeout(() => {
                    resetFormData();
                    goToStep(1);
                    
                    // Reset button to normal state
                    finishButton.disabled = false;
                    finishButton.innerHTML = `
                        <span>إنهاء وحفظ المنتج</span>
                        <i class="ri-check-line group-hover:scale-110 transition-transform duration-200"></i>
                    `;
                    finishButton.classList.remove('from-green-500', 'to-green-600');
                    finishButton.classList.add('from-primary', 'to-secondary');
                    
                    showNotification('success', 'تم إعداد النموذج لمنتج جديد');
                }, 2000);
                
            } else {
                // Show error message
                showNotification('error', data.message);
                
                // Reset button state
                finishButton.disabled = false;
                finishButton.innerHTML = `
                    <span>إنهاء وحفظ المنتج</span>
                    <i class="ri-check-line group-hover:scale-110 transition-transform duration-200"></i>
                `;
            }
        });

        // Also listen for any Livewire errors
        Livewire.on('productSaveError', (event) => {
            console.log('Received productSaveError event:', event);
            const data = event[0] || event;
            const finishButton = document.getElementById('finishProduct');
            
            showNotification('error', data.message || 'حدث خطأ أثناء حفظ المنتج');
            
            // Reset button state
            finishButton.disabled = false;
            finishButton.innerHTML = `
                <span>إنهاء وحفظ المنتج</span>
                <i class="ri-check-line group-hover:scale-110 transition-transform duration-200"></i>
            `;
        });

        // Notification function
        function showNotification(type, message) {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `custom-notification fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-md transform translate-x-full transition-transform duration-300 ${
                type === 'success' 
                ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' 
                : 'bg-gradient-to-r from-red-500 to-red-600 text-white'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' 
                        ? '<i class="ri-check-circle-line text-xl"></i>' 
                        : '<i class="ri-error-warning-line text-xl"></i>'}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-sm">${type === 'success' ? 'نجح!' : 'خطأ!'}</p>
                        <p class="text-sm opacity-90 mt-1">${message}</p>
                    </div>
                    <button class="flex-shrink-0 ml-2 hover:bg-white/20 rounded p-1 transition-colors" onclick="this.parentElement.parentElement.remove()">
                        <i class="ri-close-line text-sm"></i>
                    </button>
                </div>
            `;

            // Add to page
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Add auto-generation of slug from product name
        document.getElementById('productName').addEventListener('input', function() {
            const productName = this.value;
            const slugInput = document.getElementById('productSlug');
            if (productName && !slugInput.dataset.userEdited) {
                // Generate slug from product name
                const slug = productName
                    .toLowerCase()
                    .replace(/[\u0600-\u06FF\u0750-\u077F]/g, '') // Remove Arabic characters
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .trim()
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-'); // Remove multiple hyphens
                
                slugInput.value = slug;
            }
        });

        // Mark slug as user-edited when manually changed
        document.getElementById('productSlug').addEventListener('input', function() {
            this.dataset.userEdited = 'true';
        });

        // Reset form data function
        function resetFormData() {
            // Reset all input fields
            document.getElementById('productName').value = '';
            document.getElementById('productSKU').value = '';
            document.getElementById('originalPrice').value = '';
            document.getElementById('currentPrice').value = '';
            document.getElementById('productSlug').value = '';
            document.getElementById('productDescription').value = '';
            document.getElementById('seoTitle').value = '';
            document.getElementById('seoKeywords').value = '';
            document.getElementById('metaDescription').value = '';
            
            // Reset checkbox
            document.getElementById('couponEligible').checked = false;
            
            // Reset hidden inputs
            document.getElementById('selectedCategoryId').value = '';
            document.getElementById('couponCategoriesJson').value = '[]';
            document.getElementById('excludedCouponCategoriesJson').value = '[]';
            
            // Reset dropdowns to default state
            document.getElementById('selectedProductType').innerHTML = `<i class="ri-question-line text-gray-400 group-hover:text-primary transition-colors"></i> اختر نوع المنتج`;
            document.getElementById('selectedStatus').innerHTML = `<i class="ri-question-line text-gray-400 group-hover:text-primary transition-colors"></i> اختر الحالة`;
            document.getElementById('selectedCategory').innerHTML = `<i class="ri-question-line text-gray-400 group-hover:text-primary transition-colors"></i> اختر التصنيف`;
            
            // Reset main image
            resetMainImage();
            
            // Reset gallery images
            for (let i = 0; i < 12; i++) {
                resetGalleryImage(i);
            }
            
            // Reset currency to default (USD)
            document.querySelectorAll('.currency-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-primary/10', 'border-primary');
                btn.classList.add('border-[#3a4558]');
                const span = btn.querySelector('span:last-child');
                span.classList.remove('text-primary', 'font-medium');
                span.classList.add('text-gray-300');
            });
            
            // Set USD as active
            const usdBtn = document.querySelector('[data-currency="USD"]');
            if (usdBtn) {
                usdBtn.classList.add('active', 'bg-primary/10', 'border-primary');
                usdBtn.classList.remove('border-[#3a4558]');
                const span = usdBtn.querySelector('span:last-child');
                span.classList.add('text-primary', 'font-medium');
                span.classList.remove('text-gray-300');
            }
            
            // Reset currency symbols
            document.getElementById('originalPriceCurrency').textContent = '$';
            document.getElementById('currentPriceCurrency').textContent = '$';
            
            // Reset all checkboxes for coupon categories
            document.querySelectorAll('.coupon-category').forEach(checkbox => {
                checkbox.checked = false;
            });
            document.querySelectorAll('.excluded-coupon-category').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Reset coupon category displays
            document.getElementById('selectedCouponCategories').innerHTML = '<div class="text-xs text-gray-500 py-1">لم يتم اختيار أي فئة بعد</div>';
            document.getElementById('selectedExcludedCategories').innerHTML = '<div class="text-xs text-gray-500 py-1">لم يتم استبعاد أي فئة بعد</div>';
            
            // Reset global coupon arrays
            if (window.couponCategories) {
                window.couponCategories.length = 0;
            }
            if (window.excludedCouponCategories) {
                window.excludedCouponCategories.length = 0;
            }
            
            // Reset tags
            const tagsContainer = document.getElementById('tagsContainer');
            const tagInput = document.getElementById('tagInput');
            // Remove all existing tags except the input
            tagsContainer.querySelectorAll('div:not(:last-child)').forEach(tag => tag.remove());
            
            // Reset character counters
            document.getElementById('seoTitleCounter').textContent = '0/60';
            document.getElementById('seoTitleCounter').classList.remove('text-red-500');
            document.getElementById('seoTitleCounter').classList.add('text-gray-400');
            
            document.getElementById('metaDescCounter').textContent = '0/160';
            document.getElementById('metaDescCounter').classList.remove('text-red-500');
            document.getElementById('metaDescCounter').classList.add('text-gray-400');
            
            // Reset preview
            document.getElementById('previewTitle').textContent = 'اسم المنتج';
            document.getElementById('previewDescription').textContent = 'وصف المنتج';
            document.getElementById('previewOriginalPrice').textContent = '$0.00';
            document.getElementById('previewCurrentPrice').textContent = '$0.00';
            
            // Reset preview image
            const previewImage = document.getElementById("previewImage");
            previewImage.style.backgroundImage = '';
            previewImage.innerHTML = '<div class="w-12 h-12 flex items-center justify-center text-gray-400"><i class="ri-image-line ri-2x"></i></div>';
            
            // Reset hasMainImage flag
            hasMainImage = false;
            
            // Clear slug user-edited flag
            document.getElementById('productSlug').dataset.userEdited = '';
            
            // NOTE: Removed @this.call('resetForm') as method doesn't exist
            // The frontend reset above already handles everything needed
        }
    });

    // Pre-populate form with existing product data
    document.addEventListener('DOMContentLoaded', function() {
        const product = @json($product);
        
        // Basic Information
        document.getElementById('productName').value = product.name || '';
        document.getElementById('productSKU').value = product.sku || '';
        
        // Pricing
        document.getElementById('originalPrice').value = product.old_price || '';
        document.getElementById('currentPrice').value = product.price || '';
        
        // Description
        if (product.description) {
            const descEditor = document.getElementById('productDescription');
            if (descEditor) descEditor.value = product.description;
        }
        
        // Category - trigger dropdown selection
        if (product.category_id) {
            // Find and click the category in dropdown
            setTimeout(() => {
                const categoryOption = document.querySelector(`[data-category-id="${product.category_id}"]`);
                if (categoryOption) {
                    categoryOption.click();
                }
            }, 100);
        }
        
        // Product Type
        const productTypeMap = {
            'account': 'حساب',
            'digital': 'منتج رقمي',
            'custom': 'مخصص'
        };
        if (product.type && productTypeMap[product.type]) {
            document.getElementById('productTypeValue').textContent = productTypeMap[product.type];
            document.getElementById('productTypeValue').setAttribute('data-type', product.type);
        }
        
        // Status
        const statusMap = {
            'available': 'نشط',
            'unavailable': 'غير نشط'
        };
        if (product.status && statusMap[product.status]) {
            document.getElementById('productStatusValue').textContent = statusMap[product.status];
            document.getElementById('productStatusValue').setAttribute('data-status', product.status);
        }
        
        // SEO Fields
        document.getElementById('seoTitle').value = product.meta_title || '';
        document.getElementById('seoKeywords').value = product.meta_keywords || '';
        document.getElementById('metaDescription').value = product.meta_description || '';
        
        // Coupon Settings
        if (product.coupon_eligible !== undefined) {
            document.getElementById('couponEligible').checked = product.coupon_eligible;
        }
        
        // Display existing main image if available
        if (product.main_image) {
            const mainImagePreview = document.getElementById('mainImagePreview');
            if (mainImagePreview) {
                mainImagePreview.innerHTML = `
                    <div class="relative group">
                        <img src="${window.location.origin}/storage/${product.main_image}" 
                             alt="Main Image" 
                             class="w-full h-48 object-cover rounded-lg">
                        <button type="button" 
                                onclick="@this.call('removeMainImage')"
                                class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                `;
            }
        }
        
        // Display existing gallery images if available
        if (product.gallery && product.gallery.length > 0) {
            const galleryPreview = document.getElementById('galleryImagesPreview');
            if (galleryPreview) {
                product.gallery.forEach((image, index) => {
                    const imageElement = document.createElement('div');
                    imageElement.className = 'relative group';
                    imageElement.innerHTML = `
                        <img src="${window.location.origin}/storage/${image}" 
                             alt="Gallery Image ${index + 1}" 
                             class="w-full h-32 object-cover rounded-lg">
                        <button type="button" 
                                onclick="@this.call('removeExistingGalleryImage', ${index})"
                                class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="ri-delete-bin-line text-sm"></i>
                        </button>
                    `;
                    galleryPreview.appendChild(imageElement);
                });
            }
        }
    });
    </script>




</div>