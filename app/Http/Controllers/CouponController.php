<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * تطبيق كود الخصم على السلة الحالية
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->input('code');
        $coupon = Coupon::where('code', $code)->first();

        // التحقق من وجود الكوبون
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم غير صالح أو غير موجود'
            ], 404);
        }

        // التحقق من صلاحية الكوبون
        if (!$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم منتهي الصلاحية أو تم استنفاذ الحد الأقصى لاستخدامه'
            ], 400);
        }

        // التحقق من ربط الكوبون بمنتجات أو تصنيفات محددة
        $productIds = $coupon->product_ids ? json_decode($coupon->product_ids, true) : [];
        $categoryIds = $coupon->category_ids ? json_decode($coupon->category_ids, true) : [];

        // الحصول على السلة الحالية
        $cart = $this->getCart();
        $cartTotal = $cart->getTotal();

        // جلب المنتجات المطابقة فقط
        $matchedItems = $cart->items->filter(function($item) use ($productIds, $categoryIds) {
            // كوبون عام
            if (empty($productIds) && empty($categoryIds)) {
                return true;
            }
            // كوبون مرتبط بمنتجات فقط
            if (!empty($productIds) && empty($categoryIds)) {
                return in_array($item->cartable_id, $productIds);
            }
            // كوبون مرتبط بتصنيفات فقط
            if (empty($productIds) && !empty($categoryIds)) {
                return isset($item->cartable->category_id) && in_array($item->cartable->category_id, $categoryIds);
            }
            // كوبون مرتبط بكلاهما
            return in_array($item->cartable_id, $productIds) || (isset($item->cartable->category_id) && in_array($item->cartable->category_id, $categoryIds));
        });
        // إذا لم يوجد أي منتج مشمول بالكوبون في السلة، ارفض الكود
        if ($matchedItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم غير صالح أو لا ينطبق على المنتجات في السلة'
            ], 400);
        }
        // حساب مجموع المنتجات المطابقة
        $matchedTotal = $matchedItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        // حساب الخصم فقط على المنتجات المطابقة
        $discount = $coupon->calculateDiscount($matchedTotal);

        // تخزين معلومات الكوبون في الجلسة
        Session::put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => $discount
        ]);
        
        // لا نقوم بزيادة عدد مرات الاستخدام هنا لأنه سيتم زيادته عند إتمام عملية الشراء

        return response()->json([
            'success' => true,
            'message' => 'تم تطبيق كود الخصم بنجاح',
            'discount' => $discount,
            'total' => $cartTotal - $discount,
            'code' => $coupon->code
        ]);
    }

    /**
     * إزالة كود الخصم من السلة الحالية
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCoupon()
    {
        Session::forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'تم إزالة كود الخصم'
        ]);
    }

    /**
     * الحصول على السلة الحالية
     *
     * @return \App\Models\Cart
     */
    protected function getCart()
    {
        // نفس الدالة الموجودة في CartController
        if (auth()->check()) {
            // سلة المستخدم المسجل
            $cart = Cart::with(['items.cartable'])->firstOrCreate([
                'user_id' => auth()->id(),
            ]);
        } else {
            // سلة الزائر
            $sessionId = session()->get('cart_session_id');
            
            if (!$sessionId) {
                $sessionId = Str::uuid();
                session()->put('cart_session_id', $sessionId);
            }
            
            $cart = Cart::with(['items.cartable'])->firstOrCreate([
                'session_id' => $sessionId,
            ]);
        }

        return $cart;
    }

    /**
     * التحقق من صلاحية كود الخصم بدون تطبيقه
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = $request->input('coupon_code');
        $coupon = Coupon::where('code', $code)->first();

        // التحقق من وجود الكوبون
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم غير صالح أو غير موجود'
            ], 404);
        }

        // التحقق من صلاحية الكوبون
        if (!$coupon->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم غير مفعل'
            ], 400);
        }

        if ($coupon->starts_at && now() < $coupon->starts_at) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم غير صالح بعد'
            ], 400);
        }

        if ($coupon->expires_at && now() > $coupon->expires_at) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم منتهي الصلاحية'
            ], 400);
        }

        if ($coupon->max_uses && $coupon->used_times >= $coupon->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'تم استنفاذ الحد الأقصى لاستخدام هذا الكود'
            ], 400);
        }

        // الحصول على السلة الحالية
        $cart = $this->getCart();
        $cartTotal = $cart->getTotal();

        // التحقق من الحد الأدنى للطلب
        if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => "قيمة الطلب يجب أن تكون {$coupon->min_order_amount} ريال سعودي على الأقل لاستخدام هذا الكود"
            ], 400);
        }

        // حساب الخصم
        $discount = 0;
        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } else { // percentage
            $discount = ($cartTotal * $coupon->value) / 100;
        }

        return response()->json([
            'success' => true,
            'message' => 'كود الخصم صالح',
            'discount' => $discount,
            'total' => $cartTotal - $discount,
            'code' => $coupon->code
        ]);
    }
}
