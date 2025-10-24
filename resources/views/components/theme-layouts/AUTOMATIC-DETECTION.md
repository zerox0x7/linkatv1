# Automatic Theme Layout Detection

## 🎉 What Changed

The layout builder now **automatically detects** your active theme and loads the correct layout simulation!

### Before (Manual)
```php
$currentTheme = 'torganic'; // Had to manually change this
```

### After (Automatic) ✅
```php
$activeTheme = \App\Models\Setting::get('active_theme', 'torganic');
$currentTheme = strtolower($activeTheme); // Auto-detects from database
```

## How It Works

1. **System reads active theme** from database (`settings` table)
2. **Converts to lowercase** for file matching
3. **Loads matching layout** component automatically

### Example Flow

```
Database: active_theme = "GreenGame"
    ↓
Convert to lowercase: "greengame"
    ↓
Look for file: greengame.blade.php
    ↓
Load layout: GreenGame layout (10 positions)
    ✓ Success!
```

## Visual Debug Info

When you open the Layout Builder tab, you'll now see a **blue info box** showing:

```
ℹ️ Active Theme: GreenGame  Looking for: components.theme-layouts.greengame
```

This helps you verify:
- ✅ What theme is active in your database
- ✅ What layout file the system is looking for
- ✅ If there's a mismatch, you can fix it immediately

## File Naming Rules

**Critical:** Layout files MUST match this pattern:

| Your Theme Name | Required Filename |
|-----------------|-------------------|
| `Torganic` | `torganic.blade.php` |
| `GreenGame` | `greengame.blade.php` |
| `Minimal` | `minimal.blade.php` |
| `MyAwesomeTheme` | `myawesometheme.blade.php` |

**Rule:** Lowercase + `.blade.php`

## What You Need to Do

### ✅ If your theme is GreenGame, Torganic, or Minimal
**Nothing!** Just refresh the page. The correct layout will load automatically.

### 📝 If you have a custom theme
Create a layout file with the lowercase name:

```bash
# Your theme: "MyTheme"
# Create file: mytheme.blade.php

cd resources/views/components/theme-layouts/
cp torganic.blade.php mytheme.blade.php
# Then customize mytheme.blade.php for your layout
```

## Troubleshooting

### Red Error Message?

If you see:
```
⚠️ Theme layout component not found
Looking for: components.theme-layouts.mytheme
```

**Fix:**
1. Check the filename matches (lowercase)
2. Verify the file exists in `resources/views/components/theme-layouts/`
3. Run `php artisan view:clear` to clear cache

### Wrong Layout Showing?

**Check:**
1. Go to Settings → Theme Settings
2. Verify which theme is marked as "active"
3. The layout builder uses whatever theme is active there

### Still Having Issues?

The debug info box (blue) shows exactly what the system is looking for. Match your filename to what it says!

## Benefits

✅ **No manual updates needed** - Switch themes, layout follows  
✅ **Developer-friendly** - Clear debug information  
✅ **Error-proof** - Shows exactly what's wrong if it fails  
✅ **Scalable** - Add new themes without touching core code  
✅ **Automatic** - Just works!  

## Example Scenarios

### Scenario 1: Switching from Torganic to GreenGame

**Before:**
1. Change active theme to GreenGame
2. ❌ Layout builder still shows Torganic (had to manually edit code)

**Now:**
1. Change active theme to GreenGame
2. ✅ Layout builder automatically shows GreenGame layout!

### Scenario 2: Adding a New Theme

**Before:**
1. Create new theme files
2. Create layout component
3. ❌ Edit theme-customizer.blade.php to hardcode new theme
4. Test and debug

**Now:**
1. Create new theme files
2. Create layout component (lowercase name)
3. ✅ Automatically works! No code edits needed
4. Debug info shows what's happening

## Technical Details

### Code Location
File: `resources/views/livewire/theme-customizer.blade.php`  
Lines: 420-446

### What Changed
- Added `Setting::get('active_theme')` to read from database
- Added `strtolower()` for case-insensitive file matching
- Added debug information box
- Added better error messages

### Database Query
```php
\App\Models\Setting::get('active_theme', 'torganic')
```

Reads from `settings` table where `key = 'active_theme'`

## For Developers

### Adding New Themes

1. **Create layout file:**
   ```bash
   touch resources/views/components/theme-layouts/mynewtheme.blade.php
   ```

2. **Copy template:**
   ```bash
   cp greengame.blade.php mynewtheme.blade.php
   ```

3. **Customize positions** in the new file

4. **Set as active:**
   ```php
   Setting::set('active_theme', 'MyNewTheme');
   ```

5. **Done!** Layout builder automatically uses it

### Testing Multiple Layouts

No need to change code! Just change the active theme in settings and refresh.

## Questions?

See the other documentation files:
- `README.md` - Full technical documentation
- `USAGE.md` - Quick setup guide
- `LAYOUT-COMPARISON.md` - Compare different layouts

---

**Last Updated:** October 23, 2025  
**Feature:** Automatic Theme Detection v1.0

