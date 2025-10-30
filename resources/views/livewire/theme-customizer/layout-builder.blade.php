<div class="p-8">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/50 rounded-xl text-green-400 animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="ri-checkbox-circle-line text-2xl"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-orange-500/20 to-red-500/20 flex items-center justify-center">
            <i class="ri-layout-grid-line text-orange-400"></i>
        </div>
        أداة ترتيب الصناديق الثابتة (Layout Builder)
    </h3>

    <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548] mb-6">
        <div class="flex items-start gap-2">
            <i class="ri-information-line text-primary text-xl mt-1"></i>
            <div class="text-gray-300 text-sm">
                <p class="mb-2">هذه الأداة تتيح لك ترتيب الصناديق الثابتة التي تظهر على صفحتك الرئيسية.</p>
                <p>اسحب الصناديق لإعادة ترتيبها، وانقر على أي صندوق لتعديل محتواه.</p>
            </div>
        </div>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-12 gap-4">
        <!-- Visual Layout Grid (Left Side - 8 columns) -->
        <div class="col-span-12 lg:col-span-8">
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="ri-layout-grid-line"></i>
                    تخطيط الصفحة الرئيسية
                </h4>
                
                @php
                    $activeTheme = \App\Models\Setting::get('active_theme', 'torganic');
                    $currentTheme = strtolower($activeTheme);
                    $layoutComponent = "components.theme-layouts.{$currentTheme}";
                @endphp
                
                @if(view()->exists($layoutComponent))
                    @include($layoutComponent, ['layoutBoxes' => $layoutBoxes, 'imageSizes' => $imageSizes])
                @else
                    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4 text-yellow-300">
                        <p class="text-sm">Layout component not found for theme: {{ $activeTheme }}</p>
                        <p class="text-xs mt-2">Looking for: {{ $layoutComponent }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Available Boxes & Editor Sidebar (Right Side - 4 columns) -->
        <div class="col-span-12 lg:col-span-4">
            <!-- Editor Section (when box selected) -->
            @if($selectedBox)
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548] mb-4 sticky top-4">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="ri-edit-box-line"></i>
                        تعديل الصندوق
                    </h4>
                    <button type="button" 
                            wire:click="$set('selectedBox', null)"
                            class="text-gray-400 hover:text-white transition-colors">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>

                @if(isset($selectedBox['image_preview']) && $selectedBox['image_preview'])
                    <div class="mb-4">
                        <img src="{{ $selectedBox['image_preview'] }}" 
                             alt="{{ $selectedBox['title'] ?? '' }}" 
                             class="w-full h-32 object-cover rounded-lg">
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">العنوان</label>
                        <input type="text" 
                               wire:model="selectedBox.title"
                               class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                               placeholder="أدخل العنوان">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">العنوان الفرعي</label>
                        <textarea wire:model="selectedBox.subtitle" 
                                  rows="2"
                                  class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                                  placeholder="أدخل العنوان الفرعي"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">نص الزر</label>
                        <input type="text" 
                               wire:model="selectedBox.button_text"
                               class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                               placeholder="تسوق الآن">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">رابط الزر</label>
                        <input type="text" 
                               wire:model="selectedBox.button_link"
                               class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                               placeholder="/products">
                    </div>

                    <div class="pt-4">
                        <button type="button" 
                                wire:click="updateSelectedBox"
                                class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium">
                            <i class="ri-save-line ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Available Boxes -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548] {{ $selectedBox ? '' : 'sticky top-4' }}">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="ri-inbox-line"></i>
                    الصناديق المتاحة
                </h4>
                
                @if(count($layoutBoxes) > 0)
                    <div class="space-y-2">
                        @foreach($layoutBoxes as $box)
                            <div class="bg-[#121827] rounded-lg p-3 border border-[#2a3548] hover:border-primary/50 transition-all cursor-pointer"
                                 wire:click="selectBox('{{ $box['id'] }}')">
                                <div class="flex items-center gap-3">
                                    @if(isset($box['image_preview']) && $box['image_preview'])
                                        <img src="{{ $box['image_preview'] }}" 
                                             alt="{{ $box['title'] ?? '' }}" 
                                             class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-[#1f2937] rounded flex items-center justify-center">
                                            <i class="ri-image-line text-gray-500"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h6 class="text-sm font-medium text-white truncate">
                                            {{ $box['title'] ?? 'Untitled Box' }}
                                        </h6>
                                        <p class="text-xs text-gray-400">
                                            @if(isset($box['order']) && $box['order'] >= 0 && $box['order'] <= 8)
                                                <span class="text-primary">الموضع #{{ $box['order'] + 1 }}</span>
                                            @else
                                                <span class="text-gray-500">غير مخصص</span>
                                            @endif
                                        </p>
                                    </div>
                                    <i class="ri-arrow-left-s-line text-gray-400"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="ri-inbox-line text-gray-600 text-4xl mb-3"></i>
                        <p class="text-gray-400 text-sm">لا توجد صناديق متاحة</p>
                        <p class="text-xs text-gray-500 mt-2">أضف صورًا في "السلايدر الرئيسي" أولاً</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-4 mt-6">
        <div class="flex items-start gap-3">
            <i class="ri-lightbulb-line text-blue-400 text-xl mt-1"></i>
            <div class="text-blue-300 text-sm">
                <p class="font-medium mb-1">نصيحة:</p>
                <p>يمكنك إعادة ترتيب الصناديق بالنقر على أي صندوق لتعديل محتواه.</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>
