<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    
    public function index(Request $request)
    {
        $theme = $request->attributes->get('store')->active_theme;
        return view('themes.'.$theme.'.pages.games');
    }
}
