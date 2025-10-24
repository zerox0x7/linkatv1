  <header class="bg-[#162033]  border-b border-gray-700  sticky  h-16 flex items-center px-6 sticky top-0 z-10">
                <div class="flex-1 flex items-center">
                    <div class="w-8 h-8 flex items-center justify-center mr-4 lg:hidden">
                        <i class="ri-menu-line ri-lg"></i>
                    </div>
                    <div class="relative flex-1 max-w-md">
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <i class="ri-search-line"></i>
                        </div>
                        <input type="text"
                            class="bg-gray-800 border-none text-sm rounded-lg block w-full pr-10 p-2.5 focus:ring-primary focus:border-primary text-right"
                            placeholder="بحث...">
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div id="notification-btn"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-800 cursor-pointer relative">
                        <i class="ri-notification-line ri-lg"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-primary rounded-full"></span>
                        <div id="notification-dropdown"
                            class="hidden absolute left-0 top-full mt-2 w-80 rounded bg-gray-900 shadow-lg border border-gray-800 z-50">
                            <div class="p-4 border-b border-gray-800">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium">الإشعارات</h3>
                                    <button id="mark-all-read"
                                        class="text-xs text-primary hover:text-primary/80">تحديد الكل كمقروء</button>
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <div class="notification-item p-4 border-b border-gray-800 bg-gray-800/50">
                                    <div class="flex items-start">
                                        <div class="w-2 h-2 mt-2 bg-primary rounded-full flex-shrink-0"></div>
                                        <div class="mr-3 flex-1">
                                            <p class="text-sm">طلب جديد #ORD-7896</p>
                                            <p class="text-xs text-gray-400 mt-1">قام محمد أحمد بإضافة طلب جديد</p>
                                            <span class="text-xs text-gray-500 mt-2 block">منذ 5 دقائق</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-item p-4 border-b border-gray-800">
                                    <div class="flex items-start">
                                        <div class="w-2 h-2 mt-2 bg-gray-600 rounded-full flex-shrink-0"></div>
                                        <div class="mr-3 flex-1">
                                            <p class="text-sm">تحديث المنتج</p>
                                            <p class="text-xs text-gray-400 mt-1">تم تحديث مخزون المنتج "سماعات
                                                لاسلكية"</p>
                                            <span class="text-xs text-gray-500 mt-2 block">منذ ساعة</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-item p-4 border-b border-gray-800">
                                    <div class="flex items-start">
                                        <div class="w-2 h-2 mt-2 bg-gray-600 rounded-full flex-shrink-0"></div>
                                        <div class="mr-3 flex-1">
                                            <p class="text-sm">تنبيه النظام</p>
                                            <p class="text-xs text-gray-400 mt-1">تم اكتمال النسخ الاحتياطي اليومي
                                                بنجاح</p>
                                            <span class="text-xs text-gray-500 mt-2 block">منذ 3 ساعات</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 text-center border-t border-gray-800">
                                <button class="text-sm text-primary hover:text-primary/80">عرض كل الإشعارات</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- <label class="switch" id="theme-switch">
<input type="checkbox" checked>
<span class="slider"></span>
</label> --}}
                
                        <div class="relative" id="language-selector">
                            <div class="flex items-center space-x-2 border-r border-gray-700 pr-4 cursor-pointer"
                                id="language-button">
                                <div class="w-5 h-5 flex items-center justify-center">
                                    <i class="ri-global-line"></i>
                                </div>
                                <span>AR</span>
                                <div class="w-8 h-8 flex items-center justify-center">
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                            <div class="absolute left-0 top-full mt-2 w-48 bg-gray-900 rounded shadow-lg border border-gray-800 hidden"
                                id="language-dropdown">
                                <div class="p-2 space-y-1">
                                    <div
                                        class="flex items-center justify-between px-3 py-2 text-white bg-primary/10 rounded">
                                        <div class="flex items-center">
                                            <i class="ri-flag-line ml-2"></i>
                                            <span class="text-sm">العربية</span>
                                        </div>
                                        <span class="text-xs bg-primary/20 px-2 py-0.5 rounded">Active</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between px-3 py-2 text-gray-400 hover:bg-gray-800 rounded cursor-not-allowed">
                                        <div class="flex items-center">
                                            <i class="ri-flag-line ml-2"></i>
                                            <span class="text-sm">English</span>
                                        </div>
                                        <span class="text-xs text-primary">Coming Soon</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
  </header>



    <script id="notification-handler">
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBtn = document.getElementById('notification-btn');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const markAllReadBtn = document.getElementById('mark-all-read');
            const languageButton = document.getElementById('language-button');
            const languageDropdown = document.getElementById('language-dropdown');
            let isDropdownOpen = false;
            let isLanguageDropdownOpen = false;
            notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                isDropdownOpen = !isDropdownOpen;
                notificationDropdown.classList.toggle('hidden');
            });
            languageButton.addEventListener('click', (e) => {
                e.stopPropagation();
                isLanguageDropdownOpen = !isLanguageDropdownOpen;
                languageDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!notificationBtn.contains(e.target) && isDropdownOpen) {
                    notificationDropdown.classList.add('hidden');
                    isDropdownOpen = false;
                }
                if (!languageButton.contains(e.target) && isLanguageDropdownOpen) {
                    languageDropdown.classList.add('hidden');
                    isLanguageDropdownOpen = false;
                }
            });
            markAllReadBtn.addEventListener('click', () => {
                const unreadDots = document.querySelectorAll('.notification-item .bg-primary');
                unreadDots.forEach(dot => {
                    dot.classList.remove('bg-primary');
                    dot.classList.add('bg-gray-600');
                });
                const notificationDot = notificationBtn.querySelector('.bg-primary');
                if (notificationDot) {
                    notificationDot.classList.add('hidden');
                }
            });
        });
    </script>