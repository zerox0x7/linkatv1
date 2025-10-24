<main class="flex-1   overflow-y-auto    bg-[#0f172a] p-6 ">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">المنتجات <span class="text-gray-400 text-lg">(126)</span></h1>
        <a href="{{ route('admin.products.create') }}"
            data-readdy="true"
            class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-button flex items-center whitespace-nowrap no-underline">
            <div class="w-5 h-5 flex items-center justify-center ml-2">
                <i class="ri-add-line"></i>
            </div>
            إضافة منتج جديد
        </a>
    </div>
    <!-- Filters and Actions -->
    <div class="bg-[#162033] p-6 rounded-lg mb-6 shadow-lg">
        <div class="flex flex-wrap gap-6 items-center justify-between">
            <div class="flex flex-wrap gap-4 items-center">
                <!-- Category Dropdown -->
                <div class="relative group">
                    <button wire:click="toggleCategoryDropdown"
                        class="bg-[#141c2f] text-gray-300 border border-gray-700/50 rounded-md py-2.5 px-4 pr-10 min-w-[160px] hover:bg-[#1c2436] transition-all flex items-center justify-between shadow-sm hover:shadow-md">
                        <span>{{ $this->getSelectedCategoryName() }}</span>
                        <div
                            class="w-5 h-5 flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors absolute right-3">
                            <i class="ri-filter-3-line"></i>
                        </div>
                    </button>

                    @if($showCategoryDropdown)
                    <div class="absolute z-50 w-full mt-2 bg-[#1c2436] border border-gray-700/50 rounded-lg shadow-xl">
                        <div class="py-2">
                            <!-- All Categories Option -->
                            <a wire:click="selectCategory('')"
                                class="flex items-center  justify-center px-2 py-2 text-gray-300 hover:bg-[#141c2f] hover:text-primary transition-colors cursor-pointer {{ $selectedCategory == '' ? 'bg-[#141c2f] text-primary' : '' }}">
                                <i class="ri-apps-line mx-1"></i>
                                <span>جميع الفئات</span>
                            </a>

                            <!-- Loop through categories -->
                            @foreach($categories as $category)
                            <a wire:click="selectCategory('{{ $category->id }}')"
                                class="flex  text-md items-center px-2 py-2 text-gray-300 hover:bg-[#141c2f] hover:text-primary transition-colors cursor-pointer {{ $selectedCategory == $category->id ? 'bg-[#141c2f] text-primary' : '' }}">
                                <i class="{{ $category->icon ?? 'ri-folder-line' }} mr-1 ml-1"></i>
                                <span>{{ $category->name }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Status Dropdown (unchanged) -->
                <div class="relative group">
                    <button wire:click="toggleStatusDropdown"
                        class="bg-[#141c2f] text-gray-300 border border-gray-700/50 rounded-md py-2.5 px-4 pr-10 min-w-[140px] hover:bg-[#1c2436] transition-all flex items-center justify-between shadow-sm hover:shadow-md">
                        <span>
                            @if($selectedStatus)
                            {{ $this->getStatusName($selectedStatus) }}
                            @else
                            حالة المنتج
                            @endif
                        </span>
                        <div
                            class="w-5 h-5 flex items-center justify-center text-gray-400 group-hover:text-primary transition-colors absolute right-3">
                            <i class="ri-checkbox-multiple-line"></i>
                        </div>
                    </button>

                    @if($showStatusDropdown)
                    <div class="absolute z-50 w-full mt-2 bg-[#1c2436] border border-gray-700/50 rounded-lg shadow-xl">
                        <div class="py-2">
                            <a wire:click="selectStatus('')"
                                class="flex items-center  justify-center px-2 py-2 text-gray-300 hover:bg-[#141c2f] hover:text-primary transition-colors cursor-pointer">
                                {{-- <div class="w-2 h-2 ml-2 rounded-full bg-gray-400 mr-2"></div> --}}
                                <span>جميع الحالات</span>
                            </a>
                            <a wire:click="selectStatus('active')"
                                class="flex items-center px-2 py-2 text-gray-300 hover:bg-[#141c2f] hover:text-primary transition-colors cursor-pointer">
                                <div class="w-2 h-2  ml-2 rounded-full bg-green-500 mr-2"></div>
                                <span>نشط</span>
                            </a>
                            <a wire:click="selectStatus('inactive')"
                                class="flex items-center px-2 py-2 text-gray-300 hover:bg-[#141c2f] hover:text-primary transition-colors cursor-pointer">
                                <div class="w-2 h-2 ml-2 rounded-full bg-gray-500 mr-2"></div>
                                <span>غير نشط</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button wire:click="clearFilters"
                    class="bg-[#141c2f] hover:bg-[#1c2436] text-gray-300 px-4 py-2.5 rounded-md flex items-center whitespace-nowrap transition-all border border-gray-700/50 shadow-sm hover:shadow-md group">
                    <div
                        class="w-5 h-5 flex items-center justify-center mr-2 group-hover:text-red-400 transition-colors">
                        <i class="ri-delete-bin-line"></i>
                    </div>
                    <span class="group-hover:text-red-400 transition-colors">مسح بيانات البحث</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Product Card 1 -->

        @foreach ($products as $product)
{{-- <div class="card rounded-lg overflow-hidden shadow-lg">
    <div class="relative">
        <img src="http://custom.test:8000/storage/products/roatxTJgg03hKMnbLOJJ.webp" 
             alt="Premium Headphones" 
             class="w-full h-48 object-cover object-top {{ $product->stock == 0 ? 'opacity-50 grayscale' : '' }}">
        
        <div class="absolute top-3 right-3">
            @if($product->stock == 0)
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Out of Stock</span>
            @else
                <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">inactive</span>
            @endif
        </div>
    </div>
    
    <div class="p-4">
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-semibold text-lg">سناب بلس زيرو شهر</h3>
            <label wire:id="RGl1wkJR7hgHoRcurdcX" class="switch">
                <input type="checkbox" wire:click="toggleStatus">
                <span class="slider"></span>
            </label>
        </div>
        
        <p class="text-gray-400 text-sm mb-2">snapchat</p>
        
        <div class="flex justify-between items-center mb-3">
            <span class="text-gray-300">Stock: 
                <span class="font-medium {{ $product->stock == 0 ? 'text-red-400' : 'text-white' }}">
                    {{ $product->stock }}
                </span>
            </span>
            <div class="flex flex-col items-end">
                <span class="text-xs line-through text-gray-500 mb-0.5">unset</span>
                <span class="text-primary font-semibold">35.00</span>
            </div>
        </div>
        
        <!-- Rest of your card content remains the same -->
        <div class="flex justify-between items-center mb-2">
            <span class="text-xs text-gray-400">سناب بلس زيرو شهر</span>
            <span class="text-xs text-gray-400">ORD-7895#</span>
        </div>
        
        <div class="flex justify-between pt-3 border-t border-gray-700 mt-3">
            <button class="text-gray-300 hover:text-primary">
                <div class="w-5 h-5 flex items-center justify-center">
                    <i class="ri-edit-line"></i>
                </div>
            </button>
            <button class="text-gray-300 hover:text-primary">
                <div class="w-5 h-5 flex items-center justify-center">
                    <i class="ri-coupon-line"></i>
                </div>
            </button>
            <button type="button" class="text-gray-300 hover:text-red-500" onclick="showConfirmationModal(21)">
                <div class="w-5 h-5 flex items-center justify-center">
                    <i class="ri-delete-bin-line"></i>
                </div>
            </button>
        </div>
    </div>
</div> --}}

         <div class="card rounded-lg overflow-hidden shadow-lg">
            <div class="relative">
                <img src="{{ asset('storage/' . $product->main_image) }}" alt="Premium Headphones"
                    class="w-full h-48 object-cover object-top   {{ $product->stock == 0 ? 'opacity-50 grayscale' : '' }}">
                <div class="absolute top-3 right-3">

                    @if($product->stock == 0)
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Out of Stock</span>
            @else
                <span
                        class="  {{ $product->status == 'active' ? 'bg-green-500' : 'bg-gray-500' }}  text-white text-xs px-2 py-1 rounded-full">{{$product->status}}
                    </span>
            @endif
                    
                </div>

            </div>
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-semibold text-lg">{{ \Illuminate\Support\Str::limit($product->name, 18, '...') }}
                    </h3>
                    @livewire('product-status-toggle', ['product' => $product],
                    key('product-status-'.$product->id.'-'.$selectedCategory.'-'.$selectedStatus))
                </div>
                <p class="text-gray-400 text-sm mb-2">{{ $product->category->name ?? 'بدون فئة' }}</p>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-300">Stock: <span
                            class="text-white font-medium">{{$product->stock}}</span></span>
                    <div class="flex flex-col items-end">

                        @if ($product->old_price)
                        <span class="text-xs line-through text-gray-500 mb-0.5"> {{$product->old_price}}</span>
                        <span class="text-primary font-semibold">{{$product->price}}</span>
                        @else
                        <span class="text-xs line-through text-gray-500 mb-0.5"> unset</span>
                        <span class="text-primary font-semibold">{{$product->price}}</span>
                        @endif

                    </div>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs text-gray-400">{{ \Illuminate\Support\Str::limit($product->name, 34, '...')
                        }}</span>
                    <span class="text-xs text-gray-400">ORD-7895#</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-700 mt-3">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-gray-300 hover:text-primary transition-colors">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="ri-edit-line"></i>
                        </div>
                    </a>
                    <a href="{{ route('admin.products.advanced-coupon') }}" class="text-gray-300 hover:text-primary transition-colors">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="ri-coupon-line"></i>
                        </div>
                    </a>

                    <!-- Delete Form -->

                    <button type="button" class="text-gray-300 hover:text-red-500 transition-colors"
                        onclick="showConfirmationModal({{ $product->id }})">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="ri-delete-bin-line"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div> 
        @endforeach
    </div>
    <!-- Pagination -->
    {{$products->links('vendor.pagination.custom')}}
    {{-- <div class="mt-8 flex justify-between items-center bg-[#111827] p-4 rounded-lg">
        <div class="flex items-center text-sm">
            <span class="text-gray-400">عرض</span>
            <div class="relative mx-2">
                <select
                    class="bg-[#141c2f] text-gray-300 border-none rounded-button py-1 pr-3 pl-8 appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                    <option>8</option>
                    <option>16</option>
                    <option>32</option>
                    <option>64</option>
                </select>
                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none select-icon">
                    <div class="w-4 h-4 flex items-center justify-center text-gray-400">
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                </div>
            </div>
            <span class="text-gray-400">من 126 منتج</span>
        </div>
        <div class="flex items-center space-x-1">
            <button
                class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-400 hover:bg-gray-800">
                <i class="ri-arrow-left-s-line"></i>
            </button>
            <button class="w-9 h-9 flex items-center justify-center rounded-button bg-primary text-white">1</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-300 hover:bg-gray-800">2</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-300 hover:bg-gray-800">3</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-300 hover:bg-gray-800">...</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-300 hover:bg-gray-800">16</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-400 hover:bg-gray-800">
                <i class="ri-arrow-right-s-line"></i>
            </button>
        </div>
    </div>  --}}
