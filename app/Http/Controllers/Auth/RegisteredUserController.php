<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
//ADDED
use App\Models\UserSetup;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $userType = $this->determineUserType(); // 100 - super admin, 0 - user, 1 - admin

        $ip = $_SERVER['REMOTE_ADDR'];
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        $defaultCountryCode = 'EN';

        if(!empty($details))
            if(property_exists($details, 'country'))
                if($details->country == 'LT')
                    $defaultCountryCode = 'LT';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $userType,
            'password' => Hash::make($request->password)
        ]);

        $this->createDefaultSetup($user, $defaultCountryCode);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    private function determineUserType(){
        $anyUsers = User::first();
        if (empty($anyUsers))
            return 100;
        else return 0;
    }

    private function createDefaultSetup(User $user, String $defaultCountryCode){
        UserSetup::create([
            'user_id' => $user->id,
            'lang_code' => $defaultCountryCode,
            'nav_color' => 10,
            'nav_font' => 10
        ]);
    }
}
