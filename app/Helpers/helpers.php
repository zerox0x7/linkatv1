<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getActiveTheme')) {
    /**
     * Get the active theme for the authenticated user.
     *
     * @return string
     */
    function getActiveTheme()
    {
        // Check if the user is authenticated and return their active theme
        return Auth::check() ? Auth::user()->active_theme : 'default';
    }
}


if (!function_exists('storeCheck')) {
    /**
     * Get the active theme for the authenticated user.
     *
     * @return string
     */
    function storeCheck()
    {
        $store = $request->attributes->get('store');
        if($request->input('store_id') != $store->id )
        {
             abort(403, 'Unauthorized action.');

        }
    }
}