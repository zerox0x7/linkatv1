<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SiteReview;
use Illuminate\Http\Request;

class SiteReviewController extends Controller
{
    /**
     * عرض قائمة تقييمات الموقع الرئيسية
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $siteReviews = SiteReview::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('themes.dashboard.site-reviews.index', compact('siteReviews'));
    }

    /**
     * عرض نموذج إنشاء تقييم جديد
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('themes.dashboard.site-reviews.create');
    }

    /**
     * تخزين تقييم جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
            'is_approved' => 'required|boolean',
        ]);
        
        SiteReview::create($validated);
        
        return redirect()->route('dashboard.site-reviews.index')
            ->with('success', 'تم إضافة تقييم جديد بنجاح');
    }

    /**
     * عرض تفاصيل تقييم محدد
     *
     * @param  \App\Models\SiteReview  $siteReview
     * @return \Illuminate\View\View
     */
    public function show(SiteReview $siteReview)
    {
        $siteReview->load('user');
        return view('themes.dashboard.site-reviews.show', compact('siteReview'));
    }

    /**
     * عرض نموذج تعديل تقييم
     *
     * @param  \App\Models\SiteReview  $siteReview
     * @return \Illuminate\View\View
     */
    public function edit(SiteReview $siteReview)
    {
        return view('themes.dashboard.site-reviews.edit', compact('siteReview'));
    }

    /**
     * تحديث تقييم محدد
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteReview  $siteReview
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SiteReview $siteReview)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'nullable|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|max:500',
                'is_approved' => 'required|boolean',
            ], [
                'name.required' => 'يرجى إدخال اسم العميل',
                'name.max' => 'اسم العميل يجب أن لا يتجاوز 255 حرف',
                'position.max' => 'المسمى الوظيفي يجب أن لا يتجاوز 255 حرف',
                'rating.required' => 'يرجى اختيار التقييم',
                'rating.min' => 'التقييم يجب أن يكون على الأقل نجمة واحدة',
                'rating.max' => 'التقييم يجب أن لا يتجاوز 5 نجوم',
                'review.required' => 'يرجى إدخال التعليق',
                'review.max' => 'التعليق يجب أن لا يتجاوز 500 حرف',
            ]);
            
            $siteReview->update($validated);
            
            \Log::info('تم تحديث تقييم الموقع بنجاح', [
                'review_id' => $siteReview->id,
                'name' => $siteReview->name,
                'rating' => $siteReview->rating,
                'is_approved' => $siteReview->is_approved
            ]);
            
            return redirect()->route('dashboard.site-reviews.index')
                ->with('success', 'تم تحديث التقييم بنجاح');
                
        } catch (\Exception $e) {
            \Log::error('خطأ أثناء تحديث تقييم الموقع', [
                'error' => $e->getMessage(),
                'review_id' => $siteReview->id,
                'request_data' => $request->all()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث التقييم. يرجى المحاولة مرة أخرى.');
        }
    }

    /**
     * تغيير حالة الموافقة على التقييم
     *
     * @param  \App\Models\SiteReview  $siteReview
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleApproval(SiteReview $siteReview)
    {
        $siteReview->is_approved = !$siteReview->is_approved;
        $siteReview->save();
        
        $status = $siteReview->is_approved ? 'معتمدة' : 'غير معتمدة';
        return redirect()->back()
            ->with('success', "تم تغيير حالة التقييم إلى {$status}");
    }

    /**
     * حذف تقييم محدد
     *
     * @param  \App\Models\SiteReview  $siteReview
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SiteReview $siteReview)
    {
        $siteReview->delete();

        return redirect()->route('dashboard.site-reviews.index')
            ->with('success', 'تم حذف التقييم بنجاح');
    }
} 