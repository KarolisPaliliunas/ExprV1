<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use App\Http\Requests\StoreUserGroupRequest;
use App\Http\Requests\UpdateUserGroupRequest;
use Illuminate\Http\Request;
//added
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProjectLink;
use App\Models\UserGroupLink;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\ValidationException;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Redirect to show
        $this->show();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user-group-editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //validate
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required',
            'groupJoinCode' => 'required|min:3|max:50|unique'   
        ]);

        //setup
        $currentUserID = Auth::user()->id;

        $newGroup = new UserGroup();
        $newGroup->name = $request->name;
        $newGroup->description = $request->description;
        $newGroup->group_join_code = $request->groupJoinCode;
        $newGroup->user_created_id = Auth::user()->id;

        $newUserGroupLink = new UserGroupLink();
        $newUserGroupLink->user_id = $currentUserID;
        $newUserGroupLink->user_group_id = $newGroup->id;

        //action
        $newUserGroupLink->save();
        $newGroup->save();
        return redirect()->route('ugroups.list')->with('groupCreateSuccess', __('GroupCreateSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $currentUserID = Auth::user()->id;

        $userGroups = UserGroup::where('user_created_id', '=', $currentUserID)
            ->where('user_created_id', '!=', -1)
            ->join('users', 'user_groups.user_created_id', '=', 'users.id')
            ->select('user_groups.*', 'users.name AS userName')
            ->latest()->paginate(5);

        return view('user-groups', compact('userGroups'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($user_group_id)
    {
        //setup
        $userGroupToEdit = UserGroup::find($user_group_id);

        //action
        return view('user-group-editor', ['userGroupToEdit' => $userGroupToEdit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserGroupRequest  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_group_id){
        //validate
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required',
            'joinCode' => 'required|min:3|max:50|unique'    
        ]);
        
        //setup
        $userGroupToUpdate = UserGroup::find($user_group_id);

        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;
        $groupJoinCodeToUpdate = $request->groupJoinCode;

        //action
        $userGroupToUpdate->update(['name' => $nameToUpate, 'description' => $descriptionToUpate, 'group_join_code' => $groupJoinCodeToUpdate]);

        return redirect()->route('ugroups.list')->with('groupUpdateSuccess', __('GroupUpdateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_group_id){
        //validate
        $noUsers = $this->validateNoUsersinGroup($user_group_id);
        if ($noUsers == false)
            throw ValidationException::withMessages(['NoFieldName' => __('GroupHasUsers')]);

        //setup
        $userGroupToDestroy = UserGroup::find($user_group_id);
        $userGroupLinkToDestroy = UserGroupLink::select()
        ->where('user_group_id', $user_group_id)
        ->first();

        //action
        $userGroupToDestroy->delete();
        $userGroupLinkToDestroy->delete();
        return redirect()->route('ugroups.list');
    }

    public function userList($user_group_id)
    {
        //setup
        $userGroup = UserGroup::find($user_group_id);
        $ownerId = $userGroup->user_created_id;
        $userList = $this->getUsersByGroup($user_group_id);


        //action
        return view('user-group-user-list', ['userGroup' => $userGroup, 'userList' => $userList, 'ownerId' => $ownerId])->with('groupDeleteSuccess', __('GroupDeleteSuccess'));
    }

    public function joinGroupView(){

        return view('join-group');
    }

    public function joinGroup(Request $request){
        //$validate
        $request->validate([
            'joinCode' => 'required'    
        ]);
        
        //setup
        $userGroup = null;
        $joinCode = $request->joinCode;

        $userGroup = UserGroup::select()
        ->where('group_join_code', '=', $joinCode)
        ->first();

        $currentUserID = Auth::user()->id;

        //action
        if(!empty($userGroup)){
            $newLink = new UserGroupLink(); 
            $newLink->user_group_id = $userGroup->id;
            $newLink->user_id = $currentUserID;
            $newLink->save();
            
            return redirect()->route('ugroups.list')->with('groupJoinSuccess', __('GroupJoinSuccess'));
        }
        else{
            throw ValidationException::withMessages(['NoFieldName' => __('GroupJoinFail')]);
        }
    }

    public function removeUserFromGroup($user_group_id, $user_id){
        //setup

        $userGroupLink = UserGroupLink::select()->
        where('user_id', $user_id)->
        where('user_group_id', $user_group_id)
        ->first();

        //action
        $userGroupLink->delete();
        return redirect()->route('ugroups.userList', ['user_group_id' => $user_group_id]);
    }

    //Additional funcs
    private function getUsersByGroup($user_group_id){
        
        $users = User::select('*')->whereExists(function ($query) use($user_group_id) {
            $query->select('user_id')
                  ->from('user_group_links')
                  ->whereRaw('user_group_links.user_id = users.id')
                  ->whereRaw('user_group_links.user_group_id = '.$user_group_id);
        })
        ->get();

        //dd($users);
        if(empty($users)) $users = null;

        return $users;
    }

    public function numberOfUsersInGroup($user_group_id){
        $numberofUsers = User::select()->
            whereExists(function ($query) use($user_group_id) {
                $query->select('user_id')
                      ->from('user_group_links')
                      ->whereRaw('user_group_links.user_id = users.id')
                      ->whereRaw('user_group_links.user_group_id = '.$user_group_id);
            })->count();
        
        return $numberofUsers;
    }

    //customValidators
    public function validateNoUsersinGroup($user_group_id){
        $noUsers = true;
        $userList = $this->getUsersByGroup($user_group_id);

        if (sizeof($userList)>1) // mainUser
            $noUsers = false;
        return $noUsers;
    }

}
