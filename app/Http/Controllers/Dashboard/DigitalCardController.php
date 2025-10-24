<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DigitalCard;
use App\Models\DigitalCardCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Dashboard\ImageUploadController;

class DigitalCardController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض قائمة البطاقات الرقمية
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $digitalCards = DigitalCard::withCount('codes')
            ->withCount(['codes as available_codes_count' => function ($query) {
                $query->whereNull('user_id');
            }])
            ->latest()
            ->paginate(15);
            
        return view('themes.admin.digital_cards.index', compact('digitalCards'));
    }

    /**
     * عرض نموذج إنشاء بطاقة رقمية جديدة
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('themes.admin.digital_cards.create');
    }

    /**
     * تخزين بطاقة رقمية جديدة
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'instructions' => 'required|string',
            'is_active' => 'boolean',
            'codes' => 'required|string'
        ]);

        $result = $this->imageUploader->uploadSingle(
            $request->file('image'),
            'digital-cards'
        );

        if (!$result['success']) {
            return redirect()->back()
                ->withErrors(['image' => $result['message']])
                ->withInput();
        }

        // إنشاء البطاقة الرقمية
        $digitalCard = DigitalCard::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $result['path'],
            'instructions' => $request->instructions,
            'is_active' => $request->has('is_active'),
        ]);

        // معالجة الأكواد
        $codesList = explode("\n", $request->codes);
        foreach ($codesList as $code) {
            $code = trim($code);
            if (!empty($code)) {
                DigitalCardCode::create([
                    'digital_card_id' => $digitalCard->id,
                    'code' => $code,
                ]);
            }
        }

        return redirect()->route('admin.digital-cards.index')
            ->with('success', 'تم إنشاء البطاقة الرقمية بنجاح');
    }

    /**
     * عرض بطاقة رقمية محددة
     *
     * @param  \App\Models\DigitalCard  $digitalCard
     * @return \Illuminate\View\View
     */
    public function show(DigitalCard $digitalCard)
    {
        $digitalCard->load('codes');
        
        return view('themes.admin.digital_cards.show', compact('digitalCard'));
    }

    /**
     * عرض نموذج تعديل بطاقة رقمية
     *
     * @param  \App\Models\DigitalCard  $digitalCard
     * @return \Illuminate\View\View
     */
    public function edit(DigitalCard $digitalCard)
    {
        return view('themes.admin.digital_cards.edit', compact('digitalCard'));
    }

    /**
     * تحديث بطاقة رقمية محددة
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DigitalCard  $digitalCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DigitalCard $digitalCard)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'instructions' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'instructions' => $request->instructions,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            $result = $this->imageUploader->uploadSingle(
                $request->file('image'),
                'digital-cards',
                $digitalCard->image
            );

            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['image' => $result['message']])
                    ->withInput();
            }

            $data['image'] = $result['path'];
        }

        $digitalCard->update($data);

        return redirect()->route('admin.digital-cards.index')
            ->with('success', 'تم تحديث البطاقة الرقمية بنجاح');
    }

    /**
     * حذف بطاقة رقمية محددة
     *
     * @param  \App\Models\DigitalCard  $digitalCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DigitalCard $digitalCard)
    {
        if ($digitalCard->image) {
            $this->imageUploader->deleteImage($digitalCard->image);
        }
        
        // حذف الأكواد المرتبطة
        $digitalCard->codes()->delete();
        
        // حذف البطاقة
        $digitalCard->delete();

        return redirect()->route('admin.digital-cards.index')
            ->with('success', 'تم حذف البطاقة الرقمية بنجاح');
    }
} 