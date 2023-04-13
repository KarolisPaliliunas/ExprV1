<x-wrapper-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-12">
            @isset ($userGroupToEdit)
            <form method="post" action="{{ route('ugroups.update', ['user_group_id' => $userGroupToEdit->id]) }}">
            @endisset
            @empty ($userGroupToEdit)
            <form method="post" action="{{ route('ugroups.new') }}">
            @endempty

                @csrf
                <!-- Name input -->
                <div class="form-outline mb-4">
                    @isset ($userGroupToEdit)
                    <input type="text" name="name" id="nameInput" class="form-control" value="{{ $userGroupToEdit->name }}" />
                    @endisset
                    @empty ($userGroupToEdit)
                    <input type="text" name="name" id="nameInput" class="form-control" />
                    @endempty
                    <label class="form-label" for="nameInput">{{__("Group name")}}</label>
                </div>

                <!-- Description input -->
                <div class="form-outline mb-4">
                    @isset ($userGroupToEdit)
                    <input type="text" name="description" id="descriptionInput" class="form-control" value="{{ $userGroupToEdit->description }}" />
                    @endisset
                    @empty ($userGroupToEdit)
                    <input type="text" name="description" id="descriptionInput" class="form-control" />
                    @endempty
                    <label class="form-label" for="descriptionInput">{{__("Group description")}}</label>
                </div>

                <!-- Join code input -->
                <div class="form-outline mb-4">
                    @isset ($userGroupToEdit)
                    <input type="text" name="groupJoinCode" id="joinCodeInput" class="form-control" value="{{ $userGroupToEdit->group_join_code }}" />
                    @endisset
                    @empty ($userGroupToEdit)
                    <input type="text" name="joinCode" id="joinCodeInput" class="form-control" />
                    @endempty
                    <label class="form-label" for="joinCodeInput">{{__("Join code")}}</label>
                </div>

                <!-- Reneration Button -->
                <div class="form-check d-flex justify-content-center mb-4">
                    <input type="button" value="Random!" onclick="generateGroupCode();" />
                </div>

                <!-- Submit button -->
                @isset ($userGroupToEdit)
                <button type="submit" class="btn btn-outline-success form-control">{{__("Edit group")}}</button>
                @endisset
                @empty ($userGroupToEdit)
                <button type="submit" class="btn btn-outline-success form-control">{{__("Create new group")}}</button>
                @endempty
            </form>
        </div>
    </div>
</x-wrapper-layout>