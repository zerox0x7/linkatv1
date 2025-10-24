{{-- Torganic Theme Layout Simulation --}}
@props(['layoutBoxes'])

<div class="space-y-3">
    <!-- Row 1: Large Hero + 2 Side Boxes -->
    <div class="grid grid-cols-12 gap-3">
        <!-- Position 0: Hero Principal (Large) -->
        <div class="col-span-8 layout-drop-zone" 
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
                <div class="layout-box" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box0['id'] }}'); $event.dataTransfer.effectAllowed = 'move'">
                    <div class="layout-box-content">
                        @if($box0['image_preview'])
                            <img src="{{ $box0['image_preview'] }}" alt="{{ $box0['title'] }}" class="layout-box-image">
                        @else
                            <div class="layout-box-placeholder">
                                <i class="ri-image-line text-3xl"></i>
                            </div>
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#1</div>
                            <h5 class="layout-box-title">{{ $box0['title'] ?: 'Hero Principal' }}</h5>
                            <p class="layout-box-type">Hero Principal</p>
                            <button type="button" wire:click="selectBox('{{ $box0['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-2xl"></i>
                    <p>Hero Principal</p>
                    <span class="text-xs">#1 - Large</span>
                </div>
            @endif
        </div>
        
        <!-- Right Column with 2 boxes -->
        <div class="col-span-4 space-y-3">
            <!-- Position 1: Top Right -->
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
                    <div class="layout-box layout-box-small" draggable="true"
                         @dragstart="$event.dataTransfer.setData('boxId', '{{ $box1['id'] }}')">
                        <div class="layout-box-content-compact">
                            @if($box1['image_preview'])
                                <img src="{{ $box1['image_preview'] }}" alt="{{ $box1['title'] }}" class="layout-box-image-small">
                            @endif
                            <div class="layout-box-info-compact">
                                <span class="layout-box-badge-small">#2</span>
                                <h5 class="layout-box-title-small">{{ $box1['title'] ?: 'Top Right' }}</h5>
                                <button type="button" wire:click="selectBox('{{ $box1['id'] }}')" class="layout-box-edit-small">
                                    <i class="ri-edit-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="layout-empty layout-empty-small">
                        <i class="ri-drag-drop-line"></i>
                        <p class="text-xs">Top Right</p>
                        <span class="text-xs">#2</span>
                    </div>
                @endif
            </div>
            
            <!-- Position 2: Bottom Right -->
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
                    <div class="layout-box layout-box-small" draggable="true"
                         @dragstart="$event.dataTransfer.setData('boxId', '{{ $box2['id'] }}')">
                        <div class="layout-box-content-compact">
                            @if($box2['image_preview'])
                                <img src="{{ $box2['image_preview'] }}" alt="{{ $box2['title'] }}" class="layout-box-image-small">
                            @endif
                            <div class="layout-box-info-compact">
                                <span class="layout-box-badge-small">#3</span>
                                <h5 class="layout-box-title-small">{{ $box2['title'] ?: 'Bottom Right' }}</h5>
                                <button type="button" wire:click="selectBox('{{ $box2['id'] }}')" class="layout-box-edit-small">
                                    <i class="ri-edit-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="layout-empty layout-empty-small">
                        <i class="ri-drag-drop-line"></i>
                        <p class="text-xs">Bottom Right</p>
                        <span class="text-xs">#3</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Row 2: 3 Boxes (Small - Large - Small) -->
    <div class="grid grid-cols-12 gap-3">
        <!-- Position 3: Left Side -->
        <div class="col-span-3 layout-drop-zone" 
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
                <div class="layout-box layout-box-small" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box3['id'] }}')">
                    <div class="layout-box-content-compact">
                        @if($box3['image_preview'])
                            <img src="{{ $box3['image_preview'] }}" alt="{{ $box3['title'] }}" class="layout-box-image-small">
                        @endif
                        <div class="layout-box-info-compact">
                            <span class="layout-box-badge-small">#4</span>
                            <h5 class="layout-box-title-small">{{ $box3['title'] ?: 'Left Side' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box3['id'] }}')" class="layout-box-edit-small">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty layout-empty-small">
                    <i class="ri-drag-drop-line"></i>
                    <p class="text-xs">Left</p>
                    <span class="text-xs">#4</span>
                </div>
            @endif
        </div>
        
        <!-- Position 4: Center Large -->
        <div class="col-span-6 layout-drop-zone" 
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
                            <h5 class="layout-box-title">{{ $box4['title'] ?: 'Center Large' }}</h5>
                            <p class="layout-box-type">Large Center</p>
                            <button type="button" wire:click="selectBox('{{ $box4['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-2xl"></i>
                    <p>Center Large</p>
                    <span class="text-xs">#5</span>
                </div>
            @endif
        </div>
        
        <!-- Position 5: Right Side -->
        <div class="col-span-3 layout-drop-zone" 
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
                <div class="layout-box layout-box-small" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box5['id'] }}')">
                    <div class="layout-box-content-compact">
                        @if($box5['image_preview'])
                            <img src="{{ $box5['image_preview'] }}" alt="{{ $box5['title'] }}" class="layout-box-image-small">
                        @endif
                        <div class="layout-box-info-compact">
                            <span class="layout-box-badge-small">#6</span>
                            <h5 class="layout-box-title-small">{{ $box5['title'] ?: 'Right Side' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box5['id'] }}')" class="layout-box-edit-small">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty layout-empty-small">
                    <i class="ri-drag-drop-line"></i>
                    <p class="text-xs">Right</p>
                    <span class="text-xs">#6</span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Row 3: 2 Medium Boxes -->
    <div class="grid grid-cols-2 gap-3">
        <!-- Position 6 -->
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
                <div class="layout-box layout-box-medium" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box6['id'] }}')">
                    <div class="layout-box-content">
                        @if($box6['image_preview'])
                            <img src="{{ $box6['image_preview'] }}" alt="{{ $box6['title'] }}" class="layout-box-image">
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#7</div>
                            <h5 class="layout-box-title">{{ $box6['title'] ?: 'Secondary 1' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box6['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line"></i>
                    <p class="text-sm">Secondary 1</p>
                    <span class="text-xs">#7</span>
                </div>
            @endif
        </div>
        
        <!-- Position 7 -->
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
                <div class="layout-box layout-box-medium" draggable="true"
                     @dragstart="$event.dataTransfer.setData('boxId', '{{ $box7['id'] }}')">
                    <div class="layout-box-content">
                        @if($box7['image_preview'])
                            <img src="{{ $box7['image_preview'] }}" alt="{{ $box7['title'] }}" class="layout-box-image">
                        @endif
                        <div class="layout-box-info">
                            <div class="layout-box-badge">#8</div>
                            <h5 class="layout-box-title">{{ $box7['title'] ?: 'Secondary 2' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box7['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line"></i>
                    <p class="text-sm">Secondary 2</p>
                    <span class="text-xs">#8</span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Row 4: Full Width -->
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
            <div class="layout-box layout-box-large" draggable="true"
                 @dragstart="$event.dataTransfer.setData('boxId', '{{ $box8['id'] }}')">
                <div class="layout-box-content">
                    @if($box8['image_preview'])
                        <img src="{{ $box8['image_preview'] }}" alt="{{ $box8['title'] }}" class="layout-box-image">
                    @endif
                    <div class="layout-box-info">
                        <div class="layout-box-badge">#9</div>
                        <h5 class="layout-box-title">{{ $box8['title'] ?: 'Full Width Banner' }}</h5>
                        <p class="layout-box-type">Full Width</p>
                        <button type="button" wire:click="selectBox('{{ $box8['id'] }}')" class="layout-box-edit">
                            <i class="ri-edit-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="layout-empty">
                <i class="ri-drag-drop-line text-2xl"></i>
                <p>Full Width Banner</p>
                <span class="text-xs">#9 - Extra Large</span>
            </div>
        @endif
    </div>
</div>

