<x-wrapper-layout>
    <!--  Exit button -->
    <div style="margin-left:90%;">
        <form method="get" action="{{ route('settings.userTypeList') }}">
            @csrf
            <button type="submit" class="f-n-hover btn btn-outline-danger btn-raised px-4 py-25 w-75 text-600">{{ __('messages.backToListButtonLabel') }}</button>
        </form>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-12">
            @isset ($userStatisticsList)
            <table class="table mb-4">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.projectNameLabel')}}</th>
                        <th scope="col">{{ __('messages.finalConlusionlabel')}}</th>
                        <th scope="col">{{__('messages.isClosedLabel')}}</th>
                        <th scope="col">{{__('messages.completionPathLabel')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userStatisticsList as $userStatistic)
                    <tr>
                        <td>{{ $userStatistic->projectName }}</td>
                        <td>{{ $userStatistic->final_conclusion }}</td>
                        @if ($userStatistic->closed == 1)
                        <td>{{ __('messages.yesLabel') }}</td>
                        @else
                        <td>{{ __('messages.noLabel') }}</td>
                        @endif
                        <td>{{ $userStatistic->completion_path }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endisset
            @empty($userStatisticsList)
                <div class="alert alert-danger" role="alert">
                    {{ __('messages.noStatisticsForUser') }}
                </div>
            @endempty
        </div>
    </div>

</x-wrapper-layout>