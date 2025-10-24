<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\DigitalCardCode;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * عرض صفحة إتمام الطلب
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        // التحقق من أن المستخدم مسجل الدخول
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول لإتمام عملية الشراء');
        }

        // الحصول على الثيم النشط
        $theme = $request->attributes->get('theme');
        
        $cart = $this->getCart();
        
        // التحقق من وجود منتجات في السلة
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'سلة التسوق فارغة');
        }
        
        // التحقق من توفر المنتجات في المخزون
        foreach ($cart->items as $item) {
            $product = $item->cartable;
            if (!$product) {
                return redirect()->route('cart.index')->with('error', 'أحد المنتجات في السلة غير موجود أو تم حذفه');
            }
            $productType = get_class($product);
            
            // تسجيل معلومات المنتج للتشخيص
            \Illuminate\Support\Facades\Log::info('التحقق من مخزون المنتج', [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_type' => $productType,
                'requested_quantity' => $item->quantity
            ]);
            
            // التحقق بشكل دقيق للمنتجات الرقمية
            if ($product instanceof \App\Models\Product) {
                if ($product->type === 'digital_card') {
                    // التحقق من عدد الأكواد المتاحة
                    $availableCount = \App\Models\DigitalCardCode::where('product_id', $product->id)
                        ->where('status', 'available')
                        ->whereNull('order_id')
                        ->whereNull('user_id')
                        ->count();
                    
                    \Illuminate\Support\Facades\Log::info('عدد الأكواد المتاحة', [
                        'product_id' => $product->id,
                        'available_count' => $availableCount,
                        'requested' => $item->quantity
                    ]);
                    
                    if ($availableCount < $item->quantity) {
                        return redirect()->route('cart.index')->with('error', "المنتج {$product->name} غير متوفر بالكمية المطلوبة");
                    }
                } else {
                    // منتج عادي
                    if ($product->stock < $item->quantity || $product->stock <= 0) {
                        return redirect()->route('cart.index')->with('error', "المنتج {$product->name} غير متوفر بالكمية المطلوبة");
                    }
                }
            } elseif ($product instanceof \App\Models\DigitalCard) {
                // بطاقة رقمية
                $availableCount = $product->codes()
                    ->where('status', 'available')
                    ->whereNull('order_id')
                    ->whereNull('user_id')
                    ->count();
                
                if ($availableCount < $item->quantity || $availableCount <= 0) {
                    return redirect()->route('cart.index')->with('error', "البطاقة {$product->name} غير متوفرة بالكمية المطلوبة");
                }
            }
        }
        
        // الحصول على طرق الدفع المفعلة فقط
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        // الحصول على البيانات المطلوبة للثيم
        $store = $request->attributes->get('store');
        $homePage = \App\Models\HomePage::where('store_id', $store->id)->first() ?? new \App\Models\HomePage();
        $headerSettings = \App\Models\HeaderSettings::getSettings($store->id);
        
        // تحقق صارم من الكوبون عند عرض صفحة الدفع
        $couponData = session('coupon');
        if ($couponData) {
            $coupon = \App\Models\Coupon::find($couponData['id']);
            if ($coupon && $coupon->isValid()) {
                $productIds = $coupon->product_ids ? json_decode($coupon->product_ids, true) : [];
                $categoryIds = $coupon->category_ids ? json_decode($coupon->category_ids, true) : [];
                $matchedItems = $cart->items->filter(function($item) use ($productIds, $categoryIds) {
                    if (empty($productIds) && empty($categoryIds)) {
                        return true;
                    }
                    if (!empty($productIds) && empty($categoryIds)) {
                        return $item->cartable instanceof \App\Models\Product && in_array($item->cartable_id, $productIds);
                    }
                    if (empty($productIds) && !empty($categoryIds)) {
                        return isset($item->cartable->category_id) && in_array($item->cartable->category_id, $categoryIds);
                    }
                    return (
                        ($item->cartable instanceof \App\Models\Product && in_array($item->cartable_id, $productIds))
                        || (isset($item->cartable->category_id) && in_array($item->cartable->category_id, $categoryIds))
                    );
                });
                if ($matchedItems->isEmpty()) {
                    session()->forget('coupon');
                    return redirect()->route('cart.index')->with('error', 'تم حذف المنتج المشمول بالكوبون من السلة، لم يعد الكود ينطبق.');
                }
            }
        }
        
        return view('themes.'.$theme.'.pages.checkout.index', compact('cart', 'paymentMethods', 'homePage', 'headerSettings', 'store'));
    }
    
    /**
     * معالجة طلب الشراء
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'payment_method' => 'required|exists:payment_methods,code,is_active,1',
        ]);
        
        $user = auth()->user();
        $cart = $this->getCart();
        
        // التحقق من وجود منتجات في السلة
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'سلة التسوق فارغة');
        }
        
        // التحقق من توفر المنتجات في المخزون قبل المتابعة
        foreach ($cart->items as $item) {
            $product = $item->cartable;
            $productType = get_class($product);
            
            // تسجيل معلومات المنتج للتشخيص
            \Illuminate\Support\Facades\Log::info('التحقق من مخزون المنتج أثناء عملية الطلب', [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_type' => $productType,
                'requested_quantity' => $item->quantity
            ]);
            
            // التحقق بشكل دقيق للمنتجات الرقمية
            if ($product instanceof \App\Models\Product) {
                if ($product->type === 'digital_card') {
                    // التحقق من عدد الأكواد المتاحة
                    $availableCount = \App\Models\DigitalCardCode::where('product_id', $product->id)
                        ->where('status', 'available')
                        ->whereNull('order_id')
                        ->whereNull('user_id')
                        ->count();
                    
                    \Illuminate\Support\Facades\Log::info('عدد الأكواد المتاحة أثناء الطلب', [
                        'product_id' => $product->id,
                        'available_count' => $availableCount,
                        'requested' => $item->quantity
                    ]);
                    
                    if ($availableCount < $item->quantity) {
                        return redirect()->route('cart.index')->with('error', "المنتج {$product->name} غير متوفر بالكمية المطلوبة");
                    }
                } else {
                    // منتج عادي
                    if ($product->stock < $item->quantity || $product->stock <= 0) {
                        return redirect()->route('cart.index')->with('error', "المنتج {$product->name} غير متوفر بالكمية المطلوبة");
                    }
                }
            } elseif ($product instanceof \App\Models\DigitalCard) {
                // بطاقة رقمية
                $availableCount = $product->codes()
                    ->where('status', 'available')
                    ->whereNull('order_id')
                    ->whereNull('user_id')
                    ->count();
                
                if ($availableCount < $item->quantity || $availableCount <= 0) {
                    return redirect()->route('cart.index')->with('error', "البطاقة {$product->name} غير متوفرة بالكمية المطلوبة");
                }
            }
        }
        
        // الحصول على طريقة الدفع المحددة والتأكد من أنها مفعلة
        $paymentMethod = \App\Models\PaymentMethod::where('code', $request->payment_method)
            ->where('is_active', true)
            ->first();
            
        if (!$paymentMethod) {
            return redirect()->route('checkout.index')->with('error', 'طريقة الدفع غير متاحة');
        }
        
        // --- منطق الكوبون والخصم ---
        $discount = 0;
        $couponCode = null;
        $couponData = session('coupon');
        if ($couponData) {
            $coupon = \App\Models\Coupon::find($couponData['id']);
            if ($coupon && $coupon->isValid()) {
                $productIds = $coupon->product_ids ? json_decode($coupon->product_ids, true) : [];
                $categoryIds = $coupon->category_ids ? json_decode($coupon->category_ids, true) : [];
                $matchedItems = $cart->items->filter(function($item) use ($productIds, $categoryIds) {
                    if (empty($productIds) && empty($categoryIds)) {
                        return true;
                    }
                    if (!empty($productIds) && empty($categoryIds)) {
                        return $item->cartable instanceof \App\Models\Product && in_array($item->cartable_id, $productIds);
                    }
                    if (empty($productIds) && !empty($categoryIds)) {
                        return isset($item->cartable->category_id) && in_array($item->cartable->category_id, $categoryIds);
                    }
                    return (
                        ($item->cartable instanceof \App\Models\Product && in_array($item->cartable_id, $productIds))
                        || (isset($item->cartable->category_id) && in_array($item->cartable->category_id, $categoryIds))
                    );
                });
                if ($matchedItems->isNotEmpty()) {
                    $matchedTotal = $matchedItems->sum(function($item) {
                        return $item->price * $item->quantity;
                    });
                    $discount = $coupon->calculateDiscount($matchedTotal);
                    $couponCode = $coupon->code;
                } else {
                    // لا يوجد منتج مشمول، احذف الكوبون من الجلسة وأعد المستخدم للسلة مع رسالة
                    session()->forget('coupon');
                    return redirect()->route('cart.index')->with('error', 'تم حذف المنتج المشمول بالكوبون من السلة، لم يعد الكود ينطبق.');
                }
            }
        }
        // --- نهاية منطق الكوبون ---

        // حساب إجمالي الطلب بعد الخصم
        $subTotal = $cart->getTotal();
        $total = max(0, $subTotal - $discount);
        
        // التحقق من حدود المبلغ لطريقة الدفع
        if (!$paymentMethod->isAmountWithinLimits($total)) {
            if ($paymentMethod->min_order_amount && $total < $paymentMethod->min_order_amount) {
                return redirect()->route('checkout.index')->with('error', "الحد الأدنى للطلب باستخدام {$paymentMethod->name} هو {$paymentMethod->min_order_amount} ر.س");
            }
            
            if ($paymentMethod->max_order_amount && $total > $paymentMethod->max_order_amount) {
                return redirect()->route('checkout.index')->with('error', "الحد الأقصى للطلب باستخدام {$paymentMethod->name} هو {$paymentMethod->max_order_amount} ر.س");
            }
        }
        
        // Prepare custom product data
        $customData = [];
        $hasCustomProducts = false;
        
        foreach ($cart->items as $cartItem) {
            // Check if item has custom data
            if (isset($cartItem->options) && is_array($cartItem->options)) {
                $hasCustomData = false;
                $itemData = [
                    'product_id' => $cartItem->cartable_id,
                    'name' => $cartItem->cartable->name,
                ];
                
                // تخزين معرفات العميل/اللاعب
                if (isset($cartItem->options['player_data'])) {
                    $itemData['player_data'] = $cartItem->options['player_data'];
                    $hasCustomData = true;
                }
                
                // تخزين بيانات الحقول المخصصة القديمة للتوافق مع النظام السابق
                if (isset($cartItem->options['custom_fields_data'])) {
                    $customFields = is_string($cartItem->options['custom_fields_data']) ? 
                                    json_decode($cartItem->options['custom_fields_data'], true) : 
                                    $cartItem->options['custom_fields_data'];
                    
                    $itemData['data'] = $customFields;
                    $hasCustomData = true;
                }
                
                // تخزين بيانات خيار السعر المحدد
                if (isset($cartItem->options['service_option'])) {
                    $itemData['service'] = $cartItem->options['service_option'];
                    $hasCustomData = true;
                } elseif (isset($cartItem->options['selected_option_name']) || isset($cartItem->options['selected_price_option'])) {
                    $itemData['service'] = [
                        'name' => $cartItem->options['selected_option_name'] ?? 'خدمة مخصصة',
                        'price' => $cartItem->options['selected_price'] ?? null,
                        'option_id' => $cartItem->options['selected_price_option'] ?? null
                    ];
                    $hasCustomData = true;
                }
                
                // إذا وجدت بيانات مخصصة، أضفها إلى المصفوفة الرئيسية
                if ($hasCustomData) {
                    $hasCustomProducts = true;
                    $customData[$cartItem->id] = $itemData;
                }
            }
        }
        
        // إنشاء الطلب
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total' => $total,
            'sub_total' => $subTotal,
            'discount' => $discount,
            'payment_method' => $request->payment_method,
            'coupon_code' => $couponCode,
            'custom_data' => $customData,
            'has_custom_products' => $hasCustomProducts,
        ]);
        
        // نقل عناصر السلة إلى عناصر الطلب
        foreach ($cart->items as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $item->cartable_id,
                'orderable_type' => $item->cartable_type,
                'name' => $item->cartable->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->price * $item->quantity,
                'options' => $item->options,
            ]);
            
            // تم إلغاء خفض المخزون هنا لأنه سيتم عند اكتمال الدفع فقط
            // نحتفظ بالمنتج للاستخدام لاحقاً
            $product = $item->cartable;
        }
        
        // معالجة الدفع حسب بوابة الدفع المختارة
        if ($request->payment_method === 'balance') {
            // الدفع من رصيد المستخدم
            if ($user->balance < $total) {
                return redirect()->route('checkout.index')->with('error', 'رصيدك غير كافي لإتمام عملية الشراء');
            }
            
            $user->deductBalance($total);
            
            // إنشاء سجل الدفع
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_id' => 'BAL-' . strtoupper(Str::random(10)),
                'payer_id' => $user->id,
                'payer_email' => $user->email,
                'amount' => $total,
                'currency' => 'SAR',
                'payment_status' => 'completed',
                'payment_method' => 'balance',
            ]);
            
            // تحديث حالة الطلب
            if ($order->status !== 'completed') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'paid_at' => now(),
                ]);
            } else {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);
            }
            
            // زيادة عدد طلبات المستخدم
            $user->increment('orders_count');
            
            // تفريغ سلة التسوق
            $cart->items()->delete();
            
            return redirect()->route('orders.show', $order->id)->with('success', 'تم إتمام الطلب بنجاح');
        } 
        // التحويل البنكي
        elseif ($request->payment_method === 'bank_transfer') {
            // إنشاء سجل الدفع
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'currency' => $paymentMethod->default_currency ?? 'SAR',
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod->code,
            ]);
            
            // تفريغ سلة التسوق للتحويل البنكي فقط
            $cart->items()->delete();
            
            return redirect()->route('payment.bank_transfer', $order->id);
        }
        // بوابة كليك باي
        elseif ($request->payment_method === 'clickpay') {
            // إنشاء سجل الدفع
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'currency' => $paymentMethod->default_currency ?? 'SAR',
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod->code,
            ]);
            
            // حفظ معرف الطلب في الجلسة للتعامل معه لاحقاً
            session()->put('pending_order_id', $order->id);
            
            // توجيه مباشرة لبوابة كليك باي
            return redirect()->route('payment.clickpay', $order->id);
        }
        // بوابة باي بال
        elseif ($request->payment_method === 'paypal') {
            // إنشاء سجل الدفع
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'currency' => $paymentMethod->default_currency ?? 'USD',
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod->code,
            ]);
            
            // حفظ معرف الطلب في الجلسة للتعامل معه لاحقاً
            session()->put('pending_order_id', $order->id);
            
            try {
                // إنشاء كائن بوابة الدفع باستخدام المصنع
                $gateway = $paymentMethod->createGateway();
                
                // معالجة الدفع باستخدام البوابة
                $result = $gateway->processPayment($order);
                
                // إذا كان هناك رابط تحويل، قم بتوجيه المستخدم إليه
                if (isset($result['redirect_url']) && $result['redirect_url']) {
                    return redirect()->away($result['redirect_url']);
                }
                
                return redirect()->route('checkout.index')->with('error', 'فشلت عملية الدفع: ' . ($result['message'] ?? 'خطأ غير معروف'));
            } catch (\Exception $e) {
                return redirect()->route('checkout.index')->with('error', 'حدث خطأ أثناء معالجة الدفع: ' . $e->getMessage());
            }
        }
        // بوابات أخرى
        else {
            try {
                // إنشاء كائن بوابة الدفع باستخدام المصنع
                $gateway = $paymentMethod->createGateway();
                
                // إنشاء سجل الدفع
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $total,
                    'currency' => $paymentMethod->default_currency ?? 'SAR',
                    'payment_status' => 'pending',
                    'payment_method' => $paymentMethod->code,
                ]);
                
                // معالجة الدفع باستخدام البوابة
                $result = $gateway->processPayment($order);
                
                // إذا كان هناك رابط تحويل، قم بتوجيه المستخدم إليه
                if (isset($result['redirect_url']) && $result['redirect_url']) {
                    // حفظ معرف الطلب في الجلسة للتعامل معه لاحقاً
                    session()->put('pending_order_id', $order->id);
                    
                    return redirect()->away($result['redirect_url']);
                }
                
                // إذا نجحت العملية مباشرة
                if ($result['success']) {
                    // تحديث حالة الطلب
                    if ($order->status !== 'completed') {
                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'processing',
                            'paid_at' => now(),
                        ]);
                    } else {
                        $order->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                        ]);
                    }
                    
                    // تفريغ سلة التسوق فقط بعد نجاح العملية
                    $cart->items()->delete();
                    
                    return redirect()->route('orders.show', $order->id)->with('success', 'تم إتمام الطلب بنجاح');
                }
                
                // في حالة فشل الدفع
                return redirect()->route('checkout.index')->with('error', 'فشلت عملية الدفع: ' . ($result['message'] ?? 'خطأ غير معروف'));
            } catch (\Exception $e) {
                // في حالة حدوث خطأ أثناء معالجة الدفع
                return redirect()->route('checkout.index')->with('error', 'حدث خطأ أثناء معالجة الدفع: ' . $e->getMessage());
            }
        }
    }
    
    /**
     * الحصول على سلة التسوق الحالية
     *
     * @return \App\Models\Cart
     */
    protected function getCart()
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate([
                'user_id' => auth()->id(),
            ]);
            
            // دمج سلة الزائر مع سلة المستخدم
            $sessionId = session()->get('cart_session_id');
            
            if ($sessionId) {
                $guestCart = Cart::where('session_id', $sessionId)->first();
                
                if ($guestCart) {
                    foreach ($guestCart->items as $item) {
                        // البحث عن المنتج في سلة المستخدم
                        $existingItem = $cart->items()
                            ->where('cartable_id', $item->cartable_id)
                            ->where('cartable_type', $item->cartable_type)
                            ->first();
                            
                        if ($existingItem) {
                            // تحديث الكمية
                            $existingItem->update([
                                'quantity' => $existingItem->quantity + $item->quantity,
                            ]);
                        } else {
                            // نقل العنصر إلى سلة المستخدم
                            $item->update([
                                'cart_id' => $cart->id,
                            ]);
                        }
                    }
                    
                    // حذف سلة الزائر
                    $guestCart->delete();
                    session()->forget('cart_session_id');
                }
            }
        } else {
            // سلة الزائر
            $sessionId = session()->get('cart_session_id');
            
            if (!$sessionId) {
                $sessionId = Str::uuid();
                session()->put('cart_session_id', $sessionId);
            }
            
            $cart = Cart::firstOrCreate([
                'session_id' => $sessionId,
            ]);
        }
        
        return $cart->load('items.cartable');
    }
} 