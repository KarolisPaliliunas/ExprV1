<?php

namespace App\Http\Controllers;

use App\Models\ExpertSystemConclusion;
use App\Http\Requests\StoreExpertSystemConclusionRequest;
use App\Http\Requests\UpdateExpertSystemConclusionRequest;
use Illuminate\Http\Request;

class ExpertSystemConclusionController extends Controller
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
     * @param  \App\Http\Requests\StoreExpertSystemConclusionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item_id, $project_id)
    {
                //setup
                $newConclusion = new ExpertSystemConclusion();
                $newConclusion->name = $request->name;
                $newConclusion->description = $request->description;
                $newConclusion->es_value_id = $item_id;
                $newConclusion->type = 30;
        
        
                //action
                $newConclusion->save();
                return redirect()->route('project.create', ['project_id' => $project_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpertSystemConclusion  $expertSystemConclusion
     * @return \Illuminate\Http\Response
     */
    public function show(ExpertSystemConclusion $expertSystemConclusion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpertSystemConclusion  $expertSystemConclusion
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpertSystemConclusion $expertSystemConclusion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpertSystemConclusionRequest  $request
     * @param  \App\Models\ExpertSystemConclusion  $expertSystemConclusion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item_id, $project_id)
    {
        //setup
        $conclusionToUpdate = ExpertSystemConclusion::find($item_id);
        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;

        //action
        $conclusionToUpdate->update(['name'=>$nameToUpate, 'description'=>$descriptionToUpate]);
        return redirect()->route('project.create', ['project_id' => $project_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpertSystemConclusion  $expertSystemConclusion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $item_id, $project_id)
    {
        //setup
        $conclusionToDestroy = ExpertSystemConclusion::find($item_id);

        //action
        $conclusionToDestroy->delete();
        return redirect()->route('project.create', ['project_id' => $project_id]);
    }
}
