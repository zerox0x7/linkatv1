<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuLink;
use Illuminate\Http\Request;

class MenuLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Usually not used as menu links are managed in the pages.index view
        return redirect()->route('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $section = $request->section ?? 'quick_links';
        
        return view('themes.admin.menu-links.create', compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => [
                'required',
                'string',
                'max:255',
                function (
                    $attribute, $value, $fail
                ) use ($request) {
                    if ($request->url_type === 'relative' && !preg_match('/^\//', $value)) {
                        $fail('يجب أن يبدأ المسار النسبي بـ /');
                    }
                    if ($request->url_type === 'absolute' && !preg_match('/^https?:\/\//', $value)) {
                        $fail('يجب أن يبدأ الرابط الخارجي بـ http:// أو https://');
                    }
                },
            ],
            'url_type' => 'required|in:relative,absolute',
            'section' => 'required|string|in:quick_links,policies',
            'order' => 'nullable|integer|min:0',
        ], [
            'url.required' => $request->url_type === 'relative'
                ? 'حقل المسار النسبي مطلوب'
                : 'حقل الرابط الخارجي مطلوب',
        ]);

        $lastOrder = MenuLink::where('section', $request->section)->max('order') ?? 0;
        
        MenuLink::create([
            'title' => $request->title,
            'url' => $request->url,
            'section' => $request->section,
            'order' => $request->order ?? ($lastOrder + 1),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'تم إضافة الرابط بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuLink  $menuLink
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuLink $menuLink)
    {
        return view('themes.admin.menu-links.edit', compact('menuLink'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuLink  $menuLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuLink $menuLink)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => [
                'required',
                'string',
                'max:255',
                function (
                    $attribute, $value, $fail
                ) use ($request) {
                    if ($request->url_type === 'relative' && !preg_match('/^\//', $value)) {
                        $fail('يجب أن يبدأ المسار النسبي بـ /');
                    }
                    if ($request->url_type === 'absolute' && !preg_match('/^https?:\/\//', $value)) {
                        $fail('يجب أن يبدأ الرابط الخارجي بـ http:// أو https://');
                    }
                },
            ],
            'url_type' => 'required|in:relative,absolute',
            'section' => 'required|string|in:quick_links,policies',
            'order' => 'nullable|integer|min:0',
        ], [
            'url.required' => $request->url_type === 'relative'
                ? 'حقل المسار النسبي مطلوب'
                : 'حقل الرابط الخارجي مطلوب',
        ]);

        $menuLink->update([
            'title' => $request->title,
            'url' => $request->url,
            'section' => $request->section,
            'order' => $request->order ?? $menuLink->order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'تم تحديث الرابط بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuLink  $menuLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuLink $menuLink)
    {
        $menuLink->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'تم حذف الرابط بنجاح');
    }
} 