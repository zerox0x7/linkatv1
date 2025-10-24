<!-- Option 5: Holographic Foil Effect -->
<div class="relative w-full max-w-3xl h-44 mx-auto bg-black  overflow-hidden shadow-2xl">
  <!-- Holographic background -->
  <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-blue-500 via-green-400 via-yellow-400 via-red-500 to-purple-600 opacity-30 animate-pulse"></div>
  
  <!-- Prismatic overlay -->
  <div class="absolute inset-0" style="background: conic-gradient(from 0deg, #ff0080, #00ff80, #8000ff, #ff8000, #0080ff, #ff0080); opacity: 0.1;"></div>
  
  <!-- Content -->
  <div class="relative flex items-center justify-center h-full">
    <div class="text-center">
      <!-- Holographic text -->
      <h1 class="text-8xl md:text-6xl font-black tracking-wider select-none relative">
        <span class="absolute inset-0 bg-gradient-to-r from-pink-400 via-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent animate-pulse">
          {{ $coupon->code }}
        </span>
        <span class="bg-gradient-to-r from-white via-blue-200 to-white bg-clip-text text-transparent"
              style="text-shadow: 0 0 30px rgba(255,255,255,0.5);">
          {{ $coupon->code }}
        </span>
      </h1>
      
      <!-- Rainbow reflection line -->
      <div class="mt-6 h-2 w-48 mx-auto rounded-full bg-gradient-to-r from-purple-500 via-blue-500 via-green-400 via-yellow-400 to-red-500 opacity-60 blur-sm"></div>
      
      <!-- Floating particles -->
      <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-white rounded-full animate-ping"></div>
      <div class="absolute top-3/4 right-1/3 w-1 h-1 bg-cyan-400 rounded-full animate-ping animation-delay-300"></div>
      <div class="absolute bottom-1/4 left-1/2 w-1 h-1 bg-purple-400 rounded-full animate-ping animation-delay-700"></div>
    </div>
  </div>
</div>
