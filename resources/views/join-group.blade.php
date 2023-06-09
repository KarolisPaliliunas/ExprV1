<x-wrapper-layout>
    <!--  Exit button -->
    <div style="margin-left:90%;">
        <form method="get" action="{{ route('ugroups.list') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger form-control mb-1 w-auto">{{ __('messages.backToListButtonLabel') }}</button>
        </form>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-12">


            <!-- ERRORS -->
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                  <div class="alert alert-danger">
                    <p>{{ $error }}</p>
                  </div>
                @endforeach
            @endif
            <!-- END OF ERRORS -->

            <form method="post" action="{{ route('ugroups.joinGroup') }}">

                @csrf
                <!-- Code input -->
                <label class="form-label" for="joinCodeInput">{{__("messages.enterValidGroupCodeLabel")}}</label>
                <div class="form-outline mb-4 input-group">
                    <input type="text" name="joinCode" id="joinCodeInput" class="form-control w-60" />
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-outline-success form-control w-auto">{{__("messages.joinGroupButtonLabel")}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-wrapper-layout>