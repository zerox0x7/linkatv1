# Theme Customization System Guide

## Overview
This system allows store owners to customize their active theme with extra images, data, and styling without modifying the theme files directly.

## Features
- **Hero Section Images**: Upload and manage hero/banner images
- **Banner Section**: Custom banner images and text
- **Custom Data Fields**: Add any custom key-value pairs for theme-specific data
- **Custom CSS/JS**: Inject custom styling and scripts
- **Per-Store Configuration**: Each store can have its own theme customizations

## Database Structure

### Table: `themes_data`
```sql
- id (primary key)
- store_id (nullable, for multi-store support)
- theme_name (the name of the theme)
- hero_data (JSON - hero section images and data)
- banner_data (JSON - banner images and data)
- feature_data (JSON - feature section data)
- extra_images (JSON - additional theme images)
- custom_data (JSON - other custom theme data)
- custom_css (text - custom CSS)
- custom_js (text - custom JavaScript)
- is_active (boolean)
- timestamps
```

## Admin Panel Access

### Location in Sidebar
Navigate to: **Themes (الثيمات) → Active Theme Customize (تخصيص الثيم النشط)**

### Features Available:
1. **Hero Section Tab**
   - Upload hero main image
   - Set hero title, description
   - Configure button text and link

2. **Banner Section Tab**
   - Upload banner image
   - Set banner title, description, link

3. **Custom Data Tab**
   - Add unlimited custom key-value pairs
   - Example: `secondary_color` → `#ff5733`
   - Example: `show_promo` → `true`

4. **CSS/JS Tab**
   - Add custom CSS styling
   - Add custom JavaScript code

## Using Theme Data in Your Theme

### In Blade Templates

#### Get Theme Data Instance
```php
@php
    $storeId = auth()->user()->store_id ?? null;
    $activeTheme = \App\Models\Setting::get('active_theme', 'default');
    $themeData = \App\Models\ThemeData::getByStoreAndTheme($storeId, $activeTheme);
@endphp
```

#### Display Hero Image
```php
@if($themeData && $themeData->getHeroImage())
    <img src="{{ $themeData->getHeroImage() }}" alt="Hero Image">
@endif
```

#### Display Hero Title
```php
@if($themeData && $themeData->hero_data)
    <h1>{{ $themeData->hero_data['title'] ?? 'Default Title' }}</h1>
    <p>{{ $themeData->hero_data['description'] ?? '' }}</p>
@endif
```

#### Display Banner Image
```php
@if($themeData && $themeData->getBannerImage())
    <img src="{{ $themeData->getBannerImage() }}" alt="Banner">
@endif
```

#### Get Custom Data
```php
@php
    $secondaryColor = $themeData?->getCustomData('secondary_color', '#3b82f6');
    $showPromo = $themeData?->getCustomData('show_promo', false);
@endphp

<style>
    :root {
        --secondary-color: {{ $secondaryColor }};
    }
</style>

@if($showPromo)
    <div class="promo-banner">
        <!-- Promo content -->
    </div>
@endif
```

#### Inject Custom CSS/JS
```php
@if($themeData && $themeData->custom_css)
    <style>
        {!! $themeData->custom_css !!}
    </style>
@endif

@if($themeData && $themeData->custom_js)
    <script>
        {!! $themeData->custom_js !!}
    </script>
@endif
```

### In Controllers

```php
use App\Models\ThemeData;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $storeId = auth()->user()->store_id ?? null;
        $activeTheme = Setting::get('active_theme', 'default');
        $themeData = ThemeData::getByStoreAndTheme($storeId, $activeTheme);
        
        return view('themes.home', compact('themeData'));
    }
}
```

## Available Model Methods

### ThemeData Model

#### Static Methods
- `ThemeData::getActiveThemeData($storeId, $themeName)` - Get active theme data
- `ThemeData::getByStoreAndTheme($storeId, $themeName)` - Get specific theme data

#### Instance Methods - Getters
- `$themeData->getHeroImage($key = 'main_image')` - Get hero image URL
- `$themeData->getBannerImage($key = 'main_image')` - Get banner image URL
- `$themeData->getExtraImage($key)` - Get extra image URL by key
- `$themeData->getCustomData($key, $default = null)` - Get custom data value

#### Instance Methods - Setters
- `$themeData->setHeroData(array $data)` - Update hero data
- `$themeData->setBannerData(array $data)` - Update banner data
- `$themeData->setExtraImage($key, $path)` - Set extra image
- `$themeData->setCustomData($key, $value)` - Set custom data field

