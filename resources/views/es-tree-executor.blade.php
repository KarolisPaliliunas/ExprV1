<x-wrapper-layout>
    <!--  Exit button -->
    <div style="margin-left:90%;">
        <form method="get" action="{{ route('project.list') }}">
        @csrf
            <button type="submit" class="btn btn-outline-danger form-control mb-1 w-auto">{{ __('BackToList') }}</button>
        </form>
    </div>
    <!-- Main body -->
    <div class="p-2 bg-primary text-white w-auto">{{ __("CurrentlyExecuting: ") }} {{ $project->name }}</div>
    @empty($conclusion)

    <div class="p-2 bg-dark text-white w-25">{{ $attribute['description'] }}</div>
        
        <div class="d-grid gap-2 mt-5 ml-3">
        @foreach ($values as $value)
            <form method="get" action ="{{ route('project.execute', ['project_id' => $project->id, 'currentAttributeId' => $attribute['id'], 'pickedValueId' => $value['id']]) }}">
            @csrf
                <button class="btn btn-primary btn-lg" type="submit">{{ $value['description'] }}</button>
            </form>
        @endforeach
        </div>
    @endempty

    @isset($conclusion)

    <div class="p-2 bg-warning mt-3 mx-auto text-dark w-50 h-10 d-flex justify-content-center">{{ __("YouHaveReachedAConclusion: ") }} {{ $conclusion['description'] }}</div>
    <div class="mt-3" style="margin-left:50%;margin-right:50%;">
        <form method="get" action ="{{ route('project.executeNoData', ['project_id' => $project->id]) }}">
            @csrf
            <button class="btn btn-outline-success form-control w-auto" type="submit">{{__("TryAgain")}}</button>
        </form>
    </div>
    @endisset
</x-wrapper-layout>