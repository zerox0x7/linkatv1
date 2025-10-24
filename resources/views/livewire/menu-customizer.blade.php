<div>
<!-- Loading Overlay -->
@if($isLoading)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:loading.class.remove="hidden">
    <div class="bg-[#1e293b] rounded-lg p-6 flex items-center space-x-4 space-x-reverse">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
        <span class="text-white">جاري المعالجة...</span>
    </div>
</div>
@endif

<!-- Main Content -->
<main class="flex-1 p-6">
    <div class="max-w-5xl mx-auto">
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-600 text-white p-4 rounded-lg mb-6 flex items-center" 
                 x-data="{ show: true }" 
                 x-show="show" 
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95">
                <i class="ri-check-circle-line text-xl ml-3"></i>
                <div class="flex-1 whitespace-pre-line">{{ session('message') }}</div>
                <button @click="show = false" class="mr-auto text-white hover:text-gray-200">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-red-600 text-white p-4 rounded-lg mb-6 flex items-center"
                 x-data="{ show: true }" 
                 x-show="show" 
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95">
                <i class="ri-error-warning-line text-xl ml-3"></i>
                <div class="flex-1 whitespace-pre-line">{{ session('error') }}</div>
                <button @click="show = false" class="mr-auto text-white hover:text-gray-200">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="ri-error-warning-line text-xl ml-3"></i>
                    <strong>يوجد أخطاء في البيانات:</strong>
                </div>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">إدارة القوائم</h1>
                <div class="flex items-center space-x-4 space-x-reverse text-sm text-gray-400 mt-1">
                    <span>إجمالي العناصر: {{ count($menuItems) }}</span>
                    @if($pendingChangesCount > 0)
                        <span class="bg-orange-600 text-white px-2 py-1 rounded-full text-xs">
                            {{ $pendingChangesCount }} تغيير معلق
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-3 space-x-reverse">
                <button wire:click="testDatabaseConnection" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-blue-700 transition-colors disabled:opacity-50"
                    wire:loading.attr="disabled"
                    wire:target="testDatabaseConnection">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="ri-database-line"></i>
                    </div>
                    <span class="mr-2">اختبار قاعدة البيانات</span>
                </button>
                <button wire:click="loadMenuItems" 
                    class="bg-gray-700 text-white px-4 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-gray-600 transition-colors disabled:opacity-50"
                    wire:loading.attr="disabled"
                    wire:target="loadMenuItems">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="ri-refresh-line" wire:loading.class="animate-spin" wire:target="loadMenuItems"></i>
                    </div>
                    <span class="mr-2">تحديث</span>
                </button>
                <button wire:click="saveAllChanges"
                    class="bg-primary text-gray-900 px-4 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-opacity-90 transition-colors disabled:opacity-50 relative"
                    wire:loading.attr="disabled"
                    wire:target="saveAllChanges">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="ri-save-line"></i>
                    </div>
                    <span class="mr-2">
                        @if($pendingChangesCount > 0)
                            حفظ التغييرات ({{ $pendingChangesCount }})
                        @else
                            حفظ التغييرات
                        @endif
                    </span>
                    @if($pendingChangesCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $pendingChangesCount }}
                        </span>
                    @endif
                </button>
            </div>
        </div>

        <div class="bg-[#1e293b] rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">القائمة الرئيسية</h2>
            <p class="text-gray-400 text-sm mb-6">قم بإدارة وتخصيص عناصر القائمة الرئيسية التي ستظهر في متجرك</p>
            
            @if(count($menuItems) > 0)
                <div class="space-y-4" id="sortable-menu">
                    @foreach($menuItems as $index => $item)
                        <div class="bg-[#111827] rounded-lg p-4 border-2 border-transparent hover:border-gray-600 transition-all duration-200 @if(isset($pendingChanges[$item['id']])) border-orange-500 @endif" 
                             data-id="{{ $item['id'] }}" 
                             wire:key="menu-item-{{ $item['id'] }}">
                            
                            <!-- Header Row -->
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center flex-1">
                                    <!-- Icon/Image Display -->
                                    <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center cursor-pointer mr-3 hover:bg-gray-600 transition-colors">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}" class="w-8 h-8 rounded object-cover">
                                        @else
                                            <i class="{{ $item['svg'] ?: 'ri-add-line' }} text-primary text-lg"></i>
                                        @endif
                                    </div>
                                    
                                    <!-- Title Input -->
                                    <div class="flex-1">
                                        <input type="text" 
                                            wire:model.live.debounce.500ms="menuItems.{{ $index }}.title" 
                                            wire:change="updateMenuItem({{ $index }}, 'title', $event.target.value)"
                                            value="{{ $item['title'] }}"
                                            class="w-full bg-transparent border-b border-gray-700 focus:border-primary py-2 text-sm font-medium placeholder-gray-400 @if(isset($pendingChanges[$item['id']]['title'])) border-orange-500 @endif"
                                            placeholder="عنوان العنصر"
                                            wire:loading.attr="disabled"
                                            wire:target="updateMenuItem">
                                        @error('menuItems.' . $index . '.title')
                                            <span class="text-red-400 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <!-- Pending Changes Indicator -->
                                    @if(isset($pendingChanges[$item['id']]) && !empty($pendingChanges[$item['id']]))
                                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse" title="تغييرات معلقة"></div>
                                    @endif
                                    
                                    <!-- Active Toggle -->
                                    <label class="custom-switch" title="{{ $item['is_active'] ? 'مفعل' : 'غير مفعل' }}">
                                        <input type="checkbox" 
                                            wire:click="toggleActive({{ $index }})"
                                            {{ $item['is_active'] ? 'checked' : '' }}
                                            wire:loading.attr="disabled"
                                            wire:target="toggleActive">
                                        <span class="slider"></span>
                                    </label>
                                    
                                    <!-- Duplicate Button -->
                                    <button wire:click="duplicateMenuItem({{ $index }})"
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 cursor-pointer hover:text-blue-400 transition-colors disabled:opacity-50"
                                        title="نسخ العنصر"
                                        wire:loading.attr="disabled"
                                        wire:target="duplicateMenuItem">
                                        <i class="ri-file-copy-line"></i>
                                    </button>
                                    
                                    <!-- Delete Button -->
                                    <button wire:click="deleteMenuItem({{ $index }})"
                                        wire:confirm="هل أنت متأكد من حذف هذا العنصر؟"
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 cursor-pointer hover:text-red-400 transition-colors disabled:opacity-50"
                                        title="حذف العنصر"
                                        wire:loading.attr="disabled"
                                        wire:target="deleteMenuItem">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                    
                                    <!-- Drag Handle -->
                                    <div class="w-8 h-8 flex items-center justify-center text-gray-400 cursor-move hover:text-white drag-handle transition-colors"
                                         title="اسحب لإعادة الترتيب">
                                        <i class="ri-drag-move-line"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- URL Input -->
                            <div class="flex items-center text-sm text-gray-400 mb-4">
                                <span class="min-w-fit ml-3">الرابط:</span>
                                <input type="text" 
                                    wire:model.live.debounce.500ms="menuItems.{{ $index }}.url"
                                    wire:change="updateMenuItem({{ $index }}, 'url', $event.target.value)"
                                    value="{{ $item['url'] }}"
                                    class="flex-1 bg-transparent border-b border-gray-700 focus:border-primary py-1 placeholder-gray-400 @if(isset($pendingChanges[$item['id']]['url'])) border-orange-500 @endif"
                                    placeholder="مثال: /products"
                                    wire:loading.attr="disabled"
                                    wire:target="updateMenuItem">
                                @error('menuItems.' . $index . '.url')
                                    <span class="text-red-400 text-xs mr-2">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Image Upload Section -->
                            <div class="mb-4">
                                <label class="text-sm text-gray-400 mb-2 block">صورة العنصر:</label>
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <input type="file" 
                                        wire:model="editingImages.{{ $index }}"
                                        accept="image/*"
                                        class="flex-1 text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary file:text-gray-900 hover:file:bg-opacity-90"
                                        wire:loading.attr="disabled"
                                        wire:target="uploadMenuImage">
                                    
                                    @if(isset($editingImages[$index]) && $editingImages[$index])
                                        <button wire:click="uploadMenuImage({{ $index }})"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition-colors disabled:opacity-50"
                                            wire:loading.attr="disabled"
                                            wire:target="uploadMenuImage">
                                            <span wire:loading.remove wire:target="uploadMenuImage">رفع</span>
                                            <span wire:loading wire:target="uploadMenuImage">جاري الرفع...</span>
                                        </button>
                                    @endif
                                    
                                    @if($item['image'])
                                        <button wire:click="updateMenuItem({{ $index }}, 'image', null)"
                                            wire:confirm="هل تريد حذف الصورة؟"
                                            class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors disabled:opacity-50"
                                            wire:loading.attr="disabled"
                                            wire:target="updateMenuItem">
                                            حذف الصورة
                                        </button>
                                    @endif
                                </div>
                                
                                @if($item['image'])
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}" class="w-16 h-16 rounded object-cover">
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Icon Selector -->
                            <div class="mb-4">
                                <label class="text-sm text-gray-400 mb-2 block">اختر أيقونة:</label>
                                <div class="@if(isset($pendingChanges[$item['id']]['svg'])) ring-2 ring-orange-500 rounded-md @endif">
                                    @livewire('icon-select-input', [
                                        'value' => $item['svg'] ?? '',
                                        'wireModel' => "menuItems.{$index}.svg",
                                        'placeholder' => 'اختر أيقونة',
                                        'customClass' => 'custom-input p-3 rounded-md w-full'
                                    ], key('icon-selector-' . $item['id'] . '-' . $index))
                                </div>
                            </div>
                            
                            <!-- Tailwind Code Input -->
                            <div class="mb-2">
                                <label class="text-sm text-gray-400 mb-2 block">كود Tailwind CSS (اختياري):</label>
                                <textarea 
                                    wire:model.live.debounce.1000ms="menuItems.{{ $index }}.tailwind_code"
                                    wire:change="updateMenuItem({{ $index }}, 'tailwind_code', $event.target.value)"
                                    rows="2"
                                    class="w-full bg-gray-800 border border-gray-600 rounded-md px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none transition-colors text-sm @if(isset($pendingChanges[$item['id']]['tailwind_code'])) border-orange-500 @endif"
                                    placeholder="مثال: text-blue-500 hover:text-blue-600"
                                    wire:loading.attr="disabled"
                                    wire:target="updateMenuItem">{{ $item['tailwind_code'] ?? '' }}</textarea>
                            </div>
                            
                            <!-- Item Stats -->
                            <div class="flex justify-between items-center text-xs text-gray-500 mt-4 pt-3 border-t border-gray-700">
                                <span>الترتيب: {{ $item['order'] }}</span>
                                <span>المالك: {{ $item['owner_id'] }}</span>
                                <span>آخر تحديث: {{ \Carbon\Carbon::parse($item['updated_at'])->diffForHumans() }}</span>
                                @if(isset($pendingChanges[$item['id']]) && !empty($pendingChanges[$item['id']]))
                                    <span class="text-orange-400 text-xs">
                                        تغييرات غير محفوظة: {{ count($pendingChanges[$item['id']]) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-menu-line text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-300 mb-2">لا توجد عناصر في القائمة</h3>
                    <p class="text-gray-400 mb-4">ابدأ بإضافة عناصر جديدة للقائمة</p>
                </div>
            @endif

            <!-- Add New Menu Item Form -->
            <div class="bg-[#111827] rounded-lg p-6 border-2 border-dashed border-gray-600 mt-6 hover:border-primary transition-colors">
                <h3 class="text-lg font-semibold mb-4 text-primary flex items-center">
                    <i class="ri-add-circle-line text-xl ml-2"></i>
                    إضافة عنصر جديد
                </h3>
                
                <form wire:submit.prevent="addMenuItem">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Title Input -->
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">عنوان العنصر *</label>
                            <input type="text" 
                                wire:model="newMenuItem.title"
                                placeholder="مثال: الرئيسية"
                                class="w-full bg-gray-800 border border-gray-600 rounded-md px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none transition-colors"
                                wire:loading.attr="disabled"
                                wire:target="addMenuItem">
                            @error('newMenuItem.title')
                                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- URL Input -->
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">رابط العنصر *</label>
                            <input type="text" 
                                wire:model="newMenuItem.url"
                                placeholder="مثال: /"
                                class="w-full bg-gray-800 border border-gray-600 rounded-md px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none transition-colors"
                                wire:loading.attr="disabled"
                                wire:target="addMenuItem">
                            @error('newMenuItem.url')
                                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Image Upload Input -->
                    <div class="mb-4">
                        <label class="text-sm text-gray-400 mb-2 block">رفع صورة (اختياري - الحد الأقصى 2MB):</label>
                        <input type="file" 
                            wire:model="newMenuItem.uploadedImage"
                            accept="image/*"
                            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary file:text-gray-900 hover:file:bg-opacity-90"
                            wire:loading.attr="disabled"
                            wire:target="addMenuItem">
                        @error('newMenuItem.uploadedImage')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                        
                        @if($newMenuItem['uploadedImage'])
                            <div class="mt-2" wire:loading.remove wire:target="newMenuItem.uploadedImage">
                                <img src="{{ $newMenuItem['uploadedImage']->temporaryUrl() }}" alt="Preview" class="w-16 h-16 rounded object-cover">
                            </div>
                            <div class="mt-2 text-gray-400" wire:loading wire:target="newMenuItem.uploadedImage">
                                جاري تحميل الصورة...
                            </div>
                        @endif
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
                    </div>
                    
                    <!-- Tailwind Code Input -->
                    <div class="mb-4">
                        <label class="text-sm text-gray-400 mb-2 block">كود Tailwind CSS (اختياري):</label>
                        <textarea 
                            wire:model="newMenuItem.tailwind_code"
                            rows="2"
                            placeholder="مثال: text-blue-500 hover:text-blue-600"
                            class="w-full bg-gray-800 border border-gray-600 rounded-md px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none transition-colors text-sm"
                            wire:loading.attr="disabled"
                            wire:target="addMenuItem"></textarea>
                        @error('newMenuItem.tailwind_code')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Preview -->
                    @if($newMenuItem['title'] || $newMenuItem['url'] || $newMenuItem['svg'] || $newMenuItem['uploadedImage'])
                        <div class="bg-gray-800 rounded-md p-3 mb-4 border border-gray-600">
                            <label class="text-sm text-gray-400 mb-2 block">معاينة:</label>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-700 rounded flex items-center justify-center ml-3">
                                    @if($newMenuItem['uploadedImage'])
                                        <div wire:loading.remove wire:target="newMenuItem.uploadedImage">
                                            <img src="{{ $newMenuItem['uploadedImage']->temporaryUrl() }}" alt="Preview" class="w-6 h-6 rounded object-cover">
                                        </div>
                                        <div wire:loading wire:target="newMenuItem.uploadedImage" class="animate-pulse bg-gray-600 w-6 h-6 rounded"></div>
                                    @else
                                        <i class="{{ $newMenuItem['svg'] ?: 'ri-add-line' }} text-primary"></i>
                                    @endif
                                </div>
                                <span class="text-white font-medium">{{ $newMenuItem['title'] ?: 'عنوان العنصر' }}</span>
                                <span class="text-gray-400 text-sm mr-3">{{ $newMenuItem['url'] ?: 'رابط العنصر' }}</span>
                            </div>
                            @if($newMenuItem['tailwind_code'])
                                <div class="mt-2 text-xs text-gray-500">
                                    كود CSS: <code class="bg-gray-900 px-2 py-1 rounded">{{ $newMenuItem['tailwind_code'] }}</code>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 space-x-reverse">
                        <button type="button" 
                                wire:click="$call('resetForm')"
                                class="bg-gray-700 text-white px-4 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-gray-600 transition-colors disabled:opacity-50"
                                wire:loading.attr="disabled"
                                wire:target="addMenuItem">
                            <i class="ri-refresh-line ml-2"></i>
                            إعادة تعيين
                        </button>
                        <button type="submit"
                                class="bg-primary text-gray-900 px-6 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-opacity-90 transition-colors font-medium disabled:opacity-50"
                                wire:loading.attr="disabled"
                                wire:target="addMenuItem">
                            <i class="ri-add-line ml-2" wire:loading.remove wire:target="addMenuItem"></i>
                            <i class="ri-loader-4-line ml-2 animate-spin" wire:loading wire:target="addMenuItem"></i>
                            <span wire:loading.remove wire:target="addMenuItem">إضافة العنصر</span>
                            <span wire:loading wire:target="addMenuItem">جاري الإضافة...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Enhanced Styles -->
<style>
    .custom-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .custom-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #4a5568;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #00e5bb;
    }

    input:checked + .slider:before {
        transform: translateX(20px);
    }

    .custom-input {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
    }

    .custom-input:focus {
        border-color: #00e5bb;
        outline: none;
    }

    .custom-input::placeholder {
        color: #9ca3af;
    }

    .dragging {
        opacity: 0.8;
        background: #1e293b;
        box-shadow: 0 4px 20px rgba(0, 229, 187, 0.2);
        transform: scale(1.02);
        transition: all 0.2s ease;
    }

    .drag-over {
        border: 2px dashed #00e5bb !important;
        position: relative;
    }

    .drag-handle {
        cursor: grab;
    }

    .drag-handle:active {
        cursor: grabbing;
    }
    
    /* Loading animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

@script
<script>
    // Alpine.js for better UX (if not already loaded)
    if (typeof Alpine === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js';
        script.defer = true;
        document.head.appendChild(script);
    }
    
    // SortableJS for drag and drop
    if (typeof Sortable === 'undefined') {
        const sortableScript = document.createElement('script');
        sortableScript.src = 'https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js';
        sortableScript.onload = initializeSortable;
        document.head.appendChild(sortableScript);
    }

    let sortable;

    // Initialize Sortable for drag and drop functionality
    function initializeSortable() {
        const sortableElement = document.querySelector('#sortable-menu');
        if (sortableElement && typeof Sortable !== 'undefined') {
            if (sortable) {
                sortable.destroy();
            }
            
            sortable = new Sortable(sortableElement, {
                handle: '.drag-handle',
                animation: 300,
                easing: "cubic-bezier(1, 0, 0, 1)",
                ghostClass: 'dragging',
                chosenClass: 'drag-over',
                dragClass: 'dragging',
                forceFallback: false,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                
                onStart: function (evt) {
                    evt.item.style.transform = 'rotate(2deg) scale(1.02)';
                    evt.item.style.zIndex = '1000';
                    document.body.style.cursor = 'grabbing';
                },
                
                onEnd: function (evt) {
                    evt.item.style.transform = '';
                    evt.item.style.zIndex = '';
                    document.body.style.cursor = '';
                    
                    // Only update if order actually changed
                    if (evt.oldIndex !== evt.newIndex) {
                        const items = Array.from(sortableElement.children);
                        const orderedIds = items
                            .filter(item => item.getAttribute('data-id'))
                            .map(item => item.getAttribute('data-id'));
                        
                        if (orderedIds.length > 0) {
                            $wire.updateMenuOrder(orderedIds);
                        }
                    }
                },
                
                onMove: function (evt) {
                    // Add visual feedback during drag
                    const related = evt.related;
                    if (related) {
                        related.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            if (related) related.style.transform = '';
                        }, 100);
                    }
                }
            });
        }
    }

    // Initialize on different events
    document.addEventListener('livewire:navigated', function () {
        setTimeout(initializeSortable, 100);
    });

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initializeSortable, 100);
    });

    // Re-initialize after Livewire updates
    $wire.on('refreshMenuItems', () => {
        setTimeout(initializeSortable, 200);
    });
    
    $wire.on('menuItemUpdated', () => {
        setTimeout(initializeSortable, 100);
    });

    // Enhanced auto-hide flash messages with better UX
    function setupFlashMessages() {
        const flashMessages = document.querySelectorAll('[x-data]');
        flashMessages.forEach(message => {
            if (message.querySelector('.bg-green-600') || message.querySelector('.bg-red-600')) {
                // Auto-hide success messages after 6 seconds
                if (message.querySelector('.bg-green-600')) {
                    setTimeout(() => {
                        if (message && message.__x) {
                            message.__x.$data.show = false;
                        }
                    }, 6000);
                }
                // Auto-hide error messages after 10 seconds
                else if (message.querySelector('.bg-red-600')) {
                    setTimeout(() => {
                        if (message && message.__x) {
                            message.__x.$data.show = false;
                        }
                    }, 10000);
                }
            }
        });
    }

    // Setup flash messages on load and after updates
    document.addEventListener('DOMContentLoaded', setupFlashMessages);
    $wire.on('refreshMenuItems', setupFlashMessages);
    
    // Keyboard shortcuts for better UX
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save all changes
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            $wire.saveAllChanges();
        }
        
        // Ctrl/Cmd + R to refresh
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            $wire.loadMenuItems();
        }
    });

    // Improved error handling for failed operations
    window.addEventListener('livewire:init', () => {
        Livewire.on('error', (error) => {
            console.error('Livewire error:', error);
            
            // Show user-friendly error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'fixed top-4 right-4 bg-red-600 text-white p-4 rounded-lg shadow-lg z-50 max-w-sm';
            errorDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="ri-error-warning-line text-xl ml-3"></i>
                    <div class="flex-1">
                        <div class="font-medium">حدث خطأ</div>
                        <div class="text-sm opacity-90">يرجى المحاولة مرة أخرى</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="mr-2 hover:text-gray-200">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(errorDiv);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.parentNode.removeChild(errorDiv);
                }
            }, 5000);
        });
    });

    // Performance optimization: Debounce functions
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Optimized scroll performance for long lists
    if (document.querySelector('#sortable-menu')) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                } else {
                    entry.target.classList.remove('visible');
                }
            });
        }, {
            rootMargin: '50px'
        });

        // Observe menu items for performance
        const observeMenuItems = debounce(() => {
            document.querySelectorAll('#sortable-menu > div').forEach(item => {
                observer.observe(item);
            });
        }, 100);

        $wire.on('refreshMenuItems', observeMenuItems);
        document.addEventListener('DOMContentLoaded', observeMenuItems);
    }

    // Initialize immediately if SortableJS is already loaded
    if (typeof Sortable !== 'undefined') {
        initializeSortable();
    }
</script>
@endscript
</div>