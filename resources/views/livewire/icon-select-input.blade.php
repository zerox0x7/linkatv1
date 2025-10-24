<div class="relative" wire:ignore.self>
    <!-- Label -->
    @if($label)
        <label class="text-sm font-medium text-right mb-2 block">{{ $label }}</label>
    @endif

    <!-- Form Input Style Display -->
    <div class="relative">
        <button 
            type="button"
            wire:click="openModal"
            class="{{ $customClass }} bg-[#162033] border border-gray-600 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 flex items-center justify-between hover:border-gray-500 text-right"
        >
            <div class="flex items-center flex-1">
                @if($value && $selectedLabel)
                    <div class="flex items-center">
                        <i class="{{ $value }} text-lg ml-3 text-primary"></i>
                        <span class="text-white">{{ $selectedLabel }}</span>
                    </div>
                @else
                    <span class="text-gray-400">{{ $placeholder }}</span>
                @endif
            </div>
            
          {{--  <div class="flex items-center gap-2">
                @if($value)
                    <button 
                        type="button"
                        wire:click.stop="clearSelection"
                        class="text-gray-400 hover:text-red-400 transition-colors"
                        title="مسح التحديد"
                    >
                        <i class="ri-close-line"></i>
                    </button>
                @endif
                <i class="ri-arrow-down-s-line text-gray-400"></i>
            </div>
            --}}
       
       
        </button>
    </div>

    <!-- Icons Selection Modal -->
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <div class="bg-[#0f1419] rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[80vh] overflow-hidden" wire:click.stop>
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-700">
                    <h3 class="text-xl font-semibold text-white">
                        {{ $label ?: 'اختر أيقونة الخدمة' }}
                    </h3>
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
                            placeholder="ابحث عن الأيقونة..."
                            class="w-full bg-[#162033] border border-gray-600 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200"
                        />
                    </div>
                </div>

                <!-- Icons Grid -->
                <div class="p-6 overflow-y-auto max-h-96">
                    @if(empty($filteredIcons))
                        <div class="text-center py-8">
                            <i class="ri-search-line text-4xl text-gray-500 mb-2"></i>
                            <p class="text-gray-400">لا توجد أيقونات مطابقة</p>
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($filteredIcons as $iconValue => $iconLabel)
                                <button 
                                    type="button"
                                    wire:click="selectIcon('{{ $iconValue }}')"
                                    class="flex flex-col items-center p-4 rounded-lg border-2 transition-all duration-200 hover:border-primary hover:bg-primary hover:bg-opacity-10 group
                                        {{ $value == $iconValue ? 'border-primary bg-primary bg-opacity-20' : 'border-gray-600 bg-[#162033]' }}"
                                >
                                    <i class="{{ $iconValue }} text-3xl mb-2 {{ $value == $iconValue ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }}"></i>
                                    <span class="text-sm {{ $value == $iconValue ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }}">
                                        {{ $iconLabel }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
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
                    
                    @if($value)
                        <button 
                            wire:click="clearSelection"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                        >
                            مسح التحديد
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div> 