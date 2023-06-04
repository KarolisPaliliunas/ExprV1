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
use App\Models\UserGroup;
use App\Models\UserProjectLink;
use Exception;
use SimpleXMLElement;
use Illuminate\Validation\ValidationException;

class ExpertSystemProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
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
    public function create(Request $request, $filterType = null, $filterValue = null){
        //setup

        //$this->traverseArray($projectData, 0, ""); --FOR TESTING
        //Redirect to view
        return view('project-editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpertSystemProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){ 
        //validation
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required'    
        ]);

        //setup
        $newProject = new ExpertSystemProject(); 
        $newProject->name = $request->name;
        $newProject->description = $request->description;
        $newProject->user_created_id = Auth::user()->id;
        $newProject->is_published = false;

        //action
        $newProject->save();
        return redirect()->route('project.list')->with('projectCreateSuccess', __('messages.projectCreateSuccessMessage'));;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpertSystemProject  $expertSystemProject
     * @return \Illuminate\Http\Response
     */
    public function show($filterTypeValue, $filterSearchValue = null){
        //---setup
        $currentUser = Auth::user();
        $currentUserID = $currentUser->id;
        $currentUserGroupID = Auth::user()->group_id;

        //---action
        switch ($filterTypeValue){
            case 10:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::whereExists(function ($query) use($currentUserID) {
                        $query->select('user_id')
                              ->from('user_project_links')
                              ->whereRaw('user_project_links.es_project_id = expert_system_projects.id')
                              ->whereRaw('user_project_links.user_id = '.$currentUserID);
                    })
                    ->orWhere('user_created_id', '=', $currentUserID)
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName', 'users.id as userID')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::where(function ($query) use($currentUserID, $filterSearchValue) {
                        $query->whereExists(function ($query) use($currentUserID) {
                            $query->select('user_id')
                                  ->from('user_project_links')
                                  ->whereRaw('user_project_links.es_project_id = expert_system_projects.id')
                                  ->whereRaw('user_project_links.user_id = '.$currentUserID);
                    })
                    ->whereRaw("LOWER(expert_system_projects.name) LIKE '%".strtolower($filterSearchValue)."%'");})
                    ->orWhere(function ($query) use($currentUserID, $filterSearchValue) {
                        $query->where('user_created_id', '=', $currentUserID)
                        ->whereRaw("LOWER(expert_system_projects.name) LIKE '%".strtolower($filterSearchValue)."%'");
                    })
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName', 'users.id as userID')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
            case 20:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::
                    where('is_published', '=', true)
                    ->whereNotNull('is_published')
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName', 'users.id AS userID')
                    ->latest()->paginate(5);
                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::
                    where('is_published', '=', true)->whereNotNull('is_published')
                    ->whereRaw("LOWER(expert_system_projects.name) LIKE '%".strtolower($filterSearchValue)."%'")
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName', 'users.id AS userID')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
            case 30:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::
                    where('user_project_links.user_id', '=', $currentUserID)
                    ->join('user_project_links', 'user_project_links.es_project_id', '=', 'expert_system_projects.id')
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName', 'users.id AS userID')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::
                    where('user_project_links.user_id', '=', $currentUserID)
                    ->whereRaw("LOWER(expert_system_projects.name) LIKE '%".strtolower($filterSearchValue)."%'")
                    ->join('user_project_links', 'user_project_links.es_project_id', '=', 'expert_system_projects.id')
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName', 'users.id AS userID')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
            case 40:
                if($filterSearchValue == null){
                    $projects = ExpertSystemProject::
                    join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    $projects = ExpertSystemProject::
                    whereRaw("LOWER(expert_system_projects.name) LIKE '%".strtolower($filterSearchValue)."%'")
                    ->join('users', 'expert_system_projects.user_created_id', '=', 'users.id')
                    ->select('expert_system_projects.*', 'users.name AS userName')
                    ->latest()->paginate(5);

                    return view('projects-list', compact('projects'))
                    ->with('filterTypeValue', $filterTypeValue)
                    ->with('filterSearchValue', $filterSearchValue)
                    ->with('currentUser', $currentUser)
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
    public function edit($project_id, $filterType = null, $filterValue = null){
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
    public function update(Request $request, $project_id){
        //validation

        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required'    
        ]);

        //setup
        $projectToUpdate = ExpertSystemProject::find($project_id);

        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;

        //action
        $projectToUpdate->update(['name'=>$nameToUpate, 'description'=>$descriptionToUpate]);

        return redirect()->route('project.list')->with('projectUpdateSuccess', __('messages.projectUpdateSuccessMessage'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpertSystemProject  $expertSystemProject
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id){
        //validate
        $noUsers = $this->validateNoUsersAssignedToProject($project_id);
        if($noUsers == false)
            throw ValidationException::withMessages(['NoFieldName' => __('messages.projectHasAssignedUsersMessage')]);

        //setup
        $projectToDestroy = ExpertSystemProject::find($project_id);
        
        //action
        $this->deleteAllItemsInProject($project_id);
        $projectToDestroy->delete();
        return redirect()->route('project.list')->with('projectDeleteSuccess', __('messages.projectDeleteSuccessMessage'));
    }

    public function execute($project_id, $currentAttributeId = null, $pickedValueId = null){
        //setup
        $currentUser = Auth::user();
        $projectToExcecute = ExpertSystemProject::find($project_id);
        $newAttribute = null;
        $valuesList = null;
        $setConclusion = null;

        //validate
        if ($projectToExcecute->is_published == false)
            throw ValidationException::withMessages(['NoFieldName' => __('messages.projectNotPublished')]);
        
        $canUserExecute = $this->validateUserAssignedOrOwner($projectToExcecute, $currentUser);
        if ($canUserExecute == false)
            throw ValidationException::withMessages(['NoFieldName' => __('messages.projectNotAssigned')]);

        //setup
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

    public function publishProject($project_id){
        //validate
        $allValuesHaveConclusion = $this->validateAllValuesHaveConclusion($project_id);

        if ($allValuesHaveConclusion == false)
            throw ValidationException::withMessages(['NoFieldName' => __('messages.projectNotFinishedValuesWithNoConclusionMessage')]);

        //setup
        $projectToUpdate = ExpertSystemProject::find($project_id);
        
        //action
        $projectToUpdate->update(['is_published'=>true]);
        
        return redirect()->route('project.list')->with('projectPublishSuccess', __('messages.projectPublishSuccessMessage'));
    }

    public function unpublishProject($project_id){
        //setup
        $projectToUpdate = ExpertSystemProject::find($project_id);

        $userProjectLinks = UserProjectLink::select()->
        where('es_project_id', $project_id)
        ->get();
        
        //action
        if(!empty($userProjectLinks)){
            foreach ($userProjectLinks as $userProjectLink){
                $userProjectLink->delete();
            }
        }

        $projectToUpdate->update(['is_published'=>false]);
        
        return redirect()->route('project.list')->with('projectUnpublishSuccess', __('messages.projectUnpublishSuccessMessage'));
    }
    
    public function assignUsersList($project_id){
        //setup
        $project = ExpertSystemProject::find($project_id);

        $userList = $this->getUsersNotAssignedForProject($project_id);
        
        if (empty($userList->toArray()))
            $userList = null;

        //action
        return view('assign-users-list', ['userList' => $userList, 'project' => $project]);
    }

    public function assignGroupsList($project_id){
        //setup
        $project = ExpertSystemProject::find($project_id);

        $groupsListData = $this->getGroupsWithUnassignedUsers($project_id);
        
        if (empty($groupsListData))
            $groupsListData = null;

        //action
        return view('assign-groups-list', ['groupsListData' => $groupsListData, 'project' => $project]);
        
    }

    public function unassignUsersList($project_id){
        //setup
        $project = ExpertSystemProject::find($project_id);

        $userList = $this->getUsersAssignedForProject($project_id);
                
        if (empty($userList->toArray()))
            $userList = null;
        
        //action
        return view('unassign-users-list', ['userList' => $userList, 'project' => $project]);
    }

    public function assignUsers(Request $request){
        //validate
        if(empty($request->selectedUsersIdsList))
            return redirect()->back();

        //setup
        $receivedProject_id = $request->project_id;
        $userIdsList = $request->selectedUsersIdsList;
        
        //action
        foreach ($userIdsList as $userId){
            $this->createUserProjectLink($userId, $receivedProject_id);
        }

        return redirect()->route('project.list');
    }

    public function unassignUsers(Request $request){
        //validate
        if(empty($request->selectedUsersIdsList))
            return redirect()->back();

        //setup
        $receivedProject_id = $request->project_id;
        $userIdsList = $request->selectedUsersIdsList;
        
        //action
        foreach ($userIdsList as $userId){
            $this->destroyUserProjectLink($userId, $receivedProject_id);
        }

        return redirect()->route('project.list');
    }

    public function assignGroups(Request $request){
        //validate
        if(empty($request->selectedGroupsIdsList))
            return redirect()->back();

        //setup
        $receivedProject_id = $request->project_id;
        $groupsIdsList = $request->selectedGroupsIdsList;

        
        $userIdsNotAssignedToProjectInGroup = User::select('id')->
        whereExists(function ($query) use($groupsIdsList) {
            $query->select('user_id')
                  ->from('user_group_links')
                  ->whereRaw('user_group_links.user_id = users.id')
                  ->whereIn('user_group_links.user_group_id', $groupsIdsList);
        })->whereNotExists(function ($query) use($receivedProject_id) {
            $query->select('user_id')
                  ->from('user_project_links')
                  ->whereRaw('user_project_links.user_id = users.id')
                  ->whereRaw('user_project_links.es_project_id = '.$receivedProject_id);
        })
        ->distinct()->get();

        //action
        foreach ($userIdsNotAssignedToProjectInGroup as $userId){
            $this->createUserProjectLink($userId->id, $receivedProject_id);
        }

        return redirect()->route('project.list');
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

    private function getUsersNotAssignedForProject($project_id){

        $users = User::select('*')->whereNotExists(function ($query) use($project_id) {
            $query->select('user_id')
                  ->from('user_project_links')
                  ->whereRaw('user_project_links.user_id = users.id')
                  ->whereRaw('user_project_links.es_project_id = '.$project_id);
        })
        ->get();

        return $users;
    }

    private function getGroupsWithUnassignedUsers($project_id){

        $groupsData = [];
        $allGroups = UserGroup::all();

        foreach($allGroups as $group){

            $localUserGrouControllerObject = new UserGroupController();
            $newGroupDataRecord =[];
            $userGroupId = $group->id;
            $numberOfUsersInGroup = $localUserGrouControllerObject->numberOfUsersInGroup($userGroupId);

            $numberOfUsersAssignedToProjectInGroup = User::select()->
            whereExists(function ($query) use($userGroupId) {
                $query->select('user_id')
                      ->from('user_group_links')
                      ->whereRaw('user_group_links.user_id = users.id')
                      ->whereRaw('user_group_links.user_group_id = '.$userGroupId);
            })->whereExists(function ($query) use($project_id) {
                $query->select('user_id')
                      ->from('user_project_links')
                      ->whereRaw('user_project_links.user_id = users.id')
                      ->whereRaw('user_project_links.es_project_id = '.$project_id);
            })
            ->count();

            $newGroupDataRecord['userGroup'] = $group;
            $newGroupDataRecord['numberOfUsersInGroup'] = $numberOfUsersInGroup;
            $newGroupDataRecord['numberOfUsersAssignedToProjectInGroup'] = $numberOfUsersAssignedToProjectInGroup;

            $groupsData[] = $newGroupDataRecord;
        }

        //dd($groupsData);
        return $groupsData;
    }

    private function createUserProjectLink($user_id, $project_id){
        //action
        $newUserProjectLink = new UserProjectLink();
        $newUserProjectLink->es_project_id = $project_id;
        $newUserProjectLink->user_id = $user_id;
        $newUserProjectLink->save();
    }

    private function destroyUserProjectLink($user_id, $project_id){
        //setup
        $userProjectLinkToDestory = UserProjectLink::select()->
        where('user_id', $user_id)->
        where('es_project_id', $project_id)
        ->first();

        //action
        $userProjectLinkToDestory->delete();
    }

    private function getUsersAssignedForProject($project_id){

        $users = User::select('*')->whereExists(function ($query) use($project_id) {
            $query->select('user_id')
                  ->from('user_project_links')
                  ->whereRaw('user_project_links.user_id = users.id')
                  ->whereRaw('user_project_links.es_project_id = '.$project_id);
        })
        ->get();

        return $users;
    }

    private function deleteAllItemsInProject($project_id){

        $dataArray = $this->generateDataArray($project_id);
        $this->traverseArrayAndDeleteItems($dataArray);

    }

    private function traverseArrayAndDeleteItems($array){
        if($array){
            $currentItemId = null;
            foreach ($array as $key => $keyValue){
                if($key == 'id')
                    $currentItemId = $keyValue;
                if($key == 'type' && $keyValue == 10){ // if attribute
                    $attribute = ExpertSystemAttribute::find($currentItemId);
                    $attribute->delete();
                }
                if($key == 'type' && $keyValue == 20){ // if value
                    $value = ExpertSystemValue::find($currentItemId);
                    $value->delete();
                }
                if($key == 'type' && $keyValue == 30){ // if conclusion
                    $conclusion = ExpertSystemConclusion::find($currentItemId);
                    $conclusion->delete();
                }
                if (is_array($keyValue)){
                    $this->traverseArrayAndDeleteItems($keyValue);
                }
            }
        }
    }
    //endfunctions

    //customValidators
    private function validateAllValuesHaveConclusion($project_id){
        $numberOfValuesWithoutConclusion = 0;
        $dataArray = $this->generateDataArray($project_id);
        $this->traverseArrayAndValidateItems($dataArray, $numberOfValuesWithoutConclusion);
        
        if ($numberOfValuesWithoutConclusion == 0)
            return true;
        else
            return false;
    }

    private function traverseArrayAndValidateItems($array, &$counter){
        if($array){
            $currentItemId = null;
            foreach ($array as $key => $keyValue){
                if($key == 'id')
                    $currentItemId = $keyValue;
                if($key == 'type' && $keyValue == 20){ // if value
                    $conclusion = $this->getConclusion($currentItemId);
                    $value = $this->getAttributeByValue($currentItemId);
                    if(empty($conclusion) && empty($value)) 
                        $counter++;
                }
                if($key == 'type' && $keyValue == 10){ // if attribute
                    $values = $this->getValues($currentItemId);
                    if(empty($values))
                        $counter++;
                }
                if (is_array($keyValue)){
                    $this->traverseArrayAndValidateItems($keyValue, $counter);
                }
            }
        } else {
            $counter = 100;
        }  
    }

    public function validateNoUsersAssignedToProject($project_id){
        $noUsers = true;
        $userList = $this->getUsersAssignedForProject($project_id);
        if(!empty($userList->toArray()))
            $noUsers = false;

        return $noUsers;  
    }

    private function validateUserAssignedOrOwner($project, $user){
        //setup
        $canUserExecute = true;

        $userProjectLink = UserProjectLink::where('user_id', $user->id)
        ->where('es_project_id', $project->id)
        ->first();

        if($project->user_created_id != $user->id){
            if(empty($userProjectLink))
                $canUserExecute = false;
        }

        return $canUserExecute;
    }
    //endCustomvalidators

    //TEST PRINT FUNCTION
    function traverseArrayTest($array, $counter, $idenString){
            $receivedCounter = 0;
            $receivedCounter = $counter;
            for($i=0; $i<=$receivedCounter; $i++){
                $idenString = $idenString." - ";
            }

            foreach ($array as $key => $value)
            {
                if (is_array($value))
                {
                    $this->traverseArrayTest($value, $receivedCounter, $idenString);
                }
                else
                {
                    echo $idenString;
                    echo "KEY: ". $key . "  VAL: " . $value . "<br />\n";
                }
            }
        }
}
