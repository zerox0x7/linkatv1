<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Facades\Theme;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // Added for unique rule with ignore

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        $verifiedPhone = $request->session()->get('verified_phone');
        // $intendedUrl = $request->session()->get('intended_url'); // Not directly passed to view, handled in register method

        return view(Theme::getThemeView('pages.auth.register'), [
            'verifiedPhone' => $verifiedPhone,
        ]);
    }
    
    /**
     * Show the subscription registration form (global page).
     *
     * @return \Illuminate\View\View
     */
    public function showSubscriptionRegistrationForm(Request $request)
    {
        $verifiedPhone = $request->session()->get('verified_phone');
        
        return view('auth.subscription-register', [
            'verifiedPhone' => $verifiedPhone,
        ]);
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Pass $request to validator
        $this->validator($request->all(), $request)->validate(); 

        // Pass $request to create
        event(new Registered($user = $this->create($request->all(), $request)));

        Auth::login($user);

        // Clear session variables and redirect
        $intendedUrl = $request->session()->pull('intended_url', $this->redirectPath());
        $request->session()->forget('verified_phone');

        return redirect($intendedUrl);
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Password is now always required
        ];

        if ($request->session()->has('verified_phone')) {
            // Phone is coming from session. We can make it 'sometimes' in validation 
            // as it's not expected from the form, but still allow User model to have it.
            // Or, ensure it's not in $data and add it manually in create().
        $verifiedPhoneNumberWithPlus = $request->session()->get('verified_phone');
        $normalizedPhone = ltrim($verifiedPhoneNumberWithPlus, '+');

        $rules['phone'] = [
            'nullable',
            'string',
            'max:20',
            Rule::unique('users')->ignore(optional(User::where('phone', $normalizedPhone)->first())->id)
        ];
        } else {
            // Standard registration: make phone required or nullable based on general policy.
            // Assuming nullable if not through OTP, and unique if provided.
            $rules['phone'] = ['nullable', 'string', 'max:20', 'unique:users'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data, Request $request)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'is_active' => true,
        ];

        if ($request->session()->has('verified_phone')) {
            $verifiedPhoneNumberWithPlus = $request->session()->get('verified_phone');
            $userData['phone'] = ltrim($verifiedPhoneNumberWithPlus, '+');
        } elseif (isset($data['phone'])) {
            $userData['phone'] = ltrim($data['phone'], '+'); // Normalize if provided directly
        } else {
            $userData['phone'] = null;
        }

        return User::create($userData);
    }
    
    /**
     * Get the post register redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }
    
    /**
     * Handle subscription registration request with business information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function subscriptionRegister(Request $request)
    {
        $this->subscriptionValidator($request->all(), $request)->validate();

        event(new Registered($user = $this->createSubscriptionUser($request->all(), $request)));

        Auth::login($user);

        // Clear session variables
        $request->session()->forget('verified_phone');

        // Redirect to subscriptions page with success message
        return redirect()->route('subscriptions.index')
            ->with('success', 'تم إنشاء حسابك بنجاح! اختر خطة الاشتراك المناسبة لبدء رحلتك التجارية');
    }
    
    /**
     * Get a validator for subscription registration request with business fields.
     *
     * @param  array  $data
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function subscriptionValidator(array $data, Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
            // Business Information Fields
            'store_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'in:retail,wholesale,services,manufacturing,food_beverage,fashion,electronics,health_beauty,other'],
            'expected_monthly_sales' => ['nullable', 'string', 'in:under_5000,5000_15000,15000_50000,50000_100000,over_100000'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'business_license' => ['nullable', 'string', 'max:50'],
            
            // Terms agreement
            'terms' => ['required', 'accepted'],
            'marketing' => ['nullable', 'boolean'],
        ];

        // Handle phone validation
        if ($request->session()->has('verified_phone')) {
            $verifiedPhoneNumberWithPlus = $request->session()->get('verified_phone');
            $normalizedPhone = ltrim($verifiedPhoneNumberWithPlus, '+');

            $rules['phone'] = [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users')->ignore(optional(User::where('phone', $normalizedPhone)->first())->id)
            ];
        } else {
            $rules['phone'] = ['required', 'string', 'max:20', 'unique:users'];
        }

        return Validator::make($data, $rules);
    }
    
    /**
     * Create a new user instance for subscription registration.
     *
     * @param  array  $data
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\User
     */
    protected function createSubscriptionUser(array $data, Request $request)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'is_active' => true,
            
            // Business Information
            'store_name' => $data['store_name'],
            'business_type' => $data['business_type'],
            'expected_monthly_sales' => $data['expected_monthly_sales'] ?? null,
            'website_url' => $data['website_url'] ?? null,
            'business_license' => $data['business_license'] ?? null,
        ];

        // Handle phone
        if ($request->session()->has('verified_phone')) {
            $verifiedPhoneNumberWithPlus = $request->session()->get('verified_phone');
            $userData['phone'] = ltrim($verifiedPhoneNumberWithPlus, '+');
        } elseif (isset($data['phone'])) {
            $userData['phone'] = ltrim($data['phone'], '+');
        } else {
            $userData['phone'] = null;
        }

        return User::create($userData);
    }
} 