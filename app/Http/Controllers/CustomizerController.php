<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomizerController extends Controller
{
    public function index()
    {
        return view('themes.admin.customizer.index');
    }

    public function menu()
    {
        return view('themes.admin.customizer.menu');
    }

    public function footer()
    {
        return view('themes.admin.customizer.footer');
    }

    public function productsPage()
    {
        return view('themes.admin.customizer.products-page');
    }

    public function couponsOffers()
    {
        return view('themes.admin.customizer.coupons-offers');
    }

    public function topHeader()
    {
        return view('themes.admin.customizer.top-header');
    }
}
