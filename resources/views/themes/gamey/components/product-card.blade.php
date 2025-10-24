<!-- Product Cards -->
@if(isset($products) && count($products) > 0)
    @foreach($products as $product)
        <div class="bg-dark-card border border-gray-700 rounded-xl overflow-hidden hover:border-neon-blue transition-all duration-300 group">
            <!-- Product Image -->
            <div class="relative overflow-hidden">
                <img src="{{ $product->image ?? '/themes/gamey/images/placeholder-product.jpg' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                
                <!-- Product Badges -->
                <div class="absolute top-3 left-3 flex flex-col space-y-2">
                    @if($product->is_featured ?? false)
                        <span class="bg-gradient-to-r from-neon-purple to-neon-orange text-white text-xs px-2 py-1 rounded-full font-bold">
                            <i class="fas fa-star mr-1"></i>Featured
                        </span>
                    @endif
                    @if($product->discount_percentage ?? 0 > 0)
                        <span class="bg-neon-green text-black text-xs px-2 py-1 rounded-full font-bold">
                            -{{ $product->discount_percentage }}%
                        </span>
                    @endif
                    @if($product->is_new ?? false)
                        <span class="bg-neon-blue text-white text-xs px-2 py-1 rounded-full font-bold">NEW</span>
                    @endif
                </div>
                
                <!-- Quick Actions -->
                <div class="absolute top-3 right-3 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button class="bg-dark-surface bg-opacity-90 text-white p-2 rounded-full hover:bg-neon-blue transition-colors">
                        <i class="fas fa-heart"></i>
                    </button>
                    <button class="bg-dark-surface bg-opacity-90 text-white p-2 rounded-full hover:bg-neon-purple transition-colors">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <!-- Gaming Platform -->
                @if(isset($product->platform))
                    <div class="absolute bottom-3 left-3">
                        <span class="bg-dark-surface bg-opacity-90 text-neon-blue text-xs px-2 py-1 rounded-full font-bold">
                            {{ $product->platform }}
                        </span>
                    </div>
                @endif
            </div>
            
            <!-- Product Info -->
            <div class="p-4">
                <!-- Category -->
                @if(isset($product->category))
                    <span class="text-gray-400 text-xs uppercase tracking-wide">{{ $product->category->name }}</span>
                @endif
                
                <!-- Product Name -->
                <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-blue transition-colors line-clamp-2">
                    {{ $product->name }}
                </h3>
                
                <!-- Gaming Attributes -->
                <div class="flex flex-wrap gap-2 mb-3">
                    @if(isset($product->level))
                        <span class="bg-gray-800 text-neon-green text-xs px-2 py-1 rounded">
                            <i class="fas fa-level-up-alt mr-1"></i>Level {{ $product->level }}
                        </span>
                    @endif
                    @if(isset($product->region))
                        <span class="bg-gray-800 text-neon-orange text-xs px-2 py-1 rounded">
                            <i class="fas fa-globe mr-1"></i>{{ $product->region }}
                        </span>
                    @endif
                    @if(isset($product->verified) && $product->verified)
                        <span class="bg-gray-800 text-neon-blue text-xs px-2 py-1 rounded">
                            <i class="fas fa-check-circle mr-1"></i>Verified
                        </span>
                    @endif
                </div>
                
                <!-- Rating -->
                @if(isset($product->rating))
                    <div class="flex items-center mb-3">
                        <div class="flex text-neon-orange">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <span class="text-gray-400 text-sm ml-2">({{ $product->reviews_count ?? 0 }})</span>
                    </div>
                @endif
                
                <!-- Price -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        @if(isset($product->old_price) && $product->old_price > $product->price)
                            <span class="text-gray-400 line-through text-sm">${{ number_format($product->old_price, 2) }}</span>
                        @endif
                        <span class="text-neon-green font-bold text-xl">${{ number_format($product->price, 2) }}</span>
                    </div>
                    @if(isset($product->stock) && $product->stock <= 5)
                        <span class="text-neon-orange text-xs">{{ $product->stock }} left</span>
                    @endif
                </div>
                
                <!-- Add to Cart Button -->
                <button class="w-full bg-gradient-to-r from-neon-blue to-neon-purple text-white py-2 px-4 rounded-lg font-bold hover:scale-105 transition-transform duration-200 flex items-center justify-center space-x-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Add to Cart</span>
                </button>
            </div>
        </div>
    @endforeach
