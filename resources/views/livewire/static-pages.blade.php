<div class="p-6">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-6 bg-green-900/50 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg flex items-center animate-in fade-in duration-300">
            <i class="ri-check-circle-line text-xl ml-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-900/50 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg flex items-center animate-in fade-in duration-300">
            <i class="ri-error-warning-line text-xl ml-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.static-pages.create') }}"
            class="bg-primary text-gray-900 px-4 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-primary/90 transition-colors">
            <div class="w-5 h-5 flex items-center justify-center ml-2">
                <i class="ri-add-line"></i>
            </div>
            <span>إضافة صفحة جديدة</span>
        </a>

        <div class="flex items-center">
            <h1 class="text-2xl font-bold">الصفحات الثابتة</h1>
            <span class="bg-gray-700 text-gray-300 text-sm rounded-full px-2 py-1 mr-2">({{ $pages->total() }})</span>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <input type="text" wire:model.live="search" 
                class="w-full bg-[#111827] text-white py-3 px-4 pl-10 rounded-lg border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary transition-all"
                placeholder="البحث عن صفحة...">
            <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    @if($pages->count() > 0)
        <!-- Pages Table -->
        <div class="bg-gradient-to-br from-[#0f1623] to-[#162033] rounded-lg overflow-hidden shadow-lg border border-gray-700/50">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-[#121827] to-[#1a2234] border-b border-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300">#</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300">عنوان الصفحة</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300">الرابط (Slug)</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-300">الحالة</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300">الترتيب</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300">تاريخ الإنشاء</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-300">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach ($pages as $index => $page)
                            <tr class="hover:bg-gray-800/30 transition-colors duration-200" wire:key="page-{{ $page->id }}">
                                <td class="px-6 py-4 text-gray-300">{{ $pages->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-cyan-500/20 to-blue-500/20 flex items-center justify-center ml-3">
                                            <i class="ri-file-text-line text-cyan-400"></i>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $page->title }}</div>
                                            @if($page->meta_title)
                                                <div class="text-xs text-gray-400">{{ Str::limit($page->meta_title, 40) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <code class="text-sm bg-gray-800 text-cyan-400 px-2 py-1 rounded">{{ $page->slug }}</code>
                                        <button 
                                            onclick="copyPageLink('{{ url('page/' . $page->slug) }}')"
                                            class="w-7 h-7 flex items-center justify-center bg-gray-700/50 hover:bg-primary/20 rounded-lg transition-all duration-200 group"
                                            title="نسخ الرابط">
                                            <i class="ri-file-copy-line text-gray-400 group-hover:text-primary text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <!-- Toggle Switch -->
                                    <div class="flex items-center justify-center" wire:key="toggle-{{ $page->id }}">
                                        <button wire:click="toggleStatus({{ $page->id }})" 
                                                wire:loading.attr="disabled" 
                                                wire:target="toggleStatus"
                                                wire:key="toggle-btn-{{ $page->id }}"
                                                class="relative inline-flex h-7 w-12 items-center rounded-full transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 focus:ring-offset-gray-900 disabled:opacity-50 disabled:cursor-not-allowed shadow-inner {{ $page->is_active ? 'bg-gradient-to-r from-primary to-primary/80 shadow-primary/20' : 'bg-gradient-to-r from-gray-600 to-gray-700 shadow-gray-800/20' }}">
                                            <span class="inline-block h-5 w-5 transform rounded-full transition-all duration-300 ease-in-out shadow-lg {{ $page->is_active ? '-translate-x-6 bg-white shadow-gray-200/50' : 'translate-x-1 bg-gradient-to-br from-gray-200 to-gray-300 shadow-gray-400/50' }}"></span>
                                        </button>
                                        <!-- Loading indicator -->
                                        <div wire:loading wire:target="toggleStatus" class="mr-2">
                                            <div class="w-4 h-4 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-gray-700 text-gray-300 text-sm rounded px-2 py-1">{{ $page->order }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-sm">
                                    {{ $page->created_at->format('Y-m-d') }}
                                    <div class="text-xs text-gray-500">{{ $page->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.static-pages.edit', $page->id) }}"
                                            class="w-8 h-8 flex items-center justify-center bg-primary/10 rounded-lg hover:bg-primary hover:text-gray-900 transition-all duration-200 group"
                                            title="تعديل">
                                            <i class="ri-edit-line text-primary group-hover:text-gray-900"></i>
                                        </a>
                                        
                                        <!-- View Button -->
                                        <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                                            class="w-8 h-8 flex items-center justify-center bg-blue-500/10 rounded-lg hover:bg-blue-500 hover:text-white transition-all duration-200 group"
                                            title="عرض الصفحة">
                                            <i class="ri-eye-line text-blue-400 group-hover:text-white"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <button wire:click="confirmDelete({{ $page->id }})"
                                            class="w-8 h-8 flex items-center justify-center bg-red-500/10 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-200 group"
                                            title="حذف">
                                            <i class="ri-delete-bin-line text-red-400 group-hover:text-white"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($pages, 'links'))
            <div class="mt-6">
                {{ $pages->links('vendor.pagination.custom') }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-[#0f1623] to-[#162033] rounded-lg p-12 text-center border border-gray-700/50">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-cyan-500/20 to-blue-500/20 flex items-center justify-center">
                <i class="ri-file-text-line text-4xl text-cyan-400"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">لا توجد صفحات ثابتة</h3>
            <p class="text-gray-400 mb-6">
                @if($search)
                    لم يتم العثور على نتائج للبحث "{{ $search }}"
                @else
                    ابدأ بإضافة صفحات ثابتة لموقعك
                @endif
            </p>
            <a href="{{ route('admin.static-pages.create') }}"
                class="inline-flex items-center bg-primary text-gray-900 px-6 py-3 rounded-button hover:bg-primary/90 transition-colors">
                <i class="ri-add-line ml-2"></i>
                <span>إضافة صفحة جديدة</span>
            </a>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $pageToDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" dir="rtl">
            <!-- Backdrop with blur effect -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="cancelDelete"></div>
            
            <!-- Modal Container -->
            <div class="relative bg-gradient-to-br from-gray-900/95 to-gray-800/95 backdrop-blur-xl border border-gray-700/50 rounded-2xl shadow-2xl max-w-md w-full mx-4 animate-in zoom-in-95 duration-300" 
                 wire:click.stop>
                
                <!-- Gradient Border Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 via-orange-500/20 to-red-500/20 rounded-2xl blur-sm -z-10"></div>
                
                <!-- Modal Content -->
                <div class="relative p-6 sm:p-8">
                    <!-- Header Section -->
                    <div class="flex items-start mb-8 space-x-reverse space-x-4">
                        <!-- Header Text -->
                        <div class="flex-1 text-right">
                            <h3 class="text-2xl font-bold text-white mb-2 tracking-tight">حذف الصفحة</h3>
                            <p class="text-gray-400 text-sm font-medium">هذا الإجراء لا يمكن التراجع عنه</p>
                        </div>
                        
                        <!-- Animated Icon Container -->
                        <div class="relative ml-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/25">
                                <i class="ri-delete-bin-line text-white text-2xl"></i>
                            </div>
                            <!-- Pulsing Ring Effect -->
                            <div class="absolute inset-0 w-16 h-16 bg-red-500/30 rounded-2xl animate-ping"></div>
                        </div>
                        
                        <!-- Close Button -->
                        <button wire:click="cancelDelete" 
                                class="absolute top-4 left-4 w-8 h-8 bg-gray-800/80 hover:bg-gray-700 rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <i class="ri-close-line text-gray-400 hover:text-white"></i>
                        </button>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="space-y-6 mb-8">
                        <!-- Page Info Card -->
                        <div class="bg-gradient-to-br from-cyan-500/10 to-blue-500/10 border border-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center space-x-reverse space-x-3">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-cyan-500/20 to-blue-500/20 flex items-center justify-center">
                                    <i class="ri-file-text-line text-cyan-400 text-xl"></i>
                                </div>
                                <div class="flex-1 text-right">
                                    <h4 class="text-lg font-semibold text-white">{{ $pageToDelete->title }}</h4>
                                    <p class="text-gray-400 text-sm">/{{ $pageToDelete->slug }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Warning Message -->
                        <div class="bg-yellow-900/30 border border-yellow-600/50 rounded-xl p-4">
                            <div class="flex items-start space-x-reverse space-x-3">
                                <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="ri-alert-line text-white text-sm"></i>
                                </div>
                                <div class="flex-1 text-right">
                                    <p class="text-yellow-300 font-medium mb-1">تحذير هام</p>
                                    <p class="text-yellow-200/80 text-sm leading-relaxed">
                                        هل أنت متأكد من حذف الصفحة "<span class="font-semibold text-yellow-100">{{ $pageToDelete->title }}</span>"؟
                                        سيتم حذف المحتوى بشكل نهائي.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between space-x-reverse space-x-4">
                        <!-- Cancel Button -->
                        <button wire:click="cancelDelete"
                                class="flex-1 px-6 py-3 bg-gray-700/80 hover:bg-gray-600 text-gray-200 font-medium rounded-xl transition-all duration-200 hover:scale-[1.02] flex items-center justify-center space-x-reverse space-x-2">
                            <i class="ri-close-line"></i>
                            <span>إلغاء</span>
                        </button>
                        
                        <!-- Delete Button -->
                        <button wire:click="deletePage"
                                wire:loading.attr="disabled"
                                wire:target="deletePage"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-xl transition-all duration-200 hover:scale-[1.02] hover:shadow-lg hover:shadow-red-500/25 flex items-center justify-center space-x-reverse space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div wire:loading wire:target="deletePage" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            <i wire:loading.remove wire:target="deletePage" class="ri-delete-bin-line"></i>
                            <span wire:loading.remove wire:target="deletePage">حذف نهائياً</span>
                            <span wire:loading wire:target="deletePage">جاري الحذف...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Copy Success Toast Notification -->
    <div id="copyToast" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-[60] transition-all duration-300 opacity-0 pointer-events-none">
        <i class="ri-check-line text-xl"></i>
        <span>تم نسخ الرابط بنجاح!</span>
    </div>
</div>

<script>
function copyPageLink(url) {
    // Create a temporary input element
    const tempInput = document.createElement('input');
    tempInput.value = url;
    document.body.appendChild(tempInput);
    
    // Select and copy the text
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        showCopyToast();
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
    
    // Remove the temporary input
    document.body.removeChild(tempInput);
}

function showCopyToast() {
    const toast = document.getElementById('copyToast');
    
    // Show the toast
    toast.style.opacity = '1';
    toast.style.pointerEvents = 'auto';
    
    // Hide after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.pointerEvents = 'none';
    }, 3000);
}
</script>