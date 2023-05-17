<h2 class="font-semibold text-xl text-gray-800 leading-tight">
{{ __('Filters') }}
</h2>

<form method="POST" action="{{ route('project.listFiltered') }}">
    @csrf
    <div class="row">
        <div class="form-outline mb-4 col-sm-3">
            <select class="form-select" name="filterTypeValue">
            @foreach(\App\Enums\ProjectFilterEnum::cases() as $filterType)
              @if ($filterTypeValue == $filterType->value)
              <option selected value="{{$filterType->value}}">{{ __('messages.'.$filterType->name) }}</option>
              @else
              <option value="{{$filterType->value}}">{{ __('messages.'.$filterType->name) }}</option>
              @endif
            @endforeach
            </select>
        </div>
    
        <div class="form-outline mb-4 col-sm-3">
        @isset ($filterSearchValue)
            <input type="text" id="projects-filter-search" class="form-control" value="{{ $filterSearchValue }}" name="filterSearchValue"/>
        @endisset
        @empty ($filterSearchValue)
            <input type="text" id="projects-filter-search" class="form-control" name="filterSearchValue"/>
        @endempty
        </div>
        <div class="mb-4 col-sm-6">
            <input type="submit" class="btn btn-outline-primary mb-2" value="{{ __('messages.filtersSearchButton') }}"></input>
        </div>
    </div>    
</form>
