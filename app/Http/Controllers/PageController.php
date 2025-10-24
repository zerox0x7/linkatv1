<?php

namespace App\Http\Controllers;

use App\Facades\Theme;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * عرض صفحة ثابتة
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        // الحصول على المتجر من الطلب
        $store = request()->attributes->get('store');
        
        // البحث عن الصفحة الثابتة في قاعدة البيانات أولاً (بغض النظر عن الحالة)
        if ($store) {
            $staticPage = \App\Models\StaticPage::where('slug', $slug)
                    ->where('store_id', $store->id)
                    ->first();
            
            // إذا كانت الصفحة موجودة
            if ($staticPage) {
                // إذا كانت الصفحة غير مفعلة، عرض صفحة 404
                if (!$staticPage->is_active) {
                    abort(404);
                }
                
                // الصفحة مفعلة، عرضها
                $theme = $store->active_theme;
                
                // التحقق من وجود الصفحة في القالب النشط
                $dynamicView = "themes.{$theme}.pages.dynamic";
                
                if (!view()->exists($dynamicView)) {
                    // إذا لم توجد، استخدم القالب الافتراضي
                    $dynamicView = 'themes.default.pages.dynamic';
                }
                
                return view($dynamicView, [
                    'title' => $staticPage->title,
                    'page' => $staticPage
                ]);
            }
        }
        
        // الصفحة غير موجودة في قاعدة البيانات، التحقق من الصفحات الثابتة المبرمجة
        $validPages = ['terms', 'privacy', 'refund', 'faq', 'about', 'contact'];
        
        if (!in_array($slug, $validPages)) {
            abort(404);
        }
        
        $pageTitle = [
            'terms' => 'شروط الاستخدام',
            'privacy' => 'سياسة الخصوصية',
            'refund' => 'سياسة الاسترجاع',
            'faq' => 'الأسئلة الشائعة',
            'about' => 'من نحن',
            'contact' => 'اتصل بنا',
        ][$slug];
        
        return view(Theme::getThemeView('pages.static.' . $slug), [
            'title' => $pageTitle
        ]);
    }
} 