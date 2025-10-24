<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\DigitalCard;
use App\Facades\Theme;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * حفظ تقييم جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // للتصحيح فقط
        \Log::info('تم استلام طلب التقييم', [
            'request_data' => $request->all(),
            'user_id' => auth()->id() ?? 'غير مسجل دخول'
        ]);
        
        try {
            // التحقق من البيانات
            $validatedData = $request->validate([
                'product_id' => 'required|numeric',
                'product_type' => 'required|string',
                'order_item_id' => 'required|numeric',
                'rating' => 'required|numeric|min:1|max:5',
                'comment' => 'nullable|string|max:500',
            ]);
            
            // التحقق من تسجيل الدخول
            if (!auth()->check()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'يجب تسجيل الدخول لإضافة تقييم',
                        'auth_required' => true
                    ], 401);
                }
                
                return redirect()->route('login')
                    ->with('error', 'يجب تسجيل الدخول لإضافة تقييم');
            }
            
            // التحقق من وجود طلب مكتمل للمستخدم
            $orderItem = OrderItem::with('order')->find($request->order_item_id);

            \Log::info('بيانات التقييم', [
                'order_item_id' => $request->order_item_id,
                'user_id' => auth()->id(),
                'order_item_user_id' => $orderItem ? $orderItem->order->user_id : null,
            ]);

            if (!$orderItem || $orderItem->is_rated) {
                return back()->with('error', 'لقد قمت بتقييم هذا المنتج لهذا الطلب مسبقًا.');
            }
            
            // التحقق من أن الطلب ينتمي للمستخدم الحالي
            if ($orderItem->order->user_id != auth()->id()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لا يمكنك تقييم منتج لم تقم بشرائه'
                    ], 403);
                }
                
                return back()->with('error', 'لا يمكنك تقييم منتج لم تقم بشرائه');
            }
            
            // التحقق من حالة الطلب
            if ($orderItem->order->status !== 'completed') {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لا يمكن تقييم المنتج قبل إكمال الطلب'
                    ], 403);
                }
                
                return back()->with('error', 'لا يمكن تقييم المنتج قبل إكمال الطلب');
            }
            
            // تحديد نوع المنتج
            $productType = $request->product_type;
            $model = null;
            
            // الحصول على نموذج المنتج المناسب بناءً على النوع
            if (strpos($productType, 'Product') !== false) {
                $model = Product::find($request->product_id);
            } elseif (strpos($productType, 'DigitalCard') !== false) {
                $model = DigitalCard::find($request->product_id);
            }
            
            // التحقق من وجود المنتج
            if (!$model) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'المنتج غير موجود'
                    ], 404);
                }
                
                return back()->with('error', 'المنتج غير موجود');
            }
            
            // إنشاء تقييم جديد
            $review = new Review();
            $review->user_id = auth()->id();
            $review->reviewable_id = $request->product_id;
            $review->reviewable_type = $productType;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->order_item_id = $request->order_item_id;
            $review->is_approved = false;
            $review->save();
            
            // تحديث تقييم المنتج
            if (method_exists($model, 'updateRating')) {
                $model->updateRating();
            }
            
            \Log::info('تم حفظ التقييم بنجاح', [
                'review_id' => $review->id,
                'product_id' => $request->product_id,
                'rating' => $request->rating
            ]);
            
            $orderItem->is_rated = true;
            $orderItem->save();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال تقييمك بنجاح! شكراً لمشاركة رأيك.'
                ]);
            }
            
            return back()->with('review_success_' . $orderItem->id, 'تم إرسال تقييمك بنجاح! شكراً لمشاركة رأيك.');
        } catch (\Exception $e) {
            \Log::error('خطأ في معالجة التقييم', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء معالجة التقييم: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'حدث خطأ أثناء معالجة التقييم: ' . $e->getMessage());
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
