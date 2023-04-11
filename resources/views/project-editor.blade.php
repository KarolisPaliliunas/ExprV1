<x-wrapper-layout>
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
  <div class="py-12">
    <!-- HEADER -->
      @isset ($project->id)
      <form method="post" action="{{ route('project.update', ['project_id'=>$project->id]) }}">
      @csrf
        <div class="row">
          <div class="col">
            <input type="text" class="form-control" value="{{ $project->name }}" name="name">
          </div>
          <div class="col">
            <input type="text" class="form-control" value="{{ $project->description }}" name="description">
          </div>
          <div class="col">
            <button type="submit" class="btn btn-outline-success form-control">{{ __('Save Changes') }}</button>
          </div>
          <div class="col">
            <button type="submit" class="btn btn-outline-danger form-control">{{ __('Cancel') }}</button>
          </div>
        </div>
      </form>  
      @endisset
      @empty ($project->id)
      <form method="post" action="{{ route('project.new') }}">
      @csrf
        <div class="row">
          <div class="col">
            <input type="text" class="form-control" placeholder="{{ __('Project name') }}" name="name">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="{{ __('Project description') }}" name="description">
          </div>
          <div class="col">
            <button type="submit" class="btn btn-outline-success form-control">{{ __('Create') }}</button>
          </div>
          <div class="col">
            <button type="submit" class="btn btn-outline-danger form-control">{{ __('Cancel') }}</button>
          </div>
        </div>
      </form>
      @endempty
      <!-- MAIN BODY -->
      @isset ($project->id)
        @isset ($projectData)
          <div class="border border-secondary overflow-auto" style="height:600px; width:100%; margin-top:20px">
            <div class="tree">
              @include('recursive', ['projectData' => $projectData, 'project_id' => $project->id])
            </div>
          </div>
        @endisset
        @empty ($projectData)
          <div class="border border-secondary overflow-auto" style="height:600px; width:100%; margin-top:20px">
            <form method="post" action="{{ route('attribute.new', ['item_id'=>$project->id, 'project_id'=>$project->id, 'createForProject'=>true]) }}">
            @csrf
              <div>
                <div class="row">
                  <label for="name1" class="form-label">{{ __('Your system is empty! Lets create a header attribute') }}</label>
                </div>
                <div class="row">
                  <input type="text" placeholder="{{ __('Main attribute name') }}" name="name">
                  <input type="text" placeholder="{{ __('Main attribute description') }}" name="description">
                </div>
                <div class="row">
                  <button type="submit" class="btn btn-outline-success form-control">{{ __('Create') }}</button>
                </div>
              </div>
            </form>
          </div>
        @endempty
      @endisset
</x-wrapper-layout>