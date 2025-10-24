<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSectionSetting;
use Illuminate\Http\Request;

class HomeSectionSettingController extends Controller
{
    /**
     * عرض قائمة الأقسام الثابتة
     */
    public function index()
    {
        $sections = HomeSectionSetting::orderBy('order')->get();
        return view('themes.admin.home-sections.index', compact('sections'));
    }

    /**
     * عرض نموذج إنشاء قسم ثابت جديد
     */
    public function create()
    {
        return view('themes.admin.home-sections.create');
    }

    /**
     * تخزين قسم ثابت جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        // تسجيل جميع بيانات الطلب للتشخيص
        \Log::info('تم استلام طلب إنشاء قسم جديد', ['data' => $request->all()]);
        
        try {
            $validated = $request->validate([
                'key' => 'required|string|max:100|unique:home_section_settings,key',
                'section_type' => 'nullable|string',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'order' => 'required|integer|min:0',
                'is_active' => 'nullable|boolean',
                'content' => 'nullable',
            ]);
            
            \Log::info('تم التحقق من صحة البيانات بنجاح', ['validated' => $validated]);

            // إذا تم اختيار نوع قسم ولم يتم تحديد مفتاح، استخدم نوع القسم كمفتاح
            if (empty($validated['key']) && !empty($request->section_type)) {
                $validated['key'] = $request->section_type;
                \Log::info('تم استخدام section_type كمفتاح', ['key' => $validated['key']]);
            }

            // تحضير البيانات للإدخال
            $data = [
                'key' => $validated['key'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'order' => $validated['order'],
                'is_active' => isset($validated['is_active']),
                'content' => !empty($validated['content']) ? (is_array($validated['content']) ? $validated['content'] : json_decode($validated['content'], true)) : [],
            ];
            
            \Log::info('البيانات جاهزة للإدخال في قاعدة البيانات', ['data' => $data]);

            $section = HomeSectionSetting::create($data);
            \Log::info('تم إنشاء القسم بنجاح', ['section_id' => $section->id]);
            
            return redirect()->route('admin.home-section-settings.index')
                ->with('success', 'تم إنشاء القسم الثابت بنجاح');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('خطأ في التحقق من صحة البيانات', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\PDOException $e) {
            \Log::error('خطأ في قاعدة البيانات أثناء إنشاء قسم جديد', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'data' => $request->all()
            ]);
            return back()->withInput()->withErrors(['error' => 'حدث خطأ في قاعدة البيانات: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            \Log::error('خطأ عام في إنشاء قسم جديد', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);
            return back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء إنشاء القسم: ' . $e->getMessage()]);
        }
    }

    /**
     * عرض صفحة تعديل قسم التصنيفات
     */
    public function editCategories()
    {
        $section = HomeSectionSetting::getByKey('categories_section');
        return view('themes.admin.home-sections.edit-categories', compact('section'));
    }

    /**
     * عرض صفحة تعديل قسم المميزات
     */
    public function editFeatures()
    {
        $section = HomeSectionSetting::getByKey('features_section');
        return view('themes.admin.home-sections.edit-features', compact('section'));
    }

    /**
     * عرض صفحة تعديل قسم التقييمات
     */
    public function editTestimonials()
    {
        $section = HomeSectionSetting::getByKey('testimonials_section');
        return view('themes.admin.home-sections.edit-testimonials', compact('section'));
    }

    /**
     * عرض صفحة تعديل قسم النشرة البريدية
     */
    public function editNewsletter()
    {
        $section = HomeSectionSetting::getByKey('newsletter_section');
        return view('themes.admin.home-sections.edit-newsletter', compact('section'));
    }

