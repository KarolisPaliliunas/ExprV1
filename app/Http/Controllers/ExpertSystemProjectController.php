<?php

namespace App\Http\Controllers;

use App\Models\ExpertSystemProject;
use App\Http\Requests\StoreExpertSystemProjectRequest;
use App\Http\Requests\UpdateExpertSystemProjectRequest;
//----ADDED
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpertSystemAttribute;
use App\Models\ExpertSystemValue;
use App\Models\ExpertSystemConclusion;
use App\Models\User;
use Exception;
use SimpleXMLElement;

class ExpertSystemProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //setup
        $filterTypeValue = $request->filterTypeValue;
        $filterSearchValue = $request->filterSearchValue;

        //Redirect to show
        if ($filterTypeValue==null && $filterSearchValue==null)
            return $this->show(10);
        elseif ($filterSearchValue != null )
            return $this->show($filterTypeValue, $filterSearchValue);
        else
            return $this->show($filterTypeValue);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $filterType = null, $filterValue = null)
    {
        //setup

        //$this->traverseArray($projectData, 0, ""); --FOR TESTING
        //Redirect to view
        return view('project-editor', ['filterType'=>$filterType, 'filterValue'=>$filterValue]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpertSystemProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //setup
        $newProject = new ExpertSystemProject(); 
        $newProject->name = $request->name;
        $newProject->description = $request->description;
        $newProject->user_created_id = Auth::user()->id;
        $newProject->is_published = false;

        //action
        $newProject->save();
        return redirect()->route('project.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpertSystemProject  $expertSystemProject
     * @return \Illuminate\Http\Response
     */
    public function show($filterTypeValue, $filterSearchValue = null)
    {
        //---setup
        $currentUserID = Auth::user()->id;
        $currentUserGroupID = Auth::user()->group_id;
        if ($filterTypeValue != 10)
        dd($filterTypeValue."  AND  ".$filterSearchValue);
        //---action
        switch ($filterTypeValue){
            case 10:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::
                    where('user_created_id', '=', $currentUserID)
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::
                    where('user_created_id', '=', $currentUserID)
                    ->whereRaw("LOWER('expert_system_projects.name') LIKE '%". strtolower($filterSearchValue)."%'")
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
            case 20:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::
                    where('is_published', '=', true)->whereNotNull('is_published')
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::
                    where('is_published', '=', true)->whereNotNull('is_published')
                    ->whereRaw("LOWER('expert_system_projects.name') LIKE '%". strtolower($filterSearchValue)."%'")
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
            case 30:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::
                    where('user_project_links.user_id', '=', $currentUserID)
                    ->join('user_project_links', 'user_project_links.es_project_id', '=', 'expert_system_projects.id')
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::
                    where('user_project_links.user_id', '=', $currentUserID)
                    ->whereRaw("LOWER('expert_system_projects.name') LIKE '%". strtolower($filterSearchValue)."%'")
                    ->join('user_project_links', 'user_project_links.es_project_id', '=', 'expert_system_projects.id')
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
            case 40:
                if($currentUserGroupID != null){
                    if($filterSearchValue == null){
                        $projects = ExpertSystemProject::
                        where('group_project_links.user_group_id', '=', $currentUserID)
                        ->join('group_project_links', 'group_project_links.es_project_id', '=', 'expert_system_projects.id')
                        ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                        ->select('expert_system_projects.*', 'users.name AS userName')
                        ->latest()->paginate(5);
                        return view('projects-list', compact('projects'))
                        ->with('filterTypeValue', $filterTypeValue)
                        ->with('filterSearchValue', $filterSearchValue)
                        ->with('i', (request()->input('page', 1) - 1) * 5);
                    } else {
                        $projects = ExpertSystemProject::
                        where('group_project_links.user_id', '=', $currentUserID)
                        ->whereRaw("LOWER('expert_system_projects.name') LIKE '%". strtolower($filterSearchValue)."%'")
                        ->join('group_project_links', 'group_project_links.es_project_id', '=', 'expert_system_projects.id')
                        ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                        ->select('expert_system_projects.*', 'users.name AS userName')
                        ->latest()->paginate(5);
                        return view('projects-list', compact('projects'))
                        ->with('filterTypeValue', $filterTypeValue)
                        ->with('filterSearchValue', $filterSearchValue)
                        ->with('i', (request()->input('page', 1) - 1) * 5);
                    }
                } else {
                    $projects = array();
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
            case 50:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::
                    join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::
                    whereRaw("LOWER('expert_system_projects.name') LIKE '%". strtolower($filterSearchValue)."%'")
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpertSystemProject  $expertSystemProject
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $filterType = null, $filterValue = null)
    {
        //setup
        $projectToEdit = ExpertSystemProject::find($project_id);
        
        //action
        return view('project-editor', ['projectToEdit' => $projectToEdit, 'filterType'=>$filterType, 'filterValue'=>$filterValue]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpertSystemProjectRequest  $request
     * @param  \App\Models\ExpertSystemProject  $expertSystemProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id)
    {
        //setup
        $projectToUpdate = ExpertSystemProject::find($project_id);

        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;

        //action
        $projectToUpdate->update(['name'=>$nameToUpate, 'description'=>$descriptionToUpate]);

        return redirect()->route('project.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpertSystemProject  $expertSystemProject
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id)
    {
        //setup
        $projectToDestroy = ExpertSystemProject::find($project_id);

        //action
        $projectToDestroy->delete();
        return redirect()->route('project.list');
    }

    public function execute($project_id, $currentAttributeId = null, $pickedValueId = null)
    {
        //setup
        //if (!empty($currentAttributeId)){
         //   dd("HERE: ".$project_id."  ATTTR: ".$currentAttributeId);
        //}
        $projectToExcecute = ExpertSystemProject::find($project_id);
        $newAttribute = null;
        $valuesList = null;
        $setConclusion = null;

        if(empty($currentAttributeId)) {
            $newAttribute = $this->getAttributeByProject($project_id);
            $valuesList = $this->getValues($newAttribute['id']);
        } else {
            $setConclusion = $this->getConclusion($pickedValueId);
                if(empty($setConclusion)) {
                    $newAttribute = $this->getAttributeByValue($pickedValueId);
                    $valuesList = $this->getValues($newAttribute['id']);
                }
        }

        //action
        //return redirect()->route('project.execute', ['project_id'=>$project_id, 'currentAttribute'=>$newAttribute['id'], 'valuesList'=>$valuesList, 'conclusion'=>$setConclusion]);
        return view('es-tree-executor', ['project'=>$projectToExcecute, 'attribute'=>$newAttribute, 'values'=>$valuesList, 'conclusion'=>$setConclusion]);
    }

    public function buildExpertSystemTree($project_id){
        //setup
        $project = ExpertSystemProject::find($project_id);
        $projectTree = $this->generateDataArray($project_id);

        //action
        return view('es-tree-editor', ['project'=>$project, 'projectTree'=>$projectTree]);
    }

    public function storeFromExchange($xmlData) {
        //setup
        $errorValue = null;

        //validation
        $this->valdiateXmlData($xmlData, 1);

        //action
        $newProject = new ExpertSystemProject(); 
        $newProject->name = $xmlData['projectName'];
        $newProject->description = $xmlData['projectDescription'];
        $newProject->user_created_id = User::where('name', $xmlData['createdBy'])->first()->id;
        $newProject->is_published = false;
        $newProject->save();
        $count = 0;
        foreach($xmlData as $field){
            if (is_array($field))
            $this->generateProjectFromXml($field, $newProject->id, 1);
        }
        //throw new Exception($count);
    }

    public function buildProjectXML(Request $request){
        $xmlData = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><projectItems></projectItems>');
        $project = ExpertSystemProject::where('name', $request->projectName)->first();
        if($project){
            $projectDataArray = $this->generateDataArray($project->id);
            $this->recursiveXMLBuilder($projectDataArray, $xmlData);
        }
        
        return $xmlData->asXML();//$xmlData;
    }

    //additionalFunctions

    private function recursiveXMLBuilder($data, $xml_data){
        foreach( $data as $key => $value ) {
            if( is_array($value) ) {
                if( is_numeric($key) ){//dealing with <0/>..<n/> from array
                    $key= "item";
                }
                $subnode = $xml_data->addChild($key);
                $this->recursiveXMLBuilder($value, $subnode);
            } else {
                    //$xml_data->addChild($key, $value);
                    if($value){
                        $xml_data->addChild($key, $value);
                    }
            }
        }
    }

    private function valdiateXmlData($dataArray, $typeBefore){
        //throw new Exception(array_key_exists('name', $dataArray));
        //if (!$dataArray->type) throw new Exception("CURRDataType: ".$dataArray->type."  TYBEBEF:".$typeBefore."   BOOL: ".$abc);
        if(array_key_exists('type', $dataArray)){
            if ($dataArray['type'] == $typeBefore) throw new Exception(__("Error: Next item can't be the same type!"));
            switch ((int)$dataArray['type']){
                case 10:
                    if ($typeBefore==1 || $typeBefore==20) {}
                        else throw new Exception(__("Error: Attribute must be a subject of a project or a value!"));
                        break;
                case 20:
                    if ($typeBefore !=10) throw new Exception(__("Error: Value must be a subject of an attribute!".(int)$dataArray['type']."  BEF: ".$typeBefore));
                    break;
                case 30:
                    if($typeBefore !=20) throw new Exception(__("Error: Conclusion must be subject of a value!"));
                    break;
            }
            $typeBefore = (int)$dataArray['type'];
        } else {
            if (!User::where('name', $dataArray['createdBy'])->exists()) throw new Exception(__("Error: User does not exist!"));
            if (ExpertSystemProject::where('name', $dataArray['projectName'])->exists()) throw new Exception(__("Error: Project: ".$dataArray['projectName']." already exists!"));
        }

        foreach ($dataArray as $value)
        {
            if (is_array($value)){
                $this->valdiateXmlData($value, $typeBefore);
            }      
        }
    }

    private function generateProjectFromXml($data, $idBefore = null, $forProject = null){

        $currentId = null;

        switch((int)$data['type']){
            case 10:
                if ($forProject == 1){
                    //create attribute for project
                    $newAttribute = new ExpertSystemAttribute();
                    $newAttribute->name = $data['name'];
                    $newAttribute->description = $data['description'];
                    $newAttribute->es_project_id = $idBefore;
                    $newAttribute->type = 10;
                    $newAttribute->save();
                } else {
                    //create attribute for value
                    $newAttribute = new ExpertSystemAttribute();
                    $newAttribute->name = $data['name'];
                    $newAttribute->description = $data['description'];
                    $newAttribute->es_value_id = $idBefore;
                    $newAttribute->type = 10;
                    $newAttribute->save();
                }
                $currentId = $newAttribute->id;
                break;
            case 20:
                // create for attribute
                $newValue = new ExpertSystemValue();
                $newValue->name = $data['name'];
                $newValue->description = $data['description'];
                $newValue->es_attribute_id = $idBefore;
                $newValue->type = 20;
                $newValue->save();
                $currentId = $newValue->id;
                break;
            case 30:
                //create for value
                $newConclusion = new ExpertSystemConclusion();
                $newConclusion->name = $data['name'];
                $newConclusion->description = $data['description'];
                $newConclusion->es_value_id = $idBefore;
                $newConclusion->type = 30;
                $newConclusion->save();
                $currentId = $newConclusion->id;
                break;
        }
        
        foreach ($data as $item)
        {
            if (is_array($item))
            {
                $this->generateProjectFromXml($item, $currentId);
            }
        }
    
    }

    //Generate project es data array
    private function generateDataArray($received_project_id) {
        //setup
        $data = array();


        //action
        $projectAttribute = $this->getAttributeByProject($received_project_id);
        if ($projectAttribute){
            $data = $projectAttribute;
            $projectValues = $this->getValues($projectAttribute['id']);
            foreach ($projectValues as $projectValue){
                $this->RecursiveValuesAttributesLoop($projectValue);
                $data[] = $projectValue;
            }
            return $data;
        } else return null;
    }

    private function RecursiveValuesAttributesLoop(&$receivedValue){
        $conclusion = $this->getConclusion($receivedValue['id']);
        if($conclusion){
            $receivedValue[] = $conclusion;
        } else {
            $newAttribute = $this->getAttributeByValue($receivedValue);
            if($newAttribute){
                $nextValues = $this->getValues($newAttribute);
                if($nextValues){
                    foreach($nextValues as $nextValue){
                        $this->RecursiveValuesAttributesLoop($nextValue);
                        $newAttribute[] = $nextValue;
                    }
                }
                $receivedValue[] = $newAttribute;
            }
        }
    }

    private function getAttributeByProject ($project_id){
        $attribute = ExpertSystemAttribute::
        select('*')
        ->where('expert_system_attributes.es_project_id', '=', $project_id)
        ->first();

        if ($attribute)
            $attribute = $attribute->toArray();

        return $attribute;
    }

    private function getAttributeByValue($value_id){
        $attribute = ExpertSystemAttribute::
        select('*')
        ->where('expert_system_attributes.es_value_id', '=', $value_id)
        ->first();

        if ($attribute)
            $attribute = $attribute->toArray();

        return $attribute;
    }

    private function getValues($attribute_id){
        $values = ExpertSystemValue::
        select('*')
        ->where('expert_system_values.es_attribute_id', '=', $attribute_id)
        ->get();

        if ($values)
            $values = $values->toArray();

        return $values;
    }

    private function getConclusion($value_id){
        $conclusion = ExpertSystemConclusion::
        select('expert_system_conclusions.*')
        ->where('expert_system_conclusions.es_value_id', '=', $value_id)
        ->first();

        if($conclusion)
           $conclusion = $conclusion->toArray();

        return $conclusion;
    }
    //endfunctions

    //TEST PRINT FUNCTION
    function traverseArray($array, $counter, $idenString){
            $receivedCounter = 0;
            $receivedCounter = $counter;
            for($i=0; $i<=$receivedCounter; $i++){
                $idenString = $idenString." - ";
            }

            foreach ($array as $key => $value)
            {
                if (is_array($value))
                {
                    $this->traverseArray($value, $receivedCounter, $idenString);
                }
                else
                {
                    echo $idenString;
                    echo "KEY: ". $key . "  VAL: " . $value . "<br />\n";
                }
            }
        }
}
