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
      @isset ($projectToEdit)
      <!-- END OF ERRORS -->

      <form method="post" action="{{ route('project.update', ['project_id'=>$projectToEdit->id]) }}">
      @csrf
          <div class="form-outline mb-4">
            <input type="text" class="form-control" value="{{ $projectToEdit->name }}" name="name" id="nameInput">
            <label class="form-label" for="nameInput">{{__("messages.projectNameLabel")}}</label>
          </div>
          <div class="form-outline mb-4">
            <input type="text" class="form-control" value="{{ $projectToEdit->description }}" name="description" id="descriptionInput">
            <label class="form-label" for="descriptionInput">{{__("messages.projectDescriptionLabel")}}</label>
          </div>
          <button type="submit" class="btn btn-outline-success form-control">{{ __('messages.saveButtonLabel') }}</button>
      </form>
      <form method="get" action="{{ route('project.list') }}">
          @csrf
          <button type="submit" class="btn btn-outline-danger form-control mt-3">{{ __('messages.cancelButtonLabel') }}</button>
      </form>
      @endisset
      @empty ($projectToEdit)
      <form method="post" action="{{ route('project.new') }}">
      @csrf
      <div class="form-outline mb-4">
            <input type="text" class="form-control" name="name" id="nameInput">
            <label class="form-label" for="nameInput">{{__("messages.projectNameLabel")}}</label>
          </div>
          <div class="form-outline mb-4">
            <input type="text" class="form-control" name="description" id="descriptionInput">
            <label class="form-label" for="descriptionInput">{{__("messages.projectDescriptionLabel")}}</label>
          </div>
          <button type="submit" class="btn btn-outline-success form-control">{{ __('messages.createButtonLabel') }}</button>
      </form>
      <form method="get" action="{{ route('project.list') }}">
          @csrf
          <button type="submit" class="btn btn-outline-danger form-control mt-3">{{ __('messages.cancelButtonLabel') }}</button>
      </form>
      @endempty
</x-wrapper-layout>