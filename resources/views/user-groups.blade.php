<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="p-6 text-gray-900 mb-4 col-sm-3">
                        {{ __("Groups") }}
                    </div>
                    <div class="p-6 text-gray-900 mb-4 col-sm-3">
                        <a class="btn btn-success" href="{{ route('ugroups.create') }}">{{ __('CreateNewGroup') }}</a>
                    </div>
                    <div class="p-6 text-gray-900 mb-4 col-sm-3">
                        <a class="btn btn-info" href="{{ route('ugroups.joinGroupView') }}">{{ __('JoinExistingGroup') }}</a>
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
                      <th>Name</th>
                      <th>Description</th>
                      <th>Owner</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($userGroups as $userGroup)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="ms-3">
                            <p class="fw-bold mb-1">{{ $userGroup->name }}</p>
                            <p class="text-muted mb-0">{{__("User group")}}</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="fw-normal mb-1">{{ $userGroup->description }}</p>
                      </td>
                      <td>
                        <p class="fw-normal mb-1">{{ $userGroup->userName }}</p>
                      </td>
                      <td>
                        <form method="get" action="{{ route('ugroups.edit', ['user_group_id'=>$userGroup->id]) }}">
                          <input type="submit" value="{{ __('Edit') }}" class="btn btn-link btn-sm btn-rounded">
                        </form>
                        <form method="post" action="{{ route('ugroups.delete', ['user_group_id'=>$userGroup->id]) }}">
                        @csrf
                          <input type="submit" value="{{ __('Delete') }}" class="btn btn-link btn-sm btn-rounded">
                        </form>
                        <form method="get" action="{{ route('ugroups.userList', ['user_group_id'=>$userGroup->id]) }}">
                          <input type="submit" value="{{ __('GroupUsersList') }}" class="btn btn-link btn-sm btn-rounded">
                        </form>
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
