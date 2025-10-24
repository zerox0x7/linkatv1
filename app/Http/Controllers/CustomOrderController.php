<?php

namespace App\Http\Controllers;

use App\Models\CustomOrder;
use App\Models\CustomOrderMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomOrderController extends Controller
{
    /**
     * عرض قائمة الطلبات المخصصة للمستخدم
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $customOrders = auth()->user()->customOrders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('custom_orders.index', compact('customOrders'));
    }
    
    /**
     * عرض صفحة إنشاء طلب مخصص جديد
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('custom_orders.create');
    }
    
    /**
     * حفظ طلب مخصص جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ]);
        
        $customOrder = CustomOrder::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'deadline' => $request->deadline,
            'status' => 'new',
        ]);
        
        // إنشاء رسالة أولية من المستخدم
        CustomOrderMessage::create([
            'custom_order_id' => $customOrder->id,
            'user_id' => auth()->id(),
            'message' => $request->description,
        ]);
        
        return redirect()->route('custom-orders.show', $customOrder->id)
            ->with('success', 'تم إنشاء الطلب المخصص بنجاح. سنتواصل معك قريباً.');
    }
    
    /**
     * عرض تفاصيل الطلب المخصص
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $customOrder = CustomOrder::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['messages.user', 'assignedTo'])
            ->firstOrFail();
            
        return view('custom_orders.show', compact('customOrder'));
    }
    
    /**
     * إرسال رسالة في الطلب المخصص
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request, $id)
    {
        $customOrder = CustomOrder::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:5120',
        ]);
        
        $data = [
            'custom_order_id' => $customOrder->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ];
        
        // معالجة المرفق
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }
        
        CustomOrderMessage::create($data);
        
        return redirect()->route('custom-orders.show', $customOrder->id)
            ->with('success', 'تم إرسال الرسالة بنجاح');
    }
    
    /**
     * إلغاء الطلب المخصص
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        $customOrder = CustomOrder::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'new')
            ->firstOrFail();
            
        $customOrder->update([
            'status' => 'cancelled',
        ]);
        
        return redirect()->route('custom-orders.show', $customOrder->id)
            ->with('success', 'تم إلغاء الطلب المخصص بنجاح');
    }
} 