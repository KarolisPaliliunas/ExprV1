<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="row">
          <div class="p-6 text-gray-900 mb-4 col-sm-3">
            {{ __("messages.groupsLabel") }}
          </div>
          <div class="p-6 text-gray-900 mb-4 col-sm-3">
            <a class="btn btn-success" href="{{ route('ugroups.create') }}">{{ __("messages.createGroupButtonLabel") }}</a>
          </div>
          <div class="p-6 text-gray-900 mb-4 col-sm-3">
            <a class="btn btn-info" href="{{ route('ugroups.joinGroupView') }}">{{ __("messages.joinGroupButtonLabel") }}</a>
          </div>
        </div>

        <!-- ERRORS -->
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
          <p>{{ $error }}</p>
        </div>
        @endforeach
        @endif
        <!-- END OF ERRORS -->
        <!-- MESSAGES -->
        @if ($message = Session::get('groupCreateSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('groupUpdateSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('groupDeleteSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('groupJoinSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('projectUnpublishSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @endif
        <!-- END OF MESSAGES -->

        <table class="table align-middle mb-0 bg-white">
          <thead class="bg-light">
            <tr>
              <th>{{ __("messages.groupNameLabel") }}</th>
              <th>{{ __("messages.groupDescriptionLabel") }}</th>
              <th>{{ __("messages.groupOwnerLabel") }}</th>
              <th>{{ __("messages.groupActionsLabel") }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($userGroups as $userGroup)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="ms-3">
                    <p class="fw-bold mb-1">{{ $userGroup->name }}</p>
                    <p class="text-muted mb-0">{{__("messages.userGroupLabel")}}</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="fw-normal mb-1">{{ $userGroup->description }}</p>
              </td>
              <td>
                <p class="fw-normal mb-1">{{ $userGroup->ownerName }}</p>
              </td>
              <td>
                <div class="d-flex flex-row bd-highlight mb-3">
                @if ($userGroup->ownerID == $currentUser->id || $currentUser->user_type > 0)
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('ugroups.edit', ['user_group_id'=>$userGroup->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-pencil" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="post" action="{{ route('ugroups.delete', ['user_group_id'=>$userGroup->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-trash" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('ugroups.userList', ['user_group_id'=>$userGroup->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-person-x" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                @endif
                  <div class="p-2 bd-highlight">
                    <form method="get" action="#">
                      @csrf
                      <button type="submit"><i class="bi bi-person-dash-fill" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $userGroups->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</x-app-layout>