<div class="relative">
    <!-- Label -->
    @if($label)
        <label class="block text-sm font-medium text-gray-300 mb-2">{{ $label }}</label>
    @endif

    <!-- Selected Options Display -->
    <div class="relative">
        <button 
            type="button"
            wire:click="openModal"
            class="w-full bg-[#162033] border border-gray-600 rounded-lg px-4 py-3 text-right text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 flex items-center justify-between hover:border-gray-500 min-h-[50px]"
        >
            <div class="flex items-center flex-wrap gap-2 flex-1">
                @if($multiple && !empty($selectedOptions))
                    <!-- Multiple selections display -->
                    @foreach($selectedOptions as $value)
                        @php
                            $option = collect($options)->firstWhere('value', $value);
                        @endphp
                        @if($option)
                            <span class="inline-flex items-center bg-primary/20 text-primary px-2 py-1 rounded-full text-sm">
                                @if($displayType === 'icon' && $option['icon'])
                                    <i class="{{ $option['icon'] }} text-sm ml-1"></i>
                                @elseif($displayType === 'color' && $option['color'])
                                    <div class="w-3 h-3 rounded-full ml-1" style="background-color: {{ $option['color'] }};"></div>
                                @elseif($displayType === 'image' && $option['image'])
                                    <img src="{{ $option['image'] }}" class="w-4 h-4 rounded ml-1" alt="">
                                @endif
                                {{ $option['label'] }}
                                <button 
                                    type="button"
                                    wire:click.stop="removeOption('{{ $value }}')"
                                    class="ml-1 text-primary/70 hover:text-primary"
                                >
                                    <i class="ri-close-line text-xs"></i>
                                </button>
                            </span>
                        @endif
                    @endforeach
                @elseif(!$multiple && $selectedValue)
                    <!-- Single selection display -->
                    @php
                        $selectedOption = collect($options)->firstWhere('value', $selectedValue);
                    @endphp
                    @if($selectedOption)
                        <div class="flex items-center">
                            @if($displayType === 'icon' && $selectedOption['icon'])
                                <i class="{{ $selectedOption['icon'] }} text-lg ml-3"></i>
                            @elseif($displayType === 'color' && $selectedOption['color'])
                                <div class="w-5 h-5 rounded-full ml-3" style="background-color: {{ $selectedOption['color'] }};"></div>
                            @elseif($displayType === 'image' && $selectedOption['image'])
                                <img src="{{ $selectedOption['image'] }}" class="w-6 h-6 rounded ml-3" alt="">
                            @elseif($displayType === 'badge')
                                <span class="bg-primary/20 text-primary px-2 py-1 rounded text-sm ml-3">
                                    {{ $selectedOption['category'] ?? 'عام' }}
                                </span>
                            @endif
                            <span class="text-gray-300">{{ $selectedOption['label'] }}</span>
                            @if($selectedOption['description'])
                                <span class="text-gray-500 text-sm mr-2"> - {{ Str::limit($selectedOption['description'], 30) }}</span>
                            @endif
                        </div>
                    @endif
                @else
                    <span class="text-gray-400">{{ $placeholder }}</span>
                @endif
            </div>
            
            <div class="flex items-center gap-2">
                @if(($multiple && !empty($selectedOptions)) || (!$multiple && $selectedValue))
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
        </button>
    </div>

    <!-- Options Selection Modal -->
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <div class="bg-[#0f1419] rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[80vh] overflow-hidden" wire:click.stop>
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-700">
                    <h3 class="text-xl font-semibold text-white">
                        {{ $label }} 
                        @if($multiple && $maxSelections)
                            <span class="text-sm text-gray-400">({{ count($selectedOptions) }}/{{ $maxSelections }})</span>
                        @endif
                    </h3>
                    <button 
                        wire:click="closeModal"
                        class="text-gray-400 hover:text-white transition-colors"
                    >
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <!-- Search -->
                @if($searchable)
                    <div class="p-6 border-b border-gray-700">
                        <div class="relative">
                            <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input 
                                type="text" 
                                wire:model.live="searchTerm"
                                placeholder="{{ $searchPlaceholder }}"
                                class="w-full bg-[#162033] border border-gray-600 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200"
                            />
                        </div>
                    </div>
                @endif

                <!-- Options List -->
                <div class="p-6 overflow-y-auto max-h-96">
                    @if(empty($filteredOptions))
                        <div class="text-center py-8">
                            <i class="ri-search-line text-4xl text-gray-500 mb-2"></i>
                            <p class="text-gray-400">{{ $emptyMessage }}</p>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach($filteredOptions as $option)
                                <button 
                                    type="button"
                                    wire:click="selectOption('{{ $option['value'] }}', '{{ $option['label'] }}')"
                                    class="w-full flex items-center p-3 rounded-lg border-2 transition-all duration-200 hover:border-primary hover:bg-primary hover:bg-opacity-10 group text-left
                                        {{ $this->isSelected($option['value']) ? 'border-primary bg-primary bg-opacity-20' : 'border-gray-600 bg-[#162033]' }}"
                                >
                                    <!-- Selection Indicator -->
                                    @if($multiple)
                                        <div class="w-5 h-5 rounded border-2 flex items-center justify-center ml-3 {{ $this->isSelected($option['value']) ? 'border-primary bg-primary' : 'border-gray-400' }}">
                                            @if($this->isSelected($option['value']))
                                                <i class="ri-check-line text-white text-sm"></i>
                                            @endif
                                        </div>
                                    @else
                                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center ml-3 {{ $this->isSelected($option['value']) ? 'border-primary bg-primary' : 'border-gray-400' }}">
                                            @if($this->isSelected($option['value']))
                                                <div class="w-2 h-2 rounded-full bg-white"></div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Option Content -->
                                    <div class="flex items-center flex-1">
                                        @if($displayType === 'icon' && $option['icon'])
                                            <i class="{{ $option['icon'] }} text-xl ml-3 {{ $this->isSelected($option['value']) ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }}"></i>
                                        @elseif($displayType === 'color' && $option['color'])
                                            <div class="w-8 h-8 rounded-lg ml-3 border-2 border-gray-500" style="background-color: {{ $option['color'] }};"></div>
                                        @elseif($displayType === 'image' && $option['image'])
                                            <img src="{{ $option['image'] }}" class="w-10 h-10 rounded-lg ml-3 object-cover" alt="">
                                        @elseif($displayType === 'badge' && $option['category'])
                                            <span class="bg-secondary/20 text-secondary px-2 py-1 rounded text-sm ml-3">
                                                {{ $option['category'] }}
                                            </span>
                                        @endif

                                        <div class="flex-1">
                                            <div class="font-medium {{ $this->isSelected($option['value']) ? 'text-primary' : 'text-white group-hover:text-primary' }}">
                                                {{ $option['label'] }}
                                            </div>
                                            @if($option['description'])
                                                <div class="text-sm text-gray-400 mt-1">
                                                    {{ $option['description'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
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
                        @if($multiple)
                            تم ({{ count($selectedOptions) }})
                        @else
                            إلغاء
                        @endif
                    </button>
                    
                    @if($multiple && !empty($selectedOptions))
                        <button 
                            wire:click="clearSelection"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                        >
                            مسح الكل
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Hidden Input for Form Submission -->
    @if($multiple)
        @foreach($selectedOptions as $value)
            <input type="hidden" name="{{ $fieldName }}[]" value="{{ $value }}" />
        @endforeach
    @else
        <input type="hidden" name="{{ $fieldName }}" value="{{ $selectedValue }}" />
    @endif
</div> 