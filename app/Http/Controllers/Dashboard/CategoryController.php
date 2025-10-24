<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\ImageUploadController;

class CategoryController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض قائمة التصنيفات
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('themes.admin.categories.index', compact('categories'));
    }

    /**
     * عرض نموذج إنشاء تصنيف جديد
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('themes.admin.categories.create', compact('parentCategories'));
    }

    /**
     * تخزين تصنيف جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'show_in_homepage' => 'boolean',
            'homepage_order' => 'nullable|integer',
            'sort_order' => 'nullable|integer'
        ]);

        // إنشاء سلاق من الاسم
        $validated['slug'] = Str::slug($request->name);
        
        // معالجة الصورة
        if ($request->hasFile('image')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('image'),
                'categories',
                null
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['image' => $result['message']])
                    ->withInput();
            }
            
            $validated['image'] = $result['path'];
        }
        
        // تعيين القيم الافتراضية
        $validated['is_active'] = $request->has('is_active');
        $validated['show_in_homepage'] = $request->has('show_in_homepage');
        $validated['homepage_order'] = $validated['homepage_order'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إضافة التصنيف بنجاح');
    }

    /**
     * عرض تصنيف محدد
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products']);
        return view('themes.admin.categories.show', compact('category'));
    }

    /**
     * عرض نموذج تعديل تصنيف
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
            
        return view('themes.admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * تحديث تصنيف محدد
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'show_in_homepage' => 'boolean',
            'homepage_order' => 'nullable|integer',
            'sort_order' => 'nullable|integer'
        ]);

        // إنشاء سلاق من الاسم إذا تغير الاسم
        if ($category->name !== $request->name) {
            $validated['slug'] = Str::slug($request->name);
        }
        
        // معالجة الصورة
        if ($request->hasFile('image')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('image'),
                'categories',
                $category->image
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['image' => $result['message']])
                    ->withInput();
            }
            
            $validated['image'] = $result['path'];
        }
        
        // تعيين القيم
        $validated['is_active'] = $request->has('is_active');
        $validated['show_in_homepage'] = $request->has('show_in_homepage');
        $validated['homepage_order'] = $validated['homepage_order'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        // التأكد من أن التصنيف لا يكون تابعًا لنفسه أو لأحد أبنائه
        if ($request->filled('parent_id') && $request->parent_id == $category->id) {
            return redirect()->back()
                ->withErrors(['parent_id' => 'لا يمكن أن يكون التصنيف تابعًا لنفسه'])
                ->withInput();
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    /**
     * حذف تصنيف محدد
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        // التحقق من وجود منتجات ضمن هذا التصنيف
        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'لا يمكن حذف هذا التصنيف لأنه يحتوي على منتجات');
        }
        
        // جعل التصنيفات الفرعية تصنيفات رئيسية
        foreach ($category->children as $child) {
            $child->update(['parent_id' => $category->parent_id]);
        }
        
        // حذف الصورة
        if ($category->image) {
            $this->imageUploader->deleteImage($category->image);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم حذف التصنيف بنجاح');
    }
} 