<?php

namespace App\Http\Middleware;

use App\Models\UserSetup;
use Closure;
use Illuminate\Http\Request;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!empty(auth()->user())){
            $currentUserFromSession = auth()->user();
            $userSetup = UserSetup::where('user_id', $currentUserFromSession->id)->first();
            $sessionLocale = strtolower($userSetup->lang_code);
            if(!session()->has('locale')) {
                session(['locale' => $sessionLocale]);
            } else if (session()->get('locale') != $sessionLocale){
                session(['locale' => $sessionLocale]);
            } 

            app()->setLocale(session('locale'));
        }

        return $next($request);
    }
}
