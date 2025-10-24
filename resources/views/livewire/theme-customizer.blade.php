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

    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/50 rounded-xl text-red-400 animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="ri-error-warning-line text-2xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" x-data="{ activeTab: 'hero' }">
        <!-- Tabs Navigation -->
        <div class="flex gap-2 mb-6 border-b border-[#2a3548] overflow-x-auto">
            <button type="button" @click="activeTab = 'hero'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'hero' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-image-line ml-2"></i>
                الصفحة الرئيسية والبطل
            </button>
            <button type="button" @click="activeTab = 'banner'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'banner' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-layout-grid-line ml-2"></i>
                أداة ترتيب الصناديق (Layout Builder)
            </button>
            <button type="button" @click="activeTab = 'custom'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'custom' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-settings-3-line ml-2"></i>
                بيانات مخصصة
            </button>
            <button type="button" @click="activeTab = 'code'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'code' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-code-line ml-2"></i>
                CSS/JS مخصص
            </button>
            <button type="button" @click="activeTab = 'sections'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'sections' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-list-check ml-2"></i>
                التحكم بالأقسام
            </button>
        </div>

        <!-- Hero Section Tab -->
        <div x-show="activeTab === 'hero'" class="space-y-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-primary/20 to-secondary/20 flex items-center justify-center">
                            <i class="ri-image-line text-primary"></i>
                        </div>
                        قسم البطل والصفحة الرئيسية (Hero & Home Page)
                    </h3>
                    <p class="text-gray-400 text-sm mt-1">يمكنك إضافة حتى 10 صور مع عناوينها وأزرارها</p>
                </div>
                <div class="text-sm text-gray-400">
                    <span class="font-bold text-primary">{{ count($heroSlides) }}</span> / 10 صور
                </div>
            </div>

            <!-- Existing Slides -->
            @if(count($heroSlides) > 0)
                <div class="space-y-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="ri-gallery-line"></i>
                            الصور الحالية
                        </h4>
                        <div class="text-xs text-gray-400 flex items-center gap-2 bg-[#0f1623] px-3 py-2 rounded-lg border border-[#2a3548]">
                            <i class="ri-drag-move-line text-primary"></i>
                            اسحب وأفلت لإعادة الترتيب
                        </div>
                    </div>
                    
                    <div id="hero-slides-container" class="space-y-4">
                        @foreach($heroSlides as $index => $slide)
                            <div class="bg-gradient-to-br from-[#0f1623] to-[#1a2234] rounded-xl border border-[#2a3548] overflow-hidden hover:border-primary/30 transition-all duration-300" 
                                 wire:key="slide-{{ $slide['id'] ?? $index }}"
                                 data-slide-id="{{ $slide['id'] ?? $index }}">
                                <div class="p-6">
                                    <!-- Drag Handle Bar -->
                                    <div class="flex items-center justify-center mb-4 pb-4 border-b border-[#2a3548]">
                                        <div class="drag-handle text-gray-500 text-2xl py-2" title="اسحب لإعادة الترتيب">
                                            <i class="ri-draggable"></i>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                        <!-- Image Preview -->
                                        <div class="lg:col-span-1">
                                            <div class="relative group">
                                                @if(isset($slide['image_preview']))
                                                    <img src="{{ $slide['image_preview'] }}" 
                                                         alt="{{ $slide['title'] ?? 'Hero Image' }}" 
                                                         class="w-full h-48 object-cover rounded-lg shadow-lg">
                                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-300 rounded-lg flex items-center justify-center">
                                                        <i class="ri-eye-line text-white text-3xl"></i>
                                                    </div>
                                                @else
                                                    <div class="w-full h-48 bg-[#121827] rounded-lg flex items-center justify-center">
                                                        <i class="ri-image-line text-gray-500 text-4xl"></i>
                                                    </div>
                                                @endif
                                                
                                                <!-- Slide Number Badge -->
                                                <div class="absolute top-2 right-2 bg-gradient-to-r from-primary to-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                                    #{{ $index + 1 }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide Info -->
                                        <div class="lg:col-span-2 space-y-3">
                                            <div>
                                                <label class="text-xs text-gray-500 block mb-1">العنوان</label>
                                                <div class="text-white font-semibold text-lg">{{ $slide['title'] ?? 'بدون عنوان' }}</div>
                                            </div>
                                            
                                            @if(isset($slide['subtitle']) && $slide['subtitle'])
                                                <div>
                                                    <label class="text-xs text-gray-500 block mb-1">العنوان الفرعي</label>
                                                    <div class="text-gray-300">{{ $slide['subtitle'] }}</div>
                                                </div>
                                            @endif
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @if(isset($slide['button_text']) && $slide['button_text'])
                                                    <div>
                                                        <label class="text-xs text-gray-500 block mb-1">نص الزر</label>
                                                        <div class="text-primary font-medium">{{ $slide['button_text'] }}</div>
                                                    </div>
                                                @endif
                                                
                                                @if(isset($slide['button_link']) && $slide['button_link'])
                                                    <div>
                                                        <label class="text-xs text-gray-500 block mb-1">رابط الزر</label>
                                                        <div class="text-gray-400 text-sm truncate">{{ $slide['button_link'] }}</div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex items-center gap-2 pt-3 border-t border-[#2a3548]">
                                                <!-- Edit Button -->
                                                <button type="button" wire:click="editHeroSlide({{ $index }})" 
                                                        class="px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors flex items-center gap-2">
                                                    <i class="ri-edit-line"></i>
                                                    <span>تعديل</span>
                                                </button>
                                                
                                                <!-- Move Up -->
                                                @if($index > 0)
                                                    <button type="button" wire:click="moveSlideUp({{ $index }})" 
                                                            class="p-2 bg-purple-500/20 text-purple-400 rounded-lg hover:bg-purple-500/30 transition-colors"
                                                            title="تحريك لأعلى">
                                                        <i class="ri-arrow-up-line"></i>
                                                    </button>
                                                @endif
                                                
                                                <!-- Move Down -->
                                                @if($index < count($heroSlides) - 1)
                                                    <button type="button" wire:click="moveSlideDown({{ $index }})" 
                                                            class="p-2 bg-purple-500/20 text-purple-400 rounded-lg hover:bg-purple-500/30 transition-colors"
                                                            title="تحريك لأسفل">
                                                        <i class="ri-arrow-down-line"></i>
                                                    </button>
                                                @endif
                                                
                                                <!-- Delete Button -->
                                                <button type="button" 
                                                        wire:click="deleteHeroSlide({{ $index }})" 
                                                        wire:confirm="هل أنت متأكد من حذف هذه الصورة؟"
                                                        class="mr-auto p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors"
                                                        title="حذف">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-[#0f1623] rounded-xl p-12 border border-dashed border-[#2a3548] text-center">
                    <i class="ri-image-add-line text-6xl text-gray-600 mb-4"></i>
                    <h4 class="text-xl font-semibold text-gray-400 mb-2">لا توجد صور بطل بعد</h4>
                    <p class="text-gray-500">ابدأ بإضافة أول صورة للبطل من النموذج أدناه</p>
                </div>
            @endif

            <!-- Add/Edit Slide Form -->
            @if(count($heroSlides) < 10 || $editingSlideIndex !== null)
                <div class="bg-gradient-to-br from-[#0f1623] to-[#1a2234] rounded-xl border-2 border-primary/30 p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="{{ $editingSlideIndex !== null ? 'ri-edit-line text-blue-400' : 'ri-add-circle-line text-green-400' }}"></i>
                            {{ $editingSlideIndex !== null ? 'تعديل الصورة' : 'إضافة صورة جديدة' }}
                        </h4>
                        
                        @if($editingSlideIndex !== null)
                            <button type="button" wire:click="cancelEdit" 
                                    class="px-4 py-2 bg-gray-600/20 text-gray-300 rounded-lg hover:bg-gray-600/30 transition-colors flex items-center gap-2">
                                <i class="ri-close-line"></i>
                                إلغاء
                            </button>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-3">
                                صورة البطل {{ $editingSlideIndex !== null ? '(اختياري - اترك فارغاً للاحتفاظ بالصورة الحالية)' : '*' }}
                            </label>
                            
                            @if(isset($newHeroSlide['image_preview']) && $newHeroSlide['image_preview'])
                                <div class="mb-4 relative group">
                                    <img src="{{ $newHeroSlide['image_preview'] }}" 
                                         alt="Preview" 
                                         class="w-full h-64 object-cover rounded-lg shadow-lg">
                                    <div class="absolute top-2 left-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                        <i class="ri-check-line"></i> جاهز للحفظ
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center justify-center w-full" x-data="{ uploading: false, progress: 0 }">
                                <label for="hero-slide-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-primary/50 rounded-lg cursor-pointer hover:border-primary transition-all duration-300 bg-primary/5">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="ri-upload-cloud-line text-4xl text-primary mb-2"></i>
                                        <p class="mb-2 text-sm text-gray-300">
                                            <span class="font-semibold">اضغط لرفع الصورة</span> أو اسحب وأفلت
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG أو WEBP (الحد الأقصى 2MB)</p>
                                    </div>
                                    <input id="hero-slide-upload" type="file" wire:model.live="tempSlideImage" class="hidden" accept="image/*" 
                                           x-on:livewire-upload-start="uploading = true"
                                           x-on:livewire-upload-finish="uploading = false"
                                           x-on:livewire-upload-error="uploading = false"
                                           x-on:livewire-upload-progress="progress = $event.detail.progress" />
                                </label>
                                
                                <!-- Upload Progress -->
                                <div x-show="uploading" class="mt-2">
                                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-primary h-2.5 rounded-full transition-all duration-300" :style="`width: ${progress}%`"></div>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1 text-center" x-text="`جاري الرفع: ${progress}%`"></p>
                                </div>
                            </div>

                            @error('tempSlideImage') 
                                <span class="text-red-400 text-sm mt-2 block flex items-center gap-2">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </span> 
                            @enderror

                            <div wire:loading wire:target="tempSlideImage" class="mt-2 text-primary text-sm flex items-center gap-2">
                                <i class="ri-loader-4-line animate-spin"></i>
                                جاري رفع الصورة...
                            </div>
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">العنوان الرئيسي *</label>
                            <input type="text" wire:model="newHeroSlide.title" 
                                   class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                   placeholder="أدخل عنوان الصورة">
                            @error('newHeroSlide.title') 
                                <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Subtitle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">العنوان الفرعي</label>
                            <textarea wire:model="newHeroSlide.subtitle" rows="2"
                                      class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                      placeholder="أدخل عنوان فرعي (اختياري)"></textarea>
                            @error('newHeroSlide.subtitle') 
                                <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Button Text & Link -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">نص الزر</label>
                                <input type="text" wire:model="newHeroSlide.button_text" 
                                       class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                       placeholder="مثال: تسوق الآن">
                                @error('newHeroSlide.button_text') 
                                    <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">رابط الزر</label>
                                <input type="text" wire:model="newHeroSlide.button_link" 
                                       class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                       placeholder="مثال: /products">
                                @error('newHeroSlide.button_link') 
                                    <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <!-- Add/Update Button -->
                        <div class="pt-4">
                            @if($editingSlideIndex !== null)
                                <button type="button" wire:click="updateHeroSlide" 
                                        wire:loading.attr="disabled"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg flex items-center justify-center gap-3">
                                    <i class="ri-save-line text-xl"></i>
                                    <span wire:loading.remove wire:target="updateHeroSlide">تحديث الصورة</span>
                                    <span wire:loading wire:target="updateHeroSlide">جاري التحديث...</span>
                                </button>
                            @else
                                <button type="button" wire:click="addHeroSlide" 
                                        wire:loading.attr="disabled"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg flex items-center justify-center gap-3">
                                    <i class="ri-add-line text-xl"></i>
                                    <span wire:loading.remove wire:target="addHeroSlide">إضافة الصورة</span>
                                    <span wire:loading wire:target="addHeroSlide">جاري الإضافة...</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if(count($heroSlides) >= 10 && $editingSlideIndex === null)
                <div class="bg-orange-500/10 border border-orange-500/30 rounded-xl p-4 text-center">
                    <i class="ri-information-line text-orange-400 text-2xl mb-2"></i>
                    <p class="text-orange-300">لقد وصلت للحد الأقصى (10 صور). احذف صورة أو عدّل موجودة.</p>
                </div>
            @endif
        </div>

        <!-- Layout Builder Tab (Replaced Banner Section) -->
        <div x-show="activeTab === 'banner'" class="space-y-6" 
             x-data="{
                 selectedBoxId: null,
                 dragging: false,
                 sortableInstance: null,
                 initSortable() {
                     // Wait for Sortable to be loaded
                     const tryInit = () => {
                         if (typeof Sortable !== 'undefined') {
                             const el = document.getElementById('layout-boxes-container');
                             if (el && !this.sortableInstance) {
                                 this.sortableInstance = Sortable.create(el, {
                                     animation: 150,
                                     handle: '.drag-handle',
                                     ghostClass: 'bg-primary/20',
                                     chosenClass: 'bg-primary/10',
                                     dragClass: 'opacity-50',
                                     onStart: () => {
                                         this.dragging = true;
                                     },
                                     onEnd: (evt) => {
                                         this.dragging = false;
                                         const items = Array.from(el.children)
                                             .map(item => item.dataset.boxId)
                                             .filter(id => id); // Filter out undefined
                                         @this.updateBoxOrder(items);
                                     }
                                 });
                             }
                         } else {
                             // Retry after 100ms if Sortable not loaded yet
                             setTimeout(tryInit, 100);
                         }
                     };
                     tryInit();
                 }
             }"
             x-init="setTimeout(() => initSortable(), 100)"
             @reinit-sortable.window="initSortable()">
            
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-orange-500/20 to-red-500/20 flex items-center justify-center">
                    <i class="ri-layout-grid-line text-orange-400"></i>
                </div>
                أداة ترتيب الصناديق الثابتة (Layout Builder)
            </h3>

            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <div class="flex items-start gap-2 mb-4">
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
                            <span class="text-xs text-gray-400 font-normal mr-auto">اسحب الصناديق من اليمين وأفلتها هنا</span>
                        </h4>
                        
                        <!-- Theme Layout Simulation - Dynamically loaded based on theme -->
                        @php
                            // Determine which theme layout to load from active theme setting
                            $activeTheme = \App\Models\Setting::get('active_theme', 'torganic');
                            // Convert theme name to lowercase for component naming consistency
                            $currentTheme = strtolower($activeTheme);
                            $layoutComponent = "components.theme-layouts.{$currentTheme}";
                        @endphp
                        
                        {{-- Debug info (remove in production) --}}
                        <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-3 mb-3 text-blue-300 text-xs">
                            <i class="ri-information-line"></i>
                            <strong>Active Theme:</strong> {{ $activeTheme }} 
                            <strong class="mr-3">Looking for:</strong> {{ $layoutComponent }}
                        </div>
                        
                        @if(view()->exists($layoutComponent))
                            @include($layoutComponent, ['layoutBoxes' => $layoutBoxes])
                        @else
                            <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 text-red-400">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-error-warning-line text-xl"></i>
                                    <strong>Theme layout component not found</strong>
                                </div>
                                <p class="text-sm mb-2">Looking for: <code class="bg-black/30 px-2 py-1 rounded">{{ $layoutComponent }}</code></p>
                                <p class="text-xs text-gray-400">Available layouts: torganic, greengame, minimal</p>
                            </div>
                        @endif
                        
                    </div>
                </div>

                <!-- Available Boxes & Editor Sidebar (Right Side - 4 columns) -->
                <div class="col-span-12 lg:col-span-4">
                    <!-- Editor Section (when box selected) -->
                    @if($selectedBox)
                    <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548] mb-4 sticky top-4">
                        @if($selectedBox)
                            <div>
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

                                <!-- Box Image Preview -->
                                @if($selectedBox['image_preview'])
                                    <div class="mb-4">
                                        <img src="{{ $selectedBox['image_preview'] }}" 
                                             alt="{{ $selectedBox['title'] }}" 
                                             class="w-full h-32 object-cover rounded-lg">
                                    </div>
                                @endif

                                <!-- Edit Form -->
                                <div class="space-y-4">
                                    <!-- Title -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">العنوان</label>
                                        <input type="text" 
                                               wire:model="selectedBox.title"
                                               class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                                               placeholder="أدخل العنوان">
                                    </div>

                                    <!-- Subtitle -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">العنوان الفرعي</label>
                                        <textarea wire:model="selectedBox.subtitle" 
                                                  rows="2"
                                                  class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                                                  placeholder="أدخل العنوان الفرعي"></textarea>
                                    </div>

                                    <!-- Button Text -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">نص الزر</label>
                                        <input type="text" 
                                               wire:model="selectedBox.button_text"
                                               class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                                               placeholder="تسوق الآن">
                                    </div>

                                    <!-- Button Link -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">رابط الزر</label>
                                        <input type="text" 
                                               wire:model="selectedBox.button_link"
                                               class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                                               placeholder="/products">
                                    </div>

                                    <!-- Extra Fields (if any) -->
                                    @if(!empty($selectedBox['extra_fields']))
                                        <div class="pt-4 border-t border-[#2a3548]">
                                            <p class="text-sm font-medium text-gray-300 mb-3">حقول إضافية</p>
                                            @foreach($selectedBox['extra_fields'] as $key => $value)
                                                <div class="mb-3">
                                                    <label class="block text-xs text-gray-400 mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                    <input type="text" 
                                                           wire:model="selectedBox.extra_fields.{{ $key }}"
                                                           class="w-full px-3 py-2 bg-[#121827] border border-[#2a3548] rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary transition-colors">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Save Button -->
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
                    </div>
                    @endif
                    
                    <!-- Available Boxes (Not yet placed) -->
                    <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548] {{ $selectedBox ? '' : 'sticky top-4' }}">
                        <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <i class="ri-inbox-line"></i>
                            الصناديق المتاحة
                        </h4>
                        
                        @php
                            $assignedOrders = collect($layoutBoxes)->pluck('order')->toArray();
                            $unassignedBoxes = collect($layoutBoxes)->filter(function($box) use ($assignedOrders) {
                                return !in_array($box['order'], range(0, 8));
                            });
                            $allBoxes = collect($layoutBoxes);
                        @endphp
                        
                        @if($allBoxes->count() > 0)
                            <div class="space-y-2">
                                @foreach($allBoxes as $box)
                                    <div draggable="true"
                                         @dragstart="$event.dataTransfer.setData('boxId', '{{ $box['id'] }}'); $event.dataTransfer.effectAllowed = 'move'"
                                         class="bg-[#121827] rounded-lg p-3 border border-[#2a3548] cursor-move hover:border-primary/50 transition-all">
                                        <div class="flex items-center gap-3">
                                            @if($box['image_preview'])
                                                <img src="{{ $box['image_preview'] }}" 
                                                     alt="{{ $box['title'] }}" 
                                                     class="w-12 h-12 object-cover rounded">
                                            @else
                                                <div class="w-12 h-12 bg-[#1f2937] rounded flex items-center justify-center">
                                                    <i class="ri-image-line text-gray-500"></i>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h6 class="text-sm font-medium text-white truncate">
                                                    {{ $box['title'] ?: 'Untitled Box' }}
                                                </h6>
                                                <p class="text-xs text-gray-400">
                                                    @if(isset($box['order']) && $box['order'] >= 0 && $box['order'] <= 8)
                                                        <span class="text-primary">في الموضع #{{ $box['order'] + 1 }}</span>
                                                    @else
                                                        <span class="text-gray-500">غير مخصص</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <i class="ri-draggable text-gray-400"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="ri-inbox-line text-gray-600 text-4xl mb-3"></i>
                                <p class="text-gray-400 text-sm">لا توجد صناديق متاحة</p>
                                <p class="text-xs text-gray-500 mt-2">أضف صورًا في تبويب "Hero Section" أولاً</p>
                            </div>
                        @endif
                        
                        <div class="mt-4 pt-4 border-t border-[#2a3548]">
                            <p class="text-xs text-gray-500 text-center">
                                <i class="ri-information-line"></i>
                                اسحب أي صندوق وأفلته في الموضع المطلوب
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <i class="ri-lightbulb-line text-blue-400 text-xl mt-1"></i>
                    <div class="text-blue-300 text-sm">
                        <p class="font-medium mb-1">نصيحة:</p>
                        <p>يمكنك إعادة ترتيب الصناديق بالسحب والإفلات. الترتيب الجديد سيؤثر على كيفية عرض الصناديق في صفحتك الرئيسية.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Data Tab -->
        <div x-data="{ newKey: '', newValue: '' }" x-show="activeTab === 'custom'" class="space-y-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                    <i class="ri-settings-3-line text-purple-400"></i>
                </div>
                بيانات مخصصة (Custom Data)
            </h3>

            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <p class="text-gray-400 mb-4">يمكنك إضافة بيانات مخصصة إضافية يحتاجها الثيم</p>

                <!-- Current Custom Data -->
                @if(count($customData) > 0)
                    <div class="space-y-3 mb-4">
                        @foreach($customData as $key => $value)
                            <div class="flex items-center gap-3 bg-[#121827] p-4 rounded-lg border border-[#2a3548]">
                                <div class="flex-1 grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-500 block mb-1">المفتاح</label>
                                        <div class="text-white font-mono">{{ $key }}</div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 block mb-1">القيمة</label>
                                        <div class="text-white">{{ $value }}</div>
                                    </div>
                                </div>
                                <button type="button" wire:click="removeCustomDataField('{{ $key }}')" 
                                        class="p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-database-line text-4xl mb-2"></i>
                        <p>لا توجد بيانات مخصصة بعد</p>
                    </div>
                @endif

                <!-- Add New Field -->
                <div class="border-t border-[#2a3548] pt-4 mt-4">
                    <p class="text-sm text-gray-400 mb-3">إضافة حقل جديد</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" x-model="newKey" 
                               class="px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                               placeholder="المفتاح (مثال: secondary_color)">
                        <input type="text" x-model="newValue" 
                               class="px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                               placeholder="القيمة (مثال: #ff5733)">
                    </div>
                    <button type="button" 
                            @click="if(newKey && newValue) { $wire.addCustomDataField(newKey, newValue); newKey = ''; newValue = ''; }"
                            class="mt-3 px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:opacity-90 transition-opacity">
                        <i class="ri-add-line ml-2"></i>
                        إضافة حقل
                    </button>
                </div>
            </div>
        </div>

        <!-- Custom CSS/JS Tab -->
        <div x-show="activeTab === 'code'" class="space-y-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500/20 to-cyan-500/20 flex items-center justify-center">
                    <i class="ri-code-line text-blue-400"></i>
                </div>
                أكواد CSS/JS مخصصة
            </h3>

            <!-- Custom CSS -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">CSS مخصص</label>
                <textarea wire:model="customCss" rows="10"
                          class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors font-mono text-sm"
                          placeholder="/* أدخل كود CSS المخصص هنا */"></textarea>
            </div>

            <!-- Custom JS -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">JavaScript مخصص</label>
                <textarea wire:model="customJs" rows="10"
                          class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors font-mono text-sm"
                          placeholder="// أدخل كود JavaScript المخصص هنا"></textarea>
            </div>
        </div>

        <!-- Sections Activation Tab -->
        <div x-show="activeTab === 'sections'" class="space-y-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                            <i class="ri-list-check text-purple-400"></i>
                        </div>
                        التحكم بتفعيل الأقسام
                    </h3>
                    <p class="text-gray-400 text-sm mt-1">يمكنك التحكم بتفعيل أو إلغاء تفعيل الأقسام العشرة في الموقع</p>
                </div>
                <div class="text-sm text-gray-400 bg-[#0f1623] px-4 py-2 rounded-lg border border-[#2a3548]">
                    @php
                        $activeSections = collect($sectionsData)->filter(function($section) {
                            return $section['is_active'] ?? false;
                        })->count();
                    @endphp
                    <span class="font-bold text-primary">{{ $activeSections }}</span> / 10 قسم نشط
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#0f1623] to-[#1a2234] rounded-xl border border-[#2a3548] overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($sectionsData as $key => $section)
                            @php
                                $sectionNumber = (int) str_replace('section', '', $key);
                                $isActive = $section['is_active'] ?? false;
                                $sectionName = $section['name'] ?? 'القسم ' . $sectionNumber;
                                
                                // Arabic section names mapping
                                $arabicNames = [
                                    'firstSection' => 'القسم الأول',
                                    'secondSection' => 'القسم الثاني',
                                    'thirdSection' => 'القسم الثالث',
                                    'fourthSection' => 'القسم الرابع',
                                    'fifthSection' => 'القسم الخامس',
                                    'sixthSection' => 'القسم السادس',
                                    'seventhSection' => 'القسم السابع',
                                    'eighthSection' => 'القسم الثامن',
                                    'ninthSection' => 'القسم التاسع',
                                    'tenthSection' => 'القسم العاشر',
                                ];
                                
                                $displayName = $arabicNames[$sectionName] ?? $sectionName;
                            @endphp
                            
                            <div class="bg-[#121827] rounded-lg p-5 border border-[#2a3548] hover:border-primary/30 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center font-bold text-lg
                                                    {{ $isActive ? 'bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400' : 'bg-gray-500/20 text-gray-500' }}">
                                            {{ $sectionNumber }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold {{ $isActive ? 'text-white' : 'text-gray-400' }}">
                                                {{ $displayName }}
                                            </h4>
                                            <p class="text-xs {{ $isActive ? 'text-green-400' : 'text-gray-500' }} mt-1">
                                                <i class="ri-{{ $isActive ? 'checkbox-circle' : 'close-circle' }}-line"></i>
                                                {{ $isActive ? 'نشط' : 'غير نشط' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $sectionName }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Toggle Switch -->
                                    <button type="button" 
                                            wire:click="toggleSection('{{ $key }}')"
                                            wire:loading.attr="disabled"
                                            class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-[#121827]
                                                   {{ $isActive ? 'bg-gradient-to-r from-primary to-secondary' : 'bg-gray-600' }}">
                                        <span class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform
                                                     {{ $isActive ? '-translate-x-7' : 'translate-x-1' }}">
                                        </span>
                                        
                                        <!-- Loading indicator -->
                                        <span wire:loading wire:target="toggleSection('{{ $key }}')" 
                                              class="absolute inset-0 flex items-center justify-center">
                                            <i class="ri-loader-4-line animate-spin text-white"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Helper Info -->
                    <div class="mt-6 p-4 bg-blue-500/10 border border-blue-500/30 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i class="ri-information-line text-blue-400 text-xl mt-0.5"></i>
                            <div class="text-sm text-blue-300">
                                <p class="font-semibold mb-1">ملاحظة هامة:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs text-blue-300/80">
                                    <li>يتم حفظ التغييرات تلقائياً عند الضغط على زر التفعيل/الإلغاء</li>
                                    <li>الأقسام غير النشطة لن تظهر في الصفحة الرئيسية للموقع</li>
                                    <li>يمكنك إعادة تفعيل الأقسام في أي وقت</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button for Banner/Custom/Code tabs -->
        <div class="mt-8 flex items-center justify-end gap-4 border-t border-[#2a3548] pt-6" x-show="activeTab !== 'hero' && activeTab !== 'sections'">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-3">
                <i class="ri-save-line text-xl"></i>
                <span wire:loading.remove wire:target="save">حفظ التغييرات</span>
                <span wire:loading wire:target="save">جاري الحفظ...</span>
            </button>
        </div>
    </form>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        /* Layout Builder Styles */
        .layout-drop-zone {
            min-height: 120px;
            border: 2px dashed #2a3548;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .layout-drop-zone:hover {
            border-color: rgba(99, 102, 241, 0.5);
        }
        
        .layout-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 120px;
            padding: 1rem;
            color: #6b7280;
            text-align: center;
        }
        
        .layout-empty-small {
            min-height: 80px;
            font-size: 0.75rem;
        }
        
        .layout-empty i {
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }
        
        .layout-box {
            position: relative;
            background: #121827;
            border: 2px solid #2a3548;
            border-radius: 0.75rem;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: move;
        }
        
        .layout-box:hover {
            border-color: rgba(99, 102, 241, 0.7);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }
        
        .layout-box-content {
            position: relative;
            padding: 1rem;
        }
        
        .layout-box-content-compact {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
        }
        
        .layout-box-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .layout-box-image-small {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 0.5rem;
            flex-shrink: 0;
        }
        
        .layout-box-placeholder {
            width: 100%;
            height: 120px;
            background: #1f2937;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }
        
        .layout-box-info {
            position: relative;
        }
        
        .layout-box-info-compact {
            flex: 1;
            min-width: 0;
            position: relative;
        }
        
        .layout-box-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(99, 102, 241, 0.2);
            color: #6366f1;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .layout-box-badge-small {
            display: inline-block;
            background: rgba(99, 102, 241, 0.2);
            color: #6366f1;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.625rem;
            font-weight: 600;
        }
        
        .layout-box-title {
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            padding-right: 3rem;
        }
        
        .layout-box-title-small {
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .layout-box-type {
            color: #9ca3af;
            font-size: 0.75rem;
        }
        
        .layout-box-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .layout-box-edit:hover {
            background: rgba(99, 102, 241, 0.2);
        }
        
        .layout-box-edit-small {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .layout-box-edit-small:hover {
            background: rgba(99, 102, 241, 0.2);
        }
        
        .layout-box-small {
            min-height: 80px;
        }
        
        .layout-box-medium {
            min-height: 100px;
        }
        
        .layout-box-large {
            min-height: 120px;
        }
        
        /* Drag states */
        .layout-box[draggable="true"] {
            cursor: grab;
        }
        
        .layout-box[draggable="true"]:active {
            cursor: grabbing;
            opacity: 0.6;
        }
    </style>

    @script
    <script>
        // Load Sortable.js library if not already loaded
        if (typeof Sortable === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
            script.onload = function() {
                console.log('Sortable.js loaded successfully');
                // Reinitialize sortable after loading
                window.dispatchEvent(new CustomEvent('sortable-loaded'));
            };
            document.head.appendChild(script);
        }
        
        // Method 1: Expose reorderSlides to window for easier access
        window.reorderHeroSlides = function(orderedIds) {
            $wire.call('reorderSlides', orderedIds);
        };
        
        // Method 2: Listen for custom event
        window.addEventListener('reorder-hero-slides', function(event) {
            if (event.detail && event.detail.orderedIds) {
                $wire.call('reorderSlides', event.detail.orderedIds);
            }
        });
        
        // Reinitialize sortable when library is loaded
        window.addEventListener('sortable-loaded', function() {
            const event = new CustomEvent('reinit-sortable');
            window.dispatchEvent(event);
        });
    </script>
    @endscript
</div>
