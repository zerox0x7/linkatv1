<div class="relative">
    <!-- Label -->
    @if($label)
        <label class="block text-sm font-medium text-gray-300 mb-2">{{ $label }}</label>
    @endif

    <!-- Selected Icon Display -->
    <div class="relative">
        <button 
            type="button"
            wire:click="openModal"
            class="w-full bg-[#162033] border border-gray-600 rounded-lg px-4 py-3 text-right text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 flex items-center justify-between hover:border-gray-500"
        >
            <div class="flex items-center">
                @if($selectedIcon)
                    <i class="{{ $selectedIcon }} text-lg ml-3"></i>
                    <span class="text-gray-300">{{ $selectedIcon }}</span>
                @else
                    <span class="text-gray-400">{{ $placeholder }}</span>
                @endif
            </div>
            <i class="ri-arrow-down-s-line text-gray-400"></i>
        </button>
    </div>

    <!-- Icon Selection Modal -->
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <div class="bg-[#0f1419] rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[80vh] overflow-hidden" wire:click.stop>
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-700">
                    <h3 class="text-xl font-semibold text-white">اختيار الأيقونة</h3>
                    <button 
                        wire:click="closeModal"
                        class="text-gray-400 hover:text-white transition-colors"
                    >
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <!-- Search -->
                <div class="p-6 border-b border-gray-700">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            wire:model.live="searchTerm"
                            placeholder="ابحث عن أيقونة..."
                            class="w-full bg-[#162033] border border-gray-600 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200"
                        />
                    </div>
                </div>

                <!-- Icons Grid -->
                <div class="p-6 overflow-y-auto max-h-96">
                    @if(empty($filteredIcons))
                        <div class="text-center py-8">
                            <i class="ri-search-line text-4xl text-gray-500 mb-2"></i>
                            <p class="text-gray-400">لم يتم العثور على أيقونات</p>
                        </div>
                    @else
                        @foreach($filteredIcons as $category => $categoryIcons)
                            <div class="mb-6">
                                <!-- Category Title -->
                                <h4 class="text-lg font-semibold text-white mb-3 capitalize">
                                    @switch($category)
                                        @case('business') الأعمال @break
                                        @case('tech') التكنولوجيا @break
                                        @case('communication') التواصل @break
                                        @case('media') الوسائط @break
                                        @case('navigation') التنقل @break
                                        @case('actions') الإجراءات @break
                                        @case('status') الحالة @break
                                        @case('user') المستخدم @break
                                        @case('files') الملفات @break
                                        @case('shopping') التسوق @break
                                        @default {{ $category }}
                                    @endswitch
                                </h4>

                                <!-- Icons Grid -->
                                <div class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12 gap-3">
                                    @foreach($categoryIcons as $icon)
                                        <button 
                                            type="button"
                                            wire:click="selectIcon('{{ $icon }}')"
                                            class="flex items-center justify-center w-12 h-12 rounded-lg border-2 transition-all duration-200 hover:border-primary hover:bg-primary hover:bg-opacity-10 group
                                                {{ $selectedIcon === $icon ? 'border-primary bg-primary bg-opacity-20' : 'border-gray-600 bg-[#162033]' }}"
                                            title="{{ $icon }}"
                                        >
                                            <i class="{{ $icon }} text-xl transition-colors duration-200 
                                                {{ $selectedIcon === $icon ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }}"></i>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-between p-6 border-t border-gray-700">
                    <button 
                        wire:click="closeModal"
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200"
                    >
                        إلغاء
                    </button>
                    
                    @if($selectedIcon)
                        <div class="flex items-center text-white">
                            <i class="{{ $selectedIcon }} text-xl ml-2"></i>
                            <span class="text-sm text-gray-300">{{ $selectedIcon }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="{{ $fieldName }}" value="{{ $selectedIcon }}" />
</div> 