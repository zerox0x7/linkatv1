<div class="p-8">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/50 rounded-xl text-green-400 animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="ri-checkbox-circle-line text-2xl"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500/20 to-cyan-500/20 flex items-center justify-center">
            <i class="ri-code-line text-blue-400"></i>
        </div>
        أكواد CSS/JS مخصصة
    </h3>

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Custom CSS -->
        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
            <label class="block text-sm font-medium text-gray-300 mb-3">CSS مخصص</label>
            <textarea wire:model="customCss" rows="10"
                      class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors font-mono text-sm"
                      placeholder="/* أدخل كود CSS المخصص هنا */"></textarea>
        </div>

        <!-- Custom JS -->
        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
            <label class="block text-sm font-medium text-gray-300 mb-3">JavaScript مخصص</label>
            <textarea wire:model="customJs" rows="10"
                      class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors font-mono text-sm"
                      placeholder="// أدخل كود JavaScript المخصص هنا"></textarea>
        </div>

        <!-- Save Button -->
        <div class="flex items-center justify-end">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-3">
                <i class="ri-save-line text-xl"></i>
                <span wire:loading.remove wire:target="save">حفظ التغييرات</span>
                <span wire:loading wire:target="save">جاري الحفظ...</span>
            </button>
        </div>
    </form>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>

