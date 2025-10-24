<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * عرض قائمة طلبات المستخدم
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }
    
    /**
     * عرض تفاصيل الطلب
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $digitalCodes = [];
        $unratedItems = collect();
        $ratedItems = collect();
        $accountDigetals = [];
        
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['items.orderable', 'payment'])
            ->firstOrFail();
            
        $totalItems = $order->items->count();
        $hasOnlyDigitalProducts = true;
        
        try {
            foreach ($order->items as $item) {
                // تحقق من نوع المنتج: حساب أو بطاقة رقمية
                $isAccount = $item->orderable_type === 'App\\Models\\Product' && $item->orderable && $item->orderable->type === 'account';
                $isDigitalCard =
                    ($item->orderable_type === 'App\\Models\\Product' && $item->orderable && $item->orderable->type === 'digital_card') ||
                    ($item->orderable_type === 'App\\Models\\DigitalCard');

                if ($isAccount) {
                    $product = $item->orderable;
                    // جلب الحسابات المرتبطة بالطلب (تم تسليمها مسبقاً)
                    $existingAccounts = DB::table('account_digetal')
                        ->where('product_id', $product->id)
                        ->where('order_id', $order->id)
                        ->get();

                    $needed = $item->quantity - $existingAccounts->count();
                    if ($needed > 0 && $order->payment_status === 'paid') {
                        $accounts = DB::table('account_digetal')
                            ->where('product_id', $product->id)
                            ->where('status', 'available')
                            ->limit($needed)
                            ->get();

                        foreach ($accounts as $account) {
                            DB::table('account_digetal')
                                ->where('id', $account->id)
                                ->update([
                                    'status' => 'sold',
                                    'order_id' => $order->id
                                ]);
                        }
                    }
                    // جلب جميع الحسابات المرتبطة بالطلب بعد التحديث
                    $accountDigetals[$item->id] = DB::table('account_digetal')
                        ->where('product_id', $product->id)
                        ->where('order_id', $order->id)
                        ->get();

                    // تحديث المخزون بعد البيع
                    $availableAccounts = DB::table('account_digetal')
                        ->where('product_id', $product->id)
                        ->where('status', 'available')
                        ->count();
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['stock' => $availableAccounts]);

                    // تحديث حالة المنتج إذا نفذ المخزون
                    $status = $availableAccounts == 0 ? 'out-of-stock' : 'active';
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['status' => $status]);
                } elseif ($isDigitalCard) {
                    // منطق تسليم الأكواد الرقمية
                    $productId = $item->orderable_id;
                    $codes = DB::table('digital_card_codes')
                        ->where('product_id', $productId)
                        ->where('order_id', $order->id)
                        ->get();
                    // إذا لم يتم تسليم الأكواد بعد والطلب مدفوع
                    if ($codes->isEmpty() && $order->payment_status === 'paid') {
                        $codesToDeliver = DB::table('digital_card_codes')
                            ->where('product_id', $productId)
                            ->where('status', 'available')
                            ->limit($item->quantity)
                            ->get();
                        foreach ($codesToDeliver as $code) {
                            DB::table('digital_card_codes')
                                ->where('id', $code->id)
                                ->update([
                                    'status' => 'used',
                                    'sold_at' => now(),
                                    'order_id' => $order->id,
                                    'user_id' => auth()->id(),
                                ]);
                        }
                        // إعادة جلب الأكواد بعد التحديث
                        $codes = DB::table('digital_card_codes')
                            ->where('product_id', $productId)
                            ->where('order_id', $order->id)
                            ->get();
                    }
                    if ($codes->isNotEmpty()) {
                        $digitalCodes[$item->id] = $codes;
                    }
                } else {
                    $hasOnlyDigitalProducts = false;
                }
            }
            
            // تحديث حالة الطلب تلقائيًا إذا كان كل المنتجات رقمية وتم الدفع
            if ($hasOnlyDigitalProducts && $order->payment_status === 'paid' && $order->status !== 'completed') {
                $order->update([
                    'status' => 'completed',
                    'fulfilled_at' => now(),
                ]);
                $order = $order->fresh(['items.orderable', 'payment']);
            }
            
            // تفريغ سلة التسوق عند عرض الطلب إذا كان مدفوعاً
            if ($order->payment_status === 'paid') {
                // تفريغ سلة التسوق للمستخدم المسجل
                if (auth()->check()) {
                    $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                    if ($cart) {
                        $cart->items()->delete();
                        \Log::info('تم تفريغ سلة التسوق عند عرض تفاصيل الطلب المدفوع', ['order_id' => $order->id]);
                    }
                }
                // تفريغ سلة التسوق للزائر (إذا كان يستخدم نفس الجلسة)
                elseif (session()->has('cart_session_id')) {
                    $sessionId = session()->get('cart_session_id');
                    $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
                    if ($cart) {
                        $cart->items()->delete();
                        \Log::info('تم تفريغ سلة التسوق للزائر عند عرض تفاصيل الطلب المدفوع', ['order_id' => $order->id]);
                    }
                }
            }
            
            // تحديد العناصر غير المقيمة إذا كان الطلب مكتمل
            $unratedItems = collect();
            $ratedItems = collect();
            if ($order->status === 'completed') {
                $unratedItems = $order->items()
                    ->where('is_rated', false)
                    ->with('orderable')
                    ->get();
                    
                // تحميل العناصر المقيمة مع تقييماتها
                $ratedItems = $order->items()
                    ->where('is_rated', true)
                    ->with(['orderable', 'review'])
                    ->get();
            }
            
            // بعد التأكد من أن الطلب مدفوع أو مكتمل، قم بزيادة عدد المبيعات للمنتجات
            if (in_array($order->status, ['completed', 'processing']) || $order->payment_status === 'paid') {
                foreach ($order->items as $item) {
                    if ($item->orderable_type === 'App\\Models\\Product' && $item->orderable) {
                        $item->orderable->increment('sales_count', $item->quantity);
                    }
                }
            }
        } catch (\Exception $e) {
            // Log the exception but still show the order
            \Log::error('Error processing order #' . $order->id . ': ' . $e->getMessage());
        }
        
        return view('orders.show', compact('order', 'digitalCodes', 'unratedItems', 'ratedItems', 'accountDigetals'));
    }
    
    /**
     * إلغاء الطلب
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();
            
        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
        
        // إرسال إشعار إلغاء الطلب عبر الواتساب
        try {
            $user = auth()->user();
            if ($user && $user->phone) {
                $whatsappService = app(\App\Services\WhatsApp\WhatsAppService::class);
                $whatsappService->sendOrderStatusUpdate($order, 'cancelled');
                
                \Illuminate\Support\Facades\Log::info('تم إرسال إشعار إلغاء الطلب عبر واتساب', [
                    'order_id' => $order->id,
                    'phone' => $user->phone
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('خطأ أثناء إرسال إشعار واتساب لإلغاء الطلب', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $order->id
            ]);
        }
        
        // استرجاع المخزون
        foreach ($order->items as $item) {
            $product = $item->orderable;
            
            if ($item->orderable_type === 'App\\Models\\Product') {
                // إذا كان منتج رقمي، تحقق من وجود أكواد
                $productDB = DB::table('products')->where('id', $item->orderable_id)->first();
                if ($productDB && $productDB->type === 'digital_card') {
                    // إعادة تعيين حالة أكواد البطاقات الرقمية
                    DB::table('digital_card_codes')
                        ->where('product_id', $item->orderable_id)
                        ->where('order_id', $order->id)
                        ->update([
                            'status' => 'available',
                            'sold_at' => null,
                            'order_id' => null,
                            'user_id' => null,
                        ]);
                        
                    // تحديث المخزون
                    $remainingCodes = DB::table('digital_card_codes')
                        ->where('product_id', $item->orderable_id)
                        ->where('order_id', null)
                        ->where('status', 'available')
                        ->count();
                        
                    DB::table('products')
                        ->where('id', $item->orderable_id)
                        ->update([
                            'stock' => $remainingCodes,
                            'updated_at' => now()
                        ]);
                } else {
                    // منتج عادي
                    $product->increment('stock', $item->quantity);
                    $product->decrement('sales_count', $item->quantity);
                }
            } elseif ($item->orderable_type === 'App\\Models\\DigitalCard') {
                // إعادة تعيين حالة أكواد البطاقات الرقمية
                $product->codes()
                    ->where('order_id', $order->id)
                    ->update([
                        'status' => 'available',
                        'sold_at' => null,
                        'order_id' => null,
                        'user_id' => null,
                    ]);
                    
                $product->increment('stock_quantity', $item->quantity);
            }
        }
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'تم إلغاء الطلب بنجاح');
    }
    
    /**
     * تتبع الطلب
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function track(Request $request)
    {
        $order = null;
        
        if ($request->filled('order_number')) {
            $order = Order::where('order_number', $request->order_number)
                ->first();
                
            if (!$order) {
                return view('orders.track')->with('error', 'لم يتم العثور على الطلب');
            }
            
            // التحقق من أن الطلب يخص المستخدم الحالي
            if (auth()->check() && $order->user_id !== auth()->id()) {
                return view('orders.track')->with('error', 'ليس لديك صلاحية لعرض هذا الطلب');
            }
        }
        
        return view('orders.track', compact('order'));
    }
} 