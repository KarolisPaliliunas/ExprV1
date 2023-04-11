<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="p-6 text-gray-900 mb-4 col-sm-3">
                        {{ __("Groups") }}
                    </div>
                    <div class="p-6 text-gray-900 mb-4 col-sm-3">
                        <a class="btn btn-success" href="#">{{ __('Create new group') }}</a>
                    </div>
                </div>
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
                          <img
                              src="{{asset('assets/images/default-project-picture.jpg')}}"
                              alt="project-image"
                              style="width: 45px; height: 45px"
                              class="rounded-circle"
                              />
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
                        <a class="btn btn-link btn-sm btn-rounded" href="#">
                        {{ __('Edit') }}
                        </a>
                        <form method="post" action="#">
                        @csrf
                        <input type="submit" value="{{ __('Delete') }}" class="btn btn-link btn-sm btn-rounded">
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
