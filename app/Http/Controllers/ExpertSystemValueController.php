<?php

namespace App\Http\Controllers;

use App\Models\ExpertSystemValue;
use App\Http\Requests\StoreExpertSystemValueRequest;
use App\Http\Requests\UpdateExpertSystemValueRequest;
use App\Models\ExpertSystemAttribute;
use App\Models\ExpertSystemConclusion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        //validate
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'  
        ]);

        //setup
        $newValue = new ExpertSystemValue();
        $newValue->name = $request->name;
        $newValue->description = $request->description;
        $newValue->es_attribute_id = $item_id;
        $newValue->type = 20;


        //action
        $newValue->save();
        return redirect()->route('project.generateTreeEditor', ['project_id' => $project_id]);
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
        //validate
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'  
        ]);

        //setup
        $valueToUpdate = ExpertSystemValue::find($item_id);
        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;

        //action
        $valueToUpdate->update(['name'=>$nameToUpate, 'description'=>$descriptionToUpate]);
        return redirect()->route('project.generateTreeEditor', ['project_id' => $project_id]);
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

        //validation
        $noRelatedItems = $this->validateNoRelatedItems($valueToDestroy);
        if($noRelatedItems == false)
            throw ValidationException::withMessages(['NoFieldName' => __('messages.hasRelatedItems')]);

        //action
        $valueToDestroy->delete();
        return redirect()->route('project.generateTreeEditor', ['project_id' => $project_id]);
    }

    //validators
    private function validateNoRelatedItems($expertSystemValue){
        $noRelatedItems = true;
        $foundAttribute = ExpertSystemAttribute::where('es_value_id', $expertSystemValue->id)->first();
        $foundConclusion = ExpertSystemConclusion::where('es_value_id', $expertSystemValue->id)->first();
        if(!empty($foundAttribute)){
            $noRelatedItems = false;
        } else if(!empty($foundConclusion))
            $noRelatedItems = false;
        
        return $noRelatedItems;
    }
}
