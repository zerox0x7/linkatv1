<div class="p-6">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-6 bg-green-900/50 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg flex items-center animate-in fade-in duration-300">
            <i class="ri-check-circle-line text-xl ml-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-900/50 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg flex items-center animate-in fade-in duration-300">
            <i class="ri-error-warning-line text-xl ml-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <button onclick="Livewire.dispatch('openModal')"
            class="bg-primary text-gray-900 px-4 py-2 rounded-button flex items-center whitespace-nowrap">
            <div class="w-5 h-5 flex items-center justify-center ml-2">
                <i class="ri-add-line"></i>
            </div>
            <span>إضافة فئة جديدة</span>
        </button>

        <div class="flex items-center">
            <h1 class="text-2xl font-bold">الفئات</h1>
            <span class="bg-gray-700 text-gray-300 text-sm rounded-full px-2 py-1 mr-2">(45)</span>
        </div>
    </div>

  

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Category 1 -->
        @foreach ($cate as $cat)
            <div class="bg-gradient-to-br from-[{{$cat->bg_color}}] to-[{{$cat->bg_color}}] rounded-lg overflow-hidden shadow-lg">
                <div class="relative h-40">
                    <img src="{{ asset('storage/'.$cat->image)}}"
                        alt="الإلكترونيات" class="w-full h-full object-cover object-top" />
                    <div class="absolute top-2 left-2">
                        @if($cat->is_active)
                        <span class="status-badge status-active">نشط</span>
                        @else
                        <span class="status-badge bg-gray-500 ">غير نشط </span>
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-xl font-bold text-white">{{$cat->name}}</h3>
                        <span class="text-sm bg-white bg-opacity-20 px-2 py-1 rounded">{{$cat->products_count}} منتج</span>
                    </div>
                    <p class="text-white text-opacity-80 text-sm mb-4">
                        {{$cat->description}}
                    </p>
                    <div class="flex justify-between">
                        <button wire:click="confirmDelete({{ $cat->id }})"
                            class="w-10 h-10 flex items-center justify-center bg-white bg-opacity-20 rounded-full hover:bg-red-500 hover:bg-opacity-90 transition-all duration-200 group">
                            <i class="ri-delete-bin-line text-white group-hover:text-white"></i>
                        </button>
                        <!-- <button
                            class="w-10 h-10 flex items-center justify-center bg-white bg-opacity-20 rounded-full hover:bg-opacity-30">
                            <i class="ri-eye-line text-white"></i>
                        </button> -->
                        <a href="{{ route('admin.categories.edit', $cat) }}"
                            class="w-10 h-10 flex items-center justify-center bg-white bg-opacity-20 rounded-full hover:bg-primary hover:bg-opacity-90 transition-all duration-200 group">
                            <i class="ri-edit-line text-white group-hover:text-gray-900"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    
    </div>
    @if(method_exists($cate, 'links'))
        {{$cate->links('vendor.pagination.custom')}}
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $categoryToDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" dir="rtl">
            <!-- Backdrop with blur effect -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="cancelDelete"></div>
            
            <!-- Modal Container -->
            <div class="relative bg-gradient-to-br from-gray-900/95 to-gray-800/95 backdrop-blur-xl border border-gray-700/50 rounded-2xl shadow-2xl max-w-md w-full mx-4 animate-in zoom-in-95 duration-300" 
                 wire:click.stop>
                
                <!-- Gradient Border Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 via-orange-500/20 to-red-500/20 rounded-2xl blur-sm -z-10"></div>
                
                <!-- Modal Content -->
                <div class="relative p-6 sm:p-8">
                    <!-- Header Section -->
                    <div class="flex items-start mb-8 space-x-reverse space-x-4">
                        <!-- Header Text -->
                        <div class="flex-1 text-right">
                            <h3 class="text-2xl font-bold text-white mb-2 tracking-tight">حذف الفئة</h3>
                            <p class="text-gray-400 text-sm font-medium">هذا الإجراء لا يمكن التراجع عنه</p>
                        </div>
                        
                        <!-- Animated Icon Container -->
                        <div class="relative ml-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/25">
                                <i class="ri-delete-bin-line text-white text-2xl"></i>
                            </div>
                            <!-- Pulsing Ring Effect -->
                            <div class="absolute inset-0 w-16 h-16 bg-red-500/30 rounded-2xl animate-ping"></div>
                        </div>
                        
                        <!-- Close Button -->
                        <button wire:click="cancelDelete" 
                                class="absolute top-4 left-4 w-8 h-8 bg-gray-800/80 hover:bg-gray-700 rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <i class="ri-close-line text-gray-400 hover:text-white"></i>
                        </button>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="space-y-6 mb-8">
                        <!-- Category Info Card -->
                        <div class="bg-gradient-to-br from-[{{$categoryToDelete->bg_color}}]/20 to-[{{$categoryToDelete->bg_color}}]/10 border border-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center space-x-reverse space-x-3">
                                @if($categoryToDelete->image)
                                    <img src="{{ asset('storage/'.$categoryToDelete->image) }}" 
                                         alt="{{ $categoryToDelete->name }}" 
                                         class="w-12 h-12 rounded-lg object-cover">
                                @endif
                                <div class="flex-1 text-right">
                                    <h4 class="text-lg font-semibold text-white">{{ $categoryToDelete->name }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $categoryToDelete->products_count ?? 0 }} منتج</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Warning Message -->
                        <div class="bg-yellow-900/30 border border-yellow-600/50 rounded-xl p-4">
                            <div class="flex items-start space-x-reverse space-x-3">
                                <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="ri-alert-line text-white text-sm"></i>
                                </div>
                                <div class="flex-1 text-right">
                                    <p class="text-yellow-300 font-medium mb-1">تحذير هام</p>
                                    <p class="text-yellow-200/80 text-sm leading-relaxed">
                                        هل أنت متأكد من حذف الفئة "<span class="font-semibold text-yellow-100">{{ $categoryToDelete->name }}</span>"؟
                                        @if($categoryToDelete->products_count > 0)
                                            <br><span class="text-red-300 font-medium">تحتوي هذه الفئة على {{ $categoryToDelete->products_count }} منتج وسيتم منع الحذف.</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between space-x-reverse space-x-4">
                        <!-- Cancel Button -->
                        <button wire:click="cancelDelete"
                                class="flex-1 px-6 py-3 bg-gray-700/80 hover:bg-gray-600 text-gray-200 font-medium rounded-xl transition-all duration-200 hover:scale-[1.02] flex items-center justify-center space-x-reverse space-x-2">
                            <i class="ri-close-line"></i>
                            <span>إلغاء</span>
                        </button>
                        
                        <!-- Delete Button -->
                        <button wire:click="deleteCategory"
                                wire:loading.attr="disabled"
                                wire:target="deleteCategory"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-xl transition-all duration-200 hover:scale-[1.02] hover:shadow-lg hover:shadow-red-500/25 flex items-center justify-center space-x-reverse space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div wire:loading wire:target="deleteCategory" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            <i wire:loading.remove wire:target="deleteCategory" class="ri-delete-bin-line"></i>
                            <span wire:loading.remove wire:target="deleteCategory">حذف نهائياً</span>
                            <span wire:loading wire:target="deleteCategory">جاري الحذف...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Category Add New Component -->
    @livewire('category-add-new')

</div>