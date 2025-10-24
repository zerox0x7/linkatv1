

<!-- Option 4: Minimalist with Floating Elements -->


<div class="relative w-full max-w-2xl h-44 mx-auto bg-white shadow-2xl overflow-hidden">
  <!-- Floating geometric shapes -->
  <div class="absolute top-8 left-12 w-16 h-16 bg-gradient-to-br from-rose-400 to-pink-500 rounded-2xl rotate-12 opacity-20 animate-float"></div>
  <div class="absolute top-20 right-16 w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full opacity-30 animate-float-delayed"></div>
  <div class="absolute bottom-16 left-20 w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-3xl -rotate-12 opacity-25 animate-float-slow"></div>
  
  <!-- Main content -->
  <div class="relative flex items-center justify-center h-full">
    <div class="text-center">
      <!-- Text with subtle shadow -->
      <h1 class="text-7xl md:text-6xl font-black text-gray-800 tracking-tight mb-4 leading-none">
        {{ $coupon->code }}
      </h1>
      
      <!-- Elegant underline -->
      <div class="w-24 h-1 bg-gradient-to-r from-gray-300 via-gray-600 to-gray-300 mx-auto rounded-full"></div>
      
      <!-- Minimal details -->
      <p class="text-gray-500 text-sm font-medium tracking-widest mt-6 uppercase">Modern Typography</p>
    </div>
  </div>
  
  <!-- Subtle gradient overlay -->
  <div class="absolute inset-0 bg-gradient-to-t from-gray-50/50 to-transparent pointer-events-none"></div>
</div>

<!-- Custom animations -->
<style>
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(12deg); }
  50% { transform: translateY(-20px) rotate(12deg); }
}
@keyframes float-delayed {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-15px); }
}
@keyframes float-slow {
  0%, 100% { transform: translateY(0px) rotate(-12deg); }
  50% { transform: translateY(-10px) rotate(-12deg); }
}
.animate-float { animation: float 3s ease-in-out infinite; }
.animate-float-delayed { animation: float-delayed 4s ease-in-out infinite 1s; }
.animate-float-slow { animation: float-slow 5s ease-in-out infinite 2s; }
</style>


