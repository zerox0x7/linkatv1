# Gamey Theme - Gaming Store Theme

A modern, dark gaming-themed store design built for multi-store platforms. Perfect for selling gaming accounts, in-game currency, boosting services, and digital gaming products.

## Features

### 🎮 Gaming Design
- Dark neon theme with gaming aesthetics
- Modern gradients and glowing effects
- Gaming-specific animations and interactions
- Responsive design optimized for all devices

### 🎨 Modern UI/UX
- TailwindCSS for rapid styling
- Custom gaming animations and effects
- Interactive particles background
- Smooth scrolling and transitions

### 🛠 Theme System Integration
- Full integration with Zain Theme System
- Dynamic configuration through `zain_theme_*` tables
- Store-specific customization (store_id based)
- Theme switching and management support

### 🎯 Gaming-Specific Features
- Product badges for gaming platforms
- Account level and region displays
- Verification status indicators
- Rating and review systems
- Gaming category showcases

## Installation

### 1. Prerequisites
- Laravel application with Zain Theme System
- Existing `zain_theme_*` database tables
- TailwindCSS or CDN access

### 2. Theme Files Structure
```
resources/views/themes/gamey/
├── layouts/
│   └── app.blade.php          # Main layout
├── partials/
│   ├── header.blade.php       # Header with navigation
│   ├── nav.blade.php          # Main navigation
│   └── footer.blade.php       # Footer
├── pages/
│   └── home.blade.php         # Homepage
├── components/
│   └── product-card.blade.php # Product card component
└── sections/                  # Future sections

public/themes/gamey/
├── css/
│   └── style.css             # Custom gaming styles
├── js/
│   └── app.js                # Interactive features
└── images/                   # Theme assets
```

### 3. Database Setup
The theme uses the following `zain_theme_*` tables:
- `zain_theme_settings` - Theme configuration
- `zain_theme_colors` - Color schemes
- `zain_theme_sections` - Page sections
- `zain_theme_products` - Product display settings
- `zain_theme_media` - Media assets

### 4. Test Data
Use the `GameyThemeSeeder` to populate test data for store_id 15:
```bash
php artisan db:seed --class=GameyThemeSeeder
```

## Usage

### 1. Demo Route
Visit `/gamey-demo` to see the theme in action with sample data.

### 2. Controller Integration
The theme integrates with your existing controllers through the `ThemeSettingsController`:

```php
$themeConfig = app('App\Http\Controllers\Theme\ThemeSettingsController')
    ->getStoreThemeConfiguration($storeId, 'gamey');

return view('themes.gamey.pages.home', compact('themeConfig', 'products', 'categories'));
```

### 3. Data Structure
The theme expects data in the following format:

#### Products
```php
$products = [
    (object) [
        'id' => 1,
        'name' => 'Product Name',
        'price' => 99.99,
        'old_price' => 149.99,
        'platform' => 'PUBG Mobile',
        'level' => 85,
        'region' => 'Global',
        'verified' => true,
        'rating' => 5,
        'reviews_count' => 127,
        'is_featured' => true,
        // ... other properties
    ]
];
```

#### Categories
```php
$categories = [
    (object) [
        'id' => 1,
        'name' => 'Gaming Accounts',
        'description' => 'Premium gaming accounts',
        'products_count' => 50,
    ]
];
```

## Customization

### 1. Colors
Modify colors in the `zain_theme_colors` table or override CSS variables:
```css
:root {
    --neon-blue: #00BFFF;
    --neon-green: #39FF14;
    --neon-purple: #BF00FF;
    --neon-orange: #FF6600;
}
```

### 2. Fonts
Change fonts in theme settings:
```php
'google_fonts' => [
    'Orbitron:wght@400;700;900',  // Gaming font
    'Inter:wght@300;400;500;600;700'  // Body font
]
```

### 3. Animations
Enable/disable animations in theme configuration:
```php
'enable_animations' => true,
'enable_loading_screen' => true,
'enable_back_to_top' => true,
```

## Features Overview

### 🎮 Gaming Elements
- **Neon Glow Effects**: Buttons and cards with gaming glow
- **Particle Animations**: Background particles for immersion
- **Gaming Typography**: Orbitron font for headings
- **Platform Badges**: Display game platforms and regions
- **Level Indicators**: Show account levels and ranks

### 🛒 E-commerce Features
- **Product Grid**: Responsive product layouts
- **Shopping Cart**: Sidebar cart with animations
- **Wishlist**: Heart button for favorites
- **Quick View**: Product preview modals
- **Rating System**: Star ratings and reviews

### 📱 Responsive Design
- **Mobile First**: Optimized for mobile devices
- **Tablet Support**: Perfect tablet experience
- **Desktop Enhanced**: Rich desktop interactions

### ⚡ Performance
- **Lazy Loading**: Images load when needed
- **Caching**: Theme data caching support
- **Optimized Assets**: Minified CSS and JS

## Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Credits
- Built with TailwindCSS
- Font Awesome icons
- Google Fonts (Orbitron, Inter)
- Gaming design inspiration

## License
This theme is part of the Zain Theme System for multi-store platforms.

---

**Created by**: Zain Theme System  
**Version**: 1.0  
**Compatible with**: Laravel 8+, Zain Theme System  
**Demo**: Visit `/gamey-demo` to see it in action! 