<div>
    <!-- Content Area -->
    <div class="flex-1 p-6 overflow-y-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-white mb-2">تخصيص الفوتر</h1>
            <p class="text-gray-400">قم بتخصيص فوتر الموقع وإضافة الروابط والمعلومات المهمة</p>
        </div>

        <!-- Theme Links Section -->
        <div class="mb-6">
            @livewire('theme-links')
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Footer Customization Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Footer Settings -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                            <i class="ri-settings-4-line text-blue-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">إعدادات الفوتر</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="footerEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="mr-3 text-sm font-medium text-gray-300">تفعيل الفوتر</span>
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">نص حقوق الطبع والنشر</label>
                        <input type="text" wire:model="footerCopyright" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors"
                            placeholder="© 2024 جميع الحقوق محفوظة">
                        @error('footerCopyright') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">لون خلفية الفوتر</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model="footerBackgroundColor" class="w-12 h-12 rounded-lg border border-[#2a3548] bg-[#0f1623] cursor-pointer">
                            <input type="text" wire:model="footerBackgroundColor" class="bg-[#0f1623] border border-[#2a3548] text-white flex-1 p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="#1e293b">
                        </div>
                        @error('footerBackgroundColor') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">لون النص</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model="footerTextColor" class="w-12 h-12 rounded-lg border border-[#2a3548] bg-[#0f1623] cursor-pointer">
                            <input type="text" wire:model="footerTextColor" class="bg-[#0f1623] border border-[#2a3548] text-white flex-1 p-3 rounded-lg focus:border-primary focus:outline-none"
                                placeholder="#d1d5db">
                        </div>
                        @error('footerTextColor') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">وصف الفوتر</label>
                        <textarea wire:model="footerDescription" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors" rows="3"
                            placeholder="وصف موجز عن الموقع أو المتجر"></textarea>
                        @error('footerDescription') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center">
                            <i class="ri-links-line text-orange-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">روابط الفوتر</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex  items-center cursor-pointer">
                            <input type="checkbox" wire:model="footerLinksEnabled" class=" ml-2 toggle-switch sr-only">
                        </label>
                        <button wire:click="addFooterLink" type="button"
                            class="bg-gradient-to-r from-primary to-secondary text-black px-4 py-2 rounded-lg text-sm font-medium hover:from-primary/90 hover:to-secondary/90 transition-all duration-300 shadow-lg">
                            <i class="ri-add-line ml-1"></i>
                            إضافة رابط
                        </button>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($footerQuickLinks as $index => $link)
                    <div wire:key="footer-link-{{ $index }}" class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548] flex justify-between items-center shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center gap-3">
                            <button wire:click="removeFooterLink({{ $index }})" type="button" class="text-gray-400 hover:text-red-500 transition-colors duration-300">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <button class="text-gray-400 hover:text-primary transition-colors duration-300 cursor-grab">
                                <i class="ri-drag-move-line"></i>
                            </button>
                        </div>
                        <div class="flex-1 mr-4">
                            <input type="text" wire:model="footerQuickLinks.{{ $index }}.name" class="bg-[#111827] border border-[#2a3548] text-white w-full p-2 rounded text-sm mb-2 focus:border-primary focus:outline-none"
                                placeholder="نص الرابط">
                            <input type="text" wire:model="footerQuickLinks.{{ $index }}.url" class="bg-[#111827] border border-[#2a3548] text-white w-full p-2 rounded text-sm focus:border-primary focus:outline-none"
                                placeholder="URL الرابط">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                            <i class="ri-share-line text-purple-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">روابط التواصل الاجتماعي</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="footerSocialMediaEnabled" class="ml-2 toggle-switch sr-only">
                            <span class="ml-3 text-sm font-medium text-gray-300">تفعيل القسم</span>
                        </label>
                        <button wire:click="addSocialLink" type="button"
                            class="bg-gradient-to-r from-primary to-secondary text-black px-4 py-2 rounded-lg text-sm font-medium hover:from-primary/90 hover:to-secondary/90 transition-all duration-300 shadow-lg">
                            <i class="ri-add-line ml-1"></i>
                            إضافة رابط
                        </button>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($footerSocialMedia as $index => $social)
                    <div wire:key="social-link-{{ $index }}" class="bg-[#0f1623] rounded-lg p-4 border border-[#2a3548] flex justify-between items-center shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center gap-3">
                            <button wire:click="removeSocialLink({{ $index }})" type="button" class="text-gray-400 hover:text-red-500 transition-colors duration-300">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <button class="text-gray-400 hover:text-primary transition-colors duration-300 cursor-grab">
                                <i class="ri-drag-move-line"></i>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 flex-1 mr-4">
                            <select wire:model="footerSocialMedia.{{ $index }}.icon" class="bg-[#111827] border border-[#2a3548] text-white p-2 rounded text-sm focus:border-primary focus:outline-none">
                                <option value="ri-facebook-fill">Facebook</option>
                                <option value="ri-twitter-fill">Twitter</option>
                                <option value="ri-instagram-line">Instagram</option>
                                <option value="ri-youtube-fill">YouTube</option>
                                <option value="ri-linkedin-fill">LinkedIn</option>
                                <option value="ri-whatsapp-line">WhatsApp</option>
                                <option value="ri-tiktok-fill">TikTok</option>
                                <option value="ri-snapchat-fill">Snapchat</option>
                            </select>
                            <input type="text" wire:model="footerSocialMedia.{{ $index }}.url" class="bg-[#111827] border border-[#2a3548] text-white flex-1 p-2 rounded text-sm focus:border-primary focus:outline-none"
                                placeholder="URL الرابط">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center">
                            <i class="ri-contacts-line text-green-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">معلومات الاتصال</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="contactEnabled" class="ml-2 toggle-switch sr-only">
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">رقم الهاتف</label>
                        <input type="text" wire:model="footerPhone" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors"
                            placeholder="+966 55 123 4567">
                        @error('footerPhone') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">البريد الإلكتروني</label>
                        <input type="email" wire:model="footerEmail" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors"
                            placeholder="info@example.com">
                        @error('footerEmail') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">العنوان</label>
                        <textarea wire:model="footerAddress" class="bg-[#0f1623] border border-[#2a3548] text-white w-full p-3 rounded-lg focus:border-primary focus:outline-none transition-colors" rows="3"
                            placeholder="العنوان الكامل"></textarea>
                        @error('footerAddress') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Footer Settings -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Footer Categories Toggle -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                            <i class="ri-list-check-3 text-indigo-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">عرض التصنيفات في الفوتر</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="footerCategoriesEnabled" class=" ml-2 toggle-switch sr-only">
                        <span class="ml-3 text-sm font-medium text-gray-300">تفعيل القسم</span>
                    </label>
                </div>
                <p class="text-gray-400 text-sm">
                    عند التفعيل، سيتم عرض قسم التصنيفات في الفوتر مع روابط للتصنيفات الرئيسية
                </p>
            </div>

            <!-- Footer Payment Methods Toggle -->
            <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-6 border border-[#2a3548] shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                            <i class="ri-bank-card-line text-yellow-400"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-white">عرض وسائل الدفع في الفوتر</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="footerPaymentMethodsEnabled" class="ml-2 toggle-switch sr-only">
                        <span class="ml-3 text-sm font-medium text-gray-300">تفعيل القسم</span>
                    </label>
                </div>
                <p class="text-gray-400 text-sm">
                    عند التفعيل، سيتم عرض أيقونات وسائل الدفع المتاحة في الفوتر
                </p>
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-6 flex justify-end">
            <button wire:click="save" type="button" class="bg-gradient-to-r from-primary to-secondary text-black px-6 py-3 rounded-lg font-medium hover:from-primary/90 hover:to-secondary/90 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="ri-save-line ml-2"></i>
                حفظ التغييرات
            </button>
        </div>
    </div>

    <style>
        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            background: #374151;
            border-radius: 12px;
            outline: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .toggle-switch:checked {
            background: #00e5bb;
        }

        .toggle-switch::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .toggle-switch:checked::before {
            transform: translateX(20px);
        }
    </style>
</div>