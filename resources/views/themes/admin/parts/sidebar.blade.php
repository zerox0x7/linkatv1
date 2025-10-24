 <div class="w-64 bg-gradient-to-b from-[#0f1623] to-[#162033] sticky top-0 h-screen flex flex-col border-l border-[#2a3548] shadow-2xl">

    <!-- Logo Section with Modern Styling -->
    <a href="{{ route('home') }}" target="_blank" class="p-6 flex justify-center items-center border-b border-[#2a3548] bg-gradient-to-r from-[#121827] to-[#1a2234] hover:opacity-80 transition-opacity">
        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-primary to-secondary flex items-center justify-center shadow-lg">
            <span class="text-black font-['Pacifico'] text-lg font-bold">L</span>
        </div>
        <span class="text-primary font-['Pacifico'] text-xl mr-3">{{ \App\Models\Setting::get('store_name', config('app.name')) }}</span>
    </a>

     <div class="flex flex-col flex-grow p-4 overflow-y-auto custom-scrollbar"
         style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

         <!-- لوحة التحكم -->
         <div class="mb-6">
             <div class="s-dropdown-item">
                 <button class="s-dropdown-toggle flex items-center justify-between w-full p-3 rounded-xl bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-300 group shadow-lg hover:shadow-xl"
                     onclick="toggleDropdown('dashboard')">
                     <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-dashboard-line text-blue-400 group-hover:text-primary transition-colors"></i>
                         </div>
                         <span class="text-gray-300 font-medium group-hover:text-white transition-colors">لوحة التحكم</span>
                     </div>
                     <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transform transition-all duration-300" id="dashboard-arrow"></i>
                 </button>
                 <div class="s-dropdown-content mr-4 mt-3 space-y-2" id="dashboard-content">
                     <a href="{{ route('admin.dashboard') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-primary/20 to-secondary/20 flex items-center justify-center">
                             <i class="ri-dashboard-line text-sm {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"></i>
                         </div>
                         <span class="font-medium">لوحة التحكم الرئيسية</span>
                     </a>
                 </div>
             </div>
         </div>

         <!-- إدارة المتجر -->
         <div class="mb-6">
             <div class="s-dropdown-item">
                 <button class="s-dropdown-toggle flex items-center justify-between w-full p-3 rounded-xl bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-300 group shadow-lg hover:shadow-xl"
                     onclick="toggleDropdown('store')">
                     <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-store-2-line text-green-400 group-hover:text-primary transition-colors"></i>
                         </div>
                         <span class="text-gray-300 font-medium group-hover:text-white transition-colors">إدارة المتجر</span>
                     </div>
                     <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transform transition-all duration-300" id="store-arrow"></i>
                 </button>
                 <div class="s-dropdown-content mr-4 mt-3 space-y-2" id="store-content">

                     <a href="{{ route('admin.products.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-orange-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-shopping-bag-line text-sm {{ request()->routeIs('admin.products.*') ? 'text-primary' : 'text-orange-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">المنتجات</span>
                     </a>

                     <a href="{{ route('admin.orders.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-blue-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-shopping-cart-line text-sm {{ request()->routeIs('admin.orders.*') ? 'text-primary' : 'text-blue-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">الطلبات</span>
                     </a>

                     <a href="{{ route('admin.categories.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-purple-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-price-tag-3-line text-sm {{ request()->routeIs('admin.categories.*') ? 'text-primary' : 'text-purple-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">التصنيفات</span>
                     </a>

                     <a href="{{ route('admin.coupons.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.coupons.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-pink-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-coupon-3-line text-sm {{ request()->routeIs('admin.coupons.*') ? 'text-primary' : 'text-pink-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">اكواد الخصم</span>
                     </a>

                     <a href="{{ route('admin.users.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-indigo-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-user-line text-sm {{ request()->routeIs('admin.users.*') ? 'text-primary' : 'text-indigo-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">العملاء</span>
                     </a>

                     <a href="{{ route('admin.payment-methods.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.payment-methods.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-cyan-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-bank-card-line text-sm {{ request()->routeIs('admin.payment-methods.*') ? 'text-primary' : 'text-cyan-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">طرق الدفع</span>
                     </a>

                     <a href="{{ route('admin.reviews.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.reviews.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-yellow-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-star-line text-sm {{ request()->routeIs('admin.reviews.*') ? 'text-primary' : 'text-yellow-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">تقيمات المنتجات</span>
                     </a>

                     <a href="{{ route('admin.site-reviews.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.site-reviews.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-emerald-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-store-2-line text-sm {{ request()->routeIs('admin.site-reviews.*') ? 'text-primary' : 'text-emerald-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">تقيمات المتجر</span>
                     </a>

                 </div>
             </div>
         </div>

         <!-- إدارة واجهة المتجر -->
         <div class="mb-6">
             <div class="s-dropdown-item">
                 <button class="s-dropdown-toggle flex items-center justify-between w-full p-3 rounded-xl bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-300 group shadow-lg hover:shadow-xl"
                     onclick="toggleDropdown('settings')">
                     <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-layout-line text-purple-400 group-hover:text-primary transition-colors"></i>
                         </div>
                         <span class="text-gray-300 font-medium group-hover:text-white transition-colors">إدارة واجهة المتجر</span>
                     </div>
                     <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transform transition-all duration-300" id="settings-arrow"></i>
                 </button>
                 <div class="s-dropdown-content mr-4 mt-3 space-y-2" id="settings-content">
                     <a href="{{ route('admin.home-sections.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.home-sections.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-primary/20 to-secondary/20 flex items-center justify-center">
                             <i class="ri-home-line text-sm {{ request()->routeIs('admin.home-sections.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">الرئيسية</span>
                     </a>
                     
                    <a href="{{ route('admin.customizer.products-page') }}"
                        class="flex items-center gap-3 {{ request()->routeIs('admin.customizer.products-page') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                        <div class="w-6 h-6 rounded bg-gradient-to-r from-orange-500/20 to-red-500/20 flex items-center justify-center">
                            <i class="ri-shopping-bag-line text-sm {{ request()->routeIs('admin.customizer.products-page') ? 'text-primary' : 'text-orange-400 group-hover:text-primary' }} transition-colors"></i>
                        </div>
                        <span class="font-medium">المنتجات</span>
                    </a>
                    
                    <!-- الصفحات الثابتة مع قائمة فرعية -->
                    <div class="s-dropdown-item-nested">
                        <button class="s-dropdown-toggle-nested flex items-center justify-between w-full {{ request()->routeIs('admin.static-pages.*') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg"
                            onclick="toggleNestedDropdown('static-pages')">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded bg-gradient-to-r from-cyan-500/20 to-blue-500/20 flex items-center justify-center">
                                    <i class="ri-file-text-line text-sm {{ request()->routeIs('admin.static-pages.*') ? 'text-primary' : 'text-cyan-400 group-hover:text-primary' }} transition-colors"></i>
                                </div>
                                <span class="font-medium">الصفحات الثابتة</span>
                            </div>
                            <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transform transition-all duration-300" id="static-pages-arrow"></i>
                        </button>
                        <div class="s-dropdown-content-nested mr-6 mt-2 space-y-2" id="static-pages-content" style="display: none;">
                            <a href="{{ route('admin.static-pages.index') }}"
                                class="flex items-center gap-2 {{ request()->routeIs('admin.static-pages.index') ? 'bg-gradient-to-r from-primary/10 to-secondary/10 text-primary' : 'bg-[#0a0f1a] text-gray-400 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 hover:text-white' }} p-2 rounded-lg border border-[#1a2234] transition-all duration-300 text-sm">
                                <i class="ri-list-check text-xs"></i>
                                <span>جميع الصفحات</span>
                            </a>
                            <a href="{{ route('admin.static-pages.create') }}"
                                class="flex items-center gap-2 {{ request()->routeIs('admin.static-pages.create') ? 'bg-gradient-to-r from-primary/10 to-secondary/10 text-primary' : 'bg-[#0a0f1a] text-gray-400 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 hover:text-white' }} p-2 rounded-lg border border-[#1a2234] transition-all duration-300 text-sm">
                                <i class="ri-add-circle-line text-xs"></i>
                                <span>إضافة صفحة جديدة</span>
                            </a>
                            @php
                                $staticPages = \App\Models\StaticPage::orderBy('created_at', 'desc')->limit(5)->get();
                            @endphp
                            @if($staticPages->count() > 0)
                                <div class="border-t border-[#1a2234] pt-2 mt-2">
                                    <span class="text-xs text-gray-500 px-2 block mb-2">الصفحات الأخيرة:</span>
                                    @foreach($staticPages as $page)
                                        <a href="{{ route('admin.static-pages.edit', $page->id) }}"
                                            class="flex items-center gap-2 bg-[#0a0f1a] text-gray-400 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 hover:text-white p-2 rounded-lg border border-[#1a2234] transition-all duration-300 text-sm">
                                            <i class="ri-file-line text-xs"></i>
                                            <span class="truncate">{{ $page->title ?? 'صفحة' }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>     
            </div>
        </div>

         <!-- تخصيص الواجهة المتقدمة -->
         <div class="mb-6">
             <div class="s-dropdown-item">
                 <button class="s-dropdown-toggle flex items-center justify-between w-full p-3 rounded-xl bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-300 group shadow-lg hover:shadow-xl"
                     onclick="toggleDropdown('advanced-settings')">
                     <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-settings-4-line text-indigo-400 group-hover:text-primary transition-colors"></i>
                         </div>
                         <span class="text-gray-300 font-medium group-hover:text-white transition-colors">تخصيص متقدم</span>
                     </div>
                     <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transform transition-all duration-300" id="advanced-settings-arrow"></i>
                 </button>
                 <div class="s-dropdown-content mr-4 mt-3 space-y-2" id="advanced-settings-content">
                     <a href="{{ route('admin.customizer.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.customizer.index') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-orange-500/20 to-red-500/20 flex items-center justify-center">
                             <i class="ri-pages-line text-sm {{ request()->routeIs('admin.customizer.index') ? 'text-primary' : 'text-orange-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">البانر الرئيسي</span>
                     </a>
                     <a href="{{ route('admin.customizer.menu') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.customizer.menu') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-blue-500/20 to-purple-500/20 flex items-center justify-center">
                             <i class="ri-menu-line text-sm {{ request()->routeIs('admin.customizer.menu') ? 'text-primary' : 'text-blue-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">القوائم</span>
                     </a>
                     <a href="{{ route('admin.customizer.footer') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.customizer.footer') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-green-500/20 to-teal-500/20 flex items-center justify-center">
                             <i class="ri-layout-bottom-line text-sm {{ request()->routeIs('admin.customizer.footer') ? 'text-primary' : 'text-green-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">الفوتر</span>
                     </a>
                     <a href="{{ route('admin.customizer.top-header') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.customizer.top-header') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-indigo-500/20 to-purple-500/20 flex items-center justify-center">
                             <i class="ri-layout-top-line text-sm {{ request()->routeIs('admin.customizer.top-header') ? 'text-primary' : 'text-indigo-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">الهيدر العلوي</span>
                     </a>
                     <a href="{{ route('admin.customizer.coupons-offers') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.customizer.coupons-offers') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-pink-500/20 to-rose-500/20 flex items-center justify-center">
                             <i class="ri-coupon-3-line text-sm {{ request()->routeIs('admin.customizer.coupons-offers') ? 'text-primary' : 'text-pink-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">كوبونات وعروض</span>
                     </a>
                 </div>
             </div>
         </div> 




          <!-- الإعدادات عامة  المتقدمة -->
         <div class="mb-6">
             <div class="s-dropdown-item">
                 <button class="s-dropdown-toggle flex items-center justify-between w-full p-3 rounded-xl bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-300 group shadow-lg hover:shadow-xl"
                     onclick="toggleDropdown('general-settings')">
                     <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-lg bg-sky-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-settings-line text-sky-400 group-hover:text-primary transition-colors"></i>
                         </div>
                         <span class="text-gray-300 font-medium group-hover:text-white transition-colors">الإعدادات العامة</span>
                     </div>
                     <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transform transition-all duration-300" id="advanced-settings-arrow"></i>
                 </button>
                 <div class="s-dropdown-content mr-4 mt-3 space-y-2" id="general-settings-content">
                     <a href="{{ route('admin.products.advanced-coupon') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.products.advanced-coupon') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-orange-500/20 to-red-500/20 flex items-center justify-center">
                             <i class="ri-coupon-2-line text-sm {{ request()->routeIs('admin.customizer.index') ? 'text-primary' : 'text-orange-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">   أكواد الخصم </span>
                     </a>
                     <!-- <a href="{{ route('admin.customizer.menu') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.customizer.menu') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-blue-500/20 to-purple-500/20 flex items-center justify-center">
                             <i class="ri-menu-line text-sm {{ request()->routeIs('admin.customizer.menu') ? 'text-primary' : 'text-blue-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">القوائم</span>
                     </a> -->
                 </div>
             </div>
         </div>

         <!-- إدارة الثيمات -->
         <div class="mb-6">
             <div class="s-dropdown-item">
                 <button class="s-dropdown-toggle flex items-center justify-between w-full p-3 rounded-xl bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] hover:border-primary/30 transition-all duration-300 group shadow-lg hover:shadow-xl"
                     onclick="toggleDropdown('themes')">
                     <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-500/10 to-pink-500/10 flex items-center justify-center group-hover:bg-primary/20 transition-all duration-300">
                             <i class="ri-paint-brush-line text-purple-400 group-hover:text-primary transition-colors"></i>
                         </div>
                         <span class="text-gray-300 font-medium group-hover:text-white transition-colors">الثيمات</span>
                     </div>
                     <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-primary transform transition-all duration-300" id="themes-arrow"></i>
                 </button>
                 <div class="s-dropdown-content mr-4 mt-3 space-y-2" id="themes-content">
                     <a href="{{ route('admin.themes.index') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.themes.index') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                             <i class="ri-layout-grid-line text-sm {{ request()->routeIs('admin.themes.index') ? 'text-primary' : 'text-purple-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">إدارة الثيمات</span>
                     </a>
                     <a href="{{ route('admin.themes.customize') }}"
                         class="flex items-center gap-3 {{ request()->routeIs('admin.themes.customize') ? 'bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/50 text-primary' : 'bg-[#0f1623] border-[#2a3548] text-gray-300 hover:bg-gradient-to-r hover:from-primary/10 hover:to-secondary/10 hover:border-primary/30 hover:text-white' }} p-3 rounded-lg border transition-all duration-300 group shadow-md hover:shadow-lg">
                         <div class="w-6 h-6 rounded bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                             <i class="ri-brush-3-line text-sm {{ request()->routeIs('admin.themes.customize') ? 'text-primary' : 'text-purple-400 group-hover:text-primary' }} transition-colors"></i>
                         </div>
                         <span class="font-medium">تخصيص الثيم النشط</span>
                     </a>
                 </div>
             </div>
         </div>

         <!-- معلومات المستخدم -->
         <div class="mt-auto">
             <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-4 border border-[#2a3548] shadow-lg">
                 <div class="flex items-center">
                     <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-primary to-secondary flex items-center justify-center shadow-md">
                         <i class="ri-user-line text-black"></i>
                     </div>
                     <div class="mr-3 flex-1">
                         <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'محمد أحمد' }}</p>
                         <p class="text-xs text-gray-400">مدير المتجر</p>
                     </div>
                     <form action="{{ route('logout') }}" method="POST">
                         @csrf
                         <button type="submit"
                             class="w-8 h-8 rounded-lg bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center text-red-400 hover:text-red-300 transition-all duration-300 group">
                             <i class="ri-logout-box-line group-hover:scale-110 transition-transform"></i>
                         </button>
                     </form>
                 </div>
             </div>
         </div>

     </div>

 </div>

 <style>
     /* Custom scrollbar styling */
     .custom-scrollbar::-webkit-scrollbar {
         width: 6px;
     }
     
     .custom-scrollbar::-webkit-scrollbar-track {
         background: rgba(42, 53, 72, 0.3);
         border-radius: 3px;
     }
     
     .custom-scrollbar::-webkit-scrollbar-thumb {
         background: linear-gradient(135deg, var(--primary), var(--secondary));
         border-radius: 3px;
     }
     
     .custom-scrollbar::-webkit-scrollbar-thumb:hover {
         background: linear-gradient(135deg, var(--primary), var(--secondary));
         opacity: 0.8;
     }
 </style>

 <script>
     function toggleDropdown(section) {
         const content = document.getElementById(section + '-content');
         const arrow = document.getElementById(section + '-arrow');

         content.classList.toggle('show');
         arrow.classList.toggle('rotate-180');
     }

    function toggleNestedDropdown(section) {
        const content = document.getElementById(section + '-content');
        const arrow = document.getElementById(section + '-arrow');

        if (content.style.display === 'none' || content.style.display === '') {
            content.style.display = 'block';
            arrow.classList.add('rotate-180');
        } else {
            content.style.display = 'none';
            arrow.classList.remove('rotate-180');
        }
    }

     // التحقق من الصفحة الحالية وفتح القسم المناسب عند تحميل الصفحة
     document.addEventListener('DOMContentLoaded', function() {
         // الخطوة 1: التحقق من روابط إدارة المتجر
         // نتحقق إذا كان المستخدم في صفحة المنتجات أو الطلبات
         @if (request()->routeIs('admin.products.index') 
         || request()->routeIs('admin.orders.*') 
         || request()->routeIs('admin.categories.*') 
         || request()->routeIs('admin.users.*')
         || request()->routeIs('admin.coupons.*')
         || request()->routeIs('admin.reviews.*')
         || request()->routeIs('admin.site-reviews.*')
         || request()->routeIs('admin.payment-methods.*')

    )
             // الخطوة 2: فتح قسم إدارة المتجر إذا كان في إحدى صفحاته
             toggleDropdown('store')
           
             // الخطوة 3: إضافة أقسام أخرى حسب الحاجة
         @elseif (request()->routeIs('admin.dashboard') || request()->routeIs('admin.reports.*'))
             // فتح قسم لوحة التحكم إذا كان موجوداً
             toggleDropdown('dashboard');

       @elseif (request()->routeIs('admin.home-sections.*') || request()->routeIs('admin.customizer.products-page') || request()->routeIs('admin.static-pages.*'))
           toggleDropdown('settings');
           @if(request()->routeIs('admin.static-pages.*'))
               toggleNestedDropdown('static-pages');
           @endif
    
        @elseif (request()->routeIs('admin.customizer.*'))
            toggleDropdown('advanced-settings');
    
        @elseif (request()->routeIs('admin.products.advanced-coupon'))
            toggleDropdown('general-settings');

        @elseif (request()->routeIs('admin.themes.*'))
            toggleDropdown('themes');

         @else
             // الخطوة 4: فتح قسم إدارة المتجر كقيمة افتراضية
             // إذا لم يكن في أي من الأقسام المحددة، افتح إدارة المتجر
             // toggleDropdown('store');
         @endif
     });
    
 </script> 






