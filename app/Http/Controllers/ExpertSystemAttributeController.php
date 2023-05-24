<?php

namespace App\Http\Controllers;

use App\Models\ExpertSystemAttribute;
use App\Http\Requests\StoreExpertSystemAttributeRequest;
use App\Http\Requests\UpdateExpertSystemAttributeRequest;
use App\Models\ExpertSystemValue;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExpertSystemAttributeController extends Controller
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
     * @param  \App\Http\Requests\StoreExpertSystemAttributeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item_id, $project_id, $createForProject = false)
    {
        //validate
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'  
        ]);

        //setup
        if ($createForProject == true){
            $newAttribute = new ExpertSystemAttribute();
            $newAttribute->name = $request->name;
            $newAttribute->description = $request->description;
            $newAttribute->es_project_id = $item_id;
            $newAttribute->type = 10;
        } else {
            $newAttribute = new ExpertSystemAttribute();
            $newAttribute->name = $request->name;
            $newAttribute->description = $request->description;
            $newAttribute->es_value_id = $item_id;
            $newAttribute->type = 10;
        }

        //action
        $newAttribute->save();
        return redirect()->route('project.generateTreeEditor', ['project_id' => $project_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpertSystemAttribute  $expertSystemAttribute
     * @return \Illuminate\Http\Response
     */
    public function show(ExpertSystemAttribute $expertSystemAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpertSystemAttribute  $expertSystemAttribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $project_id, $item_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpertSystemAttributeRequest  $request
     * @param  \App\Models\ExpertSystemAttribute  $expertSystemAttribute
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
        $attributeToUpdate = ExpertSystemAttribute::find($item_id);

        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;

        //action
        $attributeToUpdate->update(['name'=>$nameToUpate, 'description'=>$descriptionToUpate]);
        return redirect()->route('project.generateTreeEditor', ['project_id' => $project_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpertSystemAttribute  $expertSystemAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $item_id, $project_id)
    {
        //setup
        $attributeToDestroy = ExpertSystemAttribute::find($item_id);
        
        //validate
        $noRelatedItems = $this->validateNoRelatedItems($attributeToDestroy);
        if($noRelatedItems == false)
            throw ValidationException::withMessages(['NoFieldName' => __('messages.hasRelatedItems')]);

        //action
        $attributeToDestroy->delete();
        return redirect()->route('project.generateTreeEditor', ['project_id' => $project_id]);
    }

    //validators
    private function validateNoRelatedItems($expertSystemAttribute){
        $noRelatedItems = true;
        $foundValue = ExpertSystemValue::where('es_attribute_id', $expertSystemAttribute->id)->first();

        if(!empty($foundValue))
            $noRelatedItems = false;
        
        return $noRelatedItems;
    }
}
