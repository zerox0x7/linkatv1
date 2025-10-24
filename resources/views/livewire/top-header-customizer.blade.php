{{-- Be like water. --}}
<div>
    <!-- Content Area -->
    <div class="flex-1 p-6 overflow-y-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-white mb-2">تخصيص الهيدر العلوي المتحرك</h1>
            <p class="text-gray-400">قم بتخصيص الهيدر العلوي المتحرك مع خيارات الحركة والاتجاه والقوالب الجاهزة</p>
        </div>

        <!-- Theme Links Section -->
        <div class="mb-6">
            @livewire('theme-links')
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

        <!-- Modern Templates Section -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                    <i class="ri-palette-line text-black"></i>
                </div>
                <h2 class="text-xl font-semibold text-white">القوالب الجاهزة</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Template 1: Right to Left Moving News -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-white font-medium mb-2">أخبار متحركة - يمين إلى يسار</h3>
                        <p class="text-gray-400 text-sm mb-3">نص إخباري يتحرك من اليمين إلى اليسار</p>
                    </div>
                    <!-- Preview -->
                    <div class="bg-blue-600 text-white py-2 px-4 relative overflow-hidden h-10">
                        <div class="animate-scroll-rtl whitespace-nowrap">
                            🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن!
                        </div>
                    </div>
                    <div class="p-4">
                        <button wire:click="applyTemplate('rtl_news')" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition-colors">
                            تطبيق هذا القالب
                        </button>
                    </div>
                </div>

                <!-- Template 2: Left to Right Moving News -->
                <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-white font-medium mb-2">أخبار متحركة - يسار إلى يمين</h3>
                        <p class="text-gray-400 text-sm mb-3">نص إخباري يتحرك من اليسار إلى اليمين</p>
                    </div>
                    <!-- Preview -->
                    <div class="bg-green-600 text-white py-2 px-4 relative overflow-hidden h-10">
                        <div class="animate-scroll-ltr whitespace-nowrap">
                            ✨ أحدث المنتجات وصلت! تسوق الآن واحصل على شحن مجاني
                        </div>
                    </div>
                    <div class="p-4">
                        <button wire:click="applyTemplate('ltr_news')" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg text-sm transition-colors">
                            تطبيق هذا القالب
                        </button>
                    </div>
                </div>

                <!-- Template 3: Fixed with Social & Contact -->
                <div class="relative group bg-gradient-to-br from-[#121827] via-[#1a2234] to-[#0f1623] rounded-xl border-2 border-purple-500/30 overflow-hidden shadow-2xl hover:shadow-purple-500/20 transition-all duration-500 hover:scale-105">
                    <!-- Magical Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 via-transparent to-pink-500/10 opacity-50"></div>
                    
                    <!-- Customizable Badge -->
                    <div class="absolute top-3 left-3 z-10">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs px-2 py-1 rounded-full font-semibold shadow-lg animate-pulse">
                            <i class="ri-palette-line mr-1"></i>
                            قابل للتخصيص ✨
                        </div>
                    </div>
                    
                    <div class="relative z-10 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <i class="ri-contacts-line text-purple-400"></i>
                            </div>
                            <h3 class="text-white font-medium">ثابت مع التواصل</h3>
                        </div>
                        <p class="text-gray-400 text-sm mb-3">هيدر ثابت مع معلومات التواصل والشبكات الاجتماعية</p>
                        
                        <!-- Customization Tip -->
                        <div class="bg-purple-500/10 border border-purple-500/20 rounded-lg p-2 mb-3">
                            <div class="flex items-center gap-2">
                                <i class="ri-magic-line text-purple-400 text-sm"></i>
                                <span class="text-xs text-purple-300 font-medium">
                                    يمكنك تخصيص الألوان، النصوص، والأيقونات!
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview -->
                    <div class="bg-slate-800 text-white py-2 px-4 h-10 relative">
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-4">
                                <span>📞 +966 55 123 4567</span>
                                <span>✉️ info@example.com</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="ri-facebook-fill"></i>
                                <i class="ri-twitter-fill"></i>
                                <i class="ri-instagram-line"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative z-10 p-4">
                        <button wire:click="applyTemplate('fixed_contact')" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition-all duration-300 shadow-lg hover:shadow-purple-500/25">
                            <i class="ri-magic-line ml-2"></i>
                            تطبيق وبدء التخصيص
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Header Customization Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Movement Settings -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                            <i class="ri-play-line text-blue-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">إعدادات الحركة</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="topHeaderEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">تفعيل الهيدر المتحرك</span>
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">نوع الحركة</label>
                        <select wire:model="movementType" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors">
                            <option value="scroll">نص متحرك</option>
                            <option value="fixed">ثابت</option>
                            <option value="fade">تلاشي متدرج</option>
                            <option value="slide">انزلاق</option>
                        </select>
                        @error('movementType') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">اتجاه الحركة</label>
                        <select wire:model="movementDirection" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors">
                            <option value="rtl">من اليمين إلى اليسار</option>
                            <option value="ltr">من اليسار إلى اليمين</option>
                            <option value="up">من الأسفل إلى الأعلى</option>
                            <option value="down">من الأعلى إلى الأسفل</option>
                        </select>
                        @error('movementDirection') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">سرعة الحركة (ثانية)</label>
                        <input type="range" wire:model="animationSpeed" min="5" max="60" step="1" 
                            class="w-full h-2 bg-[#2a3548] rounded-lg appearance-none cursor-pointer slider">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>سريع (5s)</span>
                            <span class="text-white">{{ $animationSpeed ?? 20 }}s</span>
                            <span>بطيء (60s)</span>
                        </div>
                        @error('animationSpeed') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">توقف عند التمرير</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="pauseOnHover" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">تكرار مستمر</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="infiniteLoop" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>
                </div>
            </div>

            <!-- Content & Style Settings -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <i class="ri-text text-green-400"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-white">المحتوى والتصميم</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">نص الهيدر</label>
                        <textarea wire:model="headerText" rows="3" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors resize-none"
                            placeholder="🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن!"></textarea>
                        @error('headerText') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">رابط عند الضغط (اختياري)</label>
                        <input type="url" wire:model="headerLink" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors"
                            placeholder="https://example.com/offers">
                        @error('headerLink') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">ارتفاع الهيدر (بكسل)</label>
                        <input type="number" wire:model="topHeaderHeight" min="30" max="120" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors"
                            placeholder="30">
                        @error('topHeaderHeight') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">حجم الخط</label>
                        <select wire:model="fontSize" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors">
                            <option value="12px">صغير (12px)</option>
                            <option value="14px">متوسط (14px)</option>
                            <option value="16px">كبير (16px)</option>
                            <option value="18px">كبير جداً (18px)</option>
                        </select>
                        @error('fontSize') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">وزن الخط</label>
                        <select wire:model="fontWeight" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors">
                            <option value="300">خفيف</option>
                            <option value="400">عادي</option>
                            <option value="500">متوسط</option>
                            <option value="600">سميك</option>
                            <option value="700">سميك جداً</option>
                        </select>
                        @error('fontWeight') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Color Settings -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                        <i class="ri-palette-line text-purple-400"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-white">الألوان والتأثيرات</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">لون الخلفية</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model="topHeaderBackgroundColor" class="w-12 h-12 rounded-lg border border-[#2a3548] bg-[#0f1623] cursor-pointer">
                            <input type="text" wire:model="topHeaderBackgroundColor" class="bg-[#0f1623] border border-[#2a3548] text-white flex-1 p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="#3b82f6">
                        </div>
                        @error('topHeaderBackgroundColor') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">لون النص</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model="topHeaderTextColor" class="w-12 h-12 rounded-lg border border-[#2a3548] bg-[#0f1623] cursor-pointer">
                            <input type="text" wire:model="topHeaderTextColor" class="bg-[#0f1623] border border-[#2a3548] text-white flex-1 p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="#ffffff">
                        </div>
                        @error('topHeaderTextColor') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">تدرج الخلفية</label>
                        <select wire:model="backgroundGradient" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors">
                            <option value="none">بدون تدرج</option>
                            <option value="linear-gradient(90deg, #3b82f6, #1d4ed8)">أزرق</option>
                            <option value="linear-gradient(90deg, #10b981, #047857)">أخضر</option>
                            <option value="linear-gradient(90deg, #f59e0b, #d97706)">برتقالي</option>
                            <option value="linear-gradient(90deg, #ef4444, #dc2626)">أحمر</option>
                            <option value="linear-gradient(90deg, #8b5cf6, #7c3aed)">بنفسجي</option>
                        </select>
                        @error('backgroundGradient') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">تأثير الظلال</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="enableShadow" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">شفافية الخلفية</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="enableOpacity" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>
                </div>
            </div>

            <!-- Additional Content -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center">
                        <i class="ri-add-box-line text-orange-400"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-white">عناصر إضافية</h2>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">إضافة معلومات الاتصال</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="contactEnabled" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div class="grid grid-cols-1 gap-3" x-show="$wire.contactEnabled || false" style="display: none;" x-transition>
                        <input type="text" wire:model="topHeaderPhone" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-2 rounded-lg text-sm focus:border-primary focus:outline-none"
                            placeholder="رقم الهاتف">
                        <input type="email" wire:model="topHeaderEmail" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-2 rounded-lg text-sm focus:border-primary focus:outline-none"
                            placeholder="البريد الإلكتروني">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">إضافة أيقونات التواصل الاجتماعي</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="showSocialIcons" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">زر إغلاق الهيدر</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="showCloseButton" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">عداد تنازلي (للعروض)</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="showCountdown" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">روابط المصادقة (تسجيل دخول/إنشاء حساب)</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="authLinksEnabled" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-300">نص فقط (بدون عناصر إضافية)</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="textOnly" class="ml-2 toggle-switch sr-only">
                        </label>
                    </div>

                    <div x-show="$wire.showCountdown || false" style="display: none;" x-transition>
                        <label class="block text-sm font-medium text-gray-300 mb-2">تاريخ انتهاء العرض</label>
                        <input type="datetime-local" wire:model="countdownDate" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors">
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Preview -->
        <div class="mt-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                    <i class="ri-eye-line text-yellow-400"></i>
                </div>
                <h2 class="text-lg font-semibold text-white">معاينة مباشرة</h2>
            </div>
            
            <div class="bg-[#0f1623] rounded-xl border border-[#2a3548] overflow-hidden">
                <div class="p-4 border-b border-[#2a3548]">
                    <span class="text-gray-400 text-sm">معاينة الهيدر العلوي:</span>
                </div>
                <div id="header-preview" class="relative overflow-hidden"
                    style="height: {{ $topHeaderHeight ?? 30 }}px; 
                           background: {{ ($backgroundGradient ?? 'none') !== 'none' ? ($backgroundGradient ?? 'none') : ($topHeaderBackgroundColor ?? '#3b82f6') }};">
                    
                    @if(($movementType ?? 'scroll') === 'scroll')
                        <div class="preview-scroll-text whitespace-nowrap flex items-center h-full px-4"
                            style="color: {{ $topHeaderTextColor ?? '#ffffff' }}; 
                                   font-size: {{ $fontSize ?? '14px' }}; 
                                   font-weight: {{ $fontWeight ?? '400' }};">
                            {{ $headerText ?? '🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن!' }}
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full px-4"
                            style="color: {{ $topHeaderTextColor ?? '#ffffff' }}; 
                                   font-size: {{ $fontSize ?? '14px' }}; 
                                   font-weight: {{ $fontWeight ?? '400' }};">
                            {{ $headerText ?? '🔥 عرض خاص: خصم 50% على جميع المنتجات حتى نهاية الشهر - اطلب الآن!' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-6 flex justify-end">
            <button wire:click="save" type="button" class="bg-gradient-to-r from-primary to-secondary text-black px-6 py-3 rounded-lg font-medium hover:from-primary/90 hover:to-secondary/90 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="ri-save-line ml-2"></i>
                حفظ التغييرات
            </button>
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

        /* Slider Styles */
        .slider::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            background: #00e5bb;
            border-radius: 50%;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #00e5bb;
            border-radius: 50%;
            cursor: pointer;
            border: none;
        }

        /* Animation Styles */
        @keyframes scroll-rtl {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        @keyframes scroll-ltr {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .animate-scroll-rtl {
            animation: scroll-rtl 20s linear infinite;
        }

        .animate-scroll-ltr {
            animation: scroll-ltr 20s linear infinite;
        }

        .preview-scroll-text {
            animation: scroll-rtl {{ $animationSpeed ?? 20 }}s linear infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .animate-scroll-rtl,
            .animate-scroll-ltr,
            .preview-scroll-text {
                animation-duration: 15s;
            }
        }
    </style>

    <script>
        document.addEventListener('livewire:init', () => {
            // Update preview animation when direction changes
            Livewire.on('updatePreview', () => {
                const previewElement = document.querySelector('.preview-scroll-text');
                if (previewElement) {
                    const direction = @json($movementDirection ?? 'rtl');
                    const speed = @json($animationSpeed ?? 20);
                    
                    previewElement.style.animation = `scroll-${direction} ${speed}s linear infinite`;
                }
            });
        });
    </script>
</div>