</main>

<!-- JavaScript -->

<script>
    let productToDelete = null;

function showConfirmationModal(productId) {
    productToDelete = productId;
    document.getElementById('confirmation-modal').classList.remove('hidden');
}

function hideConfirmationModal() {
    productToDelete = null;
    document.getElementById('confirmation-modal').classList.add('hidden');
}

function confirmDeletion() {
    if (productToDelete) {
        @this.call('destroy', productToDelete);
        hideConfirmationModal();
    }
}

</script>
<script>



 
            document.addEventListener('DOMContentLoaded', function() {
            const body = document.querySelector('body');
            const toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 9999;';
            body.appendChild(toastContainer);

            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className =
                    `flex items-center p-4 mb-3 rounded-lg shadow-lg transition-all transform translate-x-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                toast.style.minWidth = '300px';
                const icon = document.createElement('div');
                icon.className = 'w-6 h-6 flex items-center justify-center ml-3 text-white';
                icon.innerHTML = type === 'success' ? '<i class="ri-checkbox-circle-line"></i>' :
                    '<i class="ri-error-warning-line"></i>';
                const text = document.createElement('div');
                text.className = 'text-white';
                text.textContent = message;
                toast.appendChild(icon);
                toast.appendChild(text);
                toastContainer.appendChild(toast);
                requestAnimationFrame(() => {
                    toast.style.transform = 'translateX(0)';
                });
                setTimeout(() => {
                    toast.style.transform = 'translateX(full)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }






            document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = [{
                    trigger: 'languageDropdown',
                    content: 'languageDropdownContent'
                },
                {
                    trigger: 'categoryDropdown',
                    content: 'categoryDropdownContent'
                },
                {
                    trigger: 'statusDropdown',
                    content: 'statusDropdownContent'
                },
                {
                    trigger: 'sortDropdown',
                    content: 'sortDropdownContent'
                }
            ];
            dropdowns.forEach(dropdown => {
                const triggerElement = document.getElementById(dropdown.trigger);
                const contentElement = document.getElementById(dropdown.content);
                if (triggerElement && contentElement) {
                    triggerElement.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdowns.forEach(d => {
                            const content = document.getElementById(d.content);
                            if (content && d.content !== dropdown.content) {
                                content.classList.add('hidden');
                            }
                        });
                        contentElement.classList.toggle('hidden');
                    });
                    contentElement.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
            });
            window.addEventListener('click', function() {
                dropdowns.forEach(dropdown => {
                    const content = document.getElementById(dropdown.content);
                    if (content) {
                        content.classList.add('hidden');
                    }
                });
            });
        });
      







</script>