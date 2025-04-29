<x-guest-layout>
    @if (session('message'))
        <div 
            class="alert alert-info text-danger p-3 rounded mb-3" 
            style="background-color:rgba(0, 123, 255, 0.2);"
        >
            {{ session('message') }}
        </div>
    @endif
    <form method="POST" action="{{ route('admin.register.save') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="fullname" :value="__('Fullname (.e.g. Juan A. Delacruz)')" />
            <x-text-input id="fullname" class="block mt-1 w-full text-capitalize" type="text" name="fullname" :value="old('fullname')" required autofocus autocomplete="fullname" />
            <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
        </div>

        <!-- Phone number -->
        <div class="mb-4">
            <x-input-label for="phone_number" :value="__('Phone number (.eg. 09xxxxxxxxxxx)')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="number" name="phone_number" :value="old('phone_number')" required autofocus autocomplete="phone_number" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
