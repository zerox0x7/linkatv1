@if ($paginator->hasPages())
<div class="mt-8 flex justify-between items-center bg-[#111827] p-4 rounded-lg">
    {{-- Left side - Items per page and count info --}}
    <div class="flex items-center text-sm">
        <span class="text-gray-400">عرض</span>
        <div class="relative mx-2">
            <select
                wire:model.live="perPage"
                class="bg-[#141c2f] text-gray-300 border-none rounded-button py-1 pr-3 pl-8 appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="4">4</option>
                <option value="6">6</option>
                <option value="8">8</option>
                <option value="16">16</option>
            </select>
            <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none select-icon">
                <div class="w-4 h-4 flex items-center justify-center text-gray-400">
                    <i class="ri-arrow-down-s-line"></i>
                </div>
            </div>
        </div>
        <span class="text-gray-400">من {{ $paginator->total() }} منتج</span>
    </div>

    {{-- Right side - Pagination controls --}}
    <div class="flex items-center space-x-1">
        {{-- Previous Page Button --}}
        @if ($paginator->onFirstPage())
            <button class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-600 cursor-not-allowed" disabled>
                <i class="ri-arrow-left-s-line"></i>
            </button>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled" class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-400 hover:bg-gray-800">
                <i class="ri-arrow-left-s-line"></i>
            </button>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <button class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-300 cursor-default">
                    {{ $element }}
                </button>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="w-9 h-9 flex items-center justify-center rounded-button bg-primary text-white">
                            {{ $page }}
                        </button>
                    @else
                        <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-300 hover:bg-gray-800">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Button --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled" class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-400 hover:bg-gray-800">
                <i class="ri-arrow-right-s-line"></i>
            </button>
        @else
            <button class="w-9 h-9 flex items-center justify-center rounded-button bg-[#141c2f] text-gray-600 cursor-not-allowed" disabled>
                <i class="ri-arrow-right-s-line"></i>
            </button>
        @endif
    </div>
</div>
@endif