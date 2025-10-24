<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\Dashboard\ImageUploadController;

class HomeSectionController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض قائمة الأقسام
     */
    public function index()
    {
        $sections = HomeSection::orderBy('sort_order')->get();
        return view('themes.admin.home-sections.index', compact('sections'));
    }

    /**
     * عرض نموذج إنشاء قسم جديد
     */
    public function create()
    {
        $categories = Category::all();
        return view('themes.admin.home-sections.form', compact('categories'));
    }

    /**
     * حفظ قسم جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|string|in:featured,latest,best_sellers,category,custom,custom_content,store_features,testimonials,newsletter,browse_categories,all',
            'category_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'settings' => 'nullable|array',
            'content' => 'nullable|string',
        ]);

        // إذا كان النوع ليس تصنيفًا، نحذف معرف التصنيف
        if ($validated['type'] !== 'category') {
            $validated['category_id'] = null;
        }

        // ضبط الحالة النشطة
        $validated['is_active'] = isset($validated['is_active']) ? true : false;

        // معالجة الإعدادات
        $settings = $validated['settings'] ?? [];

        // رفع صورة الخلفية إذا وجدت
        if ($request->hasFile('settings.background_image_file')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('settings.background_image_file'),
                'sections'
            );

            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['settings.background_image_file' => $result['message']])
                    ->withInput();
            }

            $settings['background_image'] = $result['path'];
        }

        unset($settings['background_image_file']);
        $validated['settings'] = $settings;

        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    /**
     * عرض نموذج تعديل قسم
     */
    public function edit(HomeSection $homeSection)
    {
        $section = $homeSection;
        $categories = Category::all();
        return view('themes.admin.home-sections.form', compact('section', 'categories'));
    }

    /**
     * تحديث قسم
     */
    public function update(Request $request, HomeSection $homeSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|string|in:featured,latest,best_sellers,category,custom,custom_content,store_features,testimonials,newsletter,browse_categories,all',
            'category_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'settings' => 'nullable|array',
            'content' => 'nullable|string',
        ]);

        // إذا كان النوع ليس تصنيفًا، نحذف معرف التصنيف
        if ($validated['type'] !== 'category') {
            $validated['category_id'] = null;
        }

        // ضبط الحالة النشطة
        $validated['is_active'] = isset($validated['is_active']) ? true : false;

        // حفظ الإعدادات الجديدة فقط بدون دمج مع القديمة
        $settings = $validated['settings'] ?? [];
        
        // رفع صورة الخلفية إذا وجدت
        if ($request->hasFile('settings.background_image_file')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('settings.background_image_file'),
                'sections',
                $homeSection->settings['background_image'] ?? null
            );

            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['settings.background_image_file' => $result['message']])
                    ->withInput();
            }

            $settings['background_image'] = $result['path'];
        } else if (isset($homeSection->settings['background_image'])) {
            $settings['background_image'] = $homeSection->settings['background_image'];
        }
        
        unset($settings['background_image_file']);
        $validated['settings'] = $settings;

        $homeSection->update($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    /**
     * حذف قسم
     */
    public function destroy(HomeSection $homeSection)
    {
        // حذف صورة الخلفية إذا كانت موجودة
        if (isset($homeSection->settings['background_image'])) {
            $this->imageUploader->deleteImage($homeSection->settings['background_image']);
        }

        $homeSection->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * تبديل حالة القسم (تفعيل/تعطيل)
     */
    public function toggleStatus(Request $request, HomeSection $homeSection)
    {
        $homeSection->is_active = $request->is_active;
        $homeSection->save();
        
        return response()->json(['success' => true]);
    }

    /**
     * إعادة ترتيب الأقسام
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:home_sections,id',
            'sections.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->sections as $section) {
            HomeSection::where('id', $section['id'])->update(['sort_order' => $section['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
} 