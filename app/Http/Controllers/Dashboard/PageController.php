<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Setting;

class PageController extends Controller
{
    /**
     * عرض قائمة الصفحات
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pages = Page::orderBy('title')->get();
        $footer_links_title = Setting::get('footer_links_title', 'روابط سريعة');
        $footer_policies_title = Setting::get('footer_policies_title', 'السياسات');
        return view('themes.dashboard.pages.index', compact('pages', 'footer_links_title', 'footer_policies_title'));
    }

    /**
     * عرض نموذج إنشاء صفحة جديدة
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('themes.dashboard.pages.create');
    }

    /**
     * حفظ صفحة جديدة
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pages',
                'content' => 'required|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
            ]);
            
            if(empty($validatedData['slug'])) {
                $validatedData['slug'] = Str::slug($validatedData['title']);
            }
            
            // Checkboxes - only set if present in the request
            $validatedData['is_active'] = $request->has('is_active');
            $validatedData['show_in_menu'] = $request->has('show_in_menu');
            
            Page::create($validatedData);
            
            return redirect()->route('dashboard.pages.index')
                ->with('success', 'تم إنشاء الصفحة بنجاح.');
        } catch (\Exception $e) {
            Log::error('خطأ في إنشاء صفحة', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إنشاء الصفحة: ' . $e->getMessage());
        }
    }

    /**
     * عرض الصفحة
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\View\View
     */
    public function show(Page $page)
    {
        return view('themes.dashboard.pages.show', compact('page'));
    }

    /**
     * عرض نموذج تعديل الصفحة
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\View\View
     */
    public function edit(Page $page)
    {
        return view('themes.dashboard.pages.edit', compact('page'));
    }

    /**
     * تحديث الصفحة
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Page $page)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
                'content' => 'required|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
            ]);
            
            if(empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }
            
            // Manually set the boolean values - don't validate them
            $data['is_active'] = $request->has('is_active');
            $data['show_in_menu'] = $request->has('show_in_menu');
            
            $page->update($data);
            
            return redirect()->route('dashboard.pages.index')
                ->with('success', 'تم تحديث الصفحة بنجاح.');
        } catch (\Exception $e) {
            Log::error('خطأ في تحديث صفحة', [
                'page_id' => $page->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث الصفحة: ' . $e->getMessage());
        }
    }

    /**
     * حذف الصفحة
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        try {
            $page->delete();
            
            return redirect()->route('dashboard.pages.index')
                ->with('success', 'تم حذف الصفحة بنجاح.');
        } catch (\Exception $e) {
            Log::error('خطأ في حذف صفحة', [
                'page_id' => $page->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف الصفحة: ' . $e->getMessage());
        }
    }

    /**
     * صفحة إدارة الصفحة الرئيسية
     *
     * @return \Illuminate\View\View
     */
    public function homeManager()
    {
        $homeSections = \App\Models\HomeSection::orderBy('sort_order')->get();
        return view('themes.dashboard.pages.home-manager', compact('homeSections'));
    }
} 