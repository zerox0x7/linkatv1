<div class="space-y-4">
    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200">
        <button 
            wire:click="$set('activeTab', 'products')"
            class="px-4 py-2 text-sm font-medium border-b-2 {{ $activeTab === 'products' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Products ({{ count($selectedProducts) }})
        </button>
        <button 
            wire:click="$set('activeTab', 'categories')"
            class="px-4 py-2 text-sm font-medium border-b-2 {{ $activeTab === 'categories' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Categories ({{ count($selectedCategories) }})
        </button>
    </div>

    <!-- Search Bar -->
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input 
            type="text" 
            wire:model.live.debounce.300ms="searchTerm"
            placeholder="Search {{ $activeTab }}..."
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <!-- Results Container -->
    <div class="border border-gray-200 rounded-md max-h-64 overflow-y-auto">
        @if($activeTab === 'products')
            <!-- Products List -->
            @forelse($searchResults as $product)
                <div class="flex items-center justify-between p-3 border-b border-gray-100 hover:bg-gray-50">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                        <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                        @if($product->price)
                            <div class="text-xs text-gray-500">${{ number_format($product->price, 2) }}</div>
                        @endif
                    </div>
                    <button 
                        wire:click="toggleProduct({{ $product->id }})"
                        class="ml-3 px-3 py-1 text-xs font-medium rounded-full border
                            {{ in_array($product->id, $selectedProducts) 
                                ? 'bg-blue-100 text-blue-800 border-blue-200' 
                                : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200' }}">
                        {{ in_array($product->id, $selectedProducts) ? 'Selected' : 'Select' }}
                    </button>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 text-sm">
                    @if(empty($searchTerm))
                        Start typing to search for products...
                    @else
                        No products found matching "{{ $searchTerm }}"
                    @endif
                </div>
            @endforelse
        @else
            <!-- Categories List -->
            @forelse($searchResults as $category)
                <div class="flex items-center justify-between p-3 border-b border-gray-100 hover:bg-gray-50">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                        @if($category->description)
                            <div class="text-xs text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                        @endif
                    </div>
                    <button 
                        wire:click="toggleCategory({{ $category->id }})"
                        class="ml-3 px-3 py-1 text-xs font-medium rounded-full border
                            {{ in_array($category->id, $selectedCategories) 
                                ? 'bg-green-100 text-green-800 border-green-200' 
                                : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200' }}">
                        {{ in_array($category->id, $selectedCategories) ? 'Selected' : 'Select' }}
                    </button>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 text-sm">
                    @if(empty($searchTerm))
                        Start typing to search for categories...
                    @else
                        No categories found matching "{{ $searchTerm }}"
                    @endif
                </div>
            @endforelse
        @endif
    </div>

    <!-- Selected Items Summary -->
    @if(count($selectedProducts) > 0 || count($selectedCategories) > 0)
        <div class="mt-4 p-3 bg-blue-50 rounded-md border border-blue-200">
            <div class="text-xs font-medium text-blue-800 mb-2">Selected Items:</div>
            <div class="flex flex-wrap gap-1">
                @foreach($selectedProducts as $productId)
                    @php($product = $searchResults->where('id', $productId)->first() ?? \App\Models\Product::find($productId))
                    @if($product)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $product->name }}
                            <button wire:click="toggleProduct({{ $productId }})" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                        </span>
                    @endif
                @endforeach
                @foreach($selectedCategories as $categoryId)
                    @php($category = $categories->where('id', $categoryId)->first())
                    @if($category)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $category->name }}
                            <button wire:click="toggleCategory({{ $categoryId }})" class="ml-1 text-green-600 hover:text-green-800">×</button>
                        </span>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</div>