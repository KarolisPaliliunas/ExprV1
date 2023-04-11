<h2 class="font-semibold text-xl text-gray-800 leading-tight">
{{ __('Filters') }}
</h2>

<form method="GET" action="{{ route('project.list') }}">
    <div class="row">
        <div class="form-outline mb-4 col-sm-3">
            <select class="form-select" name="filterType">
              @if ($filterType == 'projectsMy')
              <option selected value="projectsMy">{{ __('Created by me') }}</option>
              @else
              <option value="projectsMy">{{ __('Created by me') }}</option>
              @endif
              @if ($filterType == 'projectsPublished')
              <option selected value="projectsPublished">{{ __('Published') }}</option>
              @else
              <option value="projectsPublished">{{ __('Published') }}</option>
              @endif
              @if ($filterType == 'projectsForMe')
              <option selected value="projectsForMe">{{ __('Projects assigned to me') }}</option>
              @else
              <option value="projectsForMe">{{ __('Projects assigned to me') }}</option>
              @endif
              @if ($filterType == 'projectsInGroup')
              <option selected value="projectsInGroup">{{ __('Projects assigned to my groups') }}</option>
              @else
              <option value="projectsInGroup">{{ __('Projects assigned to my groups') }}</option>
              @endif
              @if ($filterType == 'projectsAll')
              <option selected value="projectsAll">{{ __('All projects') }}</option>
              @else
              <option value="projectsAll">{{ __('All projects') }}</option>
              @endif
            </select>
        </div>
    
        <div class="form-outline mb-4 col-sm-3">
        @isset ($filterValue)
            <input type="text" id="projects-filter-search" class="form-control" value="{{ $filterValue }}" name="filterValue"/>
        @endisset
        @empty ($filterValue)
            <input type="text" id="projects-filter-search" class="form-control" name="filterValue"/>
        @endempty
        </div>
        <div class="mb-4 col-sm-6">
            <input type="submit" class="btn btn-outline-primary mb-2" value="{{ __('Search') }}"></input>
        </div>
    </div>    
</form>
