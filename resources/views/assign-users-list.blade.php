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

            <form method="post" action="{{ route('project.assignSelectedUsers') }}">
            @csrf
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
                    {{ __('NowAssigningUsersFor') }} {{ $project->name }} {{ __('SelectUsersAndAssign') }}
                </h2>

                @isset($userList)
                <div class="list-group">
                    @foreach($userList as $user)
                    <label class="list-group-item border border-dark mb-2">
                        {{ $user->name }}
                        <input class="form-check-input me-1" type="checkbox" name="selectedUsersIdsList[]" value="{{ $user->id }}">
                    </label>
                    @endforeach
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                </div>
                <button type="submit" class="btn btn-outline-success form-control w-auto">{{__("AssignForSelected")}}</button>
                @endisset
                @empty($userList)
                <div class="alert alert-danger" role="alert">
                    {{ __('NoUsersToAssign') }}
                </div>
                @endempty
            </form>

        </div>
    </div>

</x-wrapper-layout>