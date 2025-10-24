<div>
    <div class="card rounded-lg">
        <div class="p-6 border-b border-slate-700 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold text-lg">الطلبات الحديثة</h3>
                <div class="flex gap-2">
                    <button type="button" wire:click="handleClick"
                        class="px-3 py-1 text-sm !rounded-button bg-[#01b6a5] hover:bg-[#00a090] transition-colors">
                        بحث <i class="ri-search-eye-line"></i>
                    </button>
                    <button type="button" wire:click="clearFilters"
                        class="px-3 py-1 text-sm !rounded-button bg-slate-700 hover:bg-slate-600 transition-colors">
                        مسح الفلاتر <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-5 gap-4">
                <div class="relative">
                    <input type="text" wire:model.defer="orderNumber" placeholder="رقم الطلب"
                        class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                    <div
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                        <i class="ri-hashtag"></i>
                    </div>
                </div>
                <div class="relative">
                    <input type="text" wire:model.defer="customerName" placeholder="اسم العميل"
                        class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                    <div
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                        <i class="ri-user-line"></i>
                    </div>
                </div>
                <div class="relative">
                    <input type="text" wire:model.defer="productName" placeholder="المنتج"
                        class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                    <div
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                        <i class="ri-shopping-bag-line"></i>
                    </div>
                </div>
                <div class="relative">
                    <input type="number" wire:model.defer="orderPrice" placeholder="السعر"
                        class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                    <div
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                </div>

                <div class="relative">
                    <input type="date" wire:model.defer="orderDate"
                        class="w-full bg-slate-800 border border-slate-700 border-none !rounded-button pl-10 pr-4 py-2 text-sm text-gray-400 placeholder-gray-400 cursor-pointer appearance-none" />
                    <div
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                        <i class="ri-calendar-schedule-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-right text-sm text-gray-400 border-b border-slate-700">
                        <th class="py-4 px-6 font-medium">رقم الطلب</th>
                        <th class="py-4 px-6 font-medium">العميل</th>
                        <th class="py-4 px-6 font-medium">المنتج</th>
                        <th class="py-4 px-6 font-medium">المبلغ</th>
                        <th class="py-4 px-6 font-medium">الحالة</th>
                        <th class="py-4 px-6 font-medium">التاريخ</th>
                        <th class="py-4 px-6 font-medium">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($recentOrders->count() > 0)
                        @foreach ($recentOrders as $order)
                            <tr
                                class="table-row border-b border-slate-700 hover:bg-slate-800/50 transition-colors">
                                <td class="py-4 px-6">{{ $order->id }}#</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                            <i class="ri-user-line text-blue-500"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium">
                                                {{ $order->user ? $order->user->name : 'غير مسجل' }} </div>
                                            <div class="text-sm text-gray-400">
                                                {{ $order->user ? $order->user->email : 'user@gmail.com' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if ($order->items && $order->items->count())
                                        {{ $order->items->first()->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-4 px-6"> {{ number_format($order->total, 2) }} ريال</td>
                                <td class="py-4 px-6">
                                    <span
                                        class="px-2 py-1 text-xs !rounded-button {{ $order->status == 'completed' ? 'bg-emerald-500/20 text-emerald-500 ' : ($order->status == 'rejected' ? 'bg-rose-500/20 text-rose-500' : 'bg-yellow-500/20 text-yellow-500') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6"> {{ $order->created_at->format('Y-m-d') }} </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <button
                                            class="w-8 h-8 !rounded-button flex items-center justify-center bg-slate-700 hover:bg-slate-600 transition-colors">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        <button
                                            class="w-8 h-8 !rounded-button flex items-center justify-center bg-slate-700 hover:bg-slate-600 transition-colors">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                        <button
                                            class="w-8 h-8 !rounded-button flex items-center justify-center bg-rose-500/20 text-rose-500 hover:bg-rose-500/30 transition-colors">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="py-8 px-6 text-center text-gray-400">
                                لا توجد طلبات مطابقة لمعايير البحث
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>