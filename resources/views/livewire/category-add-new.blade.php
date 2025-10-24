<div>
    @if($showModal)
    <div>
    <!-- Modal Backdrop - Add click handler for outside click -->
    <div   class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
         onclick="@this.closeModal()">
        <div class="bg-[#1A202C] rounded-lg w-full max-w-md max-h-[90vh] shadow-xl flex flex-col"
             onclick="event.stopPropagation()"> <!-- Prevent modal close when clicking inside -->
            
            <!-- Header - Fixed -->
            <div class="flex justify-between items-center p-6 border-b border-gray-700 flex-shrink-0">
                <h2 class="text-xl font-bold text-white">إضافة فئة جديدة</h2>
                <button id="closeModal" wire:click="closeModal" class="text-gray-400 hover:text-white transition-colors">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="ri-close-line"></i>
                    </div>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-track-gray-800 scrollbar-thumb-gray-600 hover:scrollbar-thumb-gray-500">
                <div class="p-6">
                    <form wire:submit.prevent="store" enctype="multipart/form-data">
                        <!-- Category Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">اسم الفئة</label>
                            <input type="text" wire:model="name" 
                                class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="أدخل اسم الفئة">
                            @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Category Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">وصف الفئة</label>
                            <textarea wire:model="description" 
                                class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors h-24 resize-none @error('description') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="أدخل وصف الفئة"></textarea>
                            @error('description') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Category Image - Add drag and drop handlers -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">صورة الفئة</label>
                            <div class="border-2 border-dashed border-gray-600 hover:border-gray-500 rounded-lg p-4 text-center transition-colors"
                                 ondrop="handleImageDrop(event)" 
                                 ondragover="event.preventDefault()" 
                                 ondragenter="event.preventDefault()">
                                @if($imagePreview)
                                    <div class="mb-2">
                                        <img src="{{ $imagePreview }}" alt="Preview" class="w-20 h-20 object-cover rounded-lg mx-auto shadow-md">
                                        <button type="button" wire:click="removeImage" 
                                            class="mt-2 text-xs text-red-400 hover:text-red-300 transition-colors">
                                            إزالة الصورة
                                        </button>
                                    </div>
                                @else
                                    <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center bg-gray-700 rounded-full">
                                        <i class="ri-upload-2-line text-gray-400 text-lg"></i>
                                    </div>
                                    <p class="text-sm text-gray-400 mb-2">
                                        اسحب الصورة هنا أو انقر للتصفح
                                    </p>
                                @endif
                                
                                <input type="file" wire:model="image" class="hidden" id="categoryImage" accept="image/*">
                                <button type="button" class="text-xs text-blue-400 hover:text-blue-300 bg-gray-800 hover:bg-gray-700 px-3 py-1 rounded transition-colors"
                                    onclick="document.getElementById('categoryImage').click()">
                                    {{ $imagePreview ? 'تغيير الصورة' : 'تصفح الملفات' }}
                                </button>
                                
                                <div wire:loading wire:target="image" class="text-xs text-gray-400 mt-2">
                                    جاري رفع الصورة...
                                </div>
                            </div>
                            @error('image') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Color Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-3">لون الفئة</label>
                            <div class="grid grid-cols-5 gap-3">
                                @foreach($availableColors as $colorValue => $colorName)
                                    <div class="relative">
                                        <input type="radio" 
                                            wire:model.live="color" 
                                            value="{{ $colorValue }}" 
                                            id="color_{{ $loop->index }}" 
                                            class="sr-only">
                                        <label for="color_{{ $loop->index }}" 
                                            class="block w-10 h-10 rounded-full cursor-pointer border-3 transition-all duration-200 hover:scale-105 shadow-md
                                            {{ $color === $colorValue ? 'border-white ring-2 ring-white ring-offset-2 ring-offset-gray-800 scale-110' : 'border-gray-600 hover:border-gray-400' }}"
                                            style="background-color: {{ $colorValue }}"
                                            title="{{ $colorName }}">
                                            @if($color === $colorValue)
                                                <div class="w-full h-full rounded-full flex items-center justify-center">
                                                    <i class="ri-check-line text-white text-lg font-bold drop-shadow"></i>
                                                </div>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('color') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Icon Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">أيقونة الفئة</label>
                            @livewire('icon-select-input', [
                                'value' => $icon,
                                'wireModel' => 'icon',
                                'placeholder' => 'اختر أيقونة للفئة',
                                'customClass' => 'w-full bg-gray-800 text-white py-2 px-4 rounded-lg border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors'
                            ], key('category-icon-selector'))
                            @error('icon') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Order and Home Order -->
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب الفئة</label>
                                <input type="number" wire:model="order" 
                                    class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors @error('order') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="1" min="1">
                                @error('order') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب الصفحة الرئيسية</label>
                                <input type="number" wire:model="home_order" 
                                    class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors @error('home_order') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="1" min="1">
                                @error('home_order') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Status Toggle -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-3">الحالة</label>
                            <div class="flex items-center">
                                <div class="relative inline-block w-16 h-8 ml-4">
                                    <input type="checkbox" wire:model.live="is_active" id="statusToggle" class="sr-only">
                                    <label for="statusToggle" 
                                        class="block overflow-hidden h-8 rounded-full cursor-pointer transition-all duration-300 ease-in-out shadow-inner
                                        {{ $is_active ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-gray-600 to-gray-700' }}">
                                        <div class="absolute top-1 bg-white w-6 h-6 rounded-full transition-all duration-300 ease-in-out shadow-lg border border-gray-300
                                            {{ $is_active ? 'transform -translate-x-1' : '-translate-x-8' }}">
                                            <div class="w-full h-full rounded-full flex items-center justify-center">
                                                @if($is_active)
                                                    <i class="ri-check-line text-green-600 text-xs"></i>
                                                @else
                                                    <i class="ri-close-line text-gray-400 text-xs"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium {{ $is_active ? 'text-green-400' : 'text-gray-400' }} transition-colors">
                                        {{ $is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $is_active ? 'الفئة متاحة للعرض' : 'الفئة مخفية عن العرض' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer - Fixed -->
            <div class="p-6 border-t border-gray-700 flex-shrink-0">
                <div class="flex justify-end gap-3">
                    <button id="cancelButton" type="button" wire:click="closeModal"
                        class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg whitespace-nowrap transition-colors duration-200">
                        إلغاء
                    </button>
                    <button type="submit" wire:loading.attr="disabled" wire:click="store"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg whitespace-nowrap transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="store">إضافة الفئة</span>
                        <span wire:loading wire:target="store" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            جاري الحفظ...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-[70] animate-fade-in">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-[70] animate-fade-in">
            {{ session('error') }}
        </div>
    @endif

    <!-- Custom Styles -->
    <style>
        /* Custom Scrollbar Styles */
        .scrollbar-thin {
            scrollbar-width: thin;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-track-gray-800::-webkit-scrollbar-track {
            background-color: #1f2937;
            border-radius: 3px;
        }

        .scrollbar-thumb-gray-600::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 3px;
        }

        .hover\:scrollbar-thumb-gray-500:hover::-webkit-scrollbar-thumb {
            background-color: #6b7280;
        }

        /* Custom animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Improved focus states */
        .focus\:ring-1:focus {
            box-shadow: 0 0 0 1px var(--tw-ring-color);
        }
    </style>
    @endif
</div>



