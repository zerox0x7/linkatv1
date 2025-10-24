
<!-- Option 1: Glassmorphism with Animated Gradient  -->
<div class="relative w-full max-w-2xl h-44 mx-auto overflow-hidden  shadow-2xl">
  <!-- Animated gradient background -->
  <div class="absolute inset-0 bg-gradient-to-br from-violet-600 via-blue-600 to-cyan-400 animate-pulse"></div>
  
  <!-- Glass overlay -->
  <div class="absolute inset-0 backdrop-blur-sm bg-white/10 border border-white/20">
    <!-- Decorative elements -->
    <div class="absolute top-6 right-6 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
    <div class="absolute bottom-8 left-8 w-32 h-32 bg-purple-300/10 rounded-full blur-2xl"></div>
    
    <!-- Text container -->
    <div class="flex items-center justify-center h-full">
      <div class="text-center">
        <h1 class="text-6xl md:text-6xl font-black text-white tracking-wider mb-4 drop-shadow-2xl transform hover:scale-105 transition-transform duration-300">
           {{ $coupon->code }}
        </h1>
        <div class="h-1 w-32 bg-gradient-to-r from-transparent via-white to-transparent mx-auto opacity-60"></div>
      </div>
    </div>
  </div>
</div>


