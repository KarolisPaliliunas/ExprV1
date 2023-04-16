<x-wrapper-layout>
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