<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Dashboard\ImageUploadController;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض قائمة المنتجات
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // فلترة حسب الفئة
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // فلترة حسب البحث
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $products = $query->with('category')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        
        $categories = Category::all();
        
        return view('themes.dashboard.products.index', compact('products', 'categories'));
    }

    /**
     * عرض نموذج إنشاء منتج جديد
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::all();
        return view('themes.dashboard.products.create', compact('categories'));
    }

    /**
     * تخزين منتج جديد في قاعدة البيانات
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'type' => 'required|in:account,digital_card,custom',
            'digital_codes' => 'nullable|string',
            'custom_fields' => 'nullable|string',
            'price_options' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            // حقول SEO
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'focus_keyword' => 'nullable|string|max:255',
            'tags_list' => 'nullable|string',
            'seo_score' => 'nullable|integer|min:0|max:100',
            'product_note' => 'nullable|string',
        ]);
        
        // التأكد من صحة تنسيق البيانات JSON
        if (isset($validated['custom_fields']) && $validated['custom_fields']) {
            try {
                json_decode($validated['custom_fields'], true);
            } catch (\Exception $e) {
                $validated['custom_fields'] = '[]';
            }
        }
        
        if (isset($validated['price_options']) && $validated['price_options']) {
            try {
                json_decode($validated['price_options'], true);
            } catch (\Exception $e) {
                $validated['price_options'] = '[]';
            }
        }
        
        // معالجة الصورة الرئيسية
        if ($request->hasFile('image')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('image'),
                'products',
                $product->main_image ?? null
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['image' => $result['message']])
                    ->withInput();
            }
            
            $validated['main_image'] = $result['path'];
        }
        
        // معالجة الصور الإضافية
        if ($request->hasFile('additional_images')) {
            $result = $this->imageUploader->uploadMultiple(
                $request->file('additional_images'),
                'products'
            );
            
            if ($result['success']) {
                $galleryImages = json_decode($product->gallery ?: '[]', true);
                $galleryImages = array_merge($galleryImages, $result['paths']);
                $validated['gallery'] = json_encode($galleryImages);
            }
        }
        
        // إنشاء slug
        if ($request->has('custom_slug_switch') && $request->filled('slug')) {
            // تحقق من التفرد
            $exists = Product::where('slug', $request->slug)->exists();
            if ($exists) {
                return redirect()->back()
                    ->withErrors(['slug' => 'هذا الرابط مستخدم مسبقاً، يرجى اختيار رابط آخر.'])
                    ->withInput();
            }
            $validated['slug'] = $request->slug;
        } else {
            // توليد تلقائي من الاسم مع التأكد من التفرد
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }
        
        // تحويل featured إلى is_featured
        $validated['is_featured'] = $request->has('featured');
        
        // تصحيح منطق السعر والسعر الأصلي
        if ($request->has('sale_price') && $request->sale_price !== null && $request->sale_price > 0) {
            $validated['old_price'] = $request->sale_price;
        } else {
            $validated['old_price'] = null;
        }
        
        // معالجة التاغات (tags_list)
        if ($request->has('tags_list') && !empty($request->tags_list)) {
            $tags = array_map('trim', explode(',', $request->tags_list));
            $validated['tags'] = json_encode(array_filter($tags, function($tag) {
                return !empty($tag);
            }), JSON_UNESCAPED_UNICODE);
            unset($validated['tags_list']);
        }
        
        // إنشاء المنتج
        $product = Product::create($validated);
        
        // إذا كان المنتج من نوع حساب والحسابات موجودة في الطلب
        if ($validated['type'] === 'account' && $request->filled('accounts_json')) {
            $accounts = json_decode($request->accounts_json, true);
            if (is_array($accounts) && count($accounts) > 0) {
                foreach ($accounts as $accountText) {
                    \App\Models\AccountDigetal::create([
                        'product_id' => $product->id,
                        'status' => 'available',
                        'meta' => ['text' => Crypt::encryptString($accountText)],
                    ]);
                }
                // تحديث المخزون بناءً على عدد الحسابات المضافة
                $product->update(['stock' => count($accounts)]);
            }
        }
        
        // إذا كان المنتج من نوع بطاقة رقمية والأكواد موجودة في الطلب، فسيتم إضافتها إلى جدول digital_card_codes
        if ($validated['type'] === 'digital_card' && $request->has('digital_codes') && !empty($request->digital_codes)) {
            $digitalCodes = array_filter(
                explode("\n", $request->digital_codes),
                function($code) {
                    return !empty(trim($code));
                }
            );

            if (count($digitalCodes) > 0) {
                foreach ($digitalCodes as $code) {
                    $code = trim($code);
                    if (!empty($code)) {
                        $existingCode = \App\Models\DigitalCardCode::where('code', $code)
                            ->where('product_id', $product->id)
                            ->first();

                        if (!$existingCode) {
                            \App\Models\DigitalCardCode::create([
                                'product_id' => $product->id,
                                'code' => $code,
                                'status' => 'available'
                            ]);
                        }
                    }
                }
            }

            // تحديث المخزون بناءً على عدد الأكواد المتاحة
            $availableCodesCount = \App\Models\DigitalCardCode::where('product_id', $product->id)
                ->where('status', 'available')
                ->count();

            $product->update(['stock' => $availableCodesCount]);
        }
        
        return redirect()->route('dashboard.products.index')
                        ->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    /**
     * عرض صفحة تفاصيل المنتج
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Product $product)
    {
        return view('themes.dashboard.products.show', compact('product'));
    }

    /**
     * عرض نموذج تعديل المنتج
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        
        // تأكد من تنسيق البيانات كـ JSON
        if ($product->custom_fields && !is_array(json_decode($product->custom_fields, true))) {
            $product->custom_fields = '[]';
        }
        
        if ($product->price_options && !is_array(json_decode($product->price_options, true))) {
            $product->price_options = '[]';
        }
        
        return view('themes.dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * تحديث بيانات المنتج في قاعدة البيانات
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDigitalCode(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $digitalCode = \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('code', $validated['code'])
            ->first();

        if (!$digitalCode) {
            return back()->with('error', 'الكود غير موجود أو غير متاح');
        }

        $digitalCode->delete();

        // تحديث المخزون
        $availableCodesCount = \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('status', 'available')
            ->count();

        $product->update(['stock' => $availableCodesCount]);

        return back()->with('success', 'تم حذف الكود بنجاح');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'type' => 'required|in:account,digital_card,custom',
            'custom_fields' => 'nullable|string',
            'price_options' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            'remove_images' => 'nullable|array',
            // حقول SEO
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'focus_keyword' => 'nullable|string|max:255',
            'tags_list' => 'nullable|string',
            'seo_score' => 'nullable|integer|min:0|max:100',
            'product_note' => 'nullable|string',
        ]);
        
        // التأكد من صحة تنسيق البيانات JSON
        if (isset($validated['custom_fields']) && $validated['custom_fields']) {
            try {
                json_decode($validated['custom_fields'], true);
            } catch (\Exception $e) {
                $validated['custom_fields'] = '[]';
            }
        }
        
        if (isset($validated['price_options']) && $validated['price_options']) {
            try {
                json_decode($validated['price_options'], true);
            } catch (\Exception $e) {
                $validated['price_options'] = '[]';
            }
        }
        
        // معالجة الصورة الرئيسية
        if ($request->hasFile('image')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('image'),
                'products',
                $product->main_image ?? null
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['image' => $result['message']])
                    ->withInput();
            }
            
            $validated['main_image'] = $result['path'];
        }
        
        // معالجة الصور الإضافية
        if ($request->hasFile('additional_images')) {
            $result = $this->imageUploader->uploadMultiple(
                $request->file('additional_images'),
                'products'
            );
            
            if ($result['success']) {
                $galleryImages = json_decode($product->gallery ?: '[]', true);
                $galleryImages = array_merge($galleryImages, $result['paths']);
                $validated['gallery'] = json_encode($galleryImages);
            }
        } else if ($request->has('remove_images') && is_array($request->remove_images)) {
            // حذف الصور المحددة
            $galleryImages = json_decode($product->gallery ?: '[]', true);
            
            foreach ($request->remove_images as $index) {
                if (isset($galleryImages[$index])) {
                    $this->imageUploader->deleteImage($galleryImages[$index]);
                    unset($galleryImages[$index]);
                }
            }
            
            $galleryImages = array_values($galleryImages); // إعادة ترتيب المصفوفة
            $validated['gallery'] = json_encode($galleryImages);
        }
        
        // تحويل featured إلى is_featured
        $validated['is_featured'] = $request->has('featured');
        
        // تصحيح منطق السعر والسعر الأصلي
        if ($request->has('sale_price') && $request->sale_price !== null && $request->sale_price > 0) {
            $validated['old_price'] = $request->sale_price;
        } else {
            $validated['old_price'] = null;
        }
        
        // معالجة التاغات (tags_list)
        if ($request->has('tags_list') && !empty($request->tags_list)) {
            $tags = array_map('trim', explode(',', $request->tags_list));
            $validated['tags'] = json_encode(array_filter($tags, function($tag) {
                return !empty($tag);
            }), JSON_UNESCAPED_UNICODE);
            unset($validated['tags_list']);
        }

        // معالجة slug (للتحديث فقط)
        // ملاحظة: هذا المنطق مختلف عن منطق slug في store method
        if ($request->has('custom_slug_switch') && $request->filled('slug')) {
            // تحقق من التفرد (استثناء المنتج الحالي)
            $exists = Product::where('slug', $request->slug)
                ->where('id', '!=', $product->id)
                ->exists();
            if ($exists) {
                return redirect()->back()
                    ->withErrors(['slug' => 'هذا الرابط مستخدم مسبقاً، يرجى اختيار رابط آخر.'])
                    ->withInput();
            }
            $validated['slug'] = $request->slug;
        } else {
            // توليد تلقائي من الاسم مع التأكد من التفرد
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)
                ->where('id', '!=', $product->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // إذا كان المنتج من نوع بطاقة رقمية والأكواد موجودة في الطلب، فسيتم إضافتها إلى جدول digital_card_codes
        $digitalCodes = [];
        if ($validated['type'] === 'digital_card' && $request->has('digital_codes') && !empty($request->digital_codes)) {
            $digitalCodes = array_filter(
                explode("\n", $request->digital_codes),
                function($code) {
                    return !empty(trim($code));
                }
            );
            
            // إضافة الأكواد الجديدة إلى جدول digital_card_codes
            if (count($digitalCodes) > 0) {
                foreach ($digitalCodes as $code) {
                    $code = trim($code);
                    if (!empty($code)) {
                        // التحقق من عدم وجود الكود مسبقاً
                        $existingCode = \App\Models\DigitalCardCode::where('code', $code)
                            ->where('product_id', $product->id)
                            ->first();
                        
                        if (!$existingCode) {
                            \App\Models\DigitalCardCode::create([
                                'product_id' => $product->id,
                                'code' => $code,
                                'status' => 'available'
                            ]);
                        }
                    }
                }
            }
            
            // تحديث المخزون بناءً على عدد الأكواد المتاحة
            $availableCodesCount = \App\Models\DigitalCardCode::where('product_id', $product->id)
                ->where('status', 'available')
                ->count();
            
            $validated['stock'] = $availableCodesCount;
        }
        
        $product->update($validated);
        
        return redirect()->route('dashboard.products.index')
                        ->with('success', 'تم تحديث المنتج بنجاح.');
    }

    /**
     * حذف منتج من قاعدة البيانات
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // حذف الصور
        if ($product->main_image) {
            $this->imageUploader->deleteImage($product->main_image);
        }
        
        $galleryImages = json_decode($product->gallery ?: '[]', true);
        $this->imageUploader->deleteMultipleImages($galleryImages);
        
        $product->delete();
        
        return redirect()->route('dashboard.products.index')
                        ->with('success', 'تم حذف المنتج بنجاح.');
    }
    
    /**
     * تبديل حالة المميز للمنتج
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleFeatured(Product $product)
    {
        $product->update([
            'featured' => !$product->featured
        ]);
        
        return redirect()->back()
                        ->with('success', 'تم تحديث حالة المنتج المميز بنجاح.');
    }
    
    /**
     * الحصول على الأكواد الرقمية للمنتج كاستجابة JSON
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDigitalCodes(Product $product)
    {
        // التحقق مما إذا كان المنتج من نوع بطاقة رقمية
        if ($product->type !== 'digital_card') {
            return response()->json(['error' => 'هذا المنتج ليس من نوع بطاقة رقمية'], 400);
        }
        
        // الحصول على الأكواد من جدول digital_card_codes
        $digitalCodes = \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('status', 'available')
            ->pluck('code')
            ->toArray();
        
        return response()->json([
            'digital_codes' => implode("\n", $digitalCodes),
        ]);
    }
    
    /**
     * تحديث الأكواد الرقمية للمنتج
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDigitalCodes(Request $request, Product $product)
    {
        $validated = $request->validate([
            'digital_codes' => 'nullable|string',
        ]);
        
        // تحويل الأكواد المدخلة إلى مصفوفة
        $newCodes = array_filter(
            explode("\n", $validated['digital_codes'] ?? ''),
            function($code) {
                return !empty(trim($code));
            }
        );
        
        // حذف الأكواد المتاحة الحالية
        \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('status', 'available')
            ->delete();
        
        // إضافة الأكواد الجديدة
        $addedCount = 0;
        foreach ($newCodes as $code) {
            $code = trim($code);
            if (!empty($code)) {
                \App\Models\DigitalCardCode::create([
                    'product_id' => $product->id,
                    'code' => $code,
                    'status' => 'available'
                ]);
                $addedCount++;
            }
        }
        
        // تحديث المخزون ليساوي عدد الأكواد المتاحة
        $availableCodesCount = \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('status', 'available')
            ->count();
        
        $product->update(['stock' => $availableCodesCount]);
        
        return redirect()->route('dashboard.products.index')
            ->with('success', "تم تحديث الأكواد الرقمية بنجاح. ({$addedCount} كود جديد)");
    }
    
    /**
     * عرض صفحة إدارة الأكواد الرقمية للمنتج
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\View\View
     */
    public function manageCodes(Product $product)
    {
        // التأكد من أن المنتج من نوع بطاقة رقمية
        if ($product->type !== 'digital_card') {
            return redirect()->route('dashboard.products.index')
                ->with('error', 'يمكن إدارة الأكواد الرقمية فقط للمنتجات من نوع بطاقة رقمية');
        }
        
        // الحصول على الأكواد من جدول digital_card_codes
        $digitalCodes = \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('code')
            ->toArray();
        
        // الأكواد المباعة أو المستخدمة - تضمين العلاقات مع الطلبات والمستخدمين
        $soldCodes = \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('status', 'used')
            ->with(['order', 'order.user']) // تضمين العلاقات
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('themes.dashboard.products.manage-codes', compact('product', 'digitalCodes', 'soldCodes'));
    }
    
    /**
     * إضافة كود رقمي جديد للمنتج
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCode(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);
        
        $code = trim($validated['code']);
        
        // التحقق من عدم وجود الكود مسبقًا
        $existingCode = \App\Models\DigitalCardCode::where('code', $code)
            ->where('product_id', $product->id)
            ->first();
        
        if ($existingCode) {
            return redirect()->route('dashboard.products.manage-codes', $product)
                ->with('error', 'الكود موجود مسبقًا');
        }
        
        // إضافة الكود الجديد إلى جدول digital_card_codes
        \App\Models\DigitalCardCode::create([
            'product_id' => $product->id,
            'code' => $code,
            'status' => 'available'
        ]);
        
        // تحديث عدد المخزون
        $product->increment('stock');
        
        return redirect()->route('dashboard.products.manage-codes', $product)
            ->with('success', 'تم إضافة الكود بنجاح');
    }
    
    /**
     * حذف كود رقمي من المنتج
     *
     * @param  \App\Models\Product  $product
     * @param  string  $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCode(Product $product, $code)
    {
        // فك ترميز الكود
        $decodedCode = base64_decode($code);
        
        // البحث عن الكود في جدول digital_card_codes
        $digitalCode = \App\Models\DigitalCardCode::where('code', $decodedCode)
            ->where('product_id', $product->id)
            ->where('status', 'available')
            ->first();
        
        // التحقق من وجود الكود
        if (!$digitalCode) {
            return redirect()->route('dashboard.products.manage-codes', $product)
                ->with('error', 'الكود غير موجود أو غير متاح');
        }
        
        // حذف الكود من جدول digital_card_codes
        $digitalCode->delete();
        
        // تخفيض عدد المخزون
        if ($product->stock > 0) {
            $product->decrement('stock');
        }
        
        return redirect()->route('dashboard.products.manage-codes', $product)
            ->with('success', 'تم حذف الكود بنجاح');
    }

    /**
     * إضافة مجموعة من الأكواد الرقمية دفعة واحدة
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMultipleCodes(Request $request, Product $product)
    {
        $validated = $request->validate([
            'new_digital_codes' => 'required|string',
        ]);
        
        // تحويل النص إلى مصفوفة من الأكواد
        $newCodes = array_filter(
            explode("\n", $validated['new_digital_codes']),
            function($code) {
                return !empty(trim($code));
            }
        );
        
        if (empty($newCodes)) {
            return redirect()->route('dashboard.products.manage-codes', $product)
                ->with('error', 'لم يتم إدخال أي أكواد صالحة');
        }
        
        // تتبع عدد الأكواد المضافة
        $addedCount = 0;
        
        // إضافة الأكواد الجديدة (بدون التحقق من التكرار)
        foreach ($newCodes as $code) {
            $code = trim($code);
            \App\Models\DigitalCardCode::create([
                'product_id' => $product->id,
                'code' => $code,
                'status' => 'available'
            ]);
            $addedCount++;
        }
        
        // تحديث المخزون
        $product->increment('stock', $addedCount);
        
        $message = "تم إضافة {$addedCount} كود جديد بنجاح (تم قبول التكرار)";
        
        return redirect()->route('dashboard.products.manage-codes', $product)
            ->with('success', $message);
    }

    /**
     * ترحيل الأكواد من حقل digital_codes إلى جدول digital_card_codes
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function migrateCodes(Product $product)
    {
        // التأكد من أن المنتج من نوع بطاقة رقمية
        if ($product->type !== 'digital_card') {
            return redirect()->route('dashboard.products.index')
                ->with('error', 'يمكن ترحيل الأكواد الرقمية فقط للمنتجات من نوع بطاقة رقمية');
        }
        
        // تحويل الأكواد الحالية إلى مصفوفة
        $digitalCodes = [];
        if (!empty($product->digital_codes)) {
            $digitalCodes = is_array($product->digital_codes) 
                ? $product->digital_codes 
                : explode("\n", $product->digital_codes);
        }
        
        // تنظيف المصفوفة من القيم الفارغة
        $digitalCodes = array_filter($digitalCodes, function($code) {
            return !empty(trim($code));
        });
        
        // عدد الأكواد التي تم ترحيلها
        $migratedCount = 0;
        $duplicateCount = 0;
        
        foreach ($digitalCodes as $code) {
            $code = trim($code);
            
            // التحقق من عدم وجود الكود مسبقاً
            $existingCode = \App\Models\DigitalCardCode::where('code', $code)
                ->where(function($query) use ($product) {
                    $query->where('product_id', $product->id)
                        ->orWhere('digital_card_id', function($subQuery) use ($product) {
                            $subQuery->from('digital_cards')
                                ->whereColumn('digital_cards.id', 'digital_card_codes.digital_card_id')
                                ->where('digital_cards.product_id', $product->id);
                        });
                })
                ->first();
            
            if ($existingCode) {
                $duplicateCount++;
                continue;
            }
            
            // إضافة الكود إلى جدول digital_card_codes
            \App\Models\DigitalCardCode::create([
                'product_id' => $product->id,
                'code' => $code,
                'status' => 'available'
            ]);
            
            $migratedCount++;
        }
        
        // مسح الأكواد من الحقل القديم بعد ترحيلها
        $product->update([
            'digital_codes' => null
        ]);
        
        // تحديث مخزون المنتج بعدد الأكواد المتاحة
        $availableCodesCount = \App\Models\DigitalCardCode::where('product_id', $product->id)
            ->where('status', 'available')
            ->count();
            
        $product->update(['stock' => $availableCodesCount]);
        
        $message = "تم ترحيل {$migratedCount} كود بنجاح";
        if ($duplicateCount > 0) {
            $message .= " وتجاهل {$duplicateCount} كود مكرر";
        }
        
        return redirect()->route('dashboard.products.manage-codes', $product)
            ->with('success', $message);
    }

    /**
     * تغيير حالة المنتج
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:active,inactive,out-of-stock',
        ]);

        // إزالة القيد: السماح بتعيين out-of-stock لأي منتج
        if ($validatedData['status'] === 'out-of-stock') {
            $product->update(['status' => 'out-of-stock']);
            return redirect()->route('dashboard.products.index')
                ->with('success', 'تم تغيير حالة المنتج إلى نفذ المخزون بنجاح');
        }
        // للحالات الأخرى (نشط أو غير نشط)
        $product->update(['status' => $validatedData['status']]);
        $statusText = $validatedData['status'] == 'active' ? 'نشط' : 'غير نشط';
        return redirect()->route('dashboard.products.index')
                        ->with('success', "تم تغيير حالة المنتج إلى {$statusText} بنجاح");
    }
    
    /**
     * تعيين البطاقة الرقمية كـ "نفذ المخزون"
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsOutOfStock(Product $product)
    {
        if ($product->type !== 'digital_card') {
            return redirect()->route('dashboard.products.index')
                         ->with('error', 'يمكن استخدام هذه الميزة فقط مع البطاقات الرقمية');
        }
        
        // تعيين حالة المنتج إلى "نفذ المخزون" دون تغيير المخزون أو حالة الأكواد
        $product->update(['status' => 'out-of-stock']);
            
        return redirect()->route('dashboard.products.index')
                        ->with('success', 'تم تعيين البطاقة الرقمية كـ "نفذ المخزون" بنجاح');
    }

    /**
     * عرض صفحة إدارة الحسابات للمنتج
     */
    public function manageAccounts(Product $product)
    {
        return view('themes.dashboard.products.manage-accounts', compact('product'));
    }

    // إضافة حسابات جديدة (عدة حسابات دفعة واحدة)
    public function storeAccounts(Request $request, Product $product)
    {
        $accounts = $request->accounts;
        if (!$accounts && $request->has('text')) {
            $accounts = [ $request->text ];
        }
        if (!is_array($accounts)) {
            $accounts = [];
        }
        $added = 0;
        foreach ($accounts as $line) {
            $line = trim($line);
            if ($line !== '') {
                \App\Models\AccountDigetal::create([
                    'product_id' => $product->id,
                    'status' => 'available',
                    'meta' => ['text' => Crypt::encryptString($line)],
                ]);
                $added++;
            }
        }
        $product->increment('stock', $added);
        return back()->with('success', 'تمت إضافة ' . $added . ' حساب(ات) بنجاح');
    }

    // تحديث حساب
    public function updateAccount(Request $request, Product $product, \App\Models\AccountDigetal $account)
    {
        $request->validate([
            'text' => 'required|string',
        ]);
        $account->update([
            'meta' => ['text' => Crypt::encryptString($request->text)],
        ]);
        return back()->with('success', 'تم تحديث الحساب بنجاح');
    }

    // حذف حساب
    public function destroyAccount(Product $product, \App\Models\AccountDigetal $account)
    {
        $account->delete();
        $product->decrement('stock');
        return back()->with('success', 'تم حذف الحساب بنجاح');
    }
} 