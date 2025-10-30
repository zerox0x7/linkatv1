<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeData;
use App\Models\Setting;
use App\Services\ResponsiveImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    protected $imageService;
    
    public function __construct()
    {
        $this->imageService = new ResponsiveImageService();
    }
    
    /**
     * Display theme customization page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get current active theme
        $activeTheme = Setting::get('active_theme', 'default');
        
        // Get available themes
        $availableThemes = $this->getAvailableThemes();
        
        // Get theme data for current store
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();
        
        return view('themes.admin.theme.index', compact('activeTheme', 'availableThemes', 'themeData'));
    }

    /**
     * Display active theme customization page
     *
     * @return \Illuminate\View\View
     */
    public function customize()
    {
        // Get current active theme
        $activeTheme = Setting::get('active_theme', 'default');
        
        // Get theme data for current store
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();
        
        // If no theme data exists, create default
        if (!$themeData) {
            $themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $activeTheme,
                'is_active' => true,
            ]);
        }
        
        return view('themes.admin.theme.customize', compact('activeTheme', 'themeData'));
    }

    /**
     * Display home page customization for active theme
     */
    public function customizeHome()
    {
        $activeTheme = Setting::get('active_theme', 'default');
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();
        if (!$themeData) {
            $themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $activeTheme,
                'is_active' => true,
            ]);
        }
        return view('themes.admin.theme.home', compact('activeTheme', 'themeData'));
    }

    /**
     * Display layout builder page for active theme
     */
    public function layoutBuilder()
    {
        $activeTheme = Setting::get('active_theme', 'default');
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();

        if (!$themeData) {
            $themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $activeTheme,
                'is_active' => true,
            ]);
        }

        return view('themes.admin.theme.layout-builder', compact('activeTheme', 'themeData'));
    }

    /**
     * Display sections control page for active theme
     */
    public function sectionsControl()
    {
        $activeTheme = Setting::get('active_theme', 'default');
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();

        if (!$themeData) {
            $themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $activeTheme,
                'is_active' => true,
            ]);
        }

        return view('themes.admin.theme.sections-control', compact('activeTheme', 'themeData'));
    }

    /**
     * Display custom code page for active theme
     */
    public function customCodePage()
    {
        $activeTheme = Setting::get('active_theme', 'default');
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();

        if (!$themeData) {
            $themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $activeTheme,
                'is_active' => true,
            ]);
        }

        return view('themes.admin.theme.custom-code', compact('activeTheme', 'themeData'));
    }

    /**
     * Display custom data page for active theme
     */
    public function customDataPage()
    {
        $activeTheme = Setting::get('active_theme', 'default');
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();

        if (!$themeData) {
            $themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $activeTheme,
                'is_active' => true,
            ]);
        }

        return view('themes.admin.theme.custom-data', compact('activeTheme', 'themeData'));
    }

    /**
     * Display media page for active theme
     */
    public function mediaPage()
    {
        $activeTheme = Setting::get('active_theme', 'default');
        $storeId = auth()->user()->store_id ?? null;
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();

        if (!$themeData) {
            $themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $activeTheme,
                'is_active' => true,
            ]);
        }

        return view('themes.admin.theme.media', compact('activeTheme', 'themeData'));
    }

    /**
     * Update theme customization data
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme_name' => 'required|string',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $storeId = auth()->user()->store_id ?? null;
        $themeName = $request->input('theme_name');

        // Get or create theme data
        $themeData = ThemeData::firstOrCreate(
            [
                'store_id' => $storeId,
                'theme_name' => $themeName,
            ],
            [
                'is_active' => true,
            ]
        );

        // Update basic data
        $themeData->custom_css = $request->input('custom_css');
        $themeData->custom_js = $request->input('custom_js');

        // Handle hero data
        if ($request->has('hero_title') || $request->has('hero_description')) {
            $heroData = $themeData->hero_data ?? [];
            $heroData['title'] = $request->input('hero_title');
            $heroData['description'] = $request->input('hero_description');
            $heroData['button_text'] = $request->input('hero_button_text');
            $heroData['button_link'] = $request->input('hero_button_link');
            $themeData->hero_data = $heroData;
        }

        // Handle banner data
        if ($request->has('banner_title') || $request->has('banner_description')) {
            $bannerData = $themeData->banner_data ?? [];
            $bannerData['title'] = $request->input('banner_title');
            $bannerData['description'] = $request->input('banner_description');
            $bannerData['link'] = $request->input('banner_link');
            $themeData->banner_data = $bannerData;
        }

        // Handle feature data
        if ($request->has('features')) {
            $themeData->feature_data = $request->input('features');
        }

        // Handle custom data
        if ($request->has('custom_data')) {
            $customData = $themeData->custom_data ?? [];
            foreach ($request->input('custom_data') as $key => $value) {
                $customData[$key] = $value;
            }
            $themeData->custom_data = $customData;
        }

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $heroData = $themeData->hero_data ?? [];
            
            // Delete old image if exists
            if (isset($heroData['main_image'])) {
                $this->imageService->deleteResponsiveImages($heroData['main_image'], 'public');
            }
            
            // Upload with responsive sizes
            $imagePaths = $this->imageService->uploadAndResize(
                $request->file('hero_image'),
                'themes/' . $themeName . '/hero',
                'public'
            );
            
            $heroData['main_image'] = $imagePaths;
            $themeData->hero_data = $heroData;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerData = $themeData->banner_data ?? [];
            
            // Delete old image if exists
            if (isset($bannerData['main_image'])) {
                $this->imageService->deleteResponsiveImages($bannerData['main_image'], 'public');
            }
            
            // Upload with responsive sizes
            $imagePaths = $this->imageService->uploadAndResize(
                $request->file('banner_image'),
                'themes/' . $themeName . '/banner',
                'public'
            );
            
            $bannerData['main_image'] = $imagePaths;
            $themeData->banner_data = $bannerData;
        }

        // Handle extra images upload
        if ($request->hasFile('extra_images')) {
            $extraImages = $themeData->extra_images ?? [];
            
            foreach ($request->file('extra_images') as $key => $file) {
                // Delete old image if exists
                if (isset($extraImages[$key])) {
                    $this->imageService->deleteResponsiveImages($extraImages[$key], 'public');
                }
                
                // Upload with responsive sizes
                $imagePaths = $this->imageService->uploadAndResize(
                    $file,
                    'themes/' . $themeName . '/extra',
                    'public'
                );
                
                $extraImages[$key] = $imagePaths;
            }
            
            $themeData->extra_images = $extraImages;
        }

        $themeData->save();

        return redirect()->back()->with('success', 'تم حفظ إعدادات الثيم بنجاح');
    }

    /**
     * Switch active theme
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchTheme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $themeName = $request->input('theme_name');
        
        // Check if theme exists
        if (!$this->themeExists($themeName)) {
            return redirect()->back()->with('error', 'الثيم المطلوب غير موجود');
        }

        // Update active theme in settings
        Setting::set('active_theme', $themeName);
        
        // Update active_theme column in users table for current user
        $user = auth()->user();
        if ($user) {
            $user->active_theme = $themeName;
            $user->save();
        }

        // Deactivate all themes for this store
        $storeId = $user->store_id ?? null;
        ThemeData::where('store_id', $storeId)->update(['is_active' => false]);

        // Activate selected theme (create if not exists)
        $themeData = ThemeData::firstOrCreate(
            [
                'store_id' => $storeId,
                'theme_name' => $themeName,
            ]
        );
        $themeData->is_active = true;
        $themeData->save();

        return redirect()->back()->with('success', 'تم تفعيل الثيم بنجاح');
    }

    /**
     * Delete theme image
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_type' => 'required|in:hero,banner,extra',
            'image_key' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $storeId = auth()->user()->store_id ?? null;
        $activeTheme = Setting::get('active_theme', 'default');
        
        $themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $activeTheme)
            ->first();

        if (!$themeData) {
            return response()->json(['error' => 'بيانات الثيم غير موجودة'], 404);
        }

        $imageType = $request->input('image_type');
        $imageKey = $request->input('image_key');

        switch ($imageType) {
            case 'hero':
                $heroData = $themeData->hero_data ?? [];
                if (isset($heroData[$imageKey])) {
                    $this->imageService->deleteResponsiveImages($heroData[$imageKey], 'public');
                    unset($heroData[$imageKey]);
                    $themeData->hero_data = $heroData;
                }
                break;

            case 'banner':
                $bannerData = $themeData->banner_data ?? [];
                if (isset($bannerData[$imageKey])) {
                    $this->imageService->deleteResponsiveImages($bannerData[$imageKey], 'public');
                    unset($bannerData[$imageKey]);
                    $themeData->banner_data = $bannerData;
                }
                break;

            case 'extra':
                $extraImages = $themeData->extra_images ?? [];
                if (isset($extraImages[$imageKey])) {
                    $this->imageService->deleteResponsiveImages($extraImages[$imageKey], 'public');
                    unset($extraImages[$imageKey]);
                    $themeData->extra_images = $extraImages;
                }
                break;
        }

        $themeData->save();

        return response()->json(['success' => 'تم حذف الصورة بنجاح']);
    }

    /**
     * Get available themes
     *
     * @return array
     */
    private function getAvailableThemes()
    {
        $themesPath = resource_path('views/themes');
        $themes = [];

        if (File::isDirectory($themesPath)) {
            $directories = File::directories($themesPath);

            foreach ($directories as $directory) {
                $name = basename($directory);
                
                // Skip admin and dashboard themes (special use only)
                if ($name === 'admin' || $name === 'dashboard') {
                    continue;
                }

                // Read theme config if exists
                $configFile = $directory . '/theme.json';
                $config = File::exists($configFile) 
                    ? json_decode(File::get($configFile), true) 
                    : [];

                $themes[$name] = [
                    'name' => $name,
                    'title' => $config['title'] ?? ucfirst($name),
                    'description' => $config['description'] ?? 'قالب ' . ucfirst($name),
                    'version' => $config['version'] ?? '1.0',
                    'author' => $config['author'] ?? '',
                    'screenshot' => $config['screenshot'] ?? null,
                ];
            }
        }

        return $themes;
    }

    /**
     * Check if theme exists
     *
     * @param string $themeName
     * @return bool
     */
    private function themeExists($themeName)
    {
        $themePath = resource_path('views/themes/' . $themeName);
        return File::isDirectory($themePath);
    }
}
