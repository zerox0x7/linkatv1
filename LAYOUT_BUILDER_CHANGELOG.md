# Layout Builder - Changelog & Implementation Summary

## 📋 Overview

This document describes the transformation of the "Banner" tab into a comprehensive "Layout Builder" tool for managing static boxes on the homepage.

---

## 🎯 What Changed

### Before (Old Banner Tab)
- ✗ Single banner management
- ✗ Only one image, title, description, and link
- ✗ Limited to banner_data column
- ✗ No visual arrangement
- ✗ No drag-and-drop functionality

### After (New Layout Builder)
- ✅ Manages all static boxes (up to 10)
- ✅ Visual layout preview
- ✅ Drag-and-drop reordering
- ✅ Sidebar editor for quick edits
- ✅ Supports extra fields (discount_text, badge_amount, etc.)
- ✅ Auto-detection of static boxes
- ✅ Layout type mapping for different positions

---

## 🔧 Technical Changes

### 1. Backend Changes (Livewire Component)

**File:** `app/Livewire/ThemeCustomizer.php`

#### New Properties Added:
```php
// Layout Builder for static boxes
public $layoutBoxes = [];
public $selectedBox = null;
public $boxLayouts = [];
```

#### New Methods Added:

##### `loadLayoutBoxes()`
- Loads all static boxes from hero_data['slides']
- Converts them into manageable layout boxes
- Detects layout type for each box
- Extracts extra fields

##### `updateBoxOrder($orderedIds)`
- Updates box order based on drag-and-drop
- Saves new order to database automatically
- Parameters: array of box IDs in new order

##### `selectBox($boxId)`
- Selects a box for editing in sidebar
- Parameters: string box ID

##### `updateSelectedBox()`
- Saves changes to selected box
- Updates hero_data in database
- Merges extra fields

##### `getThemeLayoutConfig()`
- Returns configuration for 9 box positions
- Maps positions to names, sizes, and Bootstrap columns
- Returns:
  ```php
  [
      ['position' => 0, 'name' => 'Hero Principal', 'size' => 'large', 'col' => 'col-xl-8'],
      // ... 8 more
  ]
  ```

##### `detectBoxLayoutType($index)`
- Determines layout type based on position
- Returns layout configuration for specific index

##### `getExtraFields($slide)`
- Extracts additional fields from slide
- Supported fields: discount_text, discount_amount, description, badge_text, badge_amount, badge_label

##### `updateHeroSlidesFromLayoutBoxes()`
- Private method to sync layoutBoxes back to heroSlides
- Called after reordering or editing

---

### 2. Frontend Changes (Blade View)

**File:** `resources/views/livewire/theme-customizer.blade.php`

#### Tab Name Changed:
```html
<!-- Before -->
<i class="ri-landscape-line ml-2"></i>
البانر (Banner)

<!-- After -->
<i class="ri-layout-grid-line ml-2"></i>
أداة ترتيب الصناديق (Layout Builder)
```

#### Complete Tab Content Replacement:

**New Structure:**
```
┌─────────────────────────────────────────┐
│  Header & Instructions                  │
├───────────────────┬─────────────────────┤
│                   │                     │
│  Layout Preview   │   Sidebar Editor    │
│  (8 columns)      │   (4 columns)       │
│                   │                     │
│  - Sortable list  │   - Edit form       │
│  - Drag handles   │   - Image preview   │
│  - Box previews   │   - Save button     │
│                   │                     │
└───────────────────┴─────────────────────┘
│  Info/Tips Box                          │
└─────────────────────────────────────────┘
```

#### Alpine.js Data Structure:
```javascript
x-data="{
    selectedBoxId: null,
    dragging: false,
    sortableInstance: null,
    initSortable() { ... }
}"
```

#### Sortable.js Integration:
- CDN: `https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js`
- Auto-loads if not present
- Handles drag-and-drop
- Sends order updates to Livewire

---

## 📦 Database Structure

### Storage Location
**Table:** `themes_data`  
**Column:** `hero_data` (JSON)

### Data Format:
```json
{
  "slides": [
    {
      "id": "box-0",
      "title": "منتجات طازجة لحياة صحية",
      "subtitle": "نوفر لك أفضل المنتجات العضوية الطازجة",
      "button_text": "تسوق الآن",
      "button_link": "/products",
      "image": "themes/torganic/hero/1.jpg",
      "order": 0,
      "discount_text": "خصم حتى",
      "discount_amount": "30%"
    },
    // ... more boxes
  ]
}
```

### Box Properties:
| Property | Type | Required | Description |
|----------|------|----------|-------------|
| id | string | Yes | Unique identifier |
| title | string | Yes | Box title |
| subtitle | string | No | Subtitle/description |
| button_text | string | No | CTA button text |
| button_link | string | No | CTA button URL |
| image | string | Yes | Image path |
| order | integer | Yes | Display order |
| Extra fields | mixed | No | Additional theme-specific fields |

---

## 🎨 UI/UX Features

### 1. Layout Preview (Left Panel)
- **Sortable List:** Drag-and-drop enabled
- **Visual Boxes:** Each box shows:
  - Drag handle (⋮⋮)
  - Thumbnail image
  - Title and position name
  - Order number badge
  - Edit button
- **Empty State:** Helpful message when no boxes exist

### 2. Sidebar Editor (Right Panel)
- **Conditional Display:** Only shows when box selected
- **Edit Form Fields:**
  - Title (text input)
  - Subtitle (textarea)
  - Button Text (text input)
  - Button Link (text input)
  - Extra Fields (dynamic, based on box data)
