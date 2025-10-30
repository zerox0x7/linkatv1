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

    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                    <i class="ri-list-check text-purple-400"></i>
                </div>
                التحكم بتفعيل الأقسام
            </h3>
            <p class="text-gray-400 text-sm mt-1">يمكنك التحكم بتفعيل أو إلغاء تفعيل الأقسام العشرة في الموقع</p>
        </div>
        <div class="text-sm text-gray-400 bg-[#0f1623] px-4 py-2 rounded-lg border border-[#2a3548]">
            @php
                $activeSections = collect($sectionsData)->filter(function($section) {
                    return $section['is_active'] ?? false;
                })->count();
            @endphp
            <span class="font-bold text-primary">{{ $activeSections }}</span> / 10 قسم نشط
        </div>
    </div>

    <div class="bg-gradient-to-br from-[#0f1623] to-[#1a2234] rounded-xl border border-[#2a3548] overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($sectionsData as $key => $section)
                    @php
                        $sectionNumber = (int) str_replace('section', '', $key);
                        $isActive = $section['is_active'] ?? false;
                        $sectionName = $section['name'] ?? 'القسم ' . $sectionNumber;
                        
                        $arabicNames = [
                            'firstSection' => 'القسم الأول',
                            'secondSection' => 'القسم الثاني',
                            'thirdSection' => 'القسم الثالث',
                            'fourthSection' => 'القسم الرابع',
                            'fifthSection' => 'القسم الخامس',
                            'sixthSection' => 'القسم السادس',
                            'seventhSection' => 'القسم السابع',
                            'eighthSection' => 'القسم الثامن',
                            'ninthSection' => 'القسم التاسع',
                            'tenthSection' => 'القسم العاشر',
                        ];
                        
                        $displayName = $arabicNames[$sectionName] ?? $sectionName;
                    @endphp
                    
                    <div class="bg-[#121827] rounded-lg p-5 border border-[#2a3548] hover:border-primary/30 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center font-bold text-lg
                                            {{ $isActive ? 'bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400' : 'bg-gray-500/20 text-gray-500' }}">
                                    {{ $sectionNumber }}
                                </div>
                                <div>
                                    <h4 class="font-semibold {{ $isActive ? 'text-white' : 'text-gray-400' }}">
                                        {{ $displayName }}
                                    </h4>
                                    <p class="text-xs {{ $isActive ? 'text-green-400' : 'text-gray-500' }} mt-1">
                                        <i class="ri-{{ $isActive ? 'checkbox-circle' : 'close-circle' }}-line"></i>
                                        {{ $isActive ? 'نشط' : 'غير نشط' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $sectionName }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Toggle Switch -->
                            <button type="button" 
                                    wire:click="toggleSection('{{ $key }}')"
                                    wire:loading.attr="disabled"
                                    class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-[#121827]
                                           {{ $isActive ? 'bg-gradient-to-r from-primary to-secondary' : 'bg-gray-600' }}">
                                <span class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform
                                             {{ $isActive ? '-translate-x-7' : 'translate-x-1' }}">
                                </span>
                                
                                <!-- Loading indicator -->
                                <span wire:loading wire:target="toggleSection('{{ $key }}')" 
                                      class="absolute inset-0 flex items-center justify-center">
                                    <i class="ri-loader-4-line animate-spin text-white"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Helper Info -->
            <div class="mt-6 p-4 bg-blue-500/10 border border-blue-500/30 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="ri-information-line text-blue-400 text-xl mt-0.5"></i>
                    <div class="text-sm text-blue-300">
                        <p class="font-semibold mb-1">ملاحظة هامة:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs text-blue-300/80">
                            <li>يتم حفظ التغييرات تلقائياً عند الضغط على زر التفعيل/الإلغاء</li>
                            <li>الأقسام غير النشطة لن تظهر في الصفحة الرئيسية للموقع</li>
                            <li>يمكنك إعادة تفعيل الأقسام في أي وقت</li>
                        </ul>
                    </div>
                </div>
            </div>
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

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</div>

