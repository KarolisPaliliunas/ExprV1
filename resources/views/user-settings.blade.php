<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.settingsLabel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('messages.generalSettingslabel') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("messages.generalSettingsInfolabel") }}
                            </p>
                        </header>
                        <form method="post" action="{{ route('settings.update', ['userSetup' => $userSetup]) }}" class="mt-6 space-y-6">
                            @csrf
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <div class="d-flex flex-column bd-highlight mb-3">
                                    <div class="p-2 bd-highlight">
                                        <label for="nav_color">{{ __('messages.navigationColorSettingLabel') }}</label>
                                        <select class="form-select" name="nav_color">
                                        @foreach(\App\Enums\NavColorEnum::cases() as $navColor)
                                            @if ($userSetup->nav_color == $navColor->value)
                                            <option selected value="{{$navColor->value}}">{{ __('messages.'.$navColor->name) }}</option>
                                            @else
                                            <option value="{{$navColor->value}}">{{ __('messages.'.$navColor->name) }}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <label for="nav_font">{{ __('messages.navigationFontSettingLabel') }}</label>

                                        <select class="form-select" name="nav_font">
                                        @foreach(\App\Enums\NavFontEnum::cases() as $navFont)
                                            @if ($userSetup->nav_font == $navFont->value)
                                            <option selected value="{{$navFont->value}}">{{ __('messages.'.$navFont->name) }}</option>
                                            @else
                                            <option value="{{$navFont->value}}">{{ __('messages.'.$navFont->name) }}</option>
                                            @endif
                                        @endforeach
                                        </select>

                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <label for="lang_code">{{ __('messages.langSettingLabel') }}</label>
                                        <select class="form-select" name="lang_code">
                                            @foreach(\App\Enums\LanguageEnum::cases() as $lang)
                                                @if ($userSetup->lang_code == $lang->value)
                                                <option selected value="{{$lang->value}}">{{ __('messages.'.$lang->name) }}</option>
                                                @else
                                                <option value="{{$lang->value}}">{{ __('messages.'.$lang->name) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <x-primary-button>{{ __('messages.saveButtonLabel') }}</x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form>
                            @csrf
                            <button type="submit" class="btn btn-outline-primary mt-4">{{ __('messages.settingsUserListButtonlabel') }}</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>