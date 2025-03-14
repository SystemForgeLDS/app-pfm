<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="img/logo.jpeg" alt="logo" width="90px" style="border-radius: 50%">
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Nome') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            
            <div class="mt-4">
                <x-label for="value_hour" value="{{ __('Valor por hora') }}" />
                <x-input id="value_hour" class="block mt-1 w-full" name="value_hour" :value="old('value_hour')" required autocomplete="username" />
            </div>
            
            <div class="mt-4">
                <x-label for="type" value="{{ __('Tipo') }}" />
                <select id="type" name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" :value="old('type')" required autocomplete="username" style="border-radius: 5px; border-color:#D1D5DB; box-shadow: 2x solid black">
                    <option value="0">Sócio</option>
                    <option value="1">Consultor</option>
                    <option value="2">Financeiro</option>
                    <option value="3">Estagiário</option>
                </select>
            </div>
            
            <div class="mt-4">
                <x-label for="password" value="{{ __('Senha') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar senha') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">

                <x-button class="ms-4">
                    {{ __('Registrar') }}
                </x-button>

            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
