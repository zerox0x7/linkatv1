<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountDigetal;
use App\Models\Product;

class AccountDigetalController extends Controller
{
    // إضافة حساب جديد
    public function store(Request $request, Product $product)
    {
        // دعم طريقتين: مصفوفة accounts[] أو نص واحد
        $accounts = $request->accounts;
        if (!$accounts && $request->has('text')) {
            $accounts = [ $request->text ];
        }
        if (!is_array($accounts)) {
            $accounts = [];
        }
        $added = 0;
        foreach ($accounts as $line) {
            $line = trim($line);
            if ($line !== '') {
                // تحليل النص إلى مصفوفة من الأسطر
                $lines = array_filter(explode("\n", $line), function($l) {
                    return trim($l) !== '';
                });
                
                AccountDigetal::create([
                    'product_id' => $product->id,
                    'status' => 'available',
                    'meta' => ['lines' => $lines],
                ]);
                $added++;
            }
        }
        // تحديث المخزون
        $product->increment('stock', $added);
        return back()->with('success', 'تمت إضافة ' . $added . ' حساب(ات) بنجاح');
    }

    // تحديث حساب
    public function update(Request $request, Product $product, AccountDigetal $account)
    {
        $request->validate([
            'text' => 'required|string',
        ]);
        
        // تحليل النص إلى مصفوفة من الأسطر
        $lines = array_filter(explode("\n", $request->text), function($l) {
            return trim($l) !== '';
        });
        
        $account->update([
            'meta' => ['lines' => $lines],
        ]);
        return back()->with('success', 'تم تحديث الحساب بنجاح');
    }

    // حذف حساب
    public function destroy(Product $product, AccountDigetal $account)
    {
        $account->delete();
        // تحديث المخزون
        $product->decrement('stock');
        return back()->with('success', 'تم حذف الحساب بنجاح');
    }
} 