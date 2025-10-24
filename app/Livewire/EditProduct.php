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

class EditProduct extends Component
{
    use WithFileUploads;

    // Product being edited
    public $product;
    public $productId;
    
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
    
    // Existing images
    public $existingMainImage = null;
    public $existingGalleryImages = [];
    public $removedGalleryIndexes = [];

    // Prevent default Livewire re-rendering
    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount(Request $request, $id)
    {
        $store = $request->attributes->get('store');
        $this->store_id = $store->id;
        
        // Load the product
        $this->product = Product::where('id', $id)
                               ->where('store_id', $store->id)
                               ->firstOrFail();
        $this->productId = $this->product->id;
        
        // Set existing images
        $this->existingMainImage = $this->product->main_image;
        $this->existingGalleryImages = is_array($this->product->gallery) ? $this->product->gallery : [];
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
                    'preserveStep' => true
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
                
                $imageUrl = asset('storage/' . $tempPath);
                
                $this->dispatch('galleryImageUploaded', [
                    'success' => true,
                    'index' => $index,
                    'tempPath' => $tempPath,
                    'url' => $imageUrl,
                    'preserveStep' => true
                ]);
                
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
        
        $this->skipRender();
    }

    public function removeMainImage()
    {
        if ($this->tempMainImagePath) {
            Storage::disk('public')->delete($this->tempMainImagePath);
            $this->tempMainImagePath = null;
        }
        
        // Mark existing main image for removal
        $this->existingMainImage = null;
        $this->mainImage = null;
        
        $this->dispatch('mainImageRemoved', [
            'preserveStep' => true
        ]);
        
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
        
        $this->skipRender();
    }
    
    public function removeExistingGalleryImage($index)
    {
        // Mark for removal
        $this->removedGalleryIndexes[] = $index;
        
        $this->dispatch('existingGalleryImageRemoved', [
            'index' => $index,
            'preserveStep' => true
        ]);
        
        $this->skipRender();
    }

    public function setStep($step)
    {
        $this->currentStep = $step;
    }

