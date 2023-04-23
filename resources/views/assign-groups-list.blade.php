<x-wrapper-layout>
    <!--  Exit button -->
    <div style="margin-left:90%;">
        <form method="get" action="{{ route('project.list') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger form-control mb-1 w-auto">{{ __('BackToList') }}</button>
        </form>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-12">

            <form method="post" action="{{ route('project.assignSelectedGroups') }}">
            @csrf
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
                    {{ __('NowAssigningGroupsFor') }} {{ $project->name }} {{ __('SelectGroupsAndAssign') }}
                </h2>

                @isset($groupsListData)
                <div class="list-group">
                    @foreach($groupsListData as $groupData)
                    @if($groupData['numberOfUsersAssignedToProjectInGroup'] < $groupData['numberOfUsersInGroup'])
                    <label class="list-group-item border border-dark mb-2">
                        {{ $groupData['userGroup']->name }} | {{ __('UsersAssigned') }} {{ $groupData['numberOfUsersAssignedToProjectInGroup'] }}/{{ $groupData['numberOfUsersInGroup'] }}
                        <input class="form-check-input me-1" type="checkbox" name="selectedGroupsIdsList[]" value="{{ $groupData['userGroup']->id }}">
                    </label>
                    @else
                    <label class="list-group-item border border-dark mb-2 disabled">
                        {{ $groupData['userGroup']->name }} | {{ __('GroupIsFullyAssignedOrEmpty') }} 
                        <input class="form-check-input me-1 disabled" type="checkbox" name="selectedGroupsIdsList[]" value="{{ $groupData['userGroup']->id }}">
                    </label>
                    @endif
                    @endforeach
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                </div>
                <button type="submit" class="btn btn-outline-success form-control w-auto">{{__("AssignForSelected")}}</button>
                @endisset
                @empty($groupsListData)
                <div class="alert alert-danger" role="alert">
                    {{ __('NoGroupsToAssign') }}
                </div>
                @endempty
            </form>

        </div>
    </div>

</x-wrapper-layout>