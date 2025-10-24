<!-- Navigation -->
<nav class="bg-dark-card border-b border-gray-700">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-3">
            <!-- Categories Menu -->
            <div class="flex items-center space-x-8">
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-white hover:text-neon-blue transition-colors font-medium">
                        <i class="fas fa-th-large"></i>
                        <span>Categories</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <!-- Categories Dropdown -->
                    <div class="absolute top-full left-0 mt-2 w-80 bg-dark-surface border border-gray-600 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-40">
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4">
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <a href="{{ url('/category/' . $category->id) }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors group">
                                            <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-2 rounded-lg">
                                                <i class="fas fa-gamepad text-white"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-medium group-hover:text-neon-blue">{{ $category->name }}</h4>
                                                <p class="text-gray-400 text-sm">{{ $category->products_count ?? 0 }} items</p>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors group">
                                        <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-2 rounded-lg">
                                            <i class="fas fa-gamepad text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-medium group-hover:text-neon-blue">Gaming Accounts</h4>
                                            <p class="text-gray-400 text-sm">Premium accounts</p>
                                        </div>
                                    </a>
                                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors group">
                                        <div class="bg-gradient-to-r from-neon-green to-neon-blue p-2 rounded-lg">
                                            <i class="fas fa-coins text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-medium group-hover:text-neon-green">Game Currency</h4>
                                            <p class="text-gray-400 text-sm">UC, Diamonds, Gold</p>
                                        </div>
                                    </a>
                                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors group">
                                        <div class="bg-gradient-to-r from-neon-purple to-neon-orange p-2 rounded-lg">
                                            <i class="fas fa-trophy text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-medium group-hover:text-neon-purple">Boosting Services</h4>
                                            <p class="text-gray-400 text-sm">Rank up fast</p>
                                        </div>
                                    </a>
                                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors group">
                                        <div class="bg-gradient-to-r from-neon-orange to-neon-green p-2 rounded-lg">
                                            <i class="fas fa-gem text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-medium group-hover:text-neon-orange">Premium Items</h4>
                                            <p class="text-gray-400 text-sm">Rare collectibles</p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-white hover:text-neon-blue transition-colors font-medium flex items-center space-x-1">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ url('/products') }}" class="text-gray-300 hover:text-neon-blue transition-colors font-medium">Products</a>
                    <a href="{{ url('/deals') }}" class="text-gray-300 hover:text-neon-green transition-colors font-medium flex items-center space-x-1">
                        <i class="fas fa-fire text-neon-orange"></i>
                        <span>Hot Deals</span>
                    </a>
                    <a href="{{ url('/new-arrivals') }}" class="text-gray-300 hover:text-neon-purple transition-colors font-medium">New Arrivals</a>
                    <a href="{{ url('/support') }}" class="text-gray-300 hover:text-white transition-colors font-medium">Support</a>
                </div>
            </div>
            
            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <!-- Language Selector -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 text-gray-300 hover:text-white transition-colors">
                        <i class="fas fa-globe"></i>
                        <span class="hidden md:block">EN</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-32 bg-dark-surface border border-gray-600 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="py-2">
                            <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">English</a>
                            <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">العربية</a>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button class="md:hidden text-white hover:text-neon-blue transition-colors" id="mobile-menu-toggle">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden border-t border-gray-700 py-4 hidden" id="mobile-menu">
            <div class="space-y-4">
                <a href="{{ url('/') }}" class="flex items-center space-x-2 text-white hover:text-neon-blue transition-colors">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ url('/products') }}" class="flex items-center space-x-2 text-gray-300 hover:text-neon-blue transition-colors">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Products</span>
                </a>
                <a href="{{ url('/deals') }}" class="flex items-center space-x-2 text-gray-300 hover:text-neon-green transition-colors">
                    <i class="fas fa-fire text-neon-orange"></i>
                    <span>Hot Deals</span>
                </a>
                <a href="{{ url('/new-arrivals') }}" class="flex items-center space-x-2 text-gray-300 hover:text-neon-purple transition-colors">
                    <i class="fas fa-star"></i>
                    <span>New Arrivals</span>
                </a>
                <a href="{{ url('/support') }}" class="flex items-center space-x-2 text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-headset"></i>
                    <span>Support</span>
                </a>
            </div>
        </div>
    </div>
</nav> 