<?php

namespace App\Http\Controllers;

use App\Models\DigitalCard;
use App\Models\Category;
use App\Models\Visit;
use Illuminate\Http\Request;

class DigitalCardController extends Controller
{
    /**
     * عرض قائمة البطاقات الرقمية
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = DigitalCard::query()->where('is_active', true);
        
        // تصفية حسب الفئة
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }
        
        // تصفية حسب العملة
        if ($request->has('currency')) {
            $query->where('currency', $request->currency);
        }
        
        // تصفية حسب المنطقة
        if ($request->has('region')) {
            $region = $request->region;
            $query->whereJsonContains('regions', $region);
        }
        
        // البحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // الترتيب
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'value_asc':
                $query->orderBy('value', 'asc');
                break;
            case 'value_desc':
                $query->orderBy('value', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $digitalCards = $query->paginate(12);
        
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
            
        // العملات المتاحة
        $currencies = DigitalCard::select('currency')
            ->distinct()
            ->pluck('currency');
            
        return view('digital_cards.index', compact('digitalCards', 'categories', 'currencies'));
    }
    
    /**
     * عرض تفاصيل البطاقة الرقمية
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        $digitalCard = DigitalCard::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();
        
        // تسجيل الزيارة
        Visit::log($digitalCard);
        
        // بطاقات رقمية ذات صلة
        $relatedCards = DigitalCard::where('category_id', $digitalCard->category_id)
            ->where('id', '!=', $digitalCard->id)
            ->where('is_active', true)
            ->take(4)
            ->inRandomOrder()
            ->get();
            
        return view('digital_cards.show', compact('digitalCard', 'relatedCards'));
    }
    
    /**
     * عرض البطاقات الرقمية المميزة
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function featured()
    {
        $digitalCards = DigitalCard::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->paginate(12);
            
        return view('digital_cards.featured', compact('digitalCards'));
    }
} 