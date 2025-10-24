<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * عرض قائمة الطلبات
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // البحث عن الطلبات حسب المعايير المحددة
        $query = Order::with(['user', 'items.orderable', 'items']);
        
        // تطبيق البحث بالمعايير
        if (request('order_number')) {
            $query->where('id', 'like', '%' . request('order_number') . '%')
                  ->orWhere('order_number', 'like', '%' . request('order_number') . '%');
        }
        
        if (request('customer_name')) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . request('customer_name') . '%');
            });
        }
        
        if (request('status')) {
            $query->where('status', request('status'));
        }
        
        // ترتيب الطلبات بحيث تظهر الطلبات قيد المعالجة أولاً، ثم حسب الأحدث
        $query->orderByRaw("CASE WHEN status = 'processing' THEN 0 ELSE 1 END")
              ->orderBy('created_at', 'desc');
        
        // تقسيم النتائج لعرضها في صفحات
        $orders = $query->paginate(15);
            
        // استخدام المعلومات المخزنة في قاعدة البيانات لتحديد الطلبات المخصصة
        $customOrderIds = [];
        
        foreach ($orders as $order) {
            // إذا كان الطلب محدد بالفعل كمخصص
            if ($order->has_custom_products) {
                $customOrderIds[] = $order->id;
                continue;
            }
            
            // تحقق إضافي للطلبات القديمة التي لم يتم تحديثها بعد
            foreach ($order->items as $item) {
                if ($item->options) {
                    // التحقق مما إذا كان المنتج مخصصًا
                    if (
                        ($item->orderable_type === 'App\\Models\\Product' && $item->orderable->type === 'custom') ||
                        isset($item->options['custom_fields_data']) ||
                        isset($item->options['custom_data']) ||
                        isset($item->options['selected_option_name']) ||
                        isset($item->options['selected_price_option'])
                    ) {
                        $customOrderIds[] = $order->id;
                        // تحديث الطلب ليشير إلى وجود منتجات مخصصة
                        $order->update(['has_custom_products' => true]);
                        break;
                    }
                    
                    // التحقق من وجود حقول مخصصة أخرى
                    $fieldsToIgnore = ['selected_price_option', 'selected_option_name', 'selected_price', 
                                      'other_options', 'custom_fields_data', 'custom_data', 'quantity', 
                                      'id', 'product_id'];
                    
                    foreach ($item->options as $key => $value) {
                        if (!in_array($key, $fieldsToIgnore) && !empty($value)) {
                            $customOrderIds[] = $order->id;
                            // تحديث الطلب ليشير إلى وجود منتجات مخصصة
                            $order->update(['has_custom_products' => true]);
                            break 2;
                        }
                    }
                }
            }
        }
        
        // حساب الإحصائيات
        $now = now();
        $thisMonth = [
            $now->copy()->startOfMonth(), 
            $now->copy()->endOfMonth()
        ];
        $lastMonth = [
            $now->copy()->subMonth()->startOfMonth(), 
            $now->copy()->subMonth()->endOfMonth()
        ];
        
        // إجمالي المبيعات للشهر الحالي
        $totalSales = Order::whereBetween('created_at', $thisMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total');
            
        // إجمالي المبيعات للشهر السابق
        $lastMonthSales = Order::whereBetween('created_at', $lastMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total');
            
        // حساب نسبة التغير في المبيعات
        $salesGrowth = $lastMonthSales > 0 
            ? (($totalSales - $lastMonthSales) / $lastMonthSales) * 100 
            : 100;
            
        // عدد الطلبات للشهر الحالي
        $totalOrders = Order::whereBetween('created_at', $thisMonth)->count();
        
        // عدد الطلبات للشهر السابق
        $lastMonthOrders = Order::whereBetween('created_at', $lastMonth)->count();
        
        // حساب نسبة التغير في عدد الطلبات
        $ordersGrowth = $lastMonthOrders > 0 
            ? (($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100 
            : 100;
            
        // حساب متوسط قيمة الطلب للشهر الحالي
        $averageOrderValue = $totalOrders > 0 
            ? $totalSales / $totalOrders 
            : 0;
            
        // حساب متوسط قيمة الطلب للشهر السابق
        $lastMonthAvgOrder = $lastMonthOrders > 0 
            ? $lastMonthSales / $lastMonthOrders 
            : 0;
            
        // حساب نسبة التغير في متوسط قيمة الطلب
        $avgOrderGrowth = $lastMonthAvgOrder > 0 
            ? (($averageOrderValue - $lastMonthAvgOrder) / $lastMonthAvgOrder) * 100 
            : 100;
            
        // عدد الطلبات قيد المعالجة
        $processingOrders = Order::where('status', 'processing')->count();
            
        return view('themes.dashboard.orders.index', compact(
            'orders', 
            'customOrderIds', 
            'totalSales', 
            'salesGrowth', 
            'totalOrders', 
            'ordersGrowth', 
            'averageOrderValue', 
            'avgOrderGrowth', 
            'processingOrders'
        ));
    }

    /**
     * عرض تفاصيل طلب محدد
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load(['items.orderable', 'user']);
        
        // تتبع المنتجات المخصصة في الطلب
        $hasCustomProducts = $order->has_custom_products;
        $customProductsData = !empty($order->custom_data) ? $order->custom_data : [];
        
        // إذا لم تكن البيانات المخصصة موجودة في الطلب، قم ببنائها
        if (!$hasCustomProducts || empty($customProductsData)) {
            // معالجة البيانات المخصصة
            foreach ($order->items as $item) {
                if ($item->options) {
                    // التعرف على المنتجات المخصصة
                    if ($item->orderable_type === 'App\\Models\\Product') {
                        if ($item->orderable->type === 'custom' || isset($item->options['custom_fields_data']) || isset($item->options['custom_data'])) {
                            $hasCustomProducts = true;
                            
                            // تخزين بيانات المنتج المخصص
                            $customProductsData[$item->id] = [
                                'name' => $item->orderable->name,
                                'product_id' => $item->orderable->id, // إضافة معرف المنتج
                                'data' => []
                            ];
                        }
                    }
                    
                    // التحقق من وجود بيانات مخصصة بتنسيقات مختلفة وتوحيدها
                    if (isset($item->options['custom_data']) && !isset($item->options['custom_fields_data'])) {
                        // استخدام نسخة مؤقتة من options بدلاً من تعديلها مباشرة
                        $options = $item->options;
                        $options['custom_fields_data'] = $options['custom_data'];
                        $item->options = $options;
                        
                        if (isset($customProductsData[$item->id])) {
                            $customProductsData[$item->id]['data'] = $options['custom_data'];
                        }
                    }
                    
                    // تنظيم بيانات player_data إذا وجدت
                    if (isset($item->options['custom_fields_data']) && is_array($item->options['custom_fields_data'])) {
                        if (isset($customProductsData[$item->id])) {
                            $customProductsData[$item->id]['player_data'] = $item->options['custom_fields_data'];
                        }
                    }
                    
                    // التحقق من البيانات المخصصة في الحقول المباشرة
                    $fieldsToIgnore = ['selected_price_option', 'selected_option_name', 'selected_price', 
                                  'other_options', 'custom_fields_data', 'custom_data', 'quantity', 
                                  'id', 'product_id'];
                
                    $customData = [];
                    foreach ($item->options as $key => $value) {
                        if (!in_array($key, $fieldsToIgnore) && !empty($value)) {
                            $customData[$key] = $value;
                            
                            if (isset($customProductsData[$item->id])) {
                                $customProductsData[$item->id]['data'][$key] = $value;
                            }
                        }
                    }
                    
                    // إذا لم تكن هناك بيانات مخصصة موجودة أصلاً، أضفها
                    if (!empty($customData) && !isset($item->options['custom_fields_data'])) {
                        // استخدام نسخة مؤقتة من options بدلاً من تعديلها مباشرة
                        $options = $item->options;
                        $options['custom_fields_data'] = $customData;
                        $item->options = $options;
                    }
                    
                    // إذا كان هناك خدمة محددة، اعتبر المنتج مخصصاً
                    if (isset($item->options['selected_option_name']) || isset($item->options['selected_price_option'])) {
                        $hasCustomProducts = true;
                        
                        if (!isset($customProductsData[$item->id])) {
                            $customProductsData[$item->id] = [
                                'name' => $item->orderable->name,
                                'product_id' => $item->orderable->id, // إضافة معرف المنتج
                                'data' => []
                            ];
                        }
                        
                        $customProductsData[$item->id]['service_option'] = [
                            'name' => $item->options['selected_option_name'] ?? 'خدمة مخصصة',
                            'option_id' => $item->options['selected_price_option'] ?? '',
                            'price' => $item->options['selected_price'] ?? null
                        ];
                    }
                }
            }

            // تحديث بيانات الطلب إذا كان يحتوي على منتجات مخصصة ولم يتم تخزينها سابقًا
            if ($hasCustomProducts && (empty($order->custom_data) || !$order->has_custom_products)) {
                $order->update([
                    'custom_data' => $customProductsData,
                    'has_custom_products' => true
                ]);
            }
        }
        
        // جلب الأكواد الرقمية المرتبطة بالطلب
        $digitalCodes = [];
        foreach ($order->items as $item) {
            if ($item->orderable_type === 'App\\Models\\Product' && $item->orderable->type === 'digital_card') {
                // جلب الأكواد الرقمية المرتبطة بالمنتج
                $codes = \App\Models\DigitalCardCode::where('order_id', $order->id)
                    ->where('product_id', $item->orderable->id)
                    ->get();
                    
                if ($codes->count() > 0) {
                    $digitalCodes[$item->id] = $codes;
                }
            } elseif ($item->orderable_type === 'App\\Models\\DigitalCard') {
                // جلب الأكواد الرقمية من البطاقات الرقمية
                $codes = \App\Models\DigitalCardCode::where('order_id', $order->id)
                    ->where('card_id', $item->orderable->id)
                    ->get();
                    
                if ($codes->count() > 0) {
                    $digitalCodes[$item->id] = $codes;
                }
            }
        }
        
        return view('themes.dashboard.orders.show', compact('order', 'digitalCodes', 'hasCustomProducts', 'customProductsData'));
    }

    /**
     * عرض نموذج تعديل طلب
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        $order->load(['items.orderable', 'user']);
        
        // تتبع المنتجات المخصصة في الطلب
        $hasCustomProducts = false;
        $customProductsData = [];
        
        // إذا كان الطلب يحتوي على بيانات مخصصة مخزنة، استخدمها أولاً
        if ($order->has_custom_products && !empty($order->custom_data)) {
            $hasCustomProducts = true;
            $customProductsData = $order->custom_data;
        } else {
            // معالجة البيانات المخصصة
            foreach ($order->items as $item) {
                if ($item->options) {
                    // التعرف على المنتجات المخصصة
                    if ($item->orderable_type === 'App\\Models\\Product') {
                        if ($item->orderable->type === 'custom' || isset($item->options['custom_fields_data']) || isset($item->options['custom_data'])) {
                            $hasCustomProducts = true;
                            
                            // تخزين بيانات المنتج المخصص
                            $customProductsData[$item->id] = [
                                'name' => $item->orderable->name,
                                'data' => []
                            ];
                        }
                    }
                    
                    // التحقق من وجود بيانات مخصصة بتنسيقات مختلفة وتوحيدها
                    if (isset($item->options['custom_data']) && !isset($item->options['custom_fields_data'])) {
                        // استخدام نسخة مؤقتة من options بدلاً من تعديلها مباشرة
                        $options = $item->options;
                        $options['custom_fields_data'] = $options['custom_data'];
                        $item->options = $options;
                        
                        if (isset($customProductsData[$item->id])) {
                            $customProductsData[$item->id]['data'] = $options['custom_data'];
                        }
                    }
                    
                    // التحقق من البيانات المخصصة في الحقول المباشرة
                    $fieldsToIgnore = ['selected_price_option', 'selected_option_name', 'selected_price', 
                                      'other_options', 'custom_fields_data', 'custom_data', 'quantity', 
                                      'id', 'product_id'];
                    
                    $customData = [];
                    foreach ($item->options as $key => $value) {
                        if (!in_array($key, $fieldsToIgnore) && !empty($value)) {
                            $customData[$key] = $value;
                            
                            if (isset($customProductsData[$item->id])) {
                                $customProductsData[$item->id]['data'][$key] = $value;
                            }
                        }
                    }
                    
                    // إذا لم تكن هناك بيانات مخصصة موجودة أصلاً، أضفها
                    if (!empty($customData) && !isset($item->options['custom_fields_data'])) {
                        // استخدام نسخة مؤقتة من options بدلاً من تعديلها مباشرة
                        $options = $item->options;
                        $options['custom_fields_data'] = $customData;
                        $item->options = $options;
                    }
                    
                    // إذا كان هناك خدمة محددة، اعتبر المنتج مخصصاً
                    if (isset($item->options['selected_option_name']) || isset($item->options['selected_price_option'])) {
                        $hasCustomProducts = true;
                        
                        if (!isset($customProductsData[$item->id])) {
                            $customProductsData[$item->id] = [
                                'name' => $item->orderable->name,
                                'data' => []
                            ];
                        }
                        
                        $customProductsData[$item->id]['service'] = [
                            'name' => $item->options['selected_option_name'] ?? 'خدمة مخصصة',
                            'price' => $item->options['selected_price'] ?? null
                        ];
                    }
                }
            }

            // تحديث بيانات الطلب إذا كان يحتوي على منتجات مخصصة ولم يتم تخزينها سابقًا
            if ($hasCustomProducts) {
                $order->update([
                    'custom_data' => $customProductsData,
                    'has_custom_products' => true
                ]);
            }
        }
        
        // جلب الأكواد الرقمية المرتبطة بالطلب
        $digitalCodes = [];
        foreach ($order->items as $item) {
            if ($item->orderable_type === 'App\\Models\\Product' && $item->orderable->type === 'digital_card') {
                // جلب الأكواد الرقمية المرتبطة بالمنتج
                $codes = \App\Models\DigitalCardCode::where('order_id', $order->id)
                    ->where('product_id', $item->orderable->id)
                    ->get();
                    
                if ($codes->count() > 0) {
                    $digitalCodes[$item->id] = $codes;
                }
            } elseif ($item->orderable_type === 'App\\Models\\DigitalCard') {
                // جلب الأكواد الرقمية من البطاقات الرقمية
                $codes = \App\Models\DigitalCardCode::where('order_id', $order->id)
                    ->where('card_id', $item->orderable->id)
                    ->get();
                    
                if ($codes->count() > 0) {
                    $digitalCodes[$item->id] = $codes;
                }
            }
        }
        
        return view('themes.dashboard.orders.edit', compact('order', 'digitalCodes', 'hasCustomProducts', 'customProductsData'));
    }

    /**
     * تحديث طلب محدد
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        // إذا كان التحديث لبيانات مخصصة
        if ($request->has('update_custom_data')) {
            $validated = $request->validate([
                'custom_data' => 'required|array',
            ]);
            
            $order->update([
                'custom_data' => $validated['custom_data'],
                'has_custom_products' => true
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'تم تحديث البيانات المخصصة بنجاح']);
            }
            return redirect()->route('dashboard.orders.edit', $order->id)
                ->with('success', 'تم تحديث البيانات المخصصة بنجاح');
        }
        
        // التحديث العادي
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'تم حفظ التغييرات بنجاح']);
        }

        return redirect()->route('dashboard.orders.edit', $order->id)
            ->with('success', 'تم تحديث الطلب بنجاح');
    }

    /**
     * تحديث حالة الطلب
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,processing,shipped,delivered,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->input('status');
        
        // Only update if status has changed
        if ($oldStatus != $newStatus) {
            $order->status = $newStatus;
            $order->save();
            // تم حذف إطلاق الحدث يدوياً هنا لمنع التكرار
            // إذا اكتملت الطلبية، يتم تحديث الأكواد الرقمية
            if ($newStatus == 'completed') {
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->type == 'digital' && !empty($item->digital_code_id)) {
                        DB::table('digital_codes')
                            ->where('id', $item->digital_code_id)
                            ->update(['is_used' => true, 'used_at' => now()]);
                    }
                }
            }
        }
        
        return redirect()->route('dashboard.orders.show', $order)
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * استعادة المخزون عند إلغاء الطلب
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    protected function restoreStock(Order $order)
    {
        foreach ($order->items as $item) {
            if ($item->orderable_type === 'App\\Models\\Product') {
                $product = $item->orderable;
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }
    }

    /**
     * حذف طلب محدد
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        // في معظم التطبيقات، لا يُفضل حذف الطلبات فعليًا
        // بدلاً من ذلك، يمكن وضع علامة عليها كمحذوفة أو أرشفتها
        
        // حذف العناصر المرتبطة بالطلب
        $order->items()->delete();
        
        // حذف المدفوعات المرتبطة
        if ($order->payment) {
            $order->payment->delete();
        }
        
        // حذف الطلب
        $order->delete();

        return redirect()->route('dashboard.orders.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }
} 