<div class="p-8" x-data="{ newKey: '', newValue: '' }">
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
        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
            <i class="ri-settings-3-line text-purple-400"></i>
        </div>
        بيانات مخصصة (Custom Data)
    </h3>

    <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
        <p class="text-gray-400 mb-4">يمكنك إضافة بيانات مخصصة إضافية يحتاجها الثيم</p>

        <!-- Current Custom Data -->
        @if(count($customData) > 0)
            <div class="space-y-3 mb-4">
                @foreach($customData as $key => $value)
                    <div class="flex items-center gap-3 bg-[#121827] p-4 rounded-lg border border-[#2a3548]">
                        <div class="flex-1 grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">المفتاح</label>
                                <div class="text-white font-mono">{{ $key }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">القيمة</label>
                                <div class="text-white">{{ $value }}</div>
                            </div>
                        </div>
                        <button type="button" wire:click="removeCustomDataField('{{ $key }}')" 
                                class="p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="ri-database-line text-4xl mb-2"></i>
                <p>لا توجد بيانات مخصصة بعد</p>
            </div>
        @endif

        <!-- Add New Field -->
        <div class="border-t border-[#2a3548] pt-4 mt-4">
            <p class="text-sm text-gray-400 mb-3">إضافة حقل جديد</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" x-model="newKey" 
                       class="px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                       placeholder="المفتاح (مثال: secondary_color)">
                <input type="text" x-model="newValue" 
                       class="px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                       placeholder="القيمة (مثال: #ff5733)">
            </div>
            <button type="button" 
                    @click="if(newKey && newValue) { $wire.addCustomDataField(newKey, newValue); newKey = ''; newValue = ''; }"
                    class="mt-3 px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:opacity-90 transition-opacity">
                <i class="ri-add-line ml-2"></i>
                إضافة حقل
            </button>
        </div>
    </div>

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

