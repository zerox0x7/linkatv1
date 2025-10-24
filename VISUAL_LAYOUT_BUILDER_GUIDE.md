# 🎨 Visual Layout Builder - Complete Guide

## ✨ What Changed

The Layout Builder now displays a **visual grid** that simulates your actual theme layout, with drag-and-drop functionality to arrange boxes.

---

## 🖼️ Visual Layout Structure

### The Grid Layout (Left Panel - 8 columns)

```
┌─────────────────────────────────────────────────────────────┐
│                  تخطيط الصفحة الرئيسية                      │
│         اسحب الصناديق من اليمين وأفلتها هنا                 │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌───────────────────────────────┬──────────────────────┐   │
│  │                               │  ┌────────────────┐  │   │
│  │   Position 0: Hero Principal  │  │  Position 1:   │  │   │
│  │   (Large - 8 columns)         │  │   Top Right    │  │   │
│  │   #1                          │  │   (Small)      │  │   │
│  │   ┌─────────────────────────┐ │  │   #2           │  │   │
│  │   │    [Drag Box Here]      │ │  └────────────────┘  │   │
│  │   │  or Box Thumbnail       │ │  ┌────────────────┐  │   │
│  │   └─────────────────────────┘ │  │  Position 2:   │  │   │
│  │                               │  │  Bottom Right  │  │   │
│  │                               │  │  (Small) #3    │  │   │
│  └───────────────────────────────┴──└────────────────┘──┘   │
│                                                             │
│  ┌────────┬─────────────────────────────────┬────────────┐  │
│  │Position│  Position 4: Center Large      │  Position  │  │
│  │ 3: L   │  (Large - 6 columns)           │  5: R      │  │
│  │ #4     │  #5                            │  #6        │  │
│  │┌─────┐ │  ┌──────────────────────────┐  │  ┌──────┐ │  │
│  ││     │ │  │   [Drag Box Here]        │  │  │      │ │  │
│  │└─────┘ │  └──────────────────────────┘  │  └──────┘ │  │
│  └────────┴─────────────────────────────────┴────────────┘  │
│                                                             │
│  ┌──────────────────────────┬──────────────────────────┐   │
│  │  Position 6: Secondary 1 │  Position 7: Secondary 2 │   │
│  │  (Medium) #7             │  (Medium) #8             │   │
│  │  ┌────────────────────┐  │  ┌────────────────────┐  │   │
│  │  │  [Drag Box Here]   │  │  │  [Drag Box Here]   │  │   │
│  │  └────────────────────┘  │  └────────────────────┘  │   │
│  └──────────────────────────┴──────────────────────────┘   │
│                                                             │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Position 8: Full Width Banner (XL) #9               │  │
│  │  ┌────────────────────────────────────────────────┐  │  │
│  │  │        [Drag Box Here or Box Thumbnail]        │  │  │
│  │  └────────────────────────────────────────────────┘  │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### Available Boxes Sidebar (Right Panel - 4 columns)

```
┌────────────────────────────┐
│    الصناديق المتاحة        │
├────────────────────────────┤
│                            │
│  ┌──────────────────────┐  │
│  │ 🖼️  Box 1            │  │
│  │     Fresh Products   │  │
│  │     في الموضع #1    │  │
│  │              ⋮⋮      │  │
│  └──────────────────────┘  │
│                            │
│  ┌──────────────────────┐  │
│  │ 🖼️  Box 2            │  │
│  │     30% Discount     │  │
│  │     في الموضع #2    │  │
│  │              ⋮⋮      │  │
│  └──────────────────────┘  │
│                            │
│  ┌──────────────────────┐  │
│  │ 🖼️  Box 3            │  │
│  │     New Arrivals     │  │
│  │     غير مخصص        │  │
│  │              ⋮⋮      │  │
│  └──────────────────────┘  │
│                            │
│  ... (more boxes)          │
│                            │
│  ───────────────────────   │
│  ℹ️ اسحب وأفلت في         │
│     الموضع المطلوب        │
└────────────────────────────┘
```

---

## 🎯 How It Works

### Step 1: View Your Layout
- Open the "Layout Builder" tab
- See all 9 positions arranged exactly as they appear on your theme
- Empty positions show dashed borders with placeholder text

### Step 2: Drag Boxes from Sidebar
1. Look at the right sidebar - all your boxes are listed there
2. Click and hold on any box (grab the ⋮⋮ handle)
3. Drag it over to a position on the left grid
4. When you hover over a valid drop zone, it will highlight in blue
5. Release to drop the box

### Step 3: Swap Positions
- If you drop a box on an occupied position, the boxes will **swap**
- Example: Drag Box #3 to Position #1 → They trade places
- This makes reordering very easy!

### Step 4: Edit Content
- Click the edit button (✏️) on any placed box
- The editor opens in the sidebar
- Make your changes and click "Save"

---

## 🎨 Visual States

### Empty Position (No Box Assigned)
```
┌─────────────────────────────┐
│                             │
│     ⬇️ Drag & Drop          │
│                             │
│   Hero Principal            │
│   #1 - Large                │
│                             │
└─────────────────────────────┘
```
- Dashed border
- Icon and label
- Position number

### Filled Position (Box Assigned)
```
┌─────────────────────────────┐
│ ┌─────────────────────────┐ │
│ │   [Box Image Preview]   │ │
│ └─────────────────────────┘ │
│ #1    Fresh Products        │
│       Hero Principal        │
│                      [Edit] │
└─────────────────────────────┘
```
- Solid border
- Box image preview
- Title and type
- Edit button

### Hover State (Dragging Over)
```
┌═════════════════════════════┐ ← Blue border
║                             ║
║     ⬇️ Drop Here            ║ ← Blue background
║                             ║
║   Hero Principal            ║
║   #1 - Large                ║
║                             ║
└═════════════════════════════┘
```
- Border changes to primary color
- Light background overlay

---

## 📱 Responsive Design

### Desktop (Large Screens)
```
┌─────────────────────┬──────────┐
│                     │          │
│   Visual Grid       │ Sidebar  │
│   (8 columns)       │(4 cols)  │
│                     │          │
└─────────────────────┴──────────┘
```

### Tablet/Mobile
```
┌──────────────────────┐
│   Visual Grid        │
│   (Full Width)       │
└──────────────────────┘
┌──────────────────────┐
│   Sidebar            │
│   (Full Width)       │
└──────────────────────┘
```

---

## 🔄 Data Flow

### When You Drag and Drop:

```
1. User grabs box from sidebar
   ↓
