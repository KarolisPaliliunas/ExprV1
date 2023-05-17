<x-wrapper-layout>
    <!--  Exit button -->
    <div style="margin-left:90%;">
        <form method="get" action="{{ route('ugroups.list') }}">
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
                        @if ($user->id == $ownerId)
                        <td>{{ __('messages.groupUserListOwnerLabel') }}</td>
                        <td>
                        </td>
                        @else
                        <td>{{ __('messages.groupUserListMemberLabel') }}</td>
                        <td>
                            <form method="post" action="{{ route('ugroups.removeUser', ['user_id' => $user->id, 'user_group_id' => $userGroup->id ]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger ms-1">{{ __('messages.groupuserListRemoveFromGroupButtonLabel') }}</button>
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