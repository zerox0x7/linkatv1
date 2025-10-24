<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Controllers\Dashboard\ImageUploadController;

class UserController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض قائمة المستخدمين
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::withCount('orders')
            ->latest()
            ->paginate(15);
            
        return view('themes.dashboard.users.index', compact('users'));
    }

    /**
     * عرض نموذج إنشاء مستخدم جديد
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('themes.dashboard.users.create');
    }

    /**
     * تخزين مستخدم جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
            'role' => 'required|in:user,dashboard',
            'is_active' => 'boolean',
        ]);

        // معالجة الصورة الشخصية
        if ($request->hasFile('avatar')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('avatar'),
                'avatars',
                null
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['avatar' => $result['message']])
                    ->withInput();
            }
            
            $validated['avatar'] = $result['path'];
        }

        // تشفير كلمة المرور
        $validated['password'] = Hash::make($validated['password']);
        
        // تحديد حالة النشاط
        $validated['is_active'] = $request->has('is_active');

        // إنشاء المستخدم
        User::create($validated);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    /**
     * عرض تفاصيل مستخدم محدد
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load(['orders' => function ($query) {
            $query->latest()->take(5);
        }]);
        
        return view('themes.dashboard.users.show', compact('user'));
    }

    /**
     * عرض نموذج تعديل مستخدم
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('themes.dashboard.users.edit', compact('user'));
    }

    /**
     * تحديث مستخدم محدد
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
            'role' => 'required|in:user,dashboard',
            'is_active' => 'boolean',
        ]);

        // معالجة الصورة الشخصية
        if ($request->hasFile('avatar')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('avatar'),
                'avatars',
                $user->avatar
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['avatar' => $result['message']])
                    ->withInput();
            }
            
            $validated['avatar'] = $result['path'];
        }

        // تشفير كلمة المرور إذا تم تقديمها
        if (isset($validated['password']) && !empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        // تحديد حالة النشاط
        $validated['is_active'] = $request->has('is_active');

        // تحديث المستخدم
        $user->update($validated);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    /**
     * حذف مستخدم محدد
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // حذف الصورة الشخصية
        if ($user->avatar) {
            $this->imageUploader->deleteImage($user->avatar);
        }
        
        // يمكن أن نضيف هنا خطوات إضافية للتعامل مع الطلبات المرتبطة أو البيانات الأخرى
        
        // حذف المستخدم
        $user->delete();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
} 