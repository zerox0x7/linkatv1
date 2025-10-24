<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Menu;
use App\Models\Footer;
use App\Models\Category;
use App\Models\HomePage;
use App\Models\HeaderSettings;
// use App\Models\AboutPage;
// use App\Models\ContactPage;
// use App\Models\PrivacyPage;
// use App\Models\TermsPage;
// use App\Models\FaqPage;

class ResolveStoreByDomain
{
    /**
     * Get default header settings object
     */
    private function getDefaultHeaderSettings()
    {
        $headerSettings = new \stdClass();
        
        // General Header Settings
        $headerSettings->header_enabled = true;
        $headerSettings->header_font = 'Tajawal';
        $headerSettings->header_sticky = true;
        $headerSettings->header_shadow = true;
        $headerSettings->header_scroll_effects = false;
        $headerSettings->header_smooth_transitions = true;
        $headerSettings->header_custom_css = null;
        $headerSettings->header_layout = 'default';
        $headerSettings->header_height = 60;
        
        // Logo Settings
        $headerSettings->logo_enabled = true;
        $headerSettings->logo_image = null;
        $headerSettings->logo_svg = null;
        $headerSettings->logo_width = 120;
        $headerSettings->logo_height = 50;
        $headerSettings->logo_position = 'right';
        $headerSettings->logo_border_radius = 'rounded-lg';
        $headerSettings->logo_shadow_enabled = false;
        $headerSettings->logo_shadow_class = 'shadow-lg';
        $headerSettings->logo_shadow_color = 'gray';
        $headerSettings->logo_shadow_opacity = '50';
        
        // Navigation Settings
        $headerSettings->navigation_enabled = true;
        $headerSettings->main_menus_enabled = false;
        $headerSettings->main_menus_number = 5;
        $headerSettings->show_home_link = true;
        $headerSettings->show_categories_in_menu = false;
        $headerSettings->categories_count = 5;
        $headerSettings->menu_items = null;
        
        // Header Features
        $headerSettings->search_bar_enabled = true;
        $headerSettings->user_menu_enabled = true;
        $headerSettings->shopping_cart_enabled = true;
        $headerSettings->wishlist_enabled = false;
        $headerSettings->language_switcher_enabled = false;
        $headerSettings->currency_switcher_enabled = false;
        
        // Contact Information
        $headerSettings->header_contact_enabled = false;
        $headerSettings->header_phone = null;
        $headerSettings->header_email = null;
        $headerSettings->contact_position = 'left';
        
        // Mobile Settings
        $headerSettings->mobile_menu_enabled = true;
        $headerSettings->mobile_search_enabled = true;
        $headerSettings->mobile_cart_enabled = true;
        
        return $headerSettings;
    }

