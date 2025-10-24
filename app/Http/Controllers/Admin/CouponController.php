<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * عرض قائمة الكوبونات
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request )
    {

        $store = $request->attributes->get('store');
        // if($request->input('store_id') != $store->id )
        // {
        //      abort(403, 'Unauthorized action.');

        // }
       // where('store_id',$store->id )->
      

        $coupons = Coupon::where('store_id',$store->id )->orderBy('created_at', 'desc')->paginate(15);
        return view('themes.admin.coupons.index', compact('coupons'));
    }

    /**
     * عرض نموذج إنشاء كوبون جديد
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('themes.admin.coupons.create');
    }

    /**
     * تخزين كوبون جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
         $store = $request->attributes->get('store');
        if($request->input('store_id') != $store->id )
        {
             abort(403, 'Unauthorized action.');

        }


        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'max_uses' => 'nullable|integer|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'store_id' => 'numeric',
        ]);

        // تطبيق القيمة الافتراضية لـ is_active إذا لم يتم توفيرها
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // حفظ المنتجات والتصنيفات المستهدفة كـ JSON
        $validated['product_ids'] = $request->has('product_ids') ? json_encode($request->input('product_ids')) : null;
        $validated['category_ids'] = $request->has('category_ids') ? json_encode($request->input('category_ids')) : null;
        
        // إنشاء الكوبون
        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'تم إنشاء كود الخصم بنجاح');
    }

    /**
     * عرض بيانات كوبون محدد
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Coupon $coupon)
    {

        // dd($coupon);
        return view('themes.admin.coupons.show', compact('coupon'));
    }

    /**
     * عرض نموذج تعديل كوبون
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Coupon $coupon)
    {
        // dd($coupon);
        return view('themes.admin.coupons.edit', compact('coupon'));
    }

    /**
     * تحديث بيانات كوبون
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'max_uses' => 'nullable|integer|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // تطبيق القيمة الافتراضية لـ is_active إذا لم يتم توفيرها
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // حفظ المنتجات والتصنيفات المستهدفة كـ JSON
        $validated['product_ids'] = $request->has('product_ids') ? json_encode($request->input('product_ids')) : null;
        $validated['category_ids'] = $request->has('category_ids') ? json_encode($request->input('category_ids')) : null;
        
        // تحديث الكوبون
        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'تم تحديث كود الخصم بنجاح');
    }

    /**
     * حذف كوبون
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'تم حذف كود الخصم بنجاح');
    }
    
    /**
     * تفعيل/تعطيل كوبون
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Coupon $coupon)
    {
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return response()->json([
            'success' => true,
            'message' => $coupon->is_active 
                ? 'تم تفعيل كود الخصم بنجاح' 
                : 'تم تعطيل كود الخصم بنجاح',
            'is_active' => $coupon->is_active
        ]);
    }
    
    /**
     * توليد كود خصم عشوائي
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateCode()
    {
        $code = Str::upper(Str::random(8));
        
        // التأكد من أن الكود فريد
        while(Coupon::where('code', $code)->exists()) {
            $code = Str::upper(Str::random(8));
        }
        
        return response()->json([
            'success' => true,
            'code' => $code
        ]);
    }
}
