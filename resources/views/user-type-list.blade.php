<x-wrapper-layout>
    <!--  Exit button -->
    <div style="margin-left:90%;">
        <form method="get" action="{{ route('settings.show') }}">
            @csrf
            <button type="submit" class="f-n-hover btn btn-outline-danger btn-raised px-4 py-25 w-75 text-600">{{ __('messages.backToListButtonLabel') }}</button>
        </form>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-12">
            @isset ($userList)
            <table class="table mb-4">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.groupUserListNameLabel')}}</th>
                        <th scope="col">{{__('messages.groupUserListRoleLabel')}}</th>
                        <th scope="col">{{__('messages.groupUserListActionsLabel')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userList as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        @if ($user->user_type == 100)
                        <td>{{ __('messages.userSuperAdminLabel') }}</td>
                        <td>
                            <form method="get" action="{{ route('settings.userStatistics', ['user' => $user->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-success ms-1">{{ __('messages.userStatisticsButtonLabel') }}</button>
                            </form>
                        </td>
                        @elseif ($user->user_type == 1)
                        <td>{{ __('messages.userAdminLabel') }}</td>
                        <td>
                            <form method="post" action="{{ route('settings.changeUserType', ['user' => $user, 'userType' => 0]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-info ms-1">{{ __('messages.makeUserSimpleLabel') }}</button>
                            </form>
                            <form method="get" action="{{ route('settings.userStatistics', ['user' => $user->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-success ms-1 mt-2">{{ __('messages.userStatisticsButtonLabel') }}</button>
                            </form>
                        </td>
                        @else
                        <td>{{ __('messages.userSimpleLabel') }}</td>
                        <td>
                            <form method="post" action="{{ route('settings.changeUserType', ['user' => $user, 'userType' => 1]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-info ms-1">{{ __('messages.makeUserAdminLabel') }}</button>
                            </form>
                            <form method="get" action="{{ route('settings.userStatistics', ['user' => $user->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-success ms-1 mt-2">{{ __('messages.userStatisticsButtonLabel') }}</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endisset
        </div>
    </div>
</x-wrapper-layout>