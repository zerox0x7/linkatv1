<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarqueeController extends Controller
{
    public function index()
    {
        return view('themes.dashboard.pages.marquee');
    }

    public function save(Request $request)
    {
        try {
            // لا تعدل الرسائل إذا لم يتم إرسال marquee_texts
            if ($request->has('marquee_texts')) {
                $rawTexts = $request->marquee_texts;
                $marqueeItems = [];
                // إذا كان النص ليس JSON، حوله إلى مصفوفة JSON
                if ($rawTexts && is_string($rawTexts) && (strpos($rawTexts, '[') !== 0)) {
                    $parts = array_filter(array_map('trim', explode('|', $rawTexts)));
                    foreach ($parts as $part) {
                        $marqueeItems[] = [
                            'text' => $part,
                            'url' => '',
                            'enabled' => true
                        ];
                    }
                    $marquee_texts = json_encode($marqueeItems, JSON_UNESCAPED_UNICODE);
                } else {
                    $marquee_texts = $rawTexts;
                }
                \App\Models\Setting::updateOrCreate(['key' => 'marquee_texts'], ['value' => $marquee_texts]);
            }
            // باقي الإعدادات
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_icons'], ['value' => $request->marquee_icons]);
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_color'], ['value' => $request->marquee_color]);
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_bg_start'], ['value' => $request->marquee_bg_start]);
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_bg_end'], ['value' => $request->marquee_bg_end]);
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_speed'], ['value' => $request->marquee_speed]);
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_bold'], ['value' => $request->has('marquee_bold')]);
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_enabled'], ['value' => $request->has('marquee_enabled')]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateItem(Request $request)
    {
        $index = $request->input('index');
        $text = $request->input('text');
        $url = $request->input('url');
        $icon = $request->input('icon');
        $enabled = $request->input('enabled') ? true : false;
        $json = \App\Models\Setting::get('marquee_texts');
        $items = $json ? json_decode($json, true) : [];
        // إذا لم يتم إرسال index أو تم إرسال add=1، أضف رسالة جديدة
        if ($request->has('add') || $index === null || $index === '') {
            $items[] = [
                'text' => $text,
                'url' => $url,
                'icon' => $icon,
                'enabled' => $enabled
            ];
            \App\Models\Setting::updateOrCreate(['key' => 'marquee_texts'], ['value' => json_encode($items, JSON_UNESCAPED_UNICODE)]);
            return response()->json(['success' => true, 'item' => end($items)]);
        }
        // تعديل رسالة موجودة
        if (!isset($items[$index])) return response()->json(['success' => false, 'error' => 'Not found']);
        $items[$index]['text'] = $text;
        $items[$index]['url'] = $url;
        $items[$index]['icon'] = $icon;
        $items[$index]['enabled'] = $enabled;
        \App\Models\Setting::updateOrCreate(['key' => 'marquee_texts'], ['value' => json_encode($items, JSON_UNESCAPED_UNICODE)]);
        return response()->json(['success' => true, 'item' => $items[$index]]);
    }

    public function toggleItem(Request $request)
    {
        $index = $request->input('index');
        $json = \App\Models\Setting::get('marquee_texts');
        $items = $json ? json_decode($json, true) : [];
        if (!isset($items[$index])) return response()->json(['success' => false, 'error' => 'Not found']);
        $items[$index]['enabled'] = empty($items[$index]['enabled']) ? true : false;
        \App\Models\Setting::updateOrCreate(['key' => 'marquee_texts'], ['value' => json_encode($items, JSON_UNESCAPED_UNICODE)]);
        return response()->json(['success' => true, 'enabled' => $items[$index]['enabled']]);
    }

    public function deleteItem(Request $request)
    {
        $index = $request->input('index');
        $json = \App\Models\Setting::get('marquee_texts');
        $items = $json ? json_decode($json, true) : [];
        if (!isset($items[$index])) return response()->json(['success' => false, 'error' => 'Not found']);
        array_splice($items, $index, 1);
        \App\Models\Setting::updateOrCreate(['key' => 'marquee_texts'], ['value' => json_encode($items, JSON_UNESCAPED_UNICODE)]);
        return response()->json(['success' => true]);
    }
}