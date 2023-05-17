<?php

namespace App\Http\Controllers;

use App\Models\UserSetup;
use App\Http\Requests\StoreUserSetupRequest;
use App\Http\Requests\UpdateUserSetupRequest;

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
    public function show(UserSetup $userSetup)
    {
        //
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
    public function update(UpdateUserSetupRequest $request, UserSetup $userSetup)
    {
        //
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
