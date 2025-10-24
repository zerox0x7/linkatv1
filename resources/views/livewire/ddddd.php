<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($coupons as $coupon)
            <div class="bg-white rounded-lg shadow-md p-6 border">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $coupon->code }}</h3>
                        <p class="text-sm text-gray-600">{{ $coupon->description ?? 'No description' }}</p>
                    </div>
                    <button 
                        wire:click="openCouponSettings({{ $coupon->id }})"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition-colors"
                    >
                        Settings
                    </button>
                </div>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Type:</span>
                        <span class="font-medium">{{ ucfirst($coupon->type) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Value:</span>
                        <span class="font-medium">
                            {{ $coupon->type === 'percentage' ? $coupon->value . '%' : '$' . $coupon->value }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium {{ $coupon->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t">
                    <div class="text-xs text-gray-500">
                        <p>Categories: {{ $coupon->categories->count() }}</p>
                        <p>Products: {{ $coupon->products->count() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $coupons->links() }}
    </div>

    @if($showCouponSettings && $selectedCoupon)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeCouponSettings">
            <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-screen overflow-y-auto" wire:click.stop>
                <livewire:coupon-settings :coupon="$selectedCoupon" :key="$selectedCoupon->id" />
            </div>
        </div>
    @endif
</div>