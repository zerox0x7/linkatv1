


<!-- Option 3: Luxury Card with 3D Effect -->

<div class="relative w-full max-w-2xl h-44 mx-auto perspective-1000">
  <div class="relative w-full h-full transform-gpu transition-transform duration-500 hover:rotateY-12 preserve-3d">
    <!-- Card background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl shadow-2xl overflow-hidden">
      <!-- Metallic texture overlay -->
      <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-black/20"></div>
      
      <!-- Animated light streak -->
      <div class="absolute -top-20 -left-20 w-40 h-40 bg-gradient-radial from-white/20 to-transparent rounded-full blur-3xl animate-pulse"></div>
      
      <!-- Content area -->
      <div class="relative flex items-center justify-center h-full p-8">
        <div class="text-center">
          <!-- Main text with gradient -->
          <h1 class="text-6xl md:text-6xl font-black bg-gradient-to-r from-amber-200 via-yellow-300 to-amber-200 bg-clip-text text-transparent tracking-wider mb-6 transform hover:scale-110 transition-transform duration-300">
            {{ $coupon->code }}
          </h1>
          
          <!-- Decorative elements -->
          <div class="flex justify-center space-x-2 mb-4">
            <div class="w-2 h-2 bg-amber-400 rounded-full animate-ping"></div>
            <div class="w-2 h-2 bg-amber-400 rounded-full animate-ping animation-delay-200"></div>
            <div class="w-2 h-2 bg-amber-400 rounded-full animate-ping animation-delay-400"></div>
          </div>
          
          <!-- Premium badge -->
          <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-600/20 to-yellow-600/20 rounded-full border border-amber-400/30">
            <span class="text-amber-200 text-sm font-medium tracking-wide">PREMIUM EDITION</span>
          </div>
        </div>
      </div>
      
      <!-- Edge highlights -->
      <div class="absolute inset-0 rounded-3xl border border-gradient-to-r from-transparent via-white/20 to-transparent pointer-events-none"></div>
    </div>
  </div>
</div>
