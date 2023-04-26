<x-wrapper-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-12">

            <!-- ERRORS -->
            @if ($errors->any())
              @foreach ($errors->all() as $error)
              <div class="alert alert-danger">
                <p>{{ $error }}</p>
              </div>
              @endforeach
            @endif
            <!-- END OF ERRORS -->

            @isset ($userGroupToEdit)
            <form method="post" action="{{ route('ugroups.update', ['user_group_id' => $userGroupToEdit->id]) }}">

                @csrf
                <!-- Name input -->
                <div class="form-outline mb-4">
                    <input type="text" name="name" id="nameInput" class="form-control" value="{{ $userGroupToEdit->name }}" />
                    <label class="form-label" for="nameInput">{{__("Group name")}}</label>
                </div>

                <!-- Description input -->
                <div class="form-outline mb-4">
                    <input type="text" name="description" id="descriptionInput" class="form-control" value="{{ $userGroupToEdit->description }}" />
                    <label class="form-label" for="descriptionInput">{{__("Group description")}}</label>
                </div>

                <!-- Join code input -->
                <div class="form-outline mb-4">
                    <input type="text" name="group_join_code" id="joinCodeInput" class="form-control" value="{{ $userGroupToEdit->group_join_code }}" />
                    <label class="form-label" for="joinCodeInput">{{__("Join code")}}</label>
                </div>

                <!-- Reneration Button -->
                <div class="form-check d-flex justify-content-center mb-4">
                    <input type="button" value="Random!" onclick="generateGroupCode();" />
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-outline-success form-control">{{__("Edit group")}}</button>
            </form>
            @endisset
            @empty ($userGroupToEdit)
            <form method="post" action="{{ route('ugroups.new') }}">

                @csrf
                <!-- Name input -->
                <div class="form-outline mb-4">
                    <input type="text" name="name" id="nameInput" class="form-control" />
                    <label class="form-label" for="nameInput">{{__("Group name")}}</label>
                </div>

                <!-- Description input -->
                <div class="form-outline mb-4">
                    <input type="text" name="description" id="descriptionInput" class="form-control" />
                    <label class="form-label" for="descriptionInput">{{__("Group description")}}</label>
                </div>

                <!-- Join code input -->
                <div class="form-outline mb-4">
                    <input type="text" name="group_join_code" id="joinCodeInput" class="form-control" />
                    <label class="form-label" for="joinCodeInput">{{__("Join code")}}</label>
                </div>

                <!-- Reneration Button -->
                <div class="form-check d-flex justify-content-center mb-4">
                    <input type="button" value="Random!" onclick="generateGroupCode();" />
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-outline-success form-control">{{__("Create new group")}}</button>
            </form>
            @endempty
            <form method="get" action="{{ route('ugroups.list') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger form-control mt-3">{{ __('Cancel') }}</button>
            </form>
        </div>
    </div>
</x-wrapper-layout>