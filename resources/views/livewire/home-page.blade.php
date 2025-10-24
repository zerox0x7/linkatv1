<div class="flex-1 overflow-y-auto bg-[#111827] p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-500/20 text-green-400 p-4 rounded-md border border-green-500/50">
                {{ session('message') }}
            </div>
        @endif

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-2">تخصيص الصفحة الرئيسية</h1>
            <p class="text-gray-400">قم بتخصيص وتعديل محتوى الصفحة الرئيسية لمتجرك</p>
        </div>

        <!-- Store Info Section -->
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <button wire:click="saveStoreInfo" 
                        class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">
                        حفظ التغييرات
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">معلومات المتجر</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-store-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">اسم المتجر</label>
                    <input type="text" wire:model="store_name" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">وصف المتجر</label>
                    <textarea rows="3" wire:model="store_description" class="custom-input p-3 rounded-md w-full"></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">شعار المتجر</label>
                    <div class="relative">
                        <!-- Image Upload Area -->
                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-primary transition-colors"
                             x-data="{ 
                                 isDragging: false,
                                 handleFiles(files) {
                                     if (files.length > 0) {
                                         @this.uploadIterator++;
                                         @this.upload('store_logo_file', files[0], (uploadedFilename) => {
                                             // Upload completed
                                         }, () => {
                                             // Upload error
                                         }, (event) => {
                                             // Upload progress
                                         });
                                     }
                                 }
                             }"
                             x-on:dragover.prevent="isDragging = true"
                             x-on:dragleave.prevent="isDragging = false"
                             x-on:drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
                             :class="{ 'border-primary bg-primary/10': isDragging }">
                            
                            @if($store_logo)
                                <div class="space-y-4">
                                    <div class="mx-auto w-24 h-24 rounded-lg overflow-hidden bg-gray-700">
                                        <img src="{{ asset('storage/'.$store_logo) }}" alt="Store Logo" class="w-full h-full object-cover">
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-300">شعار المتجر الحالي</p>
                                        <button wire:click="removeStoreLogo" 
                                                class="text-red-400 hover:text-red-300 text-sm">
                                            <i class="ri-delete-bin-line mr-1"></i>
                                            حذف الشعار
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <div class="mx-auto w-16 h-16 text-gray-400">
                                        <i class="ri-image-add-line text-4xl"></i>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-300">اسحب وأفلت الصورة هنا</p>
                                        <p class="text-xs text-gray-500">أو</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- File Input -->
                            <input type="file" 
                                   wire:model="store_logo_file"
                                   accept="image/*"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   x-on:change="handleFiles($event.target.files)">
                        </div>
                        
                        <!-- Upload Progress -->
                        <div wire:loading wire:target="store_logo_file" class="mt-2">
                            <div class="bg-gray-700 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full animate-pulse" style="width: 50%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-center">جاري رفع الصورة...</p>
                        </div>
                        
                        <!-- File Format Info -->
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            الصيغ المدعومة: JPG, PNG, GIF (حد أقصى 2MB)
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
         
        {{-- Hero Section - Commented Out
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="hero_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">القسم البطولي (Hero Section)</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-layout-top-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">العنوان الرئيسي</label>
                    <input type="text" wire:model="hero_title" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">العنوان الفرعي</label>
                    <input type="text" wire:model="hero_subtitle" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">نص الزر الأول</label>
                        <input type="text" wire:model="hero_button1_text" class="custom-input p-3 rounded-md w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">رابط الزر الأول</label>
                        <input type="text" wire:model="hero_button1_link" class="custom-input p-3 rounded-md w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">نص الزر الثاني</label>
                        <input type="text" wire:model="hero_button2_text" class="custom-input p-3 rounded-md w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">رابط الزر الثاني</label>
                        <input type="text" wire:model="hero_button2_link" class="custom-input p-3 rounded-md w-full">
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">صورة الخلفية</label>
                    <div class="relative">
                        <!-- Image Upload Area -->
                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-primary transition-colors"
                             x-data="{ 
                                 isDragging: false,
                                 handleFiles(files) {
                                     if (files.length > 0) {
                                         @this.uploadIterator++;
                                         @this.upload('hero_background_image_file', files[0], (uploadedFilename) => {
                                             // Upload completed
                                         }, () => {
                                             // Upload error
                                         }, (event) => {
                                             // Upload progress
                                         });
                                     }
                                 }
                             }"
                             x-on:dragover.prevent="isDragging = true"
                             x-on:dragleave.prevent="isDragging = false"
                             x-on:drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
                             :class="{ 'border-primary bg-primary/10': isDragging }">
                            
                            @if($hero_background_image)
                                <div class="space-y-4">
                                    <div class="mx-auto w-24 h-24 rounded-lg overflow-hidden bg-gray-700">
                                        <img src="{{ 
                                            str_starts_with($hero_background_image, 'http') 
                                                ? $hero_background_image 
                                                : asset('storage/'.$hero_background_image) 
                                        }}" alt="Hero Background Image" class="w-full h-full object-cover">
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-300">صورة الخلفية الحالية</p>
                                        <button wire:click="removeHeroBackgroundImage" 
                                                class="text-red-400 hover:text-red-300 text-sm">
                                            <i class="ri-delete-bin-line mr-1"></i>
                                            حذف الصورة
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <div class="mx-auto w-16 h-16 text-gray-400">
                                        <i class="ri-image-add-line text-4xl"></i>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-300">اسحب وأفلت الصورة هنا</p>
                                        <p class="text-xs text-gray-500">أو</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- File Input -->
                            <input type="file" 
                                   wire:model="hero_background_image_file"
                                   accept="image/*"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   x-on:change="handleFiles($event.target.files)">
                        </div>
                        
                        <!-- Upload Progress -->
                        <div wire:loading wire:target="hero_background_image_file" class="mt-2">
                            <div class="bg-gray-700 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full animate-pulse" style="width: 50%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-center">جاري رفع الصورة...</p>
                        </div>
                        
                        <!-- File Format Info -->
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            الصيغ المدعومة: JPG, PNG, GIF (حد أقصى 2MB)
                        </p>
                    </div>
                </div>
            </div>
        </div>
        --}}
         

        <!-- Categories Section -->
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="categories_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">قسم الفئات</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-grid-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">عنوان القسم</label>
                    <input type="text" wire:model="categories_title" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center mb-2">
                        <button wire:click="openCategoryModal" 
                            class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">
                            اختيار الفئات
                        </button>
                        <label class="text-sm font-medium text-right">الفئات المعروضة</label>
                    </div>
                    <div class="space-y-4">
                        @foreach($selected_categories as $index => $category)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="category-{{ $index }}-{{ $category['id'] ?? $index }}">
                                <div class="flex items-center gap-3">
                                    <button wire:click="removeCategory({{ $index }})" 
                                        wire:loading.attr="disabled"
                                        wire:target="removeCategory"
                                        class="text-gray-400 hover:text-red-500 disabled:opacity-50">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="font-medium">{{ $category['name'] ?? 'فئة غير محددة' }}</p>
                                        <p class="text-sm text-gray-400">{{ $category['products_count'] ?? 0 }} منتج</p>
                                    </div>
                                    <div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
                                        <i class="{{ $category['icon'] ?? 'ri-grid-line' }} text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
         {{--
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="featured_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">المنتجات المميزة</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-award-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">عنوان القسم</label>
                    <input type="text" wire:model="featured_title" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <button wire:click="openProductModal" 
                                class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">
                                اختيار المنتجات
                            </button>
                            <select wire:model="featured_count" class="custom-input p-3 rounded-md text-sm pr-8">
                                <option value="4">عرض 4 منتجات</option>
                                <option value="8">عرض 8 منتجات</option>
                                <option value="12">عرض 12 منتج</option>
                            </select>
                        </div>
                        <label class="text-sm font-medium text-right">المنتجات المعروضة</label>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($selected_featured_products as $index => $product)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="featured-product-{{ $index }}-{{ $product['id'] ?? $index }}">
                                <div class="flex items-center gap-3">
                                    <button wire:click="removeProduct({{ $index }})" 
                                        wire:loading.attr="disabled"
                                        wire:target="removeProduct"
                                        class="text-gray-400 hover:text-red-500 disabled:opacity-50">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="font-medium">{{ $product['name'] ?? 'منتج غير محدد' }}</p>
                                        <p class="text-sm text-primary">{{ $product['price'] ?? 0 }} ريال</p>
                                    </div>
                                    <div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
                                        @if($product['image'])
                                            <img src="{{ asset('storage/'.$product['image']) }}" alt="{{ $product['name'] }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="ri-image-line text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        --}}
        <!-- Brand Section -->
         {{--
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="brand_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">العلامات التجارية</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-medal-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">عنوان القسم</label>
                    <input type="text" wire:model="brand_title" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <button wire:click="openBrandModal" 
                                class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">
                                اختيار المنتجات
                            </button>
                            <select wire:model="brand_count" class="custom-input p-3 rounded-md text-sm pr-8">
                                <option value="3">عرض 3 منتجات</option>
                                <option value="6">عرض 6 منتجات</option>
                                <option value="9">عرض 9 منتجات</option>
                                <option value="12">عرض 12 منتج</option>
                            </select>
                        </div>
                        <label class="text-sm font-medium text-right">المنتجات المعروضة</label>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($selected_brand_products as $index => $product)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="brand-product-{{ $index }}-{{ $product['id'] ?? $index }}">
                                <div class="flex items-center gap-3">
                                    <button wire:click="removeBrandProduct({{ $index }})" 
                                        wire:loading.attr="disabled"
                                        wire:target="removeBrandProduct"
                                        class="text-gray-400 hover:text-red-500 disabled:opacity-50">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="font-medium">{{ $product['name'] ?? 'منتج غير محدد' }}</p>
                                        <p class="text-sm text-primary">{{ $product['price'] ?? 0 }} ريال</p>
                                    </div>
                                    <div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
                                        @if($product['image'])
                                            <img src="{{ asset('storage/'.$product['image']) }}" alt="{{ $product['name'] }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="ri-image-line text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
       --}}
        <!-- Services Section -->
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="services_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">خدمات المتجر</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-customer-service-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">عنوان القسم</label>
                    <input type="text" wire:model="services_title" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center mb-2">
                        <button wire:click="openServiceModal" 
                            class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">
                            إضافة خدمة
                        </button>
                        <label class="text-sm font-medium text-right">الخدمات المعروضة</label>
                    </div>
                    <div class="space-y-4">
                        @foreach($services_data as $index => $service)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="service-{{ $index }}-{{ $service['id'] ?? $index }}">
                                <div class="flex items-center gap-3">
                                    <button wire:click="removeService({{ $index }})" 
                                        wire:loading.attr="disabled"
                                        wire:target="removeService"
                                        class="text-gray-400 hover:text-red-500 disabled:opacity-50">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="font-medium">{{ $service['title'] ?? 'خدمة غير محددة' }}</p>
                                        <p class="text-sm text-gray-400">{{ $service['description'] ?? '' }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
                                        <i class="{{ $service['icon'] ?? 'ri-service-line' }} text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="reviews_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">آراء العملاء</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-chat-quote-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">عنوان القسم</label>
                    <input type="text" wire:model="reviews_title" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <button wire:click="openReviewModal" 
                                class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">
                                اختيار التقييمات
                            </button>
                            <select wire:model="reviews_count" class="custom-input p-3 rounded-md text-sm pr-8">
                                <option value="3">عرض 3 تقييمات</option>
                                <option value="6">عرض 6 تقييمات</option>
                                <option value="9">عرض 9 تقييمات</option>
                            </select>
                        </div>
                        <label class="text-sm font-medium text-right">التقييمات المعروضة</label>
                    </div>
                    <div class="space-y-4">
                        @foreach($selected_reviews as $index => $review)
                            <div class="bg-[#111827] rounded-md p-4" wire:key="review-{{ $index }}-{{ $review['id'] ?? $index }}">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ri-star-{{ $i <= ($review['rating'] ?? 0) ? 'fill' : 'line' }} text-yellow-400"></i>
                                        @endfor
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="text-right">
                                            <p class="font-medium">{{ $review['name'] ?? 'عميل' }}</p>
                                            <p class="text-sm text-gray-400">{{ $review['city'] ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
                                            <i class="ri-user-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-300 text-right">{{ $review['comment'] ?? '' }}</p>
                                <div class="flex justify-end mt-3">
                                    <button wire:click="removeReview({{ $index }})" 
                                        wire:loading.attr="disabled"
                                        wire:target="removeReview"
                                        class="text-gray-400 hover:text-red-500 disabled:opacity-50">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Section -->
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="location_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">موقعنا</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-map-pin-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">عنوان القسم</label>
                    <input type="text" wire:model="location_title" class="custom-input p-3 rounded-md w-full">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">العنوان</label>
                        <input type="text" wire:model="location_address" class="custom-input p-3 rounded-md w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">رقم الهاتف</label>
                        <input type="text" wire:model="location_phone" class="custom-input p-3 rounded-md w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">البريد الإلكتروني</label>
                        <input type="text" wire:model="location_email" class="custom-input p-3 rounded-md w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">ساعات العمل</label>
                        <input type="text" wire:model="location_hours" class="custom-input p-3 rounded-md w-full">
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">رابط صورة الخريطة</label>
                    <input type="text" wire:model="location_map_image" class="custom-input p-3 rounded-md w-full">
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="footer_enabled" class="sr-only peer">
                        <!-- <div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div> -->
                        <span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">تذييل الصفحة</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-layout-bottom-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">وصف المتجر في التذييل</label>
                    <textarea rows="3" wire:model="footer_description" class="custom-input p-3 rounded-md w-full"></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model="new_link.title" placeholder="عنوان الرابط" class="custom-input p-2 rounded-md text-sm">
                            <input type="text" wire:model="new_link.url" placeholder="رابط الصفحة" class="custom-input p-2 rounded-md text-sm">
                            <button wire:click="addQuickLink" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة</button>
                        </div>
                        <label class="text-sm font-medium text-right">روابط سريعة</label>
                    </div>
                    <div class="space-y-2">
                        @foreach($footer_quick_links as $index => $link)
                            <div class="bg-[#111827] rounded-md p-3 flex justify-between items-center" wire:key="quick-link-{{ $index }}-{{ $link['id'] ?? $index }}">
                                <div class="flex items-center gap-3">
                                    <button wire:click="removeQuickLink({{ $index }})" 
                                        wire:loading.attr="disabled"
                                        wire:target="removeQuickLink"
                                        class="text-gray-400 hover:text-red-500 disabled:opacity-50">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="font-medium">{{ $link['title'] ?? 'رابط' }}</p>
                                        <p class="text-xs text-gray-400">{{ $link['url'] ?? '#' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-right">حقوق النشر</label>
                    <input type="text" wire:model="footer_copyright" class="custom-input p-3 rounded-md w-full">
                </div>
            </div>
        </div>

        <!-- Theme Colors Section -->
        <div class="section-card mb-8 overflow-hidden">
            <div class="section-header p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <button wire:click="saveColors" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">حفظ الألوان</button>
                </div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-medium">ألوان المتجر</h2>
                    <div class="w-6 h-6 flex items-center justify-center text-primary">
                        <i class="ri-palette-line"></i>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">اللون الرئيسي</label>
                        <div class="flex items-center gap-3">
                            <input type="text" wire:model="primary_color" class="custom-input p-3 rounded-md w-full">
                            <input type="color" wire:model="primary_color" class="color-picker">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">لون الخلفية</label>
                        <div class="flex items-center gap-3">
                            <input type="text" wire:model="background_color" class="custom-input p-3 rounded-md w-full">
                            <input type="color" wire:model="background_color" class="color-picker">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">لون النص</label>
                        <div class="flex items-center gap-3">
                            <input type="text" wire:model="text_color" class="custom-input p-3 rounded-md w-full">
                            <input type="color" wire:model="text_color" class="color-picker">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">لون النص الثانوي</label>
                        <div class="flex items-center gap-3">
                            <input type="text" wire:model="secondary_text_color" class="custom-input p-3 rounded-md w-full">
                            <input type="color" wire:model="secondary_text_color" class="color-picker">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Changes Button -->
        <div class="flex justify-between mb-8">
            <button wire:click="loadHomePageData" class="bg-gray-700 text-white py-3 px-6 rounded-button text-sm font-medium whitespace-nowrap">إعادة تحميل</button>
            <button wire:click="saveAll" class="bg-primary text-[#0f172a] py-3 px-6 rounded-button text-sm font-medium whitespace-nowrap">حفظ جميع التغييرات</button>
        </div>
    </div>

    <!-- Product Selection Modal -->
    @if($showProductModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[80vh] flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <button wire:click="closeProductModal" class="text-gray-400 hover:text-white">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                    <h3 class="text-lg font-medium">اختيار المنتجات المميزة</h3>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <div class="space-y-2">
                        @foreach($available_products as $product)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="available-product-{{ $product->id }}">
                                <div class="flex items-center gap-4">
                                    @php
                                        $isSelected = collect($selected_featured_products)->where('id', $product->id)->isNotEmpty();
                                    @endphp
                                    
                                    @if($isSelected)
                                        <button wire:click="removeProduct({{ collect($selected_featured_products)->search(function($item) use ($product) { return $item['id'] == $product->id; }) }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeProduct,addProduct"
                                            class="bg-red-600 text-white py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إزالة
                                        </button>
                                    @else
                                        <button wire:click="addProduct({{ $product->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeProduct,addProduct"
                                            class="bg-primary text-[#0f172a] py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إضافة
                                        </button>
                                    @endif
                                    
                                    <div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
                                        @if($product->main_image)
                                            <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="ri-image-line text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">{{ $product->name }}</p>
                                        <p class="text-sm text-primary">{{ $product->price }} ريال</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Brand Selection Modal -->
    @if($showBrandModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[80vh] flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <button wire:click="closeBrandModal" class="text-gray-400 hover:text-white">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                    <h3 class="text-lg font-medium">اختيار منتجات العلامة التجارية</h3>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <div class="space-y-2">
                        @foreach($available_products as $product)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="available-brand-product-{{ $product->id }}">
                                <div class="flex items-center gap-4">
                                    @php
                                        $isSelected = collect($selected_brand_products)->where('id', $product->id)->isNotEmpty();
                                    @endphp
                                    
                                    @if($isSelected)
                                        <button wire:click="removeBrandProduct({{ collect($selected_brand_products)->search(function($item) use ($product) { return $item['id'] == $product->id; }) }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeBrandProduct,addBrandProduct"
                                            class="bg-red-600 text-white py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إزالة
                                        </button>
                                    @else
                                        <button wire:click="addBrandProduct({{ $product->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeBrandProduct,addBrandProduct"
                                            class="bg-primary text-[#0f172a] py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إضافة
                                        </button>
                                    @endif
                                    
                                    <div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
                                        @if($product->main_image)
                                            <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="ri-image-line text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">{{ $product->name }}</p>
                                        <p class="text-sm text-primary">{{ $product->price }} ريال</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Category Selection Modal -->
    @if($showCategoryModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[80vh] flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <button wire:click="closeCategoryModal" class="text-gray-400 hover:text-white">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                    <h3 class="text-lg font-medium">اختيار الفئات</h3>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <div class="space-y-2">
                        @foreach($available_categories as $category)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="available-category-{{ $category->id }}">
                                <div class="flex items-center gap-4">
                                    @php
                                        $isSelected = collect($selected_categories)->where('id', $category->id)->isNotEmpty();
                                    @endphp
                                    
                                    @if($isSelected)
                                        <button wire:click="removeCategory({{ collect($selected_categories)->search(function($item) use ($category) { return $item['id'] == $category->id; }) }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeCategory,addCategory"
                                            class="bg-red-600 text-white py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إزالة
                                        </button>
                                    @else
                                        <button wire:click="addCategory({{ $category->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeCategory,addCategory"
                                            class="bg-primary text-[#0f172a] py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إضافة
                                        </button>
                                    @endif
                                    
                                    <div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
                                        <i class="{{ $category->icon ?? 'ri-grid-line' }} text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">{{ $category->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $category->products_count }} منتج</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Review Selection Modal -->
    @if($showReviewModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[80vh] flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <button wire:click="closeReviewModal" class="text-gray-400 hover:text-white">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                    <h3 class="text-lg font-medium">اختيار التقييمات</h3>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <div class="space-y-2">
                        @foreach($available_reviews as $review)
                            <div class="bg-[#111827] rounded-md p-4 flex justify-between items-center" wire:key="available-review-{{ $review->id }}">
                                <div class="flex items-center gap-4">
                                    @php
                                        $isSelected = collect($selected_reviews)->where('id', $review->id)->isNotEmpty();
                                    @endphp
                                    
                                    @if($isSelected)
                                        <button wire:click="removeReview({{ collect($selected_reviews)->search(function($item) use ($review) { return $item['id'] == $review->id; }) }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeReview,addReview"
                                            class="bg-red-600 text-white py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إزالة
                                        </button>
                                    @else
                                        <button wire:click="addReview({{ $review->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="removeReview,addReview"
                                            class="bg-primary text-[#0f172a] py-1 px-3 rounded-button text-sm disabled:opacity-50">
                                            إضافة
                                        </button>
                                    @endif
                                    
                                    <div class="text-right">
                                        <p class="font-medium">{{ $review->user->name ?? 'عميل' }}</p>
                                        <div class="flex items-center gap-1 justify-end">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="ri-star-{{ $i <= $review->rating ? 'fill' : 'line' }} text-yellow-400 text-xs"></i>
                                            @endfor
                                        </div>
                                        <p class="text-xs text-gray-400">{{ Str::limit($review->comment, 50) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Service Addition Modal -->
    @if($showServiceModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-md mx-4">
                <div class="flex justify-between items-center mb-4">
                    <button wire:click="closeServiceModal" class="text-gray-400 hover:text-white">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                    <h3 class="text-lg font-medium">إضافة خدمة جديدة</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">عنوان الخدمة</label>
                        <input type="text" wire:model="new_service.title" class="custom-input p-3 rounded-md w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">وصف الخدمة</label>
                        <textarea wire:model="new_service.description" rows="3" class="custom-input p-3 rounded-md w-full"></textarea>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-right">أيقونة الخدمة</label>
                        @livewire('icon-select-input', [
                            'value' => $new_service['icon'] ?? '',
                            'label' => '',
                            'placeholder' => 'اختر أيقونة',
                            'wireModel' => 'new_service.icon'
                        ], key('service-icon-'.now()))
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button wire:click="closeServiceModal" class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm">إلغاء</button>
                        <button wire:click="addService" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm">إضافة</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>