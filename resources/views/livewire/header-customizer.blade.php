<div>
    <!-- Add Google Fonts for Arabic fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Cairo:wght@300;400;500;700&family=Amiri:wght@400;700&family=Almarai:wght@300;400;700&family=Changa:wght@300;400;500;700&family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;500;700&family=IBM+Plex+Sans+Arabic:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Font Preview Script -->
    <script>
        function updateFontPreview() {
            // Wait for fonts to load and then update preview
            document.fonts.ready.then(function() {
                const fontSelect = document.querySelector('select[wire\\:model\\.live="headerFont"]');
                const preview = document.getElementById('font-preview-box');
                
                if (fontSelect && preview) {
                    const selectedFont = fontSelect.value || 'Tajawal';
                    preview.style.fontFamily = `'${selectedFont}', sans-serif`;
                    
                    // Update font name displays
                    const fontNameDisplay = document.getElementById('current-font-name');
                    if (fontNameDisplay) {
                        fontNameDisplay.textContent = selectedFont;
                    }
                    
                    const activeFontDisplay = document.getElementById('active-font-display');
                    if (activeFontDisplay) {
                        activeFontDisplay.textContent = selectedFont;
                    }
                }
            });
        }

        // Update font preview when page loads
        document.addEventListener('DOMContentLoaded', updateFontPreview);
        
        // Listen for Livewire updates
        document.addEventListener('livewire:updated', updateFontPreview);
    </script>

    <!-- Content Area -->
    <div class="flex-1 p-6 overflow-y-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-white mb-2">تخصيص الهيدر</h1>
            <p class="text-gray-400">قم بتخصيص هيدر الموقع وإعداد الشعار والقوائم والألوان</p>
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

        <!-- Header Customization Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Header General Settings -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center border border-blue-500/30">
                            <i class="ri-settings-4-line text-blue-400 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-white">الإعدادات العامة</h2>
                            <p class="text-xs text-gray-400">إعدادات أساسية لشكل وسلوك الهيدر</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-xs text-gray-400">حالة الهيدر</div>
                            <div class="text-sm font-medium {{ $headerEnabled ? 'text-green-400' : 'text-red-400' }}">
                                {{ $headerEnabled ? 'مفعل' : 'معطل' }}
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="headerEnabled" class="sr-only peer">
                        </label>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Font Selection -->
                    <div class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548]">
                        <h3 class="text-white font-medium mb-4 flex items-center gap-2">
                            <i class="ri-font-size-2 text-purple-400"></i>
                            التخطيط والهيكل
                        </h3>
                        
                        <!-- Enhanced Font Preview -->
                        <div class="p-4 bg-[#1a2234] rounded-lg border border-[#2a3548] mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-3">معاينة الخط المحدد</label>
                            <div id="font-preview-box"
                                 class="bg-white p-6 rounded-lg border-2 border-gray-200 transition-all duration-500" 
                                 style="font-family: '{{ $headerFont ?? 'Tajawal' }}', sans-serif;">
                                <div class="text-gray-800 text-center text-xl font-semibold mb-3">
                                    مرحباً بك في موقعنا الإلكتروني
                                </div>
                                <div class="text-gray-600 text-center text-base mb-3">
                                    هذا نموذج لكيفية ظهور النص في الموقع باستخدام الخط المحدد
                                </div>
                                <div class="text-gray-500 text-center text-sm mb-2">
                                    نص عادي | <strong>نص عريض</strong> | <em>نص مائل</em>
                                </div>
                                <div class="text-gray-700 text-center text-lg font-medium">
                                    <span id="current-font-name">{{ $headerFont ?? 'Tajawal' }}</span>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-400 text-center bg-[#0f1623] p-2 rounded">
                                <i class="ri-information-line ml-1"></i>
                                الخط النشط: <span class="text-blue-400 font-medium" id="active-font-display">{{ $headerFont ?? 'Tajawal' }}</span>
                                | يتم التحديث تلقائياً عند تغيير الخط
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">خط الموقع</label>
                            <select wire:model.live="headerFont" 
                                    onchange="updateFontPreview()" 
                                    class="bg-[#1a2234] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 hover:border-[#3a4558]">
                                <option value="Tajawal">تجوال (Tajawal)</option>
                                <option value="Cairo">القاهرة (Cairo)</option>
                                <option value="Amiri">أميري (Amiri)</option>
                                <option value="Noto Sans Arabic">نوتو سانس عربي (Noto Sans Arabic)</option>
                                <option value="Almarai">المرعى (Almarai)</option>
                                <option value="Changa">تشانجا (Changa)</option>
                                <option value="IBM Plex Sans Arabic">IBM Plex Sans Arabic</option>
                                <option value="Rubik">روبيك (Rubik)</option>
                            </select>
                            @error('headerFont') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Behavior Settings -->
                    <div class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548]">
                        <h3 class="text-white font-medium mb-4 flex items-center gap-2">
                            <i class="ri-settings-3-line text-green-400"></i>
                            سلوك الهيدر
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- Position Settings -->
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-[#1a2234] rounded-lg border border-[#2a3548]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center">
                                            <i class="ri-pushpin-line text-blue-400 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">هيدر ثابت</div>
                                            <div class="text-xs text-gray-400">يبقى مثبت أعلى الصفحة</div>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="headerSticky" class="sr-only peer">
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-[#1a2234] rounded-lg border border-[#2a3548]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-purple-500/10 flex items-center justify-center">
                                            <i class="ri-contrast-drop-line text-purple-400 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">ظل الهيدر</div>
                                            <div class="text-xs text-gray-400">إضافة ظل أسفل الهيدر</div>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="headerShadow" class="sr-only peer">
                                    </label>
                                </div>
                            </div>

                            <!-- Animation Settings -->
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-[#1a2234] rounded-lg border border-[#2a3548]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-pink-500/10 flex items-center justify-center">
                                            <i class="ri-magic-line text-pink-400 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">تأثيرات التمرير</div>
                                            <div class="text-xs text-gray-400">تأثيرات عند التمرير</div>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="headerScrollEffects" class="sr-only peer">
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-[#1a2234] rounded-lg border border-[#2a3548]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-500/10 flex items-center justify-center">
                                            <i class="ri-speed-line text-indigo-400 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">انتقالات سلسة</div>
                                            <div class="text-xs text-gray-400">حركات ناعمة للعناصر</div>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="headerSmoothTransitions" class="sr-only peer">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Options -->
                    <div class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548]">
                        <h3 class="text-white font-medium mb-4 flex items-center gap-2">
                            <i class="ri-tools-line text-red-400"></i>
                            خيارات متقدمة
                        </h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">كود CSS مخصص</label>
                            <textarea wire:model.live="headerCustomCSS" 
                                class="bg-[#1a2234] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-blue-500 focus:outline-none font-mono text-sm"
                                placeholder="border-radius: 0px; backdrop-filter: blur(10px);"
                                rows="2"></textarea>
                            <div class="text-xs text-gray-400 mt-1">أضف كود CSS مخصص للهيدر</div>
                        </div>
                    </div>

                    <!-- Preview Status -->
                    @if($headerEnabled)
                    <div class="bg-gradient-to-r from-green-500/10 to-green-600/10 border border-green-500/30 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                                <i class="ri-checkbox-circle-line text-green-400"></i>
                            </div>
                            <div>
                                <div class="text-green-400 font-medium">الهيدر مفعل ومجهز للعرض</div>
                                <div class="text-green-300/70 text-sm">
                                    التخطيط: {{ $headerLayout ?? 'افتراضي' }} | الارتفاع: {{ $headerHeight ?? 80 }}px | 
                                    @if($headerSticky) ثابت @endif @if($headerShadow) مع ظل @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-gradient-to-r from-orange-500/10 to-orange-600/10 border border-orange-500/30 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-orange-500/20 flex items-center justify-center">
                                <i class="ri-pause-circle-line text-orange-400"></i>
                            </div>
                            <div>
                                <div class="text-orange-400 font-medium">الهيدر معطل حالياً</div>
                                <div class="text-orange-300/70 text-sm">قم بتفعيل الهيدر لرؤية التغييرات على الموقع</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Logo Settings -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center">
                            <i class="ri-image-line text-orange-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">إعدادات الشعار</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="logoEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض الشعار</span>
                    </label>
                </div>

                <!-- Logo Preview -->
                @if($logoEnabled)
                <div class="mb-6 p-4 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                    <label class="block text-sm font-medium text-gray-300 mb-3">
                        معاينة الشعار
                    </label>
                    <div class="flex items-center @if(($logoPosition ?? 'left') == 'left') justify-start @elseif($logoPosition == 'center') justify-center @else justify-end @endif p-4 bg-gradient-to-r from-gray-800 to-gray-700 rounded-lg">
                        <div class="flex items-center gap-3">
                            <!-- Logo Image Preview -->
                            <div 
                                wire:key="logo-preview-{{ $logoBorderRadius ?? 'rounded-lg' }}-{{ $logoShadowEnabled ? ($logoShadowClass ?? 'shadow-lg') . '-' . ($logoShadowColor ?? 'gray-500') . '-' . ($logoShadowOpacity ?? '50') : 'none' }}"
                                class="bg-white flex items-center justify-center border-2 border-gray-300 overflow-hidden transition-all duration-300 {{ $logoBorderRadius ?? 'rounded-lg' }} {{ $logoShadowEnabled ? ($logoShadowClass ?? 'shadow-lg') . ' shadow-' . ($logoShadowColor ?? 'gray-500') . '/' . ($logoShadowOpacity ?? '50') : '' }}"
                                style="width: {{ $logoWidth ?? 150 }}px; height: {{ $logoHeight ?? 50 }}px;">
                                @if(!empty($logoImage))
                                    <img src="{{ Storage::disk('public')->url($logoImage) }}" alt="Logo" class="w-full h-full object-contain">
                                @elseif(!empty($logoSvg))
                                    <div class="w-full h-full flex items-center justify-center text-gray-600" style="font-size: {{ min($logoWidth ?? 150, $logoHeight ?? 50) * 0.6 }}px;">
                                        {!! $logoSvg !!}
                                    </div>
                                @else
                                    <div class="text-gray-600 text-xs font-semibold">LOGO</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-400 text-center">
                        الأبعاد: {{ $logoWidth ?? 150 }} × {{ $logoHeight ?? 50 }} بكسل | الموضع: {{ $logoPosition ?? 'يسار' }} | 
                        الحواف: <span class="text-blue-400">{{ $logoBorderRadius ?? 'rounded-lg' }}</span> |
                        الظل: <span class="text-green-400">{{ $logoShadowEnabled ? ($logoShadowClass ?? 'shadow-lg') . ' shadow-' . ($logoShadowColor ?? 'gray-500') . '/' . ($logoShadowOpacity ?? '50') : 'معطل' }}</span>
                    </div>
                </div>
                @endif

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">العرض (px)</label>
                            <input type="number" wire:model.live="logoWidth" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="150" min="50" max="300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">الارتفاع (px)</label>
                            <input type="number" wire:model.live="logoHeight" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="50" min="30" max="120">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">موضع الشعار</label>
                        <select wire:model.live="logoPosition" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                            <option value="left">يمين</option>
                            <!-- <option value="center">وسط</option> -->
                            <option value="right">يسار</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">شكل حواف الشعار</label>
                        <select wire:model.live="logoBorderRadius" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                            <option value="rounded-none">بدون حواف (مربع)</option>
                            <option value="rounded-sm">حواف صغيرة</option>
                            <option value="rounded">حواف عادية</option>
                            <option value="rounded-lg">حواف كبيرة</option>
                            <option value="rounded-full">دائرية كاملة</option>
                        </select>
                        @error('logoBorderRadius') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">نوع ظل الشعار</label>
                        <select wire:model.live="logoShadowClass" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                            <option value="">بدون ظل</option>
                            <option value="shadow-sm">ظل خفيف</option>
                            <option value="shadow">ظل عادي</option>
                            <option value="shadow-md">ظل متوسط</option>
                            <option value="shadow-lg">ظل كبير</option>
                            <option value="shadow-xl">ظل كبير جداً</option>
                            <option value="shadow-2xl">ظل ضخم</option>
                        </select>
                        @error('logoShadowClass') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">لون الظل</label>
                            <select wire:model.live="logoShadowColor" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="gray-500">رمادي</option>
                                <option value="red-500">أحمر</option>
                                <option value="blue-500">أزرق</option>
                                <option value="green-500">أخضر</option>
                                <option value="yellow-500">أصفر</option>
                                <option value="purple-500">بنفسجي</option>
                                <option value="pink-500">وردي</option>
                                <option value="indigo-500">نيلي</option>
                                <option value="orange-500">برتقالي</option>
                                <option value="teal-500">تيل</option>
                                <option value="cyan-500">سماوي</option>
                                <option value="slate-500">إردوازي</option>
                                <option value="black">أسود</option>
                                <option value="white">أبيض</option>
                            </select>
                            @error('logoShadowColor') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">شفافية الظل</label>
                            <select wire:model.live="logoShadowOpacity" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                                <option value="25">25%</option>
                                <option value="30">30%</option>
                                <option value="40">40%</option>
                                <option value="50">50%</option>
                                <option value="60">60%</option>
                                <option value="70">70%</option>
                                <option value="75">75%</option>
                                <option value="80">80%</option>
                                <option value="90">90%</option>
                                <option value="100">100%</option>
                            </select>
                            @error('logoShadowOpacity') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="logoShadowEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل ظل الشعار</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                            <i class="ri-menu-line text-purple-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">قائمة التنقل</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="navigationEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">تفعيل القائمة</span>
                    </label>
                </div>

                <!-- New Menu Item Form -->
                <div class="mb-6 p-4 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                    <h3 class="text-white text-lg font-medium mb-4">إضافة عنصر جديد</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">نص القائمة</label>
                            <input type="text" wire:model="newMenuItem.name" class="bg-[#111827] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="اسم العنصر">
                            @error('newMenuItem.name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">رابط URL</label>
                            <input type="text" wire:model="newMenuItem.url" class="bg-[#111827] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="https://example.com">
                            @error('newMenuItem.url') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Icon Selector for New Item -->
                    <div class="mb-4">
                        <label class="text-sm text-gray-400 mb-2 block">اختر أيقونة:</label>
                        <div>
                            @livewire('icon-select-input', [
                                'value' => $newMenuItem['svg'] ?? '',
                                'wireModel' => 'newMenuItem.svg',
                                'placeholder' => 'اختر أيقونة',
                                'customClass' => 'custom-input p-3 rounded-md w-full'
                            ], key('new-item-icon-selector'))
                        </div>
                        
                        <!-- Icon Preview -->
                        @if(!empty($newMenuItem['svg']))
                            <div class="mt-2 p-3 bg-gray-800/50 rounded-lg border border-gray-600">
                                <div class="flex items-center gap-3 text-sm text-gray-300">
                                    <span>معاينة الأيقونة المحددة:</span>
                                    <i class="{{ $newMenuItem['svg'] }} text-blue-400 text-lg"></i>
                                    <code class="text-xs text-gray-400 bg-gray-700/50 px-2 py-1 rounded">{{ $newMenuItem['svg'] }}</code>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Image Upload for New Item -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">رفع صورة (اختياري)</label>
                        <input type="file" wire:model="newMenuItem.uploadedImage" accept="image/*"
                            class="bg-[#111827] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                        @error('newMenuItem.uploadedImage') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        
                        @if($newMenuItem['uploadedImage'])
                            <div class="mt-2" wire:loading.remove wire:target="newMenuItem.uploadedImage">
                                <img src="{{ $newMenuItem['uploadedImage']->temporaryUrl() }}" alt="Preview" class="w-16 h-16 rounded object-cover">
                            </div>
                            <div class="mt-2 text-gray-400" wire:loading wire:target="newMenuItem.uploadedImage">
                                جاري رفع الصورة...
                            </div>
                        @endif
                    </div>

                    <!-- Tailwind Code Input -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">كود CSS إضافي (اختياري)</label>
                        <textarea wire:model="newMenuItem.tailwind_code" 
                            class="bg-[#111827] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none"
                            placeholder="bg-blue-500 text-white px-4 py-2"
                            rows="2"></textarea>
                        @error('newMenuItem.tailwind_code') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button wire:click="addMenuItem" type="button"
                            class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg">
                            <i class="ri-add-line ml-1"></i>
                            إضافة العنصر
                        </button>
                    </div>
                </div>

                <!-- Menu Preview Section -->
                @if($showHomeLink || $mainMenusEnabled || $showCategoriesInMenu)
                <div class="mb-6 p-4 bg-[#0f1623] border border-[#2a3548] rounded-lg">
                    <h3 class="text-white text-lg font-medium mb-4">معاينة القائمة</h3>
                    <div class="bg-gradient-to-r from-gray-800 to-gray-700 rounded-lg p-4">
                        <div class="flex items-center gap-6 flex-wrap">
                            @if($showHomeLink)
                                <div class="flex items-center gap-2 text-white hover:text-blue-400 transition-colors cursor-pointer">
                                    <i class="ri-home-line text-sm"></i>
                                    <span class="text-sm font-medium">الرئيسية</span>
                                </div>
                            @endif
                            
                            @if($mainMenusEnabled)
                                @if(count($menuItems) > 0)
                                    @foreach(array_slice($menuItems, 0, $mainMenusNumber ?? 5) as $item)
                                        @if($item['is_active'])
                                            <div class="flex items-center gap-2 text-white hover:text-blue-400 transition-colors cursor-pointer {{ $item['tailwind_code'] ?? '' }}">
                                                @if(!empty($item['image']))
                                                    <img src="{{ Storage::disk('public')->url($item['image']) }}" alt="{{ $item['name'] }}" class="w-4 h-4 rounded object-cover">
                                                @elseif(!empty($item['svg']))
                                                    <i class="{{ $item['svg'] }} text-sm"></i>
                                                @else
                                                    <i class="ri-menu-2-line text-sm"></i>
                                                @endif
                                                <span class="text-sm font-medium">{{ $item['name'] ?? 'عنصر' }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="flex items-center gap-2 text-gray-400 italic">
                                        <i class="ri-menu-line text-sm"></i>
                                        <span class="text-sm">القوائم الرئيسية ({{ $mainMenusNumber ?? 5 }}) - لا توجد عناصر</span>
                                    </div>
                                @endif
                            @endif
                            
                            @if($showCategoriesInMenu)
                                <div class="flex items-center gap-2 text-white hover:text-blue-400 transition-colors cursor-pointer">
                                    <i class="ri-list-check text-sm"></i>
                                    <span class="text-sm font-medium">التصنيفات ({{ $categoriesCount ?? 5 }})</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-400 text-center">
                        معاينة كيف ستظهر عناصر القائمة في الهيدر الفعلي (العناصر المفعلة فقط - مرتبة حسب قاعدة البيانات)
                        @if($mainMenusEnabled && count($menuItems) > 0)
                        <br>عدد القوائم المعروضة: {{ min(count(array_filter($menuItems, fn($item) => $item['is_active'])), $mainMenusNumber ?? 5) }} من {{ count(array_filter($menuItems, fn($item) => $item['is_active'])) }}
                        @endif
                    </div>
                </div>
                @endif

                <div class="space-y-4 mb-4">
                    <div class="flex items-center gap-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="showHomeLink" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">عرض رابط الرئيسية</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="mainMenusEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">عرض القوائم الرئيسية</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="showCategoriesInMenu" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">عرض التصنيفات</span>
                        </label>
                    </div>
                    
                    @if($mainMenusEnabled)
                    <div class="bg-[#0f1623] border border-[#2a3548] rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center flex-shrink-0">
                                <i class="ri-menu-line text-green-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-300 mb-2">عدد القوائم الرئيسية المعروضة</label>
                                <input type="number" wire:model.live="mainMenusNumber" min="1" max="20" 
                                    class="bg-[#1a2234] border border-[#2a3548] text-white w-20 p-2 rounded-lg focus:border-green-400 focus:outline-none transition-colors text-center"
                                    placeholder="5">
                                @error('mainMenusNumber') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="text-xs text-gray-400">
                                <div>القوائم: 1-20</div>
                                <div>الافتراضي: 5</div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($showCategoriesInMenu)
                    <div class="bg-[#0f1623] border border-[#2a3548] rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                <i class="ri-hash text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-300 mb-2">عدد التصنيفات المعروضة</label>
                                <input type="number" wire:model.live="categoriesCount" min="1" max="20" 
                                    class="bg-[#1a2234] border border-[#2a3548] text-white w-20 p-2 rounded-lg focus:border-blue-400 focus:outline-none transition-colors text-center"
                                    placeholder="5">
                                @error('categoriesCount') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="text-xs text-gray-400">
                                <div>التصنيفات: 1-20</div>
                                <div>الافتراضي: 5</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Existing Menu Items Display -->
                <div class="space-y-3">
                    @forelse($menuItems as $index => $item)
                    <div wire:key="menu-item-{{ $item['id'] ?? $index }}" class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548] hover:border-[#3a4558] transition-colors duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <!-- Menu Item Image or Icon -->
                                <div class="w-10 h-10 rounded-lg bg-[#1a2234] border border-[#2a3548] flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if(!empty($item['image']))
                                        <img src="{{ Storage::disk('public')->url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                                    @elseif(!empty($item['svg']))
                                        <i class="{{ $item['svg'] }} text-blue-400 text-lg"></i>
                                    @else
                                        <i class="ri-menu-2-line text-gray-400"></i>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="text-white font-medium">{{ $item['name'] ?? 'عنصر بدون اسم' }}</div>
                                        @if($item['is_active'])
                                            <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs font-medium">مفعل</span>
                                        @else
                                            <span class="bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full text-xs font-medium">معطل</span>
                                        @endif
                                    </div>
                                    
                                    @if(!empty($item['url']))
                                        <div class="text-gray-400 text-sm mb-1">
                                            <i class="ri-link text-xs ml-1"></i>
                                            {{ $item['url'] }}
                                        </div>
                                    @endif
                                    
                                    @if(!empty($item['tailwind_code']))
                                        <div class="text-xs text-indigo-400 mb-1">
                                            <i class="ri-code-line text-xs ml-1"></i>
                                            <code class="bg-gray-800/50 px-2 py-1 rounded text-xs">{{ Str::limit($item['tailwind_code'], 30) }}</code>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span><i class="ri-sort-asc text-xs ml-1"></i>ترتيب: {{ $item['order'] ?? 0 }}</span>
                                        <span><i class="ri-calendar-line text-xs ml-1"></i>ID: {{ $item['id'] ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-1">
                                <!-- Toggle Status Button -->
                                <button wire:click="toggleMenuItemStatus({{ $index }})" type="button" 
                                    class="text-gray-400 hover:text-{{ $item['is_active'] ? 'orange' : 'green' }}-400 transition-colors duration-300 p-2 rounded-lg hover:bg-gray-800/50" 
                                    title="{{ $item['is_active'] ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                    <i class="ri-{{ $item['is_active'] ? 'pause-circle' : 'play-circle' }}-line text-lg"></i>
                                </button>
                                
                                <!-- Drag Handle -->
                                <button class="text-gray-400 hover:text-blue-400 transition-colors duration-300 cursor-grab p-2 rounded-lg hover:bg-gray-800/50" 
                                    title="إعادة ترتيب"
                                    draggable="true">
                                    <i class="ri-drag-move-2-line text-lg"></i>
                                </button>
                                
                                <!-- Delete Button -->
                                <button wire:click="removeMenuItem({{ $index }})" type="button" 
                                    class="text-gray-400 hover:text-red-400 transition-colors duration-300 p-2 rounded-lg hover:bg-red-900/20" 
                                    onclick="return confirm('هل أنت متأكد من حذف هذا العنصر؟ سيتم حذف الصورة المرفقة أيضاً إن وجدت.')" 
                                    title="حذف العنصر">
                                    <i class="ri-delete-bin-2-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-400">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-800/50 flex items-center justify-center">
                            <i class="ri-menu-line text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">لا توجد عناصر في القائمة</h3>
                        <p class="text-sm mb-4">قم بإضافة عنصر جديد لبناء قائمة التنقل الخاصة بك</p>
                        <div class="text-xs text-gray-500">
                            يمكنك إضافة عناصر بالنصوص والروابط والأيقونات والصور
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Header Features -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <i class="ri-function-line text-green-400"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-white">المميزات الإضافية</h2>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-3">
                        <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                            <input type="checkbox" wire:model="searchBarEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">شريط البحث</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                            <input type="checkbox" wire:model="userMenuEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">قائمة المستخدم</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                            <input type="checkbox" wire:model="shoppingCartEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">سلة التسوق</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                            <input type="checkbox" wire:model="wishlistEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">قائمة الأمنيات</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                            <input type="checkbox" wire:model="languageSwitcherEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">مبدل اللغة</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                            <input type="checkbox" wire:model="currencySwitcherEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">مبدل العملة</span>
                        </label>
                        
                        <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                            <input type="checkbox" wire:model="settingsEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="mr-3 text-sm font-medium text-gray-300">تفعيل الإعدادات</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Contact Information in Header -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                            <i class="ri-phone-line text-yellow-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">معلومات الاتصال</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="headerContactEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض في الهيدر</span>
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">رقم الهاتف</label>
                        <input type="text" wire:model="headerPhone" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors"
                            placeholder="+966 55 123 4567">
                        @error('headerPhone') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">البريد الإلكتروني</label>
                        <input type="email" wire:model="headerEmail" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors"
                            placeholder="info@example.com">
                        @error('headerEmail') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">موضع عرض المعلومات</label>
                        <select wire:model="contactPosition" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none">
                            <option value="top">أعلى الهيدر</option>
                            <option value="main">في الهيدر الرئيسي</option>
                            <option value="right">يمين الهيدر</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Header Settings -->
        <div class="mt-6">
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                        <i class="ri-smartphone-line text-indigo-400"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-white">إعدادات الهاتف المحمول</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                        <input type="checkbox" wire:model="mobileMenuEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">قائمة الهاتف</span>
                    </label>
                    
                    <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                        <input type="checkbox" wire:model="mobileSearchEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">بحث الهاتف</span>
                    </label>
                    
                    <label class="relative inline-flex items-center cursor-pointer bg-[#0f1623] border border-[#2a3548] rounded-lg p-3">
                        <input type="checkbox" wire:model="mobileCartEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">سلة الهاتف</span>
                    </label>
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
</div>
