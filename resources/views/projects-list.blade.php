<x-app-layout>
    <!-- FILTERS -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-project-list-filters :filterType='$filterType' :filterValue='$filterValue'></x-project-list-filters>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="p-6 text-gray-900 mb-4 col-sm-3">
                        {{ __("Projects") }}
                    </div>
                    <div class="p-6 text-gray-900 mb-4 col-sm-3">
                        <a class="btn btn-success" href="{{ route('project.create', ['project_id'=>null]) }}">{{ __('Create new project') }}</a>
                    </div>
                </div>
                <table class="table align-middle mb-0 bg-white">
                  <thead class="bg-light">
                    <tr>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Created By</th>
                      <th>Date Created</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($projects as $project)
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
                            <p class="fw-bold mb-1">{{ $project->name }}
                              @if($project->is_published == 1)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle pull-right" viewBox="0 0 16 16">
                                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                            </svg>
                              @endif
                            </p>
                            <p class="text-muted mb-0">{{__("Expert system project")}}</p>
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
                        <a class="btn btn-link btn-sm btn-rounded" href="{{ route('project.create', ['project_id'=>$project->id]) }}">
                        {{ __('Edit') }}
                        </a>
                        <form method="post" action="{{ route('project.delete', ['project_id'=>$project->id]) }}">
                        @csrf
                        <input type="submit" value="{{ __('Delete') }}" class="btn btn-link btn-sm btn-rounded">
                        </form>
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
