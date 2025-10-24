{{-- GreenGame Theme Layout Simulation --}}
{{-- Gaming theme with full-width hero and card-based layout --}}
@props(['layoutBoxes'])

<div class="space-y-4">
    <!-- Row 1: Full Width Hero Banner -->
    <div class="layout-drop-zone" 
         data-position="0"
         x-data="{ isOver: false }"
         @dragover.prevent="isOver = true"
         @dragleave="isOver = false"
         @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 0)"
         :class="isOver ? 'border-primary bg-primary/5' : ''">
        @php
            $box0 = collect($layoutBoxes)->firstWhere('order', 0);
        @endphp
        @if($box0)
            <div class="layout-box layout-box-large" draggable="true"
                 @dragstart="$event.dataTransfer.setData('boxId', '{{ $box0['id'] }}'); $event.dataTransfer.effectAllowed = 'move'">
                <div class="layout-box-content">
                    @if($box0['image_preview'])
                        <img src="{{ $box0['image_preview'] }}" alt="{{ $box0['title'] }}" class="layout-box-image" style="height: 160px;">
                    @else
                        <div class="layout-box-placeholder" style="height: 160px;">
                            <i class="ri-image-line text-4xl"></i>
                        </div>
                    @endif
                    <div class="layout-box-info">
                        <div class="layout-box-badge">#1</div>
                        <h5 class="layout-box-title">{{ $box0['title'] ?: 'Hero Banner' }}</h5>
                        <p class="layout-box-type">Full Width Gaming Hero</p>
                        <button type="button" wire:click="selectBox('{{ $box0['id'] }}')" class="layout-box-edit">
                            <i class="ri-edit-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="layout-empty" style="min-height: 180px;">
                <i class="ri-gamepad-line text-3xl"></i>
                <p class="text-lg">Hero Gaming Banner</p>
                <span class="text-xs text-gray-500">#1 - Full Width</span>
            </div>
        @endif
    </div>
    
    <!-- Row 2: Featured Cards (3 columns) -->
    <div class="grid grid-cols-3 gap-4">
        <!-- Position 1: Featured Left -->
        <div class="layout-drop-zone" 
             data-position="1"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 1)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box1 = collect($layoutBoxes)->firstWhere('order', 1);
            @endphp
            @if($box1)
                <div class="layout-box layout-box-medium" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box1['id'] }}')">
                    <div class="layout-box-content">
                        @if($box1['image_preview'])
                            <img src="{{ $box1['image_preview'] }}" alt="{{ $box1['title'] }}" class="layout-box-image">
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#2</div>
                            <h5 class="layout-box-title">{{ $box1['title'] ?: 'Featured Game 1' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box1['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-xl"></i>
                    <p class="text-sm">Featured Game 1</p>
                    <span class="text-xs">#2</span>
                </div>
            @endif
        </div>
        
        <!-- Position 2: Featured Center -->
        <div class="layout-drop-zone" 
             data-position="2"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 2)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box2 = collect($layoutBoxes)->firstWhere('order', 2);
            @endphp
            @if($box2)
                <div class="layout-box layout-box-medium" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box2['id'] }}')">
                    <div class="layout-box-content">
                        @if($box2['image_preview'])
                            <img src="{{ $box2['image_preview'] }}" alt="{{ $box2['title'] }}" class="layout-box-image">
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#3</div>
                            <h5 class="layout-box-title">{{ $box2['title'] ?: 'Featured Game 2' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box2['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-xl"></i>
                    <p class="text-sm">Featured Game 2</p>
                    <span class="text-xs">#3</span>
                </div>
            @endif
        </div>
        
        <!-- Position 3: Featured Right -->
        <div class="layout-drop-zone" 
             data-position="3"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 3)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box3 = collect($layoutBoxes)->firstWhere('order', 3);
            @endphp
            @if($box3)
                <div class="layout-box layout-box-medium" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box3['id'] }}')">
                    <div class="layout-box-content">
                        @if($box3['image_preview'])
                            <img src="{{ $box3['image_preview'] }}" alt="{{ $box3['title'] }}" class="layout-box-image">
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#4</div>
                            <h5 class="layout-box-title">{{ $box3['title'] ?: 'Featured Game 3' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box3['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-xl"></i>
                    <p class="text-sm">Featured Game 3</p>
                    <span class="text-xs">#4</span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Row 3: Trending/Brand Section (2 columns) -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Position 4: Trending Left -->
        <div class="layout-drop-zone" 
             data-position="4"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 4)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box4 = collect($layoutBoxes)->firstWhere('order', 4);
            @endphp
            @if($box4)
                <div class="layout-box layout-box-medium" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box4['id'] }}')">
                    <div class="layout-box-content">
                        @if($box4['image_preview'])
                            <img src="{{ $box4['image_preview'] }}" alt="{{ $box4['title'] }}" class="layout-box-image">
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#5</div>
                            <h5 class="layout-box-title">{{ $box4['title'] ?: 'Trending Left' }}</h5>
                            <p class="layout-box-type">Brand/Category</p>
                            <button type="button" wire:click="selectBox('{{ $box4['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-2xl"></i>
                    <p>Trending Games Left</p>
                    <span class="text-xs">#5</span>
                </div>
            @endif
        </div>
        
        <!-- Position 5: Trending Right -->
        <div class="layout-drop-zone" 
             data-position="5"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 5)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box5 = collect($layoutBoxes)->firstWhere('order', 5);
            @endphp
            @if($box5)
                <div class="layout-box layout-box-medium" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box5['id'] }}')">
                    <div class="layout-box-content">
                        @if($box5['image_preview'])
                            <img src="{{ $box5['image_preview'] }}" alt="{{ $box5['title'] }}" class="layout-box-image">
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#6</div>
                            <h5 class="layout-box-title">{{ $box5['title'] ?: 'Trending Right' }}</h5>
                            <p class="layout-box-type">Brand/Category</p>
                            <button type="button" wire:click="selectBox('{{ $box5['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-2xl"></i>
                    <p>Trending Games Right</p>
                    <span class="text-xs">#6</span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Row 4: Services/Promo Section (4 columns) -->
    <div class="grid grid-cols-4 gap-3">
        <!-- Position 6: Service 1 -->
        <div class="layout-drop-zone" 
             data-position="6"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 6)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box6 = collect($layoutBoxes)->firstWhere('order', 6);
            @endphp
            @if($box6)
                <div class="layout-box layout-box-small" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box6['id'] }}')">
                    <div class="layout-box-content-compact">
                        @if($box6['image_preview'])
                            <img src="{{ $box6['image_preview'] }}" alt="{{ $box6['title'] }}" class="layout-box-image-small">
                        @endif
                        <div class="layout-box-info-compact">
                            <span class="layout-box-badge-small">#7</span>
                            <h5 class="layout-box-title-small">{{ $box6['title'] ?: 'Service 1' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box6['id'] }}')" class="layout-box-edit-small">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty layout-empty-small">
                    <i class="ri-service-line"></i>
                    <p class="text-xs">Service 1</p>
                    <span class="text-xs">#7</span>
                </div>
            @endif
        </div>
        
        <!-- Position 7: Service 2 -->
        <div class="layout-drop-zone" 
             data-position="7"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 7)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box7 = collect($layoutBoxes)->firstWhere('order', 7);
            @endphp
            @if($box7)
                <div class="layout-box layout-box-small" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box7['id'] }}')">
                    <div class="layout-box-content-compact">
                        @if($box7['image_preview'])
                            <img src="{{ $box7['image_preview'] }}" alt="{{ $box7['title'] }}" class="layout-box-image-small">
                        @endif
                        <div class="layout-box-info-compact">
                            <span class="layout-box-badge-small">#8</span>
                            <h5 class="layout-box-title-small">{{ $box7['title'] ?: 'Service 2' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box7['id'] }}')" class="layout-box-edit-small">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty layout-empty-small">
                    <i class="ri-service-line"></i>
                    <p class="text-xs">Service 2</p>
                    <span class="text-xs">#8</span>
                </div>
            @endif
        </div>
        
        <!-- Position 8: Service 3 -->
        <div class="layout-drop-zone" 
             data-position="8"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 8)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box8 = collect($layoutBoxes)->firstWhere('order', 8);
            @endphp
            @if($box8)
                <div class="layout-box layout-box-small" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box8['id'] }}')">
                    <div class="layout-box-content-compact">
                        @if($box8['image_preview'])
                            <img src="{{ $box8['image_preview'] }}" alt="{{ $box8['title'] }}" class="layout-box-image-small">
                        @endif
                        <div class="layout-box-info-compact">
                            <span class="layout-box-badge-small">#9</span>
                            <h5 class="layout-box-title-small">{{ $box8['title'] ?: 'Service 3' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box8['id'] }}')" class="layout-box-edit-small">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty layout-empty-small">
                    <i class="ri-service-line"></i>
                    <p class="text-xs">Service 3</p>
                    <span class="text-xs">#9</span>
                </div>
            @endif
        </div>
        
        <!-- Position 9: Service 4 -->
        <div class="layout-drop-zone" 
             data-position="9"
             x-data="{ isOver: false }"
             @dragover.prevent="isOver = true"
             @dragleave="isOver = false"
             @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 9)"
             :class="isOver ? 'border-primary bg-primary/5' : ''">
            @php
                $box9 = collect($layoutBoxes)->firstWhere('order', 9);
            @endphp
            @if($box9)
                <div class="layout-box layout-box-small" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box9['id'] }}')">
                    <div class="layout-box-content-compact">
                        @if($box9['image_preview'])
                            <img src="{{ $box9['image_preview'] }}" alt="{{ $box9['title'] }}" class="layout-box-image-small">
                        @endif
                        <div class="layout-box-info-compact">
                            <span class="layout-box-badge-small">#10</span>
                            <h5 class="layout-box-title-small">{{ $box9['title'] ?: 'Service 4' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box9['id'] }}')" class="layout-box-edit-small">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty layout-empty-small">
                    <i class="ri-service-line"></i>
                    <p class="text-xs">Service 4</p>
                    <span class="text-xs">#10</span>
                </div>
            @endif
        </div>
    </div>
</div>

