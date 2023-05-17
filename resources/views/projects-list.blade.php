<x-app-layout>
  <!-- FILTERS -->
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <x-project-list-filters :filterTypeValue='$filterTypeValue' :filterSearchValue='$filterSearchValue'></x-project-list-filters>
  </div>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="row">
          <div class="p-6 text-gray-900 mb-4 col-sm-3">
            {{ __("messages.projectsLabel") }}
          </div>
          <div class="p-6 text-gray-900 mb-4 col-sm-3">
            <a class="btn btn-success" href="{{ route('project.create', ['filterType'=>$filterTypeValue, 'filterValue'=>$filterSearchValue]) }}">{{ __('messages.createProjectButtonLabel') }}</a>
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
        @if ($message = Session::get('projectCreateSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('projectDeleteSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('projectUpdateSuccess'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('projectPublishSuccess'))
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
              <th>{{ __('messages.projectNameLabel') }}</th>
              <th>{{ __('messages.projectDescriptionLabel') }}</th>
              <th>{{ __('messages.projectCreatedByLabel') }}</th>
              <th>{{ __('messages.projectCreatedDateLabel') }}</th>
              <th>{{ __('messages.projectActionsLabel') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($projects as $project)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img src="{{asset('assets/images/default-project-picture.jpg')}}" alt="project-image" style="width: 45px; height: 45px" class="rounded-circle" />
                  <div class="ms-3">
                    <p class="fw-bold mb-1">{{ $project->name }}
                      @if($project->is_published == 1)
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle pull-right" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z" />
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                      </svg>
                      @endif
                    </p>
                    <p class="text-muted mb-0">{{__("messages.expertSystemProjectLabel")}}</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="fw-normal mb-1">{{ $project->description }}</p>
              </td>
              <td>
                <p class="fw-normal mb-1">{{ $project->userName }}</p>
              </td>
              <td>
                <p class="fw-normal mb-1">{{ $project->created_at->format('Y-m-d') }}</p>
              </td>
              <td>
                <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('project.edit', ['project_id'=>$project->id, 'filterType'=>$filterTypeValue, 'filterValue'=>$filterSearchValue]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-pencil" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="post" action="{{ route('project.delete', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-trash" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  @if($project->is_published == 1)
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('project.executeNoData', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-skip-start-circle" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="post" action="{{ route('project.unpublish', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-file-x" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('project.assignUsers', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-person-add" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('project.assignGroups', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-patch-plus" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('project.unassignUsers', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-person-x" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                    @else
                  <div class="p-2 bd-highlight">
                    <form method="get" action="{{ route('project.generateTreeEditor', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-signpost-split" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <form method="post" action="{{ route('project.publish', ['project_id'=>$project->id]) }}">
                      @csrf
                      <button type="submit"><i class="bi bi-file-plus" style="font-size: 30px;"></i></button>
                    </form>
                  </div>
                  @endif
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $projects->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</x-app-layout>