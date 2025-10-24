{{-- Minimal Theme Layout Simulation --}}
{{-- A simple 4-box layout: 1 large hero + 3 equal boxes --}}
@props(['layoutBoxes'])

<div class="space-y-4">
    <!-- Row 1: Full Width Hero -->
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
                        <img src="{{ $box0['image_preview'] }}" alt="{{ $box0['title'] }}" class="layout-box-image">
                    @else
                        <div class="layout-box-placeholder">
                            <i class="ri-image-line text-4xl"></i>
                        </div>
                    @endif
                    <div class="layout-box-info">
                        <div class="layout-box-badge">#1</div>
                        <h5 class="layout-box-title">{{ $box0['title'] ?: 'Hero Banner' }}</h5>
                        <p class="layout-box-type">Full Width Hero</p>
                        <button type="button" wire:click="selectBox('{{ $box0['id'] }}')" class="layout-box-edit">
                            <i class="ri-edit-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="layout-empty" style="min-height: 200px;">
                <i class="ri-drag-drop-line text-3xl"></i>
                <p class="text-lg">Full Width Hero</p>
                <span class="text-xs text-gray-500">#1 - Drag a box here</span>
            </div>
        @endif
    </div>
    
    <!-- Row 2: Three Equal Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Position 1 -->
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
                            <h5 class="layout-box-title">{{ $box1['title'] ?: 'Feature 1' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box1['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-xl"></i>
                    <p class="text-sm">Feature 1</p>
                    <span class="text-xs">#2</span>
                </div>
            @endif
        </div>
        
        <!-- Position 2 -->
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
                            <h5 class="layout-box-title">{{ $box2['title'] ?: 'Feature 2' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box2['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-xl"></i>
                    <p class="text-sm">Feature 2</p>
                    <span class="text-xs">#3</span>
                </div>
            @endif
        </div>
        
        <!-- Position 3 -->
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
                            <h5 class="layout-box-title">{{ $box3['title'] ?: 'Feature 3' }}</h5>
                            <button type="button" wire:click="selectBox('{{ $box3['id'] }}')" class="layout-box-edit">
                                <i class="ri-edit-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="layout-empty">
                    <i class="ri-drag-drop-line text-xl"></i>
                    <p class="text-sm">Feature 3</p>
                    <span class="text-xs">#4</span>
                </div>
            @endif
        </div>
    </div>
</div>

