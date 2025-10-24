
<!-- Option 6: Retro Synthwave -->

<div class="relative w-full max-w-4xl h-44 mx-auto bg-gradient-to-b from-purple-900 via-pink-900 to-black  overflow-hidden shadow-2xl">
  <!-- Grid lines -->
  <div class="absolute inset-0" style="background-image: linear-gradient(rgba(236, 72, 153, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(236, 72, 153, 0.3) 1px, transparent 1px); background-size: 50px 50px;"></div>
  
  <!-- Horizon line -->
  <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-pink-500 to-transparent"></div>
  
  <!-- Sun -->
  <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2 w-32 h-32 bg-gradient-radial from-yellow-400 via-orange-500 to-pink-600 rounded-full opacity-80"></div>
  
  <!-- Content -->
  <div class="relative flex items-center justify-center h-full">
    <div class="text-center">
      <!-- Retro text with chrome effect -->
      <h1 class="text-8xl md:text-6xl font-black text-transparent bg-gradient-to-b from-pink-300 via-purple-400 to-cyan-400 bg-clip-text tracking-wider mb-4 transform perspective-1000 rotateX-12"
          style="text-shadow: 0 1px 0 #c084fc, 0 2px 0 #a855f7, 0 3px 0 #9333ea, 0 4px 0 #7c3aed, 0 5px 0 #6d28d9, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25);">
        {{ $coupon->code }}
      </h1>
      
      <!-- Retro subtitle -->
      <div class="text-cyan-400 font-mono text-xl tracking-widest opacity-80 animate-pulse">
        ::::: RETRO WAVE :::::
      </div>
      
      <!-- Scan lines -->
      <div class="absolute inset-0 pointer-events-none" style="background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px);"></div>
    </div>
  </div>
</div>




