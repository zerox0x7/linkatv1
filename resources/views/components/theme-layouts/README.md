# Theme Layout Components

This directory contains layout simulation components for different themes. Each theme has its own layout file that defines how boxes are arranged on the homepage.

## Directory Structure

```
theme-layouts/
├── README.md           # This file
├── torganic.blade.php  # Torganic theme layout (9 positions)
├── greengame.blade.php # GreenGame theme layout (10 positions)
├── minimal.blade.php   # Minimal theme layout (4 positions)
└── [other-theme].blade.php # Add new theme layouts here
```

## How to Add a New Theme Layout

### Step 1: Create a New Layout File

Create a new Blade component file in this directory. **Important:** The filename must be the **lowercase** version of your theme name:

```bash
# If your theme is "MyTheme" in the database, create:
touch resources/views/components/theme-layouts/mytheme.blade.php

# If your theme is "GreenGame", the file should be:
# greengame.blade.php (already exists)
```

**Naming Convention:**
- Theme name in database: `GreenGame` → File: `greengame.blade.php`
- Theme name in database: `Torganic` → File: `torganic.blade.php`
- Theme name in database: `MyCustomTheme` → File: `mycustomtheme.blade.php`

### Step 2: Define Your Layout Structure

Your layout component should:
- Accept `$layoutBoxes` as a prop
- Define drop zones with `data-position` attributes (0-8 or as many as you need)
- Include drag-and-drop functionality
- Style boxes appropriately for your theme

#### Basic Template:

```blade
{{-- My Theme Layout Simulation --}}
@props(['layoutBoxes'])

<div class="space-y-3">
    <!-- Define your layout structure here -->
    
    <!-- Example: Single position -->
    <div class="layout-drop-zone" 
         data-position="0"
         x-data="{ isOver: false }"
         @dragover.prevent="isOver = true"
         @dragleave="isOver = false"
         @drop.prevent="isOver = false; $event.dataTransfer.getData('boxId') && $wire.moveBoxToPosition($event.dataTransfer.getData('boxId'), 0)"
         :class="isOver ? 'border-primary bg-primary/5' : ''">
        @php
            $box = collect($layoutBoxes)->firstWhere('order', 0);
        @endphp
        @if($box)
            <div class="layout-box" draggable="true"
                 @dragstart="$event.dataTransfer.setData('boxId', '{{ $box['id'] }}')">
                <!-- Box content -->
                <div class="layout-box-content">
                    @if($box['image_preview'])
                        <img src="{{ $box['image_preview'] }}" alt="{{ $box['title'] }}" class="layout-box-image">
                    @endif
                    <div class="layout-box-info">
                        <h5 class="layout-box-title">{{ $box['title'] ?: 'Box Title' }}</h5>
                        <button type="button" wire:click="selectBox('{{ $box['id'] }}')" class="layout-box-edit">
                            <i class="ri-edit-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="layout-empty">
                <i class="ri-drag-drop-line text-2xl"></i>
                <p>Empty Position</p>
            </div>
        @endif
    </div>
    
    <!-- Add more positions as needed -->
</div>
```

### Step 3: Update Theme Customizer

In `theme-customizer.blade.php`, update the `$currentTheme` variable to use your new theme:

```php
$currentTheme = 'mytheme'; // Change from 'torganic' to your theme name
```

**Or** make it dynamic by reading from settings:

```php
$currentTheme = settings('active_theme', 'torganic');
```

## Available CSS Classes

The theme customizer includes predefined CSS classes for layout styling:

### Drop Zones
- `.layout-drop-zone` - Drop zone container with border and hover effects

### Box Containers
- `.layout-box` - Basic box container
- `.layout-box-small` - Small box (min-height: 80px)
- `.layout-box-medium` - Medium box (min-height: 100px)
- `.layout-box-large` - Large box (min-height: 120px)

### Box Content
- `.layout-box-content` - Full box content wrapper
- `.layout-box-content-compact` - Compact content (flex layout)
- `.layout-box-image` - Full-size image (120px height)
- `.layout-box-image-small` - Small thumbnail (48px)
- `.layout-box-placeholder` - Placeholder when no image

### Box Info
- `.layout-box-info` - Box information wrapper
- `.layout-box-info-compact` - Compact info layout
- `.layout-box-title` - Box title
- `.layout-box-title-small` - Small title
- `.layout-box-type` - Box type label
- `.layout-box-badge` - Position badge
- `.layout-box-badge-small` - Small position badge

### Empty States
- `.layout-empty` - Empty drop zone state
- `.layout-empty-small` - Small empty state

### Buttons
- `.layout-box-edit` - Edit button
- `.layout-box-edit-small` - Small edit button

## Layout Examples

### Torganic Theme Layout

The torganic theme uses a 9-position layout:
- Position 0: Large hero (8 columns)
- Positions 1-2: Right sidebar (4 columns, stacked)
- Position 3: Left small (3 columns)
- Position 4: Center large (6 columns)
- Position 5: Right small (3 columns)
- Positions 6-7: Two medium boxes (6 columns each)
- Position 8: Full-width banner (12 columns)

### GreenGame Theme Layout

The greenGame theme uses a 10-position gaming-focused layout:
- Position 0: Full-width hero banner (gaming hero)
- Positions 1-3: Featured games row (3 equal columns)
- Positions 4-5: Trending/brand section (2 large columns)
- Positions 6-9: Services/promo section (4 small columns)

### Minimal Theme Layout

The minimal theme uses a 4-position simple layout:
- Position 0: Full-width hero
- Positions 1-3: Three equal feature boxes

### Custom Layout Ideas

1. **Grid Layout**: Equal-sized boxes in a grid
2. **Masonry Layout**: Pinterest-style layout
3. **Single Column**: Stack boxes vertically
4. **Magazine Layout**: Mixed sizes for editorial content
5. **Minimalist**: Few large boxes with lots of whitespace

## Best Practices

1. **Consistent Positioning**: Use sequential `data-position` attributes starting from 0
2. **Responsive Design**: Use Tailwind's responsive classes (`sm:`, `md:`, `lg:`, `xl:`)
3. **Fallback State**: Always include an empty state for unfilled positions
4. **Image Handling**: Check for `image_preview` before displaying
5. **Wire Actions**: Include `wire:click="selectBox()"` for editing functionality
6. **Drag & Drop**: Maintain consistent drag handlers and drop zones

## Troubleshooting

### Layout Not Loading
- Check file name matches theme name exactly
- Verify file is in the correct directory
- Check for PHP/Blade syntax errors

### Boxes Not Draggable
- Ensure `draggable="true"` is set
- Verify Alpine.js drag handlers are present
- Check that Sortable.js is loaded

### Styling Issues
- CSS classes are defined in `theme-customizer.blade.php` `<style>` section
- Add custom styles in your layout file if needed
- Use Tailwind utility classes for quick styling

## Questions?

For questions or issues, refer to the main theme customizer component or documentation.

