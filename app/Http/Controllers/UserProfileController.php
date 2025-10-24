<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\ImageUploadController;

class UserProfileController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض ملف المستخدم الشخصي
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request)
    {
        $theme = $request->attributes->get('theme');
        // dd($theme);
        $user = auth()->user();
        $orders = $user->orders()->latest()->take(5)->get();
        
        // التأكد من وجود مجموعة الطلبات حتى لو كانت فارغة
        if (!isset($orders) || $orders === null) {
            $orders = collect([]);
        }
        
        return view('themes.'.$theme.'.pages.profile.show', compact('user', 'orders'));
    }
    
    /**
     * تحديث بيانات المستخدم
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = $request->only(['name', 'email', 'phone']);
        
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
            
            $data['avatar'] = $result['path'];
        }
        
        $user->update($data);
        
        return redirect()->route('profile.show')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
    
    /**
     * تحديث كلمة مرور المستخدم
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        
        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'كلمة المرور الحالية غير صحيحة',
            ]);
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('profile.show')
            ->with('success', 'تم تحديث كلمة المرور بنجاح');
    }
} 