@else
    <!-- Sample Product Cards for Demo -->
    <div class="bg-dark-card border border-gray-700 rounded-xl overflow-hidden hover:border-neon-blue transition-all duration-300 group">
        <div class="relative overflow-hidden">
            <div class="w-full h-48 bg-gradient-to-br from-neon-blue/20 to-neon-purple/20 flex items-center justify-center">
                <i class="fas fa-gamepad text-neon-blue text-4xl"></i>
            </div>
            <div class="absolute top-3 left-3">
                <span class="bg-gradient-to-r from-neon-purple to-neon-orange text-white text-xs px-2 py-1 rounded-full font-bold">
                    <i class="fas fa-star mr-1"></i>Featured
                </span>
            </div>
            <div class="absolute top-3 right-3 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="bg-dark-surface bg-opacity-90 text-white p-2 rounded-full hover:bg-neon-blue transition-colors">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>
        
        <div class="p-4">
            <span class="text-gray-400 text-xs uppercase tracking-wide">Gaming Account</span>
            <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-blue transition-colors">PUBG Mobile Premium Account</h3>
            
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-gray-800 text-neon-green text-xs px-2 py-1 rounded">
                    <i class="fas fa-level-up-alt mr-1"></i>Level 85
                </span>
                <span class="bg-gray-800 text-neon-orange text-xs px-2 py-1 rounded">
                    <i class="fas fa-globe mr-1"></i>Global
                </span>
                <span class="bg-gray-800 text-neon-blue text-xs px-2 py-1 rounded">
                    <i class="fas fa-check-circle mr-1"></i>Verified
                </span>
            </div>
            
            <div class="flex items-center mb-3">
                <div class="flex text-neon-orange">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span class="text-gray-400 text-sm ml-2">(127)</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-400 line-through text-sm">$149.99</span>
                    <span class="text-neon-green font-bold text-xl">$99.99</span>
                </div>
                <span class="text-neon-orange text-xs">3 left</span>
            </div>
            
            <button class="w-full bg-gradient-to-r from-neon-blue to-neon-purple text-white py-2 px-4 rounded-lg font-bold hover:scale-105 transition-transform duration-200 flex items-center justify-center space-x-2">
                <i class="fas fa-shopping-cart"></i>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
    
    <div class="bg-dark-card border border-gray-700 rounded-xl overflow-hidden hover:border-neon-green transition-all duration-300 group">
        <div class="relative overflow-hidden">
            <div class="w-full h-48 bg-gradient-to-br from-neon-green/20 to-neon-blue/20 flex items-center justify-center">
                <i class="fas fa-coins text-neon-green text-4xl"></i>
            </div>
            <div class="absolute top-3 left-3">
                <span class="bg-neon-green text-black text-xs px-2 py-1 rounded-full font-bold">-25%</span>
            </div>
        </div>
        
        <div class="p-4">
            <span class="text-gray-400 text-xs uppercase tracking-wide">Game Currency</span>
            <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-green transition-colors">8100 UC + Bonus</h3>
            
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-gray-800 text-neon-blue text-xs px-2 py-1 rounded">
                    <i class="fas fa-bolt mr-1"></i>Instant
                </span>
                <span class="bg-gray-800 text-neon-purple text-xs px-2 py-1 rounded">
                    <i class="fas fa-gift mr-1"></i>Bonus
                </span>
            </div>
            
            <div class="flex items-center mb-3">
                <div class="flex text-neon-orange">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span class="text-gray-400 text-sm ml-2">(89)</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-400 line-through text-sm">$79.99</span>
                    <span class="text-neon-green font-bold text-xl">$59.99</span>
                </div>
            </div>
            
            <button class="w-full bg-gradient-to-r from-neon-green to-neon-blue text-white py-2 px-4 rounded-lg font-bold hover:scale-105 transition-transform duration-200 flex items-center justify-center space-x-2">
                <i class="fas fa-shopping-cart"></i>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
    
    <div class="bg-dark-card border border-gray-700 rounded-xl overflow-hidden hover:border-neon-purple transition-all duration-300 group">
        <div class="relative overflow-hidden">
            <div class="w-full h-48 bg-gradient-to-br from-neon-purple/20 to-neon-orange/20 flex items-center justify-center">
                <i class="fas fa-trophy text-neon-purple text-4xl"></i>
            </div>
            <div class="absolute top-3 left-3">
                <span class="bg-neon-blue text-white text-xs px-2 py-1 rounded-full font-bold">NEW</span>
            </div>
        </div>
        
        <div class="p-4">
            <span class="text-gray-400 text-xs uppercase tracking-wide">Boosting Service</span>
            <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-purple transition-colors">Rank Boost to Conqueror</h3>
            
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-gray-800 text-neon-orange text-xs px-2 py-1 rounded">
                    <i class="fas fa-clock mr-1"></i>2-3 Days
                </span>
                <span class="bg-gray-800 text-neon-green text-xs px-2 py-1 rounded">
                    <i class="fas fa-shield-alt mr-1"></i>Safe
                </span>
            </div>
            
            <div class="flex items-center mb-3">
                <div class="flex text-neon-orange">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span class="text-gray-400 text-sm ml-2">(234)</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <span class="text-neon-green font-bold text-xl">$199.99</span>
            </div>
            
            <button class="w-full bg-gradient-to-r from-neon-purple to-neon-orange text-white py-2 px-4 rounded-lg font-bold hover:scale-105 transition-transform duration-200 flex items-center justify-center space-x-2">
                <i class="fas fa-shopping-cart"></i>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
    
    <div class="bg-dark-card border border-gray-700 rounded-xl overflow-hidden hover:border-neon-orange transition-all duration-300 group">
        <div class="relative overflow-hidden">
            <div class="w-full h-48 bg-gradient-to-br from-neon-orange/20 to-neon-green/20 flex items-center justify-center">
                <i class="fas fa-gem text-neon-orange text-4xl"></i>
            </div>
        </div>
        
        <div class="p-4">
            <span class="text-gray-400 text-xs uppercase tracking-wide">Premium Item</span>
            <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-orange transition-colors">Mythic Outfit Set</h3>
            
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-gray-800 text-neon-purple text-xs px-2 py-1 rounded">
                    <i class="fas fa-star mr-1"></i>Mythic
                </span>
                <span class="bg-gray-800 text-neon-blue text-xs px-2 py-1 rounded">
                    <i class="fas fa-sparkles mr-1"></i>Limited
                </span>
            </div>
            
            <div class="flex items-center mb-3">
                <div class="flex text-neon-orange">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <span class="text-gray-400 text-sm ml-2">(56)</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <span class="text-neon-green font-bold text-xl">$299.99</span>
                <span class="text-neon-orange text-xs">Rare</span>
            </div>
            
            <button class="w-full bg-gradient-to-r from-neon-orange to-neon-green text-white py-2 px-4 rounded-lg font-bold hover:scale-105 transition-transform duration-200 flex items-center justify-center space-x-2">
                <i class="fas fa-shopping-cart"></i>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
@endif 