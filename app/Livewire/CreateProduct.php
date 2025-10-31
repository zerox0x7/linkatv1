<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class CreateProduct extends Component
{
    use WithFileUploads;

    // Hidden fields
    public $store_id;
    
    // Step management
    public $currentStep = 1;
    
    // Image upload properties
    public $mainImage;
    public $galleryImages = [];
    
    // Temporary image storage
    public $tempMainImagePath = null;
    public $tempGalleryPaths = [];

    // Prevent default Livewire re-rendering
    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount(Request $request)
    {
        $store = $request->attributes->get('store');
        // Get store_id from session or request
        $this->store_id = $store->id;
    }

    public function updatedMainImage()
    {
        $this->uploadMainImage();
    }

    public function updatedGalleryImages($value, $key)
    {
        $this->uploadGalleryImage($key);
    }

    public function uploadMainImage()
    {
        try {
            $this->validate([
                'mainImage' => 'image|max:5120|mimes:jpeg,jpg,png,webp', // 5MB max
            ]);

            if ($this->mainImage) {
                // Store temporarily
                $this->tempMainImagePath = $this->mainImage->store('temp/products', 'public');
                
                // Build the correct URL using asset() for proper domain handling
                $imageUrl = asset('storage/' . $this->tempMainImagePath);
                
                // Emit success event to frontend with step preservation
                $this->dispatch('mainImageUploaded', [
                    'success' => true,
                    'tempPath' => $this->tempMainImagePath,
                    'url' => $imageUrl,
                    'preserveStep' => true // Tell frontend to preserve current step
                ]);
                
                // Reset the file input to allow re-upload
                $this->mainImage = null;
            }
        } catch (\Exception $e) {
            $this->dispatch('mainImageUploadError', [
                'success' => false,
                'message' => 'فشل في رفع الصورة: ' . $e->getMessage(),
                'preserveStep' => true
            ]);
        }
        
        // Skip default Livewire re-render
        $this->skipRender();
    }

    public function uploadGalleryImage($index)
    {
        try {
            if (isset($this->galleryImages[$index])) {
                $this->validate([
                    "galleryImages.{$index}" => 'image|max:5120|mimes:jpeg,jpg,png,webp',
                ]);

                $image = $this->galleryImages[$index];
                $tempPath = $image->store('temp/products/gallery', 'public');
                
                $this->tempGalleryPaths[$index] = $tempPath;
                
                // Build the correct URL using asset() for proper domain handling
                $imageUrl = asset('storage/' . $tempPath);
                
                $this->dispatch('galleryImageUploaded', [
                    'success' => true,
                    'index' => $index,
                    'tempPath' => $tempPath,
                    'url' => $imageUrl,
                    'preserveStep' => true
                ]);
                
                // Reset the specific gallery input
                unset($this->galleryImages[$index]);
            }
        } catch (\Exception $e) {
            $this->dispatch('galleryImageUploadError', [
                'success' => false,
                'index' => $index,
                'message' => 'فشل في رفع الصورة: ' . $e->getMessage(),
                'preserveStep' => true
            ]);
        }
        
        // Skip default Livewire re-render
        $this->skipRender();
    }

    public function removeMainImage()
    {
        if ($this->tempMainImagePath) {
            Storage::disk('public')->delete($this->tempMainImagePath);
            $this->tempMainImagePath = null;
        }
        $this->mainImage = null;
        
        $this->dispatch('mainImageRemoved', [
            'preserveStep' => true
        ]);
        
        // Skip default Livewire re-render
        $this->skipRender();
    }

    public function removeGalleryImage($index)
    {
        if (isset($this->tempGalleryPaths[$index])) {
            Storage::disk('public')->delete($this->tempGalleryPaths[$index]);
            unset($this->tempGalleryPaths[$index]);
        }
        
        if (isset($this->galleryImages[$index])) {
            unset($this->galleryImages[$index]);
        }
        
        $this->dispatch('galleryImageRemoved', [
            'index' => $index,
            'preserveStep' => true
        ]);
        
        // Skip default Livewire re-render
        $this->skipRender();
    }

    public function setStep($step)
    {
        $this->currentStep = $step;
    }

    public function saveProduct($formData)
    {
        try {
            // Start database transaction
            DB::beginTransaction();
            
            // Validate required fields
            $this->validateFormData($formData);

            // Get category
            $category = null;
            if (!empty($formData['categoryId'])) {
                $category = Category::find($formData['categoryId']);
            }
            
            if (!$category) {
                throw new \Exception('التصنيف المحدد غير موجود');
            }

            // Generate slug
            $slug = $this->generateUniqueSlug($formData['productName']);
            $shareSlug = Product::generateShareSlug($formData['productName']);

            // Extract and process tags from the DOM
            $tags = $this->extractTagsFromFormData($formData);

            // Handle image uploads
            $mainImagePath = $this->handleMainImageUpload();
            $galleryPaths = $this->handleGalleryImagesUpload();

            // Prepare data for insertion
            $productData = [
                'store_id' => $this->store_id,
                'category_id' => $category->id,
                'name' => $formData['productName'],
                'slug' => $slug,
                'share_slug' => $shareSlug,
                'sku' => $formData['productSKU'] ?: null,
                'description' => $formData['productDescription'],
                'meta_title' => $formData['seoTitle'],
                'meta_description' => $formData['metaDescription'],
                'meta_keywords' => $formData['seoKeywords'],
                'tags' => $tags,
                'price' => (float) $formData['currentPrice'],
                'old_price' => (float) $formData['originalPrice'],
                'stock' => 100, // Default stock
                'status' => $this->mapStatus($formData['selectedStatus']),
                'type' => $this->mapProductType($formData['selectedProductType']),
                'main_image' => $mainImagePath,
                'gallery' => $galleryPaths,
                'coupon_eligible' => $formData['couponEligible'] ?? true,
                'coupon_categories' => $formData['couponCategories'] ?? [],
                'excluded_coupon_types' => $formData['excludedCouponCategories'] ?? [],
                'has_discount' => (float) $formData['originalPrice'] > (float) $formData['currentPrice'],
                'has_discounts' => (float) $formData['originalPrice'] > (float) $formData['currentPrice'],
                'rating' => null,
                'sales_count' => 0,
                'views_count' => 0,
                'is_featured' => false,
                'features' => [],
                'custom_fields' => null,
                'price_options' => null,
                'warranty_days' => null,
                'product_note' => null,
                'focus_keyword' => $this->extractFocusKeyword($formData['seoKeywords']),
                'seo_score' => null,
                'details' => null,
            ];

            // Create the product
            $product = Product::create($productData);

            // Clean up temporary files
            $this->cleanupTempFiles();

            // Commit the transaction
            DB::commit();

            // Log successful creation
            Log::info('Product created successfully', ['product_id' => $product->id, 'name' => $product->name]);

            // Emit success event with proper formatting for JavaScript
            $this->dispatch('productCreated', [
                'success' => true,
                'message' => 'تم إنشاء المنتج بنجاح! سيتم توجيهك إلى صفحة المنتجات.',
                'product_id' => $product->id,
                'product_name' => $product->name,
                'redirect_url' => $this->getRedirectUrl()
            ]);

        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            
            // Clean up any uploaded files on error
            $this->cleanupTempFiles();
            
            // Log the error
            Log::error('Product creation failed', ['error' => $e->getMessage(), 'formData' => $formData]);

            $this->dispatch('productCreated', [
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء المنتج: ' . $e->getMessage()
            ]);
        }
    }

    private function handleMainImageUpload()
    {
        if ($this->tempMainImagePath) {
            $finalPath = 'products/' . $this->store_id . '/main/' . basename($this->tempMainImagePath);
            $bunny = app(\App\Services\BunnyStorage::class);
            if ($bunny->isConfigured()) {
                $absolute = storage_path('app/public/'.$this->tempMainImagePath);
                $url = $bunny->uploadLocalPath($absolute, $finalPath);
                if ($url) {
                    // Bunny upload succeeded; clean up temp
                    Storage::disk('public')->delete($this->tempMainImagePath);
                    $this->tempMainImagePath = null;
                    return $finalPath;
                }
                // Bunny failed; fall back to local move without losing the file
                Storage::disk('public')->move($this->tempMainImagePath, $finalPath);
                $this->tempMainImagePath = null;
                return $finalPath;
            }
            // Fallback to local move
            Storage::disk('public')->move($this->tempMainImagePath, $finalPath);
            $this->tempMainImagePath = null;
            return $finalPath;
        }
        
        return null;
    }

    private function handleGalleryImagesUpload()
    {
        $galleryPaths = [];
        
        foreach ($this->tempGalleryPaths as $tempPath) {
            if ($tempPath) {
                $finalPath = 'products/' . $this->store_id . '/gallery/' . basename($tempPath);
                $bunny = app(\App\Services\BunnyStorage::class);
                if ($bunny->isConfigured()) {
                    $absolute = storage_path('app/public/'.$tempPath);
                    $url = $bunny->uploadLocalPath($absolute, $finalPath);
                    if ($url) {
                        // Bunny upload succeeded
                        Storage::disk('public')->delete($tempPath);
                        $galleryPaths[] = $finalPath;
                    } else {
                        // Bunny failed; move locally
                        Storage::disk('public')->move($tempPath, $finalPath);
                        $galleryPaths[] = $finalPath;
                    }
                } else {
                    Storage::disk('public')->move($tempPath, $finalPath);
                    $galleryPaths[] = $finalPath;
                }
            }
        }
        
        return $galleryPaths;
    }

    private function cleanupTempFiles()
    {
        // Clean up main image temp file
        if ($this->tempMainImagePath) {
            Storage::disk('public')->delete($this->tempMainImagePath);
            $this->tempMainImagePath = null;
        }
        
        // Clean up gallery temp files
        foreach ($this->tempGalleryPaths as $tempPath) {
            if ($tempPath) {
                Storage::disk('public')->delete($tempPath);
            }
        }
        $this->tempGalleryPaths = [];
    }

    private function validateFormData($formData)
    {
        $requiredFields = [
            'productName' => 'اسم المنتج مطلوب',
            'productDescription' => 'وصف المنتج مطلوب',
            'originalPrice' => 'السعر الأصلي مطلوب',
            'currentPrice' => 'السعر الحالي مطلوب',
            'selectedProductType' => 'نوع المنتج مطلوب',
            'selectedStatus' => 'حالة المنتج مطلوبة',
            'categoryId' => 'تصنيف المنتج مطلوب',
            'seoTitle' => 'عنوان SEO مطلوب',
            'seoKeywords' => 'الكلمات المفتاحية مطلوبة',
            'metaDescription' => 'وصف الميتا مطلوب',
        ];

        foreach ($requiredFields as $field => $message) {
            if (empty($formData[$field])) {
                throw new \Exception($message);
            }
        }

        // Check if SKU is unique (if provided)
        if (!empty($formData['productSKU'])) {
            if (Product::where('sku', $formData['productSKU'])->exists()) {
                throw new \Exception('رمز المنتج (SKU) موجود مسبقاً');
            }
        }

        // Check for valid prices
        if ((float) $formData['originalPrice'] < 0 || (float) $formData['currentPrice'] < 0) {
            throw new \Exception('الأسعار يجب أن تكون أكبر من أو تساوي الصفر');
        }

        // Validate product name length
        if (strlen($formData['productName']) > 255) {
            throw new \Exception('اسم المنتج طويل جداً (الحد الأقصى 255 حرف)');
        }

        // Validate SEO title length
        if (strlen($formData['seoTitle']) > 255) {
            throw new \Exception('عنوان SEO طويل جداً (الحد الأقصى 255 حرف)');
        }

        // Validate main image is uploaded
        if (!$this->tempMainImagePath) {
            throw new \Exception('الصورة الرئيسية للمنتج مطلوبة');
        }
    }

    private function mapProductType($type)
    {
        // Handle both Arabic and English types
        $typeMap = [
            'حساب' => 'account',
            'منتج رقمي' => 'digital',
            'مخصص' => 'custom',
            'account' => 'account',
            'digital' => 'digital',
            'custom' => 'custom'
        ];

        // Clean up the type text (remove icons and extra HTML)
        $cleanType = strip_tags($type);
        $cleanType = preg_replace('/[^\p{L}\p{N}\s]/u', '', $cleanType);
        $cleanType = trim($cleanType);

        return $typeMap[$cleanType] ?? 'account';
    }

    private function mapStatus($status)
    {
        // Handle both Arabic and English statuses
        $statusMap = [
            'نشط' => 'available',
            'غير نشط' => 'unavailable',
            'available' => 'available',
            'unavailable' => 'unavailable'
        ];

        // Clean up the status text (remove icons and extra HTML)
        $cleanStatus = strip_tags($status);
        $cleanStatus = preg_replace('/[^\p{L}\p{N}\s]/u', '', $cleanStatus);
        $cleanStatus = trim($cleanStatus);

        return $statusMap[$cleanStatus] ?? 'available';
    }

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function extractTagsFromFormData($formData)
    {
        $tags = [];
        
        // If tags are provided in the form data
        if (isset($formData['tags']) && is_array($formData['tags'])) {
            $tags = $formData['tags'];
        } elseif (isset($formData['seoKeywords']) && !empty($formData['seoKeywords'])) {
            // Extract tags from SEO keywords as fallback
            $keywords = explode(',', $formData['seoKeywords']);
            $tags = array_map('trim', $keywords);
        }

        // Filter out empty tags
        return array_filter($tags, function($tag) {
            return !empty(trim($tag));
        });
    }

    private function extractFocusKeyword($keywords)
    {
        if (empty($keywords)) {
            return null;
        }

        // Extract the first keyword as focus keyword
        $keywordArray = explode(',', $keywords);
        return trim($keywordArray[0]) ?: null;
    }

    private function getRedirectUrl()
    {
        try {
            // Try to generate the products index route
            if (route('products.index')) {
                return route('products.index');
            }
        } catch (\Exception $e) {
            // Route doesn't exist, try other alternatives
        }

        try {
            // Try admin products route
            if (route('admin.products.index')) {
                return route('admin.products.index');
            }
        } catch (\Exception $e) {
            // Route doesn't exist
        }

        // Fallback URLs
        $fallbackUrls = [
            '/admin/products',
            '/products',
            '/dashboard/products',
            '/admin'
        ];

        return $fallbackUrls[0]; // Return the first fallback
    }

    public function render()
    {
        $categories = Category::where('store_id', $this->store_id)
                             ->where('is_active', true)
                             ->orderBy('name')
                             ->get();

        return view('livewire.create-product', compact('categories'));
    }
}