    /**
     * تحديث قسم التصنيفات
     */
    public function updateCategories(Request $request)
    {
        $section = HomeSectionSetting::getByKey('categories_section');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'max_categories' => 'required|integer|min:1|max:12',
            'display_empty_categories' => 'nullable|boolean',
            'layout_type' => 'required|in:grid,carousel',
            'show_image' => 'nullable|boolean',
            'show_product_count' => 'nullable|boolean',
        ]);

        $content = [
            'max_categories' => $validated['max_categories'],
            'display_empty_categories' => isset($validated['display_empty_categories']),
            'layout_type' => $validated['layout_type'],
            'show_image' => isset($validated['show_image']),
            'show_product_count' => isset($validated['show_product_count']),
        ];

        $section->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'is_active' => isset($validated['is_active']),
            'content' => $content
        ]);

        return redirect()->route('admin.home-section-settings.index')
            ->with('success', 'تم تحديث قسم التصنيفات بنجاح');
    }

    /**
     * تحديث قسم المميزات
     */
    public function updateFeatures(Request $request)
    {
        $section = HomeSectionSetting::getByKey('features_section');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'features' => 'required|array',
            'features.*.title' => 'required|string|max:255',
            'features.*.description' => 'required|string',
            'features.*.icon' => 'required|string|max:100',
            'features.*.color' => 'required|string|max:100',
        ]);

        $content = [
            'features' => $validated['features']
        ];

        $section->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'is_active' => isset($validated['is_active']),
            'content' => $content
        ]);

        return redirect()->route('admin.home-section-settings.index')
            ->with('success', 'تم تحديث قسم المميزات بنجاح');
    }

    /**
     * تحديث قسم التقييمات
     */
    public function updateTestimonials(Request $request)
    {
        $section = HomeSectionSetting::getByKey('testimonials_section');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'display_count' => 'required|integer|min:1|max:10',
            'display_default_testimonials' => 'nullable|boolean',
        ]);

        // الحفاظ على التقييمات الافتراضية الموجودة
        $content = $section->content;
        $content['display_count'] = $validated['display_count'];
        $content['display_default_testimonials'] = isset($validated['display_default_testimonials']);

        $section->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'is_active' => isset($validated['is_active']),
            'content' => $content
        ]);

        return redirect()->route('admin.home-section-settings.index')
            ->with('success', 'تم تحديث قسم التقييمات بنجاح');
    }

    /**
     * تحديث قسم النشرة البريدية
     */
    public function updateNewsletter(Request $request)
    {
        $section = HomeSectionSetting::getByKey('newsletter_section');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'button_text' => 'required|string|max:50',
            'placeholder' => 'required|string|max:100',
            'background_color' => 'nullable|string|max:20',
            'show_privacy_text' => 'nullable|boolean',
            'privacy_text' => 'nullable|string',
        ]);

        $content = [
            'button_text' => $validated['button_text'],
            'placeholder' => $validated['placeholder'],
            'background_color' => $validated['background_color'],
            'show_privacy_text' => isset($validated['show_privacy_text']),
            'privacy_text' => $validated['privacy_text'],
        ];

        $section->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'is_active' => isset($validated['is_active']),
            'content' => $content
        ]);

        return redirect()->route('admin.home-section-settings.index')
            ->with('success', 'تم تحديث قسم النشرة البريدية بنجاح');
    }

    /**
     * تبديل حالة القسم (تفعيل/تعطيل)
     */
    public function toggleStatus(Request $request, $id)
    {
        $section = HomeSectionSetting::findOrFail($id);
        $section->is_active = $request->is_active;
        $section->save();
        
        return response()->json(['success' => true]);
    }

    /**
     * إعادة ترتيب الأقسام
     */
    public function reorder(Request $request)
    {
        if (!$request->has('items')) {
            return response()->json(['success' => false, 'message' => 'لم يتم توفير عناصر للترتيب'], 400);
        }
        
        $items = $request->items;
        
        foreach ($items as $item) {
            if (isset($item['id']) && isset($item['order'])) {
                HomeSectionSetting::where('id', $item['id'])->update(['order' => $item['order']]);
            }
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * عرض صفحة تعديل قسم محدد
     */
    public function edit($id)
    {
        $section = HomeSectionSetting::findOrFail($id);
        return view('themes.admin.home-sections.edit', compact('section'));
    }

    /**
     * تحديث بيانات قسم محدد
     */
    public function update(Request $request, $id)
    {
        $section = HomeSectionSetting::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'content' => 'nullable|json',
        ]);

        // تحضير البيانات للتحديث
        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'],
            'is_active' => isset($validated['is_active']),
        ];

        // تحديث المحتوى إذا تم توفيره
        if (isset($validated['content'])) {
            $data['content'] = json_decode($validated['content'], true);
        }

        $section->update($data);

        return redirect()->route('admin.home-section-settings.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    /**
     * حذف قسم محدد
     */
    public function delete($id)
    {
        $section = HomeSectionSetting::findOrFail($id);
        $section->delete();
        
        return redirect()->route('admin.home-section-settings.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
} 

