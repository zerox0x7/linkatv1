<div class="space-y-4">
    <!-- Coupon Card -->
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
        <div class="coupon-card">
            <!-- Holographic Background -->
            <div class="coupon-background relative h-44 w-full">
                <div class="relative w-full h-full bg-black rounded-t-lg overflow-hidden">
                    <!-- Holographic background -->
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-blue-500 via-green-400 via-yellow-400 via-red-500 to-purple-600 opacity-30 animate-pulse"></div>

                    <!-- Prismatic overlay -->
                    <div class="absolute inset-0" style="background: conic-gradient(from 0deg, #ff0080, #00ff80, #8000ff, #ff8000, #0080ff, #ff0080); opacity: 0.1;"></div>

                    <!-- Content -->
                    <div class="relative flex items-center justify-center h-full">
                        <div class="text-center">
                            <!-- Dynamic Holographic text -->
                            <h1 class="text-4xl md:text-5xl font-black tracking-wider select-none relative">
                                <span class="absolute inset-0 bg-gradient-to-r from-pink-400 via-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent animate-pulse">
                                    {{ $couponCode }}
                                </span>
                                <span class="bg-gradient-to-r from-white via-blue-200 to-white bg-clip-text text-transparent" style="text-shadow: 0 0 30px rgba(255,255,255,0.5);">
                                    {{ $couponCode }}
                                </span>
                            </h1>

                            <!-- Rainbow reflection line -->
                            <div class="mt-2 h-1 w-24 mx-auto rounded-full bg-gradient-to-r from-purple-500 via-blue-500 via-green-400 via-yellow-400 to-red-500 opacity-60 blur-sm"></div>

                            <!-- Floating particles -->
                            <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-white rounded-full animate-ping"></div>
                            <div class="absolute top-3/4 right-1/3 w-1 h-1 bg-cyan-400 rounded-full animate-ping animation-delay-300"></div>
                            <div class="absolute bottom-1/4 left-1/2 w-1 h-1 bg-purple-400 rounded-full animate-ping animation-delay-700"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coupon Content -->
            <div class="coupon-content p-4 relative">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="status-badge status-active bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                            {{ $status }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" class="mr-2">
                    </div>
                </div>
                <div class="absolute bottom-4 left-4">
                    <h3 class="text-xl font-bold text-white">{{ $couponCode }}</h3>
                    <p class="text-gray-300 mt-1">Off {{ $discount }}</p>
                </div>
            </div>
        </div>

        <!-- Card Details -->
        <div class="p-4 bg-gray-800">
            <!-- Edit Coupon Input -->
         

            <!-- Date Details -->
            <div class="flex justify-between text-sm mb-3">
                <div>
                    <p class="text-gray-400">Valid Until</p>
                    <p class="text-white">{{ $validUntil }}</p>
                </div>
                <div class="text-left">
                    <p class="text-gray-400">Valid From</p>
                    <p class="text-white">{{ $validFrom }}</p>
                </div>
            </div>

            <!-- Usage Details -->
            <div class="flex justify-between text-sm mb-4">
                <div>
                    <p class="text-gray-400">Used</p>
                    <p class="text-white">{{ $used }}</p>
                </div>
                <div class="text-left">
                    <p class="text-gray-400">Usage Limit</p>
                    <p class="text-white">{{ $usageLimit }}</p>
                </div>
            </div>

                  <div class="flex items-center justify-around my-2 space-x-2 gap-3 ">
                    <button
                    type="submit"
                    class="bg-[#00d3b7] hover:bg-[#00b59c]   text-white text-sm px-2 py-1.5 rounded-button whitespace-nowrap"
                  >
                    Update
                  </button>
                  <input 
                    type="text" 
                    id="coupon-input"
                    wire:model.live="couponCode"
                    class="w-64 px-2 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    placeholder="Enter coupon code"
                    maxlength="20"
                >
                  
                </div>

            <!-- Actions -->
            <div class="flex justify-between items-center">
                <span class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">
                    {{ $type }}
                </span>
                <div class="flex space-x-2">
                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors">
                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                            <i class="ri-edit-line"></i>
                        </div>
                    </button>
                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors">
                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                            <i class="ri-delete-bin-line"></i>
                        </div>
                    </button>
                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors">
                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                            <i class="ri-file-copy-line"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>