    public function updateProduct($formData)
    {
        try {
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

            // Generate slug if name changed
            $slug = $this->product->slug;
            if ($this->product->name !== $formData['productName']) {
                $slug = $this->generateUniqueSlug($formData['productName'], $this->product->id);
            }

            // Extract and process tags
            $tags = $this->extractTagsFromFormData($formData);

            // Handle image uploads
            $mainImagePath = $this->handleMainImageUpdate();
            $galleryPaths = $this->handleGalleryImagesUpdate();

            // Prepare data for update
            $productData = [
                'category_id' => $category->id,
                'name' => $formData['productName'],
                'slug' => $slug,
                'sku' => $formData['productSKU'] ?: null,
                'description' => $formData['productDescription'],
                'meta_title' => $formData['seoTitle'],
                'meta_description' => $formData['metaDescription'],
                'meta_keywords' => $formData['seoKeywords'],
                'tags' => $tags,
                'price' => (float) $formData['currentPrice'],
                'old_price' => (float) $formData['originalPrice'],
                'status' => $this->mapStatus($formData['selectedStatus']),
                'type' => $this->mapProductType($formData['selectedProductType']),
                'main_image' => $mainImagePath,
                'gallery' => $galleryPaths,
                'coupon_eligible' => $formData['couponEligible'] ?? true,
                'coupon_categories' => $formData['couponCategories'] ?? [],
                'excluded_coupon_types' => $formData['excludedCouponCategories'] ?? [],
                'has_discount' => (float) $formData['originalPrice'] > (float) $formData['currentPrice'],
                'has_discounts' => (float) $formData['originalPrice'] > (float) $formData['currentPrice'],
                'focus_keyword' => $this->extractFocusKeyword($formData['seoKeywords']),
            ];

            // Update the product
            $this->product->update($productData);

            // Clean up old images if replaced
            $this->cleanupReplacedImages();
            
            // Clean up temporary files
            $this->cleanupTempFiles();

            DB::commit();

            Log::info('Product updated successfully', ['product_id' => $this->product->id, 'name' => $this->product->name]);

            $this->dispatch('productUpdated', [
                'success' => true,
                'message' => 'تم تحديث المنتج بنجاح! سيتم توجيهك إلى صفحة المنتجات.',
                'product_id' => $this->product->id,
                'product_name' => $this->product->name,
                'redirect_url' => $this->getRedirectUrl()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->cleanupTempFiles();
            
            Log::error('Product update failed', ['error' => $e->getMessage(), 'product_id' => $this->productId]);

            $this->dispatch('productUpdated', [
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث المنتج: ' . $e->getMessage()
            ]);
        }
    }

    private function handleMainImageUpdate()
    {
        // If a new image was uploaded
        if ($this->tempMainImagePath) {
            $finalPath = 'products/' . $this->store_id . '/main/' . basename($this->tempMainImagePath);
            Storage::disk('public')->move($this->tempMainImagePath, $finalPath);
            
            // Delete old main image if it exists and is different
            if ($this->product->main_image && $this->product->main_image !== $finalPath) {
                Storage::disk('public')->delete($this->product->main_image);
            }
            
            return $finalPath;
        }
        
        // If existing image was removed
        if ($this->existingMainImage === null && $this->product->main_image) {
            Storage::disk('public')->delete($this->product->main_image);
            return null;
        }
        
        // Keep existing image
        return $this->product->main_image;
    }

    private function handleGalleryImagesUpdate()
    {
        $galleryPaths = [];
        
        // Keep existing gallery images (except removed ones)
        if (is_array($this->product->gallery)) {
            foreach ($this->product->gallery as $index => $imagePath) {
                if (!in_array($index, $this->removedGalleryIndexes)) {
                    $galleryPaths[] = $imagePath;
                } else {
                    // Delete removed images
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }
        
        // Add new gallery images
        foreach ($this->tempGalleryPaths as $tempPath) {
            if ($tempPath) {
                $finalPath = 'products/' . $this->store_id . '/gallery/' . basename($tempPath);
                Storage::disk('public')->move($tempPath, $finalPath);
                $galleryPaths[] = $finalPath;
            }
        }
        
        return $galleryPaths;
    }

    private function cleanupReplacedImages()
    {
        // Already handled in handleMainImageUpdate and handleGalleryImagesUpdate
    }

    private function cleanupTempFiles()
    {
        if ($this->tempMainImagePath) {
            Storage::disk('public')->delete($this->tempMainImagePath);
            $this->tempMainImagePath = null;
        }
        
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

        // Check if SKU is unique (excluding current product)
        if (!empty($formData['productSKU'])) {
            if (Product::where('sku', $formData['productSKU'])
                      ->where('id', '!=', $this->productId)
                      ->exists()) {
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

        // Main image is optional for edit (keep existing if no new one uploaded)
    }

    private function mapProductType($type)
    {
        $typeMap = [
            'حساب' => 'account',
            'منتج رقمي' => 'digital',
            'مخصص' => 'custom',
            'account' => 'account',
            'digital' => 'digital',
            'custom' => 'custom'
        ];

        $cleanType = strip_tags($type);
        $cleanType = preg_replace('/[^\p{L}\p{N}\s]/u', '', $cleanType);
        $cleanType = trim($cleanType);

        return $typeMap[$cleanType] ?? 'account';
    }

    private function mapStatus($status)
    {
        $statusMap = [
            'نشط' => 'available',
            'غير نشط' => 'unavailable',
            'available' => 'available',
            'unavailable' => 'unavailable'
        ];

        $cleanStatus = strip_tags($status);
        $cleanStatus = preg_replace('/[^\p{L}\p{N}\s]/u', '', $cleanStatus);
        $cleanStatus = trim($cleanStatus);

        return $statusMap[$cleanStatus] ?? 'available';
    }

    private function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        $query = Product::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            $query = Product::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    private function extractTagsFromFormData($formData)
    {
        $tags = [];
        
        if (isset($formData['tags']) && is_array($formData['tags'])) {
            $tags = $formData['tags'];
        } elseif (isset($formData['seoKeywords']) && !empty($formData['seoKeywords'])) {
            $keywords = explode(',', $formData['seoKeywords']);
            $tags = array_map('trim', $keywords);
        }

        return array_filter($tags, function($tag) {
            return !empty(trim($tag));
        });
    }

    private function extractFocusKeyword($keywords)
    {
        if (empty($keywords)) {
            return null;
        }

        $keywordArray = explode(',', $keywords);
        return trim($keywordArray[0]) ?: null;
    }

    private function getRedirectUrl()
    {
        try {
            if (route('admin.products.index')) {
                return route('admin.products.index');
            }
        } catch (\Exception $e) {
            // Route doesn't exist
        }

        $fallbackUrls = [
            '/admin/products',
            '/products',
            '/dashboard/products',
            '/admin'
        ];

        return $fallbackUrls[0];
    }

    public function render()
    {
        $categories = Category::where('store_id', $this->store_id)
                             ->where('is_active', true)
                             ->orderBy('name')
                             ->get();

        return view('livewire.edit-product', compact('categories'));
    }
}
