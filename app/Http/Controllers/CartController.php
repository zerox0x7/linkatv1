<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\DigitalCard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Facades\Theme;

class CartController extends Controller
{
    /**
     * عرض سلة التسوق
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $theme = $request->attributes->get('theme');
        
        $cart = $this->getCart();
        $cartItems = $cart->items;
        
        // Debug: Log cart data
        \Log::info('Cart Debug', [
            'cart_id' => $cart->id,
            'items_count' => $cartItems->count(),
            'items' => $cartItems->toArray(),
            'session_id' => session()->get('cart_session_id'),
            'user_id' => auth()->id(),
            'laravel_session_id' => session()->getId(),
            'all_session_data' => session()->all()
        ]);
        
        // Calculate totals
        $subtotal = $cart->getSubtotal();
        $shipping = 0; // You can add shipping calculation logic here
        $discount = 0; // You can add discount calculation logic here
        $total = $subtotal + $shipping - $discount;
        
        return view('themes.'.$theme.'.pages.cart.index', compact('cart', 'cartItems', 'subtotal', 'shipping', 'discount', 'total'));
    }

    /**
     * إضافة منتج مباشرة إلى سلة التسوق (GET)
     * يستخدم للشراء المباشر
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addItemAndCheckout(Request $request)
    {
        $store = $request->attributes->get('store');
        $product_id = $request->query('product_id');
        $product_type = $request->query('product_type', 'product');
        $selected_price = $request->query('selected_price');
        $selected_price_option = $request->query('selected_price_option');
        $selected_option_name = $request->query('selected_option_name');
        
        if (!$product_id) {
            return redirect()->route('cart.index');
        }

        // الحصول على المنتج بناءً على النوع
        if ($product_type === 'product') {
            $product = Product::where('store_id', $store->id)
                ->findOrFail($product_id);
            $cartableType = Product::class;
        } else { // digital_card
            $product = DigitalCard::where('store_id', $store->id)
                ->findOrFail($product_id);
            $cartableType = DigitalCard::class;
        }
        
        // تحديد السعر (إما السعر المحدد أو سعر المنتج الافتراضي)
        $price = $selected_price ?? ($product->discount_price ?? $product->price);
        
        // الحصول على السلة أو إنشاء واحدة جديدة
        $cart = $this->getCart();
        
        // إضافة المنتج إلى السلة
        $existingItem = $cart->items()
            ->where('cartable_id', $product_id)
            ->where('cartable_type', $cartableType)
            ->first();
            
        if ($existingItem) {
            // تحديث الكمية إذا كان المنتج موجوداً
            $existingItem->increment('quantity');
        } else {
            // إضافة منتج جديد إلى السلة
            $cart->items()->create([
                'cartable_id' => $product_id,
                'cartable_type' => $cartableType,
                'quantity' => 1,
                'price' => $price,
                'options' => $selected_price_option ? [
                    'selected_price_option' => $selected_price_option,
                    'selected_option_name' => $selected_option_name,
                    'selected_price' => $selected_price
                ] : null,
            ]);
        }
        
        // التوجيه إلى صفحة الدفع مباشرة
        return redirect()->route('checkout.index');
    }

    /**
     * إضافة منتج إلى سلة التسوق
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addItem(Request $request)
    {
        // إذا كان الطلب GET، توجيه إلى طريقة أخرى
        if ($request->isMethod('get')) {
            return $this->addItemAndCheckout($request);
        }

        $request->validate([
            'product_id' => 'required|integer',
            'product_type' => 'required|in:product,digital_card',
            'quantity' => 'integer|min:1',
        ]);

        $store = $request->attributes->get('store');
        $productId = $request->product_id;
        $productType = $request->product_type;
        $quantity = $request->quantity ?? 1;

        // الحصول على المنتج بناءً على النوع
        if ($productType === 'product') {
            $product = Product::where('store_id', $store->id)->find($productId);
            $cartableType = Product::class;
        } else {
            $product = DigitalCard::where('store_id', $store->id)->find($productId);
            $cartableType = DigitalCard::class;
        }

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود أو تم حذفه'
            ], 404);
        }

        // التحقق من المخزون
        if ($productType === 'product' && $product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة غير متوفرة في المخزون'
            ], 400);
        }

        if ($productType === 'digital_card' && $product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة غير متوفرة في المخزون'
            ], 400);
        }

        $cart = $this->getCart();
        
        // تحديد السعر
        $price = $request->selected_price ?? ($product->discount_price ?? $product->price);

        // التحقق من وجود نفس المنتج في السلة
        $existingItem = $cart->items()
            ->where('cartable_id', $productId)
            ->where('cartable_type', $cartableType)
            ->first();

        if ($existingItem) {
            // تحديث الكمية للمنتج الموجود
            $newQuantity = $existingItem->quantity + $quantity;
            
            // التحقق من المخزون مرة أخرى للكمية الجديدة
            if ($productType === 'product' && $product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'الكمية المطلوبة تتجاوز المخزون المتاح'
                ], 400);
            }

            if ($productType === 'digital_card' && $product->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'الكمية المطلوبة تتجاوز المخزون المتاح'
                ], 400);
            }

            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            // إعداد الخيارات
            $options = [];
            if ($request->has('selected_price_option') && $request->has('selected_option_name') && $request->has('selected_price')) {
                $options['selected_price_option'] = [
                    'option_id' => $request->selected_price_option,
                    'name' => $request->selected_option_name,
                    'price' => $request->selected_price
                ];
            } elseif ($request->has('options')) {
                $options = array_merge($options, $request->options);
            }
            
            // إضافة منتج جديد إلى السلة
            $cartItem = $cart->items()->create([
                'cartable_id' => $productId,
                'cartable_type' => $cartableType,
                'quantity' => $quantity,
                'price' => $price,
                'options' => $options,
            ]);
        }

        // إعادة تحميل السلة لضمان الحصول على البيانات المحدثة
        $cart = $cart->fresh(['items']);
        
        // Debug: Log cart after adding item
        \Log::info('Cart After Adding Item', [
            'cart_id' => $cart->id,
            'items_count' => $cart->items->count(),
            'items' => $cart->items->toArray(),
            'session_id' => session()->get('cart_session_id'),
            'user_id' => auth()->id()
        ]);
        
        // حفظ عدد العناصر في الجلسة للتأكد من التزامن
        $cartCount = $cart->getItemsCount();
        session()->put('cart_count', $cartCount);

        // التحقق من وجود طلب للتوجيه إلى صفحة أخرى بعد الإضافة
        if ($request->has('redirect')) {
            $redirect = $request->redirect;
            if ($redirect === 'cart') {
                // توجيه إلى صفحة سلة التسوق
                return redirect()->route('cart.index')->with('success', 'تمت إضافة المنتج إلى سلة التسوق');
            } elseif ($redirect === 'checkout') {
                // توجيه إلى صفحة إتمام الطلب
                return redirect()->route('checkout.index')->with('success', 'تمت إضافة المنتج إلى سلة التسوق');
            }
        }

        // استجابة JSON افتراضية إذا لم يكن هناك توجيه محدد
        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المنتج إلى سلة التسوق',
            'cart_count' => $cartCount,
            'cart_total' => $cart->getTotal(),
            'product_name' => $product->name,
        ]);
    }

    /**
     * تحديث العنصر في سلة التسوق
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();
        $cartItem = $cart->items()->findOrFail($id);
        $quantity = $request->quantity;

        // التحقق من المخزون
        $product = $cartItem->cartable;
        
        if ($cartItem->cartable_type === Product::class && $product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة غير متوفرة في المخزون'
            ], 400);
        }

        if ($cartItem->cartable_type === DigitalCard::class && $product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة غير متوفرة في المخزون'
            ], 400);
        }

        $cartItem->update([
            'quantity' => $quantity,
            // الحفاظ على السعر ولا نقوم بتحديثه
        ]);

        // إعادة تحميل السلة لضمان الحصول على البيانات المحدثة
        $cart = $cart->fresh(['items']);
        
        // حفظ عدد العناصر في الجلسة للتأكد من التزامن
        $cartCount = $cart->getItemsCount();
        session()->put('cart_count', $cartCount);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث سلة التسوق',
            'cart_count' => $cartCount,
            'cart_total' => $cart->getTotal(),
            'item_total' => $cartItem->getTotalAttribute(),
        ]);
    }

    /**
     * حذف عنصر من سلة التسوق
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItem($id)
    {
        $cart = $this->getCart();
        $cartItem = $cart->items()->findOrFail($id);
        
        // حفظ اسم المنتج قبل الحذف
        $productName = $cartItem->cartable->name ?? 'المنتج';
        
        $cartItem->delete();

        // إعادة تحميل السلة لضمان الحصول على البيانات المحدثة
        $cart = $cart->fresh(['items']);
        
        // حفظ عدد العناصر في الجلسة للتأكد من التزامن
        $cartCount = $cart->getItemsCount();
        session()->put('cart_count', $cartCount);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف ' . $productName . ' من سلة التسوق',
            'cart_count' => $cartCount,
            'cart_total' => $cart->getTotal(),
        ]);
    }

    /**
     * تفريغ سلة التسوق
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        // حفظ عدد العناصر في الجلسة (صفر بعد التفريغ)
        session()->put('cart_count', 0);

        return response()->json([
            'success' => true,
            'message' => 'تم تفريغ سلة التسوق',
            'cart_count' => 0,
            'cart_total' => 0,
        ]);
    }

    /**
     * الحصول على سلة التسوق الحالية أو إنشاء سلة جديدة
     *
     * @return \App\Models\Cart
     */
    protected function getCart()
    {
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
                // Force session save
                session()->save();
            }
            
