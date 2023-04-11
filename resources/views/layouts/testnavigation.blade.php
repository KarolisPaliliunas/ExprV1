<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('dashboard') }}">{{ __("Dashboard") }}</a>    
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('project.list') }}">{{ __("Projects") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('ugroups.list') }}">{{ __("Groups") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">{{ __("Profile") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">{{ __("Settings") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">{{ __("Integration") }}</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <input type="submit" value="{{ __('Logout') }}" class="nav-link"></input>
      </form>
      </ul>
  </div>
</nav>