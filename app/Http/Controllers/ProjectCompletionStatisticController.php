<?php

namespace App\Http\Controllers;

use App\Models\ProjectCompletionStatistic;
use App\Http\Requests\StoreProjectCompletionStatisticRequest;
use App\Http\Requests\UpdateProjectCompletionStatisticRequest;

class ProjectCompletionStatisticController extends Controller
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
     * @param  \App\Http\Requests\StoreProjectCompletionStatisticRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectCompletionStatisticRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectCompletionStatistic  $projectCompletionStatistic
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectCompletionStatistic $projectCompletionStatistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectCompletionStatistic  $projectCompletionStatistic
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectCompletionStatistic $projectCompletionStatistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectCompletionStatisticRequest  $request
     * @param  \App\Models\ProjectCompletionStatistic  $projectCompletionStatistic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectCompletionStatisticRequest $request, ProjectCompletionStatistic $projectCompletionStatistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectCompletionStatistic  $projectCompletionStatistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectCompletionStatistic $projectCompletionStatistic)
    {
        //
    }
}
