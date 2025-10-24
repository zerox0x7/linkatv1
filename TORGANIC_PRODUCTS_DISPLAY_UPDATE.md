# Torganic Theme - Products Display Update

## Overview
This document describes the updates made to display products from the database on the Torganic theme home page, including best-selling products calculated from actual order data.

## Changes Made

### 1. HomeController.php Updates

#### New Product Queries Added
The following product collections are now fetched and passed to the view:

1. **Popular Products** (`$popularProducts`) - 10 most viewed products
   - Ordered by `views_count` DESC
   - Includes ratings and review counts

2. **New Arrivals** (`$newArrivals`) - 10 latest products
   - Ordered by creation date (latest first)
   - Includes ratings and review counts

3. **Best Sellers** (`$bestSellers`) - 10 best-selling products
   - **Uses actual order data from `order_items` table**
   - Counts only completed, processing, or shipped orders
   - Ordered by total order items count
   - Includes ratings and review counts

4. **Top Selling Products** (`$topSellingProducts`) - Top 3 best sellers
   - Same logic as Best Sellers but limited to 3 products
   - Used in the "Product Listing Section"

5. **Trending Products** (`$trendingProducts`) - 3 trending products
   - Products created in last 90 days
   - With sales in the last 30 days
   - Ordered by recent sales count
   - Includes ratings and review counts

6. **New Products** (`$newProducts`) - 3 newest products
   - Latest products by creation date
   - Used in the "Product Listing Section"

7. **Flash Sale Products** (`$flashSaleProducts`) - 2 products on sale
   - Products with `old_price > price` (discount)
   - Ordered by discount percentage (highest first)
   - Includes ratings and review counts

### 2. Product Model Updates

#### New Accessor Methods
Added the following accessor methods to make the model compatible with the Torganic theme view:

```php
/**
 * Accessor for 'image' attribute (alias for main_image)
 */
public function getImageAttribute()
{
    return $this->main_image;
}

/**
 * Accessor for 'original_price' attribute (alias for old_price)
 */
public function getOriginalPriceAttribute()
{
    return $this->old_price;
}
```

These accessors allow the view to use `$product->image` and `$product->original_price` instead of `$product->main_image` and `$product->old_price`.

### 3. Database Queries Optimization

All product queries now include:
- **Rating Average**: `withAvg(['reviews' => function($query) { ... }], 'rating')`
- **Review Count**: `withCount(['reviews' => function($query) { ... }])`
- **Order Items Count** (for best sellers): `withCount(['orderItems' => function($query) { ... }])`

Only approved reviews are counted in ratings and counts.

## How Best Sellers Are Calculated

The best sellers calculation uses the `order_items` table to count actual sales:

```php
$bestSellers = Product::where('store_id', $store->id)
    ->available()
    ->withAvg(['reviews' => function($query) {
        $query->where('is_approved', true);
    }], 'rating')
    ->withCount(['reviews' => function($query) {
        $query->where('is_approved', true);
    }])
    ->withCount(['orderItems' => function($query) {
        $query->whereHas('order', function($q) {
            $q->whereIn('status', ['completed', 'processing', 'shipped']);
        });
    }])
    ->orderBy('order_items_count', 'desc')
    ->limit(10)
    ->get();
```

This counts all order items for each product where the order status is:
- `completed` - Order has been completed
- `processing` - Order is being processed
- `shipped` - Order has been shipped

## Product Sections in Torganic Home Page

The home page now displays products in the following sections:

### 1. Flash Sales Section (Line 234-291)
- Displays 2 products with the highest discount
- Shows discount badge and pricing

### 2. Popular Products with Tabs (Line 372-663)
Four tabs displaying different product collections:
- **All Products** - Shows `$popularProducts`
- **New Arrivals** - Shows `$newArrivals`
- **Featured** - Shows `$featuredProducts` (from home page config)
- **Best Sellers** - Shows `$bestSellers`

### 3. Product Listing Section (Line 725-890)
Three columns showing:
- **Top Selling** - Shows `$topSellingProducts` (top 3)
- **Trending** - Shows `$trendingProducts` (3 products)
- **New Products** - Shows `$newProducts` (3 products)

### 4. Featured Products Slider (Line 931-1044)
- Displays `$featuredProducts` in a carousel

## Database Schema Reference

### Products Table
- `main_image` - Main product image (accessed via `$product->image`)
- `old_price` - Original price before discount (accessed via `$product->original_price`)
- `price` - Current selling price
- `views_count` - Number of product views
- `sales_count` - Cached sales count (not used in new implementation)
- `rating` - Average rating
- `status` - Product status ('available', 'sold', 'reserved')
- `stock` - Available stock quantity

### Order Items Table
- `orderable_type` - Product model class name
- `orderable_id` - Product ID
- `order_id` - Associated order
- `quantity` - Number of items ordered

## Product Availability Logic

The `scopeAvailable` in the Product model checks:
```php
public function scopeAvailable($query)
{
    return $query->where('status', 'available')->where('stock', '>', 0);
}
```

Products must have:
1. Status = 'available'
2. Stock > 0

## Testing the Implementation

To test the product display:

1. **Ensure products exist in database** with status = 'available' and stock > 0
2. **Add some orders** with order_items linked to products
3. **Set order status** to 'completed', 'processing', or 'shipped'
4. **Visit the home page** to see products displayed

## Variables Passed to View

The following variables are now available in `themes.torganic.pages.home`:

```php
'popularProducts'      // Most viewed products
'newArrivals'         // Latest products
'bestSellers'         // Best selling products
'topSellingProducts'  // Top 3 best sellers
'trendingProducts'    // Recently popular products
'newProducts'         // 3 newest products
'flashSaleProducts'   // Products on sale
'featuredProducts'    // Featured products (from config)
'latestProducts'      // Latest 8 products (for default theme)
'categories'          // Categories (from home page config)
'reviews'            // Customer reviews
```

## Notes

1. **Product Status**: Changed from 'active' to 'available' to match the database migration
2. **Performance**: Queries are optimized with eager loading of ratings and review counts
3. **Fallback**: If no products match criteria, the view shows placeholder images
4. **Real Sales Data**: Best sellers now use actual order data instead of cached `sales_count`

## Future Enhancements

Consider adding:
1. Caching for frequently accessed product lists
2. Pagination for large product catalogs
3. Product view counter middleware
4. Automatic updating of `sales_count` field via observers
5. Redis caching for trending products calculation

