@php
use App\Http\Controllers\UserSetupController;
$currentSetup = UserSetupController::getSetupForCurrentUser();
@endphp
@switch($currentSetup->nav_font)
    @case(10)
      <div>
      @break
    @case(20)
      <div style='font-family:"Times New Roman"'>
      @break
    @case(30)
      <div style='font-family:"Helvetica"'>
      @break
    @default
      <div>
@endswitch
@switch($currentSetup->nav_color)
    @case(10)
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      @break
    @case(20)
      <nav class="navbar navbar-expand-lg navbar-dark bg-success">
      @break
    @case(30)
      <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
      @break
    @case(40)
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      @break
    @default
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
@endswitch
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
</div> <!-- DIV FOR FONT SETUP-->