<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.dashboardMenuItemLabel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("messages.loggedInLabel") }}
                </div>
            </div>
        </div>
        <div class="list-group">
            <a href="{{ route('project.list') }}" class="list-group-item list-group-item-action h1" style="margin-left:5%">{{ __("messages.projectsMenuItemLabel") }}</a>
            <a href="{{ route('ugroups.list') }}" class="list-group-item list-group-item-action h1" style="margin-left:5%">{{ __("messages.groupsMenuItemLabel") }}</a>
            <a href="{{ route('settings.show') }}" class="list-group-item list-group-item-action h1" style="margin-left:5%">{{ __("messages.settingsMenuItemLabel") }}</a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action h1" style="margin-left:5%">{{ __("messages.profileMenuItemLabel") }}</a>
        </div>
    </div>
</x-app-layout>