<!-- Opiton 7: Liquid Metal -->

<div class="relative w-full max-w-3xl h-44 mx-auto overflow-hidden  shadow-2xl">
  <!-- Liquid metal background -->
  <div class="absolute inset-0 bg-gradient-to-br from-gray-700 via-gray-500 to-gray-800"></div>
  
  <!-- Metallic reflections -->
  <div class="absolute inset-0 bg-gradient-to-tr from-white/20 via-transparent to-white/10"></div>
  <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-transparent via-white/5 to-transparent transform rotate-45 scale-150"></div>
  
  <!-- Liquid ripples -->
  <div class="absolute top-8 left-12 w-24 h-24 bg-white/10 rounded-full blur-xl animate-ping"></div>
  <div class="absolute bottom-12 right-16 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-pulse"></div>
  
  <!-- Content -->
  <div class="relative flex items-center justify-center h-full">
    <div class="text-center">
      <!-- Liquid metal text -->
      <h1 class="text-7xl md:text-6xl font-black tracking-wider select-none relative">
        <!-- Shadow layers for depth -->
        <span class="absolute inset-0 text-black/30 transform translate-x-2 translate-y-2">{{ $coupon->code }}</span>
        <span class="absolute inset-0 text-black/20 transform translate-x-4 translate-y-4">{{ $coupon->code }}</span>
        
        <!-- Main text with chrome gradient -->
        <span class="relative bg-gradient-to-b from-gray-100 via-gray-300 to-gray-600 bg-clip-text text-transparent"
              style="text-shadow: 0 1px 0 rgba(255,255,255,0.8), 0 2px 0 rgba(255,255,255,0.6), 0 3px 0 rgba(255,255,255,0.4);">
          {{ $coupon->code }}
        </span>
      </h1>
      
      <!-- Metallic accent line -->
      <div class="mt-6 h-1 w-40 mx-auto bg-gradient-to-r from-transparent via-gray-300 to-transparent rounded-full"></div>
    </div>
  </div>
  
  <!-- Edge highlight -->
  <div class="absolute inset-0 rounded-3xl border border-white/20 pointer-events-none"></div>
</div>

