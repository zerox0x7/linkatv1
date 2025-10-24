  <!-- Header -->
  <header class="bg-[#0f172a] border-b border-gray-800 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Left side - User info and cart -->
                <div class="flex items-center space-x-4 flex-row-reverse">
                    <div class="flex mr-4 items-center space-x-2 cursor-pointer flex-row-reverse">
                        <span class="text-sm font-medium">GamerPro</span>
                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">
                            <i class="ri-user-3-line text-white"></i>
                        </div>
                    </div>
                    <!-- <div
                        class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer">
                        <i class="ri-notification-3-line text-white"></i>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center text-[10px]">3</span>
                    </div> -->
                    <div
                        class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer">
                        <i class="ri-shopping-cart-2-line text-white"></i>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-[10px]">5</span>
                    </div>
                    <!-- <div class="flex items-center space-x-1 bg-gray-800 px-3 py-1 rounded-full">
                        <i class="ri-coin-line text-yellow-400"></i>
                        <span class="text-yellow-400 font-medium">7,220</span>
                    </div> -->
                </div>
                <!-- Middle - Search -->
                <div class="flex-1 max-w-xl mx-4">
                    <form action="{{ route('products.search') }}" method="GET" class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن الألعاب، الحسابات، العناصر..."
                            class="w-full bg-gray-800 border-none rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 flex items-center justify-center">
                            <i class="ri-search-line text-gray-400 hover:text-primary transition-colors"></i>
                        </button>
                    </form>
                </div>
                <!-- Right - Logo -->
                <div class="flex items-center space-x-4">
                  
                    <div class="font-['Pacifico'] text-2xl text-white">
                        <img src="{{ asset('storage/'.$homePage->store_logo) }}" alt="logo" class="w-14 h-14">
                    </div>
                </div>
            </div>
            <!-- Navigation Menu -->
            <nav class="mt-3 flex justify-between items-center">
                <div class="flex space-x-8">
                    @foreach ($menus as $menu)
                    <a href="{{ $menu->url }}" class="{{ request()->is($menu->url) ? 'text-blue-400 border-b-2 border-blue-400 bg-blue-900/20' : 'text-gray-400 hover:text-blue-400' }} transition-colors duration-200 flex items-center space-x-2 py-2 px-3 rounded-t-lg">
                        <i class="{{ $menu->svg }} text-xl"></i>
                        <span class="font-medium">{{ $menu->title }}</span>
                    </a>
                    @endforeach

                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-primary flex items-center space-x-2 py-2">
                        <i class="ri-wallet-3-line"></i>
                        <span>المحفظة</span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary flex items-center space-x-2 py-2">
                        <i class="ri-settings-4-line"></i>
                        <span>الإعدادات</span>
                    </a>
                </div>
            </nav>
        </div>
    </header>