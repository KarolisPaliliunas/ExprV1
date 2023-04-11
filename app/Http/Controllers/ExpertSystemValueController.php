<?php

namespace App\Http\Controllers;

use App\Models\ExpertSystemValue;
use App\Http\Requests\StoreExpertSystemValueRequest;
use App\Http\Requests\UpdateExpertSystemValueRequest;
use Illuminate\Http\Request;

class ExpertSystemValueController extends Controller
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
     * @param  \App\Http\Requests\StoreExpertSystemValueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item_id, $project_id)
    {
        //setup
        $newValue = new ExpertSystemValue();
        $newValue->name = $request->name;
        $newValue->description = $request->description;
        $newValue->es_attribute_id = $item_id;
        $newValue->type = 20;


        //action
        $newValue->save();
        return redirect()->route('project.create', ['project_id' => $project_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpertSystemValue  $expertSystemValue
     * @return \Illuminate\Http\Response
     */
    public function show(ExpertSystemValue $expertSystemValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpertSystemValue  $expertSystemValue
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpertSystemValue $expertSystemValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpertSystemValueRequest  $request
     * @param  \App\Models\ExpertSystemValue  $expertSystemValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item_id, $project_id)
    {
        //setup
        $valueToUpdate = ExpertSystemValue::find($item_id);
        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;

        //action
        $valueToUpdate->update(['name'=>$nameToUpate, 'description'=>$descriptionToUpate]);
        return redirect()->route('project.create', ['project_id' => $project_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpertSystemValue  $expertSystemValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $item_id, $project_id)
    {
        //setup
        $valueToDestroy = ExpertSystemValue::find($item_id);

        //action
        $valueToDestroy->delete();
        return redirect()->route('project.create', ['project_id' => $project_id]);
    }
}
