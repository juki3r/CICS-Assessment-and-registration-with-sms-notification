<x-guest-layout>
    @if (session('message'))
        <div 
            class="alert alert-info text-danger p-3 rounded mb-3" 
            style="background-color:rgba(0, 123, 255, 0.2);"
        >
            {{ session('message') }}
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="fullname" :value="__('Fullname (.e.g. Juan A. Delacruz)')" />
            <x-text-input id="fullname" class="block mt-1 w-full text-capitalize" type="text" name="fullname" :value="old('fullname')" required autofocus autocomplete="fullname" />
            <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
        </div>
        <!-- Course -->
        <div class="mt-4">
            <label for="course">Course</label>
            <select name="course" id="course" class="block mt-1 w-full form-control" required>
                <option value="">-- Select Course --</option>
                <option value="bsit">BSIT</option>
                <option value="bscs">BSCS</option>
                <option value="blis">BLIS</option>
            </select>
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
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
