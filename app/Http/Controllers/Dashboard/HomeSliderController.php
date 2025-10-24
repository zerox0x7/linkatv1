<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Dashboard\ImageUploadController;

class HomeSliderController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض قائمة السلايدر
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $sliders = HomeSlider::orderBy('sort_order')->get();
        return view('themes.admin.home-sliders.index', compact('sliders'));
    }

    /**
     * عرض نموذج إضافة سلايدر جديد
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('themes.admin.home-sliders.create');
    }

    /**
     * حفظ سلايدر جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string',
                'image' => 'required|image|max:2048',
                'button_text' => 'nullable|string|max:50',
                'button_url' => 'nullable|string|max:255',
                'secondary_button_text' => 'nullable|string|max:50',
                'secondary_button_url' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer',
                'is_active' => 'nullable|boolean',
            ]);

            // رفع الصورة
            if ($request->hasFile('image')) {
                $result = $this->imageUploader->uploadSingle(
                    $request->file('image'),
                    'sliders'
                );
                
                if (!$result['success']) {
                    return redirect()->back()
                        ->withErrors(['image' => $result['message']])
                        ->withInput();
                }
                
                $validatedData['image'] = $result['path'];
            }

            // معالجة القيم
            $validatedData['is_active'] = $request->has('is_active') ? true : false;
            $validatedData['sort_order'] = $validatedData['sort_order'] ?? 0;

            // إنشاء السلايدر
            HomeSlider::create($validatedData);

            return redirect()->route('admin.home-sliders.index')
                ->with('success', 'تم إضافة السلايدر بنجاح.');
        } catch (\Exception $e) {
            Log::error('خطأ في إضافة سلايدر', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة السلايدر: ' . $e->getMessage());
        }
    }

    /**
     * عرض نموذج تعديل السلايدر
     *
     * @param  HomeSlider  $homeSlider
     * @return \Illuminate\View\View
     */
    public function edit(HomeSlider $homeSlider)
    {
        return view('themes.admin.home-sliders.edit', compact('homeSlider'));
    }

    /**
     * تحديث السلايدر
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  HomeSlider  $homeSlider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, HomeSlider $homeSlider)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'button_text' => 'nullable|string|max:50',
                'button_url' => 'nullable|string|max:255',
                'secondary_button_text' => 'nullable|string|max:50',
                'secondary_button_url' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer',
                'is_active' => 'nullable|boolean',
            ]);

            // رفع الصورة الجديدة إذا تم توفيرها
            if ($request->hasFile('image')) {
                $result = $this->imageUploader->uploadSingle(
                    $request->file('image'),
                    'sliders',
                    $homeSlider->image
                );
                
                if (!$result['success']) {
                    return redirect()->back()
                        ->withErrors(['image' => $result['message']])
                        ->withInput();
                }
                
                $validatedData['image'] = $result['path'];
            }

            // معالجة القيم
            $validatedData['is_active'] = $request->has('is_active') ? true : false;
            $validatedData['sort_order'] = $validatedData['sort_order'] ?? $homeSlider->sort_order;

            // تحديث السلايدر
            $homeSlider->update($validatedData);

            return redirect()->route('admin.home-sliders.index')
                ->with('success', 'تم تحديث السلايدر بنجاح.');
        } catch (\Exception $e) {
            Log::error('خطأ في تحديث سلايدر', [
                'slider_id' => $homeSlider->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث السلايدر: ' . $e->getMessage());
        }
    }

    /**
     * حذف السلايدر
     *
     * @param  HomeSlider  $homeSlider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(HomeSlider $homeSlider)
    {
        try {
            // حذف الصورة إذا كانت موجودة
            if ($homeSlider->image) {
                $this->imageUploader->deleteImage($homeSlider->image);
            }
            
            $homeSlider->delete();
            
            return redirect()->route('admin.home-sliders.index')
                ->with('success', 'تم حذف السلايدر بنجاح.');
        } catch (\Exception $e) {
            Log::error('خطأ في حذف سلايدر', [
                'slider_id' => $homeSlider->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف السلايدر: ' . $e->getMessage());
        }
    }

    /**
     * تغيير حالة التفعيل للسلايدر
     *
     * @param  HomeSlider  $homeSlider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(HomeSlider $homeSlider)
    {
        $homeSlider->is_active = !$homeSlider->is_active;
        $homeSlider->save();
        
        $status = $homeSlider->is_active ? 'تفعيل' : 'تعطيل';
        
        return redirect()->back()
            ->with('success', "تم {$status} السلايدر بنجاح.");
    }

    /**
     * تحديث ترتيب السلايدرات
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $sliders = $request->input('sliders', []);
        
        foreach ($sliders as $slider) {
            $updateSlider = HomeSlider::find($slider['id']);
            if ($updateSlider) {
                $updateSlider->sort_order = $slider['order'];
                $updateSlider->save();
            }
        }
        
        return response()->json(['success' => true]);
    }
} 