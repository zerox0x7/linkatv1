<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\DigitalCard;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    /**
     * عرض صفحة اختبار التقييم
     */
    public function testRating()
    {
        // الحصول على المنتجات المتاحة للتقييم
        $products = Product::take(5)->get();
        $digitalCards = DigitalCard::take(5)->get();
        
        // الحصول على عنصر طلب للاختبار
        $orderItem = OrderItem::where('is_rated', false)->first();
        $orderItemId = $orderItem ? $orderItem->id : 1;
        
        return view('test-rating', compact('products', 'digitalCards', 'orderItemId'));
    }
    
    /**
     * اختبار إضافة تقييم
     */
    public function testAddRating(Request $request)
    {
        // تسجيل البيانات المستلمة
        Log::info('بيانات طلب التقييم المستلمة:', $request->all());
        
        try {
            // التحقق من البيانات
            $validated = $request->validate([
                'product_id' => 'required|numeric',
                'product_type' => 'required|string',
                'order_item_id' => 'required|numeric',
                'rating' => 'required|numeric|min:1|max:5',
                'review' => 'nullable|string|max:500',
            ]);
            
            // للتأكد من صحة التقييم
            $rating = (int) $request->rating;
            if ($rating < 1 || $rating > 5) {
                Log::warning('قيمة تقييم غير صالحة', ['rating' => $rating]);
                return response()->json([
                    'success' => false,
                    'message' => 'قيمة التقييم يجب أن تكون بين 1 و 5'
                ], 400);
            }
            
            // تحديد نوع المنتج
            $productType = $request->product_type;
            $model = null;
            
            // الحصول على نموذج المنتج المناسب بناءً على النوع
            if (strpos($productType, 'Product') !== false) {
                $model = Product::find($request->product_id);
                Log::info('البحث عن منتج', ['product_id' => $request->product_id, 'found' => $model ? 'نعم' : 'لا']);
            } elseif (strpos($productType, 'DigitalCard') !== false) {
                $model = DigitalCard::find($request->product_id);
                Log::info('البحث عن بطاقة رقمية', ['card_id' => $request->product_id, 'found' => $model ? 'نعم' : 'لا']);
            }
            
            // التحقق من وجود المنتج
            if (!$model) {
                Log::error('المنتج غير موجود للتقييم', [
                    'product_id' => $request->product_id,
                    'product_type' => $productType
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            // معرف المستخدم (استخدام معرف وهمي للتجربة إذا لم يتم تسجيل الدخول)
            $userId = auth()->check() ? auth()->id() : 1;
            
            // دائماً أنشئ تقييم جديد بدون أي تحقق من وجود تقييم سابق
            $orderItem = OrderItem::find($request->order_item_id);
            if (!$orderItem || $orderItem->is_rated) {
                return response()->json([
                    'success' => false,
                    'message' => 'لقد قمت بتقييم هذا المنتج لهذا الطلب مسبقًا.'
                ], 403);
            }
            $review = new Review();
            $review->user_id = $userId;
            $review->reviewable_id = $request->product_id;
            $review->reviewable_type = $productType;
            $review->rating = $request->rating;
            $review->review = $request->review;
            $review->order_item_id = $request->order_item_id;
            $review->is_approved = false;
            $review->save();
            
            Log::info('تم إنشاء تقييم جديد:', [
                'review_id' => $review->id,
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'rating' => $request->rating
            ]);
            
            // تحديث تقييم المنتج
            if (method_exists($model, 'updateRating')) {
                $model->updateRating();
                Log::info('تم تحديث متوسط تقييم المنتج', [
                    'product_id' => $model->id,
                    'new_avg_rating' => $model->rating
                ]);
            }
            
            // تحديث حالة العنصر المطلوب لمنع التقييمات المتكررة (فقط إذا كان موجوداً)
            $orderItem->is_rated = true;
            $orderItem->save();
            Log::info('تم تحديث حالة عنصر الطلب لمنع التقييم المتكرر', [
                'order_item_id' => $orderItem->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال تقييمك بنجاح! شكراً لمشاركة رأيك.',
                'review_id' => $review->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('خطأ أثناء إضافة تقييم:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة طلبك: ' . $e->getMessage(),
                'error' => true
            ], 500);
        }
    }
    
    /**
     * عرض جدول التقييمات
     */
    public function viewReviews()
    {
        $reviews = Review::with(['user', 'reviewable'])->latest()->take(20)->get();
        
        return response()->json([
            'success' => true,
            'reviews' => $reviews
        ]);
    }

    /**
     * حفظ تقييم للزوار بدون مصادقة
     */
    public function guestRating(Request $request)
    {
        // تسجيل البيانات المستلمة
        Log::info('بيانات طلب التقييم المستلمة من الزائر:', $request->all());
        
        try {
            // التحقق من البيانات
            $validated = $request->validate([
                'product_id' => 'required|numeric',
                'product_type' => 'required|string',
                'order_item_id' => 'required|numeric',
                'rating' => 'required|numeric|min:1|max:5',
                'review' => 'nullable|string|max:500',
            ]);
            
            // للتأكد من صحة التقييم
            $rating = (int) $request->rating;
            if ($rating < 1 || $rating > 5) {
                Log::warning('قيمة تقييم غير صالحة', ['rating' => $rating]);
                return response()->json([
                    'success' => false,
                    'message' => 'قيمة التقييم يجب أن تكون بين 1 و 5'
                ], 400);
            }
            
            // تحديد نوع المنتج
            $productType = $request->product_type;
            $model = null;
            
            // الحصول على نموذج المنتج المناسب بناءً على النوع
            if (strpos($productType, 'Product') !== false) {
                $model = Product::find($request->product_id);
                Log::info('البحث عن منتج', ['product_id' => $request->product_id, 'found' => $model ? 'نعم' : 'لا']);
            } elseif (strpos($productType, 'DigitalCard') !== false) {
                $model = DigitalCard::find($request->product_id);
                Log::info('البحث عن بطاقة رقمية', ['card_id' => $request->product_id, 'found' => $model ? 'نعم' : 'لا']);
            }
            
            // التحقق من وجود المنتج
            if (!$model) {
                Log::error('المنتج غير موجود للتقييم', [
                    'product_id' => $request->product_id,
                    'product_type' => $productType
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }
            
            // معرف المستخدم (استخدام معرف وهمي للتجربة إذا لم يتم تسجيل الدخول)
            $userId = auth()->check() ? auth()->id() : 1;
            
            // دائماً أنشئ تقييم جديد بدون أي تحقق من وجود تقييم سابق
            $orderItem = OrderItem::find($request->order_item_id);
            if (!$orderItem || $orderItem->is_rated) {
                return response()->json([
                    'success' => false,
                    'message' => 'لقد قمت بتقييم هذا المنتج لهذا الطلب مسبقًا.'
                ], 403);
            }
            $review = new Review();
            $review->user_id = $userId;
            $review->reviewable_id = $request->product_id;
            $review->reviewable_type = $productType;
            $review->rating = $request->rating;
            $review->review = $request->review;
            $review->order_item_id = $request->order_item_id;
            $review->is_approved = false;
            $review->save();
            
            Log::info('تم إنشاء تقييم جديد:', [
                'review_id' => $review->id,
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'rating' => $request->rating
            ]);
            
            // تحديث تقييم المنتج
            if (method_exists($model, 'updateRating')) {
                $model->updateRating();
                Log::info('تم تحديث متوسط تقييم المنتج', [
                    'product_id' => $model->id,
                    'new_avg_rating' => $model->rating
                ]);
            }
            
            // تحديث حالة العنصر المطلوب لمنع التقييمات المتكررة (فقط إذا كان موجوداً)
            $orderItem->is_rated = true;
            $orderItem->save();
            Log::info('تم تحديث حالة عنصر الطلب لمنع التقييم المتكرر', [
                'order_item_id' => $orderItem->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال تقييمك بنجاح! شكراً لمشاركة رأيك.',
                'review_id' => $review->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('خطأ أثناء إضافة تقييم:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة طلبك: ' . $e->getMessage(),
                'error' => true
            ], 500);
        }
    }
} 