            $cart = Cart::with(['items.cartable'])->firstOrCreate([
                'session_id' => $sessionId,
            ]);
        }

        // تحديث عدد العناصر في الجلسة للتأكد من التزامن
        $cartCount = $cart->getItemsCount();
        if (session()->get('cart_count') !== $cartCount) {
            session()->put('cart_count', $cartCount);
            // Force session save
            session()->save();
        }

        return $cart;
    }

    /**
     * تهيئة جلسة السلة - يتم استدعاؤها عند تحميل الصفحة
     *
     * @return void
     */
    public function initializeCartSession()
    {
        $cart = $this->getCart();
        $cartCount = $cart->getItemsCount();
        
        // حفظ عدد العناصر في الجلسة
        session()->put('cart_count', $cartCount);
        
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'session_id' => session()->get('cart_session_id'),
        ]);
    }

    /**
     * شراء الآن: إضافة منتج للسلة والتوجيه مباشرة للدفع
     */
    public function buyNow(Request $request)
    {
        $store = $request->attributes->get('store');
        $product_id = $request->query('product_id');
        $product_type = $request->query('product_type', 'product');
        $selected_price = $request->query('selected_price');
        $selected_price_option = $request->query('selected_price_option');
        $selected_option_name = $request->query('selected_option_name');
        if (!$product_id) {
            return redirect()->route('cart.index');
        }
        // الحصول على المنتج بناءً على النوع
        if ($product_type === 'product') {
            $product = Product::where('store_id', $store->id)->find($product_id);
            $cartableType = Product::class;
        } else {
            $product = DigitalCard::where('store_id', $store->id)->find($product_id);
            $cartableType = DigitalCard::class;
        }
        if (!$product) {
            return redirect()->route('cart.index')->with('error', 'المنتج غير موجود أو تم حذفه');
        }
        $price = $selected_price ?? ($product->discount_price ?? $product->price);
        $cart = $this->getCart();
        $existingItem = $cart->items()
            ->where('cartable_id', $product_id)
            ->where('cartable_type', $cartableType)
            ->first();
        if ($existingItem) {
            $existingItem->increment('quantity');
        } else {
            $cart->items()->create([
                'cartable_id' => $product_id,
                'cartable_type' => $cartableType,
                'quantity' => 1,
                'price' => $price,
                'options' => $selected_price_option ? [
                    'selected_price_option' => $selected_price_option,
                    'selected_option_name' => $selected_option_name,
                    'selected_price' => $selected_price
                ] : null,
            ]);
        }
        return redirect()->route('checkout.index');
    }

    /**
     * الحصول على عدد العناصر في السلة الحالية
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartCount()
    {
        $cart = $this->getCart();
        $cartCount = $cart->getItemsCount();
        
        // تحديث الجلسة
        session()->put('cart_count', $cartCount);
        
        return response()->json([
            'cart_count' => $cartCount,
            'cart_total' => $cart->getTotal(),
        ]);
    }
} 