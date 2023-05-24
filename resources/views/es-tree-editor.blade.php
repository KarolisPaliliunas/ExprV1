<x-wrapper-layout>
  <form method="get" action="{{ route('project.list') }}">
    @csrf
    <button type="submit" class="btn btn-outline-danger form-control" style="width:auto; margin-left:90%">{{ __('messages.backToListButtonLabel') }}</button>
  </form>
  <!-- ERRORS -->
  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger">
        <p>{{ $error }}</p>
      </div>
    @endforeach
  @endif
  @isset ($project->id)
  @isset ($projectTree)
  <div class="border border-secondary overflow-auto" style="height:600px; width:100%; margin-top:20px">
    <div class="tree">
      @include('recursive', ['projectTree' => $projectTree, 'project_id' => $project->id])
    </div>
  </div>
  @endisset
  @empty ($projectTree)
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="py-12">
        <form method="post" action="{{ route('attribute.new', ['item_id'=>$project->id, 'project_id'=>$project->id, 'createForProject'=>true]) }}">
          @csrf
          <div>
            <div class="row">
              <label for="name1" class="form-label">{{ __('messages.emptyProjectLabel') }}</label>
            </div>
            <div class="row">
              <input type="text" placeholder="{{ __('messages.mainAttributeNameLabel') }}" name="name">
              <input type="text" placeholder="{{ __('message.mainAttributeDescriptionLabel') }}" name="description">
            </div>
            <div class="row">
              <button type="submit" class="btn btn-outline-success form-control">{{ __('messages.createButtonLabel') }}</button>
            </div>
          </div>
        </form>
    </div>
  </div>
  @endempty
  @endisset
</x-wrapper-layout>