2. Drags over layout grid
   ↓
3. Grid position highlights (blue)
   ↓
4. User releases (drops)
   ↓
5. Livewire method: moveBoxToPosition()
   ↓
6. Check if position occupied
   ↓
   YES → Swap boxes
   NO  → Place box
   ↓
7. Update database (hero_data)
   ↓
8. Refresh view
   ↓
9. Success message shown
```

---

## 🎯 Position Map

| Position | Name | Size | Bootstrap Class | Theme Usage |
|----------|------|------|----------------|-------------|
| 0 | Hero Principal | Large | col-xl-8 | Main hero banner |
| 1 | Top Right | Small | col-md-6 col-xl-12 | Side promo 1 |
| 2 | Bottom Right | Small | col-md-6 col-xl-12 | Side promo 2 |
| 3 | Left Side | Small | col-xl-3 col-md-6 | Product highlight 1 |
| 4 | Center Large | Large | col-xl-6 col-lg-12 | Main promotional banner |
| 5 | Right Side | Small | col-xl-3 col-md-6 | Product highlight 2 |
| 6 | Secondary 1 | Medium | col-lg-6 | Category banner 1 |
| 7 | Secondary 2 | Medium | col-lg-6 | Category banner 2 |
| 8 | Full Width | XL | col-12 | Campaign banner |

---

## 🎨 CSS Classes Reference

### Layout Structure
- `.layout-drop-zone` - Droppable area
- `.layout-empty` - Empty slot placeholder
- `.layout-box` - Filled box container

### Box Sizes
- `.layout-box-small` - Small boxes (positions 1,2,3,5)
- `.layout-box-medium` - Medium boxes (positions 6,7)
- `.layout-box-large` - Large boxes (positions 0,4,8)

### Visual Elements
- `.layout-box-image` - Box image (120px height)
- `.layout-box-image-small` - Small box image (48px)
- `.layout-box-badge` - Position number badge
- `.layout-box-title` - Box title text
- `.layout-box-edit` - Edit button

---

## 💡 Tips & Tricks

### Tip 1: Quick Reordering
Instead of dragging from sidebar, you can:
- Drag box #1 to position #5
- Drag box #5 to position #1
- They swap instantly!

### Tip 2: Visual Feedback
- **Solid Border** = Box is placed
- **Dashed Border** = Empty slot
- **Blue Highlight** = Drop zone active

### Tip 3: Status Indicator
Look at the sidebar box status:
- **Green text**: "في الموضع #X" = Box is placed
- **Gray text**: "غير مخصص" = Box not assigned

### Tip 4: Edit Shortcut
Click the ✏️ button directly on any box in the grid - no need to find it in the sidebar!

---

## 🚀 Example Workflow

### Scenario: Rearrange Homepage for Sale Event

**Step 1:** You have these boxes:
- Box A: Summer Sale (currently #1)
- Box B: New Products (currently #2)
- Box C: Flash Deals (currently #3)

**Step 2:** You want Flash Deals as the main hero:
1. Drag "Box C: Flash Deals" from sidebar
2. Drop on Position #0 (Hero Principal)
3. It swaps with Box A

**Step 3:** Result:
- Position #0: Flash Deals ✅
- Position #1: Summer Sale (swapped from #0)
- Position #2: New Products (unchanged)

**Time taken:** 5 seconds! 🎉

---

## 🎭 Visual Examples

### Example 1: Fresh Install (No Boxes)
```
All 9 positions show empty placeholders:
  [#1 Hero] [#2 Top R]
  [#3 Bot R]
  [#4 L] [#5 Center] [#6 R]
  [#7 Sec1] [#8 Sec2]
  [#9 Full Width]

Sidebar: "لا توجد صناديق متاحة"
Action: Add boxes in Hero Section first
```

### Example 2: Partially Filled
```
Positions filled:
  [Box 1✓] [Empty #2]
  [Empty #3]
  [Box 2✓] [Box 3✓] [Empty #6]
  [Empty #7] [Empty #8]
  [Empty #9]

Sidebar: Shows Box 1, Box 2, Box 3
Action: Drag to fill empty positions
```

### Example 3: Fully Filled
```
All positions occupied:
  [Box 1✓] [Box 2✓]
  [Box 3✓]
  [Box 4✓] [Box 5✓] [Box 6✓]
  [Box 7✓] [Box 8✓]
  [Box 9✓]

Sidebar: Shows all 9 boxes
Action: Drag between positions to reorder
```

---

## 🔧 Technical Details

### Backend Method
```php
public function moveBoxToPosition($boxId, $newPosition)
{
    // Find box
    // Check current position
    // Find box at target position
    // Swap if occupied
    // Update orders
    // Save to database
    // Flash success message
}
```

### Frontend Events
```javascript
@dragstart - User starts dragging
@dragover - User drags over drop zone
@dragleave - User leaves drop zone
@drop - User releases (drops) box
```

### Data Transfer
```javascript
dataTransfer.setData('boxId', '...')
// Carries box ID during drag
```

---

## ✅ Feature Checklist

- [x] Visual grid matching theme layout
- [x] 9 predefined positions
- [x] Drag from sidebar to grid
- [x] Drag between grid positions (swap)
- [x] Visual feedback (borders, highlights)
- [x] Position numbers (#1-#9)
- [x] Box thumbnails and previews
- [x] Edit button on each box
- [x] Sidebar editor
- [x] Status indicators
- [x] Responsive design
- [x] Auto-save on drop
- [x] Success messages

---

## 🎓 User Guide

**For Beginners:**
1. Add images in "Hero Section" tab first
2. Go to "Layout Builder" tab
3. See your boxes in the right sidebar
4. Drag any box to the grid on the left
5. Drop it in a position
6. Done! Changes save automatically

**For Advanced Users:**
- Swap boxes between positions for quick reordering
- Use edit button for inline content changes
- Check position status in sidebar
- Understand position numbers (#1-#9) for consistent layout

---

**Created:** October 23, 2025  
**Version:** 2.0.0  
**Status:** ✅ Enhanced Visual Layout Builder

