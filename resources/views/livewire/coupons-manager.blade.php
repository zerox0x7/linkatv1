 <div>
    

                


    <main class="p-6">
        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-4 bg-green-900 border border-green-700 text-green-100 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="mb-4 bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        <!-- Copy Success Notification -->
        @if($showCopySuccess)
            <div class="fixed top-4 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3 animate-in slide-in-from-right duration-300">
                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="ri-check-line text-sm"></i>
                </div>
                <div>
                    <p class="font-medium">Coupon Copied!</p>
                    <p class="text-sm text-green-100">{{ $copiedCouponCode }} copied to clipboard</p>
                </div>
                <button wire:click="hideCopySuccess" class="ml-4 text-green-200 hover:text-white">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
        
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Coupons</h2>
                        <p class="text-gray-400 mt-1">Manage your discount coupons and promotions</p>
                        </div>
                        <a href="{{ route('admin.coupons.create') }}"
                        class="bg-primary text-gray-900 px-4 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-primary/90">
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            <i class="ri-add-line"></i>
                        </div>
                        Add New Coupon
                    </a>
                </div>
                <!-- Filters -->
           
                <!-- Coupon Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  
                    
                 


                      @foreach($coupons as $coupon)
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->

                        @if($coupon->style_id)
                                 

                            @include("themes.admin.coupon-style.$coupon->style_id",['coupon'=>$coupon])

                            @else

                            @include("themes.admin.coupon-style.default",['coupon'=>$coupon])

                            @endif
                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge {{ $coupon->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">{{ $coupon->code }}</h3>
                                    <p class="text-gray-300 mt-1">
                                        @if($coupon->type === 'percentage')
                                            Off {{ $coupon->value }}%
                                        @else
                                            {{ $coupon->value }} SAR Off
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>{{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'No limit' }}</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>{{ $coupon->starts_at ? $coupon->starts_at->format('M d, Y') : 'Immediate' }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>{{ $coupon->used_times ?? 0 }}</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>{{ $coupon->max_uses ?? 'Unlimited' }}</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">{{ ucfirst($coupon->type) }}</span>
                                <div class="flex space-x-2">
                                    <!-- Settings Button -->
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                                            class="w-8 ml-2 h-8 bg-primary hover:bg-primary/80 rounded-full flex items-center justify-center transition-colors">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-900">
                                            <i class="ri-settings-3-line"></i>
                                        </div>
</a>  
                                    <!-- Edit Button -->
                                    <!-- <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                                       class="w-8 h-8 bg-gray-700 hover:bg-gray-600 rounded-full flex items-center justify-center transition-colors">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </a> -->
                                    <!-- Delete Button -->
                                    <button wire:click="copyCoupon({{ $coupon->id }})" class="w-8 h-8 bg-gray-700 hover:bg-gray-600 rounded-full flex items-center justify-center transition-colors group">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300 group-hover:text-white">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                    <button wire:click="confirmDelete({{ $coupon->id }})" class="w-8 h-8 bg-gray-700 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <!-- Copy Button -->
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach





















                </div>
                <!-- Pagination -->
    {{ $coupons->links('vendor.pagination.custom') }}
                <!-- <div class="flex justify-center mt-8">
                    <nav class="flex items-center">
                        <button class="pagination-item mr-2 bg-gray-700">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <i class="ri-arrow-left-s-line"></i>
                            </div>
                        </button>
                        <button class="pagination-item mr-2 bg-gray-700">3</button>
                        <button class="pagination-item mr-2 bg-gray-700">2</button>
                        <button class="pagination-item mr-2 active">1</button>
                        <button class="pagination-item bg-gray-700">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <i class="ri-arrow-right-s-line"></i>
                            </div>
                        </button>
                    </nav>
                </div> -->














    </main>

        {{-- <livewire:coupon-settings-modal :coupon="$coupon" :key="$coupon->id" /> --}}
   

    <!-- Modal Component -->
    {{-- @if($showCouponSettings && $selectedCoupon)
        <livewire:coupon-settings-modal :coupon="$selectedCoupon" :key="$selectedCoupon->id" />
    @endif --}}
    
    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $couponToDelete)
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
                            <h3 class="text-2xl font-bold text-white mb-2 tracking-tight">حذف الكوبون</h3>
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
                    <div class="mb-8 space-y-4 text-right">
                        <p class="text-gray-300 leading-relaxed text-base">
                            أنت على وشك حذف الكوبون نهائياً
                        </p>
                        
                        <!-- Coupon Code Highlight -->
                        <div class="bg-gradient-to-l from-gray-800/50 to-gray-700/50 rounded-xl p-5 border border-gray-600/30">
                            <div class="flex items-center justify-between">
                                <div class="text-left">
                                    <p class="text-gray-400 text-xs mb-1">مرات الاستخدام</p>
                                    <p class="text-white font-semibold text-lg">{{ $couponToDelete->used_times ?? 0 }}</p>
                                </div>
                                <div class="flex items-center space-x-reverse space-x-3">
                                    <div>
                                        <p class="text-white font-bold text-xl mb-1">{{ $couponToDelete->code }}</p>
                                        <p class="text-gray-400 text-sm">
                                            @if($couponToDelete->type === 'percentage')
                                                خصم {{ $couponToDelete->value }}%
                                            @else
                                                خصم {{ $couponToDelete->value }} ريال
                                            @endif
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                        <i class="ri-coupon-line text-primary text-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-gray-400 text-sm leading-relaxed">
                            سيتم حذف جميع البيانات المرتبطة وتاريخ الاستخدام والإعدادات نهائياً من النظام.
                        </p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-reverse space-x-3">
                        <button wire:click="deleteCoupon" 
                                class="flex-1 px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:scale-[1.02] active:scale-[0.98]">
                            <span class="flex items-center justify-center space-x-reverse space-x-2">
                                <span class="font-semibold">حذف نهائي</span>
                                <i class="ri-delete-bin-line text-base"></i>
                            </span>
                        </button>
                        
                        <button wire:click="cancelDelete" 
                                class="flex-1 px-6 py-3.5 bg-gray-800/60 hover:bg-gray-700/80 text-gray-300 hover:text-white rounded-xl font-medium transition-all duration-200 border border-gray-600/40 hover:border-gray-500/60 hover:scale-[1.02] active:scale-[0.98]">
                            <span class="flex items-center justify-center space-x-reverse space-x-2">
                                <span class="font-semibold">إلغاء</span>
                                <i class="ri-close-line text-base"></i>
                            </span>
                        </button>
                    </div>
                </div>
                
                <!-- Bottom Glow Effect -->
                <div class="absolute bottom-0 right-1/2 transform translate-x-1/2 w-1/2 h-px bg-gradient-to-l from-transparent via-red-500/50 to-transparent"></div>
            </div>
        </div>
    @endif
    
    <!-- JavaScript for Copy Functionality -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Listen for copy to clipboard event
            Livewire.on('copyToClipboard', (event) => {
                const code = event.code;
                
                if (navigator.clipboard && window.isSecureContext) {
                    // Use modern clipboard API
                    navigator.clipboard.writeText(code).then(() => {
                        console.log('Coupon code copied to clipboard:', code);
                    }).catch(err => {
                        console.error('Failed to copy to clipboard:', err);
                        // Fallback to legacy method
                        fallbackCopy(code);
                    });
                } else {
                    // Fallback for older browsers or non-secure contexts
                    fallbackCopy(code);
                }
            });
            
            // Listen for hide copy success event
            Livewire.on('hideCopySuccess', () => {
                setTimeout(() => {
                    @this.hideCopySuccess();
                }, 3000);
            });
        });
        
        // Fallback copy function for older browsers
        function fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                console.log('Coupon code copied to clipboard (fallback):', text);
            } catch (err) {
                console.error('Fallback copy failed:', err);
            }
            
            document.body.removeChild(textArea);
        }
    </script>
</div>  


















