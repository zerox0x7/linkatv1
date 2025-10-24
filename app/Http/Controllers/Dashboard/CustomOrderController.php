<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use App\Models\CustomOrderMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomOrderController extends Controller
{
    /**
     * عرض قائمة الطلبات المخصصة
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customOrders = CustomOrder::with(['user', 'assignedTo'])
            ->latest()
            ->paginate(15);
            
        return view('themes.admin.custom_orders.index', compact('customOrders'));
    }

    /**
     * عرض نموذج إنشاء طلب مخصص جديد
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('themes.admin.custom_orders.create', compact('users'));
    }

    /**
     * تخزين طلب مخصص جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'is_paid' => 'required|boolean',
            'payment_method' => 'nullable|string',
            'payment_id' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB max
            'admin_notes' => 'nullable|string',
        ]);

        $customOrder = new CustomOrder($validated);
        
        if ($request->hasFile('file')) {
            $customOrder->file_path = $request->file('file')->store('custom_orders/files', 'public');
        }
        
        $customOrder->assigned_to = Auth::id();
        $customOrder->save();

        // إضافة رسالة أولية إذا تم إدخال وصف أو متطلبات
        if ($request->filled('description')) {
            $initialMessage = new CustomOrderMessage([
                'custom_order_id' => $customOrder->id,
                'user_id' => Auth::id(),
                'message' => 'تم إنشاء الطلب المخصص بواسطة المسؤول',
                'is_from_admin' => true,
            ]);
            $initialMessage->save();
        }

        return redirect()->route('admin.custom_orders.index')
            ->with('success', 'تم إضافة الطلب المخصص بنجاح');
    }

    /**
     * عرض تفاصيل طلب مخصص محدد
     *
     * @param  \App\Models\CustomOrder  $customOrder
     * @return \Illuminate\View\View
     */
    public function show(CustomOrder $customOrder)
    {
        $customOrder->load(['user', 'assignedTo', 'messages.user']);
        
        $admins = User::where('role', 'admin')->get();
        
        return view('themes.admin.custom_orders.show', compact('customOrder', 'admins'));
    }

    /**
     * عرض نموذج تعديل طلب مخصص
     *
     * @param  \App\Models\CustomOrder  $customOrder
     * @return \Illuminate\View\View
     */
    public function edit(CustomOrder $customOrder)
    {
        $customOrder->load(['user', 'assignedTo']);
        
        $admins = User::where('role', 'admin')->get();
        
        return view('themes.admin.custom_orders.edit', compact('customOrder', 'admins'));
    }

    /**
     * تحديث طلب مخصص محدد
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomOrder  $customOrder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CustomOrder $customOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
        ]);

        $customOrder->update($validated);

        // إرسال إشعار إذا تم تعيين المسؤول
        if ($request->filled('assigned_to') && $customOrder->assigned_to != $request->assigned_to) {
            $admin = User::find($request->assigned_to);
            if ($admin) {
                // $admin->notify(new \App\Notifications\CustomOrderAssigned($customOrder));
            }
        }

        return redirect()->route('admin.custom_orders.index')
            ->with('success', 'تم تحديث الطلب المخصص بنجاح');
    }

    /**
     * الرد على طلب مخصص
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomOrder  $customOrder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply(Request $request, CustomOrder $customOrder)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // الحد الأقصى 10 ميجابايت
        ]);

        $message = new CustomOrderMessage([
            'custom_order_id' => $customOrder->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_from_admin' => true,
        ]);

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $attachments = [];
            
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('custom_orders/attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ];
            }
            
            $message->attachments = $attachments;
        }

        $message->save();

        // تحديث حالة الطلب إلى قيد التنفيذ إذا كان بانتظار المراجعة
        if ($customOrder->status === 'pending') {
            $customOrder->update([
                'status' => 'in_progress',
                'assigned_to' => Auth::id(),
            ]);
        }

        // إرسال إشعار للمستخدم
        if ($customOrder->user) {
            // $customOrder->user->notify(new \App\Notifications\CustomOrderReply($customOrder, $message));
        }

        return redirect()->back()
            ->with('success', 'تم إرسال الرد بنجاح');
    }

    /**
     * حذف طلب مخصص محدد
     *
     * @param  \App\Models\CustomOrder  $customOrder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(CustomOrder $customOrder)
    {
        // حذف المرفقات
        foreach ($customOrder->messages as $message) {
            if (!empty($message->attachments)) {
                foreach ($message->attachments as $attachment) {
                    if (isset($attachment['path'])) {
                        Storage::disk('public')->delete($attachment['path']);
                    }
                }
            }
        }
        
        // حذف الرسائل
        $customOrder->messages()->delete();
        
        // حذف الطلب
        $customOrder->delete();

        return redirect()->route('admin.custom_orders.index')
            ->with('success', 'تم حذف الطلب المخصص بنجاح');
    }

    /**
     * تحديث حالة الطلب المخصص
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomOrder  $customOrder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, CustomOrder $customOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $customOrder->update([
            'status' => $validated['status'],
            'updated_at' => now(),
        ]);

        // إضافة رسالة للطلب عند تغيير الحالة
        $statusMessages = [
            'pending' => 'تم تحديث حالة الطلب إلى قيد الانتظار',
            'processing' => 'تم تحديث حالة الطلب إلى قيد المعالجة',
            'completed' => 'تم تحديث حالة الطلب إلى مكتمل',
            'cancelled' => 'تم إلغاء الطلب'
        ];

        $message = new CustomOrderMessage([
            'custom_order_id' => $customOrder->id,
            'user_id' => Auth::id(),
            'message' => $statusMessages[$validated['status']] ?? 'تم تحديث حالة الطلب',
            'is_from_admin' => true,
        ]);
        $message->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
} 