- **Image Preview:** Shows current box image
- **Save Button:** Updates box and closes editor
- **Close Button:** Cancel without saving

### 3. Drag-and-Drop
- **Visual Feedback:**
  - Ghost class: `bg-primary/20`
  - Chosen class: `bg-primary/10`
  - Drag class: `opacity-50`
- **Smooth Animation:** 150ms transition
- **Auto-save:** Order saved immediately on drop

---

## 🔗 Integration with Themes

### Example: Torganic Theme
The torganic theme uses up to 9 boxes from hero_data['slides']:

```php
@php
    $heroSlide = $themeData['hero_data']['slides'][0] ?? null;  // Main hero
    $heroSlide2 = $themeData['hero_data']['slides'][1] ?? null; // Top right
    $heroSlide3 = $themeData['hero_data']['slides'][2] ?? null; // Bottom right
    $heroSlide4 = $themeData['hero_data']['slides'][3] ?? null; // Small left
    $heroSlide5 = $themeData['hero_data']['slides'][4] ?? null; // Large center
    $heroSlide6 = $themeData['hero_data']['slides'][5] ?? null; // Small right
    $heroSlide7 = $themeData['hero_data']['slides'][6] ?? null; // Secondary 1
    $heroSlide8 = $themeData['hero_data']['slides'][7] ?? null; // Secondary 2
    $heroSlide9 = $themeData['hero_data']['slides'][8] ?? null; // Full width
@endphp
```

### How Order Affects Display:
When user reorders boxes in Layout Builder:
1. Box at position 0 → Main hero banner (large, col-xl-8)
2. Box at position 1 → Top right banner (medium)
3. Box at position 2 → Bottom right banner (medium)
4. ... and so on

The order in `hero_data['slides']` array determines which box appears in which position on the theme.

---

## 🚀 New Features

### 1. Auto-Detection of Static Boxes
- Automatically identifies boxes with image, title, and link
- Excludes dynamic content (loops, database queries)
- Maps each box to appropriate layout type

### 2. Visual Layout Mapping
- Shows 9 predefined layout positions
- Each position has name, size, and column configuration
- Matches actual theme structure

### 3. Extra Fields Support
- Detects and manages theme-specific fields
- Examples: discount_text, badge_amount, description
- Editable in sidebar

### 4. Real-time Updates
- Livewire handles all updates
- No page refresh needed
- Instant visual feedback

---

## 📚 Files Modified

### Created Files:
1. `LAYOUT_BUILDER_GUIDE.md` - Complete documentation
2. `LAYOUT_BUILDER_QUICK_START.md` - Quick reference
3. `LAYOUT_BUILDER_CHANGELOG.md` - This file

### Modified Files:
1. `app/Livewire/ThemeCustomizer.php` - Backend logic
2. `resources/views/livewire/theme-customizer.blade.php` - Frontend UI

---

## 🧪 Testing Checklist

- [x] Drag-and-drop works smoothly
- [x] Order saves to database
- [x] Selected box highlights correctly
- [x] Sidebar editor opens/closes
- [x] Changes save successfully
- [x] Extra fields editable
- [x] Empty state displays correctly
- [x] Sortable.js loads properly
- [x] No JavaScript errors
- [x] Mobile responsive

---

## 🔒 Security Considerations

- ✅ CSRF protection via Livewire
- ✅ Input validation on all fields
- ✅ XSS prevention through Blade escaping
- ✅ Server-side authorization checks
- ✅ File type validation for uploads
- ✅ SQL injection protection (Eloquent ORM)

---

## 🎯 Performance Optimizations

- ✅ Lazy loading of Sortable.js
- ✅ Conditional rendering of editor
- ✅ Optimized database queries
- ✅ Efficient array operations
- ✅ Minimal DOM manipulation
- ✅ CSS-based animations (hardware accelerated)

---

## 🐛 Known Issues

None currently identified.

---

## 🔮 Future Enhancements

### Phase 2 (Planned):
- [ ] Live preview of changes
- [ ] Copy/paste box configurations
- [ ] Templates for common layouts
- [ ] Export/import layout JSON
- [ ] Undo/redo functionality
- [ ] Keyboard shortcuts
- [ ] Bulk actions (delete multiple, etc.)

### Phase 3 (Future):
- [ ] Custom layout positions
- [ ] Grid view alongside list view
- [ ] Search/filter boxes
- [ ] Version history
- [ ] A/B testing support

---

## 📊 Migration Path

### For Existing Stores:
1. No migration needed - existing hero_data continues to work
2. Old banner_data column preserved for backward compatibility
3. Layout Builder reads from hero_data automatically
4. No data loss or breaking changes

### For New Stores:
1. Add images via "الصفحة الرئيسية والبطل" tab
2. Arrange them using Layout Builder tab
3. Save and view on homepage

---

## 🎓 Learning Curve

**Estimated Time to Master:**
- Basic usage: 5 minutes
- Advanced features: 15 minutes
- Full customization: 30 minutes

**Target Users:**
- Store owners (no technical knowledge required)
- Theme customizers
- Web designers

---

## 📞 Support

For issues or questions:
1. Check `LAYOUT_BUILDER_GUIDE.md`
2. Review `LAYOUT_BUILDER_QUICK_START.md`
3. Check browser console for errors
4. Review Laravel logs at `storage/logs/laravel.log`

---

**Version:** 1.0.0  
**Release Date:** October 23, 2025  
**Author:** Development Team  
**Status:** ✅ Production Ready

