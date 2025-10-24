<!-- Header -->
<header class="bg-dark-surface border-b border-gray-700 sticky top-0 z-30 backdrop-blur-sm bg-opacity-95">
    <div class="container mx-auto px-4">
        <!-- Top Bar -->
        <div class="flex items-center justify-between py-2 text-sm border-b border-gray-800">
            <div class="flex items-center space-x-4">
                <div class="text-gray-400">
                    <i class="fas fa-gamepad text-neon-green"></i>
                    <span class="ml-1">Level Up Your Gaming!</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                @if(isset($themeConfig['settings']['integrations']['social_links']))
                    @foreach($themeConfig['settings']['integrations']['social_links'] as $platform => $link)
                        <a href="{{ $link }}" class="text-gray-400 hover:text-neon-blue transition-colors" target="_blank">
                            <i class="fab fa-{{ $platform }}"></i>
                        </a>
                    @endforeach
                @endif
                <div class="text-gray-400">
                    <i class="fas fa-phone"></i>
                    <span class="ml-1">24/7 Support</span>
                </div>
            </div>
        </div>
        
        <!-- Main Header -->
        <div class="flex items-center justify-between py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    @if(isset($themeConfig['settings']['logos']['logo']))
                        <img src="{{ $themeConfig['settings']['logos']['logo'] }}" alt="Gamey Store" class="h-10 w-auto">
                    @else
                        <div class="flex items-center">
                            <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-2 rounded-lg mr-3">
                                <i class="fas fa-gamepad text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="font-gaming text-2xl font-bold text-white">GAMEY</h1>
                                <p class="text-xs text-gray-400">Gaming Paradise</p>
                            </div>
                        </div>
                    @endif
                </a>
            </div>
            
            <!-- Search Bar -->
            <div class="flex-1 max-w-lg mx-8">
                <form class="relative">
                    <input type="text" 
                           placeholder="Search for games, accounts, items..." 
                           class="w-full bg-dark-card border border-gray-600 rounded-lg px-4 py-2 pl-12 pr-4 text-white placeholder-gray-400 focus:outline-none focus:border-neon-blue focus:ring-1 focus:ring-neon-blue transition-colors">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-neon-blue hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition-colors">
                        Search
                    </button>
                </form>
            </div>
            
            <!-- Header Actions -->
            <div class="flex items-center space-x-4">
                <!-- Wishlist -->
                <a href="#" class="relative text-gray-400 hover:text-neon-blue transition-colors">
                    <i class="fas fa-heart text-xl"></i>
                    <span class="absolute -top-2 -right-2 bg-neon-orange text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </a>
                
                <!-- Cart -->
                <button id="cart-toggle" class="relative text-gray-400 hover:text-neon-blue transition-colors">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span class="absolute -top-2 -right-2 bg-neon-green text-black text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">2</span>
                </button>
                
                <!-- User Account -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-r from-neon-purple to-neon-blue rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <span class="hidden md:block">Account</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-dark-card border border-gray-600 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="py-2">
                            <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                <i class="fas fa-shopping-bag mr-2"></i>Orders
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                <i class="fas fa-wallet mr-2"></i>Wallet
                            </a>
                            <hr class="border-gray-600 my-2">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors w-full text-left">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> 