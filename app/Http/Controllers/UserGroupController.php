<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use App\Http\Requests\StoreUserGroupRequest;
use App\Http\Requests\UpdateUserGroupRequest;
use Illuminate\Http\Request;
//added
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        //setup
        $newGroup = new UserGroup();
        $newGroup->name = $request->name;
        $newGroup->description = $request->description;
        $newGroup->group_join_code = $request->groupJoinCode;
        $newGroup->user_created_id = Auth::user()->id;

        //action
        $newGroup->save();
        return redirect()->route('ugroups.list');
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
    public function update(Request $request, $user_group_id)
    {
        //setup
        $userGroupToUpdate = UserGroup::find($user_group_id);

        $nameToUpate = $request->name;
        $descriptionToUpate = $request->description;
        $groupJoinCodeToUpdate = $request->groupJoinCode;

        //action
        $userGroupToUpdate->update(['name' => $nameToUpate, 'description' => $descriptionToUpate, 'group_join_code' => $groupJoinCodeToUpdate]);

        return redirect()->route('ugroups.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_group_id)
    {
        //setup
        $userGroupToDestroy = UserGroup::find($user_group_id);

        //action
        $userGroupToDestroy->delete();
        return redirect()->route('ugroups.list');
    }
}
