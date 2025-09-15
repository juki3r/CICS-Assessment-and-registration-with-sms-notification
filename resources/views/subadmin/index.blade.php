<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('subadmin.login') }}">
        @csrf

        <!-- Full name -->
        <div>
            <h1 class="fs-3 text-center mb-3">Faculty Login</h1>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" 
                          class="block mt-1 w-full form-control" 
                          style="text-transform: capitalize;"  
                          type="text" 
                          name="name" 
                          required 
                          autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- Submit Button -->
        <button class="btn btn-dark w-100 mt-4">Proceed</button>
    </form>
</x-guest-layout>
