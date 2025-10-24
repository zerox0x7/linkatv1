<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaticPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('themes.admin.static-pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('themes.admin.static-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = $request->attributes->get('store');
        
        // التحقق من أن store_id يطابق المستخدم الحالي
        if($request->input('store_id') != $store->id) {
            abort(403, 'Unauthorized action.');
        }

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'store_id' => 'required|numeric|exists:users,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:static_pages,slug',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // تنظيف الـ slug
        $validated['slug'] = Str::slug($request->slug);
        
        // معالجة checkbox is_active
        $validated['is_active'] = $request->has('is_active');
        
        // تعيين القيمة الافتراضية للترتيب
        $validated['order'] = $request->input('order', 0);

        // إنشاء الصفحة
        $staticPage = StaticPage::create($validated);

        return redirect()
            ->route('admin.static-pages.index')
            ->with('success', 'تم إضافة الصفحة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $store = $request->attributes->get('store');
        
        // البحث عن الصفحة والتحقق من أنها تابعة للمتجر
        $page = StaticPage::where('id', $id)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        return view('themes.admin.static-pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $store = $request->attributes->get('store');
        
        // البحث عن الصفحة والتحقق من أنها تابعة للمتجر
        $page = StaticPage::where('id', $id)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        // التحقق من أن store_id يطابق المستخدم الحالي
        if($request->input('store_id') != $store->id) {
            abort(403, 'Unauthorized action.');
        }

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'store_id' => 'required|numeric|exists:users,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:static_pages,slug,' . $id,
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // تنظيف الـ slug
        $validated['slug'] = Str::slug($request->slug);
        
        // معالجة checkbox is_active
        $validated['is_active'] = $request->has('is_active');
        
        // تعيين القيمة الافتراضية للترتيب
        $validated['order'] = $request->input('order', 0);

        // تحديث الصفحة
        $page->update($validated);

        return redirect()
            ->route('admin.static-pages.index')
            ->with('success', 'تم تحديث الصفحة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $store = $request->attributes->get('store');
        
        // البحث عن الصفحة والتحقق من أنها تابعة للمتجر
        $page = StaticPage::where('id', $id)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        $page->delete();

        return redirect()
            ->route('admin.static-pages.index')
            ->with('success', 'تم حذف الصفحة بنجاح');
    }
}