## Example: Complete Theme Integration

```php
{{-- resources/views/themes/yourtheme/pages/home.blade.php --}}

@php
    $storeId = auth()->user()->store_id ?? null;
    $activeTheme = \App\Models\Setting::get('active_theme', 'default');
    $themeData = \App\Models\ThemeData::getByStoreAndTheme($storeId, $activeTheme);
@endphp

@extends('themes.yourtheme.layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="hero" style="background-image: url('{{ $themeData?->getHeroImage() }}');">
        <div class="container">
            <h1>{{ $themeData?->hero_data['title'] ?? 'Welcome to Our Store' }}</h1>
            <p>{{ $themeData?->hero_data['description'] ?? 'Find amazing products' }}</p>
            
            @if($themeData && isset($themeData->hero_data['button_text']))
                <a href="{{ $themeData->hero_data['button_link'] ?? '#' }}" class="btn">
                    {{ $themeData->hero_data['button_text'] }}
                </a>
            @endif
        </div>
    </section>

    {{-- Banner Section --}}
    @if($themeData && $themeData->getBannerImage())
        <section class="banner">
            <a href="{{ $themeData->banner_data['link'] ?? '#' }}">
                <img src="{{ $themeData->getBannerImage() }}" alt="Banner">
                <div class="banner-content">
                    <h2>{{ $themeData->banner_data['title'] ?? '' }}</h2>
                    <p>{{ $themeData->banner_data['description'] ?? '' }}</p>
                </div>
            </a>
        </section>
    @endif

    {{-- Custom Styling --}}
    @if($themeData && $themeData->custom_css)
        <style>{!! $themeData->custom_css !!}</style>
    @endif
    
    @if($themeData && $themeData->custom_js)
        <script>{!! $themeData->custom_js !!}</script>
    @endif
@endsection
```

## Routes

- `GET /admin/themes` - List all available themes
- `GET /admin/themes/customize` - Customize active theme
- `POST /admin/themes/update` - Update theme customization
- `POST /admin/themes/switch` - Switch active theme
- `DELETE /admin/themes/delete-image` - Delete theme image

## API Endpoints

### Switch Theme
```php
POST /admin/themes/switch
Parameters: theme_name
```

### Update Theme Data
```php
POST /admin/themes/update
Parameters:
  - theme_name
  - hero_title
  - hero_description
  - hero_button_text
  - hero_button_link
  - hero_image (file)
  - banner_title
  - banner_description
  - banner_link
  - banner_image (file)
  - custom_data[key] = value
  - custom_css
  - custom_js
```

### Delete Image
```php
DELETE /admin/themes/delete-image
Parameters:
  - image_type (hero|banner|extra)
  - image_key
```

## Best Practices

1. **Always Check for Null**: Theme data might not exist yet
   ```php
   {{ $themeData?->getHeroImage() ?? '/default-image.jpg' }}
   ```

2. **Provide Defaults**: Always provide fallback values
   ```php
   {{ $themeData?->hero_data['title'] ?? 'Default Title' }}
   ```

3. **Use Helper Methods**: Use model methods instead of direct array access
   ```php
   // Good ✓
   $themeData->getCustomData('color', '#000')
   
   // Avoid ✗
   $themeData->custom_data['color'] ?? '#000'
   ```

4. **Cache Theme Data**: For high-traffic sites, consider caching
   ```php
   $themeData = Cache::remember("theme_data_{$storeId}_{$activeTheme}", 3600, function() {
       return ThemeData::getByStoreAndTheme($storeId, $activeTheme);
   });
   ```

## Troubleshooting

### Theme Data Not Showing
1. Check if migration is run: `php artisan migrate`
2. Verify theme data exists in database
3. Check store_id matches current user
4. Ensure theme_name matches active theme

### Images Not Displaying
1. Verify storage is linked: `php artisan storage:link`
2. Check file permissions on storage directory
3. Confirm image path in database is correct

### Custom CSS/JS Not Working
1. Check for syntax errors in custom code
2. Ensure code is being injected in correct location
3. Verify no Content Security Policy blocking execution

## Migration Command

To create the themes_data table:
```bash
php artisan migrate
```

The migration file is located at:
`database/migrations/2025_10_12_191206_create_themes_data_table.php`

## Support

For issues or questions about the theme customization system, please refer to:
- Model: `app/Models/ThemeData.php`
- Controller: `app/Http/Controllers/Admin/ThemeController.php`
- Livewire Component: `app/Livewire/ThemeCustomizer.php`
- Views: `resources/views/themes/admin/theme/`

