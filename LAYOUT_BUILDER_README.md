# 🎨 Layout Builder - Visual Static Box Manager

## ✨ Feature Overview

The Layout Builder is a powerful drag-and-drop tool that replaces the old "Banner" tab, allowing store owners to visually arrange and manage all static boxes on their homepage without writing any code.

---

## 🎯 What It Does

### Old System (Banner Tab) ❌
```
┌─────────────────────┐
│   Single Banner     │
│   ┌──────────┐     │
│   │  Image   │     │
│   │  Title   │     │
│   │  Link    │     │
│   └──────────┘     │
└─────────────────────┘
```

### New System (Layout Builder) ✅
```
┌────────────────────────────────────────────────────────┐
│           Layout Builder - Visual Manager              │
├─────────────────────────────┬──────────────────────────┤
│  📋 Layout Preview          │  ✏️ Quick Editor         │
│                             │                          │
│  [⋮⋮] Box 1: Hero Principal │  Selected: Box 3         │
│       🖼️ [Image Preview]    │  ┌──────────────────┐   │
│       Order: #1             │  │ 🖼️ Image        │   │
│                             │  └──────────────────┘   │
│  [⋮⋮] Box 2: Top Banner     │  Title: ___________     │
│       🖼️ [Image Preview]    │  Subtitle: ________     │
│       Order: #2             │  Button: __________     │
│                             │  Link: ____________     │
│  [⋮⋮] Box 3: Side Banner    │                          │
│       🖼️ [Image Preview]    │  Extra Fields:          │
│       Order: #3             │  Discount: ________     │
│                             │                          │
│  ... (up to 10 boxes)       │  [💾 Save Changes]       │
│                             │                          │
└─────────────────────────────┴──────────────────────────┘
```

---

## 🚀 Key Features

