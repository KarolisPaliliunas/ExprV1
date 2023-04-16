<x-wrapper-layout>
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
  <div class="py-12">
    <!-- HEADER -->
      @isset ($projectToEdit)
      <form method="post" action="{{ route('project.update', ['project_id'=>$projectToEdit->id]) }}">
      @csrf
          <div class="form-outline mb-4">
            <input type="text" class="form-control" value="{{ $projectToEdit->name }}" name="name" id="nameInput">
            <label class="form-label" for="nameInput">{{__("Project name")}}</label>
          </div>
          <div class="form-outline mb-4">
            <input type="text" class="form-control" value="{{ $projectToEdit->description }}" name="description" id="descriptionInput">
            <label class="form-label" for="descriptionInput">{{__("Project description")}}</label>
          </div>
          <button type="submit" class="btn btn-outline-success form-control">{{ __('SaveChanges') }}</button>
          <button type="submit" class="btn btn-outline-danger form-control">{{ __('Cancel') }}</button>
      </form>
      @endisset
      @empty ($projectToEdit)
      <form method="post" action="{{ route('project.new') }}">
      @csrf
      <div class="form-outline mb-4">
            <input type="text" class="form-control" name="name" id="nameInput">
            <label class="form-label" for="nameInput">{{__("Project name")}}</label>
          </div>
          <div class="form-outline mb-4">
            <input type="text" class="form-control" name="description" id="descriptionInput">
            <label class="form-label" for="descriptionInput">{{__("Project description")}}</label>
          </div>
          <button type="submit" class="btn btn-outline-success form-control">{{ __('Create') }}</button>
          <button type="submit" class="btn btn-outline-danger form-control">{{ __('Cancel') }}</button>
      </form>
      @endempty
</x-wrapper-layout>