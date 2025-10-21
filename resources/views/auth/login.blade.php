<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('student.login') }}">
        @csrf

        <!-- Full name -->
        <div>
            <h1 class="fs-3 text-center mb-3">Student</h1>
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

        <!-- Course Dropdown -->
        <div class="mt-3">
            <x-input-label for="course" :value="__('Course')" />
            <select id="course" name="course" class="form-select block mt-1 w-full" required>
                <option value="">-- Select Course --</option>
                <option value="bsit" {{ old('course') == 'bsit' ? 'selected' : '' }}>BSIT</option>
                <option value="bscs" {{ old('course') == 'bscs' ? 'selected' : '' }}>BSCS</option>
                <option value="blis" {{ old('course') == 'blis' ? 'selected' : '' }}>BLIS</option>
            </select>
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button class="btn btn-dark w-100 my-3">Proceed</button>
    </form>
</x-guest-layout>
