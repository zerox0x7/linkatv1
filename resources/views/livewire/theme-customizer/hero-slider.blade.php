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
                                <div class="drag-handle text-gray-500 text-2xl py-2 cursor-move" title="اسحب لإعادة الترتيب">
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
        <div class="bg-gradient-to-br from-[#0f1623] to-[#1a2234] rounded-xl border-2 border-primary/30 p-6 shadow-xl mt-6">
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
        <div class="bg-orange-500/10 border border-orange-500/30 rounded-xl p-4 text-center mt-6">
            <i class="ri-information-line text-orange-400 text-2xl mb-2"></i>
            <p class="text-orange-300">لقد وصلت للحد الأقصى (10 صور). احذف صورة أو عدّل موجودة.</p>
        </div>
    @endif

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
    </style>

    @script
    <script>
        // Load Sortable.js library if not already loaded
        if (typeof Sortable === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
            script.onload = function() {
                console.log('Sortable.js loaded successfully');
                window.dispatchEvent(new CustomEvent('sortable-loaded'));
            };
            document.head.appendChild(script);
        }
        
        // Expose reorderSlides to window
        window.reorderHeroSlides = function(orderedIds) {
            $wire.call('reorderSlides', orderedIds);
        };
        
        // Listen for custom event
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