### 1️⃣ Visual Layout Management
- See all boxes in one view
- Visual preview with thumbnails
- Clear position indicators (#1, #2, #3...)
- Layout type labels (Hero, Banner, etc.)

### 2️⃣ Drag-and-Drop Reordering
- Grab any box by the handle (⋮⋮)
- Drag to new position
- Drop to reorder
- Auto-saves instantly

### 3️⃣ Quick Sidebar Editor
- Click any box to edit
- See image preview
- Edit all fields inline
- Save with one click

### 4️⃣ Smart Detection
- Automatically finds static boxes
- Identifies box types
- Extracts extra fields
- Maps to layout positions

---

## 🎬 How It Works

### Flow Diagram
```
User Opens Layout Builder
         │
         ▼
System Loads Hero Data
(from themes_data.hero_data)
         │
         ▼
Detects Static Boxes
(only image + title + link)
         │
         ▼
Maps to Layout Types
(9 predefined positions)
         │
         ▼
┌────────┴────────┐
│                 │
▼                 ▼
User Drags Box    User Clicks Edit
│                 │
▼                 ▼
New Order Saved   Sidebar Opens
to Database       │
                  ▼
                  User Edits Content
                  │
                  ▼
                  Changes Saved
                  to Database
```

---

## 📊 Supported Box Types

### Static Boxes (Supported) ✅
```php
[
    'image' => 'path/to/image.jpg',
    'title' => 'Product Title',
    'subtitle' => 'Description',
    'button_text' => 'Shop Now',
    'button_link' => '/products',
    'extra_fields' => [
        'discount_text' => 'Save up to',
        'discount_amount' => '30%'
    ]
]
```

### Dynamic Content (Not Supported) ❌
- Product loops from database
- Category listings
- Dynamic carousels
- Real-time data

---

## 🎨 Layout Positions

### Position Map for Torganic Theme
```
┌─────────────────────────────────────────┐
│  Position 0: Hero Principal             │
│  (col-xl-8) - Large hero banner         │
│  ┌──────────────────────────────────┐   │
│  │                                  │   │
│  │     Main Hero Image              │   │
│  │     + Title + CTA                │   │
│  │                                  │   │
│  └──────────────────────────────────┘   │
└─────────────────────────────────────────┘

┌───────────────────┬───────────────────┐
│ Position 1:       │ Position 2:       │
│ Top Right Banner  │ Bottom Right      │
│ (col-md-6)        │ Banner            │
│ ┌──────────────┐  │ (col-md-6)        │
│ │   Image      │  │ ┌──────────────┐  │
│ │   + Text     │  │ │   Image      │  │
│ └──────────────┘  │ │   + Text     │  │
└───────────────────┴─│───────────────┘  │
                      └──────────────────┘

┌────────┬──────────────────┬────────┐
│Pos 3:  │  Position 4:     │Pos 5:  │
│Side L  │  Large Center    │Side R  │
│┌─────┐ │  ┌────────────┐  │┌─────┐ │
││Image│ │  │   Image    │  ││Image│ │
│└─────┘ │  │   + Promo  │  │└─────┘ │
└────────┴──│────────────┘──┴────────┘
            └───────────────┘

┌──────────────────┬──────────────────┐
│  Position 6:     │  Position 7:     │
│  Secondary 1     │  Secondary 2     │
│  (col-lg-6)      │  (col-lg-6)      │
│  ┌────────────┐  │  ┌────────────┐  │
│  │  Image     │  │  │  Image     │  │
│  └────────────┘  │  └────────────┘  │
└──────────────────┴──────────────────┘

┌─────────────────────────────────────┐
│  Position 8: Full Width Banner      │
│  (col-12)                           │
│  ┌────────────────────────────────┐ │
│  │    Wide Promotional Banner     │ │
│  └────────────────────────────────┘ │
└─────────────────────────────────────┘
```

---

## 💻 Technical Implementation

### Backend (Livewire)
```php
// New methods in ThemeCustomizer.php
- loadLayoutBoxes()          // Load boxes from DB
- updateBoxOrder($ids)        // Save new order
- selectBox($id)             // Select for editing
- updateSelectedBox()        // Save changes
- getThemeLayoutConfig()     // Get position map
- detectBoxLayoutType($idx)  // Detect type
- getExtraFields($slide)     // Extract extras
```

### Frontend (Blade + Alpine.js)
```html
<!-- Main components -->
<div x-data="{ sortableInstance: null }">
    <!-- Layout Preview Panel -->
    <div id="layout-boxes-container">
        @foreach($layoutBoxes as $box)
            <div data-box-id="{{ $box['id'] }}">
                <!-- Box preview -->
            </div>
        @endforeach
    </div>
    
    <!-- Sidebar Editor -->
    <div>
        <!-- Edit form -->
    </div>
</div>
```

### JavaScript (Sortable.js)
```javascript
Sortable.create(element, {
    animation: 150,
    handle: '.drag-handle',
    onEnd: (evt) => {
        const newOrder = getBoxIds();
        @this.updateBoxOrder(newOrder);
    }
});
```

---

## 🔄 Data Flow

### Reading Data
```
Database (themes_data.hero_data)
    ↓
ThemeCustomizer::loadData()
    ↓
ThemeCustomizer::loadLayoutBoxes()
    ↓
Blade View ($layoutBoxes)
    ↓
User Interface
```

### Saving Data
```
User Action (drag/edit)
    ↓
Livewire Method
    ↓
updateHeroSlidesFromLayoutBoxes()
    ↓
saveHeroSlides()
    ↓
Database (themes_data.hero_data)
    ↓
Theme Frontend (updated)
```

---

## 📱 Screenshots & Examples

### Example 1: Empty State
```
┌─────────────────────────────────────┐
│  📦 No boxes available              │
│                                     │
│  Start by adding images in the      │
│  "Hero Section" tab                 │
│                                     │
│  [Go to Hero Section →]             │
└─────────────────────────────────────┘
```

### Example 2: Filled State
```
┌─────────────────────────────────────┐
│  [⋮⋮] #1 Hero Principal             │
│      🖼️ [Organic Products]          │
│      "Fresh Organic Products"       │
│      /products                       │
│                          [Edit ✏️]  │
├─────────────────────────────────────┤
│  [⋮⋮] #2 Top Banner                 │
│      🖼️ [30% Discount]              │
│      "30% Off Special"              │
│      /offers                         │
│                          [Edit ✏️]  │
└─────────────────────────────────────┘
```

### Example 3: Editor Sidebar
```
┌─────────────────────────┐
│  ✏️ Edit Box            │
│  ╔═══════════════════╗  │
│  ║   🖼️ Preview      ║  │
│  ╚═══════════════════╝  │
│                         │
│  Title:                 │
│  [Fresh Products____]   │
│                         │
│  Subtitle:              │
│  [Organic & Healthy_]   │
│                         │
│  Button Text:           │
│  [Shop Now_________]    │
│                         │
│  Button Link:           │
│  [/products________]    │
│                         │
│  Extra Fields:          │
│  Discount: [30%____]    │
│                         │
│  [💾 Save Changes]      │
└─────────────────────────┘
```

---

## 🎯 Use Cases

### Use Case 1: Seasonal Promotion
**Scenario:** Store wants to promote Christmas sale as main hero

**Steps:**
1. Open Layout Builder
2. Drag "Christmas Sale" box to position #1
3. Edit to update discount percentage
4. Save - appears immediately on homepage

### Use Case 2: New Product Launch
**Scenario:** Launch new product line with prominent banner

**Steps:**
1. Add new image in Hero Section
2. Open Layout Builder
3. Drag new box to position #4 (large center)
4. Edit title and link
5. Save - product prominently displayed

### Use Case 3: Rebranding
**Scenario:** Update all box titles to match new brand voice

**Steps:**
1. Open Layout Builder
2. Click each box's edit button
3. Update titles one by one
4. Save each change
5. All boxes reflect new branding

---

## ✅ Benefits

### For Store Owners
- 🎨 **Visual Control:** See exactly what will appear
- ⚡ **Fast Updates:** No coding or technical knowledge needed
- 🎯 **Precise Placement:** Control exact order of elements
- 📱 **Instant Preview:** See changes before publishing

### For Developers
- 🏗️ **Clean Architecture:** Separation of concerns
- 🔄 **Maintainable Code:** Well-documented methods
- 🛡️ **Type Safety:** Strong validation
- 🚀 **Performance:** Optimized queries

### For Designers
- 🎨 **Creative Freedom:** Easy experimentation
- 📐 **Layout Control:** Precise positioning
- 🖼️ **Image Management:** Visual preview
- 🎭 **Flexible Styling:** Support for extra fields

---

## 📚 Documentation

- 📖 **Complete Guide:** [LAYOUT_BUILDER_GUIDE.md](LAYOUT_BUILDER_GUIDE.md)
- 🚀 **Quick Start:** [LAYOUT_BUILDER_QUICK_START.md](LAYOUT_BUILDER_QUICK_START.md)
- 📝 **Changelog:** [LAYOUT_BUILDER_CHANGELOG.md](LAYOUT_BUILDER_CHANGELOG.md)

---

## 🎓 Training Resources

### Video Tutorials (Coming Soon)
- [ ] Basic usage walkthrough
- [ ] Advanced reordering techniques
- [ ] Troubleshooting common issues

### Written Guides
- [x] Installation guide
- [x] User manual
- [x] Developer documentation
- [x] Quick reference card

---

## 🌟 Success Metrics

After implementation, stores can:
- ✅ Update homepage layout in < 5 minutes
- ✅ Manage up to 10 promotional boxes
- ✅ Reorder without technical support
- ✅ Make changes without code deployment

---

**Version:** 1.0.0  
**Status:** ✅ Production Ready  
**Last Updated:** October 23, 2025

