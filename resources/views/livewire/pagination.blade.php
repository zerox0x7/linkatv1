@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
        <div class="flex">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-10 h-10 rounded-lg bg-[#1e293b] flex items-center justify-center ml-2 text-gray-600 cursor-not-allowed">
                    <i class="ri-arrow-right-s-line"></i>
                </span>
            @else
                <button wire:click="previousPage" rel="prev" 
                        class="w-10 h-10 rounded-lg bg-[#1e293b] flex items-center justify-center ml-2 text-gray-400 pagination-btn hover:bg-[#334155]">
                    <i class="ri-arrow-right-s-line"></i>
                </button>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-10 h-10 rounded-lg bg-[#1e293b] flex items-center justify-center ml-2 text-gray-400">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center ml-2 text-gray-900 pagination-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" 
                                    class="w-10 h-10 rounded-lg bg-[#1e293b] flex items-center justify-center ml-2 text-gray-400 pagination-btn hover:bg-[#334155]">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" rel="next" 
                        class="w-10 h-10 rounded-lg bg-[#1e293b] flex items-center justify-center text-gray-400 pagination-btn hover:bg-[#334155]">
                    <i class="ri-arrow-left-s-line"></i>
                </button>
            @else
                <span class="w-10 h-10 rounded-lg bg-[#1e293b] flex items-center justify-center text-gray-600 cursor-not-allowed">
                    <i class="ri-arrow-left-s-line"></i>
                </span>
            @endif
        </div>
    </nav>
@endif 