    public function handle($request, Closure $next)
    {
        // Get the requested domain
        $domain = $request->getHost();
        //  dd($domain); // سيظهر الدومين هنا في المتصفح
        
        // Define localhost/development domains and local network
        $developmentDomains = [
            '127.0.0.1',
            'localhost',
            '::1',
            '192.168.1.107'
        ];
        
        // Define routes that should be accessible from localhost without tenant resolution
        $globalRoutes = [
            'subscriptions',
            'login',
            'register',
            'password'
        ];
        
        // Check if we're accessing from development domain and a global route
        $isDevEnvironment = in_array($domain, $developmentDomains);
        $isGlobalRoute = false;
        
        foreach ($globalRoutes as $route) {
            if ($request->is($route) || $request->is($route.'/*')) {
                $isGlobalRoute = true;
                break;
            }
        }
        
        // If it's a development environment and global route, use default setup
        if ($isDevEnvironment && $isGlobalRoute) {
            // Set default values for global routes in development
            $defaultHomePage = new \stdClass();
            $defaultHomePage->store_name = config('app.name', 'منصة الاشتراكات');
            
            $defaultHeaderSettings = $this->getDefaultHeaderSettings();
            
            $menus = Menu::where('owner_id', 7)->orderBy('order')->get() ?? collect([]);
            $cats = collect([]);
            
            // Share with views
            view()->share('name', $defaultHomePage->store_name);
            view()->share('storeName', $defaultHomePage->store_name);
            view()->share('menus', $menus);
            view()->share('footer', []);
            view()->share('cats', $cats);
            view()->share('storeId', 0);
            view()->share('homePage', $defaultHomePage);
            view()->share('headerSettings', $defaultHeaderSettings);
            
            return $next($request);
        }
        
        // Find the store by custom domain or subdomain
        $store = User::where('custom_domain', $domain)->get()->first();

        // this code is used to check if the page exists in the theme
        // if the page exists, it will return the page
        // if the page does not exist, it will return a 404 error
        // the path is the path of the page
        // the theme is the theme of the store
        // the store is the store of the domain
        // $theme = $store->active_theme;
        
        // $path = resource_path('views/themes/'.$theme.'/pages/'.$request->path().'.blade.php');
        
        //  if(!file_exists($path)){
        //     abort(404, 'Page not found');
        //  }

        if ($store) {
            $homePage = HomePage::where('store_id', $store->id)->first();
            $headerSettings = HeaderSettings::where('store_id', $store->id)->first();
            // dd($headerSettings);
            // dd($homePage);
            // $aboutPage = AboutPage::where('store_id', $store->id)->first();
            // $contactPage = ContactPage::where('store_id', $store->id)->first();
            // $privacyPage = PrivacyPage::where('store_id', $store->id)->first();
            // $termsPage = TermsPage::where('store_id', $store->id)->first();
            // $faqPage = FaqPage::where('store_id', $store->id)->first();
            // $blogPage = BlogPage::where('store_id', $store->id)->first();
            // $blogPostPage = BlogPostPage::where('store_id', $store->id)->first();
            // $blogCategoryPage = BlogCategoryPage::where('store_id', $store->id)->first(); 

            //  get header and footer  store data and make them global for all views blade 

             $menus = Menu::where('owner_id', $store->id)->orderBy('order')->get();
             $cats   = Category::where('store_id',$store->id)->limit(5)->get();

              if($menus->isEmpty())
              {
                $menus = Menu::where('owner_id', 7 )->orderBy('order')->get();
              }
              // $footer = Footer::where('store_id', $store->id)->first();  
            
            // Set the current store ID in session for all users
            session(['current_store_id' => $store->id]);

            $request->attributes->set('store', $store);
            $request->attributes->set('theme', $store->active_theme);
            $this->storeName = $store->name;

            // Create default header settings if not found
            if (!$headerSettings) {
                $headerSettings = $this->getDefaultHeaderSettings();
            }

            // Create default home page if not found
            if (!$homePage) {
                $homePage = new \stdClass();
                $homePage->store_name = $store->name ?? 'متجر غير معروف';
            }

            // Share with views
            view()->share('name', $homePage->store_name ?? 'متجر غير معروف');
              view()->share('storeName', $homePage->store_name ?? 'متجر غير معروف');
            view()->share('menus', $menus ?? []);
            view()->share('footer', $footer ?? []);
            view()->share('cats', $cats ?? []);
            view()->share('storeId', $store->id ?? 0);
            view()->share('homePage', $homePage);
            view()->share('headerSettings', $headerSettings);
        } else {
            // If no store is found and it's not a development environment with global route
            if ($isDevEnvironment) {
                // For development environment, provide default setup
                $defaultHomePage = new \stdClass();
                $defaultHomePage->store_name = config('app.name', 'منصة الاشتراكات');
                
                $defaultHeaderSettings = $this->getDefaultHeaderSettings();
                
                $menus = Menu::where('owner_id', 7)->orderBy('order')->get() ?? collect([]);
                $cats = collect([]);
                
                // Share with views
                view()->share('name', $defaultHomePage->store_name);
                view()->share('storeName', $defaultHomePage->store_name);
                view()->share('menus', $menus);
                view()->share('footer', []);
                view()->share('cats', $cats);
                view()->share('storeId', 0);
                view()->share('homePage', $defaultHomePage);
                view()->share('headerSettings', $defaultHeaderSettings);
            } else {
                // If no store is found in production, show a 404 error
                abort(404, 'Store not found');
            }
        }

        return $next($request);
    }
}