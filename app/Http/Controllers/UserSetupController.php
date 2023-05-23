<?php

namespace App\Http\Controllers;

use App\Models\UserSetup;
use App\Http\Requests\StoreUserSetupRequest;
use App\Http\Requests\UpdateUserSetupRequest;
use Illuminate\Http\Request;
//ADDED
use Illuminate\Support\Facades\Auth;

class UserSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserSetupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserSetupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSetup  $userSetup
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $userId = Auth::user()->id;
        $userSetup = UserSetup::where('user_id', $userId)->first();

        return view('user-settings', ['userSetup' => $userSetup]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserSetup  $userSetup
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSetup $userSetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserSetupRequest  $request
     * @param  \App\Models\UserSetup  $userSetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSetup $userSetup)
    {
        //setup
        $navColorToUpdate = $request->nav_color;
        $navFontToUpdate = $request->nav_font;
        $langCodeToUpdate = $request->lang_code;

        //action
        $userSetup->update(['nav_color'=>$navColorToUpdate, 'nav_font'=>$navFontToUpdate, 'lang_code'=>$langCodeToUpdate]);

        return redirect()->route('settings.show', ['userSetup'=>$userSetup]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSetup  $userSetup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSetup $userSetup)
    {
        //
    }
}
