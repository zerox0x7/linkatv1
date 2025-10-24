<div>
    <!-- Page Content -->
    <div class="p-6">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-[#1e293b] rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-400 text-sm">إجمالي العملاء</div>
                    <div class="w-10 h-10 rounded-full bg-primary bg-opacity-20 flex items-center justify-center text-primary">
                        <i class="ri-user-line"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ number_format($stats['total']) }}</div>
                <div class="flex items-center mt-2 text-sm">
                    <div class="{{ $stats['growth']['total'] >= 0 ? 'text-green-500' : 'text-red-500' }} flex items-center">
                        <i class="{{ $stats['growth']['total'] >= 0 ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line' }}"></i>
                        <span>{{ abs($stats['growth']['total']) }}%</span>
                    </div>
                    <div class="text-gray-400 mr-2">مقارنة بالشهر الماضي</div>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-400 text-sm">عملاء نشطين</div>
                    <div class="w-10 h-10 rounded-full bg-green-500 bg-opacity-20 flex items-center justify-center text-green-500">
                        <i class="ri-user-follow-line"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ number_format($stats['active']) }}</div>
                <div class="flex items-center mt-2 text-sm">
                    <div class="{{ $stats['growth']['active'] >= 0 ? 'text-green-500' : 'text-red-500' }} flex items-center">
                        <i class="{{ $stats['growth']['active'] >= 0 ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line' }}"></i>
                        <span>{{ abs($stats['growth']['active']) }}%</span>
                    </div>
                    <div class="text-gray-400 mr-2">مقارنة بالشهر الماضي</div>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-400 text-sm">عملاء VIP</div>
                    <div class="w-10 h-10 rounded-full bg-yellow-500 bg-opacity-20 flex items-center justify-center text-yellow-500">
                        <i class="ri-vip-crown-line"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ number_format($stats['vip']) }}</div>
                <div class="flex items-center mt-2 text-sm">
                    <div class="{{ $stats['growth']['vip'] >= 0 ? 'text-green-500' : 'text-red-500' }} flex items-center">
                        <i class="{{ $stats['growth']['vip'] >= 0 ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line' }}"></i>
                        <span>{{ abs($stats['growth']['vip']) }}%</span>
                    </div>
                    <div class="text-gray-400 mr-2">مقارنة بالشهر الماضي</div>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-400 text-sm">عملاء جدد</div>
                    <div class="w-10 h-10 rounded-full bg-blue-500 bg-opacity-20 flex items-center justify-center text-blue-500">
                        <i class="ri-user-add-line"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ number_format($stats['new']) }}</div>
                <div class="flex items-center mt-2 text-sm">
                    <div class="{{ $stats['growth']['new'] >= 0 ? 'text-green-500' : 'text-red-500' }} flex items-center">
                        <i class="{{ $stats['growth']['new'] >= 0 ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line' }}"></i>
                        <span>{{ abs($stats['growth']['new']) }}%</span>
                    </div>
                    <div class="text-gray-400 mr-2">مقارنة بالشهر الماضي</div>
                </div>
            </div>
        </div>

       
        <!-- Filters and Actions -->
        <div class="bg-[#1e293b] rounded-lg p-4 mb-6">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex flex-wrap items-center">
                    <!-- Segment Filter -->
                    <div class="relative ml-4 mb-2 md:mb-0">
                        <select wire:model.live="segmentFilter" 
                                class="bg-[#141c2f] border border-gray-700 rounded-button px-4 py-2 text-sm whitespace-nowrap appearance-none">
                            <option value="">جميع الشرائح</option>
                            <option value="vip">عملاء VIP</option>
                            <option value="regular">عملاء عاديين</option>
                            <option value="new">عملاء جدد</option>
                        </select>
                    </div>
        

                    
                    <!-- Status Filter -->
                    <div class="relative ml-4 mb-2 md:mb-0">
                        <select wire:model.live="statusFilter" 
                                class="bg-[#141c2f] border border-gray-700 rounded-button px-4 py-2 text-sm whitespace-nowrap appearance-none">
                            <option value="">جميع الحالات</option>
                            <option value="active">نشط</option>
                            <option value="inactive">غير نشط</option>
                        </select>
                    </div>
                    
                    <!-- Sort Filter -->
                    <div class="relative mb-2 md:mb-0">
                        <select wire:model.live="sortBy" 
                                class="bg-[#141c2f] border border-gray-700 rounded-button px-4 py-2 text-sm whitespace-nowrap appearance-none">
                            <option value="created_at">ترتيب حسب: الأحدث</option>
                            <option value="name">الاسم: أ-ي</option>
                            <option value="orders_sum_total">قيمة المشتريات: الأعلى</option>
                            <option value="orders_count">عدد الطلبات</option>
                        </select>
                    </div>
                </div>



                             <!-- Search Bar -->
            <div class="relative">
            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="ri-search-line"></i>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="البحث في العملاء..." 
                       class="w-full bg-[#141c2f] border border-gray-700 rounded-button px-4 py-2 pl-10 search-input">
               
            </div>
                
                <div class="flex items-center">
                    <button wire:click="refreshData" 
                            class="bg-[#141c2f] border border-gray-700 rounded-button px-4 py-2 flex items-center text-sm ml-3 whitespace-nowrap">
                        <div class="w-4 h-4 flex items-center justify-center ml-1">
                            <i class="ri-refresh-line"></i>
                        </div>
                        <span>تحديث</span>
                    </button>
                    
                    @if(count($selectedClients) > 0)
                    <button wire:click="deleteSelected" 
                            wire:confirm="هل أنت متأكد من حذف العملاء المحددين؟"
                            class="bg-red-600 hover:bg-red-700 rounded-button px-4 py-2 flex items-center text-sm whitespace-nowrap">
                        <div class="w-4 h-4 flex items-center justify-center ml-1">
                            <i class="ri-delete-bin-line"></i>
                        </div>
                        <span>حذف المحدد ({{ count($selectedClients) }})</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- View Toggle -->
        <div class="flex items-center mb-4">
            <div class="flex bg-[#1e293b] rounded-full p-1">
                <button class="flex items-center justify-center px-4 py-1 rounded-full bg-primary text-gray-900 whitespace-nowrap">
                    <i class="ri-table-line ml-2"></i>
                    جدول
                </button>
            </div>
            <div class="flex items-center mr-auto">
                <span class="text-sm text-gray-400 ml-2">عرض</span>
                <div class="relative">
                    <select wire:model.live="perPage" 
                            class="bg-[#141c2f] border border-gray-700 rounded-button px-4 py-2 text-sm appearance-none pr-8">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <div class="absolute left-2 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                </div>
                <span class="text-sm text-gray-400 mr-2">لكل صفحة</span>
            </div>
        </div>

        <!-- Table View -->
        <div class="bg-[#1e293b] rounded-lg overflow-hidden mb-6">
            <div class="overflow-x-auto table-container">
                <table class="w-full min-w-[1000px]">
                    <thead>
                        <tr class="bg-[#141c2f] text-gray-300 text-sm">
                            <th class="py-3 px-4 text-right">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           wire:model.live="selectAll"
                                           class="rounded border-gray-600 text-primary focus:ring-primary focus:ring-offset-0">
                                </div>
                            </th>
                            <th class="py-3 px-4 text-right avatar-column"></th>
                            <th class="py-3 px-4 text-right name-column">
                                <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                                    <span>العميل</span>
                                    <div class="w-4 h-4 flex items-center justify-center mr-1">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 px-4 text-right">
                                <div class="flex items-center cursor-pointer" wire:click="sortBy('orders_sum_total')">
                                    <span>المشتريات</span>
                                    <div class="w-4 h-4 flex items-center justify-center mr-1">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 px-4 text-right role-column">الشريحة</th>
                            <th class="py-3 px-4 text-right status-column">الحالة</th>
                            <th class="py-3 px-4 text-right login-column">آخر نشاط</th>
                            <th class="py-3 px-4 text-center actions-column">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                        <tr class="table-row border-b border-gray-800 {{ in_array($client->id, $selectedClients) ? 'selected' : '' }}">
                            <td class="py-3 px-4">
                                <input type="checkbox" 
                                       wire:model.live="selectedClients" 
                                       value="{{ $client->id }}"
                                       class="rounded border-gray-600 text-primary focus:ring-primary focus:ring-offset-0">
                            </td>
                            <td class="py-3 px-2">
                                @if($client->avatar)
                                    <img src="{{ asset('storage/' . $client->avatar) }}" 
                                         alt="{{ $client->name }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                        {{ mb_substr($client->name, 0, 2) }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div>
                                    <div class="font-medium">{{ $client->name }}</div>
                                    <div class="text-sm text-gray-400">{{ $client->email }}</div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium">{{ $this->formatPurchases($client->orders_sum_total, $client->orders_count) }}</div>
                                <div class="text-xs text-gray-400">{{ $client->orders_count ?? 0 }} طلب</div>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $segment = $this->getClientSegment($client);
                                @endphp
                                @if($segment === 'vip')
                                    <span class="customer-tag vip">VIP</span>
                                @elseif($segment === 'new')
                                    <span class="customer-tag new">جديد</span>
                                @else
                                    <span class="customer-tag">عادي</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="status-badge {{ $client->is_active ? 'active-badge' : 'inactive-badge' }}">
                                    {{ $client->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center text-sm text-gray-400">
                                    <div class="w-4 h-4 flex items-center justify-center ml-1">
                                        <i class="ri-time-line"></i>
                                    </div>
                                    <span>{{ $this->formatLastActivity($client->last_login_at) }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex justify-center">
                                    <button class="w-8 h-8 rounded-full bg-[#141c2f] flex items-center justify-center ml-1 action-btn"
                                            title="عرض الملف الشخصي">
                                        <i class="ri-eye-line text-gray-400"></i>
                                    </button>
                                    <!-- <button class="w-8 h-8 rounded-full bg-[#141c2f] flex items-center justify-center ml-1 action-btn"
                                            title="تعديل">
                                        <i class="ri-edit-line text-gray-400"></i>
                                    </button> -->
                                    <button wire:click="deleteClient({{ $client->id }})"
                                            wire:confirm="هل أنت متأكد من حذف هذا العميل؟"
                                            class="w-8 h-8 rounded-full bg-[#141c2f] flex items-center justify-center action-btn"
                                            title="حذف">
                                        <i class="ri-delete-bin-line text-gray-400"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <i class="ri-user-line text-4xl mb-2"></i>
                                    <p>لا توجد عملاء</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center">
           
        </div>
        {{ $clients->links('vendor.pagination.custom') }}
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-[#1e293b] rounded-lg p-6 flex items-center">
            <div class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin ml-3"></div>
            <span class="text-white">جاري التحميل...</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide flash messages
    setTimeout(() => {
        const flashMessage = document.querySelector('.fixed.top-4');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }, 3000);

    // Listen for data refresh events
    Livewire.on('data-refreshed', () => {
        // Show success message
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.textContent = 'تم تحديث البيانات بنجاح';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    });
</script>
@endpush