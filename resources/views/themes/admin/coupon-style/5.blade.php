<!--Option 5: Neon Cyberpunk Style -->

<div class="relative w-full max-w-3xl h-44 mx-auto overflow-hidden  bg-gray-900 border border-cyan-500/30 shadow-2xl shadow-cyan-500/20">
  <!-- Grid pattern overlay -->
  <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #06b6d4 1px, transparent 1px); background-size: 30px 30px;"></div>
  
  <!-- Neon glow effects -->
  <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-cyan-400 to-transparent opacity-60"></div>
  <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-purple-400 to-transparent opacity-60"></div>
  
  <!-- Content -->
  <div class="relative flex items-center justify-center h-full">
    <div class="text-center">
      <!-- Main text with multiple shadows for neon effect -->
      <h1 class="text-7xl md:text-6xl font-bold text-cyan-300 tracking-widest mb-6 select-none"
          style="text-shadow: 0 0 10px #06b6d4, 0 0 20px #06b6d4, 0 0 40px #06b6d4, 0 0 80px #06b6d4;">
        {{ $coupon->code }}
      </h1>
      
      <!-- Subtitle -->
      <p class="text-gray-400 text-lg tracking-wider font-mono opacity-80">// DIGITAL MATRIX //</p>
      
      <!-- Animated underline -->
      <div class="mt-4 h-px bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-pulse"></div>
    </div>
  </div>
  
  <!-- Corner decorations -->
  <div class="absolute top-4 left-4 w-8 h-8 border-l-2 border-t-2 border-cyan-400/60"></div>
  <div class="absolute top-4 right-4 w-8 h-8 border-r-2 border-t-2 border-cyan-400/60"></div>
  <div class="absolute bottom-4 left-4 w-8 h-8 border-l-2 border-b-2 border-cyan-400/60"></div>
  <div class="absolute bottom-4 right-4 w-8 h-8 border-r-2 border-b-2 border-cyan-400/60"></div>
</div>


