<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|string',
        ]);

        // Save the active theme in the database
        ThemeSetting::set('active_theme', $request->theme);

        return redirect()->back()->with('success', 'Theme updated successfully!');
    }
}