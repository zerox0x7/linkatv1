# Home Page Management System

## Overview
The Home Page Management System allows store owners to customize and manage their store's home page content through an intuitive admin interface. The system uses Laravel Livewire for real-time interactivity and stores all data in the `home_page` table.

## Features

### 1. Store Information Management
- **Store Name**: Editable store name
- **Store Description**: Detailed store description
- **Store Logo**: URL for the store logo image

### 2. Hero Section
- **Toggle**: Enable/disable the hero section
- **Main Title**: Primary headline
- **Subtitle**: Supporting text
- **Button 1**: Text and link for primary CTA button
- **Button 2**: Text and link for secondary CTA button
- **Background Image**: URL for hero background image

### 3. Categories Section
- **Toggle**: Enable/disable categories display
- **Section Title**: Customizable title
- **Category Selection**: Choose from available categories in the database
- **Auto Product Count**: Displays product count for each category

### 4. Featured Products Section
- **Toggle**: Enable/disable featured products
- **Section Title**: Customizable title
- **Product Selection**: Choose from active products in the database
- **Display Count**: 4, 8, or 12 products
- **Product Management**: Add/remove products dynamically

### 5. Services Section
- **Toggle**: Enable/disable services display
- **Section Title**: Customizable title
- **Service Management**: Add/remove/edit services
- **Service Properties**: Title, description, and icon
- **Default Services**: Pre-loaded with delivery, warranty, support, and return services

### 6. Reviews Section
- **Toggle**: Enable/disable reviews display
- **Section Title**: Customizable title
- **Review Selection**: Choose from approved reviews in the database
- **Display Count**: 3, 6, or 9 reviews
- **Review Display**: Shows customer name, city, rating, and comment

### 7. Location Section
- **Toggle**: Enable/disable location display
- **Section Title**: Customizable title
- **Contact Information**: Address, phone, email, and hours
- **Map Image**: URL for location map image

### 8. Footer Section
- **Toggle**: Enable/disable footer
- **Description**: Store description for footer
- **Quick Links**: Manageable list of footer links
- **Copyright**: Customizable copyright text

### 9. Theme Colors
- **Primary Color**: Main brand color
- **Background Color**: Page background color
- **Text Color**: Primary text color
- **Secondary Text Color**: Secondary text color

## Technical Implementation

### Database Structure
The system uses the `home_page` table with the following key fields:
- Store identification: `store_id`
- Section toggles: `*_enabled` fields
- Content fields: `*_title`, `*_description`, etc.
- JSON fields: `categories_data`, `featured_products`, `services_data`, `reviews_data`, etc.
- Color fields: `primary_color`, `background_color`, etc.

### Livewire Component
**File**: `app/Livewire/HomePage.php`
**View**: `resources/views/livewire/home-page.blade.php`

Key methods:
- `mount()`: Initialize component with store data
- `loadHomePageData()`: Load existing home page settings
- `loadAvailableData()`: Fetch products, categories, and reviews
- `saveAll()`: Save all home page settings
- `addProduct()`, `removeProduct()`: Manage featured products
- `addCategory()`, `removeCategory()`: Manage categories
- `addReview()`, `removeReview()`: Manage reviews
- `addService()`, `removeService()`: Manage services

### Data Flow
1. **Load**: Component loads existing home page data for the store
2. **Edit**: Store owner modifies content through the interface
3. **Save**: Data is saved to the `home_page` table via Livewire methods
4. **Display**: Frontend uses saved data to render the store's home page

## Usage Instructions

### For Store Owners
1. Navigate to the home page management section in admin panel
2. Toggle sections on/off as needed
3. Edit text content directly in input fields
4. Use modal dialogs to select products, categories, and reviews
5. Add custom services and links as needed
6. Adjust theme colors using color pickers
7. Save changes using individual section save buttons or "Save All"

### For Developers
1. The component automatically handles store context via middleware
2. All data is stored as JSON for complex structures (arrays)
3. Modals are controlled by boolean properties (`showProductModal`, etc.)
4. Real-time updates using Livewire's reactive properties
5. Data validation and error handling included

## Database Relationships
- `home_page.store_id` → `stores.id`
- Featured products reference `products` table
- Categories reference `categories` table  
- Reviews reference `reviews` table with user relationships

## Security Features
- Store isolation: Each store can only manage their own home page
- Data validation on inputs
- Sanitized JSON storage
- User authentication required

## Performance Considerations
- Lazy loading of product/category/review lists
- Efficient database queries with specific field selection
- Minimal DOM updates through Livewire
- Cached default values for better UX

## Future Enhancements
- Image upload functionality for logos and backgrounds
- Drag & drop reordering for sections
- Preview mode before saving
- Section templates/presets
- Multi-language support
- SEO optimization fields 