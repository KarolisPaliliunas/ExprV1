<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('dashboard') }}">{{ __("messages.dashboardMenuItemLabel") }}</a>    
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('project.list') }}">{{ __("messages.projectsMenuItemLabel") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('ugroups.list') }}">{{ __("messages.groupsMenuItemLabel") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('settings.show') }}">{{ __("messages.settingsMenuItemLabel") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('profile.edit') }}">{{ __("messages.profileMenuItemLabel") }}</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <input type="submit" value="{{ __('messages.logoutButtonLabel') }}" class="nav-link"></input>
      </form>
      </ul>
  </div>
</nav>