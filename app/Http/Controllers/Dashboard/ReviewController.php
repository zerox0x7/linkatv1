<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * عرض قائمة المراجعات والتقييمات
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reviews = Review::with(['user', 'reviewable'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('themes.dashboard.reviews.index', compact('reviews'));
    }

    /**
     * عرض تفاصيل مراجعة محددة
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\View\View
     */
    public function show(Review $review)
    {
        $review->load(['user', 'reviewable']);
        return view('themes.dashboard.reviews.show', compact('review'));
    }

    /**
     * عرض نموذج تعديل مراجعة
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\View\View
     */
    public function edit(Review $review)
    {
        return view('themes.dashboard.reviews.edit', compact('review'));
    }

    /**
     * تحديث مراجعة محددة
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'review' => 'nullable|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'is_approved' => 'required|boolean',
        ]);
        
        $review->update($validated);
        
        // تحديث تقييم المنتج
        if ($review->reviewable) {
            $review->reviewable->updateRating();
        }

        return redirect()->route('dashboard.reviews.index')
            ->with('success', 'تم تحديث المراجعة بنجاح');
    }

    /**
     * تغيير حالة الموافقة على المراجعة
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleApproval(Review $review)
    {
        $review->is_approved = !$review->is_approved;
        $review->save();
        
        // تحديث تقييم المنتج
        if ($review->reviewable) {
            $review->reviewable->updateRating();
        }

        $status = $review->is_approved ? 'معتمدة' : 'غير معتمدة';
        return redirect()->back()
            ->with('success', "تم تغيير حالة المراجعة إلى {$status}");
    }

    /**
     * حذف مراجعة محددة
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Review $review)
    {
        $reviewable = $review->reviewable;
        
        $review->delete();
        
        // تحديث تقييم المنتج بعد الحذف
        if ($reviewable) {
            $reviewable->updateRating();
        }

        return redirect()->route('dashboard.reviews.index')
            ->with('success', 'تم حذف المراجعة بنجاح');
    }

    /**
     * عرض نموذج إضافة تقييم جديد
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $products = \App\Models\Product::all();
        $users = \App\Models\User::all();
        return view('themes.dashboard.reviews.create', compact('products', 'users'));
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
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'is_approved' => 'required|boolean',
        ]);

        $product = \App\Models\Product::findOrFail($validated['product_id']);
        
        $review = new Review([
            'user_id' => $validated['user_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => $validated['is_approved'],
        ]);

        $product->reviews()->save($review);
        
        // تحديث تقييم المنتج
        $product->updateRating();

        return redirect()->route('dashboard.reviews.index')
            ->with('success', 'تم إضافة التقييم بنجاح');